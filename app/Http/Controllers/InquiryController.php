<?php

namespace App\Http\Controllers;

use App\Models\Inquiry;
use Illuminate\Http\Request;

class InquiryController extends Controller
{
    public function store(Request $request)
    {
        // Validation
        $validated = $request->validate([
            'name'        => 'required|string|max:100',
            'email'       => 'required|email|max:150',
            'mobile'      => 'required|digits:10',
            'description' => 'nullable|string|max:2000',
        ]);

        // Save to DB
        Inquiry::create($validated);

        // Redirect back with success
        return redirect()->back()->with('success', 'Your inquiry has been submitted successfully!');
    }
}
