<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Villa;
use App\Models\Location;
use App\Models\Contact;

class HomeController extends Controller
{
    /**
     * Display the homepage.
     */
    public function index()
    {
        // Get featured villas
        $featuredVillas = Villa::with(['location', 'primaryImage', 'features'])
            ->active()
            ->featured()
            ->limit(6)
            ->latest()
            ->get();
            
        // Get latest villas
        $latestVillas = Villa::with(['location', 'primaryImage'])
            ->active()
            ->latest()
            ->limit(4)
            ->get();
            
        // Get popular locations
        $popularLocations = Location::with('activeVillas')
            ->popular()
            ->whereHas('activeVillas')
            ->limit(6)
            ->get();
            
        return view('home', compact('featuredVillas', 'latestVillas', 'popularLocations'));
    }

    /**
     * Display the about page.
     */
    public function about()
    {
        return view('about');
    }

    /**
     * Display the contact page.
     */
    public function contact()
    {
        // Son 3 yorumu çek
        $latestReviews = \App\Models\Review::with('user')
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        return view('contact', compact('latestReviews'));
    }

    /**
     * Handle contact form submission.
     */
    public function submitContact(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);
        
        // Save contact message to database
        Contact::create($validated);
        
        return redirect()->route('contact')->with('success', 'Mesajınız gönderildi. En kısa sürede size dönüş yapacağız.');
    }
}
