// Function to toggle the chat
function toggleChat() {
  var chat = document.getElementById('chat');
  chat.classList.toggle('active');

  var chatBody = document.getElementById('chatBody');
  chatBody.classList.toggle('active');

  var chatInput = document.getElementById('chat-input-container');
  chatInput.style.display = chatBody.classList.contains('active') ? 'flex' : 'none';
  var chatBtn = document.getElementById("open-chat-btn");
  chatBtn.style.display = chatBody.classList.contains('active') ?  'none':'flex';
  // // Toggle the icon up/down
  // var icon = document.querySelector('.chat-header i');
  // if (icon) {
  //     icon.classList.toggle('fa-angle-up'); 
  //     icon.classList.toggle('fa-angle-down');
  // }
}

// Function to send message to chatbot
async function sendMessage() {
  const messageInput = document.getElementById('chat-input');
  const message = messageInput.value.trim();
  if (message === '') return; // Don't send empty messages

  // Add the user's message to the list of messages
  const messages = document.getElementById('chat-messages');
  const userMessage = document.createElement('div');
  userMessage.className = 'chat-message chat-message-user';
  userMessage.textContent = message;

  const messagesInner = document.querySelector('.chat-messages-inner');
  messagesInner.appendChild(userMessage);

  messageInput.value = ''; // Clear the input field

  // Send the message to the chatbot (replace with the correct endpoint)
  const response = await fetch('http://localhost:5000/chatbot', {
      method: 'POST',
      headers: {
          'Content-Type': 'application/json',
      },
      body: JSON.stringify({ message: message }),
  });
  const data = await response.json();

  // Add the chatbot's response to the list of messages
  const botMessage = document.createElement('div');
  botMessage.className = 'chat-message chat-message-bot';
  botMessage.textContent = data.response;

  messagesInner.appendChild(botMessage);

  // Scroll down to the latest message
  messages.scrollTop = messages.scrollHeight;
}

// Add this function to be called when the page is ready:
document.addEventListener('DOMContentLoaded', () => {
  // Find the chat send button
  const chatSendButton = document.getElementById('chat-send');
  if (chatSendButton) {
      chatSendButton.addEventListener('click', sendMessage); 
  } else {
      console.error("Chat send button not found.");
  }

  // Find the chat header and add the click event
  const chatHeader = document.querySelector('.chat-header');
  if (chatHeader) {
      chatHeader.addEventListener('click', toggleChat);
  } else {
      console.error("Chat header not found.");
  }

  // Find the chat input field and add the enter key event
  const chatInput = document.getElementById('chat-input');
  if (chatInput) {
      chatInput.addEventListener('keyup', (event) => {
          if (event.key === 'Enter') {
              sendMessage();
          }
      });
  } else {
      console.error("Chat input field not found.");
  }

  // Add event listener to chat button to toggle chat
  const chatButton = document.querySelector('.uiButton.helpButtonEnabled');
  if (chatButton) {
      chatButton.addEventListener('click', toggleChat);
  } else {
      console.error("Chat button not found.");
  }
});
