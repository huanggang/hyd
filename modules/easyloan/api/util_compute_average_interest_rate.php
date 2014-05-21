<?php

class AverageInterestRate
{
  public $cr1;
  public $cd1;
}

function compute_average_interest_rate($ca0, $cr0, $cd0, $a1, $r1, $d1)
{
  $obj = new AverageInterestRate();
  $obj->cr1 = $cr0;
  $obj->cd1 = $cd0;
  if ($ca0 > 0 && $a1 > 0)
  {
    $cr1 = ($cr0 * $ca0 * $cd0 + $r1 * $a1 * $d1) / ($ca0 * $cd0 + $a1 * $d1);
    $cd1 = ($ca0 * $cd0 + $a1 * $d1) / ($ca0 + $a1);
    $obj->cr1 = round($cr1, 4);
    $obj->cd1 = round($cd1, 4);
  }
  return $obj;
}
?>
