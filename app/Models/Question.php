<?php

namespace App\Models;

use App\Models\Choice;
use App\Models\Assignment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Question extends Model
{
    protected $guarded = ['id'];

    protected $with = ['assignment'];

    public function choices(): HasMany{
        return $this->hasMany(Choice::class);
    }

    public function assignment(): BelongsTo{
        return $this->belongsTo(Assignment::class);
    }
}
