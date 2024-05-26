<?php
// Incluir el archivo de conexión a la base de datos
require '../includes/conexion.php';

// Verificar si se ha enviado algún dato por POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario de manera segura
    $idExpedienteDV = isset($_POST['idExpedienteDV']) ? $_POST['idExpedienteDV'] : '';
    $enfermedad = isset($_POST['enfermedad']) ? $_POST['enfermedad'] : '';
    $sustanciaActiva = isset($_POST['sustanciaActiva']) ? $_POST['sustanciaActiva'] : '';
    $formula = isset($_POST['formula']) ? $_POST['formula'] : '';
    $laboratorio = isset($_POST['laboratorio']) ? $_POST['laboratorio'] : '';
    $gramaje = isset($_POST['gramaje']) ? $_POST['gramaje'] : '';
    $lote = isset($_POST['lote']) ? $_POST['lote'] : '';
    $dosis = isset($_POST['dosis']) ? $_POST['dosis'] : '';
    $fechaAplicacion = date("Y-m-d"); // Obtener la fecha actual en el formato AAAA-MM-DD
    $fechaCaducidad = isset($_POST['fechaCaducidad']) ? $_POST['fechaCaducidad'] : '';

 

    // Iniciar una transacción
    $conn->begin_transaction();

    try {
        // Preparar la consulta SQL para insertar en la tabla Vacunas
        $sqlVacunas = "INSERT INTO Vacunas (enfermedad, sustanciaActiva, formula, laboratorio, gramaje) VALUES (?, ?, ?, ?, ?)";

        // Preparar la sentencia
        $stmtVacunas = $conn->prepare($sqlVacunas);

        // Vincular parámetros
        $stmtVacunas->bind_param("ssssi", $enfermedad, $sustanciaActiva, $formula, $laboratorio, $gramaje);

        // Ejecutar la sentencia
        if (!$stmtVacunas->execute()) {
            throw new Exception("Error al guardar los datos en Vacunas: " . $stmtVacunas->error);
        }

        // Obtener el ID del nuevo registro en Vacunas
        $idVacunas = $conn->insert_id;

        // Preparar la consulta SQL para insertar en la tabla detalleVacunas
        $sqlDetalleVacunas = "INSERT INTO detalleVacunas (idExpedienteDV, idVacunasDV, lote, dosis, fechaAplicacion, fechaCaducidad) VALUES (?, ?, ?, ?, ?, ?)";

        // Preparar la sentencia
        $stmtDetalleVacunas = $conn->prepare($sqlDetalleVacunas);

        // Vincular parámetros
        $stmtDetalleVacunas->bind_param("iiiiss", $idExpedienteDV, $idVacunas, $lote, $dosis, $fechaAplicacion, $fechaCaducidad);

        // Ejecutar la sentencia
        if (!$stmtDetalleVacunas->execute()) {
            throw new Exception("Error al guardar los datos en detalleVacunas: " . $stmtDetalleVacunas->error);
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
    $stmtVacunas->close();
    $stmtDetalleVacunas->close();
} else {
    // Si no se reciben datos por POST, devolver un mensaje de error
    echo json_encode(array("success" => false, "message" => "No se han recibido datos por POST"));
}

// Cerrar la conexión
?>