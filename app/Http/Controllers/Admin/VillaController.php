<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Villa;
use App\Models\Location;
use App\Models\User;
use App\Models\Feature;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class VillaController extends Controller
{
    public function index(Request $request)
    {
        $query = Villa::with(['location', 'primaryImage']);

        // Apply location filter
        if ($request->filled('location')) {
            $query->where('location_id', $request->location);
        }

        // Apply status filter
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        // Apply featured filter
        if ($request->filled('featured')) {
            $query->where('is_featured', (bool)$request->featured);
        }

        // Apply search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('id', 'like', '%' . $search . '%');
            });
        }

        // Apply sorting
        $sort = $request->input('sort', 'id_asc');
        switch ($sort) {
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
            default: // id_asc
                $query->orderBy('id', 'asc');
                break;
        }

        $villas = $query->paginate(10)->withQueryString();
        $locations = Location::orderBy('name')->get();

        if ($request->ajax()) {
            return view('admin.villas.partials.villa-list', compact('villas'))->render();
        }

        return view('admin.villas.index', compact('villas', 'locations'));
    }

    public function create()
    {
        $locations = Location::active()->get();
        $realtors = User::role('realtor')->get();
        $features = Feature::all();

        return view('admin.villas.create', compact('locations', 'realtors', 'features'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'location_id' => 'required|exists:locations,id',
            'realtor_id' => 'required|exists:users,id',
            'bedrooms' => 'required|integer|min:1',
            'bathrooms' => 'required|integer|min:1',
            'capacity' => 'required|integer|min:1',
            'size' => 'required|integer|min:1',
            'price_per_night' => 'required|numeric|min:0',
            'address' => 'required',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'features' => 'array|max:10',
            'features.*' => 'nullable|integer|exists:features,id',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:20480',
            'images' => 'array|max:6',
            'primary_image_index' => 'nullable|integer|min:0'
        ]);

        try {
            DB::beginTransaction();

            $validated['slug'] = Str::slug($validated['title']);
            // Standart giriş ve çıkış saatlerini ayarla
            $validated['check_in_time'] = '15:00';
            $validated['check_out_time'] = '11:00';
            // Set default values for removed fields
            $validated['cleaning_fee'] = 0;
            $validated['min_stay'] = 1;
            
            $villa = Villa::create($validated);

            // Add features (max 10, skip empty)
            if (!empty($validated['features'])) {
                $villa->features()->sync($validated['features']);
            }

            // Handle images
            if ($request->hasFile('images')) {
                $currentOrder = -1;
                $primaryImageIndex = $request->input('primary_image_index', null); // No default primary
                
                foreach ($request->file('images') as $index => $image) {
                    $currentOrder++;
                    $path = $image->store('villa-images', 'public');
                    
                    // Create image record - only set as primary if explicitly selected
                    $villa->images()->create([
                        'path' => $path,
                        'is_primary' => $primaryImageIndex !== null && $index == $primaryImageIndex,
                        'order' => $currentOrder
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('admin.villas.index')->with('success', 'Villa başarıyla oluşturuldu.');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Villa creation error: ' . $e->getMessage());
            return back()->with('error', 'Villa oluşturulurken bir hata oluştu.');
        }
    }

    public function edit(Villa $villa)
    {
        try {
            Log::info('Villa edit method called', [
                'villa_id' => $villa->id,
                'villa_slug' => $villa->slug,
                'route_key' => $villa->getRouteKeyName()
            ]);

            $villa->load(['location', 'realtor', 'features', 'images', 'primaryImage']);
            $locations = Location::active()->get();
            $realtors = User::role('realtor')->get();
            $features = Feature::all();

            return view('admin.villas.edit', compact('villa', 'locations', 'realtors', 'features'));
        } catch (\Exception $e) {
            Log::error('Villa edit error', [
                'villa_id' => $villa->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()
                ->route('admin.villas.index')
                ->with('error', 'Villa düzenleme sayfası yüklenirken bir hata oluştu: ' . $e->getMessage());
        }
    }

    public function update(Request $request, Villa $villa)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'location_id' => 'required|exists:locations,id',
            'realtor_id' => 'required|exists:users,id',
            'bedrooms' => 'required|integer|min:1',
            'bathrooms' => 'required|integer|min:1',
            'capacity' => 'required|integer|min:1',
            'size' => 'required|integer|min:1',
            'price_per_night' => 'required|numeric|min:0',
            'address' => 'required',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'features' => 'array|max:10',
            'features.*' => 'nullable|integer|exists:features,id',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:20480',
            'images' => 'array|max:6',
            'delete_images' => 'nullable|array',
            'delete_images.*' => 'exists:villa_images,id',
            'primary_image' => 'nullable|exists:villa_images,id',
            'primary_image_index' => 'nullable|integer|min:0',
            'new_primary_image_index' => 'nullable|integer|min:0'
        ]);

        try {
            DB::beginTransaction();
            
            // Standart giriş ve çıkış saatlerini ayarla
            $validated['check_in_time'] = '15:00';
            $validated['check_out_time'] = '11:00';
            // Set default values for removed fields
            $validated['cleaning_fee'] = 0;
            $validated['min_stay'] = 1;

            $villa->update($validated);

            // Sync features
            $villa->features()->sync($request->features ?? []);

            // Handle image deletions
            if (!empty($request->delete_images)) {
                $images = $villa->images()->whereIn('id', $request->delete_images)->get();
                foreach ($images as $image) {
                    Storage::disk('public')->delete($image->path);
                    $image->delete();
                }
            }

            // Handle new images
            $newlyCreatedImages = [];
            if ($request->hasFile('images')) {
                $currentOrder = $villa->images()->max('order') ?? -1;
                $newPrimaryImageIndex = $request->input('new_primary_image_index', null);
                
                foreach ($request->file('images') as $index => $image) {
                    $currentOrder++;
                    $path = $image->store('villa-images', 'public');
                    
                    // Create image record (don't set primary yet)
                    $newImage = $villa->images()->create([
                        'path' => $path,
                        'is_primary' => false,
                        'order' => $currentOrder
                    ]);
                    
                    $newlyCreatedImages[] = [
                        'image' => $newImage,
                        'index' => $index,
                        'should_be_primary' => $newPrimaryImageIndex !== null && $index == $newPrimaryImageIndex
                    ];
                }
            }

            // Handle primary image selection - do this AFTER all images are created/deleted
            $primaryImageSet = false;
            
            // First, check if a new image should be primary
            foreach ($newlyCreatedImages as $imageData) {
                if ($imageData['should_be_primary']) {
                    // Set all images as non-primary first
                    $villa->images()->update(['is_primary' => false]);
                    // Set this new image as primary
                    $imageData['image']->update(['is_primary' => true]);
                    $primaryImageSet = true;
                    break;
                }
            }
            
            // If no new image was set as primary, check for existing image selection
            if (!$primaryImageSet && $request->has('primary_image')) {
                $primaryImageId = $request->primary_image;
                
                // First, set all images as non-primary
                $villa->images()->update(['is_primary' => false]);
                
                // Then set the selected image as primary
                $villa->images()->where('id', $primaryImageId)->update(['is_primary' => true]);
                $primaryImageSet = true;
            }
            
            // If no primary image is set and there are images, make the first one primary
            if (!$primaryImageSet && !$villa->images()->where('is_primary', true)->exists()) {
                $firstImage = $villa->images()->first();
                if ($firstImage) {
                    $firstImage->update(['is_primary' => true]);
                }
            }

            DB::commit();
            
            return redirect()
                ->route('admin.villas.index')
                ->with('success', 'Villa başarıyla güncellendi.');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Villa update error: ' . $e->getMessage());
            return back()->with('error', 'Villa güncellenirken bir hata oluştu.');
        }
    }

    public function destroy(Villa $villa)
    {
        // Delete images from storage
        foreach ($villa->images as $image) {
            Storage::disk('public')->delete($image->path);
        }

        $villa->delete();

        return redirect()
            ->route('admin.villas.index')
            ->with('success', 'Villa başarıyla silindi.');
    }

    /**
     * Update the order of villa images
     */
    public function updateImageOrder(Request $request, Villa $villa)
    {
        $request->validate([
            'orders' => 'required|array',
            'orders.*' => 'integer'
        ]);

        foreach ($request->orders as $imageId => $order) {
            $villa->images()->where('id', $imageId)->update(['order' => $order]);
        }

        return response()->json(['success' => true]);
    }

    public function show(Villa $villa)
    {
        $villa->load(['location', 'realtor', 'features', 'images', 'bookings']);
        
        return view('admin.villas.show', compact('villa'));
    }

    /**
     * Update the status of a villa.
     */
    public function updateStatus(Request $request, Villa $villa)
    {
        $validated = $request->validate([
            'is_active' => 'required|boolean',
        ]);
        
        $villa->update([
            'is_active' => $validated['is_active']
        ]);
        
        return back()->with('success', 'Villa durumu başarıyla güncellendi.');
    }

    /**
     * Toggle the featured status of a villa.
     */
    public function toggleFeatured(Villa $villa)
    {
        $villa->update([
            'is_featured' => !$villa->is_featured
        ]);
        
        return back()->with('success', 'Villa öne çıkarma durumu değiştirildi.');
    }

    /**
     * Set an image as primary
     */
    public function setPrimaryImage(Villa $villa, $imageId)
    {
        try {
            DB::beginTransaction();
            
            // Seçilen resmin bu villaya ait olduğunu kontrol et
            $image = $villa->images()->findOrFail($imageId);
            
            // Önce tüm resimlerin primary özelliğini false yap
            $villa->images()->update(['is_primary' => false]);
            
            // Seçilen resmi primary yap
            $image->update(['is_primary' => true]);
            
            DB::commit();
            
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error setting primary image', [
                'villa_id' => $villa->id,
                'image_id' => $imageId,
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'success' => false, 
                'message' => 'Kapak fotoğrafı güncellenirken bir hata oluştu: ' . $e->getMessage()
            ], 500);
        }
    }
} 