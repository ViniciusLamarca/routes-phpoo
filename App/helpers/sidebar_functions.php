<?php

// Funções para o sidebar - arquivo centralizado para evitar redeclaração

if (!function_exists('hasPermission')) {
    function hasPermission($permission)
    {
        if ($permission === null) return true;
        return isset($_SESSION['user']) && $_SESSION['user']['cargo'] === $permission;
    }
}

if (!function_exists('isActive')) {
    function isActive($itemPage, $currentPage)
    {
        return strpos($currentPage, $itemPage) !== false;
    }
}

if (!function_exists('isDropdownOpen')) {
    function isDropdownOpen($children, $currentPage)
    {
        foreach ($children as $child) {
            if (isActive($child['page'], $currentPage)) {
                return true;
            }
        }
        return false;
    }
}

if (!function_exists('getMenuItems')) {
    function getMenuItems($filters = [])
    {
        $config = include __DIR__ . '/../config/sidebar_config.php';
        $items = $config['menu_items'];

        // Aplicar filtros se necessário
        if (!empty($filters['permission'])) {
            $items = array_filter($items, function ($item) use ($filters) {
                return $item['permission'] === null || $item['permission'] === $filters['permission'];
            });
        }

        // Ordenar por order
        usort($items, function ($a, $b) {
            return ($a['order'] ?? 999) <=> ($b['order'] ?? 999);
        });

        return $items;
    }
}
