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

        return response()->json(["message" => "Specialty created successfully", "specialty" => $specialty], 201);
    }

    public function index()
    {
        return response()->json(Specialty::all(), 200);
    }

    public function show($id)
    {
        try {
            $specialty = Specialty::findOrFail($id);
            return response()->json($specialty, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(["error" => "Specialty not found"], 404);
        }
    }

    public function destroy($id)
    {
        $specialty = Specialty::findOrFail($id);
        $specialty->delete();

        try {
            $specialty = Specialty::findOrFail($id);
            $specialty->delete();
            return response()->json(["message" => "Specialty deleted successfully"], 204);
        } catch (ModelNotFoundException $e) {
            return response()->json(["error" => "Specialty not found"], 404);
        }
    }
}