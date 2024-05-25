<?php
// Incluir el archivo de conexión a la base de datos
require '../includes/conexion.php';

// Verificar si se ha enviado algún dato por POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario de manera segura
    $idExpedienteDA = isset($_POST['idExpedienteDA']) ? $_POST['idExpedienteDA'] : '';
    $tipoAlergia = isset($_POST['tipoAlergia']) ? $_POST['tipoAlergia'] : '';
    $alergeno = isset($_POST['alergeno']) ? $_POST['alergeno'] : '';
    $score = isset($_POST['score']) ? floatval($_POST['score']) : '';



    // Iniciar una transacción
    $conn->begin_transaction();

    try {
        // Preparar la consulta SQL para insertar en la tabla Alergias
        $sqlAlergias = "INSERT INTO Alergias (tipoAlergia, alergeno) VALUES (?, ?)";

        // Preparar la sentencia
        $stmtAlergias = $conn->prepare($sqlAlergias);

        // Vincular parámetros
        $stmtAlergias->bind_param("ss", $tipoAlergia, $alergeno);

        // Ejecutar la sentencia
        if (!$stmtAlergias->execute()) {
            throw new Exception("Error al guardar los datos en Alergias: " . $stmtAlergias->error);
        }

        // Obtener el ID del nuevo registro en Alergias
        $idAlergias = $conn->insert_id;

        // Preparar la consulta SQL para insertar en la tabla detalleAlergias
        $sqlDetalleAlergias = "INSERT INTO detalleAlergias (idExpedienteDA, idAlergiasDA, score) VALUES (?, ?, ?)";

        // Preparar la sentencia
        $stmtDetalleAlergias = $conn->prepare($sqlDetalleAlergias);

        // Vincular parámetros
        $stmtDetalleAlergias->bind_param("iid", $idExpedienteDA, $idAlergias, $score);

        // Ejecutar la sentencia
        if (!$stmtDetalleAlergias->execute()) {
            throw new Exception("Error al guardar los datos en detalleAlergias: " . $stmtDetalleAlergias->error);
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
    $stmtAlergias->close();
    $stmtDetalleAlergias->close();
} else {
    // Si no se reciben datos por POST, devolver un mensaje de error
    echo json_encode(array("success" => false, "message" => "No se han recibido datos por POST"));
}

// Cerrar la conexión
$conn->close();
?>
