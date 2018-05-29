<?php
class Tabuladora
{
    public $Cuotas = 0;
    public $CuotaFija = 0;
    public $Monto = 0;
    public $PeriodicoVencido = 0;
    public $Dias = 0;
    public $Periodo = 0;

    public function __construct($periodo, $plazo, $monto, $PV)
    {
        $this->Periodo = $periodo;
        $this->Cuotas = $periodo * $plazo;
        $this->Monto = $monto;
        $this->CuotaFija = $this->Monto * (((pow((1 + ($PV / 100)), $this->Cuotas)) * ($PV / 100))/((pow((1 + ($PV / 100)), $this->Cuotas)) - 1));
        $this->PeriodicoVencido = $PV;
    }

    public function tabular()
    {
        $meses = 0;
        switch ($this->Periodo) {
        case 2:
          $meses = 6;
          break;
        case 4:
          $meses = 3;
          break;
        case 12:
          $meses = 1;
          break;
      }

        $fecha = new DateTime();
        $Intervalo = 'P' . $meses .'M';
        $tabla=array();
        for ($i=0; $i <= $this->Cuotas ; $i++) {
            $tabla[$i]=array();
            if ($i==0) {
                array_push($tabla[$i], $i, $fecha->format('d/m/Y'), $this->Monto, 0, 0, 0, 0);
                $fecha->add(new DateInterval($Intervalo));
            } else {
                $AmorInteres = $tabla[$i-1][2] * ($this->PeriodicoVencido / 100);
                $AmorCapital = $this->CuotaFija - $AmorInteres;
                $SaldoCapital = $tabla[$i-1][2] - $AmorCapital;
                if ($SaldoCapital < 0) {
                    $SaldoCapital = 0;
                }
                array_push($tabla[$i], $i, $fecha->format('d/m/Y'), $SaldoCapital, $this->CuotaFija, $AmorCapital, $AmorInteres, $this->CuotaFija);
                $fecha->add(new DateInterval($Intervalo));
            }
        }
        echo "<table class=\"table table-bordered\"style=\"background-color:white\" id =\"tabla\">";
        echo "<tr><th>Cuota</th><th>Fecha</th><th>Saldo Capital</th><th>Cuota Fija</th><th>Amortizacion a Capital</th><th>Amortizacion o interes</th><th>Flujo de caja</th>";
        for ($i=0; $i <count($tabla) ; $i++) {
            echo "<tr>";
            for ($j=0; $j <count($tabla[$i]) ; $j++) {
                if (strpos($tabla[$i][$j], '/')) {
                    echo "<td>",$tabla[$i][$j],"</td>";
                } else {
                    echo "<td>",intval($tabla[$i][$j]),"</td>";
                }
            }
            echo "</tr>";
        }
        echo "</table>";
        echo "<div class=\"form-group\">";
        echo "<label for=\"sel1\">Cuota:</label>";
        echo "<select class=\"form-control\" id=\"seleccionarcuota\">";
        for ($i=0; $i <count($tabla)-1; $i++) {
            echo "<option>",$i+1,"</option>";
        }
        echo "</select>";
        echo "</div>";
        echo "<div class=\"form-group\">";
        echo "<label for=\"diapago\">Día de pago:</label>";
        echo "<input type=\"date\" name=\"diapago\" id=\"diapago\" class=\"form-control\" ng-model=\"diapago\">";
        echo "</div>";
        echo "<button type=\"button\" class=\"btn btn-primary btn-block\" id=\"mora\" onclick=\"ajaxConnect2(seleccionarcuota.value, diapago.value)\">Calcular mora</button>";
        echo "<div id=\"respuestaMora\"></div>";
    }
}
