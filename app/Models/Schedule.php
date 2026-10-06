<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Schedule extends Model
{
    use HasFactory;

    protected $table = 'tbl_schedules';
    protected $primaryKey = 'schedule_id';

    protected $fillable = [
        'class_id', 'teacher_id', 'subject_id', 'day', 'start_time', 'end_time', 'jp', 'archived',
    ];

    protected function casts(): array
    {
        return ['archived' => 'boolean'];
    }

    public function schoolClass(): BelongsTo
    { return $this->belongsTo(SchoolClass::class, 'class_id', 'class_id'); }

    public function teacher(): BelongsTo
    { return $this->belongsTo(Teacher::class, 'teacher_id', 'teacher_id'); }

    public function subject(): BelongsTo
    { return $this->belongsTo(Subject::class, 'subject_id', 'subject_id'); }
}
