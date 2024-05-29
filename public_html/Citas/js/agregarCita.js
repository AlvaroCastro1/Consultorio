/**
 * Función para guardar una cita médica.
 * 
 * Esta función recopila los datos ingresados en el formulario de la cita, realiza una solicitud AJAX para
 * enviar estos datos al servidor y maneja la respuesta del servidor. También recarga la página y actualiza
 * la lista de citas al guardar una cita exitosamente.
 */
function guardarCita() {
    // Obtener los valores de los campos del formulario
    var patientId = document.getElementById('input-IDpaciente').value;
    var eventDate = document.getElementById('eventDate').value;
    var eventTime = document.getElementById('eventTime').value;
    var eventAttendance = document.getElementById('eventAttendance').checked ? 1 : 0;

    // Realizar una solicitud AJAX para guardar la cita
    $.ajax({
        url: '../Calendario/guardar_cita.php', // URL del servidor para guardar la cita
        type: 'POST', // Tipo de solicitud HTTP
        data: {
            patientId: patientId,       // ID del paciente
            eventDate: eventDate,       // Fecha del evento
            eventTime: eventTime,       // Hora del evento
            eventAttendance: eventAttendance // Asistencia al evento (1 para asistió, 0 para no asistió)
        },
        success: function(response) {
            // Mostrar un mensaje de éxito al usuario
            alert(response);
            // Recargar la página para reflejar los cambios
            location.reload();
            // Actualizar la lista de citas
            cargarCitas();
            // Ocultar el modal de agregar cita
            $('#modalAgregar').modal('hide');
        },
        error: function(error) {
            // Mostrar un mensaje de error al usuario
            alert('Error al guardar la cita: ' + error);
        }
    });
}
/**
 * Función para guardar una cita médica.
 * 
 * Esta función recopila los datos ingresados en el formulario de la cita, realiza una solicitud AJAX para
 * enviar estos datos al servidor y maneja la respuesta del servidor. También recarga la página y actualiza
 * la lista de citas al guardar una cita exitosamente.
 */
function guardarCita() {
    // Obtener los valores de los campos del formulario
    var patientId = document.getElementById('input-IDpaciente').value;
    var eventDate = document.getElementById('eventDate').value;
    var eventTime = document.getElementById('eventTime').value;
    var eventAttendance = document.getElementById('eventAttendance').checked ? 1 : 0;

    // Realizar una solicitud AJAX para guardar la cita
    $.ajax({
        url: '../Calendario/guardar_cita.php', // URL del servidor para guardar la cita
        type: 'POST', // Tipo de solicitud HTTP
        data: {
            patientId: patientId,       // ID del paciente
            eventDate: eventDate,       // Fecha del evento
            eventTime: eventTime,       // Hora del evento
            eventAttendance: eventAttendance // Asistencia al evento (1 para asistió, 0 para no asistió)
        },
        success: function(response) {
            // Mostrar un mensaje de éxito al usuario
            alert(response);
            // Recargar la página para reflejar los cambios
            location.reload();
            // Actualizar la lista de citas
            cargarCitas();
            // Ocultar el modal de agregar cita
            $('#modalAgregar').modal('hide');
        },
        error: function(error) {
            // Mostrar un mensaje de error al usuario
            alert('Error al guardar la cita: ' + error);
        }
    });
}
