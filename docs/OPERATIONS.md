# Operations Guardrails

## Pre-Deploy Checklist

Run these before every deployment:

1. `php artisan ops:predeploy-checks`
2. `composer test:critical`

The pre-deploy command verifies:
- config cache is valid
- migration status can be read
- route map compiles
- password hashes in `admins` and `users` tables are valid

## Password Hash Recovery

If `/admin/login` shows hash algorithm failures:

1. Run `php artisan auth:audit-hashes`
2. For known legacy plain-text records, run `php artisan auth:audit-hashes --fix-plain`
3. Force password reset for any remaining unknown hash formats

## Runtime Monitoring

Scheduled in `routes/console.php`:

- `auth:audit-hashes` daily at 02:30
- `ops:monitor-failures` every 5 minutes

Monitor outputs:
- `storage/logs/auth-hash-audit.log`
- `storage/logs/failure-monitor.log`
- `storage/logs/laravel.log`

## Incident Rollback Basics

For payment/commission incidents:

1. Pause queue workers.
2. Export impacted `payments`, `incomes`, `admin_earnings`, and wallet balances.
3. Reconcile transaction-by-transaction.
4. Apply corrective DB transaction scripts.
5. Re-run targeted feature tests and then resume queue workers.
