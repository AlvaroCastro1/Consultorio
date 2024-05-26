<?php
// Incluir el archivo de conexión a la base de datos
require '../includes/conexion.php';

// Verificar si se ha enviado algún dato por POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario de manera segura
    $fechaControl = isset($_POST['fechaControl']) ? $_POST['fechaControl'] : '';
    $altura = isset($_POST['altura']) ? $_POST['altura'] : 0;
    $peso = isset($_POST['peso']) ? $_POST['peso'] : 0;
    $indiceMasaCorporal = isset($_POST['indiceMasaCorporal']) ? $_POST['indiceMasaCorporal'] : 0;
    $circunferenciaDelCraneo = isset($_POST['circunferenciaDelCraneo']) ? $_POST['circunferenciaDelCraneo'] : 0;
    $evaluacion = isset($_POST['evaluacion']) ? $_POST['evaluacion'] : '';
    $idExpedienteDC = isset($_POST['idExpedienteDC']) ? $_POST['idExpedienteDC'] : '';

    // Iniciar una transacción
    $conn->begin_transaction();

    try {
        // Preparar la consulta SQL para insertar en la tabla ControlCrecimiento
        $sql = "INSERT INTO ControlCrecimiento (fechaControl, altura, peso, indiceMasaCorporal, circunferenciaDelCraneo, evaluacion) VALUES (?, ?, ?, ?, ?, ?)";

        // Preparar la sentencia
        $stmt = $conn->prepare($sql);

        // Vincular parámetros
        $stmt->bind_param("sdddds", $fechaControl, $altura, $peso, $indiceMasaCorporal, $circunferenciaDelCraneo, $evaluacion);

        // Ejecutar la sentencia
        if (!$stmt->execute()) {
            throw new Exception("Error al guardar los datos en ControlCrecimiento: " . $stmt->error);
        }

        // Obtener el ID del nuevo registro en ControlCrecimiento
        $idControlCDC = $conn->insert_id;

        // Preparar la consulta SQL para insertar en la tabla detalleControlCrecimiento
        $sqlDetalle = "INSERT INTO detalleControlCrecimiento (idControlCDC, idExpedienteDC) VALUES (?, ?)";

        // Preparar la sentencia
        $stmtDetalle = $conn->prepare($sqlDetalle);

        // Vincular parámetros
        $stmtDetalle->bind_param("ii", $idControlCDC, $idExpedienteDC);

        // Ejecutar la sentencia
        if (!$stmtDetalle->execute()) {
            throw new Exception("Error al guardar los datos en detalleControlCrecimiento: " . $stmtDetalle->error);
        }

        // Confirmar la transacción
        $conn->commit();

        // Responder con éxito
        echo json_encode(array("success" => true, "message" => "Datos guardados correctamente"));
    } catch (Exception $e) {
        // Revertir la transacción en caso de error
        $conn->rollback();

        // Responder con el error
        echo json_encode(array("success" => false, "message" => $e->getMessage()));
    }

    // Cerrar las sentencias
    $stmt->close();
    $stmtDetalle->close();
} else {
    // Si no se reciben datos por POST, devolver un mensaje de error
    echo json_encode(array("success" => false, "message" => "No se han recibido datos por POST"));
}

// Cerrar la conexión
$conn->close();
?>

