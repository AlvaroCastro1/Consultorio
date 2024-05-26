<?php
include('../includes/conexion.php');

// Validar que se reciben todos los datos necesarios
if (isset($_POST['idPaciente'], $_POST['fechaCita'], $_POST['horaCita'], $_POST['asistencia'])) {
    $idPaciente = $_POST['idPaciente'];
    $fechaCita = $_POST['fechaCita'];
    $horaCita = $_POST['horaCita'];
    $asistencia = $_POST['asistencia'];

    // Verificar que los datos recibidos son válidos antes de realizar la inserción
    if (!empty($idPaciente) && !empty($fechaCita) && !empty($horaCita) && !empty($asistencia)) {
        // Preparar la consulta utilizando consultas preparadas para prevenir ataques de inyección SQL
        $query = "INSERT INTO Cita (idPacienteC, fechaCita, horaCita, asistencia) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($query);

        // Asignar los valores a los parámetros de la consulta
        $stmt->bind_param("isss", $idPaciente, $fechaCita, $horaCita, $asistencia);

        // Ejecutar la consulta preparada
        if ($stmt->execute()) {
            // La inserción fue exitosa, realizar commit y mostrar mensaje de éxito
            $conn->commit();
            echo "La cita se agregó correctamente.";
        } else {
            // Si hay algún error en la ejecución de la consulta, realizar rollback y mostrar mensaje de error
            $conn->rollback();
            echo "Error al agregar la cita. Por favor, inténtalo de nuevo.";
        }

        // Cerrar la consulta preparada
        $stmt->close();
    } else {
        // Si alguno de los campos requeridos está vacío, mostrar mensaje de error
        echo "Todos los campos son obligatorios. Por favor, completa el formulario.";
    }
} else {
    // Si no se reciben todos los datos necesarios, mostrar mensaje de error
    echo "No se recibieron todos los datos necesarios para agregar la cita.";
}

// Cerrar la conexión a la base de datos
$conn->close();
?>

