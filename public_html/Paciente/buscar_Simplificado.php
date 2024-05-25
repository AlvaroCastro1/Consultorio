<?php
// Incluir el archivo de conexión a la base de datos
require '../includes/conexion.php';

$columnsPaciente = ['idPaciente', 'nombre', 'apellidoPaterno', 'apellidoMaterno'];
$columnsExpediente = ['idExpediente'];
$columnsABuscar = ['Paciente.idPaciente','Paciente.nombre', 'Paciente.apellidoPaterno', 'Paciente.apellidoMaterno'];

$tablePaciente = "Paciente";
$tableExpediente = "Expediente";

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

$sql = "SELECT Paciente.idPaciente, Paciente.nombre,Paciente.apellidoPaterno,Paciente.apellidoMaterno, Expediente.idExpediente
        FROM $tablePaciente
        LEFT JOIN $tableExpediente ON Paciente.idPaciente = Expediente.idPacienteE
        $where";
$resultado = $conn->query($sql);
$html = '';

if ($resultado) {
    if ($resultado->num_rows > 0) {
        while ($row = $resultado->fetch_assoc()) {
            $html .= '<tr>';
            $html .= '<td>' . $row['idPaciente'] . '</td>';
            $html .= '<td>' . $row['nombre'] . '</td>';
            $html .= '<td>' . $row['apellidoPaterno'] . '</td>';
            $html .= '<td>' . $row['apellidoMaterno'] . '</td>';
            $html .= '<td>' . (isset($row['idExpediente']) ? $row['idExpediente'] : 'N/A') . '</td>';
            $html .= '<td>
            <button type="button" class="btn btn-danger me-2" onclick="eliminarRegistro(this)">Eliminar</button>
            <button type="button" class="btn btn-primary" onclick="modificarPaciente(this)">Modificar</button>
            <button type="button" class="btn btn-primary" onclick="seleccionarExpediente(this)">Expediente</button>

            </td>';
            $html .= '</tr>';
        }
    } else {
        $html .= '<tr>';
        $html .= '<td colspan="3">No se encontraron resultados</td>';
        $html .= '</tr>';
    }
} else {
    $html .= '<tr>';
    $html .= '<td colspan="3">Error al ejecutar la consulta</td>';
    $html .= '</tr>';
}

echo json_encode($html, JSON_UNESCAPED_UNICODE);

?>

