<?php
include '../includes/conexion.php';

$response = [];

try {
    if (isset($_POST['nombreElemento'], $_POST['rango'], $_POST['valor'], $_POST['interpretacion'], $_POST['idEstudio'])) {
        $nombreElemento = $_POST['nombreElemento'];
        $rango = $_POST['rango'];
        $valor = $_POST['valor'];
        $interpretacion = $_POST['interpretacion'];
        $idEstudio = $_POST['idEstudio'];

        // Inserta el elemento en la tabla Elementos
        $queryElemento = "INSERT INTO Elementos (nombreElemento, rango) VALUES (?, ?)";
        if ($stmtElemento = $conn->prepare($queryElemento)) {
            $stmtElemento->bind_param('ss', $nombreElemento, $rango);
            if (!$stmtElemento->execute()) {
                throw new Exception("Error al insertar en la tabla Elementos: " . $stmtElemento->error);
            }
            $idElemento = $stmtElemento->insert_id;
        } else {
            throw new Exception("Error al preparar la consulta para la tabla Elementos: " . $conn->error);
        }

        // Inserta el detalle del elemento en la tabla detalleElemento
        $queryDetalleElemento = "INSERT INTO detalleElemento (idEstudioDElem, idElementosDElem, valor, interpretacion) VALUES (?, ?, ?, ?)";
        if ($stmtDetalleElemento = $conn->prepare($queryDetalleElemento)) {
            $stmtDetalleElemento->bind_param('iids', $idEstudio, $idElemento, $valor, $interpretacion);
            if (!$stmtDetalleElemento->execute()) {
                throw new Exception("Error al insertar en la tabla detalleElemento: " . $stmtDetalleElemento->error);
            }
        } else {
            throw new Exception("Error al preparar la consulta para la tabla detalleElemento: " . $conn->error);
        }

        $response['message'] = 'Elemento guardado exitosamente.';
    } else {
        $response['message'] = 'Faltan datos en la solicitud.';
    }
} catch (Exception $e) {
    $response['error'] = $e->getMessage();
}

echo json_encode($response);
?>
