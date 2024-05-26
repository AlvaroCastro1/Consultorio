import { idPaciente, idExpediente, obtenerDatosSession } from '../../Estudios/js/obtenerExpediente.js';


window.buscar=function () {
    var fecha = document.getElementById('input-busqueda');
    
    // Verificar si el input está vacío
    if (fecha.value === '') {
        alert('Por favor, llena el campo de búsqueda.');
        return;
    }

    console.log(idPaciente);
    console.log(fecha.value);

    $.ajax({
        url: 'buscar_cita.php',
        type: 'POST',
        data: {
            fecha: fecha.value,
            idP: idPaciente
        },
        success: function(response) {
            var citas = JSON.parse(response);
            var tbody = document.querySelector('#tabla-Citas tbody');
            tbody.innerHTML = '';

            if (citas.length > 0) {
                citas.forEach(function(cita) {
                    var row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${cita.idCita}</td>
                        <td>${cita.idPacienteC}</td>
                        <td>${cita.fecha}</td>
                        <td>${cita.hora}</td>
                        <td>${cita.asistencia == 1 ? 'Asistió' : 'No asistió'}</td>
                        <td>
                            <button type="button" class="btn btn-danger me-2" onclick="eliminarCita(${cita.idCita})">Eliminar</button>
                            <button type="button" class="btn btn-primary" onclick="modificarCita(${cita.idCita})">Modificar</button>
                        </td>
                    `;
                    tbody.appendChild(row);
                });
            } else {
                var row = document.createElement('tr');
                row.innerHTML = `<td colspan="6" class="text-center">No se encontraron citas</td>`;
                tbody.appendChild(row);
            }
        },
        error: function(error) {
            alert('Error al buscar la cita: ' + error);
        }
    });
}