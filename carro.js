// Funcion para actualizar el carrito de la compra
function actualizarCarro(id_carro, accion) {

    // Crear un objeto FormData para enviar los datos por POST
    const formData = new FormData();
    formData.append('id_carro', id_carro);
    formData.append('accion', accion);

    // Enviar los datos al servidor mediante fetch
    fetch('actualizar_carro.php', { method: 'POST', body: formData })
        .then(res => res.json())
        .then(data => {
            if (data.ok) {

                // Actualizar lista y contador
                const lista = document.getElementById('lista-productos');
                lista.innerHTML = data.html;
                const contador = Number(data.contador);
                document.getElementById('contador-carrito').innerText = contador;

                // Mostrar u ocultar el botón de finalizar segun el contador
                const botonFinalizar = document.querySelector('.boton-finalizar');
                if (botonFinalizar) {
                    if (contador > 0) {
                        botonFinalizar.style.display = 'flex';
                    } else {
                        botonFinalizar.style.display = 'none';
                    }
                }
            } else {
                alert(data.error);
            }
        });
}

// Función para finalizar la compra
function finalizarCompra() {

    //Enviar petición al servidor para procesar la compra
    fetch('finalizar_compra.php', { method: 'POST' })
        .then(res => res.json())
        .then(data => {
            if (data.ok) {

                // Vaciar la lista de productos en la página
                const lista = document.getElementById('lista-productos');
                lista.innerHTML = '<p id="carrito-vacio">Carrito vacío</p>';

                // Reiniciar el contador a 0
                document.getElementById('contador-carrito').innerText = '0';

                // Ocultar el botón de finalizar
                const botonFinalizar = document.querySelector('.boton-finalizar');
                if (botonFinalizar) botonFinalizar.style.display = 'none';

                // Mostrar modal de éxito
                document.getElementById('modal-exito').style.display = 'flex';
            } else {
                alert(data.error);
            }
        });
}
