function cargarElementos() {
    // Obtén el idEstudio de la URL
    const urlParams = new URLSearchParams(window.location.search);
    const idEstudio = urlParams.get('idEstudio');
    $("#tabla-ElementosIndividual tbody").empty();
    // Llena la tabla con los elementos correspondientes al idEstudio
    if (idEstudio) {
        $.ajax({
            url: 'obtenerElementos.php',
            type: 'POST',
            data: { idEstudio: idEstudio },
            success: function(response) {
                // Parsea la respuesta JSON
                const elementos = JSON.parse(response);
                let rowIndex = 1;
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
                            <button type="button" class="btn btn-danger me-2" onclick="eliminarElementosIndividual(${elemento.idElementos}, ${rowIndex})">Eliminar</button>
                            <button type="button" class="btn btn-primary" onclick="modificarElementosIndividual(${elemento.idElementos}, ${rowIndex})">Modificar</button>
                        </td>
                    `;
                    rowIndex++;
                });
            },
            error: function(xhr, status, error) {
                console.error('Error al obtener los elementos:', xhr.responseText);
                alert('Ocurrió un error al obtener los elementos.');
            }
        });
    }
}


function limpiar() {
    document.getElementById('input-busqueda').value = '';
    location.reload();

}


function buscar() {
    const urlParams = new URLSearchParams(window.location.search);
    const idEstudio = urlParams.get('idEstudio');
    const nombre = document.getElementById('input-busqueda').value.trim();

    // Si el campo nombre está vacío, no realizar la búsqueda
    if (nombre === '') {
        alert('El campo nombre está vacío.');
        return;
    }

    if (!idEstudio) {
        alert('No se ha proporcionado un ID de estudio.');
        return;
    }

    $.ajax({
        url: 'buscarElemento.php',
        type: 'GET',
        data: { idEstudio: idEstudio, nombre: nombre },
        success: function(response) {
            var elementos = JSON.parse(response);
            var tbody = document.getElementById('tabla-ElementosIndividual').getElementsByTagName('tbody')[0];
            tbody.innerHTML = ''; // Limpiar la tabla antes de agregar nuevos datos
            let rowIndex = 1;
            elementos.forEach(elemento => {
                var row = tbody.insertRow();
                row.innerHTML = `
                    <td>${elemento.nombreElemento}</td>
                    <td>${elemento.rango}</td>
                    <td>${elemento.valor}</td>
                    <td>${elemento.interpretacion}</td>
                    <td>
                        <button type="button" class="btn btn-danger me-2" onclick="eliminarElementosIndividual(${elemento.idElementos}, ${rowIndex})">Eliminar</button>
                        <button type="button" class="btn btn-primary" onclick="modificarElementosIndividual(${elemento.idElementos}, ${rowIndex})">Modificar</button>
                    </td>
                `;
                rowIndex++;
            });
        },
        error: function(xhr, status, error) {
            console.error('Error al buscar el elemento:', xhr.responseText);
            alert('Ocurrió un error al buscar el elemento.');
        }
    });
}


function reiniciarModal() {
    // Obtén los elementos del modal por su id
    var nombreElemento = document.getElementById('nombreElementoinput');
    var rango = document.getElementById('rangoInput');
    var valor = document.getElementById('valorInput');
    var interpretacion = document.getElementById('interpretacionInput');

    // Reinicia los valores de los elementos
    nombreElemento.value = '';
    rango.value = '';
    valor.value = '';
    interpretacion.value = '';

    // Cierra el modal
    var modalAgregar = new bootstrap.Modal(document.getElementById('modalAgregar'));
    modalAgregar.hide();
}
