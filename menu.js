//Espera a que el DOM esté completamente cargado
document.addEventListener("DOMContentLoaded", () => {

  // Obtenemos los elementos del DOM
  const menu = document.getElementById("menu_usuario");
  const logo = document.getElementById("usuario");

  // Función para alternar visibilidad del menú
  function toggleMenuUsuario() {
    menu.classList.toggle("mostrar");
  }

  // Abrir/cerrar menú al hacer clic en el logo
  logo.addEventListener("click", toggleMenuUsuario);

  // Cerrar menú al hacer clic fuera
  window.addEventListener("click", function (event) {
    if (!menu.contains(event.target) && event.target !== logo) {
      menu.classList.remove("mostrar");
    }
  });
});