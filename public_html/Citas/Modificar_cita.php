<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "consultorios";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if(isset($_POST['modificarCita'])) {
  $idCita = $_POST['idCita'];
  $idPacienteC = $_POST['idPacienteC'];
  $fechaCita = $_POST['fechaCita'];
  $horaCita = $_POST['horaCita'];
  $asistencia = $_POST['asistencia'];

  // ACTUALIZAR (Modificar)
  $sql = "UPDATE Cita SET idPacienteC='$idPacienteC', fechaCita='$fechaCita', horaCita='$horaCita', asistencia='$asistencia' WHERE idCita=$idCita";

  if ($conn->query($sql) === TRUE) {
    echo "Registro actualizado exitosamente";
  } else {
    echo "Error actualizando registro: " . $conn->error;
  }
}

$conn->close();
?>
