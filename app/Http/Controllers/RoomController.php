<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoomController extends Controller
{
    public function index()
    {
        if (Auth::user()->hasRole(1)) {
            return response()->json(Room::all(), 200);
        }
        return response()->json(['error' => 'Forbidden'], 403);
    }

    public function show($id)
    {
        try {
            $room = Room::findOrFail($id);
            if (Auth::user()->hasRole(1)) {
                return response()->json($room, 200);
            }
            return response()->json(['error' => 'Forbidden'], 403);
        } catch (\Exception $e) {
            return response()->json(["error" => "Room not found"], 404);
        }
    }

    public function store(Request $request)
    {
        if (Auth::user()->hasRole(1)) {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255|unique:table_rooms',
                'floor' => 'required|integer',
                'capacity' => 'required|integer',
            ]);

            $room = Room::create($validatedData);
            return response()->json(["message" => "Room created successfully", "room" => $room], 201);
        }
        return response()->json(['error' => 'Forbidden'], 403);
    }

    public function update(Request $request, $id)
    {
        try {
            $room = Room::findOrFail($id);
            if (Auth::user()->hasRole(1)) {
                $validatedData = $request->validate([
                    'name' => 'sometimes|required|string|max:255|unique:table_rooms,name,' . $id,
                    'floor' => 'sometimes|required|integer',
                    'capacity' => 'sometimes|required|integer',
                ]);
                $room->update($validatedData);
                return response()->json(["message" => "Room updated successfully", "room" => $room], 200);
            }
            return response()->json(['error' => 'Forbidden'], 403);
        } catch (\Exception $e) {
            return response()->json(["error" => "Room not found"], 404);
        }
    }

    public function destroy($id)
    {
        try {
            $room = Room::findOrFail($id);
            if (Auth::user()->hasRole(1)) {
                $room->delete();
                return response()->json(["message" => "Room deleted successfully"], 204);
            }
            return response()->json(['error' => 'Forbidden'], 403);
        } catch (\Exception $e) {
            return response()->json(["error" => "Room not found"], 404);
        }
    }
}