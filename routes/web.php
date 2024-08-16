<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientController;
use App\Models\Appointment;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// web.php
Route::middleware('auth')->group(function () {
    Route::get('/patient/appointments', [PatientController::class, 'showAppointments'])->name('patient.appointments');
    // other routes
});

Route::get('doctor/dashboard', [DoctorController::class, 'dashboard'])->name('doctor.dashboard');


// Doctor Routes
Route::get('/doctor/create', [DoctorController::class, 'create'])->name('doctor.create');
Route::post('/doctor/store', [DoctorController::class, 'store'])->name('doctor.store');
Route::get('/doctor',[DoctorController::class,'index'])->name('doctor.index');
// Route::post('/doctor',[DoctorController::class,'show'])->name('doctor.show');
Route::get('/doctor/{doctor}', [DoctorController::class, 'show'])->name('doctor.show');
//Route::get('/doctor/{doctor}/edit', [DoctorController::class, 'edit'])->name('doctor.edit');
Route::put('/doctor/{doctor}', [DoctorController::class, 'update'])->name('doctor.update');
//Route::get('/doctor/appointments/{doctorId}', [DoctorController::class, 'appointments'])->name('doctor.appointments');
Route::get('/doctor/appointments', [DoctorController::class, 'appointments'])->name('doctor.appointments');

//Route::delete('/doctor/{doctor}', [DoctorController::class, 'destroy'])->name('doctor.destroy');
Route::delete('/doctor/destroy', [DoctorController::class, 'destroy'])->name('doctor.destroy');


Route::post('doctor/find',[DoctorController::class,'findDr'])->name('appointment.doctor');
// Patient Routes
Route::get('/patient/create', [PatientController::class, 'create'])->name('patient.create');
Route::post('/patient/store', [PatientController::class, 'store'])->name('patient.store');
Route::get('/patient',[PatientController::class,'index'])->name('patient.index');
Route::get('/patient/dashboard',[PatientController::class,'dashboard'])->name('patient.dashboard');
// Route::get('/patient/appointments/{patientId}', [PatientController::class, 'appointments'])->name('patient.appointments');
Route::get('/patient/appointments', [PatientController::class, 'appointments'])->name('patient.appointments');
Route::get('/patient/appointments/{id}', [PatientController::class, 'show'])->name('patient.appointment.show');




Route::get('/appointment/create',[AppointmentController::class,'create'])->name('appointment.create');
Route::post('/appointment/store',[AppointmentController::class, 'store'])->name('appointment.store');
Route::get('/appointment/show', [AppointmentController::class, 'show'])->name('appointment.show');

//route bata department bata doctor ko id line
