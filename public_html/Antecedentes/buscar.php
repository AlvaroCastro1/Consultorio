<?php
// Incluir el archivo de conexión a la base de datos
require '../includes/conexion.php';

// Obtener los parámetros del POST
$idExpedienteDA = isset($_POST['idExpedienteDA']) ? intval($_POST['idExpedienteDA']) : 0;
$tipoAntecedente = isset($_POST['tipoAntecedente']) ? $_POST['tipoAntecedente'] : '';

if ($idExpedienteDA == 0) {
    echo json_encode('<tr><td colspan="4">No se ha proporcionado un idExpedienteDA válido</td></tr>', JSON_UNESCAPED_UNICODE);
    exit;
}

$columns = ['Antecedentes.idAntecedentes', 'Antecedentes.tipoAntecedente', 'Antecedentes.nombrePadecimiento', 'Antecedentes.descripcion'];
$columnsABuscar = ['Antecedentes.tipoAntecedente', 'Antecedentes.nombrePadecimiento'];

$table = "Antecedentes";
$detalleTable = "detalleAntecedentes";

$where = "WHERE $detalleTable.idExpedienteDA = $idExpedienteDA";

if ($tipoAntecedente != '') {
    $where .= " AND Antecedentes.tipoAntecedente LIKE '%" . $tipoAntecedente . "%'";
}

$sql = "SELECT " . implode(", ", $columns) . " 
        FROM $table 
        INNER JOIN $detalleTable ON $table.idAntecedentes = $detalleTable.idAntecedentesDA 
        $where";
        
$resultado = $conn->query($sql);
$html = '';

if ($resultado) {
    if ($resultado->num_rows > 0) {
        while ($row = $resultado->fetch_assoc()) {
            $html .= '<tr>';
            $html .= '<td>' . $row['idAntecedentes'] . '</td>';
            $html .= '<td>' . $row['tipoAntecedente'] . '</td>';
            $html .= '<td>' . $row['nombrePadecimiento'] . '</td>';
            $html .= '<td>' . $row['descripcion'] . '</td>';
            $html .= '<td>
            <button type="button" class="btn btn-danger me-2" onclick="eliminarFila(this)">Eliminar</button>
            <button type="button" class="btn btn-primary" onclick="modificarAntecedente(this)">Modificar</button>
            </td>';
            $html .= '</tr>';
        }
    } else {
        $html .= '<tr>';
        $html .= '<td colspan="5">No se encontraron resultados</td>';
        $html .= '</tr>';
    }
} else {
    $html .= '<tr>';
    $html .= '<td colspan="5">Error al ejecutar la consulta</td>';
    $html .= '</tr>';
}

echo json_encode($html, JSON_UNESCAPED_UNICODE);
?>