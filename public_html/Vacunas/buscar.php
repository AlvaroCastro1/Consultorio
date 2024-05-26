<?php
// Incluir el archivo de conexión a la base de datos
require '../includes/conexion.php';

// Obtener los datos del POST
$idExpedienteDV = isset($_POST['idExpedienteDV']) ? $_POST['idExpedienteDV'] : '';
$sustanciaActiva = isset($_POST['sustanciaActiva']) ? $_POST['sustanciaActiva'] : '';

// Definir las columnas a seleccionar
$columns = [
    'Vacunas.idVacunas', 
    'Vacunas.enfermedad', 
    'Vacunas.sustanciaActiva', 
    'Vacunas.formula', 
    'Vacunas.laboratorio', 
    'Vacunas.gramaje', 
    'detalleVacunas.lote', 
    'detalleVacunas.dosis', 
    'detalleVacunas.fechaAplicacion', 
    'detalleVacunas.fechaCaducidad'
];

// Definir la tabla principal y la tabla de detalles
$table = "Vacunas";
$detalleTable = "detalleVacunas";

// Construir la cláusula WHERE
$whereClauses = [];
$params = [];
$types = "";

if (!empty($idExpedienteDV)) {
    $whereClauses[] = "$detalleTable.idExpedienteDV = ?";
    $params[] = $idExpedienteDV;
    $types .= "i"; // entero para idExpedienteDV
}
if (!empty($sustanciaActiva)) {
    $whereClauses[] = "$table.sustanciaActiva LIKE ?";
    $params[] = "%$sustanciaActiva%";
    $types .= "s"; // cadena de texto para sustanciaActiva
}

if (empty($whereClauses)) {
    echo json_encode('<tr><td colspan="10">No se ha proporcionado un criterio de búsqueda válido</td></tr>', JSON_UNESCAPED_UNICODE);
    exit;
}

$where = "WHERE " . implode(" AND ", $whereClauses);

// Construir la consulta SQL
$sql = "SELECT " . implode(", ", $columns) . " 
        FROM $table 
        INNER JOIN $detalleTable ON $table.idVacunas = $detalleTable.idVacunasDV 
        $where";

// Preparar la consulta
$stmt = $conn->prepare($sql);

// Vincular parámetros
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}

// Ejecutar la consulta
$stmt->execute();
$resultado = $stmt->get_result();
$html = '';

if ($resultado) {
    if ($resultado->num_rows > 0) {
        while ($row = $resultado->fetch_assoc()) {
            $html .= '<tr>';
            $html .= '<td>' . $row['idVacunas'] . '</td>';
            $html .= '<td>' . $row['enfermedad'] . '</td>';
            $html .= '<td>' . $row['sustanciaActiva'] . '</td>';
            $html .= '<td>' . $row['formula'] . '</td>';
            $html .= '<td>' . $row['laboratorio'] . '</td>';
            $html .= '<td>' . $row['gramaje'] . '</td>';
            $html .= '<td>' . $row['lote'] . '</td>';
            $html .= '<td>' . $row['dosis'] . '</td>';
            $html .= '<td>' . $row['fechaAplicacion'] . '</td>';
            $html .= '<td>' . $row['fechaCaducidad'] . '</td>';
            $html .= '<td>
            <button type="button" class="btn btn-danger me-2" onclick="eliminarFila(this)">Eliminar</button>
            <button type="button" class="btn btn-primary" onclick="modificarVacunas(this)">Modificar</button>
            </td>';
            $html .= '</tr>';
        }
    } else {
        $html .= '<tr>';
        $html .= '<td colspan="11">No se encontraron resultados</td>';
        $html .= '</tr>';
    }
} else {
    $html .= '<tr>';
    $html .= '<td colspan="11">Error al ejecutar la consulta</td>';
    $html .= '</tr>';
}

echo json_encode($html, JSON_UNESCAPED_UNICODE);

?>
