<?php
include '../includes/conexion.php';

// Obtener la fecha seleccionada y el horario extra, si se proporcionó
$selectedDate = $_POST['date'];
$extraTime = isset($_POST['horarioExtra']) ? $_POST['horarioExtra'] : null;

// Obtener todas las citas para la fecha seleccionada
$sql = "SELECT hora FROM Cita WHERE fecha = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $selectedDate);
$stmt->execute();
$result = $stmt->get_result();

// Leer las horas de inicio y fin desde el archivo
$lines = file('horarios.txt', FILE_IGNORE_NEW_LINES);
$hora_inicio = $lines[0];
$hora_fin = $lines[1];

// Crear un array de todos los horarios posibles
$horarios = [];
for ($i = $hora_inicio; $i <= $hora_fin; $i += 0.5) {
    $hora = floor($i);
    $minuto = ($i - $hora) * 60;
    $horarios[] = sprintf('%02d:%02d', $hora, $minuto);
}

// Si se proporcionó un horario extra, agregarlo a la lista de horarios disponibles
if ($extraTime !== null) {
    $horarios[] = $extraTime;
}

// Función para normalizar las horas
function normalize_hour($hour) {
    $parts = explode(':', $hour);
    return sprintf('%02d:%02d', $parts[0], $parts[1]);
}

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