<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:table_users',
            'password' => 'required|string|min:8',
            'role_id' => 'required|exists:table_roles,id',
            'birth_date' => 'required_if:role_id,3|date',
            'gender' => 'required_if:role_id,3|in:male,female,other',
            'phone_number' => 'required_if:role_id,2|string|max:255',
            'specialization_summary' => 'required_if:role_id,2|string',
            'specialties' => 'required_if:role_id,2|array',
            'specialties.*' => 'exists:table_specialties,id',
        ]);

        
        $user = DB::transaction(function () use ($request, $validatedData) {
            
            $role = Role::findOrFail($validatedData['role_id']);

            
            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
                'role_id' => $validatedData['role_id'],
            ]);

            
            if ($role->id == 3) {
                Patient::create([
                    'user_id' => $user->id,
                    'birth_date' => $request->input('birth_date'),
                    'gender' => $request->input('gender'),
                ]);
            } elseif ($role->id == 2) {
                $doctor = Doctor::create([
                    'user_id' => $user->id,
                    'phone_number' => $request->input('phone_number'),
                    'specialization_summary' => $request->input('specialization_summary'),
                ]);

                
                $doctor->specialties()->attach($request->input('specialties'));
            }

            return ['user' => $user, 'role' => $role];
        });

        
        $token = JWTAuth::claims(["role" => $user['role']->name])->fromUser($user['user']);

        return response()->json(['message' => 'User created successfully', 'user'=>$user ,'token' =>$token],201);
    }
    
    public function login(Request $request)
    {
        $credentials = $request->only("email", "password");
    
        if (!($token = JWTAuth::attempt($credentials))) {
            return response()->json(
                ["error" => "Invalid credentials"],
                401
            );
        }
    
        $user = Auth::user();
    
        $role = Role::findOrFail($user->role_id);
        $token = JWTAuth::claims(["role" => $role->name])->fromUser($user);
    
        return response()->json(['message' => 'Login successful', 'user' =>$user, 'token' =>$token],200);
    }

    public function index()
    {
        return response()->json(User::all(), 200);
    }

    public function show($id)
    {
        try {
            $user = User::findOrFail($id);
            return response()->json($user, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(["error" => "User not found"], 404);
        }
    }

    public function store(Request $request)
    {
        
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:table_users',
            'password' => 'required|string|min:8',
            'role_id' => 'required|exists:table_roles,id',
            'birth_date' => 'required_if:role_id,3|date',
            'gender' => 'required_if:role_id,3|in:male,female,other',
            'phone_number' => 'required_if:role_id,2|string|max:255',
            'specialization_summary' => 'required_if:role_id,2|string',
            'specialties' => 'required_if:role_id,2|array',
            'specialties.*' => 'exists:table_specialties,id',
        ]);

        
        $user = DB::transaction(function () use ($request, $validatedData) {
            
            $role = Role::findOrFail($validatedData['role_id']);

            
            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
                'role_id' => $validatedData['role_id'],
            ]);

            
            if ($role->id == 3) {
                Patient::create([
                    'user_id' => $user->id,
                    'birth_date' => $request->input('birth_date'),
                    'gender' => $request->input('gender'),
                ]);
            } elseif ($role->id == 2) {
                $doctor = Doctor::create([
                    'user_id' => $user->id,
                    'phone_number' => $request->input('phone_number'),
                    'specialization_summary' => $request->input('specialization_summary'),
                ]);

                
                $doctor->specialties()->attach($request->input('specialties'));
            }

            return ['user' => $user, 'role' => $role];
        });

        
        $token = JWTAuth::claims(["role" => $user['role']->name])->fromUser($user['user']);

        return response()->json(['message' => 'User created successfully', 'user'=>$user ,'token' =>$token],201);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|max:255|unique:table_users,email,' . $id,
            'password' => 'sometimes|required|string|min:8',
            'role_id' => 'sometimes|required|exists:table_roles,id',
        ]);

        if (isset($validatedData['password'])) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        }

        $user->update($validatedData);

        try {
            $user = User::findOrFail($id);
            $user->update($validatedData);
            return response()->json(["message" => "User updated successfully", "user" => $user], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(["error" => "User not found"], 404);
        }
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        $role = Role::findOrFail($user->role_id);
        if ($role->name === 'doctor') {
            $user->doctor()->delete();
        } elseif ($role->name === 'patient') {
            $user->patient()->delete();
        }

        $user->delete();

        try {
            $user = User::findOrFail($id);
            $role = Role::findOrFail($user->role_id);
            if ($role->name === 'doctor') {
                $user->doctor()->delete();
            } elseif ($role->name === 'patient') {
                $user->patient()->delete();
            }
            $user->delete();
            return response()->json(["message" => "User deleted successfully"], 204);
        } catch (ModelNotFoundException $e) {
            return response()->json(["error" => "User not found"], 404);
        }
    }
}