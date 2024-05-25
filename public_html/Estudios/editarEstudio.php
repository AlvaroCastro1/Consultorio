<?php
// Conexión a la base de datos
include '../includes/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idEstudio = $_POST['idEstudio'];
    $tipoEstudio = $_POST['tipo'];
    $nombreEstudio = $_POST['nombre'];
    $descripcionEstudio = $_POST['descripcion'];
    $fechaEstudio = $_POST['fecha'];
    $idExpediente = $_POST['idExpediente'];

    // Actualiza la tabla Estudios
    $sqlEstudio = "UPDATE Estudios SET nombreEstudio = ?, tipoEstudio = ?, descripcionEstudio = ? WHERE idEstudios = ?";
    $stmtEstudio = $conn->prepare($sqlEstudio);
    $stmtEstudio->bind_param("sssi", $nombreEstudio, $tipoEstudio, $descripcionEstudio, $idEstudio);

    // Actualiza la tabla detalleEstudios
    $sqlDetalle = "UPDATE detalleEstudios SET fechaEstudio = ? WHERE idEstudiosDE = ? AND idExpedienteDE = ?";
    $stmtDetalle = $conn->prepare($sqlDetalle);
    $stmtDetalle->bind_param("sii", $fechaEstudio, $idEstudio, $idExpediente);

    if ($stmtEstudio->execute() && $stmtDetalle->execute()) {
        echo json_encode(['message' => 'Estudio actualizado exitosamente.']);
    } else {
        echo json_encode(['message' => 'Error al actualizar el estudio.']);
    }

    $stmtEstudio->close();
    $stmtDetalle->close();
    $conn->close();
}
?>
