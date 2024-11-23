<?php
// Incluir el archivo de conexión a la base de datos
include 'db.php';

// Manejar la adición de nuevas tareas (solo si NO es una edición)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tarea']) && !isset($_POST['editar_id'])) {
    $tarea = $_POST['tarea'];
    $fecha = $_POST['fecha']; // Ahora obtenemos la fecha seleccionada por el usuario
    $estado = "Pendiente"; // Por defecto, las nuevas tareas están como Pendiente

    // Insertar la nueva tarea en la base de datos
    $stmt = $conn->prepare("INSERT INTO tareas (tarea, fecha, estado) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $tarea, $fecha, $estado);
    $stmt->execute();
    $stmt->close();
}

// Manejar la eliminación de tareas
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['eliminar'])) {
    $id = $_GET['eliminar'];

    // Eliminar la tarea de la base de datos
    $stmt = $conn->prepare("DELETE FROM tareas WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();

    // Redirigir después de eliminar para evitar reenvíos al actualizar la página
    header('Location: index.php');
    exit();
}

// Manejar la edición de tareas
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['editar_id'])) {
    $id = $_POST['editar_id'];
    $tarea = $_POST['tarea'];
    $estado = $_POST['estado']; // Usamos directamente el valor seleccionado en el formulario
    $fecha = $_POST['fecha']; // Obtener la fecha seleccionada en la edición

    // Actualizar la tarea en la base de datos
    $stmt = $conn->prepare("UPDATE tareas SET tarea = ?, estado = ?, fecha = ? WHERE id = ?");
    $stmt->bind_param("sssi", $tarea, $estado, $fecha, $id);
    $stmt->execute();
    $stmt->close();

    // Redirigir después de guardar cambios para evitar reenvíos
    echo "<script>window.location.href='index.php';</script>";
    exit();
}

// Obtener todas las tareas desde la base de datos
$result = $conn->query("SELECT * FROM tareas ORDER BY fecha DESC");
$tareas = [];
while ($row = $result->fetch_assoc()) {
    $tareas[] = $row;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Tareas</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7fc;
            color: #333;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 80%;
            max-width: 900px;
        }

        h1 {
            text-align: center;
            color: #4CAF50;
            font-size: 2em;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        input[type="text"], input[type="date"] {
            width: 80%;
            padding: 10px;
            font-size: 1em;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        button {
            padding: 10px 20px;
            font-size: 1em;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #45a049;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
            color: #555;
        }

        td {
            background-color: #fafafa;
        }

        .btn {
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }

        .btn-editar {
            background-color: #4CAF50;
            color: white;
        }

        .btn-editar:hover {
            background-color: #45a049;
        }

        .btn-eliminar {
            background-color: #f44336;
            color: white;
        }

        .btn-eliminar:hover {
            background-color: #e53935;
        }

        select {
            padding: 10px;
            font-size: 1em;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .form-container {
            margin-top: 30px;
        }

        .form-container h2 {
            text-align: center;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Lista de Tareas</h1>

        <!-- Formulario para agregar tareas -->
        <form method="POST" action="">
            <input type="text" name="tarea" placeholder="Nueva tarea" required>
            <input type="date" name="fecha" required>
            <button type="submit">Agregar</button>
        </form>

        <!-- Tabla de tareas -->
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tarea</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tareas as $tarea): ?>
                    <tr>
                        <td><?php echo $tarea['id']; ?></td>
                        <td><?php echo htmlspecialchars($tarea['tarea']); ?></td>
                        <td><?php echo $tarea['fecha']; ?></td>
                        <td><?php echo $tarea['estado']; ?></td>
                        <td>
                            <!-- Botón para editar -->
                            <a href="index.php?editar=<?php echo $tarea['id']; ?>" class="btn btn-editar">Editar</a>
                            <!-- Botón para eliminar -->
                            <a href="index.php?eliminar=<?php echo $tarea['id']; ?>" class="btn btn-eliminar" onclick="return confirm('¿Seguro que deseas eliminar esta tarea?');">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <?php
        // Mostrar el formulario de edición si se seleccionó una tarea
        if (isset($_GET['editar'])) {
            $editar_id = $_GET['editar'];
            // Obtener la tarea a editar
            $stmt = $conn->prepare("SELECT * FROM tareas WHERE id = ?");
            $stmt->bind_param("i", $editar_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $tarea_editar = $result->fetch_assoc();
            $stmt->close();
        ?>

        <div class="form-container">
            <h2>Editar Tarea</h2>
            <!-- Formulario para editar la tarea -->
            <form method="POST" action="">
                <input type="hidden" name="editar_id" value="<?php echo $tarea_editar['id']; ?>">
                <input type="text" name="tarea" value="<?php echo htmlspecialchars($tarea_editar['tarea']); ?>" required>
                <input type="date" name="fecha" value="<?php echo $tarea_editar['fecha']; ?>" required>
                <select name="estado">
                    <option value="Pendiente" <?php echo ($tarea_editar['estado'] == 'Pendiente') ? 'selected' : ''; ?>>Pendiente</option>
                    <option value="Completado" <?php echo ($tarea_editar['estado'] == 'Completado') ? 'selected' : ''; ?>>Completado</option>
                </select>
                <button type="submit">Guardar Cambios</button>
            </form>
        </div>

        <?php } ?>
    </div>
</body>
</html>
