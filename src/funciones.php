<?php



function dump($var)
{
  echo '<pre>' . print_r($var, 1) . '</pre>';
}


function getCSVContentInArray(String $rutaCSV, $definir_clave)
{


  $contenidoArchivo = trim(file_get_contents($rutaCSV));
  $lineasCSV = explode("\n", $contenidoArchivo);


  $encabezadoCadena = reset($lineasCSV);
  $encabezadoArray = explode(',', $encabezadoCadena);
  $encabezadoArrayNuevo = array_map('trim', $encabezadoArray);

  $coches = [];

  foreach ($lineasCSV as $clave => $linea) {
    if ($clave != 0) {
      $camposLinea = explode(',', $linea);

      $coche = array_combine($encabezadoArrayNuevo, $camposLinea);
      $coche = array_map('trim', $coche);

      $coches[$coche[$definir_clave]] = $coche;
    }
  }
  return $coches;
}

function imprimir_tabla($array_csv)
{
  echo "<table border='1'>";
  foreach ($array_csv as $indexado => $objeto) {
    echo "<tr>";
    foreach ($objeto as $clave => $valor) {

      if(terminaConImagen($valor)) {
        echo "<td><img src='src/" . $valor . "' height='350px' width='400px'></td>";
      }
      else if($valor==null) {
        echo "<td><img src='src/sin_imagen.png' height='350px' width='400px'></td>";
      } else {
        echo "<td>" . $valor . "</td>";
      }

    }
    echo "</tr>";
  }
  echo "</table>";
}



function terminaConImagen(string $cadena): bool {

  $formatos = '\.(jpg|jpeg|png|gif|webp|svg|bmp)$';
  
  return (bool) preg_match('/' . $formatos . '$/i', $cadena);
}