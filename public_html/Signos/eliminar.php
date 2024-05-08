<?php
// Incluir el archivo de conexión a la base de datos
require '../includes/conexion.php';

// Verificar si se ha enviado algún dato por POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener el idSigno del formulario de manera segura
    $idSignos = isset($_POST['idSignos']) ? $_POST['idSignos'] : '';

    // Verificar si se proporcionó un idSigno válido

    // Preparar la consulta SQL para eliminar la fila con el idSigno proporcionado
    $sql = "DELETE FROM Signos WHERE idSignos = ?";

    // Preparar la sentencia
    $stmt = $conn->prepare($sql);

    // Vincular parámetros
    $stmt->bind_param("i", $idSignos);

    // Ejecutar la sentencia
    if ($stmt->execute()) {
        echo json_encode(array("success" => true, "message" => "La fila se eliminó correctamente"));
    } else {
        echo json_encode(array("success" => false, "message" => "Error al eliminar la fila: " . $conn->error));
    }

    // Cerrar la sentencia
    $stmt->close();

} else {
    // Si no se reciben datos por POST, devolver un mensaje de error
    echo json_encode(array("success" => false, "message" => "No se han recibido datos por POST"));
}
?>