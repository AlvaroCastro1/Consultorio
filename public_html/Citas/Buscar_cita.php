<?php

include '../includes/conexion.php';

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
