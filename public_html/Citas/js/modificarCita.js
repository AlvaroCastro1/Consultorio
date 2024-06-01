/**
 * Función para modificar una cita médica.
 * 
 * Esta función toma el índice de una fila en la tabla de citas, recupera los datos de la cita de esa fila y 
 * los coloca en los campos de un modal para permitir la modificación de la cita.
 *
 * @param {number} rowIndex - El índice de la fila de la tabla de citas.
 */
function modificarCita(rowIndex) {
    // Obtén la tabla y la fila correspondiente
    var table = document.getElementById('tabla-Citas');
    var row = table.rows[rowIndex];

    // Verifica si la fila existe y tiene al menos 5 celdas
    if (row && row.cells.length >= 5) {
        // Recupera los valores de las celdas de la fila
        var idCita = row.cells[0].innerText;
        var idPacienteC = row.cells[1].innerText;
        var fecha = row.cells[2].innerText;
        var hora = row.cells[3].innerText;
        var asistencia = row.cells[4].innerText == 'Asistió';
        console.log('Texto de la celda:', row.cells[4].innerText);

        // Obtén los elementos del modal por su id
        var idCitaInput = document.getElementById('input-idCita');
        var idPacienteInput = document.getElementById('input-IDpacienteModificar');
        var fechaInput = document.getElementById('eventDateModificar');
        var horaInput = document.getElementById('eventTimeModificar');
        var asistenciaInput = document.getElementById('eventAttendanceModificar');
        var fechaInputOculto = document.getElementById('ocultoEventDate');
        var horaInputOculto = document.getElementById('ocultoEventTime');

        // Verifica si los elementos existen antes de intentar establecer su valor
        if (idCitaInput && idPacienteInput && fechaInput && horaInput && asistenciaInput) {
            // Coloca los datos de la fila en los campos del modal
            idCitaInput.value = idCita;
            idPacienteInput.value = idPacienteC;
            fechaInput.value = fecha;
            horaInput.value = hora;
            asistenciaInput.checked = asistencia;
            fechaInputOculto.value = fecha;
            horaInputOculto.value = hora;

            // Abre el modal
            $('#modalModificar').modal('show');
        } else {
            console.error('Alguno de los elementos input no se encontró.');
        }
    } else {
        console.error('La fila o las celdas no están definidas correctamente.');
    }
}

/**
 * Función para guardar la modificación de una cita médica.
 * 
 * Esta función toma los datos del formulario de modificación de cita, realiza una solicitud AJAX para
 * enviar los datos al servidor y maneja la respuesta del servidor.
 */
function guardarModificacionCita() {
    // Obtén los valores de los campos del formulario
    var idCita = document.getElementById('input-idCita').value;
    var idPaciente = document.getElementById('input-IDpacienteModificar').value;
    var fecha = document.getElementById('eventDateModificar').value;
    var hora = document.getElementById('eventTimeModificar').value;
    var asistencia = document.getElementById('eventAttendanceModificar').checked ? 1 : 0;

    console.log(idCita);
    var data = {
        citaId: idCita,
        patientId: idPaciente,
        eventDate: fecha,
        eventTime: hora,
        eventAttendance: asistencia
    };

    // Realizar una solicitud AJAX para guardar la modificación de la cita
    $.ajax({
        url: '../Calendario/modificar_cita.php', // URL del servidor para modificar la cita
        method: 'POST', // Tipo de solicitud HTTP
        data: data, // Datos enviados en la solicitud
        success: function(response) {
            if (response === 'Cita modificada correctamente') {
                // Mostrar un mensaje de éxito al usuario
                alert('Cita modificada correctamente');
                // Ocultar el modal
                $('#modalModificar').modal('hide');
                // Recargar la página para reflejar los cambios
                location.reload();
            } else {
                console.log('Error al modificar la cita: ' + response);
            }
        },
        error: function(xhr, status, error) {
            console.error('Error al modificar la cita');
            console.error(xhr.responseText);
        }
    });
}
