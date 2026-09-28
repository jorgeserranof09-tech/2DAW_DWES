<?php
include(__DIR__ . '/src/funciones.php');


$coches_imagenes = getCSVContentInArray('coches.csv','matricula');
?>
<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <link rel='stylesheet' href='style.css'>
</head>
<body>
    <?php imprimir_tabla($coches_imagenes); ?>"
</body>
</html>";




?>
