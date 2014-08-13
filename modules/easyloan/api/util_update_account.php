<?php

include_once 'util_global.php';
include_once 'util_compute_interest.php';
include_once 'util_compute_average_interest_rate.php';
include_once 'util_compute_fine.php';

function update_account($id)
{
  global $db_host, $db_user, $db_pwd, $db_name;
  $con=mysqli_connect($db_host, $db_user, $db_pwd, $db_name);
  if (mysqli_connect_errno())
  {
    return false;
  }
  mysqli_set_charset($con, "UTF8");

  $flag = false;
  $is_owned = false;
  $todayStr = date("Y-m-d");
  $today = new DateTime($todayStr);// date_create_from_format('Y-m-d', $todayStr);
  $now = new DateTime;
  $nowStr = $now->format("Y-m-d\TH:i:sP");

  mysqli_autocommit($con, false);
  mysqli_query($con, "LOCK TABLES account_loan_act_ln WRITE, loans_lns WRITE, account_money_act_mny WRITE, account_transactions_act_trn WRITE");
  
  $result = mysqli_query($con, "SELECT act_ln_app_id, act_ln_amount, act_ln_interest, act_ln_fine, act_ln_interest_rate, act_ln_duration, act_ln_loans, act_ln_total, act_ln_count, act_ln_r_amount, act_ln_r_interest, act_ln_w_amount, act_ln_w_interest, act_ln_n_date, act_ln_n_amount, act_ln_n_interest, act_ln_w_owned, act_ln_w_fine, act_ln_updated FROM account_loan_act_ln WHERE act_ln_usr_id=".strval($id)." AND act_ln_app_id IS NOT NULL AND act_ln_updated < ".sqlstr($nowStr));
  if ($row = mysqli_fetch_array($result)) // has unfinished loans
  {
    $act_ln_app_id = $row['act_ln_app_id'];
    $act_ln_amount = $row['act_ln_amount'];
    $act_ln_interest = $row['act_ln_interest'];
    $act_ln_fine = $row['act_ln_fine'];
    $act_ln_interest_rate = $row['act_ln_interest_rate'];
    $act_ln_duration = $row['act_ln_duration'];
    $act_ln_loans = $row['act_ln_loans'];
    $act_ln_total = $row['act_ln_total'];
    $act_ln_count = $row['act_ln_count'];
    $act_ln_r_amount = $row['act_ln_r_amount'];
    $act_ln_r_interest = $row['act_ln_r_interest'];
    $act_ln_w_amount = $row['act_ln_w_amount'];
    $act_ln_w_interest = $row['act_ln_w_interest'];
    $act_ln_n_date = $row['act_ln_n_date'];
    $act_ln_n_amount = $row['act_ln_n_amount'];
    $act_ln_n_interest = $row['act_ln_n_interest'];
    $act_ln_w_owned = $row['act_ln_w_owned'];
    $act_ln_w_fine = $row['act_ln_w_fine'];
    $act_ln_updated = $row['act_ln_updated'];
    mysqli_free_result($result);

    $result = mysqli_query($con, "SELECT lns_amount, lns_interest_rate, lns_repayment_method, lns_duration, lns_start, lns_end, lns_fine_rate, lns_fine_rate_is_single, lns_fine, lns_updated FROM loans_lns WHERE lns_app_id=".strval($act_ln_app_id));
    $row = mysqli_fetch_array($result);
    $lns_amount = $row['lns_amount'];
    $lns_interest_rate = $row['lns_interest_rate'];
    $lns_repayment_method = $row['lns_repayment_method'];
    $lns_duration = $row['lns_duration'];
    $lns_start = $row['lns_start'];
    $lns_end = $row['lns_end'];
    $lns_fine_rate = $row['lns_fine_rate'];
    $lns_fine_rate_is_single = $row['lns_fine_rate_is_single'];
    $lns_fine = $row['lns_fine'];
    $lns_updated = $row['lns_updated'];
    mysqli_free_result($result);

    $result = mysqli_query($con, "SELECT act_mny_available, act_mny_frozen, act_mny_investment, act_mny_loaned, act_mny_interest, act_mny_is_owned, act_mny_owned, act_mny_fine, act_mny_total, act_mny_updated FROM account_money_act_mny WHERE act_mny_usr_id=".strval($id));
    $row = mysqli_fetch_array($result);
    $act_mny_available = $row['act_mny_available'];
    $act_mny_frozen = $row['act_mny_frozen'];
    $act_mny_investment = $row['act_mny_investment'];
    $act_mny_loaned = $row['act_mny_loaned'];
    $act_mny_interest = $row['act_mny_interest'];
    $act_mny_is_owned = $row['act_mny_is_owned'];
    $act_mny_owned= $row['act_mny_owned'];
    $act_mny_fine = $row['act_mny_fine'];
    $act_mny_total = $row['act_mny_total'];
    $act_mny_updated = $row['act_mny_updated'];
    mysqli_free_result($result);

    $flag = true;
    if ((new DateTime($act_ln_n_date)) <= $today) // it is the time to repay
    {
      $act_mny_available = $act_mny_available - ($act_ln_n_amount + $act_ln_n_interest);
      $interest = compute_interest($lns_amount, $lns_interest_rate, $lns_repayment_method, $lns_start, $lns_end, $todayStr);
      if ($act_mny_available >= 0) // not owning anything
      {
        if ($act_ln_n_interest > 0)
        {
          $flag = $flag && (mysqli_query($con, "INSERT INTO account_transactions_act_trn (act_trn_usr_id, act_trn_time, act_trn_type, act_trn_amount, act_trn_available, act_trn_owned, act_trn_fine, act_trn_note) VALUES (".sqlstrval($id).", ".sqlstr($todayStr).", 9, ".sqlstrval($act_ln_n_interest).", ".sqlstrval($act_mny_available + $act_mny_frozen + $act_ln_n_amount).", 0, 0, NULL)") != false);
        }
        if ($act_ln_n_amount > 0)
        {
          $flag = $flag && (mysqli_query($con, "INSERT INTO account_transactions_act_trn (act_trn_usr_id, act_trn_time, act_trn_type, act_trn_amount, act_trn_available, act_trn_owned, act_trn_fine, act_trn_note) VALUES (".sqlstrval($id).", ".sqlstr($todayStr).", 8, ".sqlstrval($act_ln_n_amount).", ".sqlstrval($act_mny_available + $act_mny_frozen).", 0, 0, NULL)") != false);
        }
        $act_mny_total = compute_money_total($act_mny_available, $act_mny_frozen, $act_mny_investment, $interest->w_amount, $interest->w_interest, $act_mny_owned, $act_mny_fine);
        $flag = $flag && (mysqli_query($con, "UPDATE account_money_act_mny SET act_mny_available = ".sqlstrval($act_mny_available).", act_mny_loaned = ".sqlstrval($interest->w_amount).", act_mny_interest = ".sqlstrval($interest->w_interest).", act_mny_total = ".sqlstrval($act_mny_total).", act_mny_updated = ".sqlstr($nowStr)." WHERE act_mny_usr_id = ".strval($id)) != false);
        if (is_null($interest->n_date)) // finished loan
        {
          $rate = compute_average_interest_rate($act_ln_amount, $act_ln_interest_rate, $act_ln_duration, $lns_amount, $lns_interest_rate, round($lns_duration/12.0, 4));
          $flag = $flag && (mysqli_query($con, "UPDATE account_loan_act_ln SET act_ln_amount = ".sqlstrval($act_ln_amount + $lns_amount).", act_ln_interest = ".sqlstrval($act_ln_interest + $interest->r_interest).", act_ln_fine = ".sqlstrval($act_ln_fine + $lns_fine).", act_ln_interest_rate = ".sqlstrval($rate->cr1).", act_ln_duration = ".sqlstrval($rate->cd1).", act_ln_loans = ".sqlstrval($act_ln_loans + 1).", act_ln_app_id = NULL, act_ln_total = 0, act_ln_count = 0, act_ln_r_amount = 0, act_ln_r_interest = 0, act_ln_w_amount = 0, act_ln_w_interest = 0, act_ln_n_date = NULL, act_ln_n_amount = 0, act_ln_n_interest = 0, act_ln_w_owned = 0, act_ln_w_fine = 0, act_ln_updated = ".sqlstr($nowStr)." WHERE act_ln_usr_id = ".strval($id)) != false);
          $flag = $flag && (mysqli_query($con, "UPDATE loans_lns SET lns_finished = ".sqlstr($todayStr).", lns_updated = ".sqlstr($nowStr)." WHERE lns_app_id = ".strval($id)) != false);
        }
        else // loan is not finished yet
        {
          $flag = $flag && (mysqli_query($con, "UPDATE SET act_ln_r_amount = ".sqlstrval($interest->r_amount).", act_ln_r_interest = ".sqlstrval($interest->r_interest).", act_ln_w_amount = ".sqlstrval($interest->w_amount).", act_ln_w_interest = ".sqlstrval($interest->w_interest).", act_ln_n_date = ".sqlstr($interest->n_date).", act_ln_n_amount = ".sqlstrval($interest->n_amount).", act_ln_n_interest = ".sqlstrval($interest->n_interest).", act_ln_w_owned = 0, act_ln_w_fine = 0, act_ln_updated = ".sqlstr($nowStr)." WHERE act_ln_usr_id = ".strval($id)) != false);
        }
      }
      else // has been owned or just owned
      {
        $is_owned = true;
        $act_trn_owned = 0;
        $act_trn_fine = 0;
        if ($act_mny_is_owned) // has been owned
        {
          $days = (new DateTime($act_mny_updated))->diff($act_ln_n_date)->days;
          if ($days > 0)
          {
            $delta_fine = compute_fine($act_mny_owned, $act_mny_fine, $lns_fine_rate, $lns_fine_rate_is_single, $days);
            $act_trn_owned = $act_mny_owned;
            $act_trn_fine = $act_mny_fine + $delta_fine;
            $flag = $flag && (mysqli_query($con, "INSERT INTO account_transactions_act_trn (act_trn_usr_id, act_trn_time, act_trn_type, act_trn_amount, act_trn_available, act_trn_owned, act_trn_fine, act_trn_note) VALUES (".sqlstrval($id).", ".sqlstr($todayStr).", 10, ".sqlstrval($delta_fine).", ".sqlstrval($act_mny_frozen).", ".sqlstrval($act_trn_owned).", ".sqlstrval($act_trn_fine).", NULL)") != false);
          }
          if ($act_ln_n_interest > 0)
          {
            $act_trn_owned += $act_ln_n_interest;
            $flag = $flag && (mysqli_query($con, "INSERT INTO account_transactions_act_trn (act_trn_usr_id, act_trn_time, act_trn_type, act_trn_amount, act_trn_available, act_trn_owned, act_trn_fine, act_trn_note) VALUES (".sqlstrval($id).", ".sqlstr($todayStr).", 9, ".sqlstrval($act_ln_n_interest).", ".sqlstrval($act_mny_frozen).", ".sqlstrval($act_trn_owned).", ".sqlstrval($act_trn_fine).", NULL)") != false);
          }
          if ($act_ln_n_amount > 0)
          {
            $act_trn_owned += $act_ln_n_amount;
            $flag = $flag && (mysqli_query($con, "INSERT INTO account_transactions_act_trn (act_trn_usr_id, act_trn_time, act_trn_type, act_trn_amount, act_trn_available, act_trn_owned, act_trn_fine, act_trn_note) VALUES (".sqlstrval($id).", ".sqlstr($todayStr).", 8, ".sqlstrval($act_ln_n_amount).", ".sqlstrval($act_mny_frozen).", ".sqlstrval($act_trn_owned).", ".sqlstrval($act_trn_fine).", NULL)") != false);
          }
          $days = str2date($act_ln_n_date)->diff($today)->days;
          if ($days > 0)
          {
            $delta_fine = compute_fine($act_trn_owned, $act_trn_fine, $lns_fine_rate, $lns_fine_rate_is_single, $days);
            $act_trn_fine += $delta_fine;
            $flag = $flag && (mysqli_query($con, "INSERT INTO account_transactions_act_trn (act_trn_usr_id, act_trn_time, act_trn_type, act_trn_amount, act_trn_available, act_trn_owned, act_trn_fine, act_trn_note) VALUES (".sqlstrval($id).", ".sqlstr($todayStr).", 10, ".sqlstrval($delta_fine).", ".sqlstrval($act_mny_frozen).", ".sqlstrval($act_trn_owned).", ".sqlstrval($act_trn_fine).", NULL)") != false);
          }
        }
        else // just owned
        {
          $act_mny_available += $act_ln_n_interest + $act_ln_n_amount; // restore the value
          $act_trn_available = $act_mny_available + $act_mny_frozen;
          if ($act_ln_n_interest > 0)
          {
            if (($act_mny_available - $act_ln_n_interest) < 0)
            {
              $act_trn_available = $act_mny_frozen;
              $act_trn_owned = $act_ln_n_interest - $act_mny_available;
              $act_mny_available = 0;
            }
            else
            {
              $act_trn_available = $act_trn_available - $act_ln_n_interest;
              $act_mny_available = $act_mny_available - $act_ln_n_interest;
            }
            $flag = $flag && (mysqli_query($con, "INSERT INTO account_transactions_act_trn (act_trn_usr_id, act_trn_time, act_trn_type, act_trn_amount, act_trn_available, act_trn_owned, act_trn_fine, act_trn_note) VALUES (".sqlstrval($id).", ".sqlstr($todayStr).", 9, ".sqlstrval($act_ln_n_interest).", ".sqlstrval($act_trn_available).", ".sqlstrval($act_trn_owned).", 0, NULL)") != false);
          }
          if ($act_ln_n_amount > 0)
          {
           $act_trn_available = $act_mny_frozen;
            if ($act_mny_available > 0)
            {
              $act_trn_owned = $act_ln_n_amount - $act_mny_available;
            }
            else
            {
              $act_trn_owned += $act_ln_n_amount;
            }
            $flag = $flag && (mysqli_query($con, "INSERT INTO account_transactions_act_trn (act_trn_usr_id, act_trn_time, act_trn_type, act_trn_amount, act_trn_available, act_trn_owned, act_trn_fine, act_trn_note) VALUES (".sqlstrval($id).", ".sqlstr($todayStr).", 8, ".sqlstrval($act_ln_n_amount).", ".sqlstrval($act_trn_available).", ".sqlstrval($act_trn_owned).", 0, NULL)") != false);
          }
          // check if there are days passed $act_ln_n_date
          $days = str2date($act_ln_n_date)->diff($today)->days;
          if ($days > 0)
          {
            $delta_fine = compute_fine($act_mny_owned, $act_mny_fine, $lns_fine_rate, $lns_fine_rate_is_single, $days);
            $act_trn_fine = $delta_fine;
            $flag = $flag && (mysqli_query($con, "INSERT INTO account_transactions_act_trn (act_trn_usr_id, act_trn_time, act_trn_type, act_trn_amount, act_trn_available, act_trn_owned, act_trn_fine, act_trn_note) VALUES (".sqlstrval($id).", ".sqlstr($todayStr).", 10, ".sqlstrval($delta_fine).", ".sqlstrval($act_mny_frozen).", ".sqlstrval($act_trn_owned).", ".sqlstrval($act_trn_fine).", NULL)") != false);
          }
        }
        $act_mny_total = compute_money_total(0, $act_mny_frozen, $act_mny_investment, $interest->w_amount, $interest->w_interest, $act_trn_owned, $act_trn_fine);
        $flag = $flag && (mysqli_query($con, "UPDATE account_money_act_mny SET act_mny_available = 0, act_mny_loaned = ".sqlstrval($interest->w_amount).", act_mny_interest = ".sqlstrval($interest->w_interest).", act_mny_is_owned = 1, act_mny_owned = ".sqlstrval($act_trn_owned).", act_mny_fine = ".sqlstrval($act_trn_fine).", act_mny_total = ".sqlstrval($act_mny_total).", act_mny_updated = ".sqlstr($nowStr)." WHERE act_mny_usr_id = ".strval($id)) != false);
        if (is_null($interest->n_date))
        {
          $flag = $flag && (mysqli_query($con, "UPDATE account_loan_act_ln SET act_ln_r_amount = ".sqlstrval($interest->w_interest).", act_ln_r_interest = ".sqlstrval($interest->r_interest).", act_ln_w_amount = ".sqlstrval($interest->w_amount).", act_ln_w_interest = ".sqlstrval($interest->w_interest).", act_ln_n_date = NULL, act_ln_n_amount = ".sqlstrval($interest->n_amount).", act_ln_n_interest = ".sqlstrval($interest->n_interest).", act_ln_w_owned = ".sqlstrval($act_trn_owned).", act_ln_w_fine = ".sqlstrval($act_trn_fine).", act_ln_updated = ".sqlstr($nowStr)." WHERE act_ln_usr_id = ".strval($id)) != false);
        }
        else
        {
          $flag = $flag && (mysqli_query($con, "UPDATE account_loan_act_ln SET act_ln_r_amount = ".sqlstrval($interest->w_interest).", act_ln_r_interest = ".sqlstrval($interest->r_interest).", act_ln_w_amount = ".sqlstrval($interest->w_amount).", act_ln_w_interest = ".sqlstrval($interest->w_interest).", act_ln_n_date = ".sqlstr($interest->n_date).", act_ln_n_amount = ".sqlstrval($interest->n_amount).", act_ln_n_interest = ".sqlstrval($interest->n_interest).", act_ln_w_owned = ".sqlstrval($act_trn_owned).", act_ln_w_fine = ".sqlstrval($act_trn_fine).", act_ln_updated = ".sqlstr($nowStr)." WHERE act_ln_usr_id = ".strval($id)) != false);
        }
      }
    }
    else // not a repayment day
    {
      if ($act_mny_is_owned)
      {
        $is_owned = true;
        $days = str2date($act_mny_updated)->diff($today)->days;
        if ($days > 0)
        {
          $delta_fine = compute_fine($act_mny_owned, $act_mny_fine, $lns_fine_rate, $lns_fine_rate_is_single, $days);
          $act_trn_fine = $act_mny_fine + $delta_fine;
          $flag = $flag && (mysqli_query($con, "INSERT INTO account_transactions_act_trn (act_trn_usr_id, act_trn_time, act_trn_type, act_trn_amount, act_trn_available, act_trn_owned, act_trn_fine, act_trn_note) VALUES (".sqlstrval($id).", ".sqlstr($todayStr).", 10, ".sqlstrval($delta_fine).", ".sqlstrval($act_mny_frozen).", ".sqlstrval($act_mny_owned).", ".sqlstrval($act_trn_fine).", NULL)") != false);
          $act_mny_total = compute_money_total($act_mny_available, $act_mny_frozen, $act_mny_investment, $act_mny_loaned, $act_mny_interest, $act_mny_owned, $act_trn_fine);
          $flag = $flag && (mysqli_query($con, "UPDATE account_money_act_mny SET act_mny_fine = ".sqlstrval($act_trn_fine).", act_mny_total = ".sqlstrval($act_mny_total).", act_mny_updated = ".sqlstr($nowStr)." WHERE act_mny_usr_id = ".strval($id)) != false);
          $flag = $flag && (mysqli_query($con, "UPDATE account_loan_act_ln SET act_ln_w_fine = ".sqlstrval($act_trn_fine).", act_ln_updated = ".sqlstr($nowStr)." WHERE act_ln_usr_id = ".strval($id)) != false);
        }
      }
      else
      {
        $flag = $flag && (mysqli_query($con, "UPDATE account_loan_act_ln SET act_ln_updated = ".sqlstr($nowStr)." WHERE act_ln_usr_id = ".strval($id)) != false);
      }
    }
    $flag = $flag && (mysqli_query($con, "UPDATE loans_lns SET lns_updated = ".sqlstr($nowStr)." WHERE lns_app_id = ".strval($act_ln_app_id)) != false);
  }

  if ($flag)
  {
    mysqli_commit($con);
  }
  else
  {
    mysqli_rollback($con);
  }
  mysqli_query($con, "UNLOCK TABLES");
  mysqli_kill($con, mysqli_thread_id($con));
  mysqli_close($con);
  
  return ($is_owned && $flag); //$is_owned;
}
?>
