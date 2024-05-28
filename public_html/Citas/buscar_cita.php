<?php
include '../includes/conexion.php';

// Verificar si los datos fueron enviados mediante POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos enviados por AJAX
    $fecha = isset($_POST['fecha']) ? $_POST['fecha'] : null;
    $idPaciente = isset($_POST['idP']) ? $_POST['idP'] : null;

    // Verificar que la fecha no sea nula
    if (is_null($fecha)) {
        echo json_encode(['error' => 'Fecha no especificada']);
        exit;
    }

    // Consultar la base de datos
    if (is_null($idPaciente) || $idPaciente === '') {
        // Si idPaciente es null o está vacío, devolver todas las citas de la fecha específica
        $sql = "SELECT * FROM Cita WHERE fecha = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $fecha);
    } else {
        // Si idPaciente no es null, devolver las citas para la fecha e idPaciente específicos
        $sql = "SELECT * FROM Cita WHERE fecha = ? AND idPacienteC = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('si', $fecha, $idPaciente);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $citas = [];
        while ($row = $result->fetch_assoc()) {
            $citas[] = $row;
        }
        echo json_encode($citas);
    } else {
        echo json_encode([]);
    }

    $stmt->close();
} else {
    echo json_encode(['error' => 'Solicitud inválida']);
}

$conn->close();
?>
