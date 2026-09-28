<?php


$cuadro = array();
$filas = 8;
$columnas = 4;

$cuadro = generar_tablero($filas,$columnas);

dump($cuadro);



function dump($var)
{
  echo '<pre>' . print_r($var, 1) . '</pre>';
}


function generar_tablero($x, $y)
{
    $valores_casillas  = array("hierba","agua","muro","arbusto");
    $cuadro = array();
    for ($i = 0; $i < $y; $i++) {
        for ($j = 0; $j < $x; $j++) {
            $cuadro[$i][$j] = htmlspecialchars("<div class='". $valores_casillas[array_rand($valores_casillas)] . " campo'>");
        }
        echo "<br>";
    }
    return $cuadro;
}

echo "<div class='array'";


//quiero que el tablero sea de un valor pasado como parametro 


//cada imagen debe ser de 16 x 16 px por ejemplo o 32 x 32
