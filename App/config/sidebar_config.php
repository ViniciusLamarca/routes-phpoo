<?php

/**
 * Configuração do Menu Lateral
 * 
 * Este arquivo centraliza a configuração do menu lateral, facilitando:
 * - Adição de novos itens
 * - Modificação de permissões
 * - Reordenação dos itens
 * - Configuração de ícones e links
 */

return [
    'menu_items' => [
        [
            'id' => 'dashboard',
            'title' => 'Dashboard',
            'icon' => 'fas fa-tachometer-alt',
            'link' => 'index.php',
            'page' => 'index.php',
            'permission' => null,
            'order' => 10,
            'children' => []
        ],
        [
            'id' => 'mesas',
            'title' => 'Controle de Mesas',
            'icon' => 'fas fa-utensils',
            'link' => 'tables.php',
            'page' => 'tables',
            'permission' => null,
            'order' => 15,
            'children' => []
        ],
        [
            'id' => 'produtos',
            'title' => 'Produtos',
            'icon' => 'fas fa-box',
            'link' => '#',
            'page' => 'products',
            'permission' => null,
            'order' => 20,
            'children' => [
                [
                    'title' => 'Listar Produtos',
                    'icon' => 'fas fa-list',
                    'link' => 'products.php',
                    'page' => 'products.php',
                    'permission' => null,
                    'order' => 21
                ],
                [
                    'title' => 'Adicionar Produto',
                    'icon' => 'fas fa-plus',
                    'link' => 'products_add.php',
                    'page' => 'products_add.php',
                    'permission' => null,
                    'order' => 22
                ],
                [
                    'title' => 'Categorias',
                    'icon' => 'fas fa-tags',
                    'link' => 'categories.php',
                    'page' => 'categories.php',
                    'permission' => null,
                    'order' => 23
                ],
                [
                    'title' => 'Estoque',
                    'icon' => 'fas fa-warehouse',
                    'link' => 'stock.php',
                    'page' => 'stock.php',
                    'permission' => null,
                    'order' => 24
                ]
            ]
        ],
        [
            'id' => 'usuarios',
            'title' => 'Usuários',
            'icon' => 'fas fa-users',
            'link' => '#',
            'page' => 'users',
            'permission' => 'ADMINISTRADOR',
            'order' => 30,
            'children' => [
                [
                    'title' => 'Listar Usuários',
                    'icon' => 'fas fa-list',
                    'link' => 'user.php',
                    'page' => 'user.php',
                    'permission' => 'ADMINISTRADOR',
                    'order' => 31
                ],
                [
                    'title' => 'Adicionar Usuário',
                    'icon' => 'fas fa-user-plus',
                    'link' => 'user_add.php',
                    'page' => 'user_add.php',
                    'permission' => 'ADMINISTRADOR',
                    'order' => 32
                ],
                [
                    'title' => 'Permissões',
                    'icon' => 'fas fa-shield-alt',
                    'link' => 'permissions.php',
                    'page' => 'permissions.php',
                    'permission' => 'ADMINISTRADOR',
                    'order' => 33
                ],
                [
                    'title' => 'Grupos',
                    'icon' => 'fas fa-users-cog',
                    'link' => 'groups.php',
                    'page' => 'groups.php',
                    'permission' => 'ADMINISTRADOR',
                    'order' => 34
                ]
            ]
        ],
        [
            'id' => 'comunicacao',
            'title' => 'Comunicação',
            'icon' => 'fas fa-comments',
            'link' => '#',
            'page' => 'communication',
            'permission' => null,
            'order' => 40,
            'children' => [
                [
                    'title' => 'Chat',
                    'icon' => 'fas fa-comment',
                    'link' => 'chat_teste.php',
                    'page' => 'chat_teste.php',
                    'permission' => null,
                    'order' => 41
                ],
                [
                    'title' => 'Notificações',
                    'icon' => 'fas fa-bell',
                    'link' => 'notifications.php',
                    'page' => 'notifications.php',
                    'permission' => null,
                    'order' => 42
                ],
                [
                    'title' => 'Mensagens',
                    'icon' => 'fas fa-envelope',
                    'link' => 'messages.php',
                    'page' => 'messages.php',
                    'permission' => null,
                    'order' => 43
                ]
            ]
        ],
        [
            'id' => 'relatorios',
            'title' => 'Relatórios',
            'icon' => 'fas fa-chart-bar',
            'link' => '#',
            'page' => 'reports',
            'permission' => null,
            'order' => 50,
            'children' => [
                [
                    'title' => 'Vendas',
                    'icon' => 'fas fa-chart-line',
                    'link' => 'reports_sales.php',
                    'page' => 'reports_sales.php',
                    'permission' => null,
                    'order' => 51
                ],
                [
                    'title' => 'Estoque',
                    'icon' => 'fas fa-warehouse',
                    'link' => 'reports_stock.php',
                    'page' => 'reports_stock.php',
                    'permission' => null,
                    'order' => 52
                ],
                [
                    'title' => 'Usuários',
                    'icon' => 'fas fa-users',
                    'link' => 'reports_users.php',
                    'page' => 'reports_users.php',
                    'permission' => 'ADMINISTRADOR',
                    'order' => 53
                ],
                [
                    'title' => 'Financeiro',
                    'icon' => 'fas fa-dollar-sign',
                    'link' => 'reports_financial.php',
                    'page' => 'reports_financial.php',
                    'permission' => 'ADMINISTRADOR',
                    'order' => 54
                ]
            ]
        ],
        [
            'id' => 'configuracoes',
            'title' => 'Configurações',
            'icon' => 'fas fa-cog',
            'link' => '#',
            'page' => 'settings',
            'permission' => 'ADMINISTRADOR',
            'order' => 59, // Movido para antes do perfil
            'children' => [
                [
                    'title' => 'Sistema',
                    'icon' => 'fas fa-tools',
                    'link' => 'settings_system.php',
                    'page' => 'settings_system.php',
                    'permission' => 'ADMINISTRADOR',
                    'order' => 61
                ],
                [
                    'title' => 'Backup',
                    'icon' => 'fas fa-database',
                    'link' => 'settings_backup.php',
                    'page' => 'settings_backup.php',
                    'permission' => 'ADMINISTRADOR',
                    'order' => 62
                ],
                [
                    'title' => 'Logs',
                    'icon' => 'fas fa-file-alt',
                    'link' => 'settings_logs.php',
                    'page' => 'settings_logs.php',
                    'permission' => 'ADMINISTRADOR',
                    'order' => 63
                ],
                [
                    'title' => 'Manutenção',
                    'icon' => 'fas fa-wrench',
                    'link' => 'settings_maintenance.php',
                    'page' => 'settings_maintenance.php',
                    'permission' => 'ADMINISTRADOR',
                    'order' => 64
                ],
                [
                    'title' => 'Database',
                    'icon' => 'fas fa-database',
                    'link' => 'database',
                    'page' => 'database',
                    'permission' => 'ADMINISTRADOR',
                    'order' => 65
                ]
            ]
        ],
        [
            'id' => 'perfil',
            'title' => 'Perfil',
            'icon' => 'fas fa-user-circle',
            'link' => 'profile.php',
            'page' => 'profile.php',
            'permission' => null,
            'order' => 60
        ]
    ],

    'settings' => [
        'default_icon' => 'fas fa-circle',
        'enable_tooltips' => true,
        'enable_animations' => true,
        'compact_mode_default' => false,
        'auto_close_mobile' => true,
        'show_user_info' => true,
        'brand_text' => 'Sistema Vinicius-PHP',
        'brand_icon' => 'fas fa-leaf'
    ],

    'permissions' => [
        'ADMINISTRADOR' => [
            'label' => 'Administrador',
            'color' => '#e74c3c',
            'description' => 'Acesso total ao sistema'
        ],
        'GERENTE' => [
            'label' => 'Gerente',
            'color' => '#f39c12',
            'description' => 'Acesso limitado de gerenciamento'
        ],
        'USUARIO' => [
            'label' => 'Usuário',
            'color' => '#27ae60',
            'description' => 'Acesso básico ao sistema'
        ]
    ]
];

// Funções movidas para App/helpers/sidebar_functions.php para evitar redeclaração