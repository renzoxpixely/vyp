<?php

function fecha($fechadata) {
    $fecha = explode("-", $fechadata);
    $dia = $fecha[2];
    $mes = $fecha[1];
    $year = $fecha[0];
    $fecharesult = $dia . '/' . $mes . '/' . $year;
    return $fecharesult;
}

function fecha1($fechadata) {
    $fecha = explode("/", $fechadata);
    $dia = $fecha[0];
    $mes = $fecha[1];
    $year = $fecha[2];
    $fecharesult = $year . '-' . $mes . '-' . $dia;
    return $fecharesult;
}

function stockcaja($stock, $factor) {
    $convert1 = $stock / $factor;
    $caja = ((int) ($convert1));
    $unidad = ($stock - ($caja * $factor));
    $stocknuevo = $caja . "<b>C </b>" . $unidad;
    return $stocknuevo;
}

?>