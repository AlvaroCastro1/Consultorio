<?php
// Incluir el archivo de conexión a la base de datos
require '../includes/conexion.php';

// Verificar si se ha enviado algún dato por POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario de manera segura
    $idDetalleTratamiento = isset($_POST['idDetalleTratamiento']) ? $_POST['idDetalleTratamiento'] : '';
    $idTratamientoDT = isset($_POST['idTratamientoDT']) ? $_POST['idTratamientoDT'] : '';
    $descripcionTratamiento = isset($_POST['descripcionTratamiento']) ? $_POST['descripcionTratamiento'] : '';
    $duracion = isset($_POST['duracion']) ? $_POST['duracion'] : '';
    $fechaTratamiento = isset($_POST['fechaTratamiento']) ? $_POST['fechaTratamiento'] : '';


    // Preparar la consulta SQL utilizando consultas preparadas
    $sql = "UPDATE detalleTratamiento SET  idTratamientoDT=?, descripcionTratamiento=?, duracion=? WHERE idDetalleTratamiento=?";

    // Preparar la sentencia
    $stmt = $conn->prepare($sql);

    // Vincular parámetros
    $stmt->bind_param("issi", $idTratamientoDT, $descripcionTratamiento, $duracion, $idDetalleTratamiento); // Suponiendo que tienes un campo 'id' en tu formulario para identificar el registro a modificar

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
?>