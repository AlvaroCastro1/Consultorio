import { idPaciente, idExpediente, obtenerDatosSession,verificarSesion } from './obtenerExpediente.js';

// Llama a obtenerDatosSession antes de definir las funciones para asegurarte de que las variables estén inicializadas
obtenerDatosSession();

window.cargarEstudios = function() {
    if (!verificarSesion(idExpediente)) return;

    
    // Obtener la tabla
    const tabla = document.getElementById("tabla-estudios");
    $("#tabla-estudios tbody").empty();

    // ID del expediente
    const idE = idExpediente; // Aquí debes poner el idExpediente deseado

    // Petición AJAX para obtener los datos de la base de datos
    const xhr = new XMLHttpRequest();
    xhr.open("GET", `obtener_estudios.php?idExpediente=${idE}`, true);
    xhr.onload = function() {
        if (xhr.status === 200) {
            const estudios = JSON.parse(xhr.responseText);

            // Verificar si no hay estudios
            if (estudios.length === 0) {
                const row = tabla.insertRow();
                row.innerHTML = `
                    <td colspan="11">No se encontraron resultados</td>
                `;
            } else {
                let rowIndex = 1; // Comienza en 1 para omitir la fila de encabezado
                estudios.forEach((estudio, index) => {
                    const row = tabla.insertRow();
                    row.innerHTML = `
                        <td>${estudio.tipoEstudio}</td>
                        <td>${estudio.nombreEstudio}</td>
                        <td>${estudio.descripcionEstudio}</td>
                        <td>${estudio.fechaEstudio}</td>
                        <td>
                            <button type="button" class="btn btn-primary" onclick="verElementos(${estudio.idEstudio})">Ver Elementos</button>
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger me-2" onclick="eliminarEstudio(${estudio.idEstudio}, ${estudio.idDetalleEstudio}, ${rowIndex})">Eliminar</button>
                            <button type="button" class="btn btn-primary" onclick="modificarEstudio(${estudio.idEstudio},${rowIndex})">Modificar</button>
                        </td>
                    `;
                    rowIndex++;
                });
            }
        }
    };
    xhr.send();
};

window.buscar = function() {
    if (!verificarSesion(idExpediente)) return;

    const inputBusqueda = document.getElementById("input-busqueda").value;
    const tabla = document.getElementById("tabla-estudios");
    const idE = idExpediente; // ID del expediente deseado

    const xhr = new XMLHttpRequest();
    xhr.open("GET", `buscar_estudios.php?idExpediente=${idE}&busqueda=${inputBusqueda}`, true);
    xhr.onload = function() {
        if (xhr.status === 200) {
            // Limpiar la tabla antes de mostrar los resultados
            while (tabla.rows.length > 1) {
                tabla.deleteRow(1);
            }

            const estudios = JSON.parse(xhr.responseText);

            // Verificar si no hay estudios
            if (estudios.length === 0) {
                const row = tabla.insertRow();
                row.innerHTML = `
                    <td colspan="11">No se encontraron resultados</td>
                `;
            } else {
                let rowIndex = 1; // Comienza en 1 para omitir la fila de encabezado
                estudios.forEach(estudio => {
                    const row = tabla.insertRow();
                    row.innerHTML = `
                        <td>${estudio.tipoEstudio}</td>
                        <td>${estudio.nombreEstudio}</td>
                        <td>${estudio.descripcionEstudio}</td>
                        <td>${estudio.fechaEstudio}</td>
                        <td>
                            <button type="button" class="btn btn-primary" onclick="verElementos(${estudio.idEstudio})">Ver Elementos</button>
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger me-2" onclick="eliminarEstudio(${estudio.idEstudio}, ${estudio.idDetalleEstudio}, ${rowIndex})">Eliminar</button>
                            <button type="button" class="btn btn-primary" onclick="modificarEstudio(${estudio.idEstudio},${rowIndex})">Modificar</button>
                        </td>
                    `;
                    rowIndex++;
                });
            }
        }
    };
    xhr.send();
};


window.limpiar = function() {
    document.getElementById('input-busqueda').value = '';
    location.reload();
};
