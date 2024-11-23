<?php
require 'db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM tareas WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $tarea = $result->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $tarea_nueva = $_POST['tarea'];
    $estado = $_POST['estado'];

    $stmt = $conn->prepare("UPDATE tareas SET tarea = ?, estado = ? WHERE id = ?");
    $stmt->bind_param("ssi", $tarea_nueva, $estado, $id);
    $stmt->execute();

    // Redirigir a la página principal
    header('Location: index.php');
    exit();
}
?>
