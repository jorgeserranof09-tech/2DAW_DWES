<?php

require_once __DIR__ . '/funciones.php';

$datosValidos = null;
$reservaCreada = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $datosValidos = validateNuevaReservaInput();

    $formularioValido = true;

    foreach ($datosValidos as $informacion) {
        if (!$informacion['valido']) {
            $formularioValido = false;
        }
    }

    if ($formularioValido) {
        try {
            guardarReserva($datosValidos);

            header('Location: index.php?creada=1');
            exit;
        } catch (PDOException $e) {
            $errorBD = 'No se ha podido guardar la reserva.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva reserva</title>
</head>

<body>

    <h1>Nueva reserva</h1>

    <?php if (isset($errorBD)): ?>
        <p><?= htmlspecialchars($errorBD) ?></p>
    <?php endif; ?>

    <?php if ($datosValidos !== null): ?>
        <div class="erroresContainer">
            <ul>
                <?php foreach ($datosValidos as $informacion): ?>
                    <?php if (!$informacion['valido']): ?>
                        <li>
                            <?= htmlspecialchars($informacion['mensaje']) ?>
                        </li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="post" action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>">

        <label for="nombre">Nombre:</label>
        <input
            id="nombre"
            type="text"
            name="nombre"
            maxlength="60"
            required
            value="<?= htmlspecialchars($datosValidos['nombre']['value'] ?? '') ?>"
        >

        <label for="email">Email:</label>
        <input
            id="email"
            type="email"
            name="email"
            required
            value="<?= htmlspecialchars($datosValidos['email']['value'] ?? '') ?>"
        >

        <label for="pista">Pista:</label>
        <select id="pista" name="pista" required>
            <option value="">Seleccionar...</option>

            <?php foreach (PISTAS_VALIDAS as $pista): ?>
                <option
                    value="<?= htmlspecialchars($pista) ?>"
                    <?= (($datosValidos['pista']['value'] ?? '') === $pista) ? 'selected' : '' ?>
                >
                    <?= htmlspecialchars($pista) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="fecha">Fecha:</label>
        <input
            id="fecha"
            type="date"
            name="fecha"
            min="<?= date('Y-m-d') ?>"
            required
            value="<?= htmlspecialchars($datosValidos['fecha']['value'] ?? '') ?>"
        >

        <fieldset>
            <legend>Hora</legend>

            <?php foreach (HORAS_VALIDAS as $horaValida): ?>
                <input
                    id="hora_<?= htmlspecialchars($horaValida) ?>"
                    type="radio"
                    name="hora"
                    value="<?= htmlspecialchars($horaValida) ?>"
                    <?= (($datosValidos['hora']['value'] ?? '') === $horaValida) ? 'checked' : '' ?>
                    required
                >

                <label for="hora_<?= htmlspecialchars($horaValida) ?>">
                    <?= htmlspecialchars($horaValida) ?>
                </label>
            <?php endforeach; ?>
        </fieldset>

        <fieldset>
            <legend>Material</legend>

            <?php foreach (MATERIALES_VALIDOS as $material): ?>
                <input
                    id="mat_<?= htmlspecialchars($material) ?>"
                    type="checkbox"
                    name="material[]"
                    value="<?= htmlspecialchars($material) ?>"
                    <?= in_array(
                        $material,
                        $datosValidos['material']['value'] ?? [],
                        true
                    ) ? 'checked' : '' ?>
                >

                <label for="mat_<?= htmlspecialchars($material) ?>">
                    <?= ucfirst(htmlspecialchars($material)) ?>
                </label>
            <?php endforeach; ?>
        </fieldset>

        <input
            type="checkbox"
            id="normas_aceptadas"
            name="normas_aceptadas"
            value="normas_aceptadas"
            <?= isset($_POST['normas_aceptadas']) ? 'checked' : '' ?>
            required
        >

        <label for="normas_aceptadas">
            Acepto las normas de la reserva
        </label>

        <br>

        <button type="submit" name="nueva_reserva" value="nueva_reserva">
            Hacer reserva
        </button>

    </form>

    <p><a href="index.php">Volver al listado de reservas</a></p>

</body>
</html>