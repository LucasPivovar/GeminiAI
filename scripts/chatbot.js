// Função para enviar mensagem
function sendMessage() {
    const userInput = document.getElementById('user-input').value.trim();

    if (userInput === "") return;

    const chatBox = document.getElementById('chat-box');
    const emptyMessage = document.getElementById('empty-message');

    // Oculta o texto padrão se ele estiver visível
    if (emptyMessage) {
        emptyMessage.style.display = 'none';
    }

    // Cria e adiciona a mensagem do usuário
    const userMessage = document.createElement('div');
    userMessage.className = 'user-message';
    userMessage.textContent = userInput;
    chatBox.appendChild(userMessage);

    // Limpa o input após enviar a mensagem
    document.getElementById('user-input').value = '';

    // Envia a mensagem para o chatbot
    fetch("chatbot.php", {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ message: userInput })
    })
        .then(response => response.json())
        .then(data => {
            // Cria e adiciona a mensagem do bot com efeito de digitação
            const botMessage = document.createElement('div');
            botMessage.className = 'bot-message';
            chatBox.appendChild(botMessage);

            const responseText = data.error ? `: ${data.error}` : ` ${data.response}`;
            typeText(botMessage, responseText);
        })
        .catch(error => {
            // Cria e adiciona uma mensagem de erro com efeito de digitação
            const errorMessage = document.createElement('div');
            errorMessage.className = 'bot-message';
            chatBox.appendChild(errorMessage);

            typeText(errorMessage, 'Bot: Falha ao buscar resposta.');
        });

    // Rola automaticamente para a última mensagem
    chatBox.scrollTop = chatBox.scrollHeight;
}

// Função para simular o efeito de digitação
function typeText(element, text) {
    let index = 0;
    const typingInterval = 30; // Velocidade da digitação (em milissegundos)

    function type() {
        if (index < text.length) {
            element.textContent += text.charAt(index);
            index++;
            setTimeout(type, typingInterval);
        } else {
            // Remove o cursor piscante após terminar a digitação
            element.style.animation = 'none';
        }
    }

    type();
}