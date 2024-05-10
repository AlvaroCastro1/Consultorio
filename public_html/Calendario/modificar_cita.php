<?php
include '../includes/conexion.php';

// Obtener los datos enviados por AJAX
$citaId = $_POST['citaId'];
$patientId = $_POST['patientId'];
$eventDate = $_POST['eventDate'];
$eventTime = $_POST['eventTime'];
$eventAttendance = $_POST['eventAttendance'];

// Modificar los datos en la base de datos
$sql = "UPDATE Cita SET idPacienteC = ?, fecha = ?, hora = ?, asistencia = ? WHERE idCita = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("isssi", $patientId, $eventDate, $eventTime, $eventAttendance, $citaId);
if ($stmt->execute()) {
    echo 'Cita modificada correctamente';
} else {
    echo 'Error al modificar la cita: ' . $conn->error;
}

$stmt->close();
$conn->close();
?>
