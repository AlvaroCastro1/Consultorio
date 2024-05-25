<?php
include '../includes/conexion.php';

header('Content-Type: application/json');

// Verifica si se han enviado los datos mediante POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tipo = $_POST['tipo'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $fecha = $_POST['fecha'];
    $elementos = $_POST['elementos'];
    $idExpedienteDE = $_POST['idExpediente'];

    // Inserta el estudio en la tabla Estudios
    $stmt = $conn->prepare('INSERT INTO Estudios (nombreEstudio, tipoEstudio, descripcionEstudio) VALUES (?, ?, ?)');
    $stmt->bind_param('sss', $nombre, $tipo, $descripcion);
    $stmt->execute();
    $idEstudio = $stmt->insert_id;
    $stmt->close();

    // Inserta el detalle del estudio en la tabla detalleEstudios
    $stmt = $conn->prepare('INSERT INTO detalleEstudios (idEstudiosDE, idExpedienteDE, fechaEstudio) VALUES (?, ?, ?)');
    
    $stmt->bind_param('iis', $idEstudio, $idExpedienteDE, $fecha);
    $stmt->execute();
    $idDetalleEstudio = $stmt->insert_id;
    $stmt->close();

    // Inserta los elementos en las tablas Elementos y detalleElemento
    foreach ($elementos as $elemento) {
        $stmt = $conn->prepare('INSERT INTO Elementos (nombreElemento, rango) VALUES (?, ?) ON DUPLICATE KEY UPDATE idElementos=LAST_INSERT_ID(idElementos)');
        $stmt->bind_param('ss', $elemento['nombre'], $elemento['rango']);
        $stmt->execute();
        $idElemento = $stmt->insert_id;
        $stmt->close();

        $stmt = $conn->prepare('INSERT INTO detalleElemento (idEstudioDElem, idElementosDElem, valor, interpretacion) VALUES (?, ?, ?, ?)');
        $stmt->bind_param('iids', $idEstudio, $idElemento, $elemento['valor'], $elemento['interpretacion']);
        $stmt->execute();
        $stmt->close();
    }

    http_response_code(200);
    echo json_encode(['message' => 'Estudio guardado exitosamente.']);
    $conn->close();
} else {
    http_response_code(400);
    echo json_encode(['error' => 'Método no soportado']);
}
?>
