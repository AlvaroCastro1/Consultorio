<?php
// Incluir el archivo de conexión a la base de datos
require '../includes/conexion.php';

// Obtener el idExpedienteDS del POST
$idExpedienteDS = isset($_POST['idExpedienteDS']) ? intval($_POST['idExpedienteDS']) : 0;

if ($idExpedienteDS == 0) {
    echo json_encode('<tr><td colspan="10">No se ha proporcionado un idExpedienteDS válido</td></tr>', JSON_UNESCAPED_UNICODE);
    exit;
}

$columns = ['Signos.idSignos', 'Signos.temperatura', 'Signos.frecuenciaRespiratoria', 'Signos.frecuenciaCardiaca', 'Signos.oxigenacion', 'Signos.presionArterial', 'Signos.estadoHidratacion', 'Signos.estadoConciencia', 'Signos.estadoNeurologico', 'Signos.fechaActualizacion'];
$columnsABuscar = ['Signos.fechaActualizacion'];

$table = "Signos";
$detalleTable = "detalleSignos";
$campo = isset($_POST['input-busqueda']) ? $conn->real_escape_string($_POST['input-busqueda']) : null;

$where = "WHERE $detalleTable.idExpedienteDS = $idExpedienteDS";

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
        INNER JOIN $detalleTable ON $table.idSignos = $detalleTable.idSignosDS 
        $where";
        
$resultado = $conn->query($sql);
$html = '';

if ($resultado) {
    if ($resultado->num_rows > 0) {
        while ($row = $resultado->fetch_assoc()) {
            $html .= '<tr>';
            $html .= '<td>' . $row['idSignos'] . '</td>';
            $html .= '<td>' . $row['temperatura'] . '</td>';
            $html .= '<td>' . $row['frecuenciaRespiratoria'] . '</td>';
            $html .= '<td>' . $row['frecuenciaCardiaca'] . '</td>';
            $html .= '<td>' . $row['oxigenacion'] . '</td>';
            $html .= '<td>' . $row['presionArterial'] . '</td>';
            $html .= '<td>' . $row['estadoHidratacion'] . '</td>';
            $html .= '<td>' . $row['estadoConciencia'] . '</td>';
            $html .= '<td>' . $row['estadoNeurologico'] . '</td>';
            $html .= '<td>' . $row['fechaActualizacion'] . '</td>';
            $html .= '<td>
            <button type="button" class="btn btn-danger me-2" onclick="eliminarFila(this)">Eliminar</button>
            <button type="button" class="btn btn-primary" onclick="modificarSignos(this)">Modificar</button>
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

