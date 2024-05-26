<?php
// Incluir el archivo de conexión a la base de datos
require '../includes/conexion.php';

// Verificar si se ha enviado algún dato por POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario de manera segura
    $fechaControl = isset($_POST['fechaControl']) ? $_POST['fechaControl'] : '';
    $altura = isset($_POST['altura']) ? $_POST['altura'] : '';
    $peso = isset($_POST['peso']) ? $_POST['peso'] : '';
    $indiceMasaCorporal = isset($_POST['indiceMasaCorporal']) ? $_POST['indiceMasaCorporal'] : '';
    $circunferenciaDelCraneo = isset($_POST['circunferenciaDelCraneo']) ? $_POST['circunferenciaDelCraneo'] : '';
    $evaluacion = isset($_POST['evaluacion']) ? $_POST['evaluacion'] : '';
    $idControlC = isset($_POST['idControlC']) ? $_POST['idControlC'] : '';

    // Verificar si se proporcionó un idControlC válido
    if (empty($idControlC)) {
        echo json_encode(array("success" => false, "message" => "No se ha proporcionado un idControlC válido"));
        exit;
    }

    // Preparar la consulta SQL utilizando consultas preparadas
    $sql = "UPDATE ControlCrecimiento SET fechaControl=?, altura=?, peso=?, indiceMasaCorporal=?, circunferenciaDelCraneo=?, evaluacion=? WHERE idControlC=?";

    // Preparar la sentencia
    $stmt = $conn->prepare($sql);

    // Vincular parámetros
    $stmt->bind_param("sddddsi", $fechaControl, $altura, $peso, $indiceMasaCorporal, $circunferenciaDelCraneo, $evaluacion, $idControlC);

    // Ejecutar la sentencia
    if ($stmt->execute()) {
        echo json_encode(array("success" => true, "message" => "Datos modificados correctamente"));
    } else {
        echo json_encode(array("success" => false, "message" => "Error al modificar los datos: " . $conn->error));
    }

    // Cerrar la sentencia
    $stmt->close();
} else {
    // Si no se reciben datos por POST, devolver un mensaje de error
    echo json_encode(array("success" => false, "message" => "No se han recibido datos por POST"));
}

// Cerrar la conexión
$conn->close();
?>
