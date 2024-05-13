<?php
include('../includes/conexion.php');

$nombreProcedimiento = $_POST['nombreProcedimientoInput'];
$descripcionProcedimiento = $_POST['descripcionProcedimientoInput'];
$observacionesProcedimiento = $_POST['observacionesProcedimientoInput'];
$fechaProcedimiento = $_POST['fechaProcedimientoInput'];


$conn->begin_transaction();

$insertarusu = mysqli_query($conn,"INSERT INTO procedimiento(idProcedimiento,nombreProceso,descripcionProcedimiento) values ('$nombreProcedimiento','$descripcionProcedimiento','$observacionesProcedimiento')");

if(!$insertarusu)
{
$conn->rollback();
echo "<script>alert('Correo duplicado, intenta con otro correo. Rollback ejecutado');window.location='procedimiento.php';</script>";	 
}
else
{
$conn->commit();
echo "<script> alert('Usuario registrado con exito: $nombre'); window.location='procedimiento.php' </script>";
}

?>

