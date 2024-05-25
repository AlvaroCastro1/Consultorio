<?php
include '../includes/conexion.php';

$data = json_decode(file_get_contents("php://input"));

if (isset($data->idElemento)) {
    $idElemento = $data->idElemento;
    
    // Eliminar el detalle del elemento en la tabla detalleElemento
    $queryEliminarDetalle = "DELETE FROM detalleElemento WHERE idElementosDElem = ?";
    $stmtEliminarDetalle = $conn->prepare($queryEliminarDetalle);
    $stmtEliminarDetalle->bind_param('i', $idElemento);
    $stmtEliminarDetalle->execute();

    // Eliminar el elemento en la tabla Elementos
    $queryEliminarElemento = "DELETE FROM Elementos WHERE idElementos = ?";
    $stmtEliminarElemento = $conn->prepare($queryEliminarElemento);
    $stmtEliminarElemento->bind_param('i', $idElemento);
    $stmtEliminarElemento->execute();

    echo json_encode(['message' => 'Elemento eliminado exitosamente.']);
} else {
    echo json_encode(['message' => 'ID de elemento no proporcionado.']);
}
?>
