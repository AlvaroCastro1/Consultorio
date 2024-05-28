<?php
include '../includes/conexion.php';

// Obtener el idPaciente de la solicitud (suponiendo que se envía mediante GET o POST)
$idPaciente = isset($_REQUEST['idPaciente']) ? $_REQUEST['idPaciente'] : null;

// Construir la consulta SQL utilizando consultas preparadas
if (is_null($idPaciente) || $idPaciente === '') {
    $sql = "SELECT * FROM Cita";
    $stmt = $conn->prepare($sql);
} else {
    $sql = "SELECT * FROM Cita WHERE idPacienteC = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $idPaciente);
}


$stmt->execute();
$result = $stmt->get_result();

$citas = array();

if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        $citas[] = $row;
    }
}

// Devolver las citas en formato JSON
echo json_encode($citas);

$stmt->close();
$conn->close();
?>
