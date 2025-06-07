<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentChoice extends Model
{
    protected $guarded = ['id'];

    protected $with = ['question', 'assignment_entry', 'choice'];

    public function question(): BelongsTo{
        return $this->belongsTo(Question::class);
    }

    public function assignment_entry(): BelongsTo{
        return $this->belongsTo(AssignmentEntry::class);
    }

    public function choice(): BelongsTo{
        return $this->belongsTo(Choice::class);
    }
}
