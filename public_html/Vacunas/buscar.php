<?php
// Incluir el archivo de conexión a la base de datos
require '../includes/conexion.php';

$columns = ['idVacunas','sustanciaActiva','enfermedad', 'formula', 'laboratorio','dosis', 'gramaje', 'lote', 'fechaCaducidad'];
$columnsABuscar = ['sustanciaActiva'];

$table = "Vacunas";

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
            $html .= '<td>' . $row['idVacunas'] . '</td>';
            $html .= '<td>' . $row['sustanciaActiva'] . '</td>';
            $html .= '<td>' . $row['enfermedad'] . '</td>';
            $html .= '<td>' . $row['formula'] . '</td>';
            $html .= '<td>' . $row['laboratorio'] . '</td>';
            $html .= '<td>' . $row['dosis'] . '</td>';
            $html .= '<td>' . $row['gramaje'] . '</td>';
            $html .= '<td>' . $row['lote'] . '</td>';
            $html .= '<td>' . $row['fechaCaducidad'] . '</td>';
            $html .= '<td>
            <button type="button" class="btn btn-danger me-2" onclick="eliminarFila(this)">Eliminar</button>
            <button type="button" class="btn btn-primary" onclick="modificarVacunas(this)">Modificar</button>
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
