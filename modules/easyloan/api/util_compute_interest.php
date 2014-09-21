<?php

include_once 'util_global.php';

class Repayment
{
  public $total;
  public $count;
  public $r_amount;
  public $r_interest;
  public $w_amount;
  public $w_interest;
  public $n_date;
  public $n_amount;
  public $n_interest;
}

function compute_interest($amount, $rate, $method, $start, $end, $today)
{
  $date1 = new DateTime($start);
  $date2 = new DateTime($end);
  $date3 = new DateTime($today);
  if ($date2 <= $date1)
  {
    return null;
  }
  $interval = compute_date_diff($date1, $date2);
  $b = $rate / 12.0;
  $obj = new Repayment();
  switch ($method)
  {
    case 1:
      $interest = 0;
      if ($interval->y > 0) 
      {
        $interest += $interval->y * $amount * $rate;
      }
      if ($interval->m > 0)
      {
        $interest += $interval->m * $amount * $b;
      }
      if ($interval->d > 0)
      {
        $interest += $interval->d * $amount * $b / 30.0;
      }
      $interest = round($interest, 2);
      $obj->total = 1;
      if ($date2 > $date3)
      {
        $obj->count = 0;
        $obj->r_amount = 0;
        $obj->r_interest = 0;
        $obj->w_amount = $amount;
        $obj->w_interest = $interest;
        $obj->n_date = $end;
        $obj->n_amount = $amount;
        $obj->n_interest = $interest;
      }
      else
      {
        $obj->count = 1;
        $obj->r_amount = $amount;
        $obj->r_interest = $interest;
        $obj->w_amount = 0;
        $obj->w_interest = 0;
        $obj->n_date = null;
        $obj->n_amount = 0;
        $obj->n_interest = 0;
      }
      break;
    case 2:
      $total = 0;
      $interest = 0;
      if ($interval->y > 0)
      {
        $total += $interval->y * 12;
        $interest += $interval->y * $amount * $rate;
      }
      if ($interval->m > 0)
      {
        $total += $interval->m;
        $interest += $interval->m * $amount * $b;
      }
      if ($interval->d > 0)
      {
        $total += 1;
        $interest += $interval->d * $amount * $b / 30.0;
      }
      $interest = round($interest, 2);
      $obj->total = $total;
      if ($date2 > $date3)
      {
        $r_interval = new DateInterval('P0D');
        if ($date1 < $date3)
        {
          $r_interval = compute_date_diff($date1, $date3);
        }
        $count = 0;
        $r_interest = 0;
        if ($r_interval->y > 0) 
        {
          $count += $r_interval->y * 12;
          $r_interest += $r_interval->y * 12 * round($amount * $b, 2);
        }
        if ($r_interval->m > 0)
        {
          $count += $r_interval->m;
          $r_interest += $r_interval->m * round($amount * $b, 2);
        }
        $obj->count = $count;
        $obj->r_amount = 0;
        $obj->r_interest = $r_interest;
        $obj->w_amount = $amount;
        $obj->w_interest = $interest - $r_interest;
        if ($count + 1 == $total) 
        {
          $obj->n_date = $end;
          $obj->n_amount = $amount;
          $obj->n_interest = $interest - $r_interest;
        }
        else
        {
          $date4 = add_month($date1, ($count + 1));
          $obj->n_date = $date4->format('Y-m-d');
          $obj->n_amount = 0;
          $obj->n_interest = round($amount * $b, 2);
        }
      }
      else
      {
        $obj->count = $total;
        $obj->r_amount = $amount;
        $obj->r_interest = $interest;
        $obj->w_amount = 0;
        $obj->w_interest = 0;
        $obj->n_date = null;
        $obj->n_amount = 0;
        $obj->n_interest = 0;
      }
      break;
    case 3:
      $total = 0;
      $interest = 0;
      if ($interval->y > 0)
      {
        $total += $interval->y * 12;
        $interest += $interval->y * $amount * $rate;
      }
      if ($interval->m > 0)
      {
        $total += $interval->m;
        $interest += $interval->m * $amount * $b;
      }
      if ($interval->d > 0)
      {
        $total += 1;
        $interest += $interval->d * $amount * $b / 30.0;
      }
      $interest = round($interest, 2);
      $obj->total = $total;
      if ($date2 > $date3)
      {
        $r_interval = new DateInterval('P0D');
        if ($date1 < $date3)
        {
          $r_interval = compute_date_diff($date1, $date3);
        }
        $count = 0;
        $r_interest = round($amount * $b, 2); // initially deducted
        if ($r_interval->y > 0)
        {
          $count += $r_interval->y * 12;
          $r_interest += $r_interval->y * 12 * round($amount * $b, 2);
        }
        if ($r_interval->m > 0)
        {
          $count += $r_interval->m;
          $r_interest += $r_interval->m * round($amount * $b, 2);
        }
        $obj->count = $count;
        $obj->r_amount = 0;
        $obj->r_interest = $r_interest;
        $obj->w_amount = $amount;
        $obj->w_interest = $interest - $r_interest;
        if ($count + 1 == $total)
        {
            $obj->n_date = $end;
            $obj->n_amount = $amount;
            $obj->n_interest = 0;
        }
        else
        {
          $date4 = add_month($date1, ($count + 1));
            $obj->n_date = $date4->format('Y-m-d');
            $obj->n_amount = 0;
            if ($count + 2 == $total)
            {
              $obj->n_interest = $interest - $r_interest;
            }
            else
            {
              $obj->n_interest = round($amount * $b, 2);
            }
        }
      }
      else
      {
        $obj->count = $total;
        $obj->r_amount = $amount;
        $obj->r_interest = $interest;
        $obj->w_amount = 0;
        $obj->w_interest = 0;
        $obj->n_date = null;
        $obj->n_amount = 0;
        $obj->n_interest = 0;
      }
      break;
    case 4:
      $total = 0;
      if ($interval->y > 0)
      {
        $total += $interval->y * 12;
      }
      if ($interval->m > 0)
      {
        $total += $interval->m;
      }
      if ($interval->d > 15)
      {
        $total += 1;
      }
      $interest = round($amount * (($b * $total - 1) * pow((1 + $b), $total) + 1) / (pow((1 + $b), $total) - 1), 2);
      $obj->total = $total;
      if ($date2 > $date3)
      {
        $r_interval = new DateInterval('P0D');
        if ($date1 < $date3)
        {
          $r_interval = compute_date_diff($date1, $date3);
        }
        $count = 0;
        if ($r_interval->y > 0)
        {
          $count += $r_interval->y * 12;
        }
        if ($r_interval->m > 0)
        {
          $count += $r_interval->m;
        }
        $obj->count = $count;
        $r_amount = 0;
        $r_interest = 0;
        for ($i = 1; $i <= $count; $i++)
        {
          $r_amount += round($amount * $b * pow((1 + $b), ($i - 1)) / (pow((1 + $b), $total) - 1), 2);
          $r_interest += round($amount * $b * (pow((1 + $b), $total) - pow((1 + $b), ($i -1))) / (pow((1 + $b), $total) - 1), 2);
        }
        $obj->r_amount = $r_amount;
        $obj->r_interest = $r_interest;
        $obj->w_amount = $amount - $r_amount;
        $obj->w_interest = $interest - $r_interest;
        if ($count + 1 == $total)
        {
          $obj->n_date = $end;
          $obj->n_amount = $amount - $r_amount;
          $obj->n_interest = $interest - $r_interest;
        }
        else
        {
          $date4 = add_month($date1, ($count + 1));
          $obj->n_date = $date4->format('Y-m-d');
          $obj->n_amount = round($amount * $b * pow((1 + $b), $count) / (pow((1 + $b), $total) - 1), 2);
          $obj->n_interest = round($amount * $b * (pow((1 + $b), $total) - pow((1 + $b), $count)) / (pow((1 + $b), $total) - 1), 2);
        }
      }
      else
      {
        $obj->count = $total;
        $obj->r_amount = $amount;
        $obj->r_interest = $interest;
        $obj->w_amount = 0;
        $obj->w_interest = 0;
        $obj->n_date = null;
        $obj->n_amount = 0;
        $obj->n_interest = 0;
      }
      break;
    case 5:
      $total = 0;
      if ($interval->y > 0)
      {
        $total += $interval->y * 12;
      }
      if ($interval->m > 0)
      {
        $total += $interval->m;
      }
      if ($interval->d > 15)
      {
        $total += 1;
      }
      $interest = round($amount * $b * ($total + 1) / 2.0, 2);
      $obj->total = $total;
      if ($date2 > $date3)
      {
        $r_interval = new DateInterval('P0D');
        if ($date1 < $date3)
        {
          $r_interval = compute_date_diff($date1, $date3);
        }
        $count = 0;
        if ($r_interval->y > 0)
        {
          $count += $r_interval->y * 12;
        }
        if ($r_interval->m > 0)
        {
          $count += $r_interval->m;
        }
        $obj->count = $count;
        $r_amount = 0;
        $r_interest = 0;
        for ($i = 1; $i <= $count; $i++)
        {
          $r_amount += round($amount / $total, 2);
          $r_interest += round($amount * (1 - ($i - 1) / $total) * $b, 2);
        }
        $obj->r_amount = $r_amount;
        $obj->r_interest = $r_interest;
        $obj->w_amount = $amount - $r_amount;
        $obj->w_interest = $interest - $r_interest;
        if ($count + 1 == $total)
        {
          $obj->n_date = $end;
          $obj->n_amount = $amount - $r_amount;
          $obj->n_interest = $interest - $r_interest;
        }
        else
        {
          $date4 = add_month($date1, ($count + 1));
          $obj->n_date = $date4->format('Y-m-d');
          $obj->n_amount = round($amount / $total, 2);
          $obj->n_interest = round($amount * (1 - $count / $total) * $b, 2);
        }
      }
      else
      {
        $obj->count = $total;
        $obj->r_amount = $amount;
        $obj->r_interest = $interest;
        $obj->w_amount = 0;
        $obj->w_interest = 0;
        $obj->n_date = null;
        $obj->n_amount = 0;
        $obj->n_interest = 0;
      }
      break;
  }
  return $obj;
}
?>
