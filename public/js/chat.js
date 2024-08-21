// chat.js

// Função para mostrar a caixa de chat ao clicar no botão
document.getElementById('show-chat-button').addEventListener('click', function() {
    const chatContainer = document.getElementById('chat-container');
    chatContainer.style.display = 'block';
    this.style.display = 'none'; // Esconde o botão depois que o chat é mostrado
});

// Função de envio de mensagens com AJAX
document.getElementById('send-button').addEventListener('click', function() {
    const messageInput = document.getElementById('message-input');
    const message = messageInput.value.trim();
    if (message !== '') {
        addMessageToChat('user', message);
        messageInput.value = '';

        // Envia a mensagem ao servidor usando AJAX
        fetch(`${baseUrl}/send-message`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ message: message })
        })
        .then(response => response.json())
        .then(data => {
            console.log("Dados recebidos do servidor:", data); // Verifica o que está sendo recebido
            if (data && data.length > 0) {
                data.forEach(msg => {
                    // Verifica se a mensagem contém metadados no campo 'custom'
                    if (msg.custom && msg.custom.map_type) {
                        console.log("Metadado recebido:", msg.custom.map_type); // Log para verificação
                        // Aciona a lógica de busca com base no tipo de mapa
                        performSearch(msg.custom.map_type);
                    } else if (msg.text) {
                        // Caso seja texto normal, exibe a mensagem no chat
                        addMessageToChat('bot', msg.text);
                    }
                });
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            addMessageToChat('bot', 'Erro ao se comunicar com o servidor.');
        });
    }
});

// Enviar mensagem ao pressionar Enter
document.getElementById('message-input').addEventListener('keydown', function(e) {
    if (e.key === 'Enter') {
        e.preventDefault();
        document.getElementById('send-button').click();
    }
});

// Função para adicionar mensagens ao chat
function addMessageToChat(sender, text) {
    const messagesDiv = document.getElementById('messages');
    const messageDiv = document.createElement('div');
    messageDiv.classList.add('message', sender === 'user' ? 'sent' : 'received');
    messageDiv.textContent = text;
    messagesDiv.appendChild(messageDiv);
    messagesDiv.scrollTop = messagesDiv.scrollHeight;
}

// Inicialização do chat
document.addEventListener('DOMContentLoaded', function() {
    const showChatButton = document.getElementById('show-chat-button');
    const chatContainer = document.getElementById('chat-container');
    const toggleChatButton = document.getElementById('toggle-chat-button');
    const sendButton = document.getElementById('send-button');
    const messageInput = document.getElementById('message-input');
    const messagesContainer = document.getElementById('messages');

    // Mostrar o chatbox ao clicar no botão
    showChatButton.addEventListener('click', function() {
        chatContainer.style.display = 'flex';
        showChatButton.style.display = 'none';
    });

    // Esconder o chatbox ao clicar no botão X
    toggleChatButton.addEventListener('click', function() {
        chatContainer.style.display = 'none';
        showChatButton.style.display = 'block';
    });

    // Enviar mensagem ao clicar no botão "Enviar"
    sendButton.addEventListener('click', function() {
        const messageText = messageInput.value;
        if (messageText.trim() !== "") {
            const messageElement = document.createElement('div');
            messageElement.classList.add('message', 'sent');
            messageElement.textContent = messageText;

            messagesContainer.appendChild(messageElement);
            messageInput.value = "";
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        }
    });
});
