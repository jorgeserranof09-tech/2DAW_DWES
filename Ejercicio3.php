<?php
include(__DIR__ . "/src/funciones.php");


$coches_imagenes = getCSVContentInArray("coches.csv","matricula");
imprimir_tabla($coches_imagenes);








?>