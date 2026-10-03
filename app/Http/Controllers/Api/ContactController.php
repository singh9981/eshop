<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        $contacts = Contact::latest()->get();

        return response()->json([
            'success' => true,
            'message' => 'Contact list fetched successfully',
            'data'    => $contacts,
        ], 200);
    }
    public function store(Request $request)
    {
        // Validation
        $validator = Validator::make($request->all(), [
            'website' => 'required|string|max:255',
            'name'    => 'required|string|max:255',
            'email'   => 'nullable|email|max:255',
            'phone'   => 'nullable|string',
            'message' => 'nullable|string',
            'subjact' => 'nullable|string',
            'service' => 'nullable|string',
        ]);

        // Validation failed
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors'  => $validator->errors(),
            ], 422);
        }

        // Store data
        $contact = Contact::create([
            'website' => $request->website,
            'name'    => $request->name,
            'email'   => $request->email,
            'phone'   => $request->phone,
            'message' => $request->message,
            'service' => $request->service,
            'subjact' => $request->subjact,
        ]);

        // Response
        return response()->json([
            'success' => true,
            'message' => 'Contact data saved successfully',
            'data'    => $contact,
        ], 201);
    }
    public function show($id)
    {
        $contact = Contact::find($id);

        if (!$contact) {
            return response()->json([
                'success' => false,
                'message' => 'Contact not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data'    => $contact,
        ], 200);
    }
}
