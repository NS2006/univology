<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faculty extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function students(){
        return $this->hasMany(Student::class);
    }

    public function lecturers(){
        return $this->hasMany(lecturer::class);
    }
}
