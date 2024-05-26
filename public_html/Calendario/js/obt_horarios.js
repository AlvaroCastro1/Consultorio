document.addEventListener('DOMContentLoaded', function() {
    $('#addEventModal').on('show.bs.modal', function() {
        var fechaSeleccionada = $('#eventDate').val();
        cargarHorarios('#eventTime', fechaSeleccionada,null,null);
    });

    $('#eventDate').on('change', function() {
        var fechaSeleccionada = $(this).val();
        cargarHorarios('#eventTime', fechaSeleccionada,null,null);
    });
    
});

document.addEventListener('DOMContentLoaded', function() {
    $('#editEventModal').on('show.bs.modal', function() {
        var fechaSeleccionada = $('#editeventDate').val();
        cargarHorarios('#editeventTime', fechaSeleccionada,$('#ocultoEventDate').val(), $('#ocultoEventTime').val().slice(0, -3));
    });

    $('#editeventDate').on('change', function() {
        var fechaSeleccionada = $(this).val();
        cargarHorarios('#editeventTime', fechaSeleccionada,$('#ocultoEventDate').val(), $('#ocultoEventTime').val().slice(0, -3));
    });
});


// Función para cargar los horarios disponibles
function cargarHorarios(idComboBox, fechaSeleccionada, fechaActual, horarioExtra) {
    console.log(fechaActual)
    console.log(horarioExtra)
    var data = { 
        date: fechaSeleccionada // Agregar la fecha actual a los datos
    };
    if (horarioExtra !== null) {
        data.horarioExtra = horarioExtra;
    }
    if (fechaActual !== null) {
        data.fechaActual = fechaActual;
    }
    
    // Agregar timestamp para evitar caché
    var timestamp = new Date().getTime();
    var url = '../Calendario/obtener_horarios_disponibles.php?timestamp=' + timestamp;

    $.ajax({
        url: url,
        method: 'POST',
        data: data,
        dataType: 'json',
        success: function(response) {
            if (response.horarios && Array.isArray(response.horarios)) {
                var comboBox = $(idComboBox);
                console.log(response.horarios)
                comboBox.empty();
                comboBox.append('<option value="">Seleccionar hora</option>');
                response.horarios.forEach(function(time) {
                    comboBox.append('<option value="' + time + '">' + time + '</option>');
                });
            } else {
                console.error('Error: la respuesta del servidor no contiene horarios válidos');
            }
        },
        error: function(xhr, status, error) {
            console.error('Error al obtener los horarios disponibles');
            console.error(xhr.responseText);
            // Puedes mostrar un mensaje de error al usuario si lo deseas
        }
    });
}
