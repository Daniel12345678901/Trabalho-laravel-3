<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\PrescriptionController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\SpecialtyController;
use App\Http\Middleware\JwtMiddleware;

Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);

Route::middleware(['jwt.auth'])->group(function () {
    // User routes
    Route::get('users', [UserController::class, 'index']);
    Route::get('users/{id}', [UserController::class, 'show']);
    Route::post('users', [UserController::class, 'store']);
    Route::put('users/{id}', [UserController::class, 'update']);
    Route::delete('users/{id}', [UserController::class, 'destroy']);

    // Doctor routes
    Route::get('doctors', [DoctorController::class, 'index']);
    Route::get('doctors/{id}', [DoctorController::class, 'show']);
    Route::put('doctors/{id}', [DoctorController::class, 'update']);
    Route::delete('doctors/{id}', [DoctorController::class, 'destroy']);

    // Patient routes
    Route::get('patients', [PatientController::class, 'index']);
    Route::get('patients/{id}', [PatientController::class, 'show']);
    Route::put('patients/{id}', [PatientController::class, 'update']);
    Route::delete('patients/{id}', [PatientController::class, 'destroy']);

    // Room routes
    Route::get('rooms', [RoomController::class, 'index']);
    Route::get('rooms/{id}', [RoomController::class, 'show']);
    Route::post('rooms', [RoomController::class, 'store']);
    Route::put('rooms/{id}', [RoomController::class, 'update']);
    Route::delete('rooms/{id}', [RoomController::class, 'destroy']);

    // Specialty routes
    Route::get('specialties', [SpecialtyController::class, 'index']);
    Route::get('specialties/{id}', [SpecialtyController::class, 'show']);
    Route::delete('specialties/{id}', [SpecialtyController::class, 'destroy']);

    // Schedule routes
    Route::get('schedules', [ScheduleController::class, 'index']);
    Route::get('schedules/{id}', [ScheduleController::class, 'show']);
    Route::post('schedules', [ScheduleController::class, 'store']);
    Route::put('schedules/{id}', [ScheduleController::class, 'update']);
    Route::delete('schedules/{id}', [ScheduleController::class, 'destroy']);

    // Appointment routes
    Route::get('appointments', [AppointmentController::class, 'index']);
    Route::get('appointments/{id}', [AppointmentController::class, 'show']);
    Route::post('appointments', [AppointmentController::class, 'store']);
    Route::put('appointments/{id}', [AppointmentController::class, 'update']);
    Route::delete('appointments/{id}', [AppointmentController::class, 'destroy']);

    // Prescription routes
    Route::get('prescriptions', [PrescriptionController::class, 'index']);
    Route::get('prescriptions/{id}', [PrescriptionController::class, 'show']);
    Route::post('prescriptions', [PrescriptionController::class, 'store']);
    Route::put('prescriptions/{id}', [PrescriptionController::class, 'update']);
    Route::delete('prescriptions/{id}', [PrescriptionController::class, 'destroy']);
});
