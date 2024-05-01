<?php
// Comprueba si la solicitud es POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ruta para guardar la configuración JSON
    $config_dir = "config/";
    
    // Crear el directorio si no existe
    if (!file_exists($config_dir)) {
        mkdir($config_dir, 0755, true); // 0755 proporciona permisos para lectura y escritura por el propietario y solo lectura para otros
    }

    $config_file = $config_dir."/configurations.json";

    // Crear un array asociativo para la configuración
    $config = array(
        'adminName' => $_POST['adminName'],
        'startTime' => $_POST['startTime'],
        'endTime' => $_POST['endTime'],
    );

    // Manejar el archivo subido
    if (isset($_FILES['logo']) && $_FILES['logo']['error'] == 0) {
        $target_dir = $config_dir . "/uploads/";
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0755, true); // Crea el directorio si no existe
        }

        $file_name = basename($_FILES['logo']['name']); // Nombre del archivo original
        $target_file = $target_dir . time() . "_" . $file_name; // Asegurar nombres únicos
        move_uploaded_file($_FILES['logo']['tmp_name'], $target_file);

        // Añadir la ruta del archivo a la configuración
        $config['logo'] = "/configuracion/".$target_file;
    }

    // Guardar la configuración en el archivo JSON
    file_put_contents($config_file, json_encode($config, JSON_PRETTY_PRINT)); // Guarda el JSON

    // Respuesta de éxito
    echo json_encode(array("success" => true, "message" => "Configuración guardada con éxito"));
} else {
    // Si no es POST, devuelve error
    echo json_encode(array("success" => false, "message" => "Método no soportado"));
}
?>
