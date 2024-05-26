import { idPaciente, idExpediente, obtenerDatosSession } from '../../Estudios/js/obtenerExpediente.js';


window.agregarProcedimiento = function () {
    obtenerDatosSession();
    var idE = idExpediente; // Asegúrate de obtener el ID del expediente

    // Obtener los valores de los campos del modal
    var nombreProcedimiento = $('#nombreProcedimientoInput').val();
    var descripcionProcedimiento = $('#descripcionProcedimientoInput').val();
    var observaciones = $('#observacionesProcedimientoInput').val();
    var fechaProcedimiento = $('#fechaProcedimientoInput').val();

    $.ajax({
        type: 'POST',
        url: 'guardar_procedimientos.php',
        data: {
            nombreProcedimiento: nombreProcedimiento,
            descripcionProcedimiento: descripcionProcedimiento,
            observaciones: observaciones,
            fechaProcedimiento: fechaProcedimiento,
            idExpediente: idE
        },
        success: function(response) {
            let result = JSON.parse(response);
            if (result.success) {
                // Cerrar el modal
                $('#modalAgregar').modal('hide');
                location.reload();
                // Recargar la tabla de procedimientos
                cargarProcedimientos();
            } else {
                console.error('Error al guardar el procedimiento');
            }
        },
        error: function(xhr, status, error) {
            console.error('Error en la solicitud AJAX:', error);
        }
    });
}
