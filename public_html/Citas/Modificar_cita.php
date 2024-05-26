<?php
include('../includes/conexion.php');

// Obtener los datos del formulario
$idCita = $_POST['idCita'];
$idPaciente = $_POST['idPaciente'];
$fechaCita = $_POST['fechaCita'];
$horaCita = $_POST['horaCita'];
$asistencia = $_POST['asistencia'];

// Validar que los campos no estén vacíos
if (empty($idCita) || empty($idPaciente) || empty($fechaCita) || empty($horaCita) || empty($asistencia)) {
    echo "<script>alert('Todos los campos son obligatorios'); window.location='citas.php';</script>";
    exit;
}

// Preparar la consulta de actualización
$query = "UPDATE Cita SET idPacienteC = ?, fecha = ?, hora = ?, asistencia = ? WHERE idCita = ?";
$stmt = $conn->prepare($query);

// Verificar si la preparación de la consulta fue exitosa
if (!$stmt) {
    echo "<script>alert('Error al preparar la consulta. Por favor inténtalo nuevamente'); window.location='citas.php';</script>";
    exit;
}

// Ejecutar la consulta de actualización
$stmt->bind_param("isssi", $idPaciente, $fechaCita, $horaCita, $asistencia, $idCita);
$modificar = $stmt->execute();

// Verificar si la consulta de actualización se ejecutó correctamente
if (!$modificar) {
    $conn->rollback();
    echo "<script>alert('Hubo un error al modificar la cita. Rollback ejecutado.'); window.location='citas.php';</script>";
} else {
    $conn->commit();
    echo "<script>alert('Cita modificada correctamente.'); window.location='citas.php';</script>";
}

// Cerrar la consulta y la conexión
$stmt->close();
$conn->close();
?>
