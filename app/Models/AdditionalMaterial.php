<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdditionalMaterial extends Model
{
    protected $guarded = ['id'];

    protected $with = ['classroom_session', 'material'];

    public function classroom_session(): BelongsTo{
        return $this->belongsTo(ClassroomSession::class);
    }

    public function material(): BelongsTo{
        return $this->belongsTo(Material::class);
    }
}
