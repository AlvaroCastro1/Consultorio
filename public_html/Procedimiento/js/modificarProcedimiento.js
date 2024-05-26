window.ModificarProcedimiento = function() {
    let idDetalleProcedimiento = $('#modalModificar').data('id');
    let nombreProcedimiento = $('#nombreProcedimientoInputModificar').val();
    let descripcionProcedimiento = $('#descripcionProcedimientoInputModificar').val();
    let observaciones = $('#observacionesProcedimientoInputModificar').val();
    let fechaProcedimiento = $('#fechaProcedimientoInputModificar').val();

    $.ajax({
        type: 'POST',
        url: 'modificar_procedimientos.php',
        data: {
            idDetalleProcedimiento: idDetalleProcedimiento,
            nombreProcedimiento: nombreProcedimiento,
            descripcionProcedimiento: descripcionProcedimiento,
            observaciones: observaciones,
            fechaProcedimiento: fechaProcedimiento
        },
        success: function(response) {
            let result = JSON.parse(response);
            if (result.success) {
                
                alert("Se modificó con exito el registro")
                location.reload();
                // Cerrar el modal
                $('#modalModificar').modal('hide');
            } else {
                alert(result.error || 'Error al modificar el procedimiento.');
            }
        },
        error: function(xhr, status, error) {
            console.error('Error en la solicitud AJAX:', error);
            alert('Error al modificar el procedimiento.');
        }
    });
}
