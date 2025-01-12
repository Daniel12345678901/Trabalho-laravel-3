<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index()
    {
        return Schedule::all();
    }

    public function show($id)
    {
        return Schedule::findOrFail($id);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'doctor_id' => 'required|exists:table_doctors,id',
            'room_id' => 'required|exists:table_rooms,id',
            'day_of_week' => 'required|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
        ]);

        $schedule = Schedule::create($validatedData);

        return response()->json($schedule, 201);
    }

    public function update(Request $request, $id)
    {
        $schedule = Schedule::findOrFail($id);

        $validatedData = $request->validate([
            'doctor_id' => 'sometimes|required|exists:table_doctors,id',
            'room_id' => 'sometimes|required|exists:table_rooms,id',
            'day_of_week' => 'sometimes|required|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
            'start_time' => 'sometimes|required|date_format:H:i',
            'end_time' => 'sometimes|required|date_format:H:i',
        ]);

        $schedule->update($validatedData);

        return response()->json($schedule);
    }

    public function destroy($id)
    {
        $schedule = Schedule::findOrFail($id);
        $schedule->delete();

        return response()->json(null, 204);
    }
}