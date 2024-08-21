<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Schedule;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    //
    public function create(){
        $doctors =Doctor::all();
        return view('schedules.create',compact('doctors'));

    }
      // Store a newly created schedule in storage
      public function store(Request $request)
      {
          $request->validate([
              'doctor_id' => 'required|exists:doctors,id',
              'available_from' => 'required|date',
              'available_to' => 'required|date|after:available_from',
          ]);

          Schedule::create($request->all());

          return redirect()->route('schedules.create')->with('success', 'Schedule added successfully.');
      }

      // Display a listing of the schedule
      public function index()
      {
          $schedules = Schedule::with('doctor')->get();
          return view('schedules.index', compact('schedules'));
      }

      // Show available schedules for patients to choose
      public function showAvailable()
      {
          $schedules = Schedule::with('doctor')->where('available_from', '>', now())->get();
          return view('schedules.show', compact('schedules'));
      }
}
