<?php
include '../includes/conexion.php';


if (isset($_POST['idEstudio'])) {
    $idEstudio = $_POST['idEstudio'];
    
    $query = "SELECT * FROM Elementos 
              INNER JOIN detalleElemento ON Elementos.idElementos = detalleElemento.idElementosDElem
              WHERE detalleElemento.idEstudioDElem = ?";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $idEstudio);
    $stmt->execute();
    
    $result = $stmt->get_result();
    
    $elementos = array();
    while ($row = $result->fetch_assoc()) {
        $elementos[] = $row;
    }
    
    echo json_encode($elementos);
} else {
    echo 'No se recibió el idEstudio.';
}
?>
