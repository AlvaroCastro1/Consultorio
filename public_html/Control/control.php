<?php
?>
<!DOCTYPE html>
<html lang="en">
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
            {name: "Antecedentes", uri: "../Antecedentes/antecedentes.html"},
            {name: "Signos Vitales", uri: "../Signos/Signos.html"},
            {name: "Tratamiento", uri: "../Tratamiento/Tratamiento.html"},
            {name: "Procedimiento", uri: "../Procedimiento/procedimiento.html"},
            {name: "Control de Crecimiento", uri: "../Control/control.html"},
            {name: "Gráficas", uri: "../Graficar/index.php"}

        ];
    
        createHeader(navItems);
    </script>
    
    <div class="container2  mt-5">
        <h1 class="titulo-control mb-4">Control de crecimiento</h1>
        
        <div class="input-group mb-3">
            <input type="date" class="form-control"  id="input-busqueda">
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
                <tbody id="tabla-estudios-body">
                    
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
                    <form method="POST" action="../Control/insertarControl.php" id="registroEstudio">
                        <input type="number" class="form-control mb-3" id="altura" name="altura" placeholder="Altura" min="40" step="0.01" >
                        <input type="number" class="form-control mb-3" id="peso" name="peso" placeholder="Peso" min="1" step="0.001">
                        <input type="number" class="form-control mb-3" id="circunferenciaDelCraneo" name="circunferenciaDelCraneo" placeholder="Perimetro Cefálico" min="20" step="0.01">
                        <input type="number" class="form-control mb-3" id="indiceMasaCorporal" name="indiceMasaCorporal" placeholder="IMC" min="18" step="0.1">
                        <input type="date" class="form-control mb-3" id="fechaControl" name="fechaControl" placeholder="Fecha de Registro">
                        <textarea class="form-control mb-3" id="evaluacion" name="evaluacion" placeholder="Evaluación" maxlength="30"></textarea>
                        
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger me-2" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" id="btnAceptar" onclick="insertaControl()">Aceptar</button>
                    <button type="submit" class="btn btn-primary d-none"
                        onclick="modificar()" id="btnActualizar">Actualizar</button>
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
        var listaCrecimientos = [];
        var crecimiento =  null;

        document.addEventListener("DOMContentLoaded", function() {
            buscar();
        });

        function mostrarAlerta(mensaje, tipo){
            //asignar texto al toast
            document.querySelector('.toast-body').innerHTML = mensaje;

            let toast = document.querySelector('.toast');
            toast.classList.remove('text-bg-success');
            toast.classList.remove('text-bg-danger');
            toast.classList.remove('text-bg-warning');
            toast.classList.add(tipo);
            // mostrar alerta
            let alerta = new bootstrap.Toast(toast);
            alerta.show();
        }

        function validarRegistro(){
            let Altura=document.getElementById('altura');
            if (Altura.value === '') {
                mostrarAlerta('Por favor, ingrese una altura', 'text-bg-warning');
                return false;
            }

            let Peso=document.getElementById('peso');
            if(Peso.value === ''){
                mostrarAlerta('Por favor, ingrese el peso' , 'text-bg-warning');
                return false;
            }

            let CircunferenciaDelCraneo=document.getElementById('circunferenciaDelCraneo');
            if(CircunferenciaDelCraneo.value === ''){
                mostrarAlerta('Por favor, ingrese el perímetro cefálico', 'text-bg-warning');
                return false;
            }

            let IMC=document.getElementById('indiceMasaCorporal');
            if(IMC.value === ''){
                mostrarAlerta('Por favor, ingrese el índice de masa Corporal', 'text-bg-warning');
                return false;
            }

            let Evaluacion=document.getElementById('evaluacion');
            if(Evaluacion.value === ''){
                mostrarAlerta('Por favor, ingrese la evaluacion', 'text-bg-warning');
                return false;
            }
            return true;
        }

        
        function limpiarModal() {
            document.getElementById('altura').value = '';
            document.getElementById('peso').value = '';
            document.getElementById('indiceMasaCorporal').value = '';
            document.getElementById('evaluacion').value = '';
            document.getElementById('circunferenciaDelCraneo').value = '';
            document.getElementById('fechaControl').value = '';
        }


        function insertaControl() {
        if (validarRegistro()) {
            let altura = document.getElementById('altura').value;
            let peso = document.getElementById('peso').value;
            let indiceMasaCorporal = document.getElementById('indiceMasaCorporal').value;
            let evaluacion = document.getElementById('evaluacion').value;
            let circunferenciaDelCraneo = document.getElementById('circunferenciaDelCraneo').value;
            let fechaControl = document.getElementById('fechaControl').value;

            // URL a la que enviar la petición POST
            const url = './insertarControl.php';

            // Crear un objeto FormData
            const formData = new FormData();
            formData.append('altura', altura);
            formData.append('peso', peso);
            formData.append('indiceMasaCorporal', indiceMasaCorporal);
            formData.append('evaluacion', evaluacion);
            formData.append('circunferenciaDelCraneo', circunferenciaDelCraneo);
            formData.append('fechaControl', fechaControl);

            // Configuración de la petición
            const configuracion = {
                method: 'POST',
                body: formData
            };

            // Enviamos la petición
            fetch(url, configuracion)
                .then(response => Promise.all([response.status, response.text()]))
                .then(([status, text]) => {
                    if (status !== 200) {
                        mostrarAlerta(text, 'text-bg-danger');
                    } else {
                        mostrarAlerta(text, 'text-bg-success');
                        // Recargar la página después de mostrar la alerta
                        location.reload();
                    }
                    limpiarModal();
                })
                .catch(error => {
                    console.error('Error al insertar el control de crecimiento:', error);
                });
        }
    }

    function buscar() {
            let fechaControlBuscar = document.getElementById('input-busqueda').value;
            const url = './mostarControl.php';

            //Creamos el formData
            let formData = new FormData();
            formData.append('fechaControl', fechaControlBuscar);

            fetch(url, {
                method: "POST",
                body: formData
            })
            // Manejamos la respuesta del servidor
            .then(response => {
                // Verificamos si la respuesta fue exitosa
                if (!response.ok) {
                    throw new Error('Ocurrió un problema con la solicitud.');
                }
                // Convertimos la respuesta a formato JSON
                return response.json();
            })
            // Manejamos los datos obtenidos del servidor
            .then(data => {
                // Obtenemos el cuerpo de la tabla
                let tableBody = document.getElementById("tabla-estudios-body");
                // Limpiamos el contenido actual del cuerpo de la tabla
                tableBody.innerHTML = '';
                this.listaCrecimientos = [];
                // Iteramos sobre los datos obtenidos y creamos filas en la tabla para cada conjunto de datos
                data.forEach(rowData => {
                    this.listaCrecimientos.push(rowData);
                    let row = document.createElement('tr');
                    // Insertamos los datos en las celdas de la fila
                    row.innerHTML = `
                        <td>${rowData.altura}</td>
                        <td>${rowData.peso}</td>
                        <td>${rowData.circunferenciaDelCraneo}</td>
                        <td>${rowData.indiceMasaCorporal}</td>
                        <td>${rowData.evaluacion}</td>
                        <td>${rowData.fechaControl}</td>
                        <td>
                            <button type="button" class="btn btn-danger me-2" onclick="eliminar(${rowData.idControlC})">Eliminar</button>
                            <button type="button" class="btn btn-primary" onclick="abrirControl(${rowData.idControlC})">Modificar</button>
                        </td>
                    `;
                    // Agregamos la fila al cuerpo de la tabla
                    tableBody.appendChild(row);
                });
            })
            // Manejamos errores que puedan ocurrir durante la solicitud
            .catch(error => {
                console.error('Error al realizar la solicitud:', error);
            });
        }

        function eliminar(idControl) {
            // URL a la que enviar la petición DELETE para eliminar el registro
            const url = './eliminarControl.php';

            // Crear un objeto con los datos a enviar
            const data = {
                idControlC: idControl

            };

            // Configuración de la petición
            const configuracion = {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data) // Convertir el objeto en una cadena JSON
            };

            // Enviamos la petición sin confirmación del usuario
            fetch(url, configuracion)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Error al eliminar el registro');
                    }
                    // Recargar la página después de eliminar el registro
                    location.reload();
                })
                .catch(error => {
                    console.error('Error al eliminar el control de crecimiento:', error);
                });
        }

        function abrirControl(idControl) {
            idControl=''+idControl;
            //Buscar idControl en el array listaCrecimientos
            let controlCrecimiento = this.listaCrecimientos.filter( (item) => item.idControlC === idControl);

            if(controlCrecimiento.length){
                this.crecimiento = controlCrecimiento[0];

                document.getElementById('altura').value = this.crecimiento.altura;
                document.getElementById('peso').value = this.crecimiento.peso;
                document.getElementById('indiceMasaCorporal').value = this.crecimiento.indiceMasaCorporal;
                document.getElementById('evaluacion').value = this.crecimiento.evaluacion;
                document.getElementById('circunferenciaDelCraneo').value = this.crecimiento.circunferenciaDelCraneo;
                document.getElementById('fechaControl').value = this.crecimiento.fechaControl;

                cambiarModal();

                document.getElementById('btnActualizar').classList.remove('d-none');
                document.getElementById('btnActualizar').classList.add('d-block');
                document.getElementById('btnAceptar').classList.remove('d-block');
                document.getElementById('btnAceptar').classList.add('d-none');



            }
            

        }

        function cambiarModal() {
            const modalElement = document.getElementById('modalAgregar');
            const modal = new bootstrap.Modal(modalElement);
            modal.toggle();
            // Agregar el siguiente código para cerrar el modal después de abrirlo
            setTimeout(() => {
                modal.hide();
            },100000); // Cambia el tiempo según sea necesario
        }

        function modificar(){

            if(validarRegistro()){

                let altura = document.getElementById('altura').value;
                let peso = document.getElementById('peso').value;
                let indiceMasaCorporal = document.getElementById('indiceMasaCorporal').value;
                let evaluacion = document.getElementById('evaluacion').value;
                let circunferenciaDelCraneo = document.getElementById('circunferenciaDelCraneo').value;
                let fechaControl = document.getElementById('fechaControl').value;

                console.log(altura);
                console.log(peso);
                console.log(indiceMasaCorporal);
                console.log(evaluacion);
                console.log(this.crecimiento.idControlC);
                // URL a la que enviar la petición POST
                const url = './modificarControl.php';
                
                // Crear un objeto FormData
                const formData = new FormData();
                formData.append('idControlC', this.crecimiento.idControlC);
                formData.append('altura', altura);
                formData.append('peso', peso);
                formData.append('indiceMasaCorporal', indiceMasaCorporal);
                formData.append('evaluacion', evaluacion);
                formData.append('circunferenciaDelCraneo', circunferenciaDelCraneo);
                formData.append('fechaControl', fechaControl);
                
                console.log(formData);
                // Configuración de la petición
                const configuracion = {
                    method: 'POST',
                    body: formData
                };

                // Enviamos la petición
                fetch(url, configuracion)
                    .then(response => Promise.all([response.status, response.text()]))
                    .then(([status, text]) => {
                        if (status !== 200) {
                            mostrarAlerta(text, 'text-bg-danger');
                        } else {
                            mostrarAlerta(text, 'text-bg-success');
                            // Recargar la página después de mostrar la alerta
                            limpiarModal();
                            document.getElementById('btnActualizar').classList.remove('d-block');
                            document.getElementById('btnActualizar').classList.add('d-none');
                            document.getElementById('btnAceptar').classList.remove('d-none');
                            document.getElementById('btnAceptar').classList.add('d-block');
                            location.reload();
                        }
                    })
                    .catch(error => {
                        console.error('Error al insertar el control de crecimiento:', error);
                    });

            }
        }

    </script>
</body>
</html>
