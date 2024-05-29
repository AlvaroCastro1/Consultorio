<?php
// Incluir el archivo de conexión a la base de datos
include '../includes/conexion.php';

// Obtener el idPaciente de la solicitud (puede ser enviado mediante GET o POST)
$idPaciente = isset($_REQUEST['idPaciente']) ? $_REQUEST['idPaciente'] : null;

// Construir la consulta SQL utilizando consultas preparadas
if (is_null($idPaciente) || $idPaciente === '') {
    // Si no se proporciona idPaciente, seleccionar todas las citas
    $sql = "SELECT * FROM Cita";
    $stmt = $conn->prepare($sql);
} else {
    // Si se proporciona idPaciente, seleccionar solo las citas de ese paciente
    $sql = "SELECT * FROM Cita WHERE idPacienteC = ?";
    $stmt = $conn->prepare($sql);
    // Vincular el parámetro idPaciente a la consulta preparada
    $stmt->bind_param('i', $idPaciente);
}

// Ejecutar la consulta
$stmt->execute();
// Obtener el resultado de la consulta
$result = $stmt->get_result();

$citas = array();

if ($result->num_rows > 0) {
    // Recorrer los resultados y agregarlos al array $citas
    while($row = $result->fetch_assoc()) {
        $citas[] = $row;
    }
}

// Devolver las citas en formato JSON
echo json_encode($citas);

// Cerrar la declaración y la conexión a la base de datos
$stmt->close();
$conn->close();
?>
