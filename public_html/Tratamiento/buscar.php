<?php
// Incluir el archivo de conexión a la base de datos
require '../includes/conexion.php';

$columns = ['idDetalleTratamiento','idTratamientoDT', 'descripcionTratamiento', 'duracion'];
//fecha de tratamiento pertenece a la tabla de tratamiento y lo debo buscar con un innerjoin usando idTratamientoDT
$columnsABuscar = ['fechaTrataniemto'];

$table = "detalleTratamiento";

$campo = isset($_POST['input-busqueda']) ? $conn->real_escape_string($_POST['input-busqueda']) : null;

$where = '';

if ($campo != null) {
    $where = "WHERE (";

    $cont = count($columnsABuscar);

    for ($i = 0; $i < $cont; $i++) {
        $where .= $columnsABuscar[$i] . " LIKE '%" . $campo . "%' OR ";
    }
    $where = substr_replace($where, "", -3);

    $where .= ")";
}

$sql = "SELECT " . implode(", ", $columns) . " FROM $table $where";
$resultado = $conn->query($sql);
$html = '';


if ($resultado) {
    if ($resultado->num_rows > 0) {
        while ($row = $resultado->fetch_assoc()) {
            $html .= '<tr>';
            $html .= '<td>' . $row['idDetalleTratamiento'] . '</td>';
            $html .= '<td>' . $row['idTratamientoDT'] . '</td>';
            $html .= '<td>' . $row['descripcionTratamiento'] . '</td>';
            $html .= '<td>' . $row['duracion'] . '</td>';
            $html .= '<td>' . $row['duracion'] . '</td>';
            $html .= '<td>' . $row['duracion'] . '</td>';
            $html .= '<td>
            <button type="button" class="btn btn-danger me-2" onclick="eliminarFila(this)">Eliminar</button>
            <button type="button" class="btn btn-primary" onclick="modificarTratamiento(this)">Modificar</button>
            </td>';
            $html .= '</tr>';
        }
    } else {
        $html .= '<tr>';
        $html .= '<td colspan="7">No se encontraron resultados</td>';
        $html .= '</tr>';
    }
} else {
    $html .= '<tr>';
    $html .= '<td colspan="7">Error al ejecutar la consulta</td>';
    $html .= '</tr>';
}

echo json_encode($html, JSON_UNESCAPED_UNICODE);

?>
