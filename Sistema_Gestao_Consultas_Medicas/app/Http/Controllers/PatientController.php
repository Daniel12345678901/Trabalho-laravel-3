<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function index()
    {
        return response()->json(Patient::all(), 200);
    }

    public function show($id)
    {
        try {
            $patient = Patient::findOrFail($id);
            return response()->json($patient, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(["error" => "Patient not found"], 404);
        }
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:table_users,id',
            'birth_date' => 'required|date',
            'gender' => 'required|in:male,female,other',
        ]);

        $patient = Patient::create($validatedData);

        return response()->json(["message" => "Patient created successfully", "patient" => $patient], 201);
    }

    public function update(Request $request, $id)
    {
        $patient = Patient::findOrFail($id);

        $validatedData = $request->validate([
            'user_id' => 'sometimes|required|exists:table_users,id',
            'birth_date' => 'sometimes|required|date',
            'gender' => 'sometimes|required|in:male,female,other',
        ]);

        $patient->update($validatedData);

        try {
            $patient = Patient::findOrFail($id);
            $patient->update($validatedData);
            return response()->json(["message" => "Patient updated successfully", "patient" => $patient], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(["error" => "Patient not found"], 404);
        }
    }

    public function destroy($id)
    {
        $patient = Patient::findOrFail($id);

        $patient->user()->delete();

        $patient->delete();

        try {
            $patient = Patient::findOrFail($id);
            $patient->user()->delete();
            $patient->delete();
            return response()->json(["message" => "Patient deleted successfully"], 204);
        } catch (ModelNotFoundException $e) {
            return response()->json(["error" => "Patient not found"], 404);
        }
    }
}