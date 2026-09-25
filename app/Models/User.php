<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'tbl_users';

    protected $primaryKey = 'user_id';

    protected $fillable = [
        'username',
        'email',
        'password',
        'role',
        'archived',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'archived' => 'boolean',
        ];
    }

    public function student(): HasOne
    {
        return $this->hasOne(Student::class, 'user_id', 'user_id');
    }

    public function teacher(): HasOne
    {
        return $this->hasOne(Teacher::class, 'user_id', 'user_id');
    }
}