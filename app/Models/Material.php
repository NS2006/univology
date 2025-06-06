<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Material extends Model
{
    protected $guarded = ['id'];

    public static function getDummyTopic(){
        return "Dango Topic";
    }

    public static function getDummyLink(){
        return "https://www.youtube.com/watch?v=rFKKSQ8GgHk";
    }

    public function main_material(): BelongsTo{
        return $this->belongsTo(MainMaterial::class);
    }

    public function additional_material(): BelongsTo{
        return $this->belongsTo(AdditionalMaterial::class);
    }
}
