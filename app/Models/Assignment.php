<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Assignment extends Model
{
    protected $casts = [
        'deadline' => 'datetime',
    ];
    
    protected $guarded = ['id'];

    protected $with = ['classroom'];

    public function classroom(): BelongsTo{
        return $this->belongsTo(Classroom::class);
    }

    public function questions(): HasMany{
        return $this->hasMany(Question::class);
    }

    public function assignment_entries(): HasMany{
        return $this->hasMany(AssignmentEntry::class);
    }

    public function isDeadlinePassed(){
        return $this->deadline
            ? now()->gt($this->deadline)
            : false;
    }

    protected static function boot(){
        parent::boot();

        static::creating(function ($model) {
            $model->assignment_id = Str::uuid();
        });
    }
}
