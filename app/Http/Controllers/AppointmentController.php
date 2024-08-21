<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Schedule;
use App\Notifications\AppointmentRescheduled;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;


class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $appointments = Appointment::with('doctor', 'department')->get();
        // $appointments = auth()->User()->patient->appointments()->with('doctor','department')->get();
        return view('appointment.create', compact('appointments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $departments =Department::with('doctors')->get();

        $departmentId = $request->input('department_id');

        $doctors=[];
       // $doctors = $departmentId ? Doctor::where('department_id', $departmentId)->get() : Doctor::all();
        if($departmentId){
            $doctors= Doctor::where('department_id',$departmentId)->get();
        }else{

        $doctors = Doctor::all();
        }
       // dd($doctors, $departments);
        return view('appointment.create', [
            'departments' => $departments,
            'doctors' => $doctors,
            'selectedDepartmentId' => $departmentId,
        ]);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request);

        $user =Auth::user();
        $patient =Patient::find($user->patient->id);

        $appointment_validate=$request->all();
        $doctorId =$appointment_validate['doctor_id'];

        $doctor =Doctor::with('user')->find($doctorId);
        $appointment_validate['patient_id'] =$patient->id;
        Appointment::create($appointment_validate);

        return redirect()->route('patient.dashboard')->with('status',[
        //return redirect()->route('appointment.show')->with('status',[
            'message'=>'Booked Sucessfully',
            'type'=>'success'
        ]);
    }



    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        $appointment = Appointment::findOrFail($id);
        return view('appointment.show',compact('appointment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Appointment $appointment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Appointment $appointment)
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

    public function reschedule(Appointment $appointment){
        $doctor_schedule = Schedule::query()
        ->where('doctor_id', '=', $appointment->doctor_id)
        ->with('doctor')
        ->get();

    return view('appointment.reschedule', [
        'appointment' => $appointment,
        'doctor_schedule' => $doctor_schedule,
    ]);
}
    public function rescheduleStore(Request $request, Appointment $appointment)
    {
        // Validate the new date
       $request->validate([
            'date' => 'required|date|after:today',
        ]);

        // Update the appointment date
        $appointment->date_time = $request->date;
        $appointment ->save();
        // $appointment->update([
        //     'date' => $request->date,
        // ]);
        // dd(1);
        Notification::send($appointment->patient->user,new AppointmentRescheduled($appointment));
        return redirect()->route('doctor.dashboard')->with('status', [
            'message' => 'Appointment rescheduled successfully',
            'type' => 'success'
        ]);

    }
}
