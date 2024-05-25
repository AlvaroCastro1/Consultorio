<?php
// Incluir el archivo de conexión a la base de datos
require '../includes/conexion.php';

// Verificar si se ha enviado algún dato por POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario de manera segura
    $idAlergia = isset($_POST['idAlergia']) ? $_POST['idAlergia'] : '';
    $tipoAlergia = isset($_POST['tipoAlergia']) ? $_POST['tipoAlergia'] : '';
    $alergeno = isset($_POST['alergeno']) ? $_POST['alergeno'] : '';
    $score = isset($_POST['score']) ? $_POST['score'] : '';



    // Iniciar una transacción
    $conn->begin_transaction();

    try {
        // Preparar la consulta SQL para actualizar en la tabla Alergias
        $sqlAlergias = "UPDATE Alergias SET tipoAlergia = ?, alergeno = ? WHERE idAlergias = ?";
        $stmtAlergias = $conn->prepare($sqlAlergias);
        $stmtAlergias->bind_param("ssi", $tipoAlergia, $alergeno, $idAlergia);

        // Ejecutar la sentencia
        if (!$stmtAlergias->execute()) {
            throw new Exception("Error al modificar los datos en Alergias: " . $stmtAlergias->error);
        }

        // Preparar la consulta SQL para actualizar en la tabla detalleAlergias
        $sqlDetalleAlergias = "UPDATE detalleAlergias SET score = ? WHERE idAlergiasDA = ?";
        $stmtDetalleAlergias = $conn->prepare($sqlDetalleAlergias);
        $stmtDetalleAlergias->bind_param("di", $score, $idAlergia);

        // Ejecutar la sentencia
        if (!$stmtDetalleAlergias->execute()) {
            throw new Exception("Error al modificar los datos en detalleAlergias: " . $stmtDetalleAlergias->error);
        }

        // Confirmar la transacción
        $conn->commit();

        // Responder con éxito
        echo json_encode(array("success" => true, "message" => "Datos modificados correctamente"));
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
