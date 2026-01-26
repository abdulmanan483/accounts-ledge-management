<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;
use Illuminate\Support\Facades\Storage;

class BackupDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'database:backup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Backup the database and exclude specific tables';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $filename = "backup-" . date('Y-m-d_H-i-s') . ".sql";
            $path = storage_path('app/backups/' . $filename);

            if (!Storage::exists('backups')) {
                Storage::makeDirectory('backups');
            }

            // Exclude "coupons" table
            $excludeTable = '--ignore-table=' . env('DB_DATABASE') . '.coupons';

            $command = sprintf('mysqldump -u%s -p%s %s %s > %s',
                env('DB_USERNAME'),
                env('DB_PASSWORD'),
                $excludeTable,
                env('DB_DATABASE'),
                $path
            );

            $process = Process::fromShellCommandline($command);
            $process->run();

            if (!$process->isSuccessful()) {
                $this->error('Backup failed: ' . $process->getErrorOutput());
                return;
            }

            $this->info('Database backup created successfully: ' . $path);

        } catch (\Exception $e) {
            $this->error('Error: ' . $e->getMessage());
        }
    }
}
