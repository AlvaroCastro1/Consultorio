function modificarElementosIndividual(idElemento, rowIndex) {
    // Obtén la tabla y la fila correspondiente
    var table = document.getElementById('tabla-ElementosIndividual');
    var row = table.rows[rowIndex+1];

    // Verifica si la fila existe y tiene al menos 4 celdas
    if (row && row.cells.length >= 4) {
        // Recupera los valores de las celdas de la fila
        var nombreElemento = row.cells[0].innerText;
        var rango = row.cells[1].innerText;
        var valor = row.cells[2].innerText;
        var interpretacion = row.cells[3].innerText;

        // Obtén los elementos del modal por su id
        var idElementoInput = document.getElementById('idElementoInputModificar');
        var nombreElementoInput = document.getElementById('nombreElementoinputModificar');
        var valorInput = document.getElementById('valorInputModificar');
        var rangoInput = document.getElementById('rangoInputModificar');
        var interpretacionInput = document.getElementById('interpretacionInputModificar');

        // Verifica si los elementos existen antes de intentar establecer su valor
        if (nombreElementoInput && rangoInput && valorInput && interpretacionInput) {
            // Coloca los datos de la fila en los campos del modal
            idElementoInput.value = idElemento;
            nombreElementoInput.value = nombreElemento;
            rangoInput.value = rango;
            valorInput.value = valor;
            interpretacionInput.value = interpretacion;

            // Abre el modal
            $('#modalModificar').modal('show');
        } else {
            console.error('Alguno de los elementos input no se encontró.');
        }
    } else {
        console.error('La fila o las celdas no están definidas correctamente.');
    }
}




function guardarModificacionEstudio() {
    // Obtén los elementos del modal por su id
    var idElementoInput = document.getElementById('idElementoInputModificar');
    var nombreElementoInput = document.getElementById('nombreElementoinputModificar');
    
    var valorInput = document.getElementById('valorInputModificar');
    var rangoInput = document.getElementById('rangoInputModificar');
    var interpretacionInput = document.getElementById('interpretacionInputModificar');
    const urlParams = new URLSearchParams(window.location.search);
    const idE = urlParams.get('idEstudio');

    // Comprueba que todos los campos estén llenos
    if (!nombreElementoInput.value || !valorInput.value || !rangoInput.value || !interpretacionInput.value) {
        alert('Por favor, llena todos los campos.');
        return;
    }

    // Recopila los datos del formulario
    var data = {
        idElemento: idElementoInput.value,
        nombreElemento: nombreElementoInput.value,
        valor: valorInput.value,
        rango: rangoInput.value,
        interpretacion: interpretacionInput.value,
        idEstudio: idE // Ajusta esto según sea necesario
    };

    console.log(data);

    // Realiza la solicitud AJAX para guardar los datos en la base de datos
    $.ajax({
        url: 'editarElemento.php',
        type: 'POST',
        data: data,
        dataType: 'json', // Asegúrate de que la respuesta sea interpretada como JSON
        success: function(response) {
            if (response.message === 'Elemento actualizado exitosamente.') {
                alert('Elemento actualizado exitosamente.');
                location.reload();
            } else {
                console.error('Error al actualizar el elemento:', response.message);
                alert('Ocurrió un error al actualizar el elemento.');
            }
        },
        error: function(xhr, status, error) {
            console.error('Error al actualizar el elemento:', xhr.responseText);
            alert('Ocurrió un error al actualizar el elemento.');
        }
    });
}
