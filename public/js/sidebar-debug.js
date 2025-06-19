// Debug simples para testar dropdowns
document.addEventListener("DOMContentLoaded", function () {
  console.log("🔧 Debug de Sidebar carregado");

  // Verificar se elementos existem
  const dropdowns = document.querySelectorAll(".dropdown-toggle");
  console.log("📋 Dropdowns encontrados:", dropdowns.length);

  dropdowns.forEach((dropdown, index) => {
    console.log(`Dropdown ${index + 1}:`, dropdown.textContent.trim());
  });

  // Função de teste
  window.testDropdown = function (index = 0) {
    const dropdown = document.querySelectorAll(".dropdown-toggle")[index];
    if (dropdown) {
      dropdown.click();
      console.log("✅ Dropdown testado:", dropdown.textContent.trim());
    } else {
      console.log("❌ Dropdown não encontrado no índice:", index);
    }
  };

  console.log(
    "💡 Execute window.testDropdown(0) para testar o primeiro dropdown"
  );
});
