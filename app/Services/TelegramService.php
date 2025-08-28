<?php

namespace App\Services;

use GuzzleHttp\Client;

class TelegramService
{
    protected $botToken;
    protected $chatId;
    protected $botTokenContact;
    protected $chatIdContact;
    protected $httpClient;

    public function __construct()
    {
        $this->botToken = env('TELEGRAM_BOT_TOKEN');
        $this->chatId = env('TELEGRAM_CHAT_ID');
        $this->httpClient = new Client(['base_uri' => 'https://api.telegram.org']);
        $this->botTokenContact = env('TELEGRAM_BOT_TOKEN_CONTACT');
        $this->chatIdContact = env('TELEGRAM_CHAT_ID_CONTACT');
    }

    public function sendMessage($message)
    {
        $url = "/bot{$this->botToken}/sendMessage";

        try {
            $response = $this->httpClient->post($url, [
                'form_params' => [
                    'chat_id' => $this->chatId,
                    'text' => $message,
                ]
            ]);

            return json_decode($response->getBody(), true);
        } catch (\Exception $e) {
            \Log::error('Telegram Error: ' . $e->getMessage());
            return false;
        }
    }

    public function sendMessageFeedback($message)
    {
        $url = "/bot{$this->botTokenContact}/sendMessage";

        try {
            $response = $this->httpClient->post($url, [
                'form_params' => [
                    'chat_id' => $this->chatIdContact,
                    'text' => $message,
                ]
            ]);

            return json_decode($response->getBody(), true);
        } catch (\Exception $e) {
            \Log::error('Telegram Error: ' . $e->getMessage());
            return false;
        }
    }
}