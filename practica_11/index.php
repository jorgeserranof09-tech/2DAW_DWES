<?php 
require_once("functions.php");

$reservas = obtener_datos();

?>


<table border='1'>
<tr>
    <td>Nombre</td>
    <td>Correo</td>
    <td>Pista</td>
    <td>Fecha</td>
    <td>Hora</td>
</tr>
<tr>
<?php 
for($i = 1;$i<count($reservas);$i++) {
    foreach($reservas[$i] as $reserva => $dato) {
         echo "<td>".$dato."</td>";
    }
    echo "</tr>";
}

?>
</table>



?>