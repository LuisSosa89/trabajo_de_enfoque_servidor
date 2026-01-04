// Se ejecuta cuando el DOM está completamente cargado
document.addEventListener('DOMContentLoaded', () => {

    // Variable para almacenar el producto que se va a eliminar
    let productoSeleccionado = null;

    // Abrir modal al hacer click en un producto
    document.querySelectorAll('.producto').forEach(producto => {
        producto.addEventListener('click', () => {
            productoSeleccionado = producto;
            document.getElementById('modalEliminar').style.display = 'flex';
        });
    });

    // Cancelar la eliminación
    document.getElementById('cancelarEliminar').addEventListener('click', () => {
        document.getElementById('modalEliminar').style.display = 'none';
        productoSeleccionado = null;
    });

    // Confirmar eliminación
    document.getElementById('confirmarEliminar').addEventListener('click', () => {

        if (!productoSeleccionado) return;

        const id = productoSeleccionado.dataset.id;

        // Hacemos la petición al PHP para eliminar el producto
        fetch('eliminar_producto_definitivamente.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: 'id_producto=' + encodeURIComponent(id)
        })
            .then(response => response.json())
            .then(data => {
                if (data.ok) {
                    productoSeleccionado.remove(); // 🔥 borra del DOM
                    document.getElementById('modalEliminar').style.display = 'none';
                    productoSeleccionado = null;
                } else {
                    alert('Error al eliminar el producto');
                }
            })
            .catch(error => {
                console.error(error);
                alert('Error en la petición');
            });

    });

});