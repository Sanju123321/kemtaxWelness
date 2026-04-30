<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class PredeployChecksCommand extends Command
{
    protected $signature = 'ops:predeploy-checks {--with-tests : Run critical tests as part of checks}';

    protected $description = 'Run core pre-deploy checks for configuration, migrations, route wiring, and password hash health.';

    public function handle(): int
    {
        $checks = [
            ['label' => 'Config clear', 'command' => 'config:clear'],
            ['label' => 'Config cache', 'command' => 'config:cache'],
            ['label' => 'Migration status', 'command' => 'migrate:status'],
            ['label' => 'Route list', 'command' => 'route:list'],
            ['label' => 'Password hash audit', 'command' => 'auth:audit-hashes'],
        ];

        if ($this->option('with-tests')) {
            $checks[] = ['label' => 'Critical tests', 'command' => 'test', 'parameters' => ['--testsuite' => 'Feature']];
        }

        foreach ($checks as $check) {
            $this->line('');
            $this->info('Running: ' . $check['label']);

            $exitCode = Artisan::call($check['command'], $check['parameters'] ?? []);
            $output = trim(Artisan::output());

            if ($output !== '') {
                $this->line($output);
            }

            if ($exitCode !== 0) {
                $this->error('Failed: ' . $check['label']);
                return self::FAILURE;
            }
        }

        $this->info('Pre-deploy checks completed successfully.');
        return self::SUCCESS;
    }
}
