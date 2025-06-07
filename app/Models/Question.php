<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Question extends Model
{
    protected $guarded = ['id'];

    protected $with = ['assignment'];

    public function assignment(): BelongsTo{
        return $this->belongsTo(Assignment::class);
    }

    public function choices(): HasMany{
        return $this->hasMany(Choice::class);
    }

    public function correct_choice(): HasOne{
        return $this->hasOne(CorrectChoice::class);
    }

    public function student_choices(): HasMany{
        return $this->hasMany(StudentChoice::class);
    }

    public static function getCorrectCoin(){
        return 10;
    }

    protected static function boot(){
        parent::boot();

        static::creating(function ($model) {
            $model->question_id = Str::uuid();
        });
    }
}
