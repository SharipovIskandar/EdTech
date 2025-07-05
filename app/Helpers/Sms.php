<?php

namespace App\Helpers;

use App\Exceptions\CustomErrorException;
use App\Models\Integration\IntegrationSystem;
use Illuminate\Support\Facades\Http;

class Sms
{
    protected string|null $url = null;
    protected string|null $login = null;
    protected string|null $from = null;
    protected string|null $password = null;
    protected string|null $token = null;
    protected $system = null;

    public function __construct($url = null, $login = null, $from = null, $password = null, $token = null)
    {
        $this->system = IntegrationSystem::where('code', 'sms_eskiz')
            ->first();

        $parameters = collect($this->system?->fields ?? []);

        $this->url = $url ?: ($parameters['url'] ?? null);
        $this->login = $login ?: ($parameters['login'] ?? null);
        $this->from = $from ?: ($parameters['from'] ?? null);
        $this->password = $password ?: ($parameters['password'] ?? null);
        $this->token = $token ?: ($parameters['token'] ?? null);
    }

    public function login()
    {
        $url = $this->url . '/auth/login';

        $response = Http::acceptJson()
            ->withBody([
                'email' => $this->login,
                'password' => $this->password,
            ])
            ->post($url);

        $content = json_decode($response->body());

        if (!$response->ok()) {
            throw new CustomErrorException($content, customCode: $response->status());
        }

        $this->token = $content->data->token;
    }

    public function refresh()
    {
        $url = $this->url . '/auth/refresh';

        $response = Http::acceptJson()
            ->withToken($this->token)
            ->patch($url);

        $content = json_decode($response->body());

        if (!$response->ok()) {
            if ($response->status() === 401) {
                $this->login();
            }

            throw new CustomErrorException($content, customCode: $response->status());
        }

        return $content;
    }

    public function send(string $phone, string $message)
    {
        $url = $this->url . '/message/sms/send';

        $response = Http::acceptJson()
            ->withToken($this->token)
            ->post($url, [
                'mobile_phone' => $this->verifyPhone($phone),
                'message' => $message,
                'from' => $this->from,
            ]);

        $content = json_decode($response->body());

        if (!$response->ok()) {
            if ($response->status() === 401) {
                $this->refresh();
            }

            throw new CustomErrorException($content, customCode: $response->status());
        }

        return $content;
    }

    public static function otpCode()
    {
        $code = rand(10000, 99999);

        return $code;
    }

    public function verifySms($otp)
    {
        $text = $this->system->fields->verify ?? null;
        if (is_null($text)) {
            throw new CustomErrorException('SMS matni kiritilmagan');
        }
        return preg_replace('/\{otp_code\}/', $otp, $text);
    }

    public function applySms($number)
    {
        $text = $this->system->fields->apply_answered ?? null;
        if (is_null($text)) {
            throw new CustomErrorException('SMS matni kiritilmagan' . $text);
        }
        return preg_replace('/\{application_number\}/', $number, $text);
    }

    public function verifyPhone(string $phone)
    {
        $match = preg_replace('/\+|\-|\s+|\(|\)/', '', $phone);
        return $match;
    }
}
