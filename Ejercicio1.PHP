<?php
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(E_ALL);
/*
Array_column
array_combine
array_filter
array_keys
array_map
array_pad
array_pop
array_push
array_walks
array_unshift
in_array
reset
array_values
asort
uasort
*/


$coches = array(
    "1234ABC" => [
        "Lamborghini",
        "modelo" => "XR74",
        "color" => "Rojo",
        "matricula" => "1234ABC"
    ],
    "5678DEF" => [
        "marca" => "Ferrari",
        "modelo" => "AB25",
        "color" => "Negro",
        "matricula" => "5678DEF"
    ],
    "9012GHI" => [
        "marca" => "BMW",
        "modelo" => "MK32",
        "color" => "Azul",
        "matricula" => "9012GHI"
    ],
    "3456JKL" => [
        "marca" => "Mercedes",
        "modelo" => "PQ18",
         "color" => "Blanco",
        "matricula" => "3456JKL"
    ],
    "7890MNP" => [
        "marca" => "Audi",
        "modelo" => "RT56",
         "color" => "Gris",
        "matricula" => "7890MNP"
    ],
    "1234QRS" => [
        "marca" => "Toyota",
        "modelo" => "LM91",
         "color" => "Verde",
        "matricula" => "1234QRS"
    ],
    "5678TUV" => [
        "marca" => "Ford",
        "modelo" => "BC43",
         "color" => "Amarillo",
        "matricula" => "5678TUV"
    ],
    "9012WXY" => [
        "marca" => "Porsche",
        "modelo" => "JK72",
         "color" => "Negro",
        "matricula" => "9012WXY"
    ],
    "3456BCD" => [
        "marca" => "Seat",
        "modelo" => "HG38",
         "color" => "Blanco",
        "matricula" => "3456BCD"
    ],
    "7890FGH" => [
        "marca" => "Volkswagen",
        "modelo" => "ZX64",
         "color" => "Gris",
        "matricula" => "7890FGH"
    ]
);

$Indexado=[];

foreach($coches as $clave => $coche)  {
   $Indexado[$coche['matricula']] = $coche;

}
var_dump($Indexado);



?>

