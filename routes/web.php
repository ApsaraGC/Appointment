<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ScheduleController;
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
Route::get('/doctor/dashboard',[DoctorController::class,'dashboard'])->name('doctor.dashboard');
Route::get('doctor/schedule', [DoctorController::class, 'schedule'])->name('doctor.schedules');
Route::post('doctor/schedule', [DoctorController::class, 'storeSchedule'])->name('doctor.storeSchedule');
Route::get('/doctor/appointments', [DoctorController::class, 'appointments'])->name('doctor.appointments');
Route::post('doctor/find',[DoctorController::class,'findDr'])->name('appointment.doctor');
Route::get('/doctor',[DoctorController::class,'index'])->name('doctor.index');
Route::get('/doctor/{doctor}', [DoctorController::class, 'show'])->name('doctor.show');
Route::put('/doctor/{doctor}', [DoctorController::class, 'update'])->name('doctor.update');
Route::delete('/doctor/destroy', [DoctorController::class, 'destroy'])->name('doctor.destroy');


// Patient Routes
Route::get('/patient/create', [PatientController::class, 'create'])->name('patient.create');
Route::post('/patient/store', [PatientController::class, 'store'])->name('patient.store');
Route::get('/patient',[PatientController::class,'index'])->name('patient.index');
//Display dashboard
Route::get('/patient/dashboard',[PatientController::class,'dashboard'])->name('patient.dashboard');
// Route::get('/patient/appointments/{patientId}', [PatientController::class, 'appointments'])->name('patient.appointments');
Route::get('/patient/appointments', [PatientController::class, 'appointments'])->name('patient.appointments');
Route::get('/patient/appointments/{id}', [PatientController::class, 'show'])->name('patient.appointment.show');
Route::delete('/patient/appointments/{id}/cancel', [PatientController::class, 'destory'])->name('patient.appointment.destory');


Route::get('/appointment/create',[AppointmentController::class,'create'])->name('appointment.create');
Route::post('/appointment/store',[AppointmentController::class, 'store'])->name('appointment.store');
Route::get('/appointment/show', [AppointmentController::class, 'show'])->name('appointment.show');



Route::get('patient/schedules', [PatientController::class, 'showAvailableSchedules'])->name('patient.schedules');

Route::get('/appointment/{appointment}/reschedule', [AppointmentController::class, 'reschedule'])->name('appointment.reschedule');
Route::patch('/appointment/{appointment}/reschedule', [AppointmentController::class, 'rescheduleStore'])->name('appointment.rescheduleStore');

