<?php
// Incluir el archivo de conexión a la base de datos
require '../includes/conexion.php';

// Verificar si se ha enviado algún dato por POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario de manera segura
    $idExpedienteT = isset($_POST['idExpedienteT']) ? intval($_POST['idExpedienteT']) : 0;
    $descripcionTratamiento = isset($_POST['descripcionTratamiento']) ? $conn->real_escape_string($_POST['descripcionTratamiento']) : '';
    $duracion = isset($_POST['duracion']) ? $conn->real_escape_string($_POST['duracion']) : '';
    $diagnostico = isset($_POST['diagnostico']) ? $conn->real_escape_string($_POST['diagnostico']) : '';
    $fechaTratamiento = isset($_POST['fechaTratamiento']) ? $conn->real_escape_string($_POST['fechaTratamiento']) : '';

    if ($idExpedienteT == 0 || empty($descripcionTratamiento) || empty($duracion) || empty($diagnostico) || empty($fechaTratamiento)) {
        echo json_encode(array("success" => false, "message" => "Datos incompletos."));
        exit;
    }

    // Iniciar la transacción
    $conn->begin_transaction();

    try {
        // Insertar en la tabla Tratamiento
        $sqlTratamiento = "INSERT INTO Tratamiento (descripcionTratamiento, duracion, diagnostico, fechaTratamiento) VALUES (?, ?, ?, ?)";
        $stmtTratamiento = $conn->prepare($sqlTratamiento);
        $stmtTratamiento->bind_param("ssss", $descripcionTratamiento, $duracion, $diagnostico, $fechaTratamiento);

        if (!$stmtTratamiento->execute()) {
            throw new Exception("Error al insertar en Tratamiento: " . $stmtTratamiento->error);
        }

        // Obtener el idTratamiento recién insertado
        $idTratamientoT = $conn->insert_id;

        // Insertar en la tabla detalleTratamiento
        $sqlDetalle = "INSERT INTO detalleTratamiento (idExpedienteT, idTratamientoT) VALUES (?, ?)";
        $stmtDetalle = $conn->prepare($sqlDetalle);
        $stmtDetalle->bind_param("ii", $idExpedienteT, $idTratamientoT);

        if (!$stmtDetalle->execute()) {
            throw new Exception("Error al insertar en detalleTratamiento: " . $stmtDetalle->error);
        }

        // Si todo va bien, confirmar la transacción
        $conn->commit();
        echo json_encode(array("success" => true, "message" => "Datos guardados correctamente"));

    } catch (Exception $e) {
        // Si ocurre un error, revertir la transacción
        $conn->rollback();
        echo json_encode(array("success" => false, "message" => $e->getMessage()));
    }

    // Cerrar las sentencias
    $stmtTratamiento->close();
    $stmtDetalle->close();
} else {
    // Si no se reciben datos por POST, devolver un mensaje de error
    echo json_encode(array("success" => false, "message" => "No se han recibido datos por POST"));
}
?>
