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

if(isset($_POST['agregarRegistro'])) {
  $idPacienteC = $_POST['idPacienteC'];
  $fechaCita = $_POST['fechaCita'];
  $horaCita = $_POST['horaCita'];
  $asistencia = $_POST['asistencia'];

  // INSERTAR (Crear)
  $sql = "INSERT INTO Cita (idPacienteC, fechaCita, horaCita, asistencia)
  VALUES ('$idPacienteC', '$fechaCita', '$horaCita', '$asistencia')";

  if ($conn->query($sql) === TRUE) {
    echo "Nuevo registro creado exitosamente";
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
}

$conn->close();
?>
