<?php

namespace App\Http\Controllers;

use App\Models\Prescription;
use Illuminate\Http\Request;

class PrescriptionController extends Controller
{
    public function index()
    {
        return response()->json(Prescription::all(), 200);
    }

    public function show($id)
    {
        try {
            $prescription = Prescription::findOrFail($id);
            return response()->json($prescription, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(["error" => "Prescription not found"], 404);
        }
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'appointment_id' => 'required|exists:table_appointments,id',
            'description' => 'required|string',
        ]);

        $prescription = Prescription::create($validatedData);

        return response()->json(["message" => "Prescription created successfully", "prescription" => $prescription], 201);
    }

    public function update(Request $request, $id)
    {
        $prescription = Prescription::findOrFail($id);

        $validatedData = $request->validate([
            'appointment_id' => 'sometimes|required|exists:table_appointments,id',
            'description' => 'sometimes|required|string',
        ]);

        $prescription->update($validatedData);

        try {
            $prescription = Prescription::findOrFail($id);
            $prescription->update($validatedData);
            return response()->json(["message" => "Prescription updated successfully", "prescription" => $prescription], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(["error" => "Prescription not found"], 404);
        }
    }

    public function destroy($id)
    {
        $prescription = Prescription::findOrFail($id);
        $prescription->delete();

        try {
            $prescription = Prescription::findOrFail($id);
            $prescription->delete();
            return response()->json(["message" => "Prescription deleted successfully"], 204);
        } catch (ModelNotFoundException $e) {
            return response()->json(["error" => "Prescription not found"], 404);
        }
    }
}