<?php
class Calculadora
{
    public $EfectivoAnual = 0;
    public $NominalAnual = 0;
    public $PeriodicoVencido = 0;
    public $Dias=0;
    public $Periodo=0;

    public function __construct($periodo, $EA, $NA, $PV)
    {
        $this->Periodo = $periodo;
        switch ($periodo) {
      case 12:
        $this->Dias = 30;
        break;
      case 4:
        $this->Dias = 90;
        break;
      case 2:
        $this->Dias = 180;
        break;
      }
        $this->EfectivoAnual = $EA;
        $this->NominalAnual = $NA;
        $this->PeriodicoVencido = $PV;
    }

    public function obtenerNominalAnual()
    {
        $this->NominalAnual = $this->PeriodicoVencido * $this->Periodo;
    }
    public function obtenerPeriodicoVencidoDadoEA()
    {
        $this->PeriodicoVencido = ((pow((1 + ($this->EfectivoAnual / 100)), ($this->Dias / 360))) - 1) * 100;
    }
    public function obtenerPeriodicoVencidoDadoNA()
    {
        $this->PeriodicoVencido = $this->NominalAnual / $this->Periodo;
    }
    public function obtenerEfectivoAnual()
    {
        $this->EfectivoAnual = ((pow((1 + ($this->PeriodicoVencido / 100)), (360 / $this->Dias))) - 1) * 100;
    }
}
