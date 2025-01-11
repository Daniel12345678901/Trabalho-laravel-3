<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index()
    {
        return Appointment::all();
    }

    public function show($id)
    {
        return Appointment::findOrFail($id);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'doctor_id' => 'required|exists:table_doctors,id',
            'patient_id' => 'required|exists:table_patients,id',
            'room_id' => 'required|exists:table_rooms,id',
            'schedule_id' => 'required|exists:table_schedules,id',
            'date_time' => 'required|date_format:Y-m-d H:i:s',
            'status' => 'required|in:scheduled,completed,cancelled',
        ]);

        $appointment = Appointment::create($validatedData);

        return response()->json($appointment, 201);
    }

    public function update(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);

        $validatedData = $request->validate([
            'doctor_id' => 'sometimes|required|exists:table_doctors,id',
            'patient_id' => 'sometimes|required|exists:table_patients,id',
            'room_id' => 'sometimes|required|exists:table_rooms,id',
            'schedule_id' => 'sometimes|required|exists:table_schedules,id',
            'date_time' => 'sometimes|required|date_format:Y-m-d H:i:s',
            'status' => 'sometimes|required|in:scheduled,completed,cancelled',
        ]);

        $appointment->update($validatedData);

        return response()->json($appointment);
    }

    public function destroy($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->delete();

        return response()->json(null, 204);
    }

    public function getByPatient($patient_id)
    {
        // Fetch appointments for the given patient ID
        $appointments = Appointment::where('patient_id', $patient_id)->get();

        // Return the appointments
        if ($appointments->isEmpty()) {
            return response()->json(['message' => 'No appointments found for this patient.'], 404);
        }

        return response()->json($appointments, 200);
    }
}