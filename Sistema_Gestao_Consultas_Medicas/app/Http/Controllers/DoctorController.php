<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function index()
    {
        return response()->json(Doctor::all(), 200);
    }

    public function show($id)
    {
        try {
            $doctor = Doctor::findOrFail($id);
            return response()->json($doctor, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(["error" => "Doctor not found"], 404);
        }
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:table_users,id',
            'phone_number' => 'required|string|max:255',
            'specialization_summary' => 'required|string',
        ]);

        $doctor = Doctor::create($validatedData);

        return response()->json(["message" => "Doctor created successfully", "doctor" => $doctor], 201);
    }

    public function update(Request $request, $id)
    {
        $doctor = Doctor::findOrFail($id);

        $validatedData = $request->validate([
            'user_id' => 'sometimes|required|exists:table_users,id',
            'phone_number' => 'sometimes|required|string|max:255',
            'specialization_summary' => 'sometimes|required|string',
        ]);

        $doctor->update($validatedData);

        try {
            $doctor = Doctor::findOrFail($id);
            $doctor->update($validatedData);
            return response()->json(["message" => "Doctor updated successfully", "doctor" => $doctor], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(["error" => "Doctor not found"], 404);
        }
    }

    public function destroy($id)
    {
        $doctor = Doctor::findOrFail($id);

        $doctor->user()->delete();

        $doctor->delete();

        try {
            $doctor = Doctor::findOrFail($id);
            $doctor->user()->delete();
            $doctor->delete();
            return response()->json(["message" => "Doctor deleted successfully"], 204);
        } catch (ModelNotFoundException $e) {
            return response()->json(["error" => "Doctor not found"], 404);
        }
    }
}