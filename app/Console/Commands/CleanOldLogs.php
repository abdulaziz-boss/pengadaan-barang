<?php

namespace App\Console\Commands;

use App\Models\Log;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log as LaravelLog; // ← tambahkan ini

class CleanOldLogs extends Command
{
    protected $signature = 'logs:clean';
    protected $description = 'Hapus 5 log tertua setiap kali dijalankan';

    public function handle()
    {
        $oldLogs = Log::orderBy('created_at', 'asc')->limit(5)->get();

        if ($oldLogs->isEmpty()) {
            $this->info('Tidak ada log yang dihapus.');

            // Log ke laravel.log
            LaravelLog::info("logs:clean dijalankan, tetapi tidak ada log yang dihapus. (" . now() . ")");
            return;
        }

        $count = $oldLogs->count();
        Log::whereIn('id', $oldLogs->pluck('id'))->delete();

        $this->info("Berhasil menghapus {$count} log tertua.");

        // Log ke laravel.log
        LaravelLog::info("logs:clean berhasil menghapus {$count} log pada " . now());
    }
}
