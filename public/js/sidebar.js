/**
 * Sistema de Menu Lateral com Dropdown
 * Gerencia a funcionalidade do menu lateral incluindo:
 * - Toggle do menu em dispositivos móveis
 * - Dropdowns com animações
 * - Responsividade
 * - Estado ativo dos itens
 * - Modo compacto para desktop
 */

class SidebarManager {
  constructor() {
    this.sidebar = document.getElementById("sidebar");
    this.overlay = document.getElementById("sidebar-overlay");
    this.toggleBtn = document.getElementById("sidebar-toggle");
    this.closeBtn = document.getElementById("sidebar-close");
    this.body = document.body;
    this.isCompact = false;
    this.isMobile = window.innerWidth < 992;

    this.init();
  }

  init() {
    this.setupEventListeners();
    this.setupResponsive();
    this.setupDropdowns();
    this.setupTooltips();
    this.setInitialState();
  }

  setupEventListeners() {
    // Toggle sidebar em mobile
    if (this.toggleBtn) {
      this.toggleBtn.addEventListener("click", () => this.toggleSidebar());
    }

    // Fechar sidebar
    if (this.closeBtn) {
      this.closeBtn.addEventListener("click", () => this.closeSidebar());
    }

    // Overlay click para fechar
    if (this.overlay) {
      this.overlay.addEventListener("click", () => this.closeSidebar());
    }

    // Tecla ESC para fechar
    document.addEventListener("keydown", (e) => {
      if (e.key === "Escape" && this.sidebar.classList.contains("show")) {
        this.closeSidebar();
      }
    });

    // Resize da janela
    window.addEventListener("resize", () => this.handleResize());

    // Double click para toggle compacto no desktop
    if (this.sidebar) {
      this.sidebar.addEventListener("dblclick", (e) => {
        if (!this.isMobile && e.target.closest(".sidebar-header")) {
          this.toggleCompactMode();
        }
      });
    }
  }

  setupResponsive() {
    this.handleResize();
  }

  setupDropdowns() {
    // Usar event delegation para evitar problemas com múltiplos listeners
    // IMPORTANTE: Apenas para dropdowns da SIDEBAR, não do navbar
    this.sidebar.addEventListener("click", (e) => {
      const toggle = e.target.closest(
        ".sidebar .dropdown-toggle, .sidebar .dropdown-toggle-floating"
      );
      if (toggle) {
        e.preventDefault();
        e.stopPropagation();
        this.toggleDropdown(toggle);
      }
    });

    // Fechar dropdowns da sidebar ao clicar fora (mas não afetar navbar)
    document.addEventListener("click", (e) => {
      if (
        !this.sidebar.contains(e.target) &&
        !this.isClickInFloatingMenu(e.target) &&
        !e.target.closest(".navbar") // Não fechar se clicou no navbar
      ) {
        this.closeAllDropdowns();
      }
    });

    // Fechar dropdown flutuante da sidebar ao pressionar ESC
    document.addEventListener("keydown", (e) => {
      if (e.key === "Escape") {
        this.closeAllDropdowns();
      }
    });
  }

  isClickInFloatingMenu(target) {
    return target.closest(".dropdown-menu-floating") !== null;
  }

  setupTooltips() {
    const navLinks = this.sidebar.querySelectorAll(".nav-link");

    navLinks.forEach((link) => {
      const text = link.querySelector(".nav-text")?.textContent;
      if (text) {
        link.setAttribute("data-tooltip", text);
      }
    });
  }

  setInitialState() {
    // Verificar se has-sidebar já existe, se não adicionar
    if (!this.body.classList.contains("has-sidebar")) {
      this.body.classList.add("has-sidebar");
    }

    // Estado inicial baseado no tamanho da tela
    if (this.isMobile) {
      this.sidebar.classList.remove("show");
      this.overlay.classList.remove("show");
    }

    // Adicionar classe para indicar que a sidebar foi carregada (sem delay)
    this.body.classList.add("sidebar-loaded");
  }

  toggleSidebar() {
    if (this.isMobile) {
      const isOpen = this.sidebar.classList.contains("show");

      if (isOpen) {
        this.closeSidebar();
      } else {
        this.openSidebar();
      }
    }
  }

  openSidebar() {
    this.sidebar.classList.add("show");
    this.overlay.classList.add("show");
    this.body.classList.add("sidebar-open");

    // Prevenir scroll do body
    this.body.style.overflow = "hidden";

    // Focus no primeiro link
    const firstLink = this.sidebar.querySelector(".nav-link");
    if (firstLink) {
      setTimeout(() => firstLink.focus(), 300);
    }

    // Disparar evento personalizado
    const event = new CustomEvent("sidebar:opened");
    document.dispatchEvent(event);
  }

  closeSidebar() {
    this.sidebar.classList.remove("show");
    this.overlay.classList.remove("show");
    this.body.classList.remove("sidebar-open");

    // Restaurar scroll do body
    this.body.style.overflow = "";

    // Retornar focus para o botão toggle
    if (this.toggleBtn) {
      this.toggleBtn.focus();
    }

    // Disparar evento personalizado
    const event = new CustomEvent("sidebar:closed");
    document.dispatchEvent(event);
  }

  toggleDropdown(toggle) {
    const targetId = toggle.getAttribute("data-bs-target");
    const target = document.querySelector(targetId);

    if (!target) {
      console.error("Target não encontrado:", targetId);
      return;
    }

    const isExpanded = target.classList.contains("show");

    if (isExpanded) {
      this.closeDropdown(toggle, target);
    } else {
      this.openDropdown(toggle, target);
    }
  }

  openDropdown(toggle, target) {
    // Fechar outros dropdowns primeiro
    this.closeAllDropdowns(toggle);

    // Definir estado do toggle
    toggle.setAttribute("aria-expanded", "true");
    toggle.classList.add("active");

    // Verificar se é dropdown flutuante
    const isFloating = toggle.getAttribute("data-dropdown-type") === "floating";

    if (isFloating) {
      this.positionFloatingDropdown(toggle, target);
    }

    // Mostrar o target simplesmente
    target.classList.add("show");
    target.style.display = "block";
  }

  positionFloatingDropdown(toggle, target) {
    const toggleRect = toggle.getBoundingClientRect();
    const menu = target.querySelector(".dropdown-menu-floating");

    if (!menu) return;

    // Calcular posição horizontal baseada na posição real do botão
    const leftPosition = toggleRect.right + 10; // 10px à direita do botão

    // Aplicar posição horizontal ao container principal
    target.style.left = `${leftPosition}px`;

    // Reset position para calcular tamanho correto
    menu.style.top = "0px";

    // Temporariamente mostrar para calcular dimensões
    menu.style.visibility = "visible";
    menu.style.opacity = "0";

    const menuRect = menu.getBoundingClientRect();
    const viewportHeight = window.innerHeight;

    // Calcular posição vertical baseada no centro do botão (levantado mais)
    let topPosition =
      toggleRect.top + toggleRect.height / 2 - menuRect.height / 2 - 120;

    // Verificar se vai ultrapassar a parte inferior da tela
    if (topPosition + menuRect.height > viewportHeight - 20) {
      topPosition = viewportHeight - menuRect.height - 20;
    }

    // Verificar se vai ultrapassar a parte superior da tela
    if (topPosition < 20) {
      topPosition = 20;
    }

    // Aplicar posição final ao container
    target.style.top = `${topPosition}px`;

    // Definir origem da transformação baseado na posição
    const buttonCenter = toggleRect.top + toggleRect.height / 2;
    const menuCenter = topPosition + menuRect.height / 2;

    if (Math.abs(menuCenter - buttonCenter) < 10) {
      menu.setAttribute("data-position", "center");
    } else if (menuCenter < buttonCenter) {
      menu.setAttribute("data-position", "bottom");
    } else {
      menu.setAttribute("data-position", "top");
    }

    // Restaurar visibilidade
    menu.style.visibility = "";
    menu.style.opacity = "";
  }

  closeDropdown(toggle, target) {
    // Definir estado do toggle
    toggle.setAttribute("aria-expanded", "false");
    toggle.classList.remove("active");

    // Esconder o target simplesmente
    target.classList.remove("show");
    target.style.display = "none";
  }

  closeAllDropdowns(exceptToggle = null) {
    // Apenas fechar dropdowns da SIDEBAR, não do navbar
    const openDropdowns = this.sidebar.querySelectorAll(
      '.sidebar .dropdown-toggle[aria-expanded="true"], .sidebar .dropdown-toggle-floating[aria-expanded="true"]'
    );

    openDropdowns.forEach((toggle) => {
      // Não fechar o dropdown que estamos abrindo
      if (toggle === exceptToggle) return;

      const targetId = toggle.getAttribute("data-bs-target");
      const target = document.querySelector(targetId);
      if (target) {
        this.closeDropdown(toggle, target);
      }
    });
  }

  toggleCompactMode() {
    this.isCompact = !this.isCompact;

    if (this.isCompact) {
      this.body.classList.add("sidebar-compact");
      this.closeAllDropdowns();
    } else {
      this.body.classList.remove("sidebar-compact");
    }

    // Reposicionar dropdowns flutuantes após mudança de modo
    setTimeout(() => {
      this.repositionFloatingDropdowns();
    }, 300); // Aguardar animação da sidebar

    // Salvar preferência
    localStorage.setItem("sidebar-compact", this.isCompact);

    // Disparar evento personalizado para outras partes do sistema
    const event = new CustomEvent("sidebar:compact", {
      detail: { isCompact: this.isCompact },
    });
    document.dispatchEvent(event);
  }

  handleResize() {
    const newIsMobile = window.innerWidth < 992;

    if (newIsMobile !== this.isMobile) {
      this.isMobile = newIsMobile;

      if (this.isMobile) {
        // Mobile: fechar sidebar e remover modo compacto
        this.closeSidebar();
        this.body.classList.remove("sidebar-compact");
      } else {
        // Desktop: fechar overlay e restaurar modo compacto se necessário
        this.overlay.classList.remove("show");
        this.body.style.overflow = "";

        const savedCompact = localStorage.getItem("sidebar-compact") === "true";
        if (savedCompact) {
          this.body.classList.add("sidebar-compact");
          this.isCompact = true;
        }
      }
    }

    // Reposicionar dropdowns flutuantes abertos
    this.repositionFloatingDropdowns();
  }

  repositionFloatingDropdowns() {
    // Apenas reposicionar dropdowns flutuantes da SIDEBAR
    const openFloatingDropdowns = this.sidebar.querySelectorAll(
      '.sidebar .dropdown-toggle-floating[aria-expanded="true"]'
    );

    openFloatingDropdowns.forEach((toggle) => {
      const targetId = toggle.getAttribute("data-bs-target");
      const target = document.querySelector(targetId);
      if (target && target.classList.contains("show")) {
        // Reposicionar baseado na posição atual do botão
        this.positionFloatingDropdown(toggle, target);
      }
    });
  }

  // Métodos públicos para controle externo
  open() {
    this.openSidebar();
  }

  close() {
    this.closeSidebar();
  }

  toggle() {
    this.toggleSidebar();
  }

  setCompact(compact) {
    if (compact !== this.isCompact) {
      this.toggleCompactMode();
    }
  }

  // Método para adicionar novos itens dinamicamente
  addMenuItem(parentId, item) {
    const parent = document.querySelector(parentId);
    if (parent) {
      const li = this.createMenuItemElement(item);
      parent.appendChild(li);
      this.setupDropdowns(); // Re-setup dropdowns
    }
  }

  createMenuItemElement(item) {
    const li = document.createElement("li");
    li.className = "nav-item";

    if (!item.children || item.children.length === 0) {
      // Item simples
      li.innerHTML = `
                <a href="${item.link}" class="nav-link" data-tooltip="${item.title}">
                    <i class="${item.icon}"></i>
                    <span class="nav-text">${item.title}</span>
                </a>
            `;
    } else {
      // Item com dropdown
      const dropdownId = `dropdown-${item.title
        .toLowerCase()
        .replace(/\s+/g, "")}`;

      li.innerHTML = `
                <a href="#" class="nav-link dropdown-toggle" 
                   data-bs-toggle="collapse" 
                   data-bs-target="#${dropdownId}"
                   aria-expanded="false"
                   data-tooltip="${item.title}">
                    <i class="${item.icon}"></i>
                    <span class="nav-text">${item.title}</span>
                    <i class="fas fa-chevron-down dropdown-icon" style="content: none !important;"></i>
                </a>
                <div class="collapse" id="${dropdownId}">
                    <ul class="dropdown-menu-custom">
                        ${item.children
                          .map(
                            (child) => `
                            <li>
                                <a href="${child.link}" class="dropdown-link">
                                    <i class="${child.icon}"></i>
                                    <span>${child.title}</span>
                                </a>
                            </li>
                        `
                          )
                          .join("")}
                    </ul>
                </div>
            `;
    }

    return li;
  }

  // Método para destacar item ativo
  setActiveItem(page) {
    // Remover todas as classes active
    this.sidebar
      .querySelectorAll(".nav-link, .dropdown-link")
      .forEach((link) => {
        link.classList.remove("active");
      });

    // Adicionar active ao item atual
    const activeLink = this.sidebar.querySelector(`[href*="${page}"]`);
    if (activeLink) {
      activeLink.classList.add("active");

      // Se for um dropdown item, abrir o dropdown pai
      const dropdown = activeLink.closest(".collapse");
      if (dropdown) {
        dropdown.classList.add("show");
        const toggle = this.sidebar.querySelector(
          `[data-bs-target="#${dropdown.id}"]`
        );
        if (toggle) {
          toggle.setAttribute("aria-expanded", "true");
          toggle.classList.add("active");
        }
      }
    }
  }
}

// Inicializar quando o DOM estiver carregado
document.addEventListener("DOMContentLoaded", function () {
  window.sidebarManager = new SidebarManager();

  // Auto-detectar página atual e destacar item ativo
  const currentPath = window.location.pathname;
  const currentPage = currentPath.split("/").pop() || "index.php";
  window.sidebarManager.setActiveItem(currentPage);
});

// Exportar para uso em outros scripts
if (typeof module !== "undefined" && module.exports) {
  module.exports = SidebarManager;
}
