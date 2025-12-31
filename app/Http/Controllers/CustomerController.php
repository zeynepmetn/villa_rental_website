<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\Booking;
use App\Models\Villa;
use App\Models\Review;

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the customer dashboard
     */
    public function dashboard()
    {
        $user = Auth::user();
        
        // Get user's booking statistics
        $totalBookings = Booking::where('customer_id', $user->id)->count();
        $completedBookings = Booking::where('customer_id', $user->id)
            ->where('status', 'completed')
            ->count();
        
        // Get recent bookings (last 3)
        $recentBookings = Booking::where('customer_id', $user->id)
            ->with(['villa'])
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();
        
        // Get favorite villas (last 3)
        $favoriteVillas = $user->favorites()
            ->with(['location', 'primaryImage'])
            ->orderBy('favorites.created_at', 'desc')
            ->limit(3)
            ->get();
        
        $favoriteCount = $user->favorites()->count();
        
        // Get user's reviews count
        $totalReviews = Review::where('user_id', $user->id)->count();
        
        return view('customer.dashboard', compact(
            'totalBookings',
            'completedBookings',
            'recentBookings',
            'favoriteVillas',
            'favoriteCount',
            'totalReviews'
        ));
    }

    /**
     * Show customer bookings
     */
    public function bookings()
    {
        $activeBookings = Booking::where('customer_id', Auth::id())
            ->where('check_out', '>=', now())
            ->where('status', '!=', 'cancelled')
            ->with('villa.location')
            ->orderBy('check_in')
            ->paginate(10);
            
        $pastBookings = Booking::where('customer_id', Auth::id())
            ->where(function($query) {
                $query->where('check_out', '<', now())
                      ->orWhere('status', 'completed');
            })
            ->with('villa.location')
            ->orderBy('check_out', 'desc')
            ->paginate(10);
            
        $cancelledBookings = Booking::where('customer_id', Auth::id())
            ->where('status', 'cancelled')
            ->with('villa.location')
            ->orderBy('updated_at', 'desc')
            ->paginate(10);
            
        return view('customer.bookings', compact(
            'activeBookings',
            'pastBookings',
            'cancelledBookings'
        ));
    }

    /**
     * Show specific booking details
     */
    public function showBooking($id)
    {
        $user = Auth::user();
        
        $booking = Booking::where('customer_id', $user->id)
            ->where('id', $id)
            ->with(['villa', 'user'])
            ->firstOrFail();
        
        return view('customer.booking-detail', compact('booking'));
    }

    /**
     * Show customer favorites
     */
    public function favorites()
    {
        $user = Auth::user();
        
        $favoriteVillas = $user->favorites()
            ->orderBy('favorites.created_at', 'desc')
            ->paginate(12);
        
        return view('customer.favorites', compact('favoriteVillas'));
    }

    /**
     * Show customer profile
     */
    public function profile()
    {
        $user = Auth::user();
        
        // Get additional stats for profile
        $totalBookings = Booking::where('customer_id', $user->id)->count();
        $completedBookings = Booking::where('customer_id', $user->id)
            ->where('status', 'completed')
            ->count();
        $favoriteCount = $user->favorites()->count();
        
        return view('customer.profile', compact('user', 'totalBookings', 'completedBookings', 'favoriteCount'));
    }

    /**
     * Update customer profile
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'city' => 'nullable|string|max:100',
            'birth_date' => 'nullable|date|before:today',
            'gender' => 'nullable|in:male,female,other',
            'bio' => 'nullable|string|max:1000',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:20480'
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->city = $request->city;
        $user->birth_date = $request->birth_date;
        $user->gender = $request->gender;
        $user->bio = $request->bio;

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            // Delete old avatar if exists
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }
            
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $avatarPath;
        }

        $user->save();

        return redirect()->route('customer.profile')
            ->with('success', 'Profil bilgileriniz başarıyla güncellendi.');
    }

    /**
     * Update customer password
     */
    public function updatePassword(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Check if current password is correct
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()
                ->withErrors(['current_password' => 'Mevcut şifreniz yanlış.']);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('customer.profile')
            ->with('success', 'Şifreniz başarıyla güncellendi.');
    }

    /**
     * Cancel a booking
     */
    public function cancelBooking($id)
    {
        $user = Auth::user();
        
        $booking = Booking::where('customer_id', $user->id)
            ->where('id', $id)
            ->firstOrFail();

        // Check if booking can be cancelled
        if ($booking->status === 'cancelled') {
            return redirect()->back()
                ->with('error', 'Bu rezervasyon zaten iptal edilmiş.');
        }

        if ($booking->status === 'completed') {
            return redirect()->back()
                ->with('error', 'Tamamlanmış rezervasyonlar iptal edilemez.');
        }

        // Update booking status
        $booking->status = 'cancelled';
        $booking->save();

        return redirect()->route('customer.bookings')
            ->with('success', 'Rezervasyonunuz başarıyla iptal edildi.');
    }

    /**
     * Add villa to favorites
     */
    public function addToFavorites($villaId)
    {
        $user = Auth::user();
        $villa = Villa::findOrFail($villaId);
        
        // Check if already favorited
        if ($user->hasFavorited($villa)) {
            return response()->json([
                'success' => false,
                'message' => 'Bu villa zaten favorilerinizde.'
            ]);
        }
        
        $user->favorites()->attach($villa->id);
        
        return response()->json([
            'success' => true,
            'message' => 'Villa favorilerinize eklendi.'
        ]);
    }

    /**
     * Remove villa from favorites
     */
    public function removeFromFavorites($villaId)
    {
        $user = Auth::user();
        $villa = Villa::findOrFail($villaId);
        
        $user->favorites()->detach($villa->id);
        
        return response()->json([
            'success' => true,
            'message' => 'Villa favorilerinizden kaldırıldı.'
        ]);
    }

    /**
     * Download user data (GDPR compliance)
     */
    public function downloadData()
    {
        $user = Auth::user();
        
        $data = [
            'user_info' => $user->toArray(),
            'bookings' => $user->bookings()->with('villa')->get()->toArray(),
            'favorites' => $user->favorites()->get()->toArray(),
            'reviews' => Review::where('user_id', $user->id)->with('villa')->get()->toArray(),
        ];
        
        $fileName = 'user_data_' . $user->id . '_' . now()->format('Y-m-d') . '.json';
        
        return response()->json($data)
            ->header('Content-Disposition', 'attachment; filename="' . $fileName . '"');
    }

    /**
     * Delete user account
     */
    public function deleteAccount(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'password' => 'required',
        ]);

        // Check if password is correct
        if (!Hash::check($request->password, $user->password)) {
            return redirect()->back()
                ->withErrors(['password' => 'Şifreniz yanlış.']);
        }

        // Delete user avatar if exists
        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        // Delete user (this will cascade delete favorites, bookings etc.)
        $user->delete();

        return redirect()->route('home')
            ->with('success', 'Hesabınız başarıyla silindi.');
    }
} 