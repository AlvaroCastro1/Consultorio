<?php
include '../includes/conexion.php';

// Obtener el idPaciente de la solicitud (suponiendo que se envía mediante GET o POST)
$idPaciente = $_REQUEST['idPaciente'];

// Consulta para obtener todas las citas de un paciente específico
$sql = "SELECT * FROM Cita WHERE idPacienteC = $idPaciente";
$result = $conn->query($sql);

$citas = array();

if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        $citas[] = $row;
    }
}

// Devolver las citas en formato JSON
echo json_encode($citas);

$conn->close();
