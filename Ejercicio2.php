<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include(__DIR__."/src/funciones.php");

// $coches = [];

// if ($fp = fopen("coches.csv","r") != false) {
//     $fp = fopen("coches.csv","r");
// } else {
//     echo "Archivo no encontrado";
// }

// echo '<table border="1">
//     <tr>
//         <td>Matricula</td>
//         <td>marca</td>
//         <td>modelo</td>
//         <td>color</td>
//     </tr>';

// while($data = fgetcsv($fp,1000,","))  {
//     $coches[$data[0]] = [
//         "matricula" => $data[0],
//         "marca" => $data[1],
//         "modelo" => $data[2],
//         "color" => $data[3]
//     ];

// echo "<tr>
//         <td>".($data[0]) ."</td>
//         <td>".($data[1]) ."</td>
//         <td>".($data[2]) ."</td>
//         <td>".($data[3]) ."</td>
//     </tr>";
// }

// fclose($fp);
// var_dump($coches);




$coches = getCSVContentInArray("coches.csv","color");
dump($coches);


?>
