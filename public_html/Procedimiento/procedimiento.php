<?php
session_start();
include("../includes/conexion.php");
$querybuscar = mysqli_query($conn, "SELECT * FROM procedimiento");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Procedimientos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../CSS/ProcedimientosStyles.css">
    <link rel="stylesheet" href="../CSS/barraNav.css">
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-primary-custom">
        <div class="container">
        </div>
    </nav>

    <div class="container2 mt-5">
        <h1 class="titulo-Procedimientos mb-4">Procedimientos</h1>
        
        <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Buscar por Nombre del Procedimiento" id="input-busqueda">
            <button class="btn btn-outline-secondary" type="button" onclick="buscarProcedimientos()">Buscar</button>
        </div>

        <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalAgregar">Agregar</button>
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="tabla-procedimientos">
                <thead>
                    <tr>
                        <th>Nombre del Procedimiento</th>
                        <th>Descripción del Procedimiento</th>
                        <th>Observaciones del Procedimiento</th>
                        <th>Fecha del Procedimiento</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                     <?php
                    while($mostrar = mysqli_fetch_array($querybuscar))
                    {   
                        $proid = $mostrar['idProcedimiento'];
                        $pronom = $mostrar['nombreProceso'];
                        $prodes = $mostrar['descripcionProcedimiento'];
                       # $profecha = $mostrar['fechaProcedimiento'];
                    ?>
                    <tr id="procedimiento_<?php echo $proid;?>">
                        <td><?php echo $pronom;?></td>
                        <td><?php echo $prodes;?></td>
                        <td>...</td>
                        <td>...</td>
                        <td>
                            <button type="button" class="btn btn-danger me-2" onclick="eliminarProcedimiento(<?php echo $proid; ?>)">Eliminar</button>
                            <button type="button" class="btn btn-primary" onclick="modificarProcedimiento(<?php echo $proid; ?>)">Modificar</button>
                        </td>
                    </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <div class="espacio-final"></div>
    </div>

    <div class="modal fade" id="modalAgregar" tabindex="-1" aria-labelledby="modalAgregarLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAgregarLabel">Registro de Procedimientos</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="text" class="form-control mb-3" id="nombreProcedimientoInput" placeholder="Nombre del Procedimientod">
                    <input type="text" class="form-control mb-3" id="descripcionProcedimientoInput" placeholder="Descripción del Procedimiento">
                    <input type="text" class="form-control mb-3" id="observacionesProcedimientoInput" placeholder="Observaciones del Procedimiento">
                    <input type="date" class="form-control mb-3" id="fechaProcedimientoInput" placeholder="Fecha del Procedimiento">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger me-2" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" onclick="agregarProcedimientoDesdeModal()">Aceptar</button>
                </div>
            </div>
        </div>
    </div>
    <footer>
        <div class="container3">
            <p>Pie de página</p>
        </div>
    </footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
function agregarProcedimientoDesdeModal() {

    // Obtener los valores de los campos del formulario
    const nombreProcedimiento = document.getElementById('nombreProcedimientoInput').value;
    const descripcionProcedimiento = document.getElementById('descripcionProcedimientoInput').value;
    const observacionesProcedimiento = document.getElementById('observacionesProcedimientoInput').value;
    const fechaProcedimiento = document.getElementById('fechaProcedimientoInput').value;
    if (nombreProcedimiento === '' || descripcionProcedimiento === '' || observacionesProcedimiento === '' || fechaProcedimiento === '') {
        alert("Por favor, complete todos los campos.");
        return;
    }
    const form = document.createElement('form');
    form.method = 'post';
    form.action = 'Guardar_procedimiento.php';

    const nombreInput = document.createElement('input');
    nombreInput.type = 'hidden'; // Ocultar este campo del usuario
    nombreInput.name = 'nombreProcedimientoInput';
    nombreInput.value = nombreProcedimiento;
    form.appendChild(nombreInput);

    const descripcionInput = document.createElement('input');
    descripcionInput.type = 'hidden';
    descripcionInput.name = 'descripcionProcedimientoInput';
    descripcionInput.value = descripcionProcedimiento;
    form.appendChild(descripcionInput);

    const observacionesInput = document.createElement('input');
    observacionesInput.type = 'hidden';
    observacionesInput.name = 'observacionesProcedimientoInput';
    observacionesInput.value = observacionesProcedimiento;
    form.appendChild(observacionesInput);

    const fechaInput = document.createElement('input');
    fechaInput.type = 'hidden';
    fechaInput.name = 'fechaProcedimientoInput';
    fechaInput.value = fechaProcedimiento;
    form.appendChild(fechaInput);
    document.body.appendChild(form);
    form.submit();
    document.getElementById('nombreProcedimientoInput').value = '';
    document.getElementById('descripcionProcedimientoInput').value = '';
    document.getElementById('observacionesProcedimientoInput').value = '';
    document.getElementById('fechaProcedimientoInput').value = '';
}

function buscarProcedimientos() {
    const input = document.getElementById('input-busqueda').value;
    console.log("Buscar registros de procedimientos:", input);
}

//ELIMINAR
function eliminarProcedimiento(idProcedimiento) {
    if (confirm("¿Estás seguro de que deseas eliminar este procedimiento?")) {
        const formData = new FormData();
        formData.append('idProcedimientoEliminar', idProcedimiento);

        fetch('Eliminar_procedimiento.php', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Hubo un problema al eliminar el procedimiento.');
            }
            return response.json();
        })
        .then(data => {
            console.log('Procedimiento eliminado exitosamente:', data);
        })
        .catch(error => {
            console.error('Error al eliminar el procedimiento:', error);
        });
    }
}

 
function modificarProcedimiento(idProcedimiento) {
    const row = document.getElementById('procedimiento_' + idProcedimiento);
    const cells = row.querySelectorAll('td');

    cells.forEach((cell, index) => {
        if (index < 4) { // Modificar la condición aquí
            const originalValue = cell.textContent.trim();
            cell.innerHTML = `<input type="text" class="form-control" value="${originalValue}">`;
        }
    });
    const button = row.querySelector('.btn-primary');
    button.textContent = "Guardar";
    button.classList.remove('btn-primary');
    button.classList.add('btn-success');
    button.addEventListener('click', function() {
        guardarModificacion(idProcedimiento);
    });
}

function guardarProcedimiento() {
    // Obtener los valores de los campos del formulario
    const nombreProcedimiento = document.getElementById('nombreProcedimientoInput').value;
    const descripcionProcedimiento = document.getElementById('descripcionProcedimientoInput').value;
    const observacionesProcedimiento = document.getElementById('observacionesProcedimientoInput').value;
    const fechaProcedimiento = document.getElementById('fechaProcedimientoInput').value;
    if (nombreProcedimiento === '' || descripcionProcedimiento === '' || observacionesProcedimiento === '' || fechaProcedimiento === '') {
        alert("Por favor, complete todos los campos.");
        return;
    }
    const form = document.createElement('form');
    form.method = 'post';
    form.action = 'Modificar_procedimiento.php';

    const nombreInput = document.createElement('input');
    nombreInput.type = 'hidden'; // Ocultar este campo del usuario
    nombreInput.name = 'nombreProcedimientoInput';
    nombreInput.value = nombreProcedimiento;
    form.appendChild(nombreInput);

    const descripcionInput = document.createElement('input');
    descripcionInput.type = 'hidden';
    descripcionInput.name = 'descripcionProcedimientoInput';
    descripcionInput.value = descripcionProcedimiento;
    form.appendChild(descripcionInput);

    const observacionesInput = document.createElement('input');
    observacionesInput.type = 'hidden';
    observacionesInput.name = 'observacionesProcedimientoInput';
    observacionesInput.value = observacionesProcedimiento;
    form.appendChild(observacionesInput);

    const fechaInput = document.createElement('input');
    fechaInput.type = 'hidden';
    fechaInput.name = 'fechaProcedimientoInput';
    fechaInput.value = fechaProcedimiento;
    form.appendChild(fechaInput);
    document.body.appendChild(form);
    form.submit();
    document.getElementById('nombreProcedimientoInput').value = '';
    document.getElementById('descripcionProcedimientoInput').value = '';
    document.getElementById('observacionesProcedimientoInput').value = '';
    document.getElementById('fechaProcedimientoInput').value = '';
}

document.getElementById('btnGuardarProcedimiento').addEventListener('click', function() {
    const form = document.getElementById('formAgregarProcedimiento');
    const formData = new FormData(form);

    fetch('Guardar_procedimiento.php', {
        method: 'POST',
        body: formData
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Hubo un problema al guardar el procedimiento.');
        }
        return response.json();
    })
    .then(data => {
        console.log('Procedimiento guardado exitosamente:', data);
    })
    .catch(error => {
        console.error('Error al guardar el procedimiento:', error);
    });
});
</script>
</body>
</html>