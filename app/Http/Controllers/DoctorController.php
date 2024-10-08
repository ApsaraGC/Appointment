<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Department;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        // $doctor = auth()->user()->doctor;
        // $appointments = $doctor->appointments()->with('patient', 'department')->get();
        // return view('doctor.appointments', compact('appointments'));

        $appointments = Appointment::with('patient', 'department')->get();
        // return view('doctor.appointments', compact('appointments'));
        return view('doctor.dashboard', compact('dashboard'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        // $doctors= Doctor::all();
        $departments = Department::all();
        return view('doctor.create', compact('departments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $doctor_validate =  $request->validate([
            'position' => 'required|string',
            'gender' => 'required|in:Male,Female,others',
            'shift' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'experience' => 'required|integer',
            'phone_number' => 'nullable|numeric',
            'department_id' => 'required|exists:departments,id',
        ]);
        // dd($request);

        $name = $request->file('image')->getClientOriginalName();
        $request->file('image')->move(public_path('images'), $name);
        $doctor_validate['image'] = $name;
        $doctor_validate['user_id'] = $user->id;
        // dd($doctor_validate);

        Doctor::create($doctor_validate);

        return redirect()->route('doctor.appointments', $user->doctor->id);
        // return redirect()->route('doctor.dashboard', $user->doctor->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(Doctor $doctor)
    {
        // dd($doctor);
        return view('doctor.show', ['doctor' => $doctor]);
        //$doctor = Doctor::findOrFail($id);

        //return view('doctor.show',compact('doctor'));
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

        $doctor = Doctor::findOrFail($id);
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
    public function appointments($doctorId)
    {
        // Retrieve appointments where the doctor is assigned
        $appointments = Appointment::where('doctor_id', $doctorId)
            ->with('patient', 'department')
            ->get();
        return view('doctor.appointments', compact('appointments'));
    }
    public function dashboard()
    {
        $doctor = Doctor::query()->where('user_id', '=', Auth::id())->with('user', 'department', 'appointments')->first();
        // $appointments = auth()->User()->patient->appointments()->with('doctor','department')->get();
        return view('doctor.dashboard', compact('doctor'));

        // $user=Auth::user();
        // $doctor =Doctor::where('user_id',$user->id)->firstOrFail();
        // $appointments =Appointment::where('doctor_id',$doctor->id)->get();

        // $today = now()->startOfDay();
        // $tommorrow =now()->addDay()->startOfDay();

        // $todayAppointments =[];
        // $previousAppointments=[];

        // foreach($appointments as $appointment){
        //     if($appointment->date->isSameDay($today)){
        //         $todayAppointments[]= $appointment;
        //     }else{
        //         $previousAppointments[]=$appointment;
        //     }
        // }
        // return view('doctor.dashboard',[
        //     'doctor'=>$doctor,
        //     'todatAppointments'=>$todayAppointments,
        //     'previousAppointments'=>$previousAppointments
        // ]);
    }
    public function findDr(Request $request)
    {
        // dd($request);

        $department_id = $request->input('department_id');
        $department_doctors = Doctor::where('department_id', $department_id)->get();
        // dd($department_doctors);
        return view('doctor.doctor', [
            'department_doctors' => $department_doctors,
            'patient_id' => $request->input('patient_id'),
            'department_id' => $department_id,
        ]);
    }
}
