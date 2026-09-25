<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Student extends Model
{
    use HasFactory;

    protected $table = 'tbl_students';

    protected $primaryKey = 'student_id';

    protected $fillable = [
        'user_id',
        'full_name',
        'nis',
        'class_id',
        'date_of_birth',
        'archived',
    ];

    protected function casts(): array
    {
        return [
            'date_of_birth' => 'date',
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

    public function schoolClass(): BelongsTo
    {
        return $this->belongsTo(
            SchoolClass::class,
            'class_id',
            'class_id'
        );
    }
}