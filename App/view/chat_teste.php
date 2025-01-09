<?php $this->layout('master', ['title' => $title, 'current_page' => 'Pagina Inicial', 'page' => 'chat_teste.php']); ?>

<?php
$this->start('css');
?>
<link rel="stylesheet" href="C:\laragon\www\PHP-POO\routes-phpoo\public\current_page_css\ChatStyle.css">
<?php
$this->stop();
?>

<div class="chat-container">
    <!-- Janela de mensagens -->
    <div class="chat-window" id="chat-window">
        <!-- Mensagens vão aparecer aqui -->
        <div class="message-container" id="messages">
            <!-- Exemplo de mensagem -->
            <div class="message sent">
                <span class="message-user">Você:</span>
                <span class="message-text">Oi! Como você está?</span>
            </div>
            <div class="message received">
                <span class="message-user">Amigo:</span>
                <span class="message-text">Estou bem, e você?</span>
            </div>
        </div>
    </div>

    <!-- Caixa de entrada para novas mensagens -->
    <form id="chat-form">
        <input type="text" id="chat-input" name="message" placeholder="Digite sua mensagem..." required>
        <button type="submit">Enviar</button>
    </form>
</div>


<?php
$this->start('js');
?>
<script src="C:\laragon\www\PHP-POO\routes-phpoo\public\js\Chat_js.js"></script>
<?php
$this->stop('js');
?>