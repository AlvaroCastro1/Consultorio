<?php
require '../includes/conexion.php';
    // Verificar si se están enviando datos por POST
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Obtener los datos del formulario
        $sustanciaActiva = isset($_POST['sustanciaActiva']) ? $_POST['sustanciaActiva'] : '';
        $enfermedad = isset($_POST['enfermedad']) ? $_POST['enfermedad'] : '';
        $formula = isset($_POST['formula']) ? $_POST['formula'] : '';
        $laboratorio = isset($_POST['laboratorio']) ? $_POST['laboratorio'] : '';
        $dosis = isset($_POST['dosis']) ? $_POST['dosis'] : '';
        $gramaje = isset($_POST['gramaje']) ? $_POST['gramaje'] : '';
        $lote = isset($_POST['lote']) ? $_POST['lote'] : '';
        $fechaCaducidad = isset($_POST['fechaCaducidad']) ? $_POST['fechaCaducidad'] : '';
        
        // Preparar la consulta SQL para insertar los datos en la tabla de Vacunas
        $sql = "INSERT INTO Vacunas (sustanciaActiva, enfermedad, formula, laboratorio, dosis, gramaje, lote, fechaCaducidad) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssiiis", $sustanciaActiva, $enfermedad, $formula, $laboratorio, $dosis, $gramaje, $lote, $fechaCaducidad);
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
    