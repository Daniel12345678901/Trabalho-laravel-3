<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index()
    {
        return response()->json(Schedule::all(), 200);
    }

    public function show($id)
    {
        try {
            $schedule = Schedule::findOrFail($id);
            return response()->json($schedule, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(["error" => "Schedule not found"], 404);
        }
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

        return response()->json(["message" => "Schedule created successfully", "schedule" => $schedule], 201);
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

        try {
            $schedule = Schedule::findOrFail($id);
            $schedule->update($validatedData);
            return response()->json(["message" => "Schedule updated successfully", "schedule" => $schedule], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(["error" => "Schedule not found"], 404);
        }
    }

    public function destroy($id)
    {
        $schedule = Schedule::findOrFail($id);
        $schedule->delete();

        try {
            $schedule = Schedule::findOrFail($id);
            $schedule->delete();
            return response()->json(["message" => "Schedule deleted successfully"], 204);
        } catch (ModelNotFoundException $e) {
            return response()->json(["error" => "Schedule not found"], 404);
        }
    }
}