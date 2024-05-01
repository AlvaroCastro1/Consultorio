<?php
include '../includes/conexion.php';

// Verificar si se recibió el ID de la cita a eliminar
if (isset($_POST['id'])) {
    $idCita = $_POST['id'];

    // Preparar la consulta SQL para eliminar la cita
    $sql = "DELETE FROM Cita WHERE idCita = $idCita";

    // Ejecutar la consulta
    if ($conn->query($sql) === TRUE) {
        echo "La cita ha sido eliminada exitosamente";
    } else {
        echo "Error al eliminar la cita: " . $conn->error;
    }

    // Cerrar la conexión
    $conn->close();
} else {
    echo "ID de cita no proporcionado";
}
?>
