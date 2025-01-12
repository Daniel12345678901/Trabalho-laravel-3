<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PatientController extends Controller
{
    public function index()
    {
        if (Auth::user()->hasRole(1)) {
            return response()->json(Patient::all(), 200);
        }
        return response()->json(['error' => 'Forbidden'], 403);
    }

    public function show($id)
    {
        try {
            $patient = Patient::findOrFail($id);
            if (Auth::user()->hasRole(1) || Auth::user()->hasRole(2) || Auth::user()->id === $patient->user_id) {
                return response()->json($patient, 200);
            }
            return response()->json(['error' => 'Forbidden'], 403);
        } catch (\Exception $e) {
            return response()->json(["error" => "Patient not found"], 404);
        }
    }

    public function store(Request $request)
    {
        if (Auth::user()->hasRole(1)) {
            $validatedData = $request->validate([
                'user_id' => 'required|exists:table_users,id',
                'birth_date' => 'required|date',
                'gender' => 'required|in:male,female,other',
            ]);

            $patient = Patient::create($validatedData);
            return response()->json(["message" => "Patient created successfully", "patient" => $patient], 201);
        }
        return response()->json(['error' => 'Forbidden'], 403);
    }

    public function update(Request $request, $id)
    {
        try {
            $patient = Patient::findOrFail($id);
            if (Auth::user()->hasRole(1) || Auth::user()->hasRole(2) || Auth::user()->id === $patient->user_id) {
                $validatedData = $request->validate([
                    'user_id' => 'sometimes|required|exists:table_users,id',
                    'birth_date' => 'sometimes|required|date',
                    'gender' => 'sometimes|required|in:male,female,other',
                ]);
                $patient->update($validatedData);
                return response()->json(["message" => "Patient updated successfully", "patient" => $patient], 200);
            }
            return response()->json(['error' => 'Forbidden'], 403);
        } catch (\Exception $e) {
            return response()->json(["error" => "Patient not found"], 404);
        }
    }

    public function destroy($id)
    {
        try {
            $patient = Patient::findOrFail($id);
            if (Auth::user()->hasRole(1)) {
                $patient->user()->delete();
                $patient->delete();
                return response()->json(["message" => "Patient deleted successfully"], 204);
            }
            return response()->json(['error' => 'Forbidden'], 403);
        } catch (\Exception $e) {
            return response()->json(["error" => "Patient not found"], 404);
        }
    }
}