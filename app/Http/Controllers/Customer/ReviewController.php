<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Display completed bookings that can be reviewed.
     */
    public function index()
    {
        $user = Auth::user();
        
        // Get completed bookings for the customer
        $completedBookings = Booking::with(['villa.location', 'review'])
            ->where('customer_id', $user->id)
            ->where('status', 'completed')
            ->orWhere(function($query) use ($user) {
                $query->where('customer_id', $user->id)
                      ->where('check_out', '<', now())
                      ->where('status', 'confirmed');
            })
            ->latest()
            ->get();
        
        return view('customer.reviews.index', compact('completedBookings'));
    }

    /**
     * Show the form for creating a new review.
     */
    public function create(Booking $booking)
    {
        // Check if user owns this booking
        if ($booking->customer_id !== Auth::id()) {
            abort(403, 'Bu rezervasyona erişim yetkiniz yok.');
        }

        // Check if booking is completed
        if (!$booking->isCompleted() && $booking->status !== 'completed') {
            return redirect()->route('customer.reviews.index')
                ->with('error', 'Sadece tamamlanan rezervasyonlar için yorum yapabilirsiniz.');
        }

        // Check if review already exists
        if ($booking->hasReview()) {
            return redirect()->route('customer.reviews.edit', $booking->review)
                ->with('info', 'Bu rezervasyon için zaten bir yorumunuz var. Düzenleyebilirsiniz.');
        }

        return view('customer.reviews.create', compact('booking'));
    }

    /**
     * Store a newly created review.
     */
    public function store(Request $request, Booking $booking)
    {
        // Check if user owns this booking
        if ($booking->customer_id !== Auth::id()) {
            abort(403, 'Bu rezervasyona erişim yetkiniz yok.');
        }

        // Check if booking is completed
        if (!$booking->isCompleted() && $booking->status !== 'completed') {
            return redirect()->route('customer.reviews.index')
                ->with('error', 'Sadece tamamlanan rezervasyonlar için yorum yapabilirsiniz.');
        }

        // Check if review already exists
        if ($booking->hasReview()) {
            return redirect()->route('customer.reviews.edit', $booking->review)
                ->with('error', 'Bu rezervasyon için zaten bir yorumunuz var.');
        }

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:10|max:1000',
        ], [
            'rating.required' => 'Puan vermeniz gereklidir.',
            'rating.min' => 'En az 1 puan vermelisiniz.',
            'rating.max' => 'En fazla 5 puan verebilirsiniz.',
            'comment.required' => 'Yorum yazmanız gereklidir.',
            'comment.min' => 'Yorum en az 10 karakter olmalıdır.',
            'comment.max' => 'Yorum en fazla 1000 karakter olabilir.',
        ]);

        Review::create([
            'booking_id' => $booking->id,
            'villa_id' => $booking->villa_id,
            'user_id' => Auth::id(),
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
            'is_approved' => false, // Admin onayı bekleyecek
        ]);

        return redirect()->route('customer.reviews.index')
            ->with('success', 'Yorumunuz başarıyla gönderildi. Admin onayından sonra yayınlanacaktır.');
    }

    /**
     * Show the form for editing the specified review.
     */
    public function edit(Review $review)
    {
        // Check if user owns this review
        if ($review->user_id !== Auth::id()) {
            abort(403, 'Bu yoruma erişim yetkiniz yok.');
        }

        $booking = $review->booking;

        return view('customer.reviews.edit', compact('review', 'booking'));
    }

    /**
     * Update the specified review.
     */
    public function update(Request $request, Review $review)
    {
        // Check if user owns this review
        if ($review->user_id !== Auth::id()) {
            abort(403, 'Bu yoruma erişim yetkiniz yok.');
        }

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:10|max:1000',
        ], [
            'rating.required' => 'Puan vermeniz gereklidir.',
            'rating.min' => 'En az 1 puan vermelisiniz.',
            'rating.max' => 'En fazla 5 puan verebilirsiniz.',
            'comment.required' => 'Yorum yazmanız gereklidir.',
            'comment.min' => 'Yorum en az 10 karakter olmalıdır.',
            'comment.max' => 'Yorum en fazla 1000 karakter olabilir.',
        ]);

        $review->update([
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
            'is_approved' => false, // Tekrar admin onayı bekleyecek
        ]);

        return redirect()->route('customer.reviews.index')
            ->with('success', 'Yorumunuz başarıyla güncellendi. Admin onayından sonra yayınlanacaktır.');
    }

    /**
     * Remove the specified review.
     */
    public function destroy(Review $review)
    {
        // Check if user owns this review
        if ($review->user_id !== Auth::id()) {
            abort(403, 'Bu yoruma erişim yetkiniz yok.');
        }

        $review->delete();

        return redirect()->route('customer.reviews.index')
            ->with('success', 'Yorumunuz başarıyla silindi.');
    }
}
