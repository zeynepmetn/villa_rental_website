<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Models\Villa;
use App\Models\Booking;
use App\Models\Location;
use App\Models\Contact;
use App\Mail\ContactReplyMail;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function dashboard()
    {
        // Get user statistics
        $totalUsers = User::count();
        $customerCount = User::role('customer')->count();
        $realtorCount = User::role('realtor')->count();
        
        // Get villa statistics
        $totalVillas = Villa::count();
        $activeVillas = Villa::where('is_active', true)->count();
        $featuredVillas = Villa::where('is_featured', true)->count();
        
        // Get booking statistics
        $totalBookings = Booking::count();
        $pendingBookings = Booking::where('status', 'pending')->count();
        $confirmedBookings = Booking::where('status', 'confirmed')->count();
        $cancelledBookings = Booking::where('status', 'cancelled')->count();
        
        // Get monthly booking data for chart
        $monthlyBookingsData = Booking::whereYear('created_at', date('Y'))
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->keyBy('month')
            ->map(function($item) {
                return $item->count;
            })
            ->toArray();
        
        // Fill missing months
        for ($i = 1; $i <= 12; $i++) {
            if (!isset($monthlyBookingsData[$i])) {
                $monthlyBookingsData[$i] = 0;
            }
        }
        
        // Sort by month
        ksort($monthlyBookingsData);
        
        // Get monthly revenue data for chart
        $monthlyRevenueData = Booking::where('status', '!=', 'cancelled')
            ->whereYear('created_at', date('Y'))
            ->selectRaw('MONTH(created_at) as month, SUM(total_price) as revenue')
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->keyBy('month')
            ->map(function($item) {
                return $item->revenue;
            })
            ->toArray();
        
        // Fill missing months
        for ($i = 1; $i <= 12; $i++) {
            if (!isset($monthlyRevenueData[$i])) {
                $monthlyRevenueData[$i] = 0;
            }
        }
        
        // Sort by month
        ksort($monthlyRevenueData);
        
        // Get recent bookings
        $recentBookings = Booking::with(['villa.location', 'customer'])
            ->latest()
            ->limit(5)
            ->get();
        
        return view('admin.dashboard', compact(
            'totalUsers',
            'customerCount',
            'realtorCount',
            'totalVillas',
            'activeVillas',
            'featuredVillas',
            'totalBookings',
            'pendingBookings',
            'confirmedBookings',
            'cancelledBookings',
            'monthlyBookingsData',
            'monthlyRevenueData',
            'recentBookings'
        ));
    }

    /**
     * Display a listing of the users.
     */
    public function users()
    {
        $users = User::with('roles')->paginate(10);
        
        return view('admin.users', compact('users'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function createUser()
    {
        $roles = Role::all();
        
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created user in storage.
     */
    public function storeUser(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'role' => 'required|exists:roles,name',
        ]);
        
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'phone' => $validated['phone'],
            'address' => $validated['address'],
        ]);
        
        $user->assignRole($validated['role']);
        
        return redirect()->route('admin.users')
            ->with('success', 'Kullanıcı başarıyla oluşturuldu.');
    }

    /**
     * Show the form for editing the specified user.
     */
    public function editUser(User $user)
    {
        $roles = Role::all();
        $user->load('roles');
        
        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified user in storage.
     */
    public function updateUser(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'role' => 'required|exists:roles,name',
            'password' => 'nullable|string|min:8|confirmed',
        ]);
        
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->phone = $validated['phone'];
        $user->address = $validated['address'];
        
        if ($request->filled('password')) {
            $user->password = Hash::make($validated['password']);
        }
        
        $user->save();
        
        // Update role
        $user->syncRoles([$validated['role']]);
        
        return redirect()->route('admin.users')
            ->with('success', 'Kullanıcı başarıyla güncellendi.');
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroyUser(User $user)
    {
        // Check if user has related data
        if ($user->villas()->count() > 0 || $user->bookings()->count() > 0) {
            return back()->with('error', 'Bu kullanıcının ilişkili verileri olduğu için silinemez.');
        }
        
        $user->delete();
        
        return redirect()->route('admin.users')
            ->with('success', 'Kullanıcı başarıyla silindi.');
    }

    /**
     * Display a listing of the villas.
     */
    public function villas()
    {
        $query = Villa::with(['location', 'realtor', 'primaryImage']);

        // Apply location filter
        if (request()->has('location') && request('location') != '') {
            $query->where('location_id', request('location'));
        }

        // Apply status filter
        if (request()->has('status')) {
            if (request('status') == 'active') {
                $query->where('is_active', true);
            } elseif (request('status') == 'inactive') {
                $query->where('is_active', false);
            }
        }

        // Apply featured filter
        if (request()->has('featured') && request('featured') != '') {
            $query->where('is_featured', request('featured'));
        }

        // Apply search
        if (request()->has('search') && request('search') != '') {
            $search = request('search');
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('id', 'like', '%' . $search . '%');
            });
        }

        // Apply sorting
        if (request()->has('sort')) {
            switch (request('sort')) {
                case 'price_asc':
                    $query->orderBy('price_per_night', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('price_per_night', 'desc');
                    break;
                default:
                    $query->latest();
                    break;
            }
        } else {
            $query->latest();
        }

        $villas = $query->paginate(10)->withQueryString();
            
        return view('admin.villas', compact('villas'));
    }

    /**
     * Update the status of a villa.
     */
    public function updateVillaStatus(Request $request, Villa $villa)
    {
        $validated = $request->validate([
            'is_active' => 'required|boolean',
        ]);
        
        $villa->is_active = $validated['is_active'];
        $villa->save();
        
        return back()->with('success', 'Villa durumu başarıyla güncellendi.');
    }

    /**
     * Toggle the featured status of a villa.
     */
    public function toggleVillaFeatured(Villa $villa)
    {
        $villa->is_featured = !$villa->is_featured;
        $villa->save();
        
        return back()->with('success', 'Villa öne çıkarma durumu değiştirildi.');
    }

    /**
     * Display a listing of all bookings.
     */
    public function bookings(Request $request)
    {
        $query = Booking::with(['villa.location', 'customer', 'villa.realtor']);

        // Apply status filter if provided
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Apply date range filter if provided
        if ($request->has('date_from') && $request->date_from != '') {
            $query->whereDate('check_in', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to != '') {
            $query->whereDate('check_out', '<=', $request->date_to);
        }

        // Apply search filter if provided
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('villa', function($villa) use ($search) {
                    $villa->where('title', 'like', '%' . $search . '%');
                })
                ->orWhereHas('customer', function($customer) use ($search) {
                    $customer->where('name', 'like', '%' . $search . '%')
                            ->orWhere('email', 'like', '%' . $search . '%');
                })
                ->orWhere('id', 'like', '%' . $search . '%');
            });
        }

        // Get all bookings for DataTables to handle pagination
        $bookings = $query->latest()->get();
            
        return view('admin.bookings', compact('bookings'));
    }

    /**
     * Display a listing of the locations.
     */
    public function locations()
    {
        $query = Location::withCount('villas');

        // Search filter
        if (request('search')) {
            $query->where('name', 'like', '%' . request('search') . '%');
        }

        // Popular filter
        if (request('popular') !== null) {
            $query->where('is_popular', request('popular'));
        }

        // Sorting
        switch (request('sort')) {
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

        $locations = $query->paginate(10);
        
        return view('admin.locations', compact('locations'));
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
        
        return redirect()->route('admin.locations')->with('success', 'Lokasyon başarıyla güncellendi.');
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
     * Display the site settings form.
     */
    public function settings()
    {
        return view('admin.settings');
    }

    /**
     * Update admin profile.
     */
    public function updateSettings(Request $request)
    {
        $user = auth()->user();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg|max:20480',
        ]);
        
        // Handle profile image upload
        if ($request->hasFile('profile_image')) {
            // Delete old image if exists
            if ($user->profile_image && Storage::disk('public')->exists($user->profile_image)) {
                Storage::disk('public')->delete($user->profile_image);
            }
            
            $path = $request->file('profile_image')->store('profile-images', 'public');
            $user->profile_image = $path;
        }
        
        // Update user information
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->phone = $validated['phone'];
        $user->address = $validated['address'];
        
        $user->save();
        
        return back()->with('success', 'Profil bilgileriniz başarıyla güncellendi.');
    }

    /**
     * Update admin password.
     */
    public function updatePassword(Request $request)
    {
        $user = auth()->user();
        
        $validated = $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);
        
        // Check if current password is correct
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Mevcut şifreniz yanlış.']);
        }
        
        // Update password
        $user->password = Hash::make($validated['password']);
        $user->save();
        
        return back()->with('success', 'Şifreniz başarıyla güncellendi.');
    }

    /**
     * Get statistics for a specific year.
     */
    public function getYearlyStats($year)
    {
        // Get monthly booking data for the selected year
        $monthlyBookingsData = Booking::whereYear('created_at', $year)
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->keyBy('month')
            ->map(function($item) {
                return $item->count;
            })
            ->toArray();
        
        // Get monthly revenue data for the selected year
        $monthlyRevenueData = Booking::where('status', '!=', 'cancelled')
            ->whereYear('created_at', $year)
            ->selectRaw('MONTH(created_at) as month, SUM(total_price) as revenue')
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->keyBy('month')
            ->map(function($item) {
                return $item->revenue;
            })
            ->toArray();
        
        return response()->json([
            'bookings' => $monthlyBookingsData,
            'revenue' => $monthlyRevenueData
        ]);
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
        $location->load(['villas']);
        
        // Get villas for this location with pagination
        $villas = $location->villas()->with(['images' => function($query) {
            $query->where('is_primary', true);
        }])->paginate(6);
        
        return view('admin.locations.edit', compact('location', 'villas'));
    }

    /**
     * Display reviews for admin approval.
     */
    public function reviews(Request $request)
    {
        $query = \App\Models\Review::with(['user', 'villa', 'booking']);
        
        // Filter by status
        if ($request->filled('status')) {
            if ($request->status === 'pending') {
                $query->where('is_approved', false);
            } elseif ($request->status === 'approved') {
                $query->where('is_approved', true);
            }
        }
        
        // Filter by rating
        if ($request->filled('rating')) {
            $query->where('rating', $request->rating);
        }
        
        // Search in comment or user name
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('comment', 'like', '%' . $search . '%')
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', '%' . $search . '%');
                  })
                  ->orWhereHas('villa', function($villaQuery) use ($search) {
                      $villaQuery->where('title', 'like', '%' . $search . '%');
                  });
            });
        }
        
        $reviews = $query->latest()->get();
        
        return view('admin.reviews', compact('reviews'));
    }

    /**
     * Approve a review.
     */
    public function approveReview(\App\Models\Review $review)
    {
        $review->update(['is_approved' => true]);
        
        return response()->json([
            'success' => true,
            'message' => 'Yorum onaylandı.'
        ]);
    }

    /**
     * Reject/Unapprove a review.
     */
    public function rejectReview(\App\Models\Review $review)
    {
        $review->update(['is_approved' => false]);
        
        return response()->json([
            'success' => true,
            'message' => 'Yorum onayı kaldırıldı.'
        ]);
    }

    /**
     * Delete a review.
     */
    public function deleteReview(\App\Models\Review $review)
    {
        $review->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Yorum silindi.'
        ]);
    }

    /**
     * Display contact messages.
     */
    public function contacts(Request $request)
    {
        $query = Contact::query();
        
        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        // Filter by subject
        if ($request->filled('subject')) {
            $query->where('subject', $request->subject);
        }
        
        // Search in name, email, or message
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%')
                  ->orWhere('message', 'like', '%' . $search . '%');
            });
        }
        
        $contacts = $query->recent()->paginate(15);
        
        // Get statistics
        $stats = [
            'total' => Contact::count(),
            'new' => Contact::new()->count(),
            'read' => Contact::read()->count(),
            'replied' => Contact::replied()->count(),
        ];
        
        return view('admin.contacts', compact('contacts', 'stats'));
    }

    /**
     * Show contact message details.
     */
    public function showContact(Contact $contact)
    {
        // Mark as read if it's new
        if ($contact->status === 'new') {
            $contact->markAsRead();
        }
        
        return view('admin.contacts.show', compact('contact'));
    }

    /**
     * Mark contact as replied.
     */
    public function markContactReplied(Contact $contact)
    {
        $contact->markAsReplied();
        
        return response()->json([
            'success' => true,
            'message' => 'Mesaj yanıtlandı olarak işaretlendi.'
        ]);
    }

    /**
     * Delete contact message.
     */
    public function deleteContact(Contact $contact)
    {
        $contact->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'İletişim mesajı silindi.'
        ]);
    }

    /**
     * Send reply email to contact.
     */
    public function sendContactReply(Request $request, Contact $contact)
    {
        $validated = $request->validate([
            'reply_message' => 'required|string|min:10',
        ]);

        try {
            // Send email
            Mail::to($contact->email)->send(new ContactReplyMail($contact, $validated['reply_message']));
            
            // Mark contact as replied and save reply message
            $contact->markAsReplied($validated['reply_message']);
            
            return response()->json([
                'success' => true,
                'message' => 'E-posta başarıyla gönderildi ve mesaj yanıtlandı olarak işaretlendi.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'E-posta gönderilirken bir hata oluştu: ' . $e->getMessage()
            ], 500);
        }
    }
}
