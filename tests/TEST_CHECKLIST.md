# Kemtex Test Checklist (Prioritized)

Tier 1 — High priority (Feature tests)
- `tests/Feature/AuthFlowTest.php`: registration (OTP send/verify), login/logout, password reset via phone
- `tests/Feature/PaymentPurchaseTest.php`: create Razorpay order, verify payment, webhook handling, wallet topup
- `tests/Feature/CommissionDistributionTest.php`: dispatch/execute `DistributeIncomeJob`, ensure `Income` records and `AdminEarning` are created correctly
- `tests/Feature/CartWishlistTest.php`: cart add/update/remove (AJAX JSON), wishlist toggle/remove

Tier 2 — Medium priority (Unit/Feature)
- `tests/Unit/CommissionServiceTest.php`: commission math, daily/total cap enforcement, repurchase deductions
- KYC & tickets: tests for `MemberKycController` CRUD and `Backend/KycController` approve/reject
- Withdrawals: submission, admin approve/reject, RazorpayX payout sync (mocked)

Tier 3 — Lower priority
- Product browse/detail and backend product CRUD/export
- Admin reports correctness and CSV export
- Blog/contact/pages

Mocks/Fakes & Test Utilities
- Use `RefreshDatabase` (or `RefreshDatabase` + `DB=:memory:` in `.env.testing`) for isolation
- Fake externals: `Http::fake()`, `Mail::fake()`, `Notification::fake()`, `Queue::fake()`, bind a fake `RazorpayXService` and `SmsService`

Suggested next actions
1. Implement Tier-1 tests (start with auth + payment).  
2. Create test helpers/factories for common scenarios (user with plan, plan price, sample product).  
3. Add `.env.testing` example and CI step to run `php artisan test`.
