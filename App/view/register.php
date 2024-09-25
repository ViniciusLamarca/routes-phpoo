<?php $this->layout('master', ['title' => $title, 'current_page' => 'Register', 'page' => 'register.php']); ?>



<section class="container">
    <h1>Register</h1>
    <form action="/PHP-POO/routes-phpoo/public/register.php" method="post">
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="teste__name">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="teste@teste.com.br">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password" value="teste__password">
            <label for="tipo_user">Tipo de usuário</label>
            <select class="form-control" id="tipo_user" name="tipo_user">
                <option value="ADMINISTRADOR">Administrador</option>
                <option value="USER">Usuário</option>
            </select>

        </div>
        <button type="submit" class="btn btn-primary">
            Enviar
        </button>
    </form>
</section>