let contadorElementos = 0;

function generarCamposElementos() {
    let div = document.createElement('div');
    div.id = 'Elemento' + (contadorElementos + 1);
    div.innerHTML = `
        <label>Número de Elemento: ${contadorElementos + 1}</label>
        <input type="text" class="form-control mb-1" placeholder="Nombre del Elemento" id="nombreElemento${contadorElementos+1}">
        <input type="text" class="form-control mb-1" placeholder="Rango" id="rangoElemento${contadorElementos+1}">
        <input type="number" class="form-control mb-1" placeholder="Valor" id="valorElemento${contadorElementos+1}">
        <input type="text" class="form-control mb-1" placeholder="Interpretación" id="interpretacionElemento${contadorElementos+1}">
    `;
    if (contadorElementos > 0) {
        div.innerHTML += `<button type="button" class="btn btn-secondary mb-3" id="EliminarElemento${contadorElementos+1}" onclick="eliminarElemento(${contadorElementos+1})">Eliminar Elemento</button>`;
    }
    document.querySelector('.modal-body').appendChild(div);
    contadorElementos++;
     // Mover el botón "Agregar Datos" al final del cuerpo del modal
    let agregarDatosBtn = document.getElementById("AgregarElemento0");
    document.querySelector('.modal-body').appendChild(agregarDatosBtn);
}


function reiniciarModal() {
    // Obtén los elementos del modal por su id
    var tipoEstudioInput = document.getElementById('tipoEstudioInput');
    var nombreEstudioInput = document.getElementById('nombreEstudioInput');
    var descripcionEstudioInput = document.getElementById('descripcionEstudioInput');
    var fechaInput = document.getElementById('fechaInput');

    // Reinicia los valores de los elementos
    tipoEstudioInput.value = '';
    nombreEstudioInput.value = '';
    descripcionEstudioInput.value = '';
    fechaInput.value = '';

    // Elimina los campos inyectados
    var modalBody = document.querySelector('.modal-body');
    while (modalBody.firstChild) {
        modalBody.removeChild(modalBody.firstChild);
    }

    // Agrega los campos originales al cuerpo del modal
    modalBody.innerHTML = `
        <input type="text" class="form-control mb-3" id="tipoEstudioInput" placeholder="Tipo">
        <input type="text" class="form-control mb-3" id="nombreEstudioInput" placeholder="Nombre">
        <input type="text" class="form-control mb-3" id="descripcionEstudioInput" placeholder="Descripción">
        <input type="date" class="form-control mb-3" id="fechaInput">
        <button type="button" class="btn btn-secondary mb-3" id="AgregarElemento0" onclick="generarCamposElementos()">Agregar Elemento</button>
    `;

    // Reinicia el contador de elementos
    contadorElementos = 0;

    // Cierra el modal
    var modalAgregar = new bootstrap.Modal(document.getElementById('modalAgregar'));
    modalAgregar.hide();
    generarCamposElementos()
}

function eliminarElemento(indice) {
    // Elimina el elemento
    var elemento = document.getElementById('Elemento' + indice);
    elemento.parentNode.removeChild(elemento);

    // Actualiza los índices de los demás elementos
    for (var i = indice + 1; i <= contadorElementos; i++) {
        var elementoActual = document.getElementById('Elemento' + i);
        elementoActual.id = 'Elemento' + (i - 1);
        elementoActual.querySelector('label').textContent = 'Número de Elemento: ' + (i-1);
        elementoActual.querySelector('#nombreElemento' + i).id = 'nombreElemento' + (i - 1);
        elementoActual.querySelector('#rangoElemento' + i).id = 'rangoElemento' + (i - 1);
        elementoActual.querySelector('#valorElemento' + i).id = 'valorElemento' + (i - 1);
        elementoActual.querySelector('#interpretacionElemento' + i).id = 'interpretacionElemento' + (i - 1);
        elementoActual.querySelector('#EliminarElemento' + i).id = 'EliminarElemento' + (i - 1);
        elementoActual.querySelector('#EliminarElemento' + (i - 1)).setAttribute('onclick', 'eliminarElemento(' + (i - 1) + ')');
    }

    // Decrementa el contador de elementos
    contadorElementos--;
}

function agregarEstudio() {
    // Obtén los elementos del modal por su id
    var tipoEstudioInput = document.getElementById('tipoEstudioInput');
    var nombreEstudioInput = document.getElementById('nombreEstudioInput');
    var descripcionEstudioInput = document.getElementById('descripcionEstudioInput');
    var fechaInput = document.getElementById('fechaInput');

    // Comprueba que todos los campos estén llenos
    if (!tipoEstudioInput.value || !nombreEstudioInput.value || !descripcionEstudioInput.value || !fechaInput.value) {
        alert('Por favor, llena todos los campos.');
        return;
    }

    // Recopila los datos del formulario
    var data = {
        tipo: tipoEstudioInput.value,
        nombre: nombreEstudioInput.value,
        descripcion: descripcionEstudioInput.value,
        fecha: fechaInput.value,
        elementos: []
    };

    // Recopila los datos de los elementos
    for (var i = 1; i <= contadorElementos; i++) {
        var nombreElemento = document.getElementById('nombreElemento' + i);
        var rangoElemento = document.getElementById('rangoElemento' + i);
        var valorElemento = document.getElementById('valorElemento' + i);
        var interpretacionElemento = document.getElementById('interpretacionElemento' + i);

        // Comprueba que todos los campos del elemento estén llenos
        if (!nombreElemento.value || !rangoElemento.value || !valorElemento.value || !interpretacionElemento.value) {
            alert('Por favor, llena todos los campos del elemento ' + i + '.');
            return;
        }

        var elemento = {
            nombre: nombreElemento.value,
            rango: rangoElemento.value,
            valor: valorElemento.value,
            interpretacion: interpretacionElemento.value
        };
        data.elementos.push(elemento);
    }

    // Realiza la solicitud AJAX para guardar los datos en la base de datos
    $.ajax({
        url: 'AgregarEstudio.php',
        type: 'POST',
        data: data,
        success: function(response) {
            if(response.message === 'Estudio guardado exitosamente.') {
                alert('Estudio guardado exitosamente.');
                reiniciarModal();
                location.reload();
            } else {
                console.error('Error al guardar el estudio:', response.message);
                alert('Ocurrió un error al guardar el estudio.');
            }
        },
        error: function(xhr, status, error) {
            console.error('Error al guardar el estudio:', xhr.responseText);
            alert('Ocurrió un error al guardar el estudio.');
        }
    });
    
}

