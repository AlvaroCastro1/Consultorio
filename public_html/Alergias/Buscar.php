<?php
// Incluir el archivo de conexión a la base de datos
require '../includes/conexion.php';

// Obtener los datos del POST
$idExpedienteDA = isset($_POST['idExpedienteDA']) ? $_POST['idExpedienteDA'] : '';
$tipoAlergia = isset($_POST['tipoAlergia']) ? $_POST['tipoAlergia'] : '';

// Definir las columnas a seleccionar
$columns = ['Alergias.idAlergias', 'Alergias.tipoAlergia', 'Alergias.alergeno', 'detalleAlergias.score'];

// Definir la tabla principal y la tabla de detalles
$table = "Alergias";
$detalleTable = "detalleAlergias";

// Construir la cláusula WHERE
$whereClauses = [];
$params = [];
$types = "";

if (!empty($idExpedienteDA)) {
    $whereClauses[] = "$detalleTable.idExpedienteDA = ?";
    $params[] = $idExpedienteDA;
    $types .= "i"; // entero para idExpedienteDA
}
if (!empty($tipoAlergia)) {
    $whereClauses[] = "$table.tipoAlergia LIKE ?";
    $params[] = "%$tipoAlergia%";
    $types .= "s"; // cadena de texto para tipoAlergia
}

if (empty($whereClauses)) {
    echo json_encode('<tr><td colspan="5">No se ha proporcionado un criterio de búsqueda válido</td></tr>', JSON_UNESCAPED_UNICODE);
    exit;
}

$where = "WHERE " . implode(" AND ", $whereClauses);

// Construir la consulta SQL
$sql = "SELECT " . implode(", ", $columns) . " 
        FROM $table 
        INNER JOIN $detalleTable ON $table.idAlergias = $detalleTable.idAlergiasDA 
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
            $html .= '<td>' . $row['idAlergias'] . '</td>';
            $html .= '<td>' . $row['tipoAlergia'] . '</td>';
            $html .= '<td>' . $row['alergeno'] . '</td>';
            $html .= '<td>' . $row['score'] . '</td>';
            $html .= '<td>
            <button type="button" class="btn btn-danger me-2" onclick="eliminarFila(this)">Eliminar</button>
            <button type="button" class="btn btn-primary" onclick="modificarAlergia(this)">Modificar</button>
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
