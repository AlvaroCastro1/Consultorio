<?php
// Incluir el archivo de conexión a la base de datos
require '../includes/conexion.php';

// Verificar si se ha enviado algún dato por POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario de manera segura
    $idVacunas = isset($_POST['idVacunas']) ? $_POST['idVacunas'] : '';
    $enfermedad = isset($_POST['enfermedad']) ? $_POST['enfermedad'] : '';
    $sustanciaActiva = isset($_POST['sustanciaActiva']) ? $_POST['sustanciaActiva'] : '';
    $formula = isset($_POST['formula']) ? $_POST['formula'] : '';
    $laboratorio = isset($_POST['laboratorio']) ? $_POST['laboratorio'] : '';
    $gramaje = isset($_POST['gramaje']) ? $_POST['gramaje'] : '';
    $lote = isset($_POST['lote']) ? $_POST['lote'] : '';
    $dosis = isset($_POST['dosis']) ? $_POST['dosis'] : '';
    $fechaAplicacion = isset($_POST['fechaAplicacion']) ? $_POST['fechaAplicacion'] : '';
    $fechaCaducidad = isset($_POST['fechaCaducidad']) ? $_POST['fechaCaducidad'] : '';

    // Iniciar una transacción
    $conn->begin_transaction();

    try {
        // Preparar la consulta SQL para actualizar en la tabla Vacunas
        $sqlVacunas = "UPDATE Vacunas 
                       SET enfermedad = ?, sustanciaActiva = ?, formula = ?, laboratorio = ?, gramaje = ? 
                       WHERE idVacunas = ?";
        $stmtVacunas = $conn->prepare($sqlVacunas);
        $stmtVacunas->bind_param("ssssii", $enfermedad, $sustanciaActiva, $formula, $laboratorio, $gramaje, $idVacunas);

        // Ejecutar la sentencia
        if (!$stmtVacunas->execute()) {
            throw new Exception("Error al modificar los datos en Vacunas: " . $stmtVacunas->error);
        }

        // Preparar la consulta SQL para actualizar en la tabla detalleVacunas
        $sqlDetalleVacunas = "UPDATE detalleVacunas 
                              SET lote = ?, dosis = ?, fechaAplicacion = ?, fechaCaducidad = ? 
                              WHERE idVacunasDV = ?";
        $stmtDetalleVacunas = $conn->prepare($sqlDetalleVacunas);
        $stmtDetalleVacunas->bind_param("iissi", $lote, $dosis, $fechaAplicacion, $fechaCaducidad, $idVacunas);

        // Ejecutar la sentencia
        if (!$stmtDetalleVacunas->execute()) {
            throw new Exception("Error al modificar los datos en detalleVacunas: " . $stmtDetalleVacunas->error);
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
    $stmtVacunas->close();
    $stmtDetalleVacunas->close();
} else {
    // Si no se reciben datos por POST, devolver un mensaje de error
    echo json_encode(array("success" => false, "message" => "No se han recibido datos por POST"));
}
?>