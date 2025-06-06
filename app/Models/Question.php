<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    protected static function boot(){
        parent::boot();

        static::creating(function ($model) {
            $model->question_id = Str::uuid();
        });
    }
}
