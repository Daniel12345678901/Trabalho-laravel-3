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

/*


THIS IS AN EXAMPLE OF HOW TO USE JWT AUTHENTICATION
Route::middleware([JwtMiddleware::class])->group(function () {
    Route::get('users', [UserController::class, 'index']);
    Route::get('users/{id}', [UserController::class, 'show']);
    Route::post('users', [UserController::class, 'store']);
    Route::put('users/{id}', [UserController::class, 'update']);
    Route::delete('users/{id}', [UserController::class, 'destroy']);
});

*/

// MAKE IT SO THAT IF YOU DELETE A DOCTOR OR A PATIENT, YOU DELETE THE USER TOO AND VICE VERSA
// (IT'S DONE BUT NOT TESTED)

// User routes
Route::get('users', [UserController::class, 'index']); //works
Route::get('users/{id}', [UserController::class, 'show']); //works
Route::post('users', [UserController::class, 'store']); //works
Route::put('users/{id}', [UserController::class, 'update']); //works
Route::delete('users/{id}', [UserController::class, 'destroy']); //works

// Doctor routes
Route::get('doctors', [DoctorController::class, 'index']); //works
Route::get('doctors/{id}', [DoctorController::class, 'show']); //works
Route::put('doctors/{id}', [DoctorController::class, 'update']);; //works
Route::delete('doctors/{id}', [DoctorController::class, 'destroy']); //works

// Patient routes
Route::get('patients', [PatientController::class, 'index']); //works
Route::get('patients/{id}', [PatientController::class, 'show']); //works
Route::put('patients/{id}', [PatientController::class, 'update']);; //works
Route::delete('patients/{id}', [PatientController::class, 'destroy']); //works

// Room routes
Route::get('rooms', [RoomController::class, 'index']); //works
Route::get('rooms/{id}', [RoomController::class, 'show']); //works
Route::post('rooms', [RoomController::class, 'store']); //works
Route::put('rooms/{id}', [RoomController::class, 'update']); //works
Route::delete('rooms/{id}', [RoomController::class, 'destroy']); //works

// Specialty routes
Route::get('specialties', [SpecialtyController::class, 'index']); //works
Route::get('specialties/{id}', [SpecialtyController::class, 'show']); //works
Route::delete('specialties/{id}', [SpecialtyController::class, 'destroy']); //works

// Schedule routes
Route::get('schedules', [ScheduleController::class, 'index']); //works
Route::get('schedules/{id}', [ScheduleController::class, 'show']); //works
Route::post('schedules', [ScheduleController::class, 'store']); //works
Route::put('schedules/{id}', [ScheduleController::class, 'update']); //works
Route::delete('schedules/{id}', [ScheduleController::class, 'destroy']); //works

// Appointment routes
Route::get('appointments', [AppointmentController::class, 'index']); //works
Route::get('appointments/{id}', [AppointmentController::class, 'show']); //works
Route::post('appointments', [AppointmentController::class, 'store']); //works
Route::put('appointments/{id}', [AppointmentController::class, 'update']); //works
Route::delete('appointments/{id}', [AppointmentController::class, 'destroy']); //works

// Prescription routes
Route::get('prescriptions', [PrescriptionController::class, 'index']); //works
Route::get('prescriptions/{id}', [PrescriptionController::class, 'show']); //works
Route::post('prescriptions', [PrescriptionController::class, 'store']); //works
Route::put('prescriptions/{id}', [PrescriptionController::class, 'update']); //works
Route::delete('prescriptions/{id}', [PrescriptionController::class, 'destroy']); //works
