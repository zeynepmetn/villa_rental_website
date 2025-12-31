<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Villa;
use App\Models\Location;
use App\Models\Feature;
use Illuminate\Support\Facades\Auth;

class VillaController extends Controller
{
    /**
     * Display a listing of the villas.
     */
    public function index(Request $request)
    {
        $query = Villa::with(['location', 'primaryImage', 'features'])
            ->active();
            
        // Filter by location
        if ($request->has('location') && $request->location) {
            $query->where('location_id', $request->location);
        }

        // Filter by status (active/inactive)
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        // Filter by featured
        if ($request->filled('featured')) {
            $query->where('is_featured', (bool)$request->featured);
        }
        
        // Filter by search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('id', 'like', '%' . $search . '%');
            });
        }
        
        // Filter by price range
        if ($request->has('min_price') && $request->min_price) {
            $query->where('price_per_night', '>=', $request->min_price);
        }
        if ($request->has('max_price') && $request->max_price) {
            $query->where('price_per_night', '<=', $request->max_price);
        }
        
        // Filter by number of guests
        if ($request->has('max_guests') && $request->max_guests) {
            $query->where('capacity', '>=', $request->max_guests);
        }
        
        // Filter by number of bedrooms
        if ($request->has('bedrooms') && $request->bedrooms) {
            $query->where('bedrooms', '>=', $request->bedrooms);
        }

        // Filter by number of bathrooms
        if ($request->has('bathrooms') && $request->bathrooms) {
            $query->where('bathrooms', '>=', $request->bathrooms);
        }
        
        // Filter by features
        if ($request->has('features') && is_array($request->features) && !empty($request->features)) {
            $query->whereHas('features', function($q) use ($request) {
                $q->whereIn('features.id', $request->features);
            }, '=', count($request->features));
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
        
        $villas = $query->paginate(6)->withQueryString();
        
        // Get all locations and features for the filter
        $locations = Location::all();
        $features = Feature::all();
        
        return view('villas.index', compact('villas', 'locations', 'features'));
    }

    /**
     * Display the specified villa.
     */
    public function show(Villa $villa)
    {
        // Check if villa is active
        if (!$villa->is_active) {
            abort(404);
        }
        
        $villa->load(['location', 'images', 'features', 'realtor']);
        
        // Get approved reviews with user information (only show latest 5 initially)
        $reviews = $villa->approvedReviews()
            ->with(['user', 'booking'])
            ->latest()
            ->limit(5)
            ->get();
        
        // Get total review count for "show more" button
        $totalReviews = $villa->approvedReviews()->count();
        
        // Get similar villas
        $similarVillas = Villa::with(['location', 'primaryImage'])
            ->active()
            ->where('id', '!=', $villa->id)
            ->where(function($query) use ($villa) {
                $query->where('location_id', $villa->location_id)
                    ->orWhere('bedrooms', $villa->bedrooms);
            })
            ->limit(3)
            ->get();
            
        // Check if user has favorited this villa
        $isFavorited = false;
        if (Auth::check()) {
            $isFavorited = Auth::user()->hasFavorited($villa);
        }
        
        return view('villas.detail', compact('villa', 'similarVillas', 'isFavorited', 'reviews', 'totalReviews'));
    }

    /**
     * Toggle the villa's favorite status for the authenticated user.
     */
    public function toggleFavorite(Villa $villa)
    {
        $user = Auth::user();
        
        if ($user->hasFavorited($villa)) {
            $user->favorites()->detach($villa->id);
            $message = 'Villa favorilerden çıkarıldı.';
            $isFavorited = false;
        } else {
            $user->favorites()->attach($villa->id);
            $message = 'Villa favorilere eklendi.';
            $isFavorited = true;
        }
        
        // Check if request expects JSON (AJAX)
        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'is_favorited' => $isFavorited
            ]);
        }
        
        return back()->with('success', $message);
    }

    /**
     * Display the user's favorited villas.
     */
    public function customerFavorites()
    {
        $villas = Auth::user()->favorites()
            ->with(['location', 'primaryImage', 'features'])
            ->paginate(9);
            
        return view('customer.favorites', compact('villas'));
    }

    /**
     * Get the villa's availability data.
     */
    public function availability(Villa $villa, Request $request)
    {
        $startDate = $request->input('start_date', now()->format('Y-m-d'));
        $endDate = $request->input('end_date', now()->addMonths(3)->format('Y-m-d'));
        
        // Get all bookings for this villa within the date range
        $bookings = $villa->bookings()
            ->where('status', '!=', 'cancelled')
            ->where(function($query) use ($startDate, $endDate) {
                $query->whereBetween('check_in', [$startDate, $endDate])
                    ->orWhereBetween('check_out', [$startDate, $endDate])
                    ->orWhere(function($q) use ($startDate, $endDate) {
                        $q->where('check_in', '<', $startDate)
                          ->where('check_out', '>', $endDate);
                    });
            })
            ->get();
        
        $bookedDates = [];
        
        foreach ($bookings as $booking) {
            $currentDate = clone $booking->check_in;
            
            while ($currentDate < $booking->check_out) {
                $bookedDates[] = $currentDate->format('Y-m-d');
                $currentDate->addDay();
            }
        }
        // Benzersiz ve sıralı hale getir
        $bookedDates = array_unique($bookedDates);
        sort($bookedDates);
        return response()->json([
            'bookedDates' => $bookedDates
        ]);
    }

    /**
     * Load all reviews for a villa (AJAX).
     */
    public function loadAllReviews(Villa $villa)
    {
        $reviews = $villa->approvedReviews()
            ->with(['user', 'booking'])
            ->latest()
            ->get();

        $html = '';
        foreach ($reviews as $review) {
            $html .= view('components.review-item', compact('review'))->render();
        }

        return response()->json([
            'success' => true,
            'html' => $html,
            'total' => $reviews->count()
        ]);
    }
}
