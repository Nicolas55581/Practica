Lista de Tareas

Este proyecto es una aplicación web simple para gestionar tareas diarias. Permite agregar, editar y eliminar tareas, así como visualizar las tareas en una lista.

archivos importantes
- db.php: este se encarga de la conexion a la base de datos
- funciones.php: contiene todas las funciones que hacen funcionar el index.php
- index.php: contiene todo el html, bootstrap y estilos para que se vea lindo dicha tabla de tareas aqui se llaman todas las funciones para que pueda tener una escalibilidad y sea mas sencillo de mejorar  

Funciones que incluye

- Agregar Tareas: Permite agregar nuevas tareas con un nombre, una fecha y un estado (Pendiente o Completado).
- Editar Tareas: Permite editar una tarea existente y actualizar su nombre, fecha y estado.
- Eliminar Tareas: Permite eliminar tareas de la base de datos.
- Visualiza las Tareas: Muestra una lista de todas las tareas registradas, con su id, tarea, fecha y estado.

Requisitos

- PHP 7.0 o superior
- MySQL (la tabla debe de contener lo siguiente: id (tipo de dato entero, pk, no nulo y auto incremento), tarea(tipo de dato varchar y no nulo), fecha (tipo de dato date y no nulo) y estado (tipo de dato enum con los valores de Pendiente y Completado y no nulo))
- Servidor local (como XAMPP, WAMP, o similar)
