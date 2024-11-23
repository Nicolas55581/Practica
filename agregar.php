<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tarea'])) {
    $tarea = $_POST['tarea'];
    $fecha = date('Y-m-d');
    $estado = 'Pendiente';

    // Insertar la tarea en la base de datos
    $stmt = $conn->prepare("INSERT INTO tareas (tarea, fecha, estado) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $tarea, $fecha, $estado);
    $stmt->execute();

    // Redirigir a la página principal
    header('Location: index.php');
    exit();
}
?>
