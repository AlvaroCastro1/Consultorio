<?php
include('../includes/conexion.php');

$idProcedimiento = $_POST['idProcedimientoEliminar'];

$conn->begin_transaction();

$eliminarProcedimiento = mysqli_query($conn, "DELETE FROM procedimiento WHERE idProcedimiento = '$idProcedimiento'");

if (!$eliminarProcedimiento) {
    $conn->rollback();
    echo "<script>alert('Error al eliminar el procedimiento. Rollback ejecutado.'); window.location='procedimiento.php';</script>";
} else {
    $conn->commit();
    echo "<script>alert('Procedimiento eliminado con éxito.'); window.location='procedimiento.php';</script>";
}

?>
