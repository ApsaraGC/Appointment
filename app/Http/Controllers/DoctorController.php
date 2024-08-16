<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Department;
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
        return view('doctor.appointments', compact('appointments'));
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
        $request->validate([
            'position' => 'required|string',
            'gender' => 'required|in:Male,Female,others',
            'shift' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'experience' => 'required|integer',
            'phone_number' => 'nullable|numeric',
            'department_id'=>'required|exists:departments,id',
        ]);
        // dd($request);

        $name = $request->file('image')->getClientOriginalName();
        $request->file('image')->move(public_path('images'), $name);
        $doctor_validate['image'] = $name;
        // dd($doctor_validate);

        Doctor::create($doctor_validate);
        //return redirect()->route('doctor.index');
        Doctor::create([
            'user_id' => $user->id,
            'position' => $request->position,
            'gender' => $request->gender,
            'shift' => $request->shift,
            'image' => $request->image,
            'experience' => $request->experience,
            'phone_number' => $request->phone_number,
            'department_id' => $request->department,
            
        ]);

        return redirect()->route('doctor.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Doctor $doctor)
    {
        // dd($doctor);
        return view('doctor.show',['doctor'=>$doctor]);
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
    public function dashboard(){
        $doctor = Appointment::with('patient', 'department')->get();
        // $appointments = auth()->User()->patient->appointments()->with('doctor','department')->get();
        return view('patient.dashboard', compact('doctor'));

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

}
