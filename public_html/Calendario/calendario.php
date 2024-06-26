<?php
include 'citas.php'; // Incluye el contenido de cita.php

// se usan las variables y metodos de citas
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset='utf-8' />
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<title>Agenda De Citas</title>
<script src='js/index.global.min.js'></script>
<script src="js/es.global.min.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- CSS de Bootstrap v5.3.3 -->
<link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet">

<!-- JS de Bootstrap v5.3.3 -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.3/js/bootstrap.min.js"></script>
<script src="../assets/js/header.js"></script>
<script src="calendar.js"></script>
<script src="js/obt_horarios.js"></script>



<link rel="stylesheet" href="../assets/css/CalendarioStyles.css">
<link rel="stylesheet" href="../assets/css/barraNav.css">

    
</head>
<body>
<script>
        const navItems = [
            {name: "Citas" ,uri: "../Citas/Citas.html"},
            {name: "Calendario" ,uri: "../Calendario/calendario.php"},
            { name: "Inicio", uri: "../../index.php" }
        
        ];
    
        createHeader(navItems);
        
    </script>
    <script>
    var idPaciente = null;
    var idExpediente = null;

    // Obtener los datos de sessionStorage
    const datos = JSON.parse(sessionStorage.getItem('datosPaciente'));

    if (datos) {
        idPaciente = datos.idPacienteE;
        idExpediente = datos.idExpedienteE

        console.log("se obtuvieron los datos idPaciente: ", idPaciente, "idExpediente: ", idExpediente);
    } else {
        var sesion = sessionStorage.getItem('sesion');
        if (!sesion) {
            // Si no hay sesión, redirige al usuario
            alert("Su sesión ya expiró o no la ha iniciado");
            window.location.href = '../index.php';
        }
    }
    </script>
<div class="container2 mt-5">
  <div class="row mt-4">
        <div class="col-md-12 mx-auto">
            <h1 class="titulo-calendario">Calendario De citas</h1>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-md-12 mx-auto">
            <div id='calendar'></div>
        </div>
    </div>
</div>
<div class="modal" tabindex="-1" id="eventModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Información de la Cita</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p id="eventInfo"></p>
                <input type="hidden" id="ocultoIdCita">
                <input type="hidden" id="ocultoIDPaciente">
                <input type="hidden" id="ocultoEventDate">
                <input type="hidden" id="ocultoEventTime">
                <input type="hidden" id="ocultoEventAttendance">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-danger" id="deleteButton">Borrar</button>
                <button type="button" class="btn btn-primary" id="modifyButton">Modificar</button>
            </div>
        </div>
    </div>
</div>
  <div class="modal" tabindex="-1" id="addEventModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Agregar Cita</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addEventForm">
                    <div class="form-group">
                        <label for="eventPatientId">ID del Paciente</label>
                        <input type="number" class="form-control" id="eventPatientId" required>
                    </div>
                    <div class="form-group">
                        <label for="eventDate">Fecha del Evento</label>
                        <input type="date" class="form-control" id="eventDate" required>
                    </div>
                    <div class="form-group">
                        <label for="eventTime">Hora del Evento</label>
                        <select class="form-control" id="eventTime" required>
                            <option value="">Seleccionar hora</option>
                        </select>
                    </div>
                    <div class="form-group form-check">
                        <input type="checkbox" class="form-check-input" id="eventAttendance">
                        <label class="form-check-label" for="eventAttendance">Asistencia</label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="saveButton">Guardar</button>
            </div>
        </div>
    </div>
</div>

  <div class="modal" tabindex="-1" id="editEventModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Cita</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editEventForm">
                    <div class="form-group">
                        <label for="eventPatientId">ID del Paciente</label>
                        <input type="number" class="form-control" id="editeventPatientId" required>
                    </div>
                    <div class="form-group">
                        <label for="eventDate">Fecha del Evento</label>
                        <input type="date" class="form-control" id="editeventDate" required>
                    </div>
                    <div class="form-group">
                        <label for="eventTime">Hora del Evento</label>
                        <select class="form-control" id="editeventTime" required>
                            <option value="">Seleccionar hora</option>
                        </select>
                    </div>
                    <div class="form-group form-check">
                        <input type="checkbox" class="form-check-input" id="editeventAttendance">
                        <label class="form-check-label" for="editeventAttendance">Asistencia</label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="editsaveButton">Guardar Cambios</button>
            </div>
        </div>
    </div>
</div>
<style>
.btn-close::before {
    content: 'x';
    font-size: 1.5rem;
    color: #000;
    font-weight: bold;
}
</style>

  <div class="espacio-final"></div>
  <footer>
        <div class="container3">
            <p>Pie de página</p>
        </div>
    </footer>
  
</body>
</html>