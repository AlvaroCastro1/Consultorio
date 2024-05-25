
document.addEventListener("DOMContentLoaded", function() {
    // Obtén el idEstudio de la URL
    const urlParams = new URLSearchParams(window.location.search);
    const idEstudio = urlParams.get('idEstudio');

    // Llena la tabla con los elementos correspondientes al idEstudio
    if (idEstudio) {
        $.ajax({
            url: 'obtenerElementos.php',
            type: 'POST',
            data: { idEstudio: idEstudio },
            success: function(response) {
                // Parsea la respuesta JSON
                const elementos = JSON.parse(response);
                
                // Llena la tabla con los elementos
                const tabla = document.getElementById('tabla-ElementosIndividual');
                elementos.forEach(elemento => {
                    const row = tabla.insertRow();
                    row.innerHTML = `
                        <td>${elemento.nombreElemento}</td>
                        <td>${elemento.rango}</td>
                        <td>${elemento.valor}</td>
                        <td>${elemento.interpretacion}</td>
                        <td>
                            <button type="button" class="btn btn-danger me-2" onclick="eliminarElementosIndividual(this)">Eliminar</button>
                            <button type="button" class="btn btn-primary" onclick="modificarElementosIndividual(this)">Modificar</button>
                        </td>
                    `;
                });
            },
            error: function(xhr, status, error) {
                console.error('Error al obtener los elementos:', xhr.responseText);
                alert('Ocurrió un error al obtener los elementos.');
            }
        });
    }
});
