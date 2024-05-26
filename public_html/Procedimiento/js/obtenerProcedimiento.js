
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

window.modalReset = function() {
    // Limpiar los valores de los campos de entrada del modal
    $('#nombreProcedimientoInput').val('');
    $('#descripcionProcedimientoInput').val('');
    $('#observacionesProcedimientoInput').val('');
    $('#fechaProcedimientoInput').val('');
    
    // Opcionalmente, puedes restablecer cualquier otro estado adicional del modal aquí
    // Por ejemplo, remover clases de validación, mensajes de error, etc.

    // Si el modal está actualmente abierto, puedes cerrarlo
    $('#modalAgregar').modal('hide');
}

window.buscar = function() {
    // Obtener el valor de la fecha de búsqueda
    var fechaBusqueda = $('#input-busqueda').val();

    // Validar que la fecha de búsqueda no esté vacía
    if (!fechaBusqueda) {
        alert('Por favor ingrese una fecha para buscar.');
        return;
    }

    $.ajax({
        type: 'POST',
        url: 'buscar_procedimientos.php',
        data: { fechaBusqueda: fechaBusqueda },
        success: function(response) {
            // Convertir la respuesta JSON en un array de objetos
            let procedimientos = JSON.parse(response);

            // Limpiar la tabla antes de agregar nuevas filas
            $('#tabla-procedimientos tbody').empty();

            // Iterar sobre los procedimientos y agregarlos a la tabla
            procedimientos.forEach(function(procedimiento) {
                let row = `<tr>
                                <td>${procedimiento.nombreProceso}</td>
                                <td>${procedimiento.descripcionProcedimiento}</td>
                                <td>${procedimiento.observaciones}</td>
                                <td>${procedimiento.fechaProceso}</td>
                                <td>
                                    <button type="button" class="btn btn-danger me-2" onclick="eliminarProcedimiento()">Eliminar</button>
                                    <button type="button" class="btn btn-primary" onclick="modificarProcedimiento(this)">Modificar</button>
                                </td>
                            </tr>`;
                $('#tabla-procedimientos tbody').append(row);
            });
        },
        error: function(xhr, status, error) {
            console.error('Error en la solicitud AJAX:', error);
        }
    });
}

window.limpiar = function() {
    // Limpiar el valor del campo de búsqueda
    $('#input-busqueda').val('');

    cargarProcedimientos();
    $('#tabla-procedimientos tbody').empty(); // Si deseas dejar la tabla vacía
}
