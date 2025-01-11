<?php

namespace App\Http\Controllers;

use App\Models\Specialty;
use Illuminate\Http\Request;

class SpecialtyController extends Controller
{
    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Create a new specialty record
        $specialty = Specialty::create([
            'name' => $validatedData['name'],
        ]);

        return response()->json($specialty, 201);
    }
    
    public function update(Request $request, $id)
    {
        $specialty = Specialty::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'sometimes|required|string|max:255|unique:table_specialties,name,' . $id,
        ]);

        $specialty->update($validatedData);

        return response()->json($specialty);
    }

    public function destroy($id)
    {
        $specialty = Specialty::findOrFail($id);
        $specialty->delete();

        return response()->json(null, 204);
    }
}