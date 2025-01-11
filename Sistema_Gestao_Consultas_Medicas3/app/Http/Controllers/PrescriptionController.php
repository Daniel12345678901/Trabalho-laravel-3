<?php

namespace App\Http\Controllers;

use App\Models\Prescription;
use Illuminate\Http\Request;

class PrescriptionController extends Controller
{
    public function index()
    {
        return Prescription::all();
    }

    public function show($id)
    {
        return Prescription::findOrFail($id);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'appointment_id' => 'required|exists:table_appointments,id',
            'description' => 'required|string',
        ]);

        $prescription = Prescription::create($validatedData);

        return response()->json($prescription, 201);
    }

    public function update(Request $request, $id)
    {
        $prescription = Prescription::findOrFail($id);

        $validatedData = $request->validate([
            'appointment_id' => 'sometimes|required|exists:table_appointments,id',
            'description' => 'sometimes|required|string',
        ]);

        $prescription->update($validatedData);

        return response()->json($prescription);
    }

    public function destroy($id)
    {
        $prescription = Prescription::findOrFail($id);
        $prescription->delete();

        return response()->json(null, 204);
    }
}