<?php

namespace App\Services;

use App\Models\User;
use App\Models\WithdrawalRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use RuntimeException;

class RazorpayXService
{
    public function isConfigured(): bool
    {
        return filled(config('services.razorpay.x_key'))
            && filled(config('services.razorpay.x_secret'))
            && filled(config('services.razorpay.x_account_number'));
    }

    public function getPayoutSourceAccount(): string
    {
        $accountNumber = (string) config('services.razorpay.x_account_number');

        if ($accountNumber === '') {
            throw new RuntimeException('RAZORPAYX_ACCOUNT_NUMBER is not configured.');
        }

        return $accountNumber;
    }

    public function createContact(User $user): array
    {
        return $this->post('contacts', [
            'name' => Str::limit($user->name, 50, ''),
            'email' => $user->email,
            'contact' => $this->normalizeContact($user->phone),
            'type' => 'customer',
            'reference_id' => 'member_' . $user->id,
            'notes' => [
                'user_id' => (string) $user->id,
                'source' => 'kemtex_wallet_withdrawal',
            ],
        ]);
    }

    public function createBankFundAccount(string $contactId, array $bankData): array
    {
        return $this->post('fund_accounts', [
            'contact_id' => $contactId,
            'account_type' => 'bank_account',
            'bank_account' => [
                'name' => $bankData['account_holder'],
                'ifsc' => strtoupper($bankData['ifsc']),
                'account_number' => $bankData['account_number'],
            ],
        ]);
    }

    public function createPayout(WithdrawalRequest $withdrawal, string $fundAccountId, ?string $idempotencyKey = null): array
    {
        $idempotencyKey ??= (string) Str::uuid();

        $payload = [
            'account_number' => $this->getPayoutSourceAccount(),
            'fund_account_id' => $fundAccountId,
            'amount' => (int) round(((float) $withdrawal->amount) * 100),
            'currency' => 'INR',
            'mode' => 'IMPS',
            'purpose' => 'payout',
            'queue_if_low_balance' => true,
            'reference_id' => 'withdrawal_' . $withdrawal->id,
            'narration' => 'Wallet Payout',
            'notes' => [
                'withdrawal_id' => (string) $withdrawal->id,
                'user_id' => (string) $withdrawal->user_id,
            ],
        ];

        return $this->post('payouts', $payload, [
            'X-Payout-Idempotency' => $idempotencyKey,
        ]);
    }

    public function fetchPayout(string $payoutId): array
    {
        return $this->get('payouts/' . $payoutId);
    }

    private function get(string $endpoint): array
    {
        $response = $this->client()->get($endpoint);

        return $this->decodeResponse($response);
    }

    private function post(string $endpoint, array $payload, array $headers = []): array
    {
        $response = $this->client($headers)->post($endpoint, $payload);

        return $this->decodeResponse($response);
    }

    private function client(array $headers = [])
    {
        return Http::baseUrl(rtrim((string) config('services.razorpay.x_base_url', 'https://api.razorpay.com/v1'), '/'))
            ->withBasicAuth(
                (string) config('services.razorpay.x_key'),
                (string) config('services.razorpay.x_secret')
            )
            ->acceptJson()
            ->asJson()
            ->withHeaders($headers)
            ->timeout(60);
    }

    private function decodeResponse(Response $response): array
    {
        $data = $response->json();

        if ($response->successful()) {
            return is_array($data) ? $data : [];
        }

        $message = data_get($data, 'error.description')
            ?? data_get($data, 'error.reason')
            ?? $response->body();

        throw new RuntimeException('RazorpayX error: ' . $message);
    }

    private function normalizeContact(?string $phone): string
    {
        $digits = preg_replace('/\D+/', '', (string) $phone);

        if ($digits === '') {
            return '9999999999';
        }

        if (strlen($digits) > 10) {
            $digits = substr($digits, -10);
        }

        return str_pad($digits, 10, '0', STR_PAD_LEFT);
    }
}
