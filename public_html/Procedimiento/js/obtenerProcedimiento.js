
import { idPaciente, idExpediente, obtenerDatosSession } from '../../Estudios/js/obtenerExpediente.js';


window.cargarProcedimientos = function () {
    obtenerDatosSession();
    var idE = idExpediente; // Asumiendo que obtienes el ID del expediente de la sesión
    console.log(idE);

    $.ajax({
        type: 'POST',
        url: 'obtener_procedimientos.php',
        data: { idExpediente: idE },
        success: function(response) {
            // Convertir la respuesta JSON en un array de objetos
            let procedimientos = JSON.parse(response);

            // Limpiar la tabla antes de agregar nuevas filas
            $('#tabla-procedimientos tbody').empty();

            // Iterar sobre los procedimientos y agregarlos a la tabla
            procedimientos.forEach(function(procedimiento, index) {
                let row = `<tr>
                                <td>${procedimiento.nombreProceso}</td>
                                <td>${procedimiento.descripcionProcedimiento}</td>
                                <td>${procedimiento.observaciones}</td>
                                <td>${procedimiento.fechaProceso}</td>
                                <td>
                                    <button type="button" class="btn btn-danger me-2" onclick="eliminarProcedimiento(${index})">Eliminar</button>
                                    <button type="button" class="btn btn-primary" onclick="modificarProcedimiento(${index})">Modificar</button>
                                </td>
                            </tr>`;
                $('#tabla-procedimientos tbody').append(row);
            });
        },
        error: function(xhr, status, error) {
            console.error('Error al obtener procedimientos:', error);
        }
    });
}
