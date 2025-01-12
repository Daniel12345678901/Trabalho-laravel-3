<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index()
    {
        return Room::all();
    }

    public function show($id)
    {
        return Room::findOrFail($id);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:table_rooms',
            'floor' => 'required|integer',
            'capacity' => 'required|integer',
        ]);

        $room = Room::create($validatedData);

        return response()->json($room, 201);
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

        return response()->json($room);
    }

    public function destroy($id)
    {
        $room = Room::findOrFail($id);
        $room->delete();

        return response()->json(null, 204);
    }
}