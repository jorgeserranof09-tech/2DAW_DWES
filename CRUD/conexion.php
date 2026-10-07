<?php
require_once("credenciales.php");
$code = $_POST["code"];

try {
    $pdo = new PDO(
        'mysql:host=localhost;dbname=dwes;charset=utf8mb4', 
        'dwes', 
        'abc123.', 
        [ 
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]
    );
    
    echo $pdo->query('SELECT * FROM familia WHERE cod LIKE :code');
 



} catch (Exception $e) {
    echo "Error: Ha surgido un problema" . $e->getMessage();
}


?>