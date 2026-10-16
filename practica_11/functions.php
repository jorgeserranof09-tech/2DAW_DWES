<?php

function tabla_reservas() {
    $reservas = obtener_datos();
    $pista = filter_input(INPUT_POST, "pista");
    $fecha = filter_input(INPUT_POST, "fecha");
  
    if ($pista && $pista != "Elegir") {
        $array_filtrado = array_filter($reservas, function ($dato) use ($pista) {
            return $dato["pista"] == $pista;
        });
        foreach ($array_filtrado as $reserva) {
            echo "<tr>";
            foreach ($reserva as $clave => $dato) {
                echo "<td>" . htmlspecialchars($dato) . "</td>";
            }
            echo "</tr>";
        }
    } else if ($fecha) {
        $array_filtrado = array_filter($reservas, function ($dato) use ($fecha) {
            return $dato["fecha"] == $fecha;
        });
        foreach ($array_filtrado as $reserva) {
            echo "<tr>";
            foreach ($reserva as $clave => $dato) {
                echo "<td>" . htmlspecialchars($dato) . "</td>";
            }
            echo "</tr>";
        }
    } else {
        for ($i = 1; $i < count($reservas); $i++) {
            foreach ($reservas[$i] as $reserva => $dato) {
                echo "<td>" . $dato . "</td>";
            }
            echo "</tr>";
        }
    }
}






function validar_datos()
{
    $nombre = filter_input(INPUT_POST,"nombre");
    $email = filter_input(INPUT_POST,"email");
    $pista = filter_input(INPUT_POST,"pista");
    $fecha = filter_input(INPUT_POST,"fecha");
    $hora =  filter_input(INPUT_POST,"hora");
    $normas = filter_input(INPUT_POST,"normas");



    if($nombre) {
        if (mb_strlen($nombre, 'UTF-8') < 2 || mb_strlen($nombre, 'UTF-8') > 60) {
            $error["nombre"] = "Nombre invalido";
        } else if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            $error["email"] = "Correo invalido";
        } else if()
    }
    /**
     * 
     * mb_strlen Devuelve la cantidad de caracteres
     * 
     * filter_validate_email Valida correo
     * 
     */


    if (isset($nombre, $email)) {
        if (mb_strlen($nombre, 'UTF-8') < 2 || mb_strlen($nombre, 'UTF-8') > 60) {
            //header("Location: reservar.php");
            echo "El nombre no puede tener menos de 2 caracteres o mas de 60";
        } else if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            echo "Correo electronico mal";
        }
    }
}




function validarNormas($normas)
{
    if (!isset($_POST['normas']['0']) && !isset($_POST['normas']['1']) && !isset($_POST['normas']['2'])) {
        //toast("Debes aceptar todas las normas"); 
        echo '<script type="text/javascript">';
        echo 'console.log("QUE FALLA")';
        echo '</script>';
    } else {
        for ($i = 0; $i < count($normas); $i++) { ?>
            <label>
                <input type="checkbox" name="normas[<?php echo htmlspecialchars($i); ?>]" value="normas<?php echo htmlspecialchars($i); ?>">
                <?php echo htmlspecialchars($normas[$i]); ?>
            </label>
<?php }
    }
}


function comprobar_disponibilidad_pista(string $pista, string $fecha, string $hora)
{
    $reservas = obtener_datos();

    foreach ($reservas as $reserva) {
        if ($reserva['pista'] == $pista && $reserva['fecha'] == $fecha && $reserva['hora'] == $hora) {
            return false;
        }
    }

    return true;
}


function obtener_datos()
{
    $contenidoArchivo = trim(file_get_contents("datos/reservas.csv"));
    $lineasCSV = explode("\n", $contenidoArchivo);


    $encabezadoCadena = reset($lineasCSV);
    $encabezadoArray = explode(',', $encabezadoCadena);
    $encabezadoArrayNuevo = array_map('trim', $encabezadoArray);

    $reservas = [];

    foreach ($lineasCSV as $clave => $linea) {
        if ($clave != 0) {
            $camposLinea = explode(',', $linea);
            $reserva = array_combine($encabezadoArrayNuevo, $camposLinea);
            $reserva = array_map('trim', $reserva);

            $reservas[] = $reserva;
        }
    }
    return $reservas;
}



function toast($error)
{
    $array = [
        "nombre" => "Nombre invalido",
        "email" => "Email invalido",
        "pista" => "pista no disponible en la fecha seleccionada"
    ];
}
?>