<?php
include '../includes/conexion.php';

if (
    isset($_POST['idDetalleProcedimiento']) && 
    isset($_POST['nombreProcedimiento']) && 
    isset($_POST['descripcionProcedimiento']) && 
    isset($_POST['observaciones']) && 
    isset($_POST['fechaProcedimiento'])
) {
    $idDetalleProcedimiento = $_POST['idDetalleProcedimiento'];
    $nombreProcedimiento = $_POST['nombreProcedimiento'];
    $descripcionProcedimiento = $_POST['descripcionProcedimiento'];
    $observaciones = $_POST['observaciones'];
    $fechaProcedimiento = $_POST['fechaProcedimiento'];

    // Primero, obtener el idProcedimiento relacionado
    $query = "SELECT idProcedimientoDP FROM detalleProcedimiento WHERE idDetalleProcedimiento = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $idDetalleProcedimiento);
    $stmt->execute();
    $stmt->bind_result($idProcedimiento);
    $stmt->fetch();
    $stmt->close();

    if ($idProcedimiento) {
        // Actualizar la tabla Procedimiento
        $query = "UPDATE Procedimiento 
                  SET nombreProceso = ?, descripcionProcedimiento = ? 
                  WHERE idProcedimiento = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssi", $nombreProcedimiento, $descripcionProcedimiento, $idProcedimiento);
        $stmt->execute();
        $affected_rows_procedimiento = $stmt->affected_rows;
        $stmt->close();

        // Actualizar la tabla detalleProcedimiento
        $query = "UPDATE detalleProcedimiento 
                  SET observaciones = ?, fechaProceso = ? 
                  WHERE idDetalleProcedimiento = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssi", $observaciones, $fechaProcedimiento, $idDetalleProcedimiento);
        $stmt->execute();
        $affected_rows_detalle = $stmt->affected_rows;

        if ($affected_rows_procedimiento > 0 || $affected_rows_detalle > 0) {
            echo json_encode(["success" => true]);
        } else {
            echo json_encode(["success" => false, "error" => "No se pudo modificar el procedimiento o no hubo cambios en los datos."]);
        }

        $stmt->close();
    } else {
        echo json_encode(["success" => false, "error" => "ID de procedimiento no encontrado."]);
    }
} else {
    echo json_encode(["success" => false, "error" => "Datos incompletos."]);
}

$conn->close();

?>
