<?php
// Inclui el archivo para solo llamar a la funcion necesaria
include 'funciones.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Tareas</title>

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f7fc;
        }
        .container {
            margin-top: 50px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center text-success mb-4">Lista de Tareas</h1>

        <!-- agregar tareas -->
        <form method="POST" action="" class="mb-4">
            <div class="form-row">
                <div class="col-md-8">
                    <input type="text" name="tarea" class="form-control" placeholder="Nueva tarea" required>
                </div>
                <div class="col-md-3">
                    <input type="date" name="fecha" class="form-control" required>
                </div>
                <div class="col-md-1">
                    <button type="submit" class="btn btn-success btn-block">Agregar</button>
                </div>
            </div>
        </form>

        <!-- Tabla de tareas -->
        <table class="table table-bordered">
            <thead class="thead-light">
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
                            <!-- Botón de editar -->
                            <a href="index.php?editar=<?php echo $tarea['id']; ?>" class="btn btn-warning btn-sm">Editar</a>
                            <!-- Botón de eliminar -->
                            <a href="index.php?eliminar=<?php echo $tarea['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro que deseas eliminar esta tarea?');">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <?php
        // Mostrar el formulario de edición si se seleccionó el boton de editar
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

        <div class="mt-5">
            <h2 class="text-center mb-4">Editar Tarea</h2>
            <!-- Formulario para editar -->
            <form method="POST" action="">
                <input type="hidden" name="editar_id" value="<?php echo $tarea_editar['id']; ?>">
                <div class="form-row">
                    <div class="col-md-8">
                        <input type="text" name="tarea" class="form-control" value="<?php echo htmlspecialchars($tarea_editar['tarea']); ?>" required>
                    </div>
                    <div class="col-md-3">
                        <input type="date" name="fecha" class="form-control" value="<?php echo $tarea_editar['fecha']; ?>" required>
                    </div>
                    <div class="col-md-1">
                        <select name="estado" class="form-control">
                            <option value="Pendiente" <?php echo ($tarea_editar['estado'] == 'Pendiente') ? 'selected' : ''; ?>>Pendiente</option>
                            <option value="Completado" <?php echo ($tarea_editar['estado'] == 'Completado') ? 'selected' : ''; ?>>Completado</option>
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btn-block mt-4">Guardar Cambios</button>
            </form>
        </div>

        <?php } ?>
    </div>

    <!-- Inclusion de Bootstrap JS y dependencias -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
