<?php
require 'db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Eliminar la tarea de la base de datos
    $stmt = $conn->prepare("DELETE FROM tareas WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    // Redirigir a la página principal
    header('Location: index.php');
    exit();
}
?>
