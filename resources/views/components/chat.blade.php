<!-- resources/views/components/chat.blade.php -->
<!-- Botão para mostrar o chat -->
<button id="show-chat-button"><i class="fas fa-comment"></i>  <span> Chat - SobralMapas</span></button>

<div id="chat-container">
    <div class="chat-header">
        <div class="chat-title">
            <i class="fas fa-comment"></i>
            Chat - Sobral Mapas
        </div>
        <button id="toggle-chat-button">
            <i class="fas fa-times" id="toggle-icon"></i>
        </button>
    </div>
    <!-- Área onde as mensagens aparecerão -->
    <div id="messages">
        <!-- Mensagem de boas-vindas -->
        <div class="welcome-message">
            <p><strong>Bem-vindo ao SobralMapas!</strong></p>
            <p>Resolva as suas dúvidas.</p>
        </div>
        <hr>
        <div class="message received"></div>
    </div>
    <!-- Caixa de input e botão de envio -->
    <div id="message-input-container">
        <input type="text" id="message-input" placeholder="Digite sua mensagem...">
        <button id="send-button">Enviar</button>
    </div>
</div>
