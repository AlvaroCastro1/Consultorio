<?php
include '../includes/conexion.php';

// Verificar si los datos fueron enviados mediante POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos enviados por AJAX
    $fecha = $_POST['fecha'];
    $idPaciente = $_POST['idP'];

    // Validar y limpiar los datos antes de usarlos en la consulta
    $fecha = $conn->real_escape_string($fecha);
    $idPaciente = $conn->real_escape_string($idPaciente);

    // Consultar la base de datos
    $sql = "SELECT * FROM Cita WHERE fecha = '$fecha' AND idPacienteC = '$idPaciente'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $citas = [];
        while($row = $result->fetch_assoc()) {
            $citas[] = $row;
        }
        echo json_encode($citas);
    } else {
        echo json_encode([]);
    }
} else {
    echo json_encode(['error' => 'Solicitud inválida']);
}

$conn->close();
?>
