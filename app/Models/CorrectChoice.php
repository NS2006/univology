<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CorrectChoice extends Model
{
    protected $guarded = ['id'];

    protected $with = ['choice', 'question'];

    public function choice(): BelongsTo{
        return $this->belongsTo( CorrectChoice::class,'');
    }

    public function question(): BelongsTo{
        return $this->belongsTo(Question::class);
    }
}
