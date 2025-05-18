<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MainMaterialProgress extends Model
{
    protected $guarded = ['id'];

    protected $with = ['enrollment', 'main_material'];

    public function enrollment(): BelongsTo{
        return $this->belongsTo(Enrollment::class);
    }

    public function main_material(): BelongsTo{
        return $this->belongsTo(MainMaterial::class);
    }
}
