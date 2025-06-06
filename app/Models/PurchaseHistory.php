<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PurchaseHistory extends Model
{
    protected $guarded = ['id'];

    protected $with = ['enrollment'];

    public function enrollment(): BelongsTo{
        return $this->belongsTo(Enrollment::class);
    }
}
