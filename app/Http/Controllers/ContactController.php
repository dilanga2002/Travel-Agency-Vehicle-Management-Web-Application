<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\ContactFormMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    public function show()
    {
        return view('contact');
    }

    public function submit(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        Log::info('Contact form submission received', $validated);

        try {
            // Send email
            Mail::to('sritravelowner@gmail.com')
                ->send(new ContactFormMail($validated));
            
            Log::info('Email sent successfully');
            return redirect()->back()->with('success', 'Your message has been sent successfully!');
            
        } catch (\Exception $e) {
            Log::error('Email sending failed: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'There was an error sending your message. Please try again later.');
        }
    }
}