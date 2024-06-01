<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Control de crecimiento</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/ControlStyles.css">
    <link rel="stylesheet" href="../assets/css/barraNav.css">
    <script src="../assets/js/header.js"></script>
</head>
<body>
    <div id="alerta">
        <div aria-live="polite" aria-atomic="true" class="bg-body-secondary position-relative bd-example-toasts rounded-3">
            <div class="toast-container p-3 top-0 end-0" id="toastPlacement">
                <div class="toast align-items-center border-0" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="d-flex">
                      <div class="toast-body">
                      </div>
                      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                  </div>
            </div>
        </div>              
    </div>
    <script>
        const navItems = [
        {name: "Vacunas", uri: "../Vacunas/vacunas.html"},
        {name: "Estudios", uri: "../Estudios/estudios.html"},
        {name: "Alergias", uri: "../Alergias/alergias.html"},
        {name: "Antecedentes", uri: "..Antecedentes/antecedentes.html"},
        {name: "Signos Vitales", uri: "../Signos/Signos.html"},
        {name: "Tratamiento", uri: "../Tratamiento/Tratamiento.html"},
        {name: "Procedimiento", uri: "../Procedimiento/procedimiento.html"},
        {name: "Control de Crecimiento", uri: "../Control/control.php"},
        {name: "Expediente", uri: "../Expediente/expediente.html"},
        {name: "Gráficas", uri: "../Graficar/index.php"}
        
        ];
    
        createHeader(navItems);
        
    </script>
    
    
    <div class="container2  mt-5">
        <h1 class="titulo-control mb-4">Control de crecimiento</h1>
        
        <div class="input-group mb-3">
            <input type="date" class="form-control" placeholder="Buscar por Fecha" id="input-busqueda">
            <button class="btn btn-outline-secondary" type="button" onclick="buscar()">Buscar</button>
            <button class="btn btn-outline-secondary" type="button" onclick="limpiar()">Limpiar</button>
        </div>  
        
        <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalAgregar">Agregar</button>

        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="tabla-control">
                <thead>
                    <tr>
                        <th>Id Control</th>
                        <th>Altura</th>
                        <th>Peso</th>
                        <th>IMC</th>
                        <th>Perimetro Cefálico</th>
                        <th>Evaluación</th>
                        <th>Fecha de Registro</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="content">
                    <tr>
                        <td contenteditable="false">Ej id</td>
                        <td contenteditable="false">altura</td>
                        <td contenteditable="false">peso</td>
                        <td contenteditable="false">imc</td>
                        <td contenteditable="false">perimetro</td>
                        <td contenteditable="false">Evaluacion</td>
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
                    <form id="registroEstudio">
                        <input type="number" class="form-control mb-3" id="altura"                  placeholder="Altura">
                        <input type="number" class="form-control mb-3" id="peso"                    placeholder="Peso">
                        <input type="number" class="form-control mb-3" id="circunferenciaDelCraneo" placeholder="Perimetro Cefálico">
                        <input type="number" class="form-control mb-3" id="indiceMasaCorporal"      placeholder="IMC">
                        <input type="date"   class="form-control mb-3" id="fechaControl"            placeholder="Fecha de Registro">
                        <input type="text"   class="form-control mb-3" id="evaluacion"              placeholder="Evaluación">
                        
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger me-2" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" onclick="agregarDesdeModal()">Aceptar</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalModificar" tabindex="-1" aria-labelledby="modalModificarLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalModificarLabel">Control de Crecimiento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="registroEstudio">
                    <input type="hidden" class="form-control mb-3" id="idControlModificar" placeholder="ID">
                    <input type="number" class="form-control mb-3" id="alturaModificar" placeholder="Altura">
                    <input type="number" class="form-control mb-3" id="pesoModificar" placeholder="Peso">
                    <input type="number" class="form-control mb-3" id="circunferenciaDelCraneoModificar" placeholder="Perímetro Cefálico">
                    <input type="number" class="form-control mb-3" id="indiceMasaCorporalModificar" placeholder="IMC">
                    <input type="date" class="form-control mb-3" id="fechaControlModificar" placeholder="Fecha de Registro">
                    <input type="text" class="form-control mb-3" id="evaluacionModificar" placeholder="Evaluación">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger me-2" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="ModificarDesdeModal()">Aceptar</button>
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
        var idPaciente = null;
        var idExpediente = null; 

        obtenerDatosSession()
        function obtenerDatosSession(){
            // Obtener los datos de sessionStorage
            const datos = JSON.parse(sessionStorage.getItem('datosPaciente'));

            if (datos) {
                idPaciente = datos.idPacienteE;
                idExpediente = datos.idExpedienteE

                console.log("se obtuvieron los datos idPaciente: ", idPaciente, "idExpediente: ", idExpediente);
            } else {
                alert("Su sesión ya expiró o no la ha iniciado");
                window.location.href = '../index.php';
            }
        }
        
        function agregarDesdeModal() {
            // Obtener los valores de los campos del formulario
            const altura = document.getElementById('altura').value;
            const peso = document.getElementById('peso').value;
            const indiceMasaCorporal = document.getElementById('indiceMasaCorporal').value;
            const circunferenciaDelCraneo = document.getElementById('circunferenciaDelCraneo').value;
            const evaluacion = document.getElementById('evaluacion').value;
            const fechaControl = document.getElementById('fechaControl').value;
            
            //var fechaFormato = formatoFecha();

            // Realizar la solicitud AJAX para guardar los datos
            fetch('../Control/guardar.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `idExpedienteDC=${idExpediente}&altura=${altura}&peso=${peso}
                &indiceMasaCorporal=${indiceMasaCorporal}&circunferenciaDelCraneo=${circunferenciaDelCraneo}&evaluacion=${evaluacion}
                &fechaControl=${fechaControl}`
            })
            .then(response => response.json())
            .then(data => {
                // Mostrar mensaje de éxito o error
                if (data.success) {
                    alert(data.message);
                    // Actualizar la tabla o hacer cualquier otra acción necesaria
                    buscar();
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al guardar los datos');
            });
        
            // Cerrar el modal después de agregar el registro
            const modal = bootstrap.Modal.getInstance(document.getElementById('modalAgregar'));
            modal.hide();
        
            // Limpiar los campos del modal
            document.getElementById('altura').value = '';
            document.getElementById('peso').value = '';
            document.getElementById('indiceMasaCorporal').value = '';
            document.getElementById('circunferenciaDelCraneo').value = '';
            document.getElementById('evaluacion').value = '';
            document.getElementById('fechaControl').value = '';
        }
        
        buscar()
        function buscar() {
            let input = document.getElementById("input-busqueda").value
            console.log("Buscar registros de signos:", input);
            let content = document.getElementById("content")
            let url = "../Control/buscar.php"
            let formaData = new FormData()
            
            formaData.append('idExpedienteDC', idExpediente)
            formaData.append('input-busqueda', input)

            fetch(url, {
                method: "POST",
                body: formaData
            }).then(Response => Response.json())
            .then(data => {
                content.innerHTML = data

            }).catch(err => console.log(err))
        }

        function eliminarFila(button) {
            // Obtener el ID de la fila
            const row = button.closest('tr');
            const idControlC = row.querySelector('td:first-child').textContent;
            console.log("la id que quiero eliminar es: ", idControlC);

            
            // Realizar la solicitud AJAX para guardar los datos
            fetch('../Control/eliminar.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `idControlC=${idControlC}`
            })
            .then(response => response.json())
            .then(data => {
                // Mostrar mensaje de éxito o error
                if (data.success) {
                    alert(data.message);
                    // Actualizar la tabla o hacer cualquier otra acción necesaria
                    buscar();
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al eliminar los datos');
            });
        }

        function modificarControl(button) {
            const row = button.closest('tr');
            const cells = row.querySelectorAll('td');
            const modal = new bootstrap.Modal(document.getElementById('modalModificar'));

            // Extraer los datos de la fila seleccionada
            const data = {
                idControl: cells[0].textContent,
                altura: cells[1].textContent,
                peso: cells[2].textContent,
                circunferenciaDelCraneo: cells[3].textContent,
                indiceMasaCorporal: cells[4].textContent,
                fechaControl: cells[6].textContent,
                evaluacion: cells[5].textContent
            };

            // Cargar los datos en los campos de entrada del modal
            document.getElementById('idControlModificar').value = data.idControl;
            
            document.getElementById('alturaModificar').value = data.altura;
            document.getElementById('pesoModificar').value = data.peso;
            document.getElementById('circunferenciaDelCraneoModificar').value = data.circunferenciaDelCraneo;
            document.getElementById('indiceMasaCorporalModificar').value = data.indiceMasaCorporal;
            document.getElementById('fechaControlModificar').value = data.fechaControl;
            document.getElementById('evaluacionModificar').value = data.evaluacion;

            // Mostrar el modal
            modal.show();
        }

        function ModificarDesdeModal() {
            const idControl = document.getElementById('idControlModificar').value;
            console.log(idControl);
            const altura = document.getElementById('alturaModificar').value;
            const peso = document.getElementById('pesoModificar').value;
            const circunferenciaDelCraneo = document.getElementById('circunferenciaDelCraneoModificar').value;
            const indiceMasaCorporal = document.getElementById('indiceMasaCorporalModificar').value;
            const fechaControl = document.getElementById('fechaControlModificar').value;
            const evaluacion = document.getElementById('evaluacionModificar').value;

            if (!altura) {
                alert('Por favor, ingresa la altura.');
                return; // Detener el proceso si el campo está vacío
            }
            if (!peso) {
                alert('Por favor, ingresa el peso.');
                return; // Detener el proceso si el campo está vacío
            }
            if (!circunferenciaDelCraneo) {
                alert('Por favor, ingresa la circunferencia del cráneo.');
                return; // Detener el proceso si el campo está vacío
            }
            if (!indiceMasaCorporal) {
                alert('Por favor, ingresa el IMC.');
                return; // Detener el proceso si el campo está vacío
            }
            if (!fechaControl) {
                alert('Por favor, ingresa la fecha de control.');
                return; // Detener el proceso si el campo está vacío
            }
            if (!evaluacion) {
                alert('Por favor, ingresa la evaluación.');
                return; // Detener el proceso si el campo está vacío
            }

            fetch('../Control/modificar.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `idControlC=${idControl}&altura=${altura}&peso=${peso}&circunferenciaDelCraneo=${circunferenciaDelCraneo}&indiceMasaCorporal=${indiceMasaCorporal}&fechaControl=${fechaControl}&evaluacion=${evaluacion}`
            })
            .then(response => response.json())
            .then(data => {
                // Mostrar mensaje de éxito o error
                if (data.success) {
                    alert(data.message);
                    // Actualizar la tabla o hacer cualquier otra acción necesaria
                    buscar();
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al guardar los datos');
            });

            // Cerrar el modal después de agregar el registro
            const modal = bootstrap.Modal.getInstance(document.getElementById('modalModificar'));
            modal.hide();

            // Limpiar los campos del formulario
            document.getElementById('registroEstudio').reset();
        }


        function formatoFecha() {
            // Obtener el input de fecha
            var fechaInput = document.getElementById("fechaSignosInput");

            // Obtener el valor del input (fecha seleccionada por el usuario)
            var fechaSeleccionada = fechaInput.value;

            // Verificar si se ha seleccionado una fecha
            if (fechaSeleccionada) {
                // Convertir la fecha a un objeto Date
                var fechaObj = new Date(fechaSeleccionada);

                // Obtener los componentes de la fecha (año, mes, día)
                var año = fechaObj.getFullYear();
                var mes = (fechaObj.getMonth() + 1).toString().padStart(2, '0'); // Agregar un cero al mes si es necesario
                var dia = fechaObj.getDate().toString().padStart(2, '0'); // Agregar un cero al día si es necesario

                // Crear el formato deseado (año-mes-día)
                var formatoDeseado = año + "-" + mes + "-" + dia;

                // Asignar el formato deseado al valor del input
                fechaInput.value = formatoDeseado;
            }

            // Retornar el valor del input modificado
            console.log("se obtuvo el valor= ",fechaInput.value);

            return fechaInput.value;
        }
        function limpiar(){
            document.getElementById('input-busqueda').value = '';
            buscar()


        }
    </script>
</body>
</html>
