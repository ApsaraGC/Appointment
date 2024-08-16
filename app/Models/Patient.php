<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;
    protected $guarded =[];
    // protected $fillable =['user_id','address','number','age','birth_date','gender','description'];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function appointment(){
        return $this->hasMany(Appointment::class);
    }
}
