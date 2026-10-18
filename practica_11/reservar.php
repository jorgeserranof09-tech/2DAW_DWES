<?php
require_once("functions.php");
$fecha_min = date("Y-m-d");
$fecha_max = date("Y-m-d", strtotime($fecha_min . ' + 14 days'));


verificar_crear_reserva();
?>






<link rel="stylesheet" href="style/css.css">
<div class="contenedor_reserva">
    <h1>Formulario de reserva</h1>
    <p>Porfavor rellena el siguiente formulario</p>
    <form method="post">
        <input type="text" name="nombre" placeholder="Nombre">

        <input type="email" name="email" placeholder="Email">

        <select id="pista" name="pista">
            <option selected="true" disabled="disabled">seleccione una pista</option>
            <option value="Pádel 1">Pádel 1</option>
            <option value="Pádel 2">Pádel 2</option>
            <option value="Tenis">Tenis</option>
            <option value="Baloncesto">Baloncesto</option>
        </select>

        <input type="date"
            min="<?php echo htmlspecialchars($fecha_min); ?>"
            max="<?php echo htmlspecialchars($fecha_max); ?>"
            value="<?php echo htmlspecialchars($fecha_min); ?>" name="fecha">

        <div class="opciones-grupo">
            <input type="radio" id="hora1" name="hora" value="16:00" />
            <label for="hora1">16:00</label>

            <input type="radio" id="hora2" name="hora" value="17:00" />
            <label for="hora2">17:00</label>

            <input type="radio" id="hora3" name="hora" value="18:00" />
            <label for="hora3">18:00</label>

            <input type="radio" id="hora4" name="hora" value="19:00" />
            <label for="hora4">19:00</label>

            <input type="radio" id="hora5" name="hora" value="20:00" />
            <label for="hora5">20:00</label>

            <input type="radio" id="hora6" name="hora" value="21:00" />
            <label for="hora6">21:00</label>
        </div>

        <label><strong>Materiales</strong></label>
        <div class="materiales">
            <input type="checkbox" id="raquetas" name="raquetas">
            <label for="raquetas">Raquetas</label>
            <input type="checkbox" id="balon" name="balon_futbol">
            <label for="balon">Balón</label>
            <input type="checkbox" id="petos" name="petos">
            <label for="petos">Petos</label>
        </div>



        <label for="normas">¿Aceptas las normas?</label>
        <input type="checkbox" name="normas" value="normas" required>


        <input type="submit" value="Reservar" name="enviar">
    </form>
</div>