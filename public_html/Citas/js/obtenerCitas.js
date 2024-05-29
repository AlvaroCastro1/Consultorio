import { idPaciente, idExpediente, obtenerDatosSession } from '../../Estudios/js/obtenerExpediente.js';

/**
 * Función para cargar citas desde el servidor y mostrarlas en una tabla.
 * 
 * Esta función utiliza una solicitud AJAX para obtener las citas de un paciente desde el servidor
 * y las muestra en una tabla HTML. Los datos del paciente se obtienen de la sesión.
 */
window.cargarCitas = function() {
    // Obtener datos de la sesión
    obtenerDatosSession();
    var idP = idPaciente;
    console.log(idP);

    // Realizar una solicitud AJAX para obtener las citas del paciente
    $.ajax({
        type: 'POST', // Tipo de solicitud HTTP
        url: 'obtener_citas.php', // URL del servidor para obtener citas
        data: { idPaciente: idPaciente }, // Datos enviados en la solicitud
        success: function(response) {
            // Convertir la respuesta JSON en un array de objetos
            let citas = JSON.parse(response);

            // Limpiar la tabla antes de agregar nuevas filas
            $('#tabla-Citas tbody').empty();
            let rowIndex = 1;
            // Iterar sobre las citas y agregarlas a la tabla
            citas.forEach(function(cita) {
                let row = `<tr>
                                <td>${cita.idCita}</td>
                                <td>${cita.idPacienteC}</td>
                                <td>${cita.fecha}</td>
                                <td>${cita.hora}</td>
                                <td>${cita.asistencia == 1 ? 'Asistió' : 'No asistió'}</td>
                                <td>
                                    <button type="button" class="btn btn-danger me-2" onclick="eliminarCita(${cita.idCita})">Eliminar</button>
                                    <button type="button" class="btn btn-primary" onclick="modificarCita(${rowIndex})">Modificar</button>
                                </td>
                            </tr>`;
                rowIndex++;
                $('#tabla-Citas tbody').append(row);
            });
        },
        error: function(xhr, status, error) {
            console.error('Error al obtener citas:', error);
        }
    });
}


window.resetModal = function() {
    var modalAgregar = new bootstrap.Modal(document.getElementById('modalAgregar'));
    
    // Restablecer el formulario
    document.getElementById('addEventForm').reset();
    
    // Mostrar el modal
    modalAgregar.show();
    
    
    // Asignar el valor de idPaciente al campo de entrada y verificar si es null
    var inputIDpaciente = document.getElementById('input-IDpaciente');
    if (idPaciente === null) {
        inputIDpaciente.removeAttribute('disabled');
    } else {
        inputIDpaciente.setAttribute('disabled', 'disabled');
        inputIDpaciente.value = idPaciente;
    }
};

/**
 * Función para limpiar el campo de búsqueda y recargar las citas.
 * 
 * Esta función restablece el valor del campo de búsqueda a una cadena vacía, limpia el contenido del cuerpo de 
 * la tabla de citas y vuelve a cargar las citas.
 */

window.limpiar=function () {
    document.getElementById('input-busqueda').value = '';
    document.querySelector('#tabla-Citas tbody').innerHTML = '';
    cargarCitas();
}
