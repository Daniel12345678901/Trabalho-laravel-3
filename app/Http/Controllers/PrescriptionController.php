<?php

namespace App\Http\Controllers;

use App\Models\Prescription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PrescriptionController extends Controller
{
    public function index()
    {
        if (Auth::user()->hasRole(1) || Auth::user()->hasRole(2) || Auth::user()->hasRole(3)) {
            return response()->json(Prescription::all(), 200);
        }
        return response()->json(['error' => 'Forbidden'], 403);
    }

    public function show($id)
    {
        try {
            $prescription = Prescription::findOrFail($id);
            if (Auth::user()->hasRole(1) || Auth::user()->hasRole(2) || Auth::user()->hasRole(3)) {
                return response()->json($prescription, 200);
            }
            return response()->json(['error' => 'Forbidden'], 403);
        } catch (\Exception $e) {
            return response()->json(["error" => "Prescription not found"], 404);
        }
    }

    public function store(Request $request)
    {
        if (Auth::user()->hasRole(1) || Auth::user()->hasRole(2)) {
            $validatedData = $request->validate([
                'appointment_id' => 'required|exists:table_appointments,id',
                'description' => 'required|string',
            ]);

            $prescription = Prescription::create($validatedData);
            return response()->json(["message" => "Prescription created successfully", "prescription" => $prescription], 201);
        }
        return response()->json(['error' => 'Forbidden'], 403);
    }

    public function update(Request $request, $id)
    {
        try {
            $prescription = Prescription::findOrFail($id);
            if (Auth::user()->hasRole(1) || Auth::user()->hasRole(2)) {
                $validatedData = $request->validate([
                    'appointment_id' => 'sometimes|required|exists:table_appointments,id',
                    'description' => 'sometimes|required|string',
                ]);
                $prescription->update($validatedData);
                return response()->json(["message" => "Prescription updated successfully", "prescription" => $prescription], 200);
            }
            return response()->json(['error' => 'Forbidden'], 403);
        } catch (\Exception $e) {
            return response()->json(["error" => "Prescription not found"], 404);
        }
    }

    public function destroy($id)
    {
        try {
            $prescription = Prescription::findOrFail($id);
            if (Auth::user()->hasRole(1) || Auth::user()->hasRole(2)) {
                $prescription->delete();
                return response()->json(["message" => "Prescription deleted successfully"], 204);
            }
            return response()->json(['error' => 'Forbidden'], 403);
        } catch (\Exception $e) {
            return response()->json(["error" => "Prescription not found"], 404);
        }
    }
}