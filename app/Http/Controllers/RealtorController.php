<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Villa;
use App\Models\VillaImage;
use App\Models\Booking;
use App\Models\Feature;
use App\Models\Location;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class RealtorController extends Controller
{
    /**
     * Display the realtor's dashboard.
     */
    public function dashboard()
    {
        $user = Auth::user();
        
        // Get statistics
        $villasCount = Villa::where('realtor_id', $user->id)->count();
        $activeVillasCount = Villa::where('realtor_id', $user->id)->where('is_active', true)->count();
        
        $bookingsCount = Booking::whereHas('villa', function($query) use ($user) {
            $query->where('realtor_id', $user->id);
        })->count();
        
        $pendingBookingsCount = Booking::whereHas('villa', function($query) use ($user) {
            $query->where('realtor_id', $user->id);
        })->where('status', 'pending')->count();
        
        // Get recent bookings
        $recentBookings = Booking::whereHas('villa', function($query) use ($user) {
            $query->where('realtor_id', $user->id);
        })
        ->with(['villa', 'customer'])
        ->latest()
        ->limit(5)
        ->get();
        
        // Get monthly revenue data for chart
        $monthlyRevenueData = Booking::whereHas('villa', function($query) use ($user) {
            $query->where('realtor_id', $user->id);
        })
        ->where('status', '!=', 'cancelled')
        ->whereYear('created_at', date('Y'))
        ->selectRaw('MONTH(created_at) as month, SUM(total_price) as revenue')
        ->groupBy('month')
        ->orderBy('month')
        ->get()
        ->keyBy('month')
        ->map(function($item) {
            return $item->revenue;
        })
        ->toArray(); // Convert Collection to array
        
        // Fill missing months with zero
        for ($i = 1; $i <= 12; $i++) {
            if (!isset($monthlyRevenueData[$i])) {
                $monthlyRevenueData[$i] = 0;
            }
        }
        
        // Sort by month
        ksort($monthlyRevenueData);
        
        return view('realtor.dashboard', compact(
            'villasCount',
            'activeVillasCount',
            'bookingsCount',
            'pendingBookingsCount',
            'recentBookings',
            'monthlyRevenueData'
        ));
    }

    /**
     * Display a listing of the realtor's villas.
     */
    public function villas(Request $request)
    {
        $query = Villa::where('realtor_id', Auth::id())
            ->with('location', 'primaryImage');

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        // Sorting
        $sort = $request->get('sort', 'id_asc');
        switch ($sort) {
            case 'id_asc':
                $query->orderBy('id', 'asc');
                break;
            case 'id_desc':
                $query->orderBy('id', 'desc');
                break;
            case 'price_asc':
                $query->orderBy('price_per_night', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price_per_night', 'desc');
                break;
            case 'title_asc':
                $query->orderBy('title', 'asc');
                break;
            case 'title_desc':
                $query->orderBy('title', 'desc');
                break;
            default:
                $query->orderBy('id', 'asc');
        }

        $villas = $query->paginate(10);
            
        return view('realtor.villas', compact('villas'));
    }

    /**
     * Show the form for creating a new villa.
     */
    public function createVilla()
    {
        $locations = Location::orderBy('name')->get();
        $features = Feature::orderBy('name')->get();
        
        return view('realtor.villa-edit', compact('locations', 'features'));
    }

    /**
     * Store a newly created villa in storage.
     */
    public function storeVilla(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location_id' => 'required|exists:locations,id',
            'price_per_night' => 'required|numeric|min:1',
            'area' => 'required|integer|min:1',
            'bedrooms' => 'required|integer|min:1',
            'bathrooms' => 'required|integer|min:1',
            'max_guests' => 'required|integer|min:1',
            'address' => 'required|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'features' => 'nullable|array',
            'features.*' => 'exists:features,id',
            'images' => 'required|array|min:1',
            'images.*' => 'image|mimes:jpeg,png,jpg|max:20480',
            'primary_image' => 'nullable|integer|min:0',
        ]);
        
        // Create the villa
        $villa = new Villa([
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']) . '-' . Str::random(5),
            'description' => $validated['description'],
            'realtor_id' => Auth::id(),
            'location_id' => $validated['location_id'],
            'price_per_night' => $validated['price_per_night'],
            'size' => $validated['area'],
            'bedrooms' => $validated['bedrooms'],
            'bathrooms' => $validated['bathrooms'],
            'capacity' => $validated['max_guests'],
            'address' => $validated['address'],
            'latitude' => $validated['latitude'],
            'longitude' => $validated['longitude'],
            'is_active' => true,
            'is_featured' => false,
        ]);
        
        $villa->save();
        
        // Handle images
        if ($request->hasFile('images')) {
            $images = $request->file('images');
            $primaryImageIndex = $validated['primary_image'] ?? 0;
            
            foreach ($images as $index => $image) {
                $path = $image->store('villa-images', 'public');
                
                // Create a thumbnail
                $manager = new ImageManager(new Driver());
                $img = $manager->read(storage_path('app/public/' . $path));
                $img->resize(800, 600);
                $img->save();
                
                // Save image to database
                $villaImage = new VillaImage([
                    'villa_id' => $villa->id,
                    'path' => $path,
                    'is_primary' => ($index == $primaryImageIndex),
                    'order' => $index,
                ]);
                
                $villaImage->save();
            }
        }
        
        // Attach features
        if (isset($validated['features'])) {
            $villa->features()->attach($validated['features']);
        }
        
        return redirect()->route('realtor.villas')
            ->with('success', 'Villa başarıyla oluşturuldu.');
    }

    /**
     * Show the form for editing the villa.
     */
    public function editVilla(Villa $villa)
    {
        // Ensure the realtor owns this villa
        if ($villa->realtor_id !== Auth::id()) {
            abort(403, 'Bu villayı düzenleme izniniz yok.');
        }
        
        $villa->load('images', 'features');
        $locations = Location::orderBy('name')->get();
        $features = Feature::orderBy('name')->get();
        $selectedFeatures = $villa->features->pluck('id')->toArray();
        
        return view('realtor.villa-edit', compact('villa', 'locations', 'features', 'selectedFeatures'));
    }

    /**
     * Update the specified villa in storage.
     */
    public function updateVilla(Request $request, Villa $villa)
    {
        // Ensure the realtor owns this villa
        if ($villa->realtor_id !== Auth::id()) {
            abort(403, 'Bu villayı düzenleme izniniz yok.');
        }
        
        // Debug: Log all request data
        \Log::info('=== UpdateVilla Debug Start ===');
        \Log::info('Request method: ' . $request->method());
        \Log::info('Request all data:', $request->all());
        \Log::info('Request files:', $request->allFiles());
        \Log::info('Has new_images file: ' . ($request->hasFile('new_images') ? 'true' : 'false'));
        if ($request->hasFile('new_images')) {
            \Log::info('New images count: ' . count($request->file('new_images')));
            foreach ($request->file('new_images') as $index => $file) {
                \Log::info("File {$index}:", [
                    'name' => $file->getClientOriginalName(),
                    'size' => $file->getSize(),
                    'mime' => $file->getMimeType(),
                ]);
            }
        }
        \Log::info('=== UpdateVilla Debug End ===');
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location_id' => 'required|exists:locations,id',
            'price_per_night' => 'required|numeric|min:1',
            'area' => 'required|integer|min:1',
            'bedrooms' => 'required|integer|min:1',
            'bathrooms' => 'required|integer|min:1',
            'max_guests' => 'required|integer|min:1',
            'address' => 'required|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'features' => 'nullable|array',
            'features.*' => 'exists:features,id',
            'is_active' => 'boolean',
            'new_images' => 'nullable|array',
            'new_images.*' => 'image|mimes:jpeg,png,jpg|max:20480',
        ]);
        
        // Update the villa
        $villa->title = $validated['title'];
        // Only update slug if title changed
        if ($villa->isDirty('title')) {
            $villa->slug = Str::slug($validated['title']) . '-' . Str::random(5);
        }
        $villa->description = $validated['description'];
        $villa->location_id = $validated['location_id'];
        $villa->price_per_night = $validated['price_per_night'];
        $villa->size = $validated['area'];
        $villa->bedrooms = $validated['bedrooms'];
        $villa->bathrooms = $validated['bathrooms'];
        $villa->capacity = $validated['max_guests'];
        $villa->address = $validated['address'];
        $villa->latitude = $validated['latitude'];
        $villa->longitude = $validated['longitude'];
        $villa->is_active = $validated['is_active'] ?? false;
        
        $villa->save();
        
        // Handle new images
        if ($request->hasFile('new_images')) {
            $images = $request->file('new_images');
            
            // Get next order number
            $nextOrder = $villa->images->max('order') + 1;
            
            foreach ($images as $index => $image) {
                $path = $image->store('villa-images', 'public');
                
                // Create a thumbnail
                $manager = new ImageManager(new Driver());
                $img = $manager->read(storage_path('app/public/' . $path));
                $img->resize(800, 600);
                $img->save();
                
                // Save image to database
                $villaImage = new VillaImage([
                    'villa_id' => $villa->id,
                    'path' => $path,
                    'is_primary' => false, // New images are not primary by default
                    'order' => $nextOrder + $index,
                ]);
                
                $villaImage->save();
            }
        }
        
        // Update features
        if (isset($validated['features'])) {
            $villa->features()->sync($validated['features']);
        } else {
            $villa->features()->detach();
        }
        
        return redirect()->route('realtor.villas')
            ->with('success', 'Villa başarıyla güncellendi.');
    }

    /**
     * Remove the specified villa from storage.
     */
    public function destroyVilla(Villa $villa)
    {
        // Ensure the realtor owns this villa
        if ($villa->realtor_id !== Auth::id()) {
            abort(403, 'Bu villayı silme izniniz yok.');
        }
        
        // Check if villa has any bookings
        if ($villa->bookings()->count() > 0) {
            return back()->with('error', 'Bu villa rezervasyonlara sahip olduğu için silinemez.');
        }
        
        // Delete images
        foreach ($villa->images as $image) {
            if (Storage::disk('public')->exists($image->path)) {
                Storage::disk('public')->delete($image->path);
            }
            $image->delete();
        }
        
        // Delete features
        $villa->features()->detach();
        
        // Delete villa
        $villa->delete();
        
        return redirect()->route('realtor.villas')
            ->with('success', 'Villa başarıyla silindi.');
    }

    /**
     * Add images to the villa.
     */
    public function addImages(Request $request, Villa $villa)
    {
        // Ensure the realtor owns this villa
        if ($villa->realtor_id !== Auth::id()) {
            abort(403, 'Bu villaya resim ekleme izniniz yok.');
        }
        
        $request->validate([
            'images' => 'required|array|min:1',
            'images.*' => 'image|mimes:jpeg,png,jpg|max:20480',
            'primary_image' => 'nullable|integer',
        ]);
        
        // Handle images
        if ($request->hasFile('images')) {
            $images = $request->file('images');
            $setPrimary = $request->has('primary_image');
            
            // Get next order number
            $nextOrder = $villa->images->max('order') + 1;
            
            foreach ($images as $index => $image) {
                $path = $image->store('villa-images', 'public');
                
                // Create a thumbnail
                $manager = new ImageManager(new Driver());
                $img = $manager->read(storage_path('app/public/' . $path));
                $img->resize(800, 600);
                $img->save();
                
                // Save image to database
                $villaImage = new VillaImage([
                    'villa_id' => $villa->id,
                    'path' => $path,
                    'is_primary' => ($setPrimary && $index == $request->primary_image),
                    'order' => $nextOrder + $index,
                ]);
                
                $villaImage->save();
                
                // If this is the primary image, unset other primary images
                if ($villaImage->is_primary) {
                    VillaImage::where('villa_id', $villa->id)
                        ->where('id', '!=', $villaImage->id)
                        ->update(['is_primary' => false]);
                }
            }
        }
        
        return back()->with('success', 'Resimler başarıyla eklendi.');
    }

    /**
     * Delete an image.
     */
    public function deleteImage(VillaImage $image)
    {
        $villa = $image->villa;
        
        // Ensure the realtor owns this villa
        if ($villa->realtor_id !== Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Bu resmi silme izniniz yok.'], 403);
        }
        
        // Check if this is the only image or the primary image
        if ($villa->images->count() <= 1) {
            return response()->json(['success' => false, 'message' => 'Villanın en az bir resmi olmalıdır.']);
        }
        
        // If it's the primary image, make another image primary
        if ($image->is_primary) {
            $newPrimary = $villa->images()->where('id', '!=', $image->id)->first();
            if ($newPrimary) {
                $newPrimary->is_primary = true;
                $newPrimary->save();
            }
        }
        
        // Delete the file
        if (Storage::disk('public')->exists($image->path)) {
            Storage::disk('public')->delete($image->path);
        }
        
        // Delete the record
        $image->delete();
        
        return response()->json(['success' => true, 'message' => 'Resim başarıyla silindi.']);
    }

    /**
     * Update the features for a villa.
     */
    public function updateFeatures(Request $request, Villa $villa)
    {
        // Ensure the realtor owns this villa
        if ($villa->realtor_id !== Auth::id()) {
            abort(403, 'Bu villanın özelliklerini güncelleme izniniz yok.');
        }
        
        $validated = $request->validate([
            'features' => 'nullable|array',
            'features.*' => 'exists:features,id',
        ]);
        
        // Sync features
        $villa->features()->sync($validated['features'] ?? []);
        
        return back()->with('success', 'Özellikler başarıyla güncellendi.');
    }

    /**
     * Display a listing of the realtor's bookings.
     */
    public function bookings(Request $request)
    {
        $baseQuery = function() {
            return Booking::whereHas('villa', function($query) {
                $query->where('realtor_id', Auth::id());
            });
        };
        
        // Get statistics for all bookings (unfiltered)
        $totalBookings = $baseQuery()->count();
        $pendingBookings = $baseQuery()->where('status', 'pending')->count();
        $confirmedBookings = $baseQuery()->where('status', 'confirmed')->count();
        $totalRevenue = $baseQuery()->where('status', '!=', 'cancelled')->sum('total_price');
        
        // Build filtered query for bookings list
        $query = $baseQuery()->with(['villa.location', 'customer']);
        
        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                  ->orWhereHas('villa', function($vq) use ($search) {
                      $vq->where('title', 'like', "%{$search}%");
                  })
                  ->orWhereHas('customer', function($cq) use ($search) {
                      $cq->where('name', 'like', "%{$search}%")
                         ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }
        
        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        // Date range filter (check-in dates)
        if ($request->filled('date_from')) {
            $query->where('check_in', '>=', $request->date_from);
        }
        
        if ($request->filled('date_to')) {
            $query->where('check_in', '<=', $request->date_to);
        }
        
        // Sorting
        $sort = $request->get('sort', 'created_desc');
        switch ($sort) {
            case 'created_asc':
                $query->orderBy('created_at', 'asc');
                break;
            case 'created_desc':
                $query->orderBy('created_at', 'desc');
                break;
            case 'checkin_asc':
                $query->orderBy('check_in', 'asc');
                break;
            case 'checkin_desc':
                $query->orderBy('check_in', 'desc');
                break;
            case 'price_asc':
                $query->orderBy('total_price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('total_price', 'desc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }
        
        $bookings = $query->paginate(10)->appends($request->query());
        
        return view('realtor.bookings', compact('bookings', 'totalBookings', 'pendingBookings', 'confirmedBookings', 'totalRevenue'));
    }

    /**
     * Show a specific booking.
     */
    public function showBooking(Booking $booking)
    {
        // Ensure the realtor owns the villa for this booking
        if ($booking->villa->realtor_id !== Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Bu rezervasyonu görüntüleme izniniz yok.'], 403);
        }
        
        $booking->load(['villa.location', 'customer']);
        
        return response()->json([
            'success' => true,
            'booking' => [
                'id' => $booking->id,
                'status' => $booking->status,
                'check_in' => $booking->check_in->format('d.m.Y'),
                'check_out' => $booking->check_out->format('d.m.Y'),
                'guests' => $booking->guests,
                'total_price' => number_format($booking->total_price, 0, ',', '.'),
                'special_requests' => $booking->special_requests,
                'customer' => [
                    'name' => $booking->customer->name,
                    'email' => $booking->customer->email,
                    'phone' => $booking->customer->phone,
                ],
                'villa' => [
                    'title' => $booking->villa->title,
                    'address' => $booking->villa->address,
                    'location' => [
                        'name' => $booking->villa->location->name,
                    ],
                ],
            ]
        ]);
    }

    /**
     * Update the status of a booking.
     */
    public function updateBookingStatus(Request $request, Booking $booking)
    {
        // Ensure the realtor owns the villa for this booking
        if ($booking->villa->realtor_id !== Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Bu rezervasyonun durumunu güncelleme izniniz yok.'], 403);
        }
        
        $validated = $request->validate([
            'status' => 'required|in:confirmed,cancelled,completed',
        ]);
        
        $booking->status = $validated['status'];
        $booking->save();
        
        // Send notification to customer (would be implemented with Laravel Notifications)
        
        return response()->json(['success' => true, 'message' => 'Rezervasyon durumu başarıyla güncellendi.']);
    }

    /**
     * Display the realtor's profile.
     */
    public function profile()
    {
        return view('realtor.profile');
    }

    /**
     * Update the realtor's profile.
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:255'],
            'profile_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:1024'],
        ]);
        
        // Handle profile image upload
        if ($request->hasFile('profile_image')) {
            // Delete old image if exists
            if ($user->profile_image && Storage::disk('public')->exists($user->profile_image)) {
                Storage::disk('public')->delete($user->profile_image);
            }
            
            $path = $request->file('profile_image')->store('profile-images', 'public');
            
            // Resize image
            $manager = new ImageManager(new Driver());
            $img = $manager->read(storage_path('app/public/' . $path));
            $img->resize(300, 300);
            $img->save();
            
            $user->profile_image = $path;
        }
        
        // Update user information
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->phone = $validated['phone'];
        $user->address = $validated['address'];
        
        $user->save();
        
        return back()->with('success', 'Profil bilgileriniz güncellendi.');
    }

    /**
     * Update the realtor's password.
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Mevcut şifre yanlış.']);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Şifre başarıyla güncellendi.');
    }

    /**
     * Display a listing of the locations.
     */
    public function locations()
    {
        $query = Location::withCount('villas');

        // Apply search filter
        if (request()->has('search') && request('search') != '') {
            $search = request('search');
            $query->where('name', 'like', '%' . $search . '%');
        }

        // Apply popular filter
        if (request()->has('popular') && request('popular') != '') {
            $query->where('is_popular', request('popular'));
        }

        // Apply sorting
        if (request()->has('sort')) {
            switch (request('sort')) {
                case 'name_asc':
                    $query->orderBy('name', 'asc');
                    break;
                case 'name_desc':
                    $query->orderBy('name', 'desc');
                    break;
                case 'villas_desc':
                    $query->orderBy('villas_count', 'desc');
                    break;
                case 'villas_asc':
                    $query->orderBy('villas_count', 'asc');
                    break;
                default:
                    $query->orderBy('name', 'asc');
                    break;
            }
        } else {
            $query->orderBy('name', 'asc');
        }

        $locations = $query->paginate(10)->withQueryString();
        
        return view('realtor.locations', compact('locations'));
    }

    /**
     * Store a newly created location in storage.
     */
    public function storeLocation(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:locations,name',
            'description' => 'nullable|string',
            'is_popular' => 'boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:20480',
        ]);
        
        $location = new Location([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'description' => $validated['description'] ?? '',
            'is_popular' => $validated['is_popular'] ?? false,
        ]);
        
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('location-images', 'public');
            $location->image = $path;
        }
        
        $location->save();
        
        return back()->with('success', 'Lokasyon başarıyla oluşturuldu.');
    }

    /**
     * Update the specified location in storage.
     */
    public function updateLocation(Request $request, Location $location)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:locations,name,' . $location->id,
            'description' => 'nullable|string',
            'is_popular' => 'boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:20480',
        ]);
        
        $location->name = $validated['name'];
        $location->slug = Str::slug($validated['name']);
        $location->description = $validated['description'] ?? '';
        $location->is_popular = $validated['is_popular'] ?? false;
        
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($location->image && Storage::disk('public')->exists($location->image)) {
                Storage::disk('public')->delete($location->image);
            }
            
            $path = $request->file('image')->store('location-images', 'public');
            $location->image = $path;
        }
        
        $location->save();
        
        return back()->with('success', 'Lokasyon başarıyla güncellendi.');
    }

    /**
     * Remove the specified location from storage.
     */
    public function destroyLocation(Location $location)
    {
        // Check if location has villas
        if ($location->villas()->count() > 0) {
            return back()->with('error', 'Bu lokasyonun ilişkili villaları olduğu için silinemez.');
        }
        
        // Delete image if exists
        if ($location->image && Storage::disk('public')->exists($location->image)) {
            Storage::disk('public')->delete($location->image);
        }
        
        $location->delete();
        
        return back()->with('success', 'Lokasyon başarıyla silindi.');
    }

    /**
     * Toggle the popular status of a location.
     */
    public function toggleLocationPopular(Location $location)
    {
        $location->update([
            'is_popular' => !$location->is_popular
        ]);
        
        return back()->with('success', 'Lokasyon popülerlik durumu değiştirildi.');
    }

    /**
     * Get location data for AJAX requests.
     */
    public function getLocation(Location $location)
    {
        try {
            $location->load(['villas']);
            
            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $location->id,
                    'name' => $location->name,
                    'description' => $location->description,
                    'is_popular' => $location->is_popular,
                    'image' => $location->image ? Storage::url($location->image) : null,
                    'villas_count' => $location->villas->count()
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lokasyon bilgileri alınırken bir hata oluştu.'
            ], 500);
        }
    }

    /**
     * Show the form for editing the specified location.
     */
    public function editLocation(Location $location)
    {
        // Get villas with pagination and load primary image
        $villas = $location->villas()
            ->with(['images' => function($query) {
                $query->where('is_primary', true);
            }])
            ->paginate(6)
            ->withQueryString();
            
        return view('realtor.locations.edit', compact('location', 'villas'));
    }

    /**
     * Set primary image for a villa.
     */
    public function setPrimaryImage(Villa $villa, $imageId)
    {
        // Check if the villa belongs to the authenticated realtor
        if ($villa->realtor_id !== Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        // Reset all images to not primary
        $villa->images()->update(['is_primary' => false]);
        
        // Set the selected image as primary
        $image = $villa->images()->find($imageId);
        if ($image) {
            $image->update(['is_primary' => true]);
            return response()->json(['success' => true]);
        }
        
        return response()->json(['success' => false, 'message' => 'Image not found'], 404);
    }
}
