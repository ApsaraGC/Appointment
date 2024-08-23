<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Department;
use App\Models\Schedule;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $doctors=Doctor::paginate(10);//retrieves all doctors from dabatase

        return view('doctor.index', compact('doctors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $departments = Department::all();
        return view('doctor.create', compact('departments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        //validates the request data for creating a doctor
        $doctor_validate =  $request->validate([
            'position' => 'required|string',
            'gender' => 'required|in:Male,Female,others',
            'shift' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'experience' => 'required|integer',
            'phone_number' => 'nullable|numeric',
            'department_id' => 'required|exists:departments,id',//department ma department id hunu paro
        ]);

       //retrieves original name of upload file from request
        $name = $request->file('image')->getClientOriginalName();
        //moves uploaded file from its temporary location images folder
        $request->file('image')->move(public_path('images'), $name);

        $doctor_validate['image'] = $name;
        //add id of auth user to doctor_validate array
        $doctor_validate['user_id'] = $user->id;
        // dd($doctor_validate); dump and die
        Doctor::create($doctor_validate);
        return redirect()->route('doctor.dashboard', $user->doctor->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(Doctor $doctor)
    {
        return view('doctor.show', ['doctor' => $doctor]);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $doctor = Doctor::findOrFail($id);
        return view('doctor.edit', compact('doctor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $request->validate([
            'position' => 'required|string',
            'gender' => 'required|in:Male,Female,others',
            'shift' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'experience' => 'required|integer',
            'phone_number' => 'nullable|numeric',
        ]);

        $doctor = Doctor::findOrFail($id);//find doctor by id
        $doctor->update(['shift' => $request->shift]);

        return redirect()->route('doctor.dashboard');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function appointments()
    {
        $doctor= Auth::user()->doctor;
        //filters appoinment records where doctor_id match currrent doctor
        $appointments = Appointment::where('doctor_id', $doctor->id)
            ->with('patient', 'department')//retrieves pateint & depertment data in same query
            ->get();//executes the query and retrieves all matching appointments

        return view('doctor.appointments', compact('appointments'));
    }
    public function dashboard()
    {
        $doctor = Doctor::where('user_id', Auth::id())->with('appointments.patient', 'department')->first();

    if (!$doctor) {
        return redirect()->route('doctor.create')->with('error', 'Please complete your profile before accessing the dashboard.');
    }

    return view('doctor.dashboard', compact('doctor'));

    }
    public function findDr(Request $request)
    {
        // dd($request);

        $department_id = $request->input('department_id');
        $department_doctors = Doctor::where('department_id', $department_id)->get();
        // dd($department_doctors);
        return view('doctor.doctor', [
            'department_doctors' => $department_doctors,//list of doctor with specific department
            'patient_id' => $request->input('patient_id'),
            'department_id' => $department_id,
        ]);
    }
    public function schedule()
    {
        $doctor= Auth::user()->doctor;
        if (!$doctor) {
            abort(404, 'Doctor profile not found.');
        }
       // $doctor = auth()->user()->doctor; // Assuming Doctor model is linked to User
        $schedules = Schedule::where('doctor_id', $doctor->id)->get();
        return view('doctor.schedule', compact('schedules'));
    }
    public function storeSchedule(Request $request)
    {
        $request->validate([
            'available_from' => 'required|date',
            'available_to' => 'required|date|after:available_from',
        ]);
        $doctor = Auth::user()->doctor; // Ensure this is valid
        if (!$doctor) {
            abort(404, 'Doctor profile not found.');
        }


        Schedule::create([
            'doctor_id' => $doctor->id,
            'available_from' => $request->available_from,
            'available_to' => $request->available_to,
        ]);

        return redirect()->route('doctor.schedules')->with('success', 'Schedule added successfully.');
    }
}
