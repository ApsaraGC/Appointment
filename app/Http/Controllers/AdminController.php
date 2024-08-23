<?php

namespace App\Http\Controllers;

use App\Models\Doctor;

use App\Models\Patient;

use App\Models\Appointment;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $totalDoctor = Doctor::count();
        $totalPatient = Patient::count();
        $totalAppointment = Appointment::count();

        // Pass the counts to the view
        return view('admin.dashboard', compact('totalDoctor', 'totalPatient', 'totalAppointment'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

         // Validate and store data here
    $validatedData = $request->validate([

    ]);

    // Assuming you are creating a new Doctor record
    Doctor::create($validatedData);

    // Redirect to a specific route with a success message
    return redirect()->route('doctor.index')->with('status', 'Doctor created successfully!');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function adminDoctor(Doctor $doctor ){
        return view('admin.doctor', compact('doctor'));

    }
}
