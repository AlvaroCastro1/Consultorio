<?php
header("Content-Type: text/plain");
// Datos de conexión a la base de datos
require_once "../includes/conexion.php";
$status = 200;



// Verificar si se recibió una solicitud de agregar estudio
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Obtener los valores del formulario
    $nombreEstudio = $_POST["nombreEstudio"];
    $tipoEstudio = $_POST["tipoEstudio"];
    $descripcionEstudio = $_POST["descripcionEstudio"];
    $fechaEstudio = $_POST["fechaEstudio"];
    $idExpediente = $_POST["idExpediente"];
    
    // Preparar la consulta SQL para agregar el detalle del estudio con la fecha
    $sql = "INSERT INTO Estudios (nombreEstudio, tipoEstudio, descripcionEstudio) VALUES ('$nombreEstudio', '$tipoEstudio', '$descripcionEstudio')";
    

    // Ejecutar la consulta para agregar el estudio
    if ($conn->query($sql) === TRUE  ) {
        $idEstudio = $conn->insert_id;
        
        $sql2 = "INSERT INTO detalleEstudios (idExpedienteDE, idEstudiosDE , fechaEstudio) VALUES ('$idExpediente','$idEstudio','$fechaEstudio')"; 
        if($conn->query($sql2) === TRUE){
            echo "Nuevo estudio agregado exitosamente.";
        }
        else{
            $status = 400;
            echo "Estudio insertado pero fecha no insertada";
        }
    } else {
        $status = 400;
        echo "Error al agregar el estudio: " . $conn->error;
    }

} else {
    $status = 405;
    echo "No se recibió una solicitud POST correctamente.";
}

// Cerrar la conexión
$conn->close();
http_response_code($status);
?>

