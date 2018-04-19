<?php
class Tabuladora
{
    public $Cuotas = 0;
    public $CuotaFija = 0;
    public $Monto = 0;
    public $PeriodicoVencido = 0;

    public function __construct($periodo, $plazo, $monto, $PV)
    {
        $this->Cuotas = $periodo * $plazo;
        $this->Monto = $monto;
        $this->CuotaFija = $this->Monto * (((pow((1 + ($PV / 100)), $this->Cuotas)) * ($PV / 100))/((pow((1 + ($PV / 100)), $this->Cuotas)) - 1));
        $this->PeriodicoVencido = $PV;
    }

    public function tabular()
    {
        $tabla=array();
        for ($i=0; $i <= $this->Cuotas ; $i++) {
            $tabla[$i]=array();
            if ($i==0) {
                array_push($tabla[$i], $i, $this->Monto, 0, 0, 0, 0);
            } else {
                $AmorInteres = $tabla[$i-1][1] * ($this->PeriodicoVencido / 100);
                $AmorCapital = $this->CuotaFija - $AmorInteres;
                $SaldoCapital = $tabla[$i-1][1] - $AmorCapital;
                if ($SaldoCapital < 0) {
                  $SaldoCapital = 0;
                }
                array_push($tabla[$i], $i, $SaldoCapital, $this->CuotaFija, $AmorCapital, $AmorInteres, $this->CuotaFija);
            }
        }
        echo "<table class=\"table table-bordered\"style=\"background-color:white\">";
        echo "<tr><th>Cuota</th><th>Saldo Capital</th><th>Cuota Fija</th><th>Amortizacion a Capital</th><th>Amortizacion o interes</th><th>Flujo de caja</th>";
        for ($i=0; $i <count($tabla) ; $i++) {
          echo "<tr>";
          for ($j=0; $j <count($tabla[$i]) ; $j++) {
            echo "<td>",intval($tabla[$i][$j]),"</td>";
          }
          echo "</tr>";
        }
        echo "</table>";
        //print_r($tabla);
    }
}
