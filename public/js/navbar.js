// Controle responsivo do menu hamburguer/navbar
// Garante que o menu fique sempre expandido no desktop e colapsado no mobile

document.addEventListener("DOMContentLoaded", function () {
  function handleNavbarCollapse() {
    var navbarCollapse = document.querySelector(".navbar-collapse");
    var navbarToggler = document.querySelector(".navbar-toggler");
    if (!navbarCollapse) return;

    if (window.innerWidth >= 992) {
      // Desktop: sempre expandido
      navbarCollapse.classList.add("show");
      if (navbarToggler) navbarToggler.setAttribute("aria-expanded", "true");
    } else {
      // Mobile: sempre colapsado
      navbarCollapse.classList.remove("show");
      if (navbarToggler) navbarToggler.setAttribute("aria-expanded", "false");
    }
  }

  // Executa ao carregar e ao redimensionar
  handleNavbarCollapse();
  window.addEventListener("resize", handleNavbarCollapse);
});
