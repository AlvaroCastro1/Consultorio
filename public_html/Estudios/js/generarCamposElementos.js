
function generarCamposElementos() {
    const cantidad = document.getElementById('cantidadElementosInput').value;
    const container = document.getElementById('elementosContainer');
    container.innerHTML = '';

    for (let i = 0; i < cantidad; i++) {
        const elementDiv = document.createElement('div');
        elementDiv.className = 'elemento-item mb-3';
        elementDiv.innerHTML = `
            <label>Número de Elemento: ${i+1}</label>
            <input type="text" class="form-control mb-1" placeholder="Nombre del Elemento" id="nombreElemento${i}">
            <input type="text" class="form-control mb-1" placeholder="Rango" id="rangoElemento${i}">
            <input type="number" class="form-control mb-1" placeholder="Valor" id="valorElemento${i}">
            <input type="text" class="form-control mb-1" placeholder="Interpretación" id="interpretacionElemento${i}">
        `;
        container.appendChild(elementDiv);
    }
}

function agregarEstudio() {
    const tipoEstudio = document.getElementById('tipoEstudioInput').value;
    const nombreEstudio = document.getElementById('nombreEstudioInput').value;
    const descripcionEstudio = document.getElementById('descripcionEstudioInput').value;
    const fecha = document.getElementById('fechaInput').value;
    const cantidadElementos = document.getElementById('cantidadElementosInput').value;

    let elementos = [];
    for (let i = 0; i < cantidadElementos; i++) {
        let elemento = {
            nombre: document.getElementById(`nombreElemento${i}`).value,
            rango: document.getElementById(`rangoElemento${i}`).value,
            valor: document.getElementById(`valorElemento${i}`).value,
            interpretacion: document.getElementById(`interpretacionElemento${i}`).value
        };
        elementos.push(elemento);
    }

    const data = {
        tipoEstudio: tipoEstudio,
        nombreEstudio: nombreEstudio,
        descripcionEstudio: descripcionEstudio,
        fecha: fecha,
        elementos: elementos
    };

    fetch('ruta/a/tu/script.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Estudio agregado con éxito');
            location.reload(); // Recargar la página para reflejar los cambios
        } else {
            alert('Error al agregar estudio');
        }
    })
    .catch(error => console.error('Error:', error));
}