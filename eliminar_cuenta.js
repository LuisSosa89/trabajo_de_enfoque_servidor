// Espera a que todo el DOM esté cargado antes de ejecutar el código
document.addEventListener('DOMContentLoaded', () => {

    // Obtiene el botón que abre el popup (Eliminar cuenta)
    const abrirPopupBtn = document.getElementById('abrirPopup');

    // Agrega un evento click al botón
    abrirPopupBtn.addEventListener('click', (e) => {
        e.preventDefault();

        const popup = document.createElement('div');
        popup.classList.add('popup');

        // Crea un div que será el contenedor del popup
        popup.innerHTML = `
        <div class="popup-contenido">
            <p>¿Seguro que quieres eliminar tu cuenta?</p>
            <button type="button" id="eliminarCuenta">Eliminar</button>
            <button type="button" id="cancelarPopup">Cancelar</button>
        </div>
    `;

        // Añade el popup al body para que se muestre en pantalla
        document.body.appendChild(popup);

        // Evento para el botón "Cancelar": elimina el popup
        popup.querySelector('#cancelarPopup').onclick = () => popup.remove();

        // Evento para el botón "Eliminar": redirige a eliminar_cuenta.php
        popup.querySelector('#eliminarCuenta').onclick = () => {
            window.location.href = 'eliminar_cuenta.php';
        };
    });
});