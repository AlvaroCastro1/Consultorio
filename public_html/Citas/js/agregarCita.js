
function guardarCita() {
    var patientId = document.getElementById('input-IDpaciente').value;
    var eventDate = document.getElementById('eventDate').value;
    var eventTime = document.getElementById('eventTime').value;
    var eventAttendance = document.getElementById('eventAttendance').checked ? 1 : 0;

    $.ajax({
        url: '../Calendario/guardar_cita.php',
        type: 'POST',
        data: {
            patientId: patientId,
            eventDate: eventDate,
            eventTime: eventTime,
            eventAttendance: eventAttendance
        },
        success: function(response) {
            alert(response);
            location.reload();
            cargarCitas();
            $('#modalAgregar').modal('hide');
        },
        error: function(error) {
            alert('Error al guardar la cita: ' + error);
        }
    });
}
