<?php
header('Content-Type: application/json; charset=utf-8');
require_once "../includes/conexion.php";

// Obtener los datos del formulario

$idControlC = (int)$_POST['idControlC'];
$fechaControl = $_POST['fechaControl'];
$altura = (float)$_POST['altura'];
$peso = (float)$_POST['peso'];
$indiceMasaCorporal = (float)$_POST['indiceMasaCorporal'];
$circunferenciaDelCraneo = (float)$_POST['circunferenciaDelCraneo'];
$evaluacion = $_POST['evaluacion'];


// Utilizar una consulta preparada para actualizar el registro
$sql = "UPDATE ControlCrecimiento SET altura=?, peso=?, indiceMasaCorporal=?, evaluacion=?, circunferenciaDelCraneo=?, fechaControl = ? WHERE idControlC = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssssss", $altura, $peso, $indiceMasaCorporal, $evaluacion ,$circunferenciaDelCraneo, $fechaControl, $idControlC);

// Ejecutar la consulta
if ($stmt->execute()) {
    // Éxito
    echo json_encode("Control de crecimiento actualizado correctamente.");
} else {
    // Error
    echo json_encode("Error al actualizar el control de crecimiento: " . $stmt->error);
}

$stmt->close();
$conn->close();
?>
