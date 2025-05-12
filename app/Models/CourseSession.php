<?php

namespace App\Models;

use App\Models\MainMaterial;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CourseSession extends Model
{
    protected $guarded = ['id'];

    public function course(): BelongsTo{
        return $this->belongsTo(Course::class);
    }
    public function main_materials(): HasMany{
        return $this->hasMany(MainMaterial::class);
    }
}
