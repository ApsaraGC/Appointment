<?php

namespace App\Models;//used to group related classes and avoid name conflicts

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;
    //method create() or update() use in bulk
    protected $fillable = ['patient_id', 'doctor_id', 'department_id', 'status', 'date_time'];

    public function patient()
    {//each appointment is associated with one patient
        return $this->belongsTo(Patient::class);
    }

    public function doctor()
    {
        //belongTo=many to one
        return $this->belongsTo(Doctor::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
