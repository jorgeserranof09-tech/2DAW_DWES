<?php
require_once("functions.php");



$fecha_min = date("d-m-Y");
$fecha_max = strtotime('+14 day',strtotime($fecha_min));
$fecha_max = date("d-m-Y",$fecha_max);


?>
    <link rel="stylesheet" href="style/css.css">
<form method="post">
    <input type="text" name="nombre" placeholder="Nombre">
    <br>

    <input type="email" name="email" placeholder="Email">
    <br>

    <select name="pista">
        <option value="1">Pádel 1</option>
        <option value="2">Pádel 2</option>
        <option value="3">Tenis</option>
        <option value="3">Baloncesto</option>
        <option value="3">Futbol</option>

    </select>
    <br>

    <input type="date" min="<?php htmlspecialchars($fecha_min); ?>" 
    max="<?php htmlspecialchars($fecha_max); ?>"value="value="<?php htmlspecialchars($fecha_min); ?>>
    <br>

    <input type="radio" name="hora" value="10:00"> 
    <input type="radio" name="hora" value="12:00"> 
    <input type="radio" name="hora" value="16:00"> 
    <br>

    <input type="checkbox" name="material" value="si">
    Necesito material
    <br>

    <label for="normas">¿Aceptas las normas?</label>
    <input type="checkbox" name="normas" value="normas">

    <br>
    <input type="submit" value="Reservar">
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    validar_datos($nombre,$email);
}

if(comprobar_disponibilidad_pista("Pista 2","2026-10-12","19:00 - 20:00")) {
    echo "SI";
} else {
    echo "no";
}


?>

