<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\Patient;
use App\Models\Schedule;
use App\Models\Doctor;
use Illuminate\Support\Facades\Auth;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

    // Check if the user has an associated patient record
    if (!$user || !$user->patient) {
        // Handle the case where the user does not have a patient record
        return redirect()->route('home')->with('error', 'You do not have access to this resource.');
    }

    // Fetch the appointments for the authenticated patient
    $appointments = $user->patient->appointments()->with('doctor', 'department')->get();
        return view('patient.dashboard', compact('appointments'));
    }

    public function dashboard()
    {

        $user = Auth::user();

        $appointments = Appointment::with('doctor', 'department')->get();
        $notifications = $user->notifications()->latest()->get();
        // $appointments = auth()->User()->patient->appointments()->with('doctor','department')->get();

        return view('patient.dashboard',[
            'appointments'=> $appointments,
            'notifications'=> $notifications
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {


        $doctors = Doctor::all();
        $departments = Department::all();
        return view('patient.create', compact('doctors', 'departments'));

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



        Patient::create([
            'user_id' => Auth::user()->id,
            'address' => $request->address,
            'number' => $request->number,
            'age' => $request->age,
            'birth_date' => $request->birth_date,
            'gender' => $request->gender,
            'description' => $request->description
        ]);


        return redirect()->route('patient.dashboard');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {

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
        $appointment = Appointment::find($id);

        if ($appointment) {
            $appointment->delete();
            return redirect()->route('patient.appointments')->with('success', 'Appointment canceled successfully!');
        }

        return redirect()->route('patient.appointments')->with('error', 'Appointment not found.');
    }
    public function appointments()
    {
        // Fetch the authenticated patient's appointments
        $patient = Auth::user()->patient;
        $appointments = $patient->appointments()->with('doctor', 'department')->get();

        return view('patient.appointments', compact('appointments'));
    }
    public function showAvailableSchedules()
    {
       $schedules = Schedule::all();
        return view('patient.schedules', compact('schedules'));
    }
}
