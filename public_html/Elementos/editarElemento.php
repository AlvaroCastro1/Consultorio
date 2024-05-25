<?php
include '../includes/conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica si se han recibido los datos necesarios
    if (isset($_POST['idElemento'], $_POST['nombreElemento'], $_POST['rango'], $_POST['valor'], $_POST['interpretacion'], $_POST['idEstudio'])) {
        $idElemento = $_POST['idElemento'];
        $nombreElemento = $_POST['nombreElemento'];
        $rango = $_POST['rango'];
        $valor = $_POST['valor'];
        $interpretacion = $_POST['interpretacion'];
        $idEstudio = $_POST['idEstudio'];

        // Actualiza el elemento en la tabla Elementos y detalleElemento utilizando un INNER JOIN
        $query = "UPDATE Elementos
                  INNER JOIN detalleElemento ON Elementos.idElementos = detalleElemento.idElementosDElem
                  SET Elementos.nombreElemento = ?, Elementos.rango = ?, detalleElemento.valor = ?, detalleElemento.interpretacion = ?
                  WHERE Elementos.idElementos = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('ssdsi', $nombreElemento, $rango, $valor, $interpretacion, $idElemento);
        $stmt->execute();

        echo json_encode(['message' => 'Elemento actualizado exitosamente.']);
    } else {
        echo json_encode(['message' => 'Faltan datos para actualizar el elemento.']);
    }
} else {
    echo json_encode(['message' => 'Método de solicitud no válido.']);
}
?>
