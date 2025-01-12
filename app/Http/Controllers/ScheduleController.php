<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends Controller
{
    public function index()
    {
        if (Auth::user()->hasRole(1)) {
            return response()->json(Schedule::all(), 200);
        }
        return response()->json(['error' => 'Forbidden'], 403);
    }

    public function show($id)
    {
        try {
            $schedule = Schedule::findOrFail($id);
            if (Auth::user()->hasRole(1) || Auth::user()->hasRole(2)) {
                return response()->json($schedule, 200);
            }
            return response()->json(['error' => 'Forbidden'], 403);
        } catch (\Exception $e) {
            return response()->json(["error" => "Schedule not found"], 404);
        }
    }

    public function store(Request $request)
    {
        if (Auth::user()->hasRole(1)) {
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
        return response()->json(['error' => 'Forbidden'], 403);
    }

    public function update(Request $request, $id)
    {
        try {
            $schedule = Schedule::findOrFail($id);
            if (Auth::user()->hasRole(1) || Auth::user()->hasRole(2)) {
                $validatedData = $request->validate([
                    'doctor_id' => 'sometimes|required|exists:table_doctors,id',
                    'room_id' => 'sometimes|required|exists:table_rooms,id',
                    'day_of_week' => 'sometimes|required|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
                    'start_time' => 'sometimes|required|date_format:H:i',
                    'end_time' => 'sometimes|required|date_format:H:i',
                ]);
                $schedule->update($validatedData);
                return response()->json(["message" => "Schedule updated successfully", "schedule" => $schedule], 200);
            }
            return response()->json(['error' => 'Forbidden'], 403);
        } catch (\Exception $e) {
            return response()->json(["error" => "Schedule not found"], 404);
        }
    }

    public function destroy($id)
    {
        try {
            $schedule = Schedule::findOrFail($id);
            if (Auth::user()->hasRole(1)) {
                $schedule->delete();
                return response()->json(["message" => "Schedule deleted successfully"], 204);
            }
            return response()->json(['error' => 'Forbidden'], 403);
        } catch (\Exception $e) {
            return response()->json(["error" => "Schedule not found"], 404);
        }
    }
}