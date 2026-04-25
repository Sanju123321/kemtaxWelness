<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;

class SmsService
{
    private const DEFAULT_FAST2SMS_URL = 'https://www.fast2sms.com/dev/bulkV2';

    /**
     * Validate Indian phone number in Fast2SMS format.
     */
    public function normalizeIndianPhoneForFast2Sms(string $phone): string
    {
        $normalized = preg_replace('/\D/', '', $phone);

        if (preg_match('/^\d{10}$/', $normalized)) {
            $normalized = '91' . $normalized;
        }

        if (!preg_match('/^91\d{10}$/', $normalized)) {
            throw new \InvalidArgumentException('Invalid phone number. Expected format: 91XXXXXXXXXX');
        }

        return $normalized;
    }

    /**
     * Send SMS using Fast2SMS OTP route.
     */
    public function sendOTP(string $phone, string $otp): array
    {
        $formattedPhone = $this->normalizeIndianPhoneForFast2Sms($phone);
        $payload = $this->dispatchFast2SmsRequest([
            'route' => (string) config('services.fast2sms.otp_route', 'otp'),
            'message' => "Your OTP is {$otp}",
            'variables_values' => $otp,
            'numbers' => $formattedPhone,
        ], [
            'context' => 'otp',
            'phone' => $formattedPhone,
        ]);

        Log::info('Fast2SMS OTP sent', [
            'phone' => $formattedPhone,
            'request_id' => $payload['request_id'] ?? null,
        ]);

        return $payload;
    }

    public function sendSMS(string $phone, string $message): array
    {
        $formattedPhone = $this->normalizeIndianPhoneForFast2Sms($phone);

        $params = [
            'route' => (string) config('services.fast2sms.transactional_route', 'q'),
            'message' => $message,
            'numbers' => $formattedPhone,
            'language' => 'english',
        ];

        $senderId = (string) config('services.fast2sms.sender_id', '');
        if ($senderId !== '') {
            $params['sender_id'] = $senderId;
        }

        $payload = $this->dispatchFast2SmsRequest($params, [
            'context' => 'transactional',
            'phone' => $formattedPhone,
            'message_preview' => mb_substr($message, 0, 60),
        ]);

        Log::info('Fast2SMS transactional SMS sent', [
            'phone' => $formattedPhone,
            'request_id' => $payload['request_id'] ?? null,
        ]);

        return $payload;
    }

    public function send(string $phone, string $message): bool
    {
        try {
            $this->sendSMS($phone, $message);
            return true;
        } catch (\Throwable $e) {
            Log::warning('Fast2SMS fallback send failed', [
                'phone' => $phone,
                'error' => $e->getMessage(),
            ]);
            return false;
        }
    }

    private function dispatchFast2SmsRequest(array $params, array $context = []): array
    {
        $apiKey = (string) config('services.fast2sms.api_key');
        if ($apiKey === '') {
            throw new \RuntimeException('FAST2SMS_API_KEY is not configured');
        }

        $baseUrl = (string) config('services.fast2sms.base_url', self::DEFAULT_FAST2SMS_URL);

        Log::info('Fast2SMS request payload', array_merge($context, [
            'url' => $baseUrl,
            'payload' => $params,
        ]));

        try {
            $client = new Client([
                'timeout' => 10,
                'http_errors' => false,
            ]);

            $response = $client->post($baseUrl, [
                'headers' => [
                    'authorization' => $apiKey,
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ],
                'json' => $params,
            ]);

            $statusCode = $response->getStatusCode();
            $rawBody = (string) $response->getBody();
            $payload = json_decode($rawBody, true);
            if (!is_array($payload)) {
                $payload = ['raw_body' => $rawBody];
            }

            Log::info('Fast2SMS response received', array_merge($context, [
                'status_code' => $statusCode,
                'response_body' => $rawBody,
            ]));

            if ($statusCode < 200 || $statusCode >= 300 || !((bool) ($payload['return'] ?? false))) {
                $providerMessage = (string) ($payload['message'] ?? 'Fast2SMS request failed');
                $classified = $this->classifyProviderError($providerMessage);

                throw new \RuntimeException($classified);
            }

            return [
                'success' => true,
                'status_code' => $statusCode,
                'response_body' => $rawBody,
                'response_json' => $payload,
            ];
        } catch (RequestException $e) {
            $errorBody = $e->hasResponse() ? (string) $e->getResponse()->getBody() : null;
            $errorStatus = $e->hasResponse() ? $e->getResponse()->getStatusCode() : 0;

            Log::error('Fast2SMS request exception', array_merge($context, [
                'url' => $baseUrl,
                'payload' => $params,
                'status_code' => $errorStatus,
                'response_body' => $errorBody,
                'error' => $e->getMessage(),
            ]));

            throw new \RuntimeException('Fast2SMS API request failed: ' . $e->getMessage());
        } catch (GuzzleException $e) {
            Log::error('Fast2SMS client error', array_merge($context, [
                'url' => $baseUrl,
                'payload' => $params,
                'error' => $e->getMessage(),
            ]));

            throw new \RuntimeException('Fast2SMS client error: ' . $e->getMessage());
        } catch (\Throwable $e) {
            Log::error('Fast2SMS unexpected failure', array_merge($context, [
                'url' => $baseUrl,
                'payload' => $params,
                'error' => $e->getMessage(),
            ]));

            throw $e;
        }
    }

    private function classifyProviderError(string $message): string
    {
        $lower = strtolower($message);

        if (str_contains($lower, 'ip') && str_contains($lower, 'whitelist')) {
            return 'Fast2SMS rejected request: server IP is not whitelisted for this API key.';
        }

        if (str_contains($lower, 'invalid') && str_contains($lower, 'key')) {
            return 'Fast2SMS rejected request: invalid API key.';
        }

        if (str_contains($lower, 'route')) {
            return 'Fast2SMS rejected request: invalid route. Use otp for OTP and q/transactional for regular SMS.';
        }

        return $message;
    }
}
