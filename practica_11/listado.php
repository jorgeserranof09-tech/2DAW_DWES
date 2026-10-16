<?php
require_once("functions.php");
?>


<head>
    <link rel="stylesheet" href="style/css.css">
</head>

<body>
    <div class="contenedor_listado">
        <h1>Listado de reservas</h1>
        <form method="post">
            <input type="date" id="fecha" name="fecha" />
            <select name="pista">
                <option>Elegir</option>
                <option value="1">Pádel 1</option>
                <option value="Pista 2">Pádel 2</option>
                <option value="3">Tenis</option>
                <option value="3">Baloncesto</option>
                <option value="3">Futbol</option>
            </select>
            <input type="submit" value="filtrar">
        </form>

        <div class="tabla_reservas">
            <table border='1'>
            <tr>
                <td>Nombre</td>
                <td>Correo</td>
                <td>Pista</td>
                <td>Fecha</td>
                <td>Hora</td>
            </tr>
            <tr>
            <?php tabla_reservas(); ?>
            </tr>
        </div>
    </div>
    </div>
</body>

</html>