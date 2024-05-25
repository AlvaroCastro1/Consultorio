<?php
// Incluir el archivo de conexión a la base de datos
require '../includes/conexion.php';

// Verificar si se ha enviado algún dato por POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener el idTratamiento del formulario de manera segura
    $idTratamiento = isset($_POST['idTratamiento']) ? $_POST['idTratamiento'] : '';



    // Preparar la consulta SQL para eliminar la fila con el idTratamiento proporcionado
    $sql = "DELETE FROM Tratamiento WHERE idTratamiento = ?";

    // Preparar la sentencia
    $stmt = $conn->prepare($sql);

    // Vincular parámetros
    $stmt->bind_param("i", $idTratamiento);

    // Ejecutar la sentencia
    if ($stmt->execute()) {
        echo json_encode(array("success" => true, "message" => "El registro se eliminó correctamente"));
    } else {
        echo json_encode(array("success" => false, "message" => "Error al eliminar el registro: " . $conn->error));
    }

    // Cerrar la sentencia
    $stmt->close();
} else {
    // Si no se reciben datos por POST, devolver un mensaje de error
    echo json_encode(array("success" => false, "message" => "No se han recibido datos por POST"));
}
?>
