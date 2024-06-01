/**
 * Función para eliminar una cita médica.
 * 
 * Esta función solicita confirmación del usuario antes de proceder a eliminar una cita. Si el usuario confirma,
 * se realiza una solicitud AJAX para eliminar la cita en el servidor. Maneja tanto la respuesta exitosa como
 * los errores de la solicitud.
 *
 * @param {number} idCita - El ID de la cita a eliminar.
 */
function eliminarCita(idCita) {
    // Solicitar confirmación al usuario antes de eliminar la cita
    if (confirm('¿Está seguro de que desea eliminar esta cita?')) {
        // Realizar una solicitud AJAX para eliminar la cita
        $.ajax({
            url: '../Calendario/eliminar_cita.php', // URL del servidor para eliminar la cita
            type: 'POST', // Tipo de solicitud HTTP
            data: { id: idCita }, // Datos enviados en la solicitud (ID de la cita)
        })
        .done(function(response) {
            // Mostrar un mensaje de éxito al usuario
            alert('La cita ha sido eliminada exitosamente');
            // Recargar la página para reflejar los cambios
            location.reload();
        })
        .fail(function(xhr, status, error) {
            // Mostrar un mensaje de error al usuario
            alert('Error al eliminar la cita');
            // Imprimir el error en la consola para propósitos de depuración
            console.error(xhr.responseText);
        });
    }
}
