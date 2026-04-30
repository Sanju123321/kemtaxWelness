# Critical Feature Smoke Matrix

## 1) Authentication / Authorization
- `GET /login` -> member login form renders.
- `POST /login` -> valid credentials redirect to `member.dashboard`.
- `POST /logout` -> session invalidated and redirect to home.
- `GET /admin/login` -> admin login form renders.
- `POST /admin/login` -> valid admin credentials redirect to `admin.dashboard`.

## 2) Payments & Wallet
- `POST /member/create-order` -> validation and auth/kyc boundary checks.
- `POST /member/verify-payment` -> rejects invalid payload and prevents duplicate writes.
- `POST /member/wallet/verify-payment` -> only captured payments are credited.
- `GET /member/wallet` -> transaction history and balances render without exceptions.

## 3) Placement & Commission
- `POST /member/placement/place` -> below-10 directs blocked.
- `POST /member/placement/place` -> non-downline parent blocked.
- `POST /member/placement/place` -> first placement succeeds, second re-placement blocked.
- Commission distribution follows `parent_id` chain for direct/level incomes.

## 4) Shopping
- `GET /products` -> product listing renders.
- `POST /cart/add` -> creates/increments cart row.
- `POST /cart/update` -> updates quantity within stock limit.
- `POST /cart/remove` -> removes item from cart.
- `POST /wishlist/toggle` and `POST /wishlist/remove` -> favorite state updates correctly.

## 5) KYC/Profile/Member Pages
- `GET /member/dashboard` -> no runtime exceptions.
- `GET /member/profile` -> update forms and sidebar render.
- `GET /member/credentials` -> certificate/milestones render.
- `GET /member/team` -> genealogy tree JSON endpoint resolves.

## Automated Coverage
- `tests/Feature/CriticalRouteSmokeTest.php`
- `tests/Feature/AuthFlowTest.php`
- `tests/Feature/PaymentPurchaseTest.php`
- `tests/Feature/CommissionDistributionTest.php`
- `tests/Feature/CartWishlistTest.php`
- `tests/Feature/PlacementControlTest.php`
- `tests/Unit/CommissionServiceTest.php`
