<?php
header("Content-Type: text/plain");
// Datos de conexión a la base de datos
$servername = "localhost"; 
$username = "root"; 
$password = "1234"; 
$database = "consultorioS"; 
$status = 200;

// Crear conexión
$conn = new mysqli($servername, $username, $password, $database);

// Revisar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar si se recibieron los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Recuperar los datos del formulario
    $idEstudio = $_POST["idEstudio"];
    $nombreEstudio = $_POST["nombreEstudio"];
    $tipoEstudio = $_POST["tipoEstudio"];
    $descripcionEstudio = $_POST["descripcionEstudio"];
    $fechaEstudio = $_POST["fechaEstudio"];

    // Preparar la consulta SQL para actualizar los datos en la tabla 'Estudios' y 'detalleEstudios'
    $sql = "UPDATE Estudios AS e
            INNER JOIN detalleEstudios AS de 
            ON e.idEstudios = de.idEstudiosDE
            SET e.nombreEstudio = ?, e.tipoEstudio = ?, e.descripcionEstudio = ?,
                de.fechaEstudio = ?
            WHERE e.idEstudios = ?";

    // Preparar la sentencia
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // Vincular los parámetros a la consulta
        $stmt->bind_param("ssssi", $nombreEstudio, $tipoEstudio, $descripcionEstudio, $fechaEstudio, $idEstudio);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            echo "Registro modificado correctamente.";
            $status = 200;
        } else {
            echo "Error al modificar el registro: " . $stmt->error;
            $status = 500;
        }

        // Cerrar la sentencia
        $stmt->close();
    } else {
        echo "Error en la preparación de la consulta: " . $mysqli->error;
        $status = 500;
    }
} else {
    echo "Acceso denegado.";
    $status = 500;
}
// Cerrar la conexión
$conn->close();
http_response_code($status);
?>
