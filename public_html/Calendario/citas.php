<?php
include '../includes/conexion.php';

// Obtener las citas de la base de datos
$sql = "SELECT * FROM Cita";
$result = $conn->query($sql);

// Formatear los datos de las citas
$events = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      $event = [
        'title' => 'Cita con Paciente #' . $row['idPacienteC'],
        'idPaciente'=> $row['idPacienteC'],
        'fechaCita'=> $row['fecha'],
        'horaCita'=> $row['hora'],
        'asistenciaCita'=> $row['asistencia'],
        'idCita'=> $row['idCita'],
        'start' => $row['fecha'] . 'T' . $row['hora'],
        'allDay' => false
      ];
        array_push($events, $event);
    }
}

// Obtener los recuentos de citas por día
$sql = "SELECT fecha, COUNT(*) as count FROM Cita GROUP BY fecha";
$result = $conn->query($sql);

// Formatear los datos de los recuentos de citas
$counts = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $count = [
            'date' => $row['fecha'],
            'count' => $row['count']
        ];
        array_push($counts, $count);
    }
}

$conn->close();
?>
<?php
      date_default_timezone_set('America/Mexico_City'); // Establece la zona horaria a México

      $fecha_actual = date("Y-m-d");

            // Leer las horas de inicio y fin desde el archivo
      $lines = file('horarios.txt', FILE_IGNORE_NEW_LINES);
      $hora_inicio = $lines[0];
      $hora_fin = $lines[1];
      $dif=$hora_fin-$hora_inicio;
      $mitadHoras = floor(floor($dif / 0.5)/2);

?>
<script>
  var events = <?php echo json_encode($events); ?>;
  var counts = <?php echo json_encode($counts); ?>;
  var fecha_actual = '<?php echo $fecha_actual; ?>';
  var horasTotales = <?php echo $dif; ?>;
  var mitadTotales = '<?php echo $mitadHoras; ?>';
  
</script>