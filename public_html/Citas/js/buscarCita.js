import { idPaciente, idExpediente, obtenerDatosSession } from '../../Estudios/js/obtenerExpediente.js';

/**
 * Función que se ejecuta al realizar una búsqueda de citas por fecha.
 * 
 * Esta función obtiene la fecha introducida en el campo de búsqueda, verifica que no esté vacío,
 * realiza una petición AJAX para buscar citas en el servidor y actualiza la tabla de citas en el DOM con los resultados obtenidos.
 */
window.buscar = function () {
    // Obtiene el elemento de entrada para la fecha de búsqueda
    var fecha = document.getElementById('input-busqueda');
    
    // Verifica si el campo de búsqueda está vacío
    if (fecha.value === '') {
        alert('Por favor, llena el campo de búsqueda.');
        return;
    }

    // Imprime en la consola el ID del paciente y la fecha de búsqueda
    console.log(idPaciente);
    console.log(fecha.value);

    // Realiza una petición AJAX para buscar citas
    $.ajax({
        url: 'buscar_cita.php', // URL del servidor para buscar citas
        type: 'POST', // Tipo de petición HTTP
        data: {
            fecha: fecha.value, // Fecha de búsqueda
            idP: idPaciente // ID del paciente
        },
        success: function(response) {
            // Convierte la respuesta JSON en un objeto JavaScript
            var citas = JSON.parse(response);
            // Obtiene el cuerpo de la tabla de citas en el DOM
            var tbody = document.querySelector('#tabla-Citas tbody');
            // Limpia el contenido actual del cuerpo de la tabla
            tbody.innerHTML = '';

            // Verifica si se encontraron citas
            if (citas.length > 0) {
                let rowIndex = 1;
                // Itera sobre cada cita encontrada
                citas.forEach(function(cita) {
                    // Crea una nueva fila en la tabla para cada cita
                    var row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${cita.idCita}</td>
                        <td>${cita.idPacienteC}</td>
                        <td>${cita.fecha}</td>
                        <td>${cita.hora}</td>
                        <td>${cita.asistencia == 1 ? 'Asistió' : 'No asistió'}</td>
                        <td>
                            <button type="button" class="btn btn-danger me-2" onclick="eliminarCita(${cita.idCita})">Eliminar</button>
                            <button type="button" class="btn btn-primary" onclick="modificarCita(${rowIndex})">Modificar</button>
                        </td>
                    `;
                    rowIndex++;
                    // Agrega la fila al cuerpo de la tabla
                    tbody.appendChild(row);
                });
            } else {
                // Si no se encontraron citas, agrega una fila indicando que no se encontraron resultados
                var row = document.createElement('tr');
                row.innerHTML = `<td colspan="6" class="text-center">No se encontraron citas</td>`;
                tbody.appendChild(row);
            }
        },
        error: function(error) {
            // Muestra una alerta en caso de error en la petición AJAX
            alert('Error al buscar la cita: ' + error);
        }
    });
}
