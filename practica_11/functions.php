<?php

function tabla_reservas()
{
    $reservas = obtener_datos();
    $pista = filter_input(INPUT_POST, "pista") ?? "Elegir";
    $fecha = filter_input(INPUT_POST, "fecha") ?? "";

    foreach ($reservas as $reserva) {

        if (($pista == "Elegir" || $pista == "" || $reserva["pista"] == $pista) &&
            ($fecha == "" || $reserva["fecha"] == $fecha)
        ) {
            echo "<tr>";

            foreach ($reserva as $dato) {
                echo "<td>" . htmlspecialchars($dato) . "</td>";
            }

            echo "</tr>";
        }
    }
}

function verificar_crear_reserva()
{

    /**
     * mb_strlen: Devuelve la cantidad de caracteres
     * 
     * filter_validate_email: Valida correo
     */


    if (!isset($_POST["enviar"])) {
        return;
    }
    if ($_SERVER["REQUEST_METHOD"] != "POST") {
        return;
    }

    $nombre = filter_input(INPUT_POST, "nombre");
    $email = filter_input(INPUT_POST, "email");
    $pista = filter_input(INPUT_POST, "pista");
    $fecha = filter_input(INPUT_POST, "fecha");
    $hora =  filter_input(INPUT_POST, "hora");
    $materiales = [];
    $normas = isset($_POST["normas"]);

    if (isset($_POST["raquetas"])) {
        $materiales[] = "Raquetas";
    }

    if (isset($_POST["balon_futbol"])) {
        $materiales[] = "Balón";
    }

    if (isset($_POST["petos"])) {
        $materiales[] = "Petos";
    }


    /**VALIDACION DE CAMPO NOMBRE */

    if ($nombre == "") {
        $error["nombre"] = "El nombre no puede estar vacío";
    } elseif (
        mb_strlen($nombre, "UTF-8") < 2 ||
        mb_strlen($nombre, "UTF-8") > 60
    ) {
        $error["nombre"] = "El nombre debe contener de 2 a 60 caracteres";
    }


    /**VALIDACION DE CAMPO EMAIL */

    if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error["email"] = "El email no es válido";
    }



    /**Valida que no haya errores y comprueba la disponibilidad */
    if (empty($error)) {
        if (!comprobar_disponibilidad_pista($pista, $fecha, $hora)) {
            $error["disponibilidad"] = "La pista no está disponible";
        }
    }


    /** En caso de que comprobar_disponilidad sea false */
    if (empty($error)) {
        guardar_datos_reserva($nombre, $email, $pista, $fecha, $hora, $materiales);

        echo "<p>Reserva guardada correctamente.</p>";
    } else {
        foreach ($error as $mensaje) {
            echo "<p>" . htmlspecialchars($mensaje) . "</p>";
        }
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
    $contenidoArchivo = trim(file_get_contents(__DIR__ . "/datos/reservas.csv"));
    $lineasCSV = explode("\n", $contenidoArchivo);

    $encabezadoCadena = reset($lineasCSV);
    $encabezadoArray = str_getcsv($encabezadoCadena);
    $encabezadoArrayNuevo = array_map('trim', $encabezadoArray);

    $reservas = [];

    foreach ($lineasCSV as $clave => $linea) {
        if ($clave != 0 && trim($linea) != "") {
            $camposLinea = str_getcsv(trim($linea));

            if (count($encabezadoArrayNuevo) == count($camposLinea)) {
                $reserva = array_combine($encabezadoArrayNuevo, $camposLinea);
                $reserva = array_map('trim', $reserva);
                $reservas[] = $reserva;
            }
        }
    }


    return $reservas;
}

function guardar_datos_reserva(string $nombre, string $email, string $pista, string $fecha, string $hora, array $materiales)
{
    $datos = [$nombre, $email, $pista, $fecha, $hora, implode("-", $materiales)];

    $fp = fopen("datos/reservas.csv", "a");

    fputcsv($fp, $datos, ",", '"', "");

    fclose($fp);
}


function toast($error)
{
    $array = [
        "nombre" => "Nombre invalido",
        "email" => "Email invalido",
        "pista" => "pista no disponible en la fecha seleccionada"
    ];
}
