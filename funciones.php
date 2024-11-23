<?php
require 'db.php';

// Función para agregar una nueva tarea
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tarea']) && !isset($_POST['editar_id'])) {
    $tarea = $_POST['tarea'];
    $fecha = date('Y-m-d');  
    $estado = 'Pendiente';  // Estado por defecto de la nueva tarea siempre debe ser pendiente

    // Insertar la tarea en la base de datos
    $stmt = $conn->prepare("INSERT INTO tareas (tarea, fecha, estado) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $tarea, $fecha, $estado);
    $stmt->execute();
    $stmt->close();

    // Redirigir a la página principal
    header('Location: index.php');
    exit();
}

// Función para editar una tarea 
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['editar_id'])) {
    $id = $_POST['editar_id'];
    $tarea = $_POST['tarea'];
    $estado = $_POST['estado'];  // Estado que seleccione el usuario
    $fecha = $_POST['fecha'];  // Fecha que seleccione el usuario

    // Actualizar la tarea en la base de datos
    $stmt = $conn->prepare("UPDATE tareas SET tarea = ?, estado = ?, fecha = ? WHERE id = ?");
    $stmt->bind_param("sssi", $tarea, $estado, $fecha, $id);
    $stmt->execute();
    $stmt->close();

    // Redirigir a la página principal despues del cambio
    echo "<script>window.location.href='index.php';</script>";
    exit();
}

// Función para eliminar una tarea
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['eliminar'])) {
    $id = $_GET['eliminar'];

    // Elimina la tarea de la base de datos
    $stmt = $conn->prepare("DELETE FROM tareas WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();

    // Redirigir después de eliminar para evitar reenvíos al actualizar la página
    header('Location: index.php');
    exit();
}

// Obtener todas las tareas desde la base de datos
$result = $conn->query("SELECT * FROM tareas ORDER BY fecha DESC");
$tareas = [];
while ($row = $result->fetch_assoc()) {
    $tareas[] = $row;
}
?>
