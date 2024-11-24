<?php
namespace App\Application\Services;

use App\Infrastructure\Adapters\ChatbotAdapter;
use Illuminate\Support\Facades\Log;
use Exception;

class ChatbotService
{
    protected $chatbotAdapter;

    public function __construct(ChatbotAdapter $chatbotAdapter)
    {
        $this->chatbotAdapter = $chatbotAdapter;
    }

    public function sendMessage($message, $sender)
    {
        Log::info('ChatbotService: enviando mensagem usando o adaptador.');

        // Validate inputs
        if (empty($message) || empty($sender)) {
            throw new Exception('Mensagem ou remetente inválido.');
        }

        try {
            // Utiliza o adaptador para enviar a mensagem
            $responses = $this->chatbotAdapter->sendMessageToChatbot($message, $sender);
            return $responses;
        } catch (Exception $e) {
            Log::error('Erro ao enviar mensagem no ChatbotService: ', ['error' => $e->getMessage()]);
            throw new Exception('Erro ao processar a mensagem no chatbot.');
        }
    }
}
