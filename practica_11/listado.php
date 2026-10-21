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
                <option value="Pádel 1">Pádel 1</option>
                <option value="Pádel 2">Pádel 2</option>
                <option value="Tenis">Tenis</option>
                <option value="Baloncesto">Baloncesto</option>
            </select>
            <input type="submit" value="filtrar">
            <a href="./listado.php">Reset</a>
        </form>

        <div class="tabla_reservas">
            <table border='1'>
            <tr>
                <td>Nombre</td>
                <td>Correo</td>
                <td>Pista</td>
                <td>Fecha</td>
                <td>Hora</td>
                <td>Materiales</td>
            </tr>
            <tr>
            <?php tabla_reservas(); ?>
            </tr>
        </div>
    </div>
    </div>
</body>

</html>