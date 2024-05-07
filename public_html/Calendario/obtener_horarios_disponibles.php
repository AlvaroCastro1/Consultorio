<?php
include '../includes/conexion.php';
include '../includes/normalizarHoras.php';

// Obtener la fecha seleccionada y el horario extra, si se proporcionó
$selectedDate = $_POST['date'];
$extraTime = isset($_POST['horarioExtra']) ? $_POST['horarioExtra'] : null;
$currentDate = isset($_POST['fechaActual']) ? $_POST['fechaActual'] : null;

// Si date y la fecha actual no son iguales, no agregar el horario extra
if ($selectedDate !== $currentDate) {
    $extraTime = null;
}

// Obtener todas las citas para la fecha seleccionada
$sql = "SELECT hora FROM Cita WHERE fecha = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $selectedDate);
$stmt->execute();
$result = $stmt->get_result();

$horarios = json_decode(file_get_contents('../configuracion/config/configurations.json'), true);
$hora_inicio = floatval($horarios['startTime']);
$hora_fin = floatval($horarios['endTime']);

// Crear un array de todos los horarios posibles
$horarios = [];
for ($i = $hora_inicio; $i != $hora_fin; $i += 0.5) {
    if ($i >= 24.0) {
        $i -= 24.0;
    }
    $hora = floor($i);
    $minuto = ($i - $hora) * 60;
    $horarios[] = sprintf('%02d:%02d', $hora, $minuto);
}

// Si se proporcionó un horario extra, agregarlo a la lista de horarios disponibles
if ($extraTime !== null) {
    $horarios[] = $extraTime;
}

// Función para normalizar las horas


// Eliminar los horarios que ya están reservados
while ($row = $result->fetch_assoc()) {
    $normalized_hour = normalize_hour($row['hora']);
    $index = array_search($normalized_hour, $horarios);
    if ($index !== false) {
        unset($horarios[$index]);
    }
}

// Ordenar los horarios restantes
sort($horarios);

// Devolver los horarios disponibles como una respuesta JSON
echo json_encode(['horarios' => array_values($horarios)]);

$conn->close();
?>
