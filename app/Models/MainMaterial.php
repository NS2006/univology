<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MainMaterial extends Model
{
    protected $guarded = ['id'];

    protected $with = ['course_session', 'material'];

    public function course_session(): BelongsTo{
        return $this->belongsTo(CourseSession::class);
    }

    public function material(): BelongsTo{
        return $this->belongsTo(Material::class);
    }
}
