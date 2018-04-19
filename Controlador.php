<?php
require "Calculadora.php";
require "Tabuladora.php";

$Cal = new Calculadora($_GET['Periodicidad'], $_GET['EfectivoAnual'], $_GET['NominalAnual'], $_GET['PeriodicoVencido']);

if ($Cal->EfectivoAnual != 0) {
    $Cal->obtenerPeriodicoVencidoDadoEA();
    $Cal->obtenerNominalAnual();
} elseif ($Cal->NominalAnual != 0) {
    $Cal->obtenerPeriodicoVencidoDadoNA();
    $Cal->obtenerEfectivoAnual();
} elseif ($Cal->PeriodicoVencido != 0) {
    $Cal->obtenerNominalAnual();
    $Cal->obtenerEfectivoAnual();
}

$tabla = new Tabuladora($Cal->Periodo, $_GET['Plazo'], $_GET['Monto'], $Cal->PeriodicoVencido);
//echo "Cuotas: ",$tabla->Cuotas,". Monto: ", $tabla->Monto,". Cuota Fija: ",$tabla->CuotaFija, ". Periodico Vencido", $tabla->PeriodicoVencido;
$tabla->tabular();
echo "<p hidden>{\"EA\":\"",$Cal->EfectivoAnual,"\", \"NA\": \"",$Cal->NominalAnual,"\", \"PV\": \"",$Cal->PeriodicoVencido,"\"}";
