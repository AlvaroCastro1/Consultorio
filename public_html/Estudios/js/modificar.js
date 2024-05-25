import { idPaciente, idExpediente, obtenerDatosSession } from './obtenerExpediente.js';


// Llama a obtenerDatosSession para asegurarte de que idExpediente se ha inicializado
obtenerDatosSession();

window.modificarEstudio = function(idEstudio, rowIndex) {
    // Obtén la tabla y la fila correspondiente
    var table = document.getElementById('tabla-estudios');
    var row = table.rows[rowIndex];

    // Recupera los valores de las celdas de la fila
    var tipoEstudio = row.cells[0].innerText;
    var nombreEstudio = row.cells[1].innerText;
    var descripcionEstudio = row.cells[2].innerText;
    var fechaEstudio = row.cells[3].innerText;

    // Obtén los elementos del modal por su id
    var idEstudioInput = document.getElementById('idEstudioInputModificar');
    var tipoEstudioInput = document.getElementById('tipoEstudioInputModificar');
    var nombreEstudioInput = document.getElementById('nombreEstudioInputModificar');
    var descripcionEstudioInput = document.getElementById('descripcionEstudioInputModificar');
    var fechaInput = document.getElementById('fechaInputModificar');

    // Coloca los datos de la fila en los campos del modal
    idEstudioInput.value = idEstudio;
    tipoEstudioInput.value = tipoEstudio;
    nombreEstudioInput.value = nombreEstudio;
    descripcionEstudioInput.value = descripcionEstudio;
    fechaInput.value = fechaEstudio;

    // Abre el modal
    $('#modalModificar').modal('show');
};

window.guardarModificacionEstudio = function() {
    // Obtén los elementos del modal por su id
    var idEstudioInput = document.getElementById('idEstudioInputModificar');
    var tipoEstudioInput = document.getElementById('tipoEstudioInputModificar');
    var nombreEstudioInput = document.getElementById('nombreEstudioInputModificar');
    var descripcionEstudioInput = document.getElementById('descripcionEstudioInputModificar');
    var fechaInput = document.getElementById('fechaInputModificar');

    // Comprueba que todos los campos estén llenos
    if (!idEstudioInput || !tipoEstudioInput.value || !nombreEstudioInput.value || !descripcionEstudioInput.value || !fechaInput.value) {
        alert('Por favor, llena todos los campos.');
        return;
    }

    // Recopila los datos del formulario
    var data = {
        idEstudio: idEstudioInput.value,
        tipo: tipoEstudioInput.value,
        nombre: nombreEstudioInput.value,
        descripcion: descripcionEstudioInput.value,
        fecha: fechaInput.value,
        idExpediente: idExpediente // Asegúrate de ajustar esto según sea necesario
    };

    console.log(data);

    // Realiza la solicitud AJAX para guardar los datos en la base de datos
    $.ajax({
        url: 'editarEstudio.php',
        type: 'POST',
        data: data,
        dataType: 'json', // Asegúrate de que la respuesta sea interpretada como JSON
        success: function(response) {
            if (response.message === 'Estudio actualizado exitosamente.') {
                alert('Estudio actualizado exitosamente.');
                location.reload();
            } else {
                console.error('Error al actualizar el estudio:', response.message);
                alert('Ocurrió un error al actualizar el estudio.');
            }
        },
        error: function(xhr, status, error) {
            console.error('Error al actualizar el estudio:', xhr.responseText);
            alert('Ocurrió un error al actualizar el estudio.');
        }
    });
};
