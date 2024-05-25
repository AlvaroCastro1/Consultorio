<?php
include('../includes/conexion.php');

$idCita = $_POST['idCitaEliminar'];

$conn->begin_transaction();

$eliminarCita = mysqli_query($conn, "DELETE FROM Cita WHERE idCita = '$idCita'");

if (!$eliminarCita) {
    $conn->rollback();
    echo "<script>alert('Error al eliminar la cita. Rollback ejecutado.'); window.location='citas.php';</script>";
} else {
    $conn->commit();
    echo "<script>alert('Cita eliminada con éxito.'); window.location='citas.php';</script>";
}

$conn->close();
?>
