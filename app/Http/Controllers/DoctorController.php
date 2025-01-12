<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DoctorController extends Controller
{
    public function index()
    {
        if (Auth::user()->hasRole(1)) {
            return response()->json(Doctor::all(), 200);
        }
        return response()->json(['error' => 'Forbidden'], 403);
    }

    public function show($id)
    {
        try {
            $doctor = Doctor::findOrFail($id);
            if (Auth::user()->hasRole(1) || Auth::user()->hasRole(2)) {
                return response()->json($doctor, 200);
            }
            return response()->json(['error' => 'Forbidden'], 403);
        } catch (\Exception $e) {
            return response()->json(["error" => "Doctor not found"], 404);
        }
    }

    public function store(Request $request)
    {
        if (Auth::user()->hasRole(1)) {
            $validatedData = $request->validate([
                'user_id' => 'required|exists:table_users,id',
                'phone_number' => 'required|string|max:255',
                'specialization_summary' => 'required|string',
            ]);

            $doctor = Doctor::create($validatedData);
            return response()->json(["message" => "Doctor created successfully", "doctor" => $doctor], 201);
        }
        return response()->json(['error' => 'Forbidden'], 403);
    }

    public function update(Request $request, $id)
    {
        try {
            $doctor = Doctor::findOrFail($id);
            if (Auth::user()->hasRole(1) || Auth::user()->id === $doctor->user_id) {
                $validatedData = $request->validate([
                    'user_id' => 'sometimes|required|exists:table_users,id',
                    'phone_number' => 'sometimes|required|string|max:255',
                    'specialization_summary' => 'sometimes|required|string',
                ]);
                $doctor->update($validatedData);
                return response()->json(["message" => "Doctor updated successfully", "doctor" => $doctor], 200);
            }
            return response()->json(['error' => 'Forbidden'], 403);
        } catch (\Exception $e) {
            return response()->json(["error" => "Doctor not found"], 404);
        }
    }

    public function destroy($id)
    {
        try {
            $doctor = Doctor::findOrFail($id);
            if (Auth::user()->hasRole(1)) {
                $doctor->user()->delete();
                $doctor->delete();
                return response()->json(["message" => "Doctor deleted successfully"], 204);
            }
            return response()->json(['error' => 'Forbidden'], 403);
        } catch (\Exception $e) {
            return response()->json(["error" => "Doctor not found"], 404);
        }
    }
}