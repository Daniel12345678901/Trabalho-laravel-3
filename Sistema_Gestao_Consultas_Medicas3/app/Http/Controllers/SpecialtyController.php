<?php

namespace App\Http\Controllers;

use App\Models\Specialty;
use Illuminate\Http\Request;

class SpecialtyController extends Controller
{
    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Create a new specialty record
        $specialty = Specialty::create([
            'name' => $validatedData['name'],
        ]);

        return response()->json($specialty, 201);
    }

    public function index()
    {
        return Specialty::all();
    }

    public function show($id)
    {
        return Specialty::findOrFail($id);
    }

    public function destroy($id)
    {
        $specialty = Specialty::findOrFail($id);
        $specialty->delete();

        return response()->json(null, 204);
    }
}