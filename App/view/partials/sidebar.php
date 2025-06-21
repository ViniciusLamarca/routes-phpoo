<?php
// Carregar configuração do menu lateral
$sidebarConfig = include __DIR__ . '/../../config/sidebar_config.php';
$menuItems = $sidebarConfig['menu_items'];
$settings = $sidebarConfig['settings'];

// Função para verificar se o usuário tem permissão
function hasPermission($permission)
{
    if ($permission === null) return true;
    return isset($_SESSION['user']) && $_SESSION['user']['cargo'] === $permission;
}

// Função para verificar se item está ativo
function isActive($itemPage, $currentPage)
{
    return strpos($currentPage, $itemPage) !== false;
}

// Função para verificar se dropdown deve estar aberto
function isDropdownOpen($children, $currentPage)
{
    foreach ($children as $child) {
        if (isActive($child['page'], $currentPage)) {
            return true;
        }
    }
    return false;
}
?>

<!-- Overlay para mobile -->
<div id="sidebar-overlay" class="sidebar-overlay"></div>

<!-- Menu Lateral -->
<aside id="sidebar" class="sidebar">
    <div class="sidebar-header">
        <div class="sidebar-brand">
            <i class="<?= $settings['brand_icon'] ?>"></i>
            <span class="brand-text"><?= $settings['brand_text'] ?></span>
        </div>
        <button id="sidebar-close" class="sidebar-close d-lg-none">
            <i class="fas fa-times"></i>
        </button>
    </div>

    <div class="sidebar-content">
        <nav class="sidebar-nav">
            <ul class="nav-list">
                <?php
                // Separar itens normais das configurações
                $normalItems = array_filter($menuItems, function ($item) {
                    return $item['id'] !== 'configuracoes';
                });
                $configItem = array_filter($menuItems, function ($item) {
                    return $item['id'] === 'configuracoes';
                });
                $configItem = !empty($configItem) ? reset($configItem) : null;
                ?>

                <?php foreach ($normalItems as $item): ?>
                <?php if (hasPermission($item['permission'])): ?>
                <li class="nav-item">
                    <?php if (empty($item['children'])): ?>
                    <!-- Item simples sem dropdown -->
                    <a href="<?= $item['link'] ?>"
                        class="nav-link <?= isActive($item['page'], $page ?? '') ? 'active' : '' ?>">
                        <i class="<?= $item['icon'] ?>"></i>
                        <span class="nav-text"><?= $item['title'] ?></span>
                    </a>
                    <?php else: ?>
                    <!-- Item com dropdown -->
                    <a href="#"
                        class="nav-link dropdown-toggle <?= isDropdownOpen($item['children'], $page ?? '') ? 'active' : '' ?>"
                        data-bs-target="#dropdown-<?= str_replace(' ', '', strtolower($item['title'])) ?>"
                        data-dropdown-type="normal"
                        aria-expanded="<?= isDropdownOpen($item['children'], $page ?? '') ? 'true' : 'false' ?>"
                        role="button">
                        <i class="<?= $item['icon'] ?>"></i>
                        <span class="nav-text"><?= $item['title'] ?></span>
                        <i class="fas fa-chevron-down dropdown-icon" style="content: none !important;"></i>
                    </a>

                    <!-- Submenu -->
                    <div class="collapse <?= isDropdownOpen($item['children'], $page ?? '') ? 'show' : '' ?>"
                        id="dropdown-<?= str_replace(' ', '', strtolower($item['title'])) ?>"
                        data-dropdown-type="normal">
                        <ul class="dropdown-menu-custom">
                            <?php foreach ($item['children'] as $child): ?>
                            <li>
                                <a href="<?= $child['link'] ?>"
                                    class="dropdown-link <?= isActive($child['page'], $page ?? '') ? 'active' : '' ?>">
                                    <i class="<?= $child['icon'] ?>"></i>
                                    <span><?= $child['title'] ?></span>
                                </a>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <?php endif; ?>
                </li>
                <?php endif; ?>
                <?php endforeach; ?>
            </ul>
        </nav>
    </div>

    <!-- Seção de configurações (bottom) -->
    <?php if ($configItem && hasPermission($configItem['permission'])): ?>
    <div class="sidebar-bottom-section">
        <div class="nav-divider"></div>
        <nav class="sidebar-nav">
            <ul class="nav-list">
                <li class="nav-item">
                    <!-- Item de configurações flutuante -->
                    <a href="#"
                        class="nav-link dropdown-toggle-floating <?= isDropdownOpen($configItem['children'], $page ?? '') ? 'active' : '' ?>"
                        data-bs-target="#dropdown-configuracoes" data-dropdown-type="floating"
                        aria-expanded="<?= isDropdownOpen($configItem['children'], $page ?? '') ? 'true' : 'false' ?>"
                        role="button">
                        <i class="<?= $configItem['icon'] ?>"></i>
                        <span class="nav-text"><?= $configItem['title'] ?></span>
                        <i class="fas fa-chevron-right dropdown-icon"></i>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
    <?php endif; ?>

    <!-- Footer da sidebar -->
    <div class="sidebar-footer">
        <div class="user-info">
            <?php if (isset($_SESSION['user'])): ?>
            <div class="user-avatar">
                <i class="fas fa-user-circle"></i>
            </div>
            <div class="user-details">
                <span class="user-name"><?= htmlspecialchars($_SESSION['user']['username']) ?></span>
                <span class="user-role"><?= htmlspecialchars($_SESSION['user']['cargo'] ?? 'Usuário') ?></span>
            </div>
            <?php endif; ?>
        </div>
    </div>
</aside>

<!-- Dropdown flutuante de configurações (fora da sidebar) -->
<?php if ($configItem && hasPermission($configItem['permission'])): ?>
<div class="collapse" id="dropdown-configuracoes" data-dropdown-type="floating">
    <ul class="dropdown-menu-floating">
        <?php foreach ($configItem['children'] as $child): ?>
        <li>
            <a href="<?= $child['link'] ?>"
                class="dropdown-link <?= isActive($child['page'], $page ?? '') ? 'active' : '' ?>">
                <i class="<?= $child['icon'] ?>"></i>
                <span><?= $child['title'] ?></span>
            </a>
        </li>
        <?php endforeach; ?>
    </ul>
</div>
<?php endif; ?>

<!-- Botão toggle para mobile -->
<button id="sidebar-toggle" class="sidebar-toggle d-lg-none">
    <i class="fas fa-bars"></i>
</button>