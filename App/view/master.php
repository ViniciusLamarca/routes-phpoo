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
    <link rel="stylesheet" href="/PHP-POO/routes-phpoo/public/css/sidebar-custom.css">
    <link rel="stylesheet" href="/PHP-POO/routes-phpoo/public/css/navbar-sidebar-integration.css">
    <link rel="stylesheet" href="/PHP-POO/routes-phpoo/public/css/navbar-dropdown-fix.css">
    <link rel="stylesheet" href="/PHP-POO/routes-phpoo/public/css/notifications.css">
    <link rel="stylesheet" href="/PHP-POO/routes-phpoo/public/css/responsive.css">
    <style>
        /* Apenas para evitar o flash de transições no carregamento inicial */
        * {
            -webkit-transition: none !important;
            -moz-transition: none !important;
            -o-transition: none !important;
            transition: none !important;
        }

        /* Reativar transições após o carregamento via JS */
        body.sidebar-loaded * {
            -webkit-transition: unset !important;
            -moz-transition: unset !important;
            -o-transition: unset !important;
            transition: unset !important;
        }

        /* Correção específica para dropdowns do navbar */
        .navbar .dropdown-menu {
            z-index: 1100 !important;
            display: none;
            position: absolute;
            background-color: #fff;
            border: 1px solid rgba(0, 0, 0, .15);
            border-radius: 0.375rem;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, .175);
        }

        .navbar .dropdown-menu.show {
            display: block !important;
        }

        .navbar .dropdown-toggle::after {
            display: inline-block;
            margin-left: 0.255em;
            vertical-align: 0.255em;
            content: "";
            border-top: 0.3em solid;
            border-right: 0.3em solid transparent;
            border-bottom: 0;
            border-left: 0.3em solid transparent;
        }
    </style>
</head>

<body class="dark-mode d-flex flex-column h-100 text-white <?= isset($_SESSION['user']) ? 'has-sidebar' : '' ?>"
    style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); background-attachment: fixed;">
    <?php if (isset($_SESSION['user'])): ?>
        <?php $this->insert('partials/sidebar', ['page' => $page]) ?>
        <?php $this->insert('partials/menu', ['page_title' => $current_page, 'page' => $page]) ?>
    <?php endif; ?>
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
<!-- Scripts - Ordem correta para evitar conflitos -->
<!-- 1. jQuery primeiro -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<!-- 2. Popper.js (incluído no bootstrap.bundle.min.js) -->
<!-- 3. Bootstrap JS -->
<script src="/PHP-POO/routes-phpoo/public/bootstrap/js/bootstrap.bundle.min.js"></script>

<script>
    $(document).ready(function() {
        // Inicializar tooltips do Bootstrap
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl, {
                animation: true,
                delay: {
                    "show": 100,
                    "hide": 150
                },
                html: true,
                placement: 'bottom'
            });
        });

        // Garantir que dropdowns do navbar funcionem corretamente
        $('.navbar .dropdown-toggle').on('click', function(e) {
            e.preventDefault();
            var $dropdown = $(this).next('.dropdown-menu');

            // Fechar outros dropdowns
            $('.navbar .dropdown-menu').not($dropdown).removeClass('show');

            // Toggle do dropdown atual
            $dropdown.toggleClass('show');
        });

        // Fechar dropdown ao clicar fora
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.navbar .dropdown').length) {
                $('.navbar .dropdown-menu').removeClass('show');
            }
        });
    });

    document.onkeydown = function($e) {
        if ($e.keyCode == 27) {
            // Fechar dropdowns com ESC
            $('.navbar .dropdown-menu').removeClass('show');

            if (page !== "index.php") {
                history.go(-1)
            } else {
                location.reload();
            }
        }
    }
</script>
<!-- Scripts customizados -->
<script src="/PHP-POO/routes-phpoo/public/js/sidebar.js"></script>
<script src="/PHP-POO/routes-phpoo/public/js/notifications.js"></script>
<!-- Debug apenas em desenvolvimento -->
<script src="/PHP-POO/routes-phpoo/public/js/sidebar-debug.js"></script>

</html>