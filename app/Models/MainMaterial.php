<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MainMaterial extends Model
{
    protected $guarded = ['id'];


    public static function getDummyLink(){
        return "https://www.youtube.com/watch?v=rFKKSQ8GgHk";
    }
    public function course_session(): BelongsTo{
        return $this->belongsTo(CourseSession::class);
    }

    public function main_material_progress(): HasMany{
        return $this->hasMany(MainMaterialProgress::class);
    }
}
