<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MonitorFailuresCommand extends Command
{
    protected $signature = 'ops:monitor-failures {--lines=400 : Number of latest log lines to scan}';

    protected $description = 'Scan recent application logs for critical failure patterns.';

    public function handle(): int
    {
        $logFile = storage_path('logs/laravel.log');
        if (!is_file($logFile)) {
            $this->warn('No laravel.log file found.');
            return self::SUCCESS;
        }

        $linesToRead = max(50, (int) $this->option('lines'));
        $content = @file($logFile, FILE_IGNORE_NEW_LINES);
        if ($content === false) {
            $this->error('Unable to read laravel.log');
            return self::FAILURE;
        }

        $recent = array_slice($content, -$linesToRead);
        $patterns = [
            'failed login' => '/Invalid email or password|Too many login attempts/i',
            'payment verify failure' => '/verifyPayment|wallet top-up payment is not captured|Invalid webhook signature/i',
            'withdrawal failure' => '/withdrawal|payout|RazorpayX/i',
            'queue retry/failure' => '/failed|exception|retry/i',
        ];

        $rows = [];
        foreach ($patterns as $label => $regex) {
            $count = 0;
            foreach ($recent as $line) {
                if (preg_match($regex, $line)) {
                    $count++;
                }
            }
            $rows[] = [$label, $count];
        }

        $this->table(['Pattern', 'Matches (recent log)'], $rows);

        $hasAlerts = collect($rows)->contains(fn ($row) => $row[1] > 0);
        if ($hasAlerts) {
            $this->warn('Potential failures detected. Review storage/logs/laravel.log.');
        } else {
            $this->info('No critical failure patterns found in recent logs.');
        }

        return self::SUCCESS;
    }
}
