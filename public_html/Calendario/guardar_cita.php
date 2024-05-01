<?php
include '../includes/conexion.php';

// Obtener los datos enviados por AJAX
$patientId = $_POST['patientId'];
$eventDate = $_POST['eventDate'];
$eventTime = $_POST['eventTime'];
$eventAttendance = $_POST['eventAttendance'];

// Insertar los datos en la base de datos
$sql = "INSERT INTO Cita (idPacienteC, fecha, hora, asistencia) VALUES ('$patientId', '$eventDate', '$eventTime', '$eventAttendance')";
if ($conn->query($sql) === TRUE) {
    echo 'Cita guardada correctamente';
} else {
    echo 'Error al guardar la cita: ' . $conn->error;
}

$conn->close();
?>
