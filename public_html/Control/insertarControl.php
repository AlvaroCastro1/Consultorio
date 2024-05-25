<?php
header("Content-Type: text/plain");
require_once "../includes/conexion.php";
$status = 200;

// Verificar si se recibió una solicitud de agregar estudio
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Obtener los valores del formulario
    $fechaControl = $_POST['fechaControl'];
    $altura = $_POST['altura'];
    $peso = $_POST['peso'];
    $indiceMasaCorporal = $_POST['indiceMasaCorporal'];
    $circunferenciaDelCraneo = $_POST['circunferenciaDelCraneo'];
    $evaluacion = $_POST['evaluacion'];

    // Consulta SQL para insertar un nuevo registro
    $sql = "INSERT INTO ControlCrecimiento (fechaControl, altura, peso, indiceMasaCorporal, circunferenciaDelCraneo, evaluacion) VALUES ('$fechaControl', $altura, $peso, $indiceMasaCorporal, $circunferenciaDelCraneo, '$evaluacion')";
    
    // Ejecutar la consulta para agregar el Control de estudio
    if ($conn->query($sql) === TRUE  ) {
        echo "Nuevo estudio agregado exitosamente.";
    } else {
        $status = 400;
        echo "Error al agregar el estudio: " . $conn->error;
    }

} else {
    $status = 405;
    echo "No se recibió una solicitud POST correctamente.";
}

// Cerrar conexión
$conn->close();
http_response_code($status);
?>
