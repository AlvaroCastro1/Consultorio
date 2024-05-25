<?php
include '../includes/conexion.php';

if (isset($_GET['nombre'])) {
    $nombre = $_GET['nombre'];
    
    $query = "SELECT e.nombreElemento, e.rango, de.valor, de.interpretacion 
              FROM Elementos e 
              JOIN detalleElemento de ON e.idElementos = de.idElementosDElem
              WHERE e.nombreElemento LIKE ?";
    $stmt = $conn->prepare($query);
    $likeNombre = "%".$nombre."%";
    $stmt->bind_param('s', $likeNombre);
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
