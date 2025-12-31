<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        // Son 3 yorumu çek
        $latestReviews = Review::with('user')
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        return view('contact', compact('latestReviews'));
    }

    public function send(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        // Burada mesaj gönderme işlemleri yapılacak
        // Mail::to('info@villaland.com')->send(new ContactFormMail($validated));

        return redirect()->back()->with('success', 'Mesajınız başarıyla gönderildi. En kısa sürede size dönüş yapacağız.');
    }
} 