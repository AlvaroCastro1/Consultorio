<?php
include('../includes/conexion.php');

$idProcedimiento = $_POST['idProcedimiento'];
$nombreProcedimiento = $_POST['nombreProcedimientoInput'];
$descripcionProcedimiento = $_POST['descripcionProcedimientoInput'];
$observacionesProcedimiento = $_POST['observacionesProcedimientoInput'];

if (!filter_var($idProcedimiento, FILTER_VALIDATE_INT) || $idProcedimiento <= 0) {
    echo "<script>alert('ID de procedimiento inválido.'); window.location='procedimiento.php';</script>";
    exit; 
}

$conn->begin_transaction();

$query = "UPDATE procedimiento 
          SET nombreProceso = ?, 
              descripcionProcedimiento = ?, 
              observacionesProcedimiento = ? 
          WHERE idProcedimiento = ?";

$stmt = $conn->prepare($query);
$stmt->bind_param("sssi", $nombreProcedimiento, $descripcionProcedimiento, $observacionesProcedimiento, $idProcedimiento);
$modificar = $stmt->execute();

if (!$modificar) {
    $conn->rollback();
    echo "<script>alert('Hubo un error al modificar el procedimiento. Rollback ejecutado.'); window.location='procedimiento.php';</script>";
} else {
    $conn->commit();
    echo "<script>alert('Procedimiento modificado correctamente.'); window.location='procedimiento.php';</script>";
}

$stmt->close();
$conn->close();
?>
