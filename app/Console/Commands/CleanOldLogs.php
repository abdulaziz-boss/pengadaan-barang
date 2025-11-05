<?php

namespace App\Console\Commands;

use App\Models\Log;
use Illuminate\Console\Command;

class CleanOldLogs extends Command
{
    protected $signature = 'logs:clean';
    protected $description = 'Hapus 5 log tertua setiap kali dijalankan';

    public function handle()
    {
        $oldLogs = Log::orderBy('created_at', 'asc')->limit(5)->get();

        if ($oldLogs->isEmpty()) {
            $this->info('Tidak ada log yang dihapus.');
            return;
        }

        $count = $oldLogs->count();
        Log::whereIn('id', $oldLogs->pluck('id'))->delete();

        $this->info("Berhasil menghapus {$count} log tertua.");
    }
}
