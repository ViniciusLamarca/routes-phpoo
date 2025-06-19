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
    <link rel="stylesheet" href="/PHP-POO/routes-phpoo/public/css/sidebar.css">
    <link rel="stylesheet" href="/PHP-POO/routes-phpoo/public/css/navbar-sidebar-integration.css">
    <link rel="stylesheet" href="/PHP-POO/routes-phpoo/public/css/notifications.css">
    <style>
        /* EVITAR FLASH NO CARREGAMENTO */
        * {
            -webkit-transition: none !important;
            -moz-transition: none !important;
            -o-transition: none !important;
            transition: none !important;
        }

        /* Wrapper principal para acomodar sidebar */
        .main-wrapper {
            /* Sem transição inicial - apenas após carregamento */
            transition: none !important;
        }

        /* Transições apenas após carregamento completo */
        body.sidebar-loaded .main-wrapper {
            transition: margin-left 0.3s ease !important;
        }

        body.sidebar-loaded * {
            -webkit-transition: unset !important;
            -moz-transition: unset !important;
            -o-transition: unset !important;
            transition: unset !important;
        }

        main {
            padding-top: calc(56px + 2.5rem);
            padding-left: 15px;
            padding-right: 15px;
            flex: 1;
        }

        /* Reduzir padding lateral quando sidebar está ativa */
        @media (min-width: 992px) {

            body.has-sidebar main,
            body.sidebar-compact main {
                padding-left: 10px;
            }
        }

        /* Ajustes para sidebar em desktop */
        @media (min-width: 992px) {

            /* Estado inicial - já com margem correta */
            body.has-sidebar .main-wrapper {
                margin-left: 280px;
                transition: none;
                /* Sem transição no carregamento */
            }

            /* Após carregamento completo - ativar transições */
            body.sidebar-loaded.has-sidebar .main-wrapper {
                margin-left: 280px;
                transition: margin-left 0.3s ease;
            }

            body.sidebar-loaded.sidebar-compact .main-wrapper {
                margin-left: 80px;
                transition: margin-left 0.3s ease;
            }
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

<body class="d-flex flex-column h-100 bg-dark text-white has-sidebar">
    <?php $this->insert('partials/sidebar', ['page' => $page]) ?>
    <?php $this->insert('partials/menu', ['page_title' => $current_page, 'page' => $page]) ?>
    <?php $this->insert('partials/notifications'); ?>

    <div class="main-wrapper">
        <main class="flex-shrink-0">
            <section>
                <?= $this->section('content') ?>
            </section>
        </main>
    </div>

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
<script src="/PHP-POO/routes-phpoo/public/js/sidebar.js"></script>
<script src="/PHP-POO/routes-phpoo/public/js/sidebar-debug.js"></script>
<script src="/PHP-POO/routes-phpoo/public/js/notifications.js"></script>

</html>