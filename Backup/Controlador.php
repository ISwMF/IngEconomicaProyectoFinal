<?php
require "Calculadora.php";
require "Tabuladora.php";

if (isset($_GET['Periodicidad'])) {
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
}

if (isset($_GET['NumCuota'])) {
    $FechaCuota = new DateTime($_GET['FechaCuota']);
    $FechaRetardo =  new DateTime($_GET['Fecha']);
    $Retardo = $FechaCuota->diff($FechaRetardo);
    $DiasdeRetardo = $Retardo->format('%a');
    $Cal =  new Calculadora(0, 0, 0, 0);
    $IP = $Cal->calcularInteresPeriodico($DiasdeRetardo);
    $Mora = $Cal->calcularInteresMoratorio($IP, $_GET['Saldo']);
    echo "<br>";
    echo "<div class=\"form-group\">";
    echo "<div class=\"col-sm-12\">";
    echo "<label for=\"retardo\">Dias de retardo:</label>";
    echo "<input type=\"text\" name=\"retardo\" id=\"retardo\" class=\"form-control\" ng-model=\"retardo\" value=\"",$DiasdeRetardo,"\"  readonly>";
    echo "</div>";
    echo "</div>";
    echo "<div class=\"form-group\">";
    echo "<div class=\"col-sm-10\">";
    echo "<label for=\"IP\">Interes Periodico:</label>";
    echo "<input type=\"text\" name=\"IP\" id=\"IP\" class=\"form-control\" ng-model=\"IP\" value=\"",$IP,"\"  readonly>";
    echo "</div>";
    echo "<div class=\"col-sm-2\" style=\"text-align:center\"><br><h4>%</h4></div>";
    echo "</div>";
    echo "<br>";
    echo "<br>";
    echo "<div class=\"col-sm-12\" style=\"text-align:center\"><p>.</p></div>";
    echo "<table class=\"table table-bordered\"style=\"background-color:white\" id =\"tablaMora\">";
    echo "<tr><th># Cuota</th><th>Fecha de Retraso</th><th>Cuota Fija</th><th>Interes de Mora</th><th>Flujo de caja</th></tr>";
    echo "<tr><td>", $_GET['NumCuota'],  "</td><td>",$FechaRetardo->format('d/m/Y'),"</td><td>",$_GET['CuotaFija'],"</td><td>",intval($Mora),"</td><td>",intval($_GET['CuotaFija'] + $Mora),"</td></tr>";
    echo "</table>";
    //echo "Ha llegado algo: Cuota # ", $_GET['NumCuota'] , ", Fecha de retardo: ", $_GET['Fecha'], ", Fecha de cuota: ", $_GET['FechaCuota'], ", Saldo: ", $_GET['Saldo'];
}
