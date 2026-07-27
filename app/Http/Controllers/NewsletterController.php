<?php

namespace App\Http\Controllers;

use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    public function subscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:newsletter_subscribers,email'
        ], [
            'email.unique' => 'This email is already subscribed.'
        ]);

        NewsletterSubscriber::create([
            'email' => $request->email
        ]);

        return redirect()->back()->with('newsletter_success', 'Thank you for subscribing to our newsletter!');
    }
}
