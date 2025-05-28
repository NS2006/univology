<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminHistoryLog extends Model
{
    protected $guarded = ['id'];

    public static function createHistory(string $description){
        AdminHistoryLog::create([
            'description'=> $description
        ]);
    }
}
