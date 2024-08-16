<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\Patient;
use App\Models\Doctor;
use Illuminate\Support\Facades\Auth;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $appointments = Appointment::with('doctor', 'department')->get();
        // $appointments = auth()->User()->patient->appointments()->with('doctor','department')->get();
        return view('patient.dashboard', compact('appointments'));
    }

    public function dashboard(){
        $appointments = Appointment::with('doctor', 'department')->get();
        // $appointments = auth()->User()->patient->appointments()->with('doctor','department')->get();
        return view('patient.dashboard', compact('appointments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        //
        // Fetch doctors and departments to display in the form
        $doctors = Doctor::all();
        $departments = Department::all();
        return view('patient.create', compact('doctors', 'departments'));
        // return view('patient.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $patient =        $request->validate([
            'address' => 'required|string|max:100',
            'number' => 'required|string',
            'age' => 'required|integer',
            'birth_date' => 'required|date',
            'gender' => 'required|in:male,female,others',
            'description' => 'nullable|string'
        ]);

        // dd($patient);

        Patient::create([
            'user_id' => Auth::user()->id,
            'address' => $request->address,
            'number' => $request->number,
            'age' => $request->age,
            'birth_date' => $request->birth_date,
            'gender' => $request->gender,
            'description' => $request->description
        ]);


        return redirect()->route('patient.index');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        // $patient = Patient::findOrFail($id); // Find the patient by ID
        // return view('patient.show', compact('patient'));
        $appointment = Appointment::with('doctor', 'department')->findOrFail($id);

        // Optionally, check if the appointment belongs to the authenticated patient
        if (Auth::user()->patient->id != $appointment->patient_id) {
            abort(403, 'Unauthorized action.');
        }

        return view('patient.appointment.show', compact('appointment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $patient = Patient::findOrFail($id); // Find the patient by ID
        return view('patient.edit', compact('patient'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $request->validate([
            'address' => 'required|string|max:100',
            'number' => 'required|numeric',
            'age' => 'required|integer',
            'birth_date' => 'required|date',
            'gender' => 'required|in:female,male,others',
            'description' => 'nullable|string'
        ]);

        $patient = Patient::findOrFail($id); // Find the patient by ID
        $patient->update($request->all());

        return redirect()->route('patient.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $appointment = Appointment::findOrFail($id); // Find the appointment by ID
        $appointment->delete();

        return redirect()->route('patient.appointments');
    }
    public function appointments()
{
    // Fetch the authenticated patient's appointments
    $patient = Auth::user()->patient;
    $appointments = $patient->appointments()->with('doctor', 'department')->get();

    return view('patient.appointments', compact('appointments'));
}
}
