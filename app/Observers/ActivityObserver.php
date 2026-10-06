<?php

namespace App\Observers;

use App\Models\User;
use App\Services\ActivityLogger;
use Illuminate\Database\Eloquent\Model;

class ActivityObserver
{
    public function created(Model $model): void
    {
        if (!auth()->check()) {
            return;
        }

        ActivityLogger::record(
            'created',
            'Menambahkan ' . self::label($model) . '.',
            $model,
        );
    }

    public function updated(Model $model): void
    {
        if (!auth()->check()) {
            return;
        }

        $changed = array_diff(array_keys($model->getChanges()), [
            'updated_at',
            'remember_token',
            'password',
            'first_login_at',
        ]);

        if ($changed === []) {
            return;
        }

        $action = ($model->getAttribute('archived') === true && $model->wasChanged('archived'))
            ? 'archived'
            : 'updated';

        $description = match ($action) {
            'archived' => 'Menonaktifkan ' . self::label($model) . '.',
            default => 'Memperbarui ' . self::label($model) . '.',
        };

        ActivityLogger::record($action, $description, $model);
    }

    public function deleted(Model $model): void
    {
        if (!auth()->check()) {
            return;
        }

        ActivityLogger::record(
            'deleted',
            'Menghapus ' . self::label($model) . '.',
            $model,
        );
    }

    private static function label(Model $model): string
    {
        return match (true) {
            $model instanceof User => 'akun pengguna ' . ($model->username ?? 'tanpa nama'),
            method_exists($model, 'getAttribute') && $model->getAttribute('full_name') => 'data ' . $model->getAttribute('full_name'),
            method_exists($model, 'getAttribute') && $model->getAttribute('class_name') => 'kelas ' . $model->getAttribute('class_name'),
            method_exists($model, 'getAttribute') && $model->getAttribute('subject_name') => 'mata pelajaran ' . $model->getAttribute('subject_name'),
            default => class_basename($model),
        };
    }
}
