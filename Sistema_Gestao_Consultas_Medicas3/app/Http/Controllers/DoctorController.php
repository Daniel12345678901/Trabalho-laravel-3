<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function index()
    {
        return Doctor::all();
    }

    public function show($id)
    {
        return Doctor::findOrFail($id);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:table_users,id',
            'phone_number' => 'required|string|max:255',
            'specialization_summary' => 'required|string',
        ]);

        $doctor = Doctor::create($validatedData);

        return response()->json($doctor, 201);
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

        return response()->json($doctor);
    }

    public function destroy($id)
    {
        $doctor = Doctor::findOrFail($id);

        // Delete the associated user HAVENT TESTED
        $doctor->user()->delete();

        $doctor->delete();

        return response()->json(null, 204);
    }
}