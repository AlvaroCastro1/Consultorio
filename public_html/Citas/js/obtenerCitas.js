
import { idPaciente, idExpediente, obtenerDatosSession } from '../../Estudios/js/obtenerExpediente.js';

window.cargarCitas=function () {
    obtenerDatosSession();
    var idP = idPaciente;
    console.log(idP);

    $.ajax({
        type: 'POST',
        url: 'obtener_citas.php',
        data: { idPaciente: idPaciente },
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


window.limpiar=function () {
    document.getElementById('input-busqueda').value = '';
    document.querySelector('#tabla-Citas tbody').innerHTML = '';
    cargarCitas();
}