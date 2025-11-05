<?php

namespace App\Traits;

use App\Models\Log;
use Illuminate\Support\Facades\Auth;

trait Loggable
{
    public static function bootLoggable()
    {
        static::created(function ($model) {
            self::createLog('create', $model);
        });

        static::updated(function ($model) {
            self::createLog('update', $model);
        });

        static::deleted(function ($model) {
            self::createLog('delete', $model);
        });
    }

    protected static function createLog($action, $model)
    {
        $user = Auth::user();

        Log::create([
            'user_id' => $user ? $user->id : null,
            'action' => $action,
            'table_name' => $model->getTable(),
            'reference_id' => $model->id,
            'description' => self::generateDescription($action, $model),
        ]);
    }

    protected static function generateDescription($action, $model)
    {
        switch ($action) {
            case 'create':
                return "User menambahkan data baru pada tabel {$model->getTable()} dengan ID {$model->id}.";
            case 'update':
                return "User memperbarui data pada tabel {$model->getTable()} dengan ID {$model->id}.";
            case 'delete':
                return "User menghapus data dari tabel {$model->getTable()} dengan ID {$model->id}.";
            default:
                return "User melakukan aksi {$action} pada tabel {$model->getTable()} dengan ID {$model->id}.";
        }
    }
}
