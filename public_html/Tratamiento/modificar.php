<?php
// Incluir el archivo de conexión a la base de datos
require '../includes/conexion.php';

// Verificar si se ha enviado algún dato por POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario de manera segura
    $idTratamiento = isset($_POST['idTratamiento']) ? $_POST['idTratamiento'] : '';
    $descripcionTratamiento = isset($_POST['descripcionTratamiento']) ? $_POST['descripcionTratamiento'] : '';
    $duracion = isset($_POST['duracion']) ? $_POST['duracion'] : '';
    $diagnostico = isset($_POST['diagnostico']) ? $_POST['diagnostico'] : '';
    $fechaTratamiento = isset($_POST['fechaTratamiento']) ? $_POST['fechaTratamiento'] : '';

    // Preparar la consulta SQL utilizando consultas preparadas
    $sql = "UPDATE Tratamiento SET descripcionTratamiento=?, duracion=?, diagnostico=?, fechaTratamiento=? WHERE idTratamiento=?";

    // Preparar la sentencia
    $stmt = $conn->prepare($sql);

    // Vincular parámetros
    $stmt->bind_param("ssssi", $descripcionTratamiento, $duracion, $diagnostico, $fechaTratamiento, $idTratamiento);

    // Ejecutar la sentencia
    if ($stmt->execute()) {
        echo json_encode(array("success" => true, "message" => "Datos modificados correctamente"));
    } else {
        echo json_encode(array("success" => false, "message" => "Error al modificar los datos: " . $conn->error));
    }

    // Cerrar la sentencia
    $stmt->close();
} else {
    // Si no se reciben datos por POST, devolver un mensaje de error
    echo json_encode(array("success" => false, "message" => "No se han recibido datos por POST"));
}

// Cerrar la conexión
$conn->close();
?>
