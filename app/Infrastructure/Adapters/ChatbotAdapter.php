<?php

namespace App\Infrastructure\Adapters;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ChatbotAdapter
{
    protected $baseUrl;

    public function __construct()
    {
        // Defina a URL do chatbot
        $this->baseUrl = 'http://localhost:5005/webhooks/rest/webhook';
    }

    public function sendMessageToChatbot($message, $sender)
    {
        try {
            Log::info('Enviando mensagem para o chatbot via adaptador.', ['message' => $message, 'sender' => $sender]);

            $response = Http::post($this->baseUrl, [
                'message' => $message,
                'sender' => $sender,
            ]);

            Log::info('Resposta do chatbot recebida no adaptador: ', $response->json());

            return $response->json();
        } catch (\Exception $e) {
            Log::error('Erro ao enviar mensagem para o chatbot no adaptador: ', ['error' => $e->getMessage()]);
            throw new \Exception('Falha na comunicação com o chatbot.');
        }
    }
}
