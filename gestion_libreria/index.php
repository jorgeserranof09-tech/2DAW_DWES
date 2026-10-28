<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require __DIR__ . '/src/functions.php';


$pdo = conectar([
    'dsn' => 'mysql:dbname=biblioteca;host=localhost',
    'username' => 'root_biblioteca',
    'password' => 'root_biblioteca'
]);

$datos = _getDBData($pdo);

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de libros</title>
</head>

<body>

    <h1>Lista de reservas</h1>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>ISBN</th>
                <th>Titulo</th>
                <th>Autor</th>
                <th>Anyo</th>
                <th>Genero</th>
                <th>Disponible</th>
            </tr>
        </thead>

        <tobdy>
            <?php if (empty($datos)): ?>
                <tr>
                    <td>No hay libros que mostrar</td>
                </tr>
            <?php else: ?>
                <?php foreach ($datos as $dato): ?>
                    <tr>
                        <td><?= htmlspecialchars($dato['id']) ?></td>
                        <td><?= htmlspecialchars($dato['isbn']) ?></td>
                        <td><?= htmlspecialchars($dato['titulo']) ?></td>
                        <td><?= htmlspecialchars($dato['autor']) ?></td>
                        <td><?= htmlspecialchars($dato['anio']) ?></td>
                        <td><?= htmlspecialchars($dato['genero']) ?></td>
                        <td><?= htmlspecialchars($dato['disponible']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tobdy>
    </table>

<?= contarDisponibles($pdo)?>