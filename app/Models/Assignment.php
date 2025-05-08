<?php

namespace App\Models;

use App\Models\Question;
use App\Models\Classroom;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Assignment extends Model
{
    protected $guarded = ['id'];

    protected $with = ['classroom'];

    public function classroom(): BelongsTo{
        return $this->belongsTo(Classroom::class);
    }

    public function questions(): HasMany{
        return $this->hasMany(Question::class);
    }
}
