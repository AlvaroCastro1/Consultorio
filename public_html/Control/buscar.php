<?php
// Incluir el archivo de conexión a la base de datos
require '../includes/conexion.php';

// Obtener el idExpedienteDC del POST
$idExpedienteDC = isset($_POST['idExpedienteDC']) ? intval($_POST['idExpedienteDC']) : 0;

if ($idExpedienteDC == 0) {
    echo json_encode('<tr><td colspan="10">No se ha proporcionado un idExpedienteDC válido</td></tr>', JSON_UNESCAPED_UNICODE);
    exit;
}

$columns = [
    'ControlCrecimiento.idControlC', 
    'ControlCrecimiento.fechaControl', 
    'ControlCrecimiento.altura', 
    'ControlCrecimiento.peso', 
    'ControlCrecimiento.indiceMasaCorporal', 
    'ControlCrecimiento.circunferenciaDelCraneo', 
    'ControlCrecimiento.evaluacion'
];
$columnsABuscar = ['ControlCrecimiento.fechaControl'];

$table = "ControlCrecimiento";
$detalleTable = "detalleControlCrecimiento";
$campo = isset($_POST['input-busqueda']) ? $conn->real_escape_string($_POST['input-busqueda']) : null;

$where = "WHERE $detalleTable.idExpedienteDC = $idExpedienteDC";

if ($campo != null) {
    $where .= " AND (";

    $cont = count($columnsABuscar);

    for ($i = 0; $i < $cont; $i++) {
        $where .= $columnsABuscar[$i] . " LIKE '%" . $campo . "%' OR ";
    }
    $where = substr_replace($where, "", -3);

    $where .= ")";
}

$sql = "SELECT " . implode(", ", $columns) . " 
        FROM $table 
        INNER JOIN $detalleTable ON $table.idControlC = $detalleTable.idControlCDC 
        $where";
        
$resultado = $conn->query($sql);
$html = '';

if ($resultado) {
    if ($resultado->num_rows > 0) {
        while ($row = $resultado->fetch_assoc()) {
            $html .= '<tr>';
            $html .= '<td>' . $row['idControlC'] . '</td>';
            $html .= '<td>' . $row['altura'] . '</td>';
            $html .= '<td>' . $row['peso'] . '</td>';
            $html .= '<td>' . $row['indiceMasaCorporal'] . '</td>';
            $html .= '<td>' . $row['circunferenciaDelCraneo'] . '</td>';
            $html .= '<td>' . $row['evaluacion'] . '</td>';
            $html .= '<td>' . $row['fechaControl'] . '</td>';
            $html .= '<td>
            <button type="button" class="btn btn-danger me-2" onclick="eliminarFila(this)">Eliminar</button>
            <button type="button" class="btn btn-primary" onclick="modificarControl(this)">Modificar</button>
            </td>';
            $html .= '</tr>';
        }
    } else {
        $html .= '<tr>';
        $html .= '<td colspan="10">No se encontraron resultados</td>';
        $html .= '</tr>';
    }
} else {
    $html .= '<tr>';
    $html .= '<td colspan="10">Error al ejecutar la consulta</td>';
    $html .= '</tr>';
}

echo json_encode($html, JSON_UNESCAPED_UNICODE);
?>


