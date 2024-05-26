
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
            console.log(procedimientos);
            procedimientos.forEach(function(procedimiento, index) {
                let row = `<tr id="fila-${procedimiento.idDetalleProcedimiento}">
                                <td>${procedimiento.nombreProceso}</td>
                                <td>${procedimiento.descripcionProcedimiento}</td>
                                <td>${procedimiento.observaciones}</td>
                                <td>${procedimiento.fechaProceso}</td>
                                <td>
                                    <button type="button" class="btn btn-danger me-2" onclick="eliminarProcedimiento(${procedimiento.idDetalleProcedimiento})">Eliminar</button>
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalModificar" onclick="cargarDatosEnModal(${procedimiento.idDetalleProcedimiento})">Modificar</button>
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
                let row = `<tr id="fila-${procedimiento.idDetalleProcedimiento}">
                                <td>${procedimiento.nombreProceso}</td>
                                <td>${procedimiento.descripcionProcedimiento}</td>
                                <td>${procedimiento.observaciones}</td>
                                <td>${procedimiento.fechaProceso}</td>
                                <td>
                                    <button type="button" class="btn btn-danger me-2" onclick="eliminarProcedimiento(${procedimiento.idDetalleProcedimiento})">Eliminar</button>
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalModificar" onclick="cargarDatosEnModal(${procedimiento.idDetalleProcedimiento})">Modificar</button>
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

window.cargarDatosEnModal = function(idDetalleProcedimiento) {
    let row = $(`#fila-${idDetalleProcedimiento}`);

    // Depuración: Imprimir la fila completa
    console.log('Fila seleccionada:', row.html());

    let nombreProceso = row.find("td:eq(0)").text();
    let descripcionProcedimiento = row.find("td:eq(1)").text();
    let observaciones = row.find("td:eq(2)").text();
    let fechaProceso = row.find("td:eq(3)").text();

    // Depuración: Imprimir los valores recuperados
    console.log('Nombre del Proceso:', nombreProceso);
    console.log('Descripción del Procedimiento:', descripcionProcedimiento);
    console.log('Observaciones:', observaciones);
    console.log('Fecha del Proceso:', fechaProceso);

    $('#nombreProcedimientoInputModificar').val(nombreProceso);
    $('#descripcionProcedimientoInputModificar').val(descripcionProcedimiento);
    $('#observacionesProcedimientoInputModificar').val(observaciones);
    $('#fechaProcedimientoInputModificar').val(fechaProceso);
    $('#modalModificar').data('id', idDetalleProcedimiento);
}
