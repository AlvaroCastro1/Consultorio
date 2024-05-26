<?php
include('../includes/conexion.php');

$idPaciente = $_POST['idPaciente'];
$fechaCita = $_POST['fechaCita'];
$horaCita = $_POST['horaCita'];
$asistencia = $_POST['asistencia'];

// Depuración: Imprimir el valor de asistencia y su longitud
echo "Valor de asistencia: $asistencia, Longitud: " . strlen($asistencia) . "<br>";

// Mapear las opciones de asistencia a los valores numéricos correspondientes
$asistencia = trim($asistencia); // Eliminar espacios en blanco alrededor de la cadena
switch ($asistencia) {
    case 'Asistió':
        $asistenciaValue = 1;
        break;
    case 'Pendiente':
        $asistenciaValue = 2;
        break;
    case 'No asistió':
        $asistenciaValue = 3;
        break;
    default:
        // En caso de que la opción de asistencia no coincida, mostrar un mensaje de error
        echo "La opción de asistencia proporcionada no es válida";
        exit;
}

if (empty($idPaciente) || empty($fechaCita) || empty($horaCita)) {
    echo "Todos los campos son obligatorios";
    exit;
}

$query = "INSERT INTO Cita (idPacienteC, fecha, hora, asistencia) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($query);

if (!$stmt) {
    echo "Error al preparar la consulta. Por favor inténtalo nuevamente";
    exit;
}

$stmt->bind_param("isss", $idPaciente, $fechaCita, $horaCita, $asistenciaValue);
$result = $stmt->execute();

if (!$result) {
    $conn->rollback();
    echo "Error al guardar la cita. Rollback ejecutado";
} else {
    $conn->commit();
    echo "Cita guardada exitosamente";
}

$stmt->close();
$conn->close();
?>
