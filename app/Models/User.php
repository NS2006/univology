<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Str;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'password',
        'role_id'
    ];

    protected $with = ['role'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public static function getEmailName(string $full_name): string{
        $name_parts = explode(' ', $full_name);

        $first_name = strtolower($name_parts[0]);
        $last_name = strtolower(end($name_parts));

        return $first_name .'.'. $last_name;
    }

    public static function getDefaultPassword(string $name): string{
        return 'uni-' . Str::slug($name);
    }

    public function role(): BelongsTo{
        return $this->belongsTo(Role::class);
    }

    public function lecturer(): HasOne{
        return $this->hasOne(lecturer::class);
    }

    public function student(): HasOne{
        return $this->hasOne(Student::class);
    }

    public function activityLogs(): HasMany{
        return $this->hasMany(ActivityLog::class);
    }

    public function reports(): HasMany{
        return $this->hasMany(Report::class);
    }
}
