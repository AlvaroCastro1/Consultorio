function agregarElementosIndividual() {
    // Obtén los valores de los campos del modal
    var nombreElemento = document.getElementById('nombreElementoinput').value;
    var rango = document.getElementById('rangoInput').value;
    var valor = document.getElementById('valorInput').value;
    var interpretacion = document.getElementById('interpretacionInput').value;

    const urlParams = new URLSearchParams(window.location.search);
    const idEstudio = urlParams.get('idEstudio');

    // Comprueba que todos los campos estén llenos
    if (!nombreElemento || !rango || !valor || !interpretacion) {
        alert('Por favor, llena todos los campos.');
        return;
    }

    // Recopila los datos del formulario
    var data = {
        nombreElemento: nombreElemento,
        rango: rango,
        valor: valor,
        interpretacion: interpretacion,
        idEstudio: idEstudio
    };

    // Realiza la solicitud AJAX para guardar los datos en la base de datos
    $.ajax({
        url: 'agregarElemento.php',
        type: 'POST',
        data: data,
        success: function(response) {
            // Asegúrate de que la respuesta esté en formato JSON
            try {
                var jsonResponse = JSON.parse(response);
                if (jsonResponse.message === 'Elemento guardado exitosamente.') {
                    alert('Elemento guardado exitosamente.');
                    $('#modalAgregar').modal('hide');
                    location.reload();
                } else {
                    console.error('Error al guardar el elemento:', jsonResponse.message);
                    alert('Ocurrió un error al guardar el elemento.');
                }
            } catch (e) {
                console.error('Respuesta inválida del servidor:', response);
                alert('Ocurrió un error inesperado al guardar el elemento.');
            }
        },
        error: function(xhr, status, error) {
            console.error('Error al guardar el elemento:', xhr.responseText);
            alert('Ocurrió un error al guardar el elemento.');
        }
    });
}
