<?php
// Datos de conexión a la base de datos
$servername = "localhost";
$username = "gdxjl15a5_root";
$password = "7YW3QDTuAb4nWvkJ2tDY";
$dbname = "gdxjl15a5_consultorio";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}   
?>
