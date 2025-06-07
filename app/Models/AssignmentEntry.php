<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AssignmentEntry extends Model
{
    protected $guarded = ['id'];

    protected $with = ['assignment', 'enrollment'];

    public function assignment(): BelongsTo{
        return $this->belongsTo(Assignment::class);
    }

    public function enrollment(): BelongsTo{
        return $this->belongsTo(Enrollment::class);
    }

    public function student_choices(): HasMany{
        return $this->hasMany(StudentChoice::class);
    }
}
