<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function index()
    {
        return Patient::all();
    }

    public function show($id)
    {
        return Patient::findOrFail($id);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:table_users,id',
            'birth_date' => 'required|date',
            'gender' => 'required|in:male,female,other',
        ]);

        $patient = Patient::create($validatedData);

        return response()->json($patient, 201);
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

        return response()->json($patient);
    }

    public function destroy($id)
    {
        $patient = Patient::findOrFail($id);

        // Delete the associated user HAVENT TESTED
        $patient->user()->delete();

        $patient->delete();

        return response()->json(null, 204);
    }
}