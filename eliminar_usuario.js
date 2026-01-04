// Variable global para almacenar el ID del usuario que queremos eliminar
let idUsuarioEliminar = null;

// Función para abrir el modal de confirmación
function abrirModal(id, nombre) {
    idUsuarioEliminar = id;

    // Cambiamos el texto del modal para mostrar el nombre del usuario
    document.getElementById("textoModal").innerText =
        "¿Seguro que deseas eliminar al usuario '" + nombre + "'?";

    // Mostramos el modal
    document.getElementById("modalEliminar").style.display = "block";
}

// Función para cerrar el modal
function cerrarModal() {
    document.getElementById("modalEliminar").style.display = "none";
    idUsuarioEliminar = null;
}

// Función que llama al PHP para eliminar el usuario
function eliminarUsuario() {

    // Evitar llamadas vacías
    if (!idUsuarioEliminar) return;

    // Codificamos el ID de usuario para seguridad
    const bodyData = "id_usuario=" + encodeURIComponent(idUsuarioEliminar);

    fetch("eliminar_usuario_seleccionado.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: "id_usuario=" + idUsuarioEliminar
    })
        .then(res => {
            if (!res.ok) throw new Error();
            location.reload();
        })
        .catch(() => {
            alert("No puedes eliminar este usuario");
        });
}
