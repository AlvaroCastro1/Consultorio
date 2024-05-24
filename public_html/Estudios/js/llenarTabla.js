document.addEventListener("DOMContentLoaded", function() {
    // Obtener la tabla
    const tabla = document.getElementById("tabla-estudios");

    // ID del expediente
    const idExpediente = 1; // Aquí debes poner el idExpediente deseado

    // Petición AJAX para obtener los datos de la base de datos
    const xhr = new XMLHttpRequest();
    xhr.open("GET", `obtener_estudios.php?idExpediente=${idExpediente}`, true);
    xhr.onload = function() {
        if (xhr.status === 200) {
            const estudios = JSON.parse(xhr.responseText);
            estudios.forEach(estudio => {
                const row = tabla.insertRow();
                row.innerHTML = `
                    <td>${estudio.tipoEstudio}</td>
                    <td>${estudio.nombreEstudio}</td>
                    <td>${estudio.descripcionEstudio}</td>
                    <td>${estudio.fechaEstudio}</td>
                    <td>
                        <button type="button" class="btn btn-primary" onclick="verElementos(this)">Ver Elementos</button>
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger me-2" onclick="eliminarEstudio(this)">Eliminar</button>
                        <button type="button" class="btn btn-primary" onclick="modificarEstudio(this)">Modificar</button>
                    </td>
                `;
            });
        }
    };
    xhr.send();
});

function buscar() {
    const inputBusqueda = document.getElementById("input-busqueda").value;
    const tabla = document.getElementById("tabla-estudios");
    const idExpediente = 1; // ID del expediente deseado

    const xhr = new XMLHttpRequest();
    xhr.open("GET", `buscar_estudios.php?idExpediente=${idExpediente}&busqueda=${inputBusqueda}`, true);
    xhr.onload = function() {
        if (xhr.status === 200) {
            // Limpiar la tabla antes de mostrar los resultados
            while (tabla.rows.length > 1) {
                tabla.deleteRow(1);
            }

            const estudios = JSON.parse(xhr.responseText);
            estudios.forEach(estudio => {
                const row = tabla.insertRow();
                row.innerHTML = `
                    <td>${estudio.tipoEstudio}</td>
                    <td>${estudio.nombreEstudio}</td>
                    <td>${estudio.descripcionEstudio}</td>
                    <td>${estudio.fechaEstudio}</td>
                    <td>
                        <button type="button" class="btn btn-primary" onclick="verElementos(this)">Ver Elementos</button>
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger me-2" onclick="eliminarEstudio(this)">Eliminar</button>
                        <button type="button" class="btn btn-primary" onclick="modificarEstudio(this)">Modificar</button>
                    </td>
                `;
            });
        }
    };
    xhr.send();
}
