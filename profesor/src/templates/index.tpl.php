<?php

require_once __DIR__ . '../funciones.php';

try {
    $parametrosBD = [
        'dsn' => DB_DSN,
        'username' => DB_USERNAME,
        'password' => DB_PASSWORD
    ];

    $reservas = getPersistentData($parametrosBD, 'db');

    $filtros = getValidFiltersFromQueryString();

    $reservas = array_filter(
        $reservas,
        function ($reserva) use ($filtros) {
            return filtraFechaPista($reserva, $filtros);
        }
    );

} catch (PDOException $e) {
    $reservas = [];
    $errorBD = 'No se han podido cargar las reservas.';
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de reservas</title>
</head>

<body>

    <h1>Lista de reservas</h1>

    <?php if (isset($_GET['creada'])): ?>
        <p>La reserva se ha creado correctamente.</p>
    <?php endif; ?>

    <?php if (isset($errorBD)): ?>
        <p><?= htmlspecialchars($errorBD) ?></p>
    <?php endif; ?>

    <form method="get" action="./index.php">

        <fieldset>
            <legend>Filtros</legend>

            <label for="filtroPista">Pista</label>

            <select name="pista" id="filtroPista">
                <option value="">Seleccionar...</option>

                <?php foreach (PISTAS_VALIDAS as $pista): ?>
                    <option
                        value="<?= htmlspecialchars($pista) ?>"
                        <?= (($filtros['pista'] ?? '') === $pista) ? 'selected' : '' ?>
                    >
                        <?= htmlspecialchars($pista) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="fecha">Fecha:</label>

            <input
                type="date"
                id="fecha"
                name="fecha"
                value="<?= htmlspecialchars($filtros['fecha'] ?? '') ?>"
            >

            <button type="submit">Filtrar</button>

            <a href="./index.php">Restablecer filtros</a>
        </fieldset>

    </form>

    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Email</th>
                <th>Pista</th>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Material</th>
            </tr>
        </thead>

        <tbody>
            <?php if (empty($reservas)): ?>
                <tr>
                    <td colspan="6">No hay reservas que mostrar.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($reservas as $reserva): ?>
                    <tr>
                        <td><?= htmlspecialchars($reserva['nombre']) ?></td>
                        <td><?= htmlspecialchars($reserva['email']) ?></td>
                        <td><?= htmlspecialchars($reserva['pista']) ?></td>
                        <td><?= htmlspecialchars($reserva['fecha']) ?></td>
                        <td><?= htmlspecialchars($reserva['hora']) ?></td>
                        <td><?= htmlspecialchars($reserva['material'] ?? '') ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <p><a href="./reservar.php">Nueva reserva</a></p>

</body>
</html>