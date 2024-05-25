<?php
// Incluir el archivo de conexión a la base de datos
require '../includes/conexion.php';

// Verificar si se ha enviado algún dato por POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario de manera segura
    $idExpedienteDA = isset($_POST['idExpedienteDA']) ? $_POST['idExpedienteDA'] : '';
    $tipoAntecedente = isset($_POST['tipoAntecedente']) ? $_POST['tipoAntecedente'] : '';
    $nombrePadecimiento = isset($_POST['nombrePadecimiento']) ? $_POST['nombrePadecimiento'] : '';
    $descripcion = isset($_POST['descripcion']) ? $_POST['descripcion'] : '';

    // Iniciar una transacción
    $conn->begin_transaction();

    try {
        // Preparar la consulta SQL para insertar en la tabla Antecedentes
        $sqlAntecedentes = "INSERT INTO Antecedentes (tipoAntecedente, nombrePadecimiento, descripcion) VALUES (?, ?, ?)";

        // Preparar la sentencia
        $stmtAntecedentes = $conn->prepare($sqlAntecedentes);

        // Vincular parámetros
        $stmtAntecedentes->bind_param("sss", $tipoAntecedente, $nombrePadecimiento, $descripcion);

        // Ejecutar la sentencia
        if (!$stmtAntecedentes->execute()) {
            throw new Exception("Error al guardar los datos en Antecedentes: " . $stmtAntecedentes->error);
        }

        // Obtener el ID del nuevo registro en Antecedentes
        $idAntecedentesDA = $conn->insert_id;

        // Preparar la consulta SQL para insertar en la tabla detalleAntecedentes
        $sqlDetalle = "INSERT INTO detalleAntecedentes (idExpedienteDA, idAntecedentesDA) VALUES (?, ?)";

        // Preparar la sentencia
        $stmtDetalle = $conn->prepare($sqlDetalle);

        // Vincular parámetros
        $stmtDetalle->bind_param("ii", $idExpedienteDA, $idAntecedentesDA);

        // Ejecutar la sentencia
        if (!$stmtDetalle->execute()) {
            throw new Exception("Error al guardar los datos en detalleAntecedentes: " . $stmtDetalle->error);
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
    $stmtAntecedentes->close();
    $stmtDetalle->close();
} else {
    // Si no se reciben datos por POST, devolver un mensaje de error
    echo json_encode(array("success" => false, "message" => "No se han recibido datos por POST"));
}

// Cerrar la conexión
$conn->close();
?>

