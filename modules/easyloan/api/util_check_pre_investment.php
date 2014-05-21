<?php

include_once 'util_global.php';
include_once 'util_compute_interest.php';

function check_pre_investment($app_id)
{
  global $db_host, $db_user, $db_pwd, $db_name;
  $con=mysqli_connect($db_host, $db_user, $db_pwd, $db_name);
  if (mysqli_connect_errno())
  {
    return false;
  }
  mysqli_set_charset($con, "UTF8");

  $flag = false;
  $is_created = false;
  $todayStr = date("Y-m-d");
  $today = new DateTime($todayStr);// date_create_from_format('Y-m-d', $todayStr);
  $now = new DateTime;
  $nowStr = $now->format("Y-m-d\TH:i:sP");

  mysqli_autocommit($con, false);
  mysqli_query($con, "LOCK TABLES investments_inv WRITE, hyd_loans_hyd_ln WRITE, investment_accounts_inv_act WRITE, account_investments_act_invs WRITE, account_investment_act_inv WRITE, account_money_act_mny WRITE, account_transactions_act_trn WRITE");

  $result = mysqli_query($con, "SELECT inv_usr_id, inv_amount, inv_interest_rate, inv_repayment_method, inv_minimum, inv_step, inv_duration, inv_start, inv_end, inv_investment FROM investments_inv WHERE inv_app_id = ".strval($app_id)." AND inv_is_done IS NULL AND inv_updated <'".$nowStr."'");
  if ($row = mysqli_fetch_array($result))
  {
    $inv_usr_id = $row['inv_usr_id'];
    $inv_amount = $row['inv_amount'];
    $inv_interest_rate = $row['inv_interest_rate'];
    $inv_repayment_method = $row['inv_repayment_method'];
    $inv_minimum = $row['inv_minimum'];
    $inv_step = $row['inv_step'];
    $inv_duration = $row['inv_duration'];
    $inv_start = $row['inv_start'];
    $inv_end = $row['inv_end'];
    $inv_investment = $row['inv_investment'];
    mysqli_free_result($result);

    if ((new DateTime($inv_start)) <= $today || $inv_amount < $inv_investment + $inv_minimum) // created
    {
      $is_created = true;
      $interest = compute_interest($inv_investment, $inv_interest_rate, $inv_repayment_method, $inv_start, $inv_end, $todayStr);
      $inv_interest = $interest->r_interest + $interest->w_interest;
      $flag = mysqli_query($con, "UPDATE investments_inv SET inv_is_done = 0, inv_interest = ".sqlstrval($inv_interest).", inv_updated = ".sqlstr($nowStr)." WHERE inv_app_id = ".strval($app_id)) != false;
      $flag = $flag && (mysqli_query($con, "INSERT INTO hyd_loans_hyd_ln (hyd_ln_app_id, hyd_ln_usr_id, hyd_ln_total, hyd_ln_count, hyd_ln_r_amount, hyd_ln_r_interest, hyd_ln_w_amount, hyd_ln_w_interest, hyd_ln_n_date, hyd_ln_n_amount, hyd_ln_n_interest, hyd_ln_w_owned, hyd_ln_w_fine, hyd_ln_updated) VALUES (".sqlstrval($app_id).", ".sqlstrval($inv_usr_id).", ".sqlstrval($interest->total).", ".sqlstrval($interest->count).", ".sqlstrval($interest->r_amount).", ".sqlstrval($interest->r_interest).", ".sqlstrval($interest->w_amount).", ".sqlstrval($interest->w_interest).", ".sqlstr($interest->n_date).", ".sqlstrval($interest->n_amount).", ".sqlstrval($interest->n_interest).", 0, 0, ".sqlstr($nowStr).")") != false);
      $result = mysqli_query($con, "SELECT inv_act_usr_id, inv_act_time, inv_act_amount FROM investment_accounts_inv_act WHERE inv_act_app_id = ".strval($app_id));
      while ($row = mysqli_fetch_array($result))
      {
        $inv_act_usr_id = $row['inv_act_usr_id'];
        $inv_act_time = $row['inv_act_time'];
        $inv_act_amount = $row['inv_act_amount'];

        $inv_act_ratio = round($inv_act_amount / $inv_investment, 8);
        $flag = $flag && (mysqli_query($con, "UPDATE investment_accounts_inv_act SET inv_act_ratio = ".sqlstrval($inv_act_ratio)." WHERE inv_act_app_id = ".strval($app_id)." AND inv_act_usr_id = ".strval($inv_act_usr_id)) != false);

        $act_interest = compute_interest($inv_act_amount, $inv_interest_rate, $inv_repayment_method, $inv_start, $inv_end, $todayStr);
        $flag = $flag && (mysqli_query($con, "INSERT INTO account_investments_act_invs (act_invs_usr_id, act_invs_is_done, act_invs_time, act_invs_app_id, act_invs_amount, act_invs_rate, act_invs_r_amount, act_invs_r_interest, act_invs_r_fine, act_invs_w_amount, act_invs_w_interest, act_invs_n_date, act_invs_n_amount, act_invs_n_interest, act_invs_a_amount, act_invs_a_interest, act_invs_w_owned, act_invs_w_fine, act_invs_updated) VALUES (".sqlstrval($inv_act_usr_id).", 0, ".sqlstr($inv_act_time).", ".sqlstrval($app_id).", ".sqlstrval($inv_act_amount).", ".sqlstrval($inv_interest_rate).", ".sqlstrval($act_interest->r_amount).", ".sqlstrval($act_interest->r_interest).", 0, ".sqlstrval($act_interest->w_amount).", ".sqlstrval($act_interest->w_interest).", ".sqlstr($act_interest->n_date).", ".sqlstrval($act_interest->n_amount).", ".sqlstrval($act_interest->n_interest).", ".sqlstrval($act_interest->r_amount).", ".sqlstrval($act_interest->r_interest).", 0, 0, ".sqlstr($nowStr).")") != false);
        
        $result1 = mysqli_query($con, "SELECT act_inv_holdings FROM account_investment_act_inv WHERE act_inv_usr_id = ".strval($inv_act_usr_id));
        $row1 = mysqli_fetch_array($result1);
        $act_inv_holdings = $row1['act_inv_holdings'];
        mysqli_free_result($result1);

        $flag = $flag && (mysqli_query($con, "UPDATE account_investment_act_inv SET act_inv_holdings = ".sqlstrval($act_inv_holdings + 1).", act_inv_updated = ".sqlstr($nowStr)." WHERE act_inv_usr_id = ".strval($inv_act_usr_id)) != false);
        
        $result1 = mysqli_query($con, "SELECT act_mny_available, act_mny_frozen, act_mny_investment, act_mny_loaned, act_mny_interest, act_mny_owned, act_mny_fine, act_mny_total FROM account_money_act_mny WHERE act_mny_usr_id = ".strval($inv_act_usr_id));
        $row1 = mysqli_fetch_array($result1);
        $act_mny_available = $row1['act_mny_available'];
        $act_mny_frozen = $row1['act_mny_frozen'];
        $act_mny_investment = $row1['act_mny_investment'];
        $act_mny_loaned = $row1['act_mny_loaned'];
        $act_mny_interest = $row1['act_mny_interest'];
        $act_mny_owned = $row1['act_mny_owned'];
        $act_mny_fine = $row1['act_mny_fine'];
        $act_mny_total = $row1['act_mny_total'];
        mysqli_free_result($result1);

        $act_mny_frozen = $act_mny_frozen - ($act_interest->w_amount + $act_interest->r_amount);
        $act_mny_investment += $act_interest->w_amount + $act_interest->r_amount;
        $flag = $flag && (mysqli_query($con, "INSERT INTO account_transactions_act_trn (act_trn_usr_id, act_trn_time, act_trn_type, act_trn_amount, act_trn_available, act_trn_owned, act_trn_fine, act_trn_note) VALUES (".sqlstrval($inv_act_usr_id).", ".sqlstr($nowStr).", 3, ".sqlstrval($act_interest->w_amount + $act_interest->r_amount).", ".sqlstrval($act_mny_available + $act_mny_frozen).", ".sqlstrval($act_mny_owned).", ".sqlstrval($act_mny_fine).", NULL)") != false);
        if ($act_interest->r_interest > 0)
        {
          $act_mny_available += $act_interest->r_interest;
          $act_mny_total = compute_money_total($act_mny_available, $act_mny_frozen, $act_mny_investment, $act_mny_loaned, $act_mny_interest, $act_mny_owned, $act_mny_fine);
          $flag = $flag && (mysqli_query($con, "INSERT INTO account_transactions_act_trn (act_trn_usr_id, act_trn_time, act_trn_type, act_trn_amount, act_trn_available, act_trn_owned, act_trn_fine, act_trn_note) VALUES (".sqlstrval($inv_act_usr_id).", ".sqlstr($nowStr).", 5, ".sqlstrval($act_interest->r_interest).", ".sqlstrval($act_mny_available + $act_mny_frozen).", ".sqlstrval($act_mny_owned).", ".sqlstrval($act_mny_fine).", NULL)") != false);
        }
        if ($act_interest->r_amount > 0)
        {
          $act_mny_available += $act_interest->r_amount;
          $act_mny_investment = $act_mny_investment - $act_interest->r_amount;
          $act_mny_total = compute_money_total($act_mny_available, $act_mny_frozen, $act_mny_investment, $act_mny_loaned, $act_mny_interest, $act_mny_owned, $act_mny_fine);
          $flag = $flag && (mysqli_query($con, "INSERT INTO account_transactions_act_trn (act_trn_usr_id, act_trn_time, act_trn_type, act_trn_amount, act_trn_available, act_trn_owned, act_trn_fine, act_trn_note) VALUES (".sqlstrval($inv_act_usr_id).", ".sqlstr($nowStr).", 4, ".sqlstrval($act_interest->r_amount).", ".sqlstrval($act_mny_available + $act_mny_frozen).", ".sqlstrval($act_mny_owned).", ".sqlstrval($act_mny_fine).", NULL)") != false);
        }
        $flag = $flag && (mysqli_query($con, "UPDATE account_money_act_mny SET act_mny_available = ".sqlstrval($act_mny_available).", act_mny_frozen = ".sqlstrval($act_mny_frozen).", act_mny_investment = ".sqlstrval($act_mny_investment).", act_mny_total = ".sqlstrval($act_mny_total).", act_mny_updated = ".sqlstr($nowStr)." WHERE act_mny_usr_id = ".strval($inv_act_usr_id)) != false);
      }
      mysqli_free_result($result);
    }
    else // not created
    {
      $flag = mysqli_query($con, "UPDATE investments_inv SET inv_updated = ".sqlstr($nowStr)." WHERE inv_app_id = ".strval($app_id)." AND inv_is_done IS NULL AND inv_updated < '".$nowStr."'") != false;
    }
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

  return ($is_created && $flag);
}
?>