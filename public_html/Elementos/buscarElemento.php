<?php
include '../includes/conexion.php';

if (isset($_GET['idEstudio'])) {
    $idEstudio = $_GET['idEstudio'];
    $nombre = isset($_GET['nombre']) ? '%' . $_GET['nombre'] . '%' : '%';
    
    $query = "SELECT e.nombreElemento, e.rango, de.valor, de.interpretacion 
              FROM Elementos e 
              JOIN detalleElemento de ON e.idElementos = de.idElementosDElem
              WHERE de.idEstudioDElem = ? AND e.nombreElemento LIKE ?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param('is', $idEstudio, $nombre);
    $stmt->execute();
    $result = $stmt->get_result();

    $elementos = [];
    while ($row = $result->fetch_assoc()) {
        $elementos[] = $row;
    }

    echo json_encode($elementos);
} else {
    echo json_encode([]);
}
?>
