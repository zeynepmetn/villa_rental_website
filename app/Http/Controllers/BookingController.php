<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Villa;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    /**
     * Show the form for creating a new booking.
     */
    public function create(Villa $villa)
    {
        // Check if user is admin or realtor
        if (Auth::check() && (Auth::user()->hasRole('admin') || Auth::user()->hasRole('realtor'))) {
            return redirect()->route('villas.show', $villa->slug)
                ->with('error', 'Rezervasyon oluşturmak için müşteri hesabınızla giriş yapın. Admin veya emlakçı hesabıyla rezervasyon yapılamaz.');
        }

        // Check if villa is active
        if (!$villa->is_active) {
            return redirect()->route('villas.index')
                ->with('error', 'Bu villa şu anda rezervasyona açık değil.');
        }
        
        // Load necessary relationships
        $villa->load(['location', 'primaryImage', 'features']);
        
        return view('bookings.create', compact('villa'));
    }

    /**
     * Store a newly created booking in storage.
     */
    public function store(Request $request, Villa $villa)
    {
        // Check if user is admin or realtor
        if (Auth::check() && (Auth::user()->hasRole('admin') || Auth::user()->hasRole('realtor'))) {
            return redirect()->route('villas.show', $villa->slug)
                ->with('error', 'Rezervasyon oluşturmak için müşteri hesabınızla giriş yapın. Admin veya emlakçı hesabıyla rezervasyon yapılamaz.');
        }

        // Validate the request
        $validated = $request->validate([
            'check_in' => 'required|date|after_or_equal:today',
            'check_out' => 'required|date|after:check_in',
            'guests' => 'required|integer|min:1|max:' . $villa->capacity,
            'notes' => 'nullable|string|max:500',
        ]);
        
        // Check if villa is active
        if (!$villa->is_active) {
            return redirect()->route('villas.index')
                ->with('error', 'Bu villa şu anda rezervasyona açık değil.');
        }
        
        // Check if the dates are available
        if (!$villa->isAvailable($validated['check_in'], $validated['check_out'])) {
            return back()->withInput()
                ->with('error', 'Seçilen tarihler müsait değil. Lütfen başka tarihler seçin.');
        }
        
        // Calculate total price
        $totalPrice = $villa->calculatePrice($validated['check_in'], $validated['check_out']);
        
        // Create the booking
        $booking = new Booking([
            'villa_id' => $villa->id,
            'customer_id' => Auth::id(),
            'check_in' => $validated['check_in'],
            'check_out' => $validated['check_out'],
            'guests' => $validated['guests'],
            'total_price' => $totalPrice,
            'status' => 'pending',
            'notes' => $validated['notes'],
        ]);
        
        $booking->save();
        
        // Redirect to the booking details
        return redirect()->route('customer.bookings.show', $booking)
            ->with('success', 'Rezervasyon talebiniz başarıyla oluşturuldu. Onay bekliyor.');
    }

    /**
     * Display the specified booking.
     */
    public function show(Booking $booking)
    {
        // Ensure the user owns this booking
        if ($booking->customer_id !== Auth::id()) {
            abort(403, 'Bu rezervasyonu görüntüleme izniniz yok.');
        }
        
        $booking->load('villa.location');
        
        return view('customer.bookings.show', compact('booking'));
    }

    /**
     * Cancel the specified booking.
     */
    public function cancel(Booking $booking)
    {
        // Ensure the user owns this booking
        if ($booking->customer_id !== Auth::id()) {
            abort(403, 'Bu rezervasyonu iptal etme izniniz yok.');
        }
        
        // Check if booking can be cancelled
        if (!$booking->canBeCancelled()) {
            return back()->with('error', 'Bu rezervasyon artık iptal edilemez.');
        }
        
        $booking->status = 'cancelled';
        $booking->save();
        
        return redirect()->route('customer.bookings')
            ->with('success', 'Rezervasyonunuz başarıyla iptal edildi.');
    }

    /**
     * Display a listing of the bookings for the authenticated customer.
     */
    public function customerBookings()
    {
        $activeBookings = Booking::where('customer_id', Auth::id())
            ->where('check_out', '>=', now())
            ->where('status', '!=', 'cancelled')
            ->with('villa.location')
            ->orderBy('check_in')
            ->get();
            
        $pastBookings = Booking::where('customer_id', Auth::id())
            ->where(function($query) {
                $query->where('check_out', '<', now())
                      ->orWhere('status', 'completed');
            })
            ->with('villa.location')
            ->orderBy('check_out', 'desc')
            ->get();
            
        $cancelledBookings = Booking::where('customer_id', Auth::id())
            ->where('status', 'cancelled')
            ->with('villa.location')
            ->orderBy('updated_at', 'desc')
            ->get();
            
        return view('customer.bookings', compact(
            'activeBookings',
            'pastBookings',
            'cancelledBookings'
        ));
    }
}
