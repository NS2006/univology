<?php

namespace App\Models;

use App\Models\Question;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Choice extends Model
{
    protected $guarded = ['id'];

    protected $with = ['question'];

    public function question(): BelongsTo{
        return $this->belongsTo(Question::class);
    }
}
