<?php
// Incluir el archivo de conexión a la base de datos
require '../includes/conexion.php';

// Verificar si se ha enviado algún dato por POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario de manera segura
    $idAntecedentes = isset($_POST['idAntecedentes']) ? intval($_POST['idAntecedentes']) : 0;
    $tipoAntecedente = isset($_POST['tipoAntecedente']) ? $_POST['tipoAntecedente'] : '';
    $nombrePadecimiento = isset($_POST['nombrePadecimiento']) ? $_POST['nombrePadecimiento'] : '';
    $descripcion = isset($_POST['descripcion']) ? $_POST['descripcion'] : '';

    // Verificar que el ID de Antecedentes sea válido
    if ($idAntecedentes == 0) {
        echo json_encode(array("success" => false, "message" => "No se ha proporcionado un idAntecedentes válido"));
        exit;
    }

    // Preparar la consulta SQL utilizando consultas preparadas
    $sql = "UPDATE Antecedentes SET tipoAntecedente = ?, nombrePadecimiento = ?, descripcion = ? WHERE idAntecedentes = ?";

    // Preparar la sentencia
    $stmt = $conn->prepare($sql);

    // Vincular parámetros
    $stmt->bind_param("sssi", $tipoAntecedente, $nombrePadecimiento, $descripcion, $idAntecedentes);

    // Ejecutar la sentencia
    if ($stmt->execute()) {
        echo json_encode(array("success" => true, "message" => "Datos modificados correctamente"));
    } else {
        echo json_encode(array("success" => false, "message" => "Error al modificar los datos: " . $stmt->error));
    }

    // Cerrar la sentencia
    $stmt->close();
} else {
    // Si no se reciben datos por POST, devolver un mensaje de error
    echo json_encode(array("success" => false, "message" => "No se han recibido datos por POST"));
}

?>
