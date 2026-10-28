<?php

require_once __DIR__ . '/vars.php';

function dump($var)
{
    echo '<pre>' . print_r($var, true) . '</pre>';
}

function getPersistentData($dataSource, $origin)
{
    switch ($origin) {
        case 'db':
            return _getDBData($dataSource);

        case 'file':
            return _getCSVData($dataSource);

        default:
            return null;
    }
}

function _getDBData($dbConnectionParameters)
{
    $dbh = new PDO(
        $dbConnectionParameters['dsn'],
        $dbConnectionParameters['username'],
        $dbConnectionParameters['password'],
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );

    $sth = $dbh->query('SELECT * FROM reserva');

    $data = [];

    while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
        $row['material'] = $row['material'] ?? '';
        $data[] = $row;
    }

    return $data;
}

function _getCSVData($path)
{
    $data = [];

    if (($filehandler = fopen($path, 'r')) !== false) {
        $cabeceras = fgetcsv($filehandler);

        while (($fields = fgetcsv($filehandler)) !== false) {
            if (count($cabeceras) === count($fields)) {
                $data[] = array_combine($cabeceras, $fields);
            }
        }

        fclose($filehandler);

        return $data;
    }

    return null;
}

function getValidFiltersFromQueryString()
{
    $filters = [
        'pista' => FILTER_UNSAFE_RAW,
        'fecha' => FILTER_UNSAFE_RAW
    ];

    $filtrosSinValidar = filter_input_array(
        INPUT_GET,
        $filters
    );

    $filtrosSinValidar = $filtrosSinValidar ?: [];

    _validateFilterPista($filtrosSinValidar);
    _validateFilterFecha($filtrosSinValidar);

    return $filtrosSinValidar;
}

function filtraFechaPista($reserva, $filtro)
{
    $pasaFiltroPista = true;
    $pasaFiltroFecha = true;

    if (
        isset($filtro['pista'])
        && $reserva['pista'] !== $filtro['pista']
    ) {
        $pasaFiltroPista = false;
    }

    if (
        isset($filtro['fecha'])
        && $reserva['fecha'] !== $filtro['fecha']
    ) {
        $pasaFiltroFecha = false;
    }

    return $pasaFiltroPista && $pasaFiltroFecha;
}

function _validateFilterPista(&$filtro)
{
    if (
        !isset($filtro['pista'])
        || empty($filtro['pista'])
        || !in_array($filtro['pista'], PISTAS_VALIDAS, true)
    ) {
        unset($filtro['pista']);
    }
}

function _validateFilterFecha(&$filtro)
{
    if (
        !isset($filtro['fecha'])
        || !preg_match(
            '/^\d{4}-\d{2}-\d{2}$/',
            $filtro['fecha']
        )
    ) {
        unset($filtro['fecha']);
        return;
    }

    $dateArray = explode('-', $filtro['fecha']);

    if (!checkdate(
        (int) $dateArray[1],
        (int) $dateArray[2],
        (int) $dateArray[0]
    )) {
        unset($filtro['fecha']);
    }
}

/**
 * Valida todos los datos enviados mediante POST.
 */
function validateNuevaReservaInput()
{
    return [
        'nombre' => _validateNombreNuevaReserva(),
        'email' => _validateEmailNuevaReserva(),
        'pista' => _validatePistaNuevaReserva(),
        'fecha' => _validateFechaNuevaReserva(),
        'hora' => _validateHoraNuevaReserva(),
        'material' => _validateMaterialNuevaReserva(),
        'normas' => _validateNormasNuevaReserva()
    ];
}

function _validateNombreNuevaReserva()
{
    $nombre = trim($_POST['nombre'] ?? '');

    if ($nombre === '') {
        return [
            'valido' => false,
            'mensaje' => 'La reserva debe tener un nombre',
            'value' => $nombre
        ];
    }

    $longitud = mb_strlen($nombre);

    if ($longitud < 3 || $longitud > 60) {
        return [
            'valido' => false,
            'mensaje' => 'El nombre debe tener entre 3 y 60 caracteres',
            'value' => $nombre
        ];
    }

    return [
        'valido' => true,
        'value' => $nombre
    ];
}

function _validateEmailNuevaReserva()
{
    $email = trim($_POST['email'] ?? '');

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return [
            'valido' => false,
            'mensaje' => 'La reserva debe tener un email válido',
            'value' => $email
        ];
    }

    return [
        'valido' => true,
        'value' => $email
    ];
}

function _validatePistaNuevaReserva()
{
    $pista = $_POST['pista'] ?? '';

    if (!in_array($pista, PISTAS_VALIDAS, true)) {
        return [
            'valido' => false,
            'mensaje' => 'Debes seleccionar una pista válida',
            'value' => $pista
        ];
    }

    return [
        'valido' => true,
        'value' => $pista
    ];
}

function _validateFechaNuevaReserva()
{
    $fecha = $_POST['fecha'] ?? '';

    if (
        !preg_match('/^\d{4}-\d{2}-\d{2}$/', $fecha)
    ) {
        return [
            'valido' => false,
            'mensaje' => 'Debes introducir una fecha correcta',
            'value' => $fecha
        ];
    }

    $dateArray = explode('-', $fecha);

    if (!checkdate(
        (int) $dateArray[1],
        (int) $dateArray[2],
        (int) $dateArray[0]
    )) {
        return [
            'valido' => false,
            'mensaje' => 'La fecha introducida no existe',
            'value' => $fecha
        ];
    }

    if ($fecha < date('Y-m-d')) {
        return [
            'valido' => false,
            'mensaje' => 'No puedes reservar en una fecha pasada',
            'value' => $fecha
        ];
    }

    return [
        'valido' => true,
        'value' => $fecha
    ];
}

function _validateHoraNuevaReserva()
{
    $hora = $_POST['hora'] ?? '';

    if (!in_array($hora, HORAS_VALIDAS, true)) {
        return [
            'valido' => false,
            'mensaje' => 'Debes seleccionar una hora válida',
            'value' => $hora
        ];
    }

    return [
        'valido' => true,
        'value' => $hora
    ];
}

function _validateMaterialNuevaReserva()
{
    $materiales = $_POST['material'] ?? [];

    if (!is_array($materiales)) {
        $materiales = [];
    }

    foreach ($materiales as $material) {
        if (!in_array($material, MATERIALES_VALIDOS, true)) {
            return [
                'valido' => false,
                'mensaje' => 'Hay materiales no válidos',
                'value' => []
            ];
        }
    }

    return [
        'valido' => true,
        'value' => array_values(array_unique($materiales))
    ];
}

function _validateNormasNuevaReserva()
{
    if (isset($_POST['normas_aceptadas'])) {
        return [
            'valido' => true,
            'value' => 'normas_aceptadas'
        ];
    }

    return [
        'valido' => false,
        'mensaje' => 'Debes aceptar las normas para realizar la reserva'
    ];
}

/**
 * Guarda la reserva en la base de datos.
 */
function guardarReserva($datosValidos)
{
    $dbh = new PDO(
        DB_DSN,
        DB_USERNAME,
        DB_PASSWORD,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );

    $sql = 'INSERT INTO reserva
        (nombre, email, pista, fecha, hora, material)
        VALUES
        (:nombre, :email, :pista, :fecha, :hora, :material)';

    $sth = $dbh->prepare($sql);

    $sth->execute([
        ':nombre' => $datosValidos['nombre']['value'],
        ':email' => $datosValidos['email']['value'],
        ':pista' => $datosValidos['pista']['value'],
        ':fecha' => $datosValidos['fecha']['value'],
        ':hora' => $datosValidos['hora']['value'],
        ':material' => implode(
            ', ',
            $datosValidos['material']['value']
        )
    ]);
}