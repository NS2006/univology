<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Choice extends Model
{
    protected $guarded = ['id'];

    protected $with = ['question'];

    public function question(): BelongsTo{
        return $this->belongsTo(Question::class);
    }

    public function correct_choice(): HasOne{
        return $this->hasOne(CorrectChoice::class);
    }

    public function student_choices(): HasMany{
        return $this->hasMany(StudentChoice::class);
    }
}
