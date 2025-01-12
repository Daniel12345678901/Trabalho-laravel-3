<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index()
    {
        return response()->json(Room::all(), 200);
    }

    public function show($id)
    {
        try {
            $room = Room::findOrFail($id);
            return response()->json($room, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(["error" => "Room not found"], 404);
        }
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:table_rooms',
            'floor' => 'required|integer',
            'capacity' => 'required|integer',
        ]);

        $room = Room::create($validatedData);

        return response()->json(["message" => "Room created successfully", "room" => $room], 201);
    }

    public function update(Request $request, $id)
    {
        $room = Room::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'sometimes|required|string|max:255|unique:table_rooms,name,' . $id,
            'floor' => 'sometimes|required|integer',
            'capacity' => 'sometimes|required|integer',
        ]);

        $room->update($validatedData);

        try {
            $room = Room::findOrFail($id);
            $room->update($validatedData);
            return response()->json(["message" => "Room updated successfully", "room" => $room], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(["error" => "Room not found"], 404);
        }
    }

    public function destroy($id)
    {
        $room = Room::findOrFail($id);
        $room->delete();

        try {
            $room = Room::findOrFail($id);
            $room->delete();
            return response()->json(["message" => "Room deleted successfully"], 204);
        } catch (ModelNotFoundException $e) {
            return response()->json(["error" => "Room not found"], 404);
        }
    }
}