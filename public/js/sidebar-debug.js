// Debug específico para SIDEBAR - não interfere com navbar
document.addEventListener("DOMContentLoaded", function () {
  console.log("🔧 Debug de Sidebar carregado");

  // Verificar se elementos da SIDEBAR existem
  const sidebar = document.getElementById("sidebar");
  if (!sidebar) {
    console.log("❌ Sidebar não encontrada");
    return;
  }

  const sidebarDropdowns = sidebar.querySelectorAll(".dropdown-toggle");
  console.log("📋 Dropdowns da SIDEBAR encontrados:", sidebarDropdowns.length);

  sidebarDropdowns.forEach((dropdown, index) => {
    console.log(`Sidebar Dropdown ${index + 1}:`, dropdown.textContent.trim());
  });

  // Verificar dropdowns do NAVBAR separadamente
  const navbar = document.querySelector(".navbar");
  if (navbar) {
    const navbarDropdowns = navbar.querySelectorAll(".dropdown-toggle");
    console.log("📋 Dropdowns do NAVBAR encontrados:", navbarDropdowns.length);

    navbarDropdowns.forEach((dropdown, index) => {
      console.log(`Navbar Dropdown ${index + 1}:`, dropdown.textContent.trim());
    });
  }

  // Função de teste específica para sidebar
  window.testSidebarDropdown = function (index = 0) {
    const dropdown = sidebar.querySelectorAll(".dropdown-toggle")[index];
    if (dropdown) {
      dropdown.click();
      console.log("✅ Sidebar Dropdown testado:", dropdown.textContent.trim());
    } else {
      console.log("❌ Sidebar Dropdown não encontrado no índice:", index);
    }
  };

  // Função de teste específica para navbar
  window.testNavbarDropdown = function (index = 0) {
    if (!navbar) {
      console.log("❌ Navbar não encontrada");
      return;
    }

    const dropdown = navbar.querySelectorAll(".dropdown-toggle")[index];
    if (dropdown) {
      // Simular clique no dropdown do navbar
      const event = new Event("click", { bubbles: true });
      dropdown.dispatchEvent(event);
      console.log("✅ Navbar Dropdown testado:", dropdown.textContent.trim());
    } else {
      console.log("❌ Navbar Dropdown não encontrado no índice:", index);
    }
  };

  console.log(
    "💡 Execute window.testSidebarDropdown(0) para testar dropdown da sidebar"
  );
  console.log(
    "💡 Execute window.testNavbarDropdown(0) para testar dropdown do navbar"
  );
});
