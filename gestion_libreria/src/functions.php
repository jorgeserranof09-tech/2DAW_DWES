<?php


function dump($var)
{
    echo '<pre>' . print_r($var, true) . '</pre>';
}


function conectar($dbConnectionParameters) {
     $pdo = new PDO(
        $dbConnectionParameters['dsn'],
        $dbConnectionParameters['username'],
        $dbConnectionParameters['password'],
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
    return $pdo;
}


function _getDBData(PDO $pdo) {
    $stmt = $pdo -> prepare('SELECT * FROM libros');
    $stmt -> execute();

    $data = [];

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $row[] = $row ?? '';
        $data[] = $row;
    }
    return $data;
}

function contarDisponibles(PDO $pdo) {
    $disponibles = 0;

    $stmt = $pdo->query('SELECT * FROM libros');
    $data = [];
    while($row = $stmt->fetchColumn()) {
        $row = $row ?? '';
         var_dump($row);
        $data = $row;
        if($data['disponible'] == 1) {
            $disponibles++;
        }
    }
    return $disponibles;
}

?>