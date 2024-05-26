<?php
$servername = "localhost";
$username = "root";
$password = "1234";
$dbname = "consultorios";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if(isset($_POST['buscarCita'])) {
  $idCita = $_POST['idCita'];

  // BUSCAR (Leer)
  $sql = "SELECT * FROM Cita WHERE idCita=$idCita";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      echo "idCita: " . $row["idCita"]. ", idPacienteC: " . $row["idPacienteC"]. ", fechaCita: " . $row["fechaCita"]. ", horaCita: " . $row["horaCita"]. ", asistencia: " . $row["asistencia"]. "<br>";
    }
  } else {
    echo "No se encontró ninguna cita con ese ID";
  }
}

$conn->close();
?>
