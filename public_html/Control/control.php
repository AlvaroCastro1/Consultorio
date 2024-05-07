<?php
// Obtener el valor de idExpediente de la URL
$idExpediente = $_GET['idExpediente'] ?? null;

// Verificar si idExpediente es null y mostrar un mensaje de error si es así
if ($idExpediente === null) {
    echo 'Error: El parámetro idExpediente no se ha especificado.';
    
    exit; // Terminar el script para evitar que se procese el resto de la página
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Control de crecimiento</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/ControlStyles.css">
    <link rel="stylesheet" href="/assets/css/barraNav.css">
    <script src="/assets/js/header.js"></script>
</head>
<body>

    <script>
        const navItems = [
            {name: "Vacunas", uri: "../Vacunas/vacunas.html"},
            {name: "Estudios", uri: "../Estudios/estudios.html"},
            {name: "Alergias", uri: "../Alergias/alergias.html"},
            {name: "Antecedentes", uri: "../Antecedentes/antecedentes.html"},
            {name: "Signos Vitales", uri: "../Signos/Signos.html"},
            {name: "Tratamiento", uri: "../Tratamiento/Tratamiento.html"},
            {name: "Procedimiento", uri: "../Procedimiento/procedimiento.html"},
            {name: "Control de Crecimiento", uri: "../Control/control.html"},
            {name: "Gráficas", uri: "../Graficar/index.php?idExpediente=<?php echo $idExpediente; ?>"}

        ];
    
        createHeader(navItems);
    </script>
    
    <div class="container2  mt-5">
        <h1 class="titulo-control mb-4">Control de crecimiento</h1>
        
        <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Buscar por Fecha" id="input-busqueda">
            <button class="btn btn-outline-secondary" type="button" onclick="buscar()">Buscar</button>
        </div>  
        
        <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalAgregar">Agregar</button>

        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="tabla-control">
                <thead>
                    <tr>
                        <th>Altura</th>
                        <th>Peso</th>
                        <th>Perimetro Cefálico</th>
                        <th>IMC</th>
                        <th>Evaluación</th>
                        <th>Fecha de Registro</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td contenteditable="false">1.20</td>
                        <td contenteditable="false">25</td>
                        <td contenteditable="false">30</td>
                        <td contenteditable="false">11.5</td>
                        <td contenteditable="false">Sobrepeso</td>
                        <td><input type="date" class="form-control" value="2024-04-15" readonly></td>
                        <td>
                            <button type="button" class="btn btn-danger me-2" onclick="eliminarFila(this)">Eliminar</button>
                            <button type="button" class="btn btn-primary" onclick="modificarControl(this)">Modificar</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <div class="espacio-final"></div>
    </div>
    <div class="modal fade" id="modalAgregar" tabindex="-1" aria-labelledby="modalAgregarLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAgregarLabel">Control de Crecimiento</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="number" class="form-control mb-3" id="alturaInput" placeholder="Altura">
                    <input type="number" class="form-control mb-3" id="pesoInput" placeholder="Peso">
                    <input type="number" class="form-control mb-3" id="perimetroCInput" placeholder="Perimetro Cefálico">
                    <input type="number" class="form-control mb-3" id="imcInput" placeholder="IMC">
                    <input type="text" class="form-control mb-3" id="evaluacionInput" placeholder="Evaluación">
                    <input type="date" class="form-control mb-3" id="fechaControlInput" placeholder="Fecha de Registro">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger me-2" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" onclick="agregarDesdeModal()">Aceptar</button>
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
        function agregarDesdeModal() {
            const altura = document.getElementById('alturaInput').value;
            const peso= document.getElementById('pesoInput').value;
            const perimetroC = document.getElementById('perimetroCInput').value;
            const imc = document.getElementById('imcInput').value;
            const evaluacion= document.getElementById('evaluacionInput').value;
            const fechaControl = document.getElementById('fechaControlInput').value;

            const tabla = document.getElementById('tabla-control').getElementsByTagName('tbody')[0];
            const newRow = tabla.insertRow(tabla.rows.length);
            newRow.innerHTML = `
                <td>${altura}</td>
                <td>${peso}</td>
                <td>${perimetroC}</td>
                <td>${imc}</td>
                <td>${evaluacion}</td>
                <td><input type="date" class="form-control" value="${fechaControl}" readonly></td>
                <td>
                    <button type="button" class="btn btn-danger me-2" onclick="eliminarFila(this)">Eliminar</button>
                    <button type="button" class="btn btn-primary" onclick="modificarControl(this)">Modificar</button>
                </td>
            `;
        
            // Cerrar el modal después de agregar el registro
            const modal = bootstrap.Modal.getInstance(document.getElementById('modalAgregar'));
            modal.hide();
        
            // Limpiar los campos del modal
            document.getElementById('alturaInput').value = '';
            document.getElementById('pesoInput').value = '';
            document.getElementById('perimetroCInput').value = '';
            document.getElementById('imcInput').value = '';
            document.getElementById('evaluacionlInput').value = '';
            document.getElementById('fechaControlInput').value = '';
        }
        

        function buscar() {
            const input = document.getElementById('input-busqueda').value;
            console.log("Buscar registros de control de crecimiento:", input);
        }

        function eliminarFila(button) {
            var fila = button.closest('tr');
            // Elimina la fila del DOM
            fila.remove();
            console.log("Eliminar registro");
        }

        function modificarControl(button) {
            const row = button.closest('tr');
            const cells = row.querySelectorAll('td');
            cells.forEach(cell => {
                cell.contentEditable = true;
            });
            button.textContent = "Guardar";
            button.classList.remove('btn-primary');
            button.classList.add('btn-success');
            button.setAttribute('onclick', 'guardarControl(this)');
        }

        function guardarControl(button) {
            const row = button.closest('tr');
            const cells = row.querySelectorAll('td');
            cells.forEach(cell => {
                cell.contentEditable = false;
            });
            button.textContent = "Modificar";
            button.classList.remove('btn-success');
            button.classList.add('btn-primary');
            button.setAttribute('onclick', 'modificarControl(this)');
            console.log("Guardar Control");
        }
    </script>
</body>
</html>