<?php $this->layout('master', ['title' => $title, 'current_page' => 'Chat', 'page' => 'chat_teste.php']); ?>

<section class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3>Chat</h3>
                    <div class="alert alert-info">
                        Bem-vindo ao chat, <?php echo htmlspecialchars($user['username']); ?>!
                    </div>
                </div>
                <div class="card-body">
                    <div id="chat-messages" class="mb-3" style="height: 400px; overflow-y: auto;">
                        <!-- Mensagens do chat serão exibidas aqui -->
                    </div>
                    <form id="chat-form">
                        <div class="input-group">
                            <input type="text" id="message" class="form-control" placeholder="Digite sua mensagem...">
                            <button type="submit" class="btn btn-primary">Enviar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    // Aqui você pode adicionar o código JavaScript para o WebSocket
    // quando implementar a funcionalidade de chat em tempo real
</script>