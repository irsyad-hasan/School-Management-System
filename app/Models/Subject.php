<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subject extends Model
{
    use HasFactory;

    protected $table = 'tbl_subjects';

    protected $primaryKey = 'subject_id';

    protected $fillable = [
        'subject_name',
        'subject_code',
        'jp',
        'archived',
    ];

    protected function casts(): array
    {
        return [
            'jp' => 'integer',
            'archived' => 'boolean',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function teachers(): HasMany
    {
        return $this->hasMany(Teacher::class, 'subject_id', 'subject_id');
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class, 'subject_id', 'subject_id');
    }
}