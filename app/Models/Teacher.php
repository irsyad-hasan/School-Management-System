<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Teacher extends Model
{
    use HasFactory;

    protected $table = 'tbl_teachers';

    protected $primaryKey = 'teacher_id';

    protected $fillable = [
        'user_id',
        'full_name',
        'nip',
        'subject_id',
        'archived',
    ];

    protected function casts(): array
    {
        return [
            'archived' => 'boolean',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class, 'subject_id', 'subject_id');
    }

    public function homeroomClass(): HasOne
    {
        return $this->hasOne(SchoolClass::class, 'homeroom_teacher_id', 'teacher_id');
    }
}