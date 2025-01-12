<?php

namespace App\Http\Controllers;

use App\Models\Specialty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SpecialtyController extends Controller
{
    public function store(Request $request)
    {
        if (Auth::user()->hasRole(1)) {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
            ]);

            $specialty = Specialty::create([
                'name' => $validatedData['name'],
            ]);

            return response()->json(["message" => "Specialty created successfully", "specialty" => $specialty], 201);
        }
        return response()->json(['error' => 'Forbidden'], 403);
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
        } catch (\Exception $e) {
            return response()->json(["error" => "Specialty not found"], 404);
        }
    }

    public function destroy($id)
    {
        try {
            $specialty = Specialty::findOrFail($id);
            if (Auth::user()->hasRole(1)) {
                $specialty->delete();
                return response()->json(["message" => "Specialty deleted successfully"], 204);
            }
            return response()->json(['error' => 'Forbidden'], 403);
        } catch (\Exception $e) {
            return response()->json(["error" => "Specialty not found"], 404);
        }
    }
}