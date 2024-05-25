<?php
// Incluir el archivo de conexión a la base de datos
require '../includes/conexion.php';

// Verificar si se ha enviado algún dato por POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario de manera segura
    $temperatura = isset($_POST['temperatura']) ? $_POST['temperatura'] : '';
    $frecuenciaR = isset($_POST['frecuenciaR']) ? $_POST['frecuenciaR'] : '';
    $frecuenciaC = isset($_POST['frecuenciaC']) ? $_POST['frecuenciaC'] : '';
    $oxigenacion = isset($_POST['oxigenacion']) ? $_POST['oxigenacion'] : '';
    $presionArterial = isset($_POST['presionArterial']) ? $_POST['presionArterial'] : '';
    $edoHidratacion = isset($_POST['edoHidratacion']) ? $_POST['edoHidratacion'] : '';
    $edoConciencia = isset($_POST['edoConciencia']) ? $_POST['edoConciencia'] : '';
    $edoNeurologico = isset($_POST['edoNeurologico']) ? $_POST['edoNeurologico'] : '';
    $fechaSignos = isset($_POST['fechaSignos']) ? $_POST['fechaSignos'] : '';
    $idExpedienteDS = isset($_POST['idExpedienteDS']) ? $_POST['idExpedienteDS'] : '';

    // Iniciar una transacción
    $conn->begin_transaction();

    try {
        // Preparar la consulta SQL para insertar en la tabla Signos
        $sql = "INSERT INTO Signos (temperatura, frecuenciaRespiratoria, frecuenciaCardiaca, oxigenacion, presionArterial, estadoHidratacion, estadoConciencia, estadoNeurologico, fechaActualizacion) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

        // Preparar la sentencia
        $stmt = $conn->prepare($sql);

        // Vincular parámetros
        $stmt->bind_param("iiiiissss", $temperatura, $frecuenciaR, $frecuenciaC, $oxigenacion, $presionArterial, $edoHidratacion, $edoConciencia, $edoNeurologico, $fechaSignos);

        // Ejecutar la sentencia
        if (!$stmt->execute()) {
            throw new Exception("Error al guardar los datos en Signos: " . $stmt->error);
        }

        // Obtener el ID del nuevo registro en Signos
        $idSignosDS = $conn->insert_id;

        // Preparar la consulta SQL para insertar en la tabla detalleSignos
        $sqlDetalle = "INSERT INTO detalleSignos (idExpedienteDS, idSignosDS) VALUES (?, ?)";

        // Preparar la sentencia
        $stmtDetalle = $conn->prepare($sqlDetalle);

        // Vincular parámetros
        $stmtDetalle->bind_param("ii", $idExpedienteDS, $idSignosDS);

        // Ejecutar la sentencia
        if (!$stmtDetalle->execute()) {
            throw new Exception("Error al guardar los datos en detalleSignos: " . $stmtDetalle->error);
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

