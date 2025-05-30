<?php

namespace App\Models;

use App\Models\Course;
use App\Models\MainMaterial;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CourseSession extends Model
{
    protected $guarded = ['id'];

    protected $with = ['course'];

    public static function createDummySession(Course $c){
        for($i = 1; $i <= $c->credit * 6; $i++){
            $courseSession = CourseSession::create([
                'session_number' => $i,
                'course_id' => $c->id,
                'title' => CourseSession::getDummyTitle() . ' ' . $i,
            ]);

            $material = Material::create([
                'link' => Material::getDummyLink(),
                'topic' => Material::getDummyTopic()
            ]);

            MainMaterial::create( [
                'course_session_id' => $courseSession->id,
                'material_id' => $material->id
            ]);
        }
    }

    public static function getDummyTitle(){
        return 'Dango Daikazoku';
    }

    public function course(): BelongsTo{
        return $this->belongsTo(Course::class);
    }

    public function classroom_sessions(): HasMany{
        return $this->hasMany(ClassroomSession::class);
    }

    public function main_materials(): HasMany{
        return $this->hasMany(MainMaterial::class);
    }
}
