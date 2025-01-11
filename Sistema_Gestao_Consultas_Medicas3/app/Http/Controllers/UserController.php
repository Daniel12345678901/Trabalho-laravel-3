<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Patient;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        return User::all();
    }

    public function show($id)
    {
        return User::findOrFail($id);
    }

    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:table_users',
            'password' => 'required|string|min:8',
            'role' => 'required|in:admin,doctor,patient', // Enum validation
            'birth_date' => 'required_if:role,patient|date',
            'gender' => 'required_if:role,patient|in:male,female,other',
            'phone_number' => 'required_if:role,doctor|string|max:255',
            'specialization_summary' => 'required_if:role,doctor|string',
            'specialties' => 'required_if:role,doctor|array',
            'specialties.*' => 'exists:table_specialties,id',
        ]);

        // Create a new user record
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'role' => $validatedData['role'],
        ]);

        // Handle specific user roles (doctor, patient) based on role
        if ($validatedData['role'] == 'patient') {
            Patient::create([
                'user_id' => $user->id,
                'birth_date' => $request->input('birth_date'),
                'gender' => $request->input('gender'),
            ]);
        } elseif ($validatedData['role'] == 'doctor') {
            $doctor = Doctor::create([
                'user_id' => $user->id,
                'phone_number' => $request->input('phone_number'),
                'specialization_summary' => $request->input('specialization_summary'),
            ]);

            // Attach specialties to the doctor
            $doctor->specialties()->attach($request->input('specialties'));
        }

        return response()->json($user, 201);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|max:255|unique:table_users,email,' . $id, // Correct table name
            'password' => 'sometimes|required|string|min:8',
            'role' => 'sometimes|required|in:admin,doctor,patient',
        ]);

        if (isset($validatedData['password'])) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        }

        $user->update($validatedData);

        return response()->json($user);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(null, 204);
    }
}