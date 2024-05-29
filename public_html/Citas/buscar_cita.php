<?php
include '../includes/conexion.php';

/**
 * Script para buscar citas en la base de datos.
 * 
 * Este script recibe datos mediante una petición POST, realiza una consulta en la base de datos
 * según los parámetros recibidos, y devuelve los resultados en formato JSON.
 */

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

    // Ejecutar la consulta
    $stmt->execute();
    $result = $stmt->get_result();

    // Verificar si se encontraron citas
    if ($result->num_rows > 0) {
        $citas = [];
        // Recorrer los resultados y almacenarlos en un array
        while ($row = $result->fetch_assoc()) {
            $citas[] = $row;
        }
        // Devolver las citas en formato JSON
        echo json_encode($citas);
    } else {
        // Devolver un array vacío si no se encontraron citas
        echo json_encode([]);
    }

    // Cerrar la declaración
    $stmt->close();
} else {
    // Devolver un error si la solicitud no es POST
    echo json_encode(['error' => 'Solicitud inválida']);
}

// Cerrar la conexión a la base de datos
$conn->close();
?>
