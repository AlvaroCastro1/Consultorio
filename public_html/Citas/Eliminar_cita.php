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

if(isset($_POST['eliminarCita'])) {
  $idCita = $_POST['idCita'];

  // ELIMINAR (Eliminar)
  $sql = "DELETE FROM Cita WHERE idCita=$idCita";

  if ($conn->query($sql) === TRUE) {
    echo "Registro eliminado exitosamente";
  } else {
    echo "Error eliminando registro: " . $conn->error;
  }
}

$conn->close();
?>
