<?php

namespace App\Services;

use Twilio\Rest\Client;

class SmsService
{
    protected $twilio;

    public function __construct()
    {
        $this->twilio = new Client(
            config('services.twilio.sid'),
            config('services.twilio.token')
        );
    }

    /**
     * Format Indian phone number with country code
     * Accepts formats: 9876543210, +919876543210, 91-9876543210
     */
    public function formatIndianPhone($phone)
    {
        // Remove all non-digit characters except leading +
        $phone = preg_replace('/[^\d+]/', '', $phone);

        // Remove leading +
        $phone = ltrim($phone, '+');

        // If it starts with 91, it's already country code
        if (strpos($phone, '91') === 0 && strlen($phone) === 12) {
            return '+' . $phone;
        }

        // If it's 10 digits (Indian number without country code)
        if (strlen($phone) === 10 && is_numeric($phone)) {
            return '+91' . $phone;
        }

        // If it's already in the right format
        if (strlen($phone) === 12 && strpos($phone, '91') === 0) {
            return '+' . $phone;
        }

        throw new \Exception('Invalid Indian phone number format');
    }

    /**
     * Send SMS to India only
     */
    public function send($phone, $message)
    {

        try {
            // Format the phone number for India
            $formattedPhone = $this->formatIndianPhone($phone);

            // return $this->twilio->messages->create(
            //     $formattedPhone,
            //     [
            //         'from' => config('services.twilio.from'),
            //         'body' => $message
            //     ]
            // );

            $response = $this->twilio->messages->create(
                $formattedPhone,
                [
                    'from' => config('services.twilio.from'),
                    'body' => $message
                ]
            );

            return $response;
        } catch (\Exception $e) {
            throw new \Exception('SMS sending failed: ' . $e->getMessage());
        }
    }

    /**
     * Send OTP message to Indian phone
     */
    public function sendOTP($phone, $otp)
    {
        $message = "Your OTP verification code is: $otp. Valid for 10 minutes. - Kemtax Wellness";
        return $this->send($phone, $message);
    }

    public function sendSMS($phone, $message)
    {
        try {
           return $this->send($phone, $message);
        } catch (\Exception $e) {
            \Log::error('Twilio SMS Error: ' . $e->getMessage());
        }
    }
}
