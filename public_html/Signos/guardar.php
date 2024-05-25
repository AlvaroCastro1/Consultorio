<?php
// Incluir el archivo de conexión a la base de datos
require '../includes/conexion.php';

// Verificar si se ha enviado algún dato por POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario de manera segura
    $temperatura = isset($_POST['temperatura']) ? $_POST['temperatura'] : '';
    $frecuenciaR = isset($_POST['frecuenciaR']) ? $_POST['frecuenciaR'] : '';
    $frecuenciaC = isset($_POST['frecuenciaC']) ? $_POST['frecuenciaC'] : '';
    $oxigenacion = isset($_POST['oxigenacion']) ? $_POST['oxigenacion'] : '';
    $presionArterial = isset($_POST['presionArterial']) ? $_POST['presionArterial'] : '';
    $edoHidratacion = isset($_POST['edoHidratacion']) ? $_POST['edoHidratacion'] : '';
    $edoConciencia = isset($_POST['edoConciencia']) ? $_POST['edoConciencia'] : '';
    $edoNeurologico = isset($_POST['edoNeurologico']) ? $_POST['edoNeurologico'] : '';
    $fechaSignos = isset($_POST['fechaSignos']) ? $_POST['fechaSignos'] : '';

    // Preparar la consulta SQL utilizando consultas preparadas
    $sql = "INSERT INTO Signos (temperatura, frecuenciaRespiratoria, frecuenciaCardiaca, oxigenacion, presionArterial, estadoHidratacion, estadoConciencia, estadoNeurologico, fechaActualizacion) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    // Preparar la sentencia
    $stmt = $conn->prepare($sql);

    // Vincular parámetros
    $stmt->bind_param("iiiiissss", $temperatura, $frecuenciaR, $frecuenciaC, $oxigenacion, $presionArterial, $edoHidratacion, $edoConciencia, $edoNeurologico, $fechaSignos);

    // Ejecutar la sentencia
    if ($stmt->execute()) {
        echo json_encode(array("success" => true, "message" => "Datos guardados correctamente"));
    } else {
        echo json_encode(array("success" => false, "message" => "Error al guardar los datos: " . $conn->error));
    }

    // Cerrar la sentencia
    $stmt->close();
} else {
    // Si no se reciben datos por POST, devolver un mensaje de error
    echo json_encode(array("success" => false, "message" => "No se han recibido datos por POST"));
}
?>
