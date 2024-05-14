<?php
// Incluir el archivo de conexión a la base de datos
require '../includes/conexion.php';

// Verificar si se ha enviado algún dato por POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario de manera segura
    $sustanciaActiva = isset($_POST['sustanciaActiva']) ? $_POST['sustanciaActiva'] : '';
    $enfermedad = isset($_POST['enfermedad']) ? $_POST['enfermedad'] : '';
    $formula =  isset($_POST['formula']) ? $_POST['formula'] : '';
    $laboratorio =  isset($_POST['laboratorio']) ? $_POST['laboratorio'] : '';
    $dosis = isset($_POST['dosis']) ? $_POST['dosis'] : '';
    $gramaje = isset($_POST['gramaje']) ? $_POST['gramaje'] : '';
    $lote = isset($_POST['lote']) ? $_POST['lote'] : '';
    $fechaCaducidad = isset($_POST['fechaCaducidad']) ? $_POST['fechaCaducidad'] : '';
    $idVacunas = isset($_POST['idVacunas']) ? $_POST['idVacunas'] : '';


    // Preparar la consulta SQL utilizando consultas preparadas
    $sql = "UPDATE Vacunas SET sustanciaActiva=?, enfermedad=?, formula=?, laboratorio=? , dosis=?, gramaje=?, lote=?, fechaCaducidad=?  WHERE idVacunas=?";

    // Preparar la sentencia
    $stmt = $conn->prepare($sql);

    // Vincular parámetros
    $stmt->bind_param("ssssiiisi", $sustanciaActiva, $enfermedad, $formula, $laboratorio, $dosis, $gramaje, $lote, $fechaCaducidad, $idVacunas); // Suponiendo que tienes un campo 'id' en tu formulario para identificar el registro a modificar

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