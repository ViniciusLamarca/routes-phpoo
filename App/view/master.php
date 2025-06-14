<?php

?>

<!DOCTYPE html>
<html lang="pt_BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->e($title) ?></title>
    <?= $this->section('css'); ?>
    <link rel="stylesheet" href="/PHP-POO/routes-phpoo/public/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="/PHP-POO/routes-phpoo/public/css/navbar.css">
    <link rel="stylesheet" href="/PHP-POO/routes-phpoo/public/css/notifications.css">
    <style>
        main {
            padding-top: calc(56px + 2.5rem);
            padding-left: 15px;
            padding-right: 15px;
            flex: 1;
        }

        @media (max-width: 500px) {
            main {
                padding-top: calc(56px + 2.5rem);
                padding-left: 5px;
                padding-right: 35px;
                flex: 1;
            }

        }
    </style>
</head>

<body class="d-flex flex-column h-100  bg-dark text-white ">
    <?php $this->insert('partials/menu', ['page_title' => $current_page, 'page' => $page]) ?>
    <?php $this->insert('partials/notifications'); ?>
    <main class="flex-shrink-0">
        <section>
            <?= $this->section('content') ?>
        </section>

    </main>

</body>
<?= $this->section('js'); ?>
<!-- links -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="/PHP-POO/routes-phpoo/public/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

<script>
    $(document).ready(function() {
        // Inicialize todos os tooltips na página
        $('[data-toggle="tooltip"]').tooltip({
            animation: true, // Se o tooltip deve ter animação
            delay: {
                "show": 100,
                "hide": 150
            }, // Delay antes de mostrar e esconder
            html: true, // Se o conteúdo deve ser interpretado como HTML
            placement: 'bottom' // Posição do tooltip
        });
    });

    document.onkeydown = function($e) {
        if ($e.keyCode == 27) {
            if (page !== "index.php") {
                history.go(-1)
            } else {
                location.reload();
            }
        }

    }
</script>
<script src="/PHP-POO/routes-phpoo/public/js/notifications.js"></script>

</html>