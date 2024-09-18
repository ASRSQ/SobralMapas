
// Funções para o chat

// Função para mostrar a caixa de chat ao clicar no botão
document
    .getElementById("show-chat-button")
    .addEventListener("click", function () {
        const chatContainer = document.getElementById("chat-container");
        chatContainer.style.display = "block";
        this.style.display = "none"; // Esconde o botão depois que o chat é mostrado
    });
let latitude = "";
let longitude = "";

// Obter a localização do usuário
navigator.geolocation.getCurrentPosition(
    (position) => {
        latitude = position.coords.latitude.toFixed(6); // Latitude com 6 casas decimais
        longitude = position.coords.longitude.toFixed(6); // Longitude com 6 casas decimais
        console.log(`Latitude: ${latitude}, Longitude: ${longitude}`);
    },
    (error) => {
        console.error("Erro ao obter a localização:", error);
    }
);

// Função para gerar um ID único
function generateUniqueId() {
    // Combina latitude, longitude e outros fatores para criar um hash único
    const randomString = Math.random().toString(36).substring(2, 15); // Gerar uma string aleatória
    const data = `${latitude}_${longitude}_${randomString}`; // Combina com sublinhados

    return crypto.subtle
        .digest("SHA-256", new TextEncoder().encode(data))
        .then((hashBuffer) => {
            const hashArray = Array.from(new Uint8Array(hashBuffer));
            const hashHex = hashArray
                .map((b) => b.toString(16).padStart(2, "0"))
                .join("");
            return `${latitude}_${longitude}_${hashHex}`; // Retorna o ID combinado com sublinhados
        });
}

// Função de envio de mensagens com AJAX
document
    .getElementById("send-button")
    .addEventListener("click", async function () {
        const messageInput = document.getElementById("message-input");
        const message = messageInput.value.trim();
        if (message !== "") {
            addMessageToChat("user", message);
            messageInput.value = "";

            // Gera o sender_id único com base na latitude, longitude e outros fatores
            const sender_id = await generateUniqueId();

            // Envia a mensagem ao servidor usando AJAX
            fetch(`${baseUrl}/send-message`, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute("content"),
                },
                body: JSON.stringify({
                    message: message,
                    sender_id: sender_id, // Inclui o sender_id gerado
                }),
            })
                .then((response) => response.json())
                .then((data) => {
                    console.log("Dados recebidos do servidor:", data); // Verifica o que está sendo recebido
                    if (data && data.length > 0) {
                        data.forEach((msg) => {
                            // Verifica se a mensagem contém metadados no campo 'custom'
                            if (msg.custom && msg.custom.map_type) {
                                console.log(
                                    "Metadado recebido:",
                                    msg.custom.map_type
                                ); // Log para verificação
                                // Aciona a lógica de busca com base no tipo de mapa
                                activateMapSearch(msg.custom.map_type);
                            } else if (msg.text) {
                                // Caso seja texto normal, exibe a mensagem no chat
                                addMessageToChat("bot", msg.text);
                            }
                        });
                    }
                })
                .catch((error) => {
                    console.error("Erro:", error);
                    addMessageToChat(
                        "bot",
                        "Erro ao se comunicar com o servidor."
                    );
                });
        }
    });

// Enviar mensagem ao pressionar Enter
document
    .getElementById("message-input")
    .addEventListener("keydown", function (e) {
        if (e.key === "Enter") {
            e.preventDefault();
            document.getElementById("send-button").click();
        }
    });

// Chamar a função de atualização ao carregar a página
updateCustomMapDropdown();
updateLegend();

// Funções do Chat
// Função para mostrar a caixa de chat ao clicar no botão
document
    .getElementById("show-chat-button")
    .addEventListener("click", function () {
        var chatContainer = document.getElementById("chat-container");
        chatContainer.style.display = "block";
        this.style.display = "none"; // Esconde o botão depois que o chat é mostrado
    });

// Função de envio de mensagens com AJAX
document.getElementById("send-button").addEventListener("click", function () {
    const messageInput = document.getElementById("message-input");
    const message = messageInput.value.trim();
    if (message !== "") {
        addMessageToChat("user", message);
        messageInput.value = "";

        // Envia a mensagem ao servidor usando AJAX
        fetch(`${window.location.origin}/sobralmapas/public/send-message`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
            },
            body: JSON.stringify({ message: message }),
        })
            .then((response) => response.json())
            .then((data) => {
                if (data && data.length > 0) {
                    data.forEach((msg) => {
                        addMessageToChat("bot", msg.text);
                    });
                }
            })
            .catch((error) => {
                console.error("Erro:", error);
                addMessageToChat("bot", "Erro ao se comunicar com o servidor.");
            });
    }
});

// Enviar mensagem ao pressionar Enter
document
    .getElementById("message-input")
    .addEventListener("keydown", function (e) {
        if (e.key === "Enter") {
            e.preventDefault();
            document.getElementById("send-button").click();
        }
    });

// Função para adicionar mensagens ao chat
function addMessageToChat(sender, text) {
    const messagesDiv = document.getElementById("messages");
    const messageDiv = document.createElement("div");
    messageDiv.classList.add(
        "message",
        sender === "user" ? "sent" : "received"
    );
    messageDiv.textContent = text;
    messagesDiv.appendChild(messageDiv);
    messagesDiv.scrollTop = messagesDiv.scrollHeight;

    removeEmptyMessages();
}

// Função para remover mensagens vazias
function removeEmptyMessages() {
    const messages = document.querySelectorAll(".message.received");
    messages.forEach((message) => {
        if (!message.textContent.trim()) {
            message.remove();
        }
    });
}

const showChatButton = document.getElementById("show-chat-button");
const chatContainer = document.getElementById("chat-container");
const toggleChatButton = document.getElementById("toggle-chat-button");
const sendButton = document.getElementById("send-button");

// Mostrar o chatbox ao clicar no botão
showChatButton.addEventListener("click", function () {
    chatContainer.style.display = "flex";
    showChatButton.style.display = "none";
});

// Esconder o chatbox ao clicar no botão X
toggleChatButton.addEventListener("click", function () {
    chatContainer.style.display = "none";
    showChatButton.style.display = "block";
});

// Enviar mensagem ao clicar no botão "Enviar"
sendButton.addEventListener("click", function () {
    const messageText = messageInput.value;
    if (messageText.trim() !== "") {
        const messageElement = document.createElement("div");
        messageElement.classList.add("message", "sent");
        messageElement.textContent = messageText;

        messagesContainer.appendChild(messageElement);
        messageInput.value = "";
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    }
});

// Seletor para a primeira mensagem vazia
const firstEmptyMessage = document.querySelector(".message.received");

// Verifique se o elemento existe antes de tentar removê-lo
if (firstEmptyMessage) {
    firstEmptyMessage.remove();
}

// Enviar mensagem ao clicar no botão "Enviar"
sendButton.addEventListener("click", function () {
    const messageText = messageInput.value;
    if (messageText.trim() !== "") {
        const messageElement = document.createElement("div");
        messageElement.classList.add("message", "sent");
        messageElement.textContent = messageText;

        messagesContainer.appendChild(messageElement);
        messageInput.value = "";
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    }
});

// Função para ativar a busca com base no metadado do tipo de mapa
function activateMapSearch(mapType) {
    performSearch(mapType); // Chama a busca diretamente com o metadado, sem preencher a caixa de pesquisa
}