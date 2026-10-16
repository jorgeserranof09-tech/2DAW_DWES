<?php
require_once("functions.php");
$fecha_min = date("Y-m-d");
$fecha_max = date("Y-m-d", strtotime($fecha_min . ' + 14 days'));


validar_datos();
?>






<link rel="stylesheet" href="style/css.css">
<div class="contenedor_reserva">
<h1>Formulario de reserva</h1>
<p>Porfavor rellena el siguiente formulario</p>
<form method="post">
    <input type="text" name="nombre" placeholder="Nombre">

    <input type="email" name="email" placeholder="Email">

    <select name="pista">
        <option value="1">Pádel 1</option>
        <option value="2">Pádel 2</option>
        <option value="3">Tenis</option>
        <option value="3">Baloncesto</option>
        <option value="3">Futbol</option>

    </select>

    <input type="date" 
    min="<?php echo htmlspecialchars($fecha_min); ?>"
    max="<?php echo htmlspecialchars($fecha_max); ?>" 
    value="<?php echo htmlspecialchars($fecha_min); ?>" name="fecha">

    <div class="opciones-grupo">
    <input type="radio" id="hora1" name="hora" value="10:00"/>
     <label for="hora1">10:00</label>
    <input type="radio" id="hora2" name="hora" value="12:00"/>
     <label for="hora2">12:00</label>
    <input type="radio" id="hora3" name="hora" value="16:00"/>
     <label for="hora3">16:00</label>
     <input type="radio" id="hora4" name="hora" value="20:00"/>
     <label for="hora4">20:00</label>
    </div>

    <label>Materiales</label>
    <input type="checkbox"  id="raqueta" name="raqueta">
    <label for="raqueta">Raqueta</label>
    <input type="checkbox"  id="balon_futbol" name="balon_futbol">
    <label for="balon_futbol">Balon de futbol</label>
    <input type="checkbox"  id="balon_baloncesto" name="balon_baloncesto">
    <label for="balon_baloncesto">Balon baloncesto</label>
    <input type="checkbox"  id="pelota_tenis" name="pelota_tenis">
    <label for="pelota_tenis">Pelota tenis</label>
    
    
   

    <label for="normas">¿Aceptas las normas?</label>
    <input type="checkbox" name="normas" value="normas">

   
    <input type="submit" value="Reservar">
</form>
</div>
