$(document).ready(function () {
    // Toggle chatbot visibility
    $('#chat-toggle').click(function () {
        $('#chatbot-container').toggle();
    });

    // Close chatbot
    $('#close-btn').click(function () {
        $('#chatbot-container').hide();
    });

    // Send message on button click
    $('#sendBtn').click(function () {
        sendMessage();
    });

    // Send message on Enter key
    $('#userInput').keypress(function (e) {
        if (e.which === 13) {
            sendMessage();
        }
    });

    function sendMessage() {
        const userMessage = $('#userInput').val().trim();
        if (userMessage === '') return;

        $('#chatlog').append(`<div class="message user">You: ${userMessage}</div>`);
        $('#userInput').val('');
        $('#chatlog').scrollTop($('#chatlog')[0].scrollHeight);

        $.ajax({
            url: 'chatbot.php',
            type: 'POST',
            data: { message: userMessage },
            success: function (response) {
                $('#chatlog').append(`<div class="message bot">Bot: ${response}</div>`);
                $('#chatlog').scrollTop($('#chatlog')[0].scrollHeight);
            },
            error: function () {
                $('#chatlog').append('<div class="message bot">Error: Could not connect to the server.</div>');
            }
        });
    }
});
