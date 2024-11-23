<?php
$host = "localhost";
$user = "root"; // Nombre de usuario para la base de datos
$password = ""; // Contraseña para la base de datos
$dbname = "prueba2"; // Nombre de la base de datos

// Crea la conexión a la base de datos
$conn = new mysqli($host, $user, $password, $dbname);

// Verifica la conexión
if ($conn->connect_error) {
    die("Error en la conexión: " . $conn->connect_error);
}
?>
