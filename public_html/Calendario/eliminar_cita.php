<?php
include '../includes/conexion.php';

// Configurar el encabezado para que el contenido devuelto sea JSON
header('Content-Type: application/json');

// Verificar si se recibió el ID de la cita a eliminar
if (isset($_POST['id'])) {
    $idCita = $_POST['id'];

    // Preparar la consulta SQL para eliminar la cita
    $sql = "DELETE FROM Cita WHERE idCita = $idCita";

    // Ejecutar la consulta
    if ($conn->query($sql) === TRUE) {
        echo json_encode(['success' => true, 'message' => 'La cita ha sido eliminada exitosamente']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al eliminar la cita: ' . $conn->error]);
    }

    // Cerrar la conexión
    $conn->close();
} else {
    echo json_encode(['success' => false, 'message' => 'ID de cita no proporcionado']);
}
?>
