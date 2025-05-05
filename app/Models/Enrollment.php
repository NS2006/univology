<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Enrollment extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $with = ['student', 'classroom'];

    public function student(): BelongsTo{
        return $this->belongsTo(Student::class);
    }

    public function classroom(): BelongsTo{
        return $this->belongsTo(Classroom::class);
    }
}
