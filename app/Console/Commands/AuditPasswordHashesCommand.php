<?php

namespace App\Console\Commands;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class AuditPasswordHashesCommand extends Command
{
    protected $signature = 'auth:audit-hashes {--fix-plain : Re-hash plain-text passwords when value equals provided plain password field}';

    protected $description = 'Audit admin/user password hash formats and optionally repair legacy plain-text records.';

    public function handle(): int
    {
        $this->info('Auditing password hashes...');

        $adminStats = $this->auditModel(Admin::class, 'admins');
        $userStats = $this->auditModel(User::class, 'users');

        $this->table(
            ['Model', 'Total', 'Bcrypt', 'Argon2id', 'Unknown', 'Rehashed'],
            [
                ['admins', ...array_values($adminStats)],
                ['users', ...array_values($userStats)],
            ]
        );

        if ($adminStats['unknown'] > 0 || $userStats['unknown'] > 0) {
            $this->warn('Unknown password formats were detected. Force password reset for those accounts.');
            return self::FAILURE;
        }

        $this->info('Password hash audit completed successfully.');
        return self::SUCCESS;
    }

    private function auditModel(string $modelClass, string $label): array
    {
        $stats = [
            'total' => 0,
            'bcrypt' => 0,
            'argon2id' => 0,
            'unknown' => 0,
            'rehashed' => 0,
        ];

        $fixPlain = (bool) $this->option('fix-plain');

        $modelClass::query()->select('id', 'password')->chunkById(200, function ($rows) use (&$stats, $fixPlain, $label, $modelClass) {
            foreach ($rows as $row) {
                $stats['total']++;
                $password = (string) $row->password;
                $algo = $this->algoName($password);

                if ($algo === 'bcrypt') {
                    $stats['bcrypt']++;
                    continue;
                }

                if ($algo === 'argon2id') {
                    $stats['argon2id']++;
                    continue;
                }

                if ($fixPlain && $password !== '' && !$this->looksHashed($password)) {
                    $modelClass::query()->whereKey($row->id)->update([
                        'password' => Hash::make($password),
                    ]);
                    $stats['rehashed']++;
                    $stats['bcrypt']++;
                    $this->line("Rehashed plain password for {$label} id={$row->id}");
                    continue;
                }

                $stats['unknown']++;
            }
        });

        return $stats;
    }

    private function algoName(string $hash): string
    {
        $info = password_get_info($hash);
        return (string) ($info['algoName'] ?? 'unknown');
    }

    private function looksHashed(string $value): bool
    {
        return str_starts_with($value, '$2y$')
            || str_starts_with($value, '$2a$')
            || str_starts_with($value, '$2b$')
            || str_starts_with($value, '$argon2id$')
            || str_starts_with($value, '$argon2i$');
    }
}
