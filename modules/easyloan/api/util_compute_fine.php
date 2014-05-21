<?php

function compute_fine($owned, $fine, $rate, $is_single, $days)
{
  $fine_increment = 0;
  if ($days > 0)
  {
    if ($is_single)
    {
      $fine_increment = $owned * $rate * $days;
    }
    else
    {
      $sum = $owned + $fine;
      for ($i = 0; $i < $days; $i++)
      {
        $sum *= (1 + $rate);
      }
      $fine_increment = $sum - $owned - $fine;
    }
  }
  return round($fine_increment, 2);
}
?>
