<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function submit(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
            'for' => 'required|string|max:255',
            'occasion' => 'nullable|string|max:255',
            'timeline' => 'nullable|string|max:255',
            'story' => 'required|string',
            'channel' => 'required|in:whatsapp,email'
        ]);

        $message = ContactMessage::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'subject' => "New Story Inquiry for " . $request->for,
            'message' => $request->story,
            'for' => $request->for,
            'occasion' => $request->occasion,
            'timeline' => $request->timeline,
            'channel' => $request->channel,
            'is_read' => false
        ]);

        // Construct handoff text
        $lines = [
            "Hello Storyloom — I'd like to begin a story.",
            "",
            "My name: " . ($request->name),
            "Email: " . ($request->email),
            "Phone: " . ($request->phone ?: '—'),
            "The story is for: " . ($request->for),
            "Occasion: " . ($request->occasion ?: '—'),
            "When I need it: " . ($request->timeline ?: 'Flexible'),
            "",
            "A little about them: " . ($request->story)
        ];
        $msgText = implode("\n", $lines);

        return response()->json([
            'success' => true,
            'channel' => $request->channel,
            'whatsapp_url' => "https://wa.me/" . setting('contact_whatsapp', '919999999999') . "?text=" . rawurlencode($msgText),
            'email_url' => "mailto:" . setting('contact_email', 'hello@storyloom.in') . "?subject=" . rawurlencode("Begin My Story — " . $request->name) . "&body=" . rawurlencode($msgText)
        ]);
    }
}
