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
    $idSignos = isset($_POST['idSignos']) ? $_POST['idSignos'] : '';


    // Preparar la consulta SQL utilizando consultas preparadas
    $sql = "UPDATE Signos SET  temperatura=?, frecuenciaRespiratoria=?, frecuenciaCardiaca=?, oxigenacion=?, presionArterial=?, estadoHidratacion=?, estadoConciencia=?, estadoNeurologico=? , fechaActualizacion=? WHERE idSignos=?";

    // Preparar la sentencia
    $stmt = $conn->prepare($sql);

    // Vincular parámetros
    $stmt->bind_param("iiiiissssi", $temperatura, $frecuenciaR, $frecuenciaC, $oxigenacion, $presionArterial, $edoHidratacion, $edoConciencia, $edoNeurologico,$fechaSignos, $idSignos); // Suponiendo que tienes un campo 'id' en tu formulario para identificar el registro a modificar

    // Ejecutar la sentencia
    if ($stmt->execute()) {
        echo json_encode(array("success" => true, "message" => "Datos modificados correctamente"));
    } else {
        echo json_encode(array("success" => false, "message" => "Error al modificar los datos: " . $conn->error));
    }

    // Cerrar la sentencia
    $stmt->close();
} else {
    // Si no se reciben datos por POST, devolver un mensaje de error
    echo json_encode(array("success" => false, "message" => "No se han recibido datos por POST"));
}
?>