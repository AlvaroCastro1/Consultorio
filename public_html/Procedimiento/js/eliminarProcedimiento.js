window.eliminarProcedimiento = function(idDetalleProcedimiento) {
    console.log(idDetalleProcedimiento);
    if (confirm("¿Estás seguro de que deseas eliminar este procedimiento?")) {
        $.ajax({
            type: 'POST',
            url: 'eliminar_procedimientos.php',
            data: { idDetalleProcedimiento: idDetalleProcedimiento },
            success: function(response) {
                try {
                    let result = JSON.parse(response);
                    if (result.success) {
                        // Eliminar la fila de la tabla
                        alert("Procedimiento borrado correctamente");
                        location.reload();
                    } else {
                        alert(result.error || 'Error al eliminar el procedimiento.');
                    }
                } catch (e) {
                    console.error('Error al parsear la respuesta:', e);
                    alert('Error al eliminar el procedimiento.');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error en la solicitud AJAX:', error);
                alert('Error al eliminar el procedimiento.');
            }
        });
    }
}
