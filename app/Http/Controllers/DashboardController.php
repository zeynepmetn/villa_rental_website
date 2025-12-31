<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Booking;
use App\Models\Villa;
use App\Models\Review;

class DashboardController extends Controller
{
    /**
     * Redirect to appropriate dashboard based on user role.
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->hasRole('admin')) {
            $adminController = new AdminController();
            return $adminController->dashboard();
        } elseif ($user->hasRole('realtor')) {
            return redirect()->route('realtor.dashboard');
        } else {
            // Default to customer dashboard
            return $this->customerDashboard();
        }
    }

    /**
     * Display customer dashboard.
     */
    private function customerDashboard()
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
     * Display the customer profile.
     */
    public function customerProfile()
    {
        return view('customer.profile');
    }

    /**
     * Update the customer profile.
     */
    public function updateCustomerProfile(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:255'],
            'current_password' => ['nullable', 'required_with:password', 'string'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);
        
        // Check if current password is correct
        if ($request->filled('current_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Mevcut şifreniz yanlış.']);
            }
        }
        
        // Update user information
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->phone = $validated['phone'];
        $user->address = $validated['address'];
        
        // Update password if provided
        if ($request->filled('password')) {
            $user->password = Hash::make($validated['password']);
        }
        
        $user->save();
        
        return back()->with('success', 'Profil bilgileriniz güncellendi.');
    }
}
