<?php
// Incluir el archivo de conexión a la base de datos
require '../includes/conexion.php';

// Obtener el idExpediente del POST
$idExpediente = isset($_POST['idExpediente']) ? intval($_POST['idExpediente']) : 0;

if ($idExpediente == 0) {
    echo json_encode('<tr><td colspan="5">No se ha proporcionado un idExpediente válido</td></tr>', JSON_UNESCAPED_UNICODE);
    exit;
}

$columns = ['Tratamiento.idTratamiento', 'Tratamiento.descripcionTratamiento', 'Tratamiento.duracion', 'Tratamiento.diagnostico', 'Tratamiento.fechaTratamiento'];
$columnsABuscar = ['Tratamiento.descripcionTratamiento', 'Tratamiento.duracion', 'Tratamiento.diagnostico', 'Tratamiento.fechaTratamiento'];

$table = "Tratamiento";
$detalleTable = "detalleTratamiento";
$campo = isset($_POST['input-busqueda']) ? $conn->real_escape_string($_POST['input-busqueda']) : null;

$where = "WHERE $detalleTable.idExpedienteT = $idExpediente";

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
        INNER JOIN $detalleTable ON $table.idTratamiento = $detalleTable.idTratamientoT 
        $where";
        
$resultado = $conn->query($sql);
$html = '';

if ($resultado) {
    if ($resultado->num_rows > 0) {
        while ($row = $resultado->fetch_assoc()) {
            $html .= '<tr>';
            $html .= '<td>' . $row['idTratamiento'] . '</td>';
            $html .= '<td>' . $row['descripcionTratamiento'] . '</td>';
            $html .= '<td>' . $row['duracion'] . '</td>';
            $html .= '<td>' . $row['diagnostico'] . '</td>';
            $html .= '<td>' . $row['fechaTratamiento'] . '</td>';
            $html .= '<td>
            <button type="button" class="btn btn-danger me-2" onclick="eliminarFila(this)">Eliminar</button>
            <button type="button" class="btn btn-primary" onclick="modificarTratamiento(this)">Modificar</button>
            </td>';
            $html .= '</tr>';
        }
    } else {
        $html .= '<tr>';
        $html .= '<td colspan="5">No se encontraron resultados</td>';
    }
} else {
    $html .= '<tr>';
    $html .= '<td colspan="5">Error al ejecutar la consulta</td>';
}

echo json_encode($html, JSON_UNESCAPED_UNICODE);
?>