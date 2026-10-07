<?php

for($i=1;$i<10;$i++) {
"Hola a todos";
}




$frutas=["manzana","pera","banana"];
$persona=["Marcos" => 22,"Paco" =>25];


foreach ($frutas as $fruta) {
    echo "$fruta, " . " ";
}
echo "<br>";
echo "<br>";
foreach ($persona as $nombre => $edad) {
    echo $nombre . " tiene " . $edad . " anyos de edad";
    echo "<br>";
}




?>