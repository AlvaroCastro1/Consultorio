document.addEventListener("DOMContentLoaded", function() {
    // Obtener la tabla
    const tabla = document.getElementById("tabla-estudios");

    // ID del expediente
    const idExpediente = 2; // Aquí debes poner el idExpediente deseado

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
