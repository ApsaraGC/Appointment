<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\PatientController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
return $request->user();
})->middleware('auth:sanctum');

Route::get('/docs', function () {
    return view('swagger-ui');
});

Route::middleware('auth:sanctum')->group(function() {
Route::apiResource('patients', PatientController::class);
Route::post('logout', [AuthController::class, 'logout']);
});
//Route::apiResource('patients', PatientController::class, )->middleware('auth:sanctum');

// Route::post('/patients', [PatientController::class, 'store'])->name('patients.store');
// Route::get('/patient/create', [PatientController::class, 'create'])->name('patient.create');

Route::post('signup',[AuthController::class,'signup']);
Route::post('login',[AuthController::class,'login']);

Route::middleware('auth:sanctum')->group(function(){
Route::post('logout',[AuthController::class,'logout']);

});
