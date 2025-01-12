<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    public function index()
    {
        if (Auth::user()->hasRole(1) || Auth::user()->hasRole(2) || Auth::user()->hasRole(3)) {
            return response()->json(Appointment::all(), 200);
        }
        return response()->json(['error' => 'Forbidden'], 403);
    }

    public function show($id)
    {
        try {
            $appointment = Appointment::findOrFail($id);
            if (Auth::user()->hasRole(1) || Auth::user()->hasRole(2) || Auth::user()->id === $appointment->patient_id) {
                return response()->json($appointment, 200);
            }
            return response()->json(['error' => 'Forbidden'], 403);
        } catch (\Exception $e) {
            return response()->json(["error" => "Appointment not found"], 404);
        }
    }

    public function store(Request $request)
    {
        if (Auth::user()->hasRole(1) || Auth::user()->hasRole(2) || Auth::user()->hasRole(3)) {
            $validatedData = $request->validate([
                'doctor_id' => 'required|exists:table_doctors,id',
                'patient_id' => 'required|exists:table_patients,id',
                'room_id' => 'required|exists:table_rooms,id',
                'schedule_id' => 'required|exists:table_schedules,id',
                'date_time' => 'required|date_format:Y-m-d H:i:s',
                'status' => 'required|in:scheduled,completed,cancelled',
            ]);

            $appointment = Appointment::create($validatedData);
            return response()->json(["message" => "Appointment created successfully", "appointment" => $appointment], 201);
        }
        return response()->json(['error' => 'Forbidden'], 403);
    }

    public function update(Request $request, $id)
    {
        try {
            $appointment = Appointment::findOrFail($id);
            if (Auth::user()->hasRole(1) || Auth::user()->hasRole(2) || Auth::user()->id === $appointment->patient_id) {
                $validatedData = $request->validate([
                    'doctor_id' => 'sometimes|required|exists:table_doctors,id',
                    'patient_id' => 'sometimes|required|exists:table_patients,id',
                    'room_id' => 'sometimes|required|exists:table_rooms,id',
                    'schedule_id' => 'sometimes|required|exists:table_schedules,id',
                    'date_time' => 'sometimes|required|date_format:Y-m-d H:i:s',
                    'status' => 'sometimes|required|in:scheduled,completed,cancelled',
                ]);
                $appointment->update($validatedData);
                return response()->json(["message" => "Appointment updated successfully", "appointment" => $appointment], 200);
            }
            return response()->json(['error' => 'Forbidden'], 403);
        } catch (\Exception $e) {
            return response()->json(["error" => "Appointment not found"], 404);
        }
    }

    public function destroy($id)
    {
        try {
            $appointment = Appointment::findOrFail($id);
            if (Auth::user()->hasRole(1) || Auth::user()->hasRole(2) || Auth::user()->id === $appointment->patient_id) {
                $appointment->delete();
                return response()->json(["message" => "Appointment deleted successfully"], 204);
            }
            return response()->json(['error' => 'Forbidden'], 403);
        } catch (\Exception $e) {
            return response()->json(["error" => "Appointment not found"], 404);
        }
    }

    public function getByPatient($patient_id)
    {
        if (Auth::user()->hasRole(1) || Auth::user()->hasRole(2) || Auth::user()->id === $patient_id) {
            $appointments = Appointment::where('patient_id', $patient_id)->get();
            if ($appointments->isEmpty()) {
                return response()->json(['message' => 'No appointments found for this patient.'], 404);
            }
            return response()->json($appointments, 200);
        }
        return response()->json(['error' => 'Forbidden'], 403);
    }
}