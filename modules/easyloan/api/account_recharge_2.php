<?php
// consider repayments after recharging
function account_recharge(){

  include_once 'util_global.php';
  include_once 'util_compute_fine.php';
  include_once 'util_compute_average_interest_rate.php';

  if ($user->uid <= 0)
  {
    echo "{\"result\":0}";
    exit;
  }
  $usr_id = $user->uid;

  $type = str2int($_GET["type"], 1);

  if ($type == 1 || $type == 2)
  {
    // check current time between 9am - 11pm
    if (!is_now_valid($time_user_start, $time_user_end))
    {
      echo "{\"result\":0,\"message\":\"Overtime\"}";
      exit;
    }
  }
  $bank = 0;
  $amount = 0;
  $fee = 0;
  if ($type == 2 || $type == 3)
  {
    $bankStr = $_GET["bank"];
    $bank = str2int($bankStr);
    if ($bank < 0 || $bank > 5)
    {
      echo "{\"result\":0}";
      exit;
    }
    $amountStr = $_GET["amount"];
    $amount = str2float($amountStr);
    if ($amount <= 0)
    {
      echo "{\"result\":0}";
      exit;
    }
    $feeStr = $_GET["fee"];
    $fee = str2float($feeStr);
    if ($fee < 0 || $fee != compute_saving_fee($amount))
    {
      echo "{\"result\":0}";
      exit;
    }
  }

  if ($type == 2)
  {
    echo "{\"result\":1}";
  }
  else
  {
    $con=mysqli_connect($db_host, $db_user, $db_pwd, $db_name);
    // Check connection
    if (mysqli_connect_errno())
    {
      echo "{\"result\":0}";
      exit;
    }
    mysqli_set_charset($con, "UTF8");
    if ($type == 3)
    {
      echo save($con, $usr_id, $bank, $amount, $fee);
    }
    else if ($type == 1)
    {
      echo get_info($con, $usr_id);
    }
    mysqli_kill($con, mysqli_thread_id($con));
    mysqli_close($con);
  }
}


function get_info($con, $usr_id)
{
  $json = "{\"result\":0}";
  mysqli_query($con, "LOCK TABLES account_money_act_mny READ, account_info_act_info READ");
  $query = "SELECT act_info_ssn_status FROM account_info_act_info WHERE act_info_usr_id = ".strval($usr_id);
  $result = mysqli_query($con, $query);
  if ($row = mysqli_fetch_array($result))
  {
    $act_info_ssn_status = $row['act_info_ssn_status'];
    mysqli_free_result($result);

    if ($act_info_ssn_status == 1)
    {
      $query = "SELECT act_mny_available FROM account_money_act_mny WHERE act_mny_usr_id = ".strval($usr_id);
      $result = mysqli_query($con, $query);
      if ($row = mysqli_fetch_array($result))
      {
        $act_mny_available = $row['act_mny_available'];
        mysqli_free_result($result);

        $json = "{\"result\":1,\"available\":".jsonstrval($act_mny_available)."}";
      }
    }
  }
  mysqli_query($con, "UNLOCK TABLES");
  return $json;
}

function save($con, $usr_id, $bank, $amount, $fee)
{
  $todayStr = date("Y-m-d");
  $today = new DateTime($todayStr);// date_create_from_format('Y-m-d', $todayStr);
  $now = new DateTime;
  $nowStr = $now->format("Y-m-d\TH:i:sP");

  $flag = true;

  $json = "{\"result\":0}";

  mysqli_autocommit($con, false);
  mysqli_query($con, "LOCK TABLES investment_accounts_inv_act READ, account_saving_act_sv WRITE, account_savings_act_svs WRITE, account_money_act_mny WRITE, account_transactions_act_trn WRITE, loans_lns WRITE, investments_inv WRITE, hyd_loans_hyd_ln WRITE, account_investments_act_invs WRITE, account_investment_act_inv WRITE, account_loan_act_ln WRITE");
  
  $query = "SELECT act_sv_amount, act_sv_fee, act_sv_times FROM account_saving_act_sv WHERE act_sv_usr_id = ".strval($usr_id);
  $result = mysqli_query($con, $query);
  if ($row = mysqli_fetch_array($result))
  {
    $act_sv_amount = $row['act_sv_amount'] + $amount;
    $act_sv_fee = $row['act_sv_fee'] + $fee;
    $act_sv_times = $row['act_sv_times'] + 1;
    mysqli_free_result($result);

    $query = "UPDATE account_saving_act_sv SET act_sv_amount = ".sqlstrval($act_sv_amount).", act_sv_fee = ".sqlstrval($act_sv_fee).", act_sv_times = ".sqlstrval($act_sv_times).", act_sv_updated = ".sqlstr($nowStr)." WHERE act_sv_usr_id = ".strval($usr_id);
    $flag = $flag && (mysqli_query($con, $query) != false);

    $query = "INSERT INTO account_savings_act_svs (act_svs_usr_id, act_svs_time, act_svs_amount, act_svs_fee, act_svs_bank) VALUES (".sqlstrval($usr_id).", ".sqlstr($nowStr).", ".sqlstrval($amount).", ".sqlstrval($fee).", ".sqlstrval($bank).")";
    $flag = $flag && (mysqli_query($con, $query) != false);

    $query = "SELECT act_mny_available, act_mny_frozen, act_mny_investment, act_mny_loaned, act_mny_interest, act_mny_owned, act_mny_fine, act_mny_updated FROM account_money_act_mny WHERE act_mny_usr_id = ".strval($usr_id);
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_array($result);
    $act_mny_available = $row['act_mny_available'];
    $act_mny_frozen = $row['act_mny_frozen'];
    $act_mny_investment = $row['act_mny_investment'];
    $act_mny_loaned = $row['act_mny_loaned'];
    $act_mny_interest = $row['act_mny_interest'];
    $act_mny_owned = $row['act_mny_owned'];
    $act_mny_fine = $row['act_mny_fine'];
    $act_mny_updated = $row['act_mny_updated'];
    mysqli_free_result($result);

    if ($act_mny_owned <= 0) // not owned, no fines
    {
      $act_mny_available += $amount;
      $act_mny_total = compute_money_total($act_mny_available, $act_mny_frozen, $act_mny_investment, $act_mny_loaned, $act_mny_interest, 0, 0);
      $query = "UPDATE account_money_act_mny SET act_mny_available = ".sqlstrval($act_mny_available).", act_mny_owned = 0, act_mny_fine = 0, act_mny_total = ".sqlstrval($act_mny_total).", act_mny_updated = ".sqlstr($nowStr)." WHERE act_mny_usr_id = ".strval($usr_id);
      $flag = $flag && (mysqli_query($con, $query) != false);

      $act_trn_available = $act_mny_available + $act_mny_frozen;
      $query = "INSERT INTO account_transactions_act_trn (act_trn_usr_id, act_trn_time, act_trn_type, act_trn_amount, act_trn_available, act_trn_owned, act_trn_fine, act_trn_note) VALUES (".sqlstrval($usr_id).", ".sqlstr($nowStr).", 1, ".sqlstrval($amount).", ".sqlstrval($act_trn_available).", 0, 0, ".sqlstrval($fee).")";
      $flag = $flag && (mysqli_query($con, $query) != false);
    }
    else // act_mny_owned > 0, owning money to the loan
    {
      $query = "SELECT lns_app_id, lns_interest_rate, lns_duration, lns_fine_rate, lns_fine_rate_is_single, lns_fine FROM loans_lns WHERE lns_usr_id = ".strval($usr_id)." AND lns_is_done = 0";
      $result = mysqli_query($con, $query);
      $row = mysqli_fetch_array($result);
      $lns_app_id = $row['lns_app_id'];
      $lns_interest_rate = $row['lns_interest_rate'];
      $lns_duration = $row['lns_duration'];
      $lns_fine_rate = $row['lns_fine_rate'];
      $lns_fine_rate_is_single = $row['lns_fine_rate_is_single'];
      $lns_fine = $row['lns_fine'];
      mysqli_free_result($result);

      $days = str2date($act_mny_updated)->diff($today)->days;

      $fine_new = $days > 0 ? compute_fine($act_mny_owned, $act_mny_fine, $lns_fine_rate, $lns_fine_rate_is_single, $days) : 0;
      $act_trn_available = $act_mny_available + $act_mny_frozen; // $act_mny_available must be 0
      $act_trn_fine = $act_mny_fine + $fine_new;
      if ($fine_new > 0)
      {
        $query = "INSERT INTO account_transactions_act_trn (act_trn_usr_id, act_trn_time, act_trn_type, act_trn_amount, act_trn_available, act_trn_owned, act_trn_fine, act_trn_note) VALUES (".sqlstrval($usr_id).", ".sqlstr($todayStr).", 10, ".sqlstrval($fine_new).", ".sqlstrval($act_trn_available).", ".sqlstrval($act_mny_owned).", ".sqlstrval($act_trn_fine).", NULL)";
        $flag = $flag && (mysqli_query($con, $query) != false);
      }

      $act_trn_fine = ($act_trn_fine - $amount) <= 0 ? 0 : ($act_trn_fine - $amount);
      $act_trn_owned = $act_mny_owned;
      if ($act_trn_fine == 0)
      {
        $act_trn_owned = ($act_mny_owned + $act_mny_fine + $fine_new - $amount) <= 0 ? 0 : ($act_mny_owned + $act_mny_fine + $fine_new - $amount);
      }
      $act_trn_available = $act_mny_available + $act_mny_frozen;
      if ($act_trn_owned == 0)
      {
        $act_trn_available += $amount - ($act_mny_owned + $act_mny_fine + $fine_new);
      }
      
      $query = "INSERT INTO account_transactions_act_trn (act_trn_usr_id, act_trn_time, act_trn_type, act_trn_amount, act_trn_available, act_trn_owned, act_trn_fine, act_trn_note) VALUES (".sqlstrval($usr_id).", ".sqlstr($nowStr).", 1, ".sqlstrval($amount).", ".sqlstrval($act_trn_available).", ".sqlstrval($act_trn_owned).", ".sqlstrval($act_trn_fine).", ".sqlstr(sqlstrval($fee)).")";
      $flag = $flag && (mysqli_query($con, $query) != false);

      if ($act_trn_fine > 0)
      {
        $lns_fine += $amount;
      }
      else
      {
        $lns_fine += $act_mny_fine + $fine_new;
      }
      $query = "UPDATE loans_lns SET lns_fine = ".sqlstrval($lns_fine).", lns_updated = ".sqlstr($nowStr)." WHERE lns_app_id = ".sqlstrval($lns_app_id);
      $flag = $flag && (mysqli_query($con, $query) != false);

      $query = "SELECT hyd_ln_n_date, hyd_ln_w_owned, hyd_ln_w_fine, hyd_ln_updated FROM hyd_loans_hyd_ln WHERE hyd_ln_app_id = ".strval($lns_app_id);
      $result = mysqli_query($con, $query);
      $row = mysqli_fetch_array($result);
      $hyd_ln_n_date = $row['hyd_ln_n_date'];
      $hyd_ln_w_owned = $row['hyd_ln_w_owned'];
      $hyd_ln_w_fine = $row['hyd_ln_w_fine'];
      $hyd_ln_updated = $row['hyd_ln_updated'];
      mysqli_free_result($result);

      $query = "SELECT inv_investment, inv_interest_rate, inv_duration, inv_start, inv_end, inv_fine_rate, inv_fine_rate_is_single, inv_fine FROM investments_inv WHERE inv_app_id = ".strval($lns_app_id);
      $result = mysqli_query($con, $query);
      $row = mysqli_fetch_array($result);
      $inv_investment = $row['inv_investment'];
      $inv_interest_rate = $row['inv_interest_rate'];
      $inv_duration = $row['inv_duration'];
      $inv_start = $row['inv_start'];
      $inv_end = $row['inv_end'];
      $inv_fine_rate = $row['inv_fine_rate'];
      $inv_fine_rate_is_single = $row['inv_fine_rate_is_single'];
      $inv_fine = $row['inv_fine'];
      mysqli_free_result($result);

      $days = str2date($hyd_ln_updated)->diff($today)->days;
      $fine_new = $days > 0 ? compute_fine($hyd_ln_w_owned, $hyd_ln_w_fine, $inv_fine_rate, $inv_fine_rate_is_single, $days) : 0;

      $hyd_ln_w_fine += $fine_new;
      if ($act_trn_fine > 0 && $amount < $hyd_ln_w_fine) // hyd will owe fines to investors.  $amount is used to repay fines
      {
        $inv_fine += $amount;
        $query = "UPDATE investments_inv SET inv_fine = ".sqlstrval($inv_fine).", inv_updated = ".sqlstr($nowStr)." WHERE inv_app_id = ".strval($lns_app_id);
        $flag = $flag && (mysqli_query($con, $query) != false);

        $hyd_ln_w_fine = $hyd_ln_w_fine - $amount;
        $query = "UPDATE hyd_loans_hyd_ln SET hyd_ln_w_fine = ".sqlstrval($hyd_ln_w_fine).", hyd_ln_updated = ".sqlstr($nowStr)." WHERE hyd_ln_app_id = ".strval($lns_app_id);
        $flag = $flag && (mysqli_query($con, $query) != false);

        $query = "SELECT inv_act_usr_id, inv_act_amount, inv_act_ratio FROM investment_accounts_inv_act WHERE inv_act_app_id = ".strval($lns_app_id);
        $result = mysqli_query($con, $query);
        while ($row = mysqli_fetch_array($result))
        {
          $inv_act_usr_id = $row['inv_act_usr_id'];
          $inv_act_amount = $row['inv_act_amount'];
          $inv_act_ratio = $row['inv_act_ratio'];

          $delta_amount = round($amount * $inv_act_ratio, 2);
          if ($delta_amount > 0)
          {
            $query = "SELECT act_invs_r_fine, act_invs_w_owned, act_invs_w_fine, act_invs_updated FROM account_investments_act_invs WHERE act_invs_usr_id = ".strval($inv_act_usr_id)." AND act_invs_app_id = ".strval($lns_app_id);
            $result1 = mysqli_query($con, $query);
            $row1 = mysqli_fetch_array($result1);
            $act_invs_r_fine = $row1['act_invs_r_fine'];
            $act_invs_w_owned = $row1['act_invs_w_owned'];
            $act_invs_w_fine = $row1['act_invs_w_fine'];
            $act_invs_updated = $row1['act_invs_updated'];
            mysqli_free_result($result1);

            $days = str2date($act_invs_updated)->diff($today)->days;
            if ($days > 0)
            {
              $delta_fine_new = compute_fine($act_invs_w_owned, $act_invs_w_fine, $inv_fine_rate, $inv_fine_rate_is_single, $days);
              $act_invs_w_fine += $delta_fine_new;
            }

            $query = "SELECT act_mny_available, act_mny_frozen, act_mny_investment, act_mny_loaned, act_mny_interest, act_mny_owned, act_mny_fine, act_mny_total, act_mny_updated FROM account_money_act_mny WHERE act_mny_usr_id = ".strval($inv_act_usr_id);
            $result1 = mysqli_query($con, $query);
            $row1 = mysqli_fetch_array($result1);
            $inv_act_mny_available = $row1['act_mny_available'];
            $inv_act_mny_frozen = $row1['act_mny_frozen'];
            $inv_act_mny_investment = $row1['act_mny_investment'];
            $inv_act_mny_loaned = $row1['act_mny_loaned'];
            $inv_act_mny_interest = $row1['act_mny_interest'];
            $inv_act_mny_owned = $row1['act_mny_owned'];
            $inv_act_mny_fine = $row1['act_mny_fine'];
            $inv_act_mny_total = $row1['act_mny_total'];
            $inv_act_mny_updated = $row1['act_mny_updated'];
            mysqli_free_result($result1);

            $delta_r_fine = $act_invs_w_fine > $delta_amount ? $delta_amount : $act_invs_w_fine;

            $inv_act_trn_available = $inv_act_mny_available + $inv_act_mny_frozen + $delta_r_fine;
            $query = "INSERT INTO account_transactions_act_trn (act_trn_usr_id, act_trn_time, act_trn_type, act_trn_amount, act_trn_available, act_trn_owned, act_trn_fine, act_trn_note) VALUES (".sqlstrval($inv_act_usr_id).", ".sqlstr($nowStr).", 6, ".sqlstrval($delta_r_fine).", ".sqlstrval($inv_act_trn_available).", 0, 0, NULL)";
            $flag = $flag && (mysqli_query($con, $query) != false);

            $inv_act_mny_available += $delta_r_fine;
            $inv_act_mny_total = compute_money_total($inv_act_mny_available, $inv_act_mny_frozen, $inv_act_mny_investment, $inv_act_mny_loaned, $inv_act_mny_interest, $inv_act_mny_owned, $inv_act_mny_fine);
            $query = "UPDATE account_money_act_mny SET act_mny_available = ".sqlstrval($inv_act_mny_available).", act_mny_total = ".sqlstrval($inv_act_mny_total).", act_mny_updated = ".sqlstr($nowStr)." WHERE act_mny_usr_id = ".strval($inv_act_usr_id);
            $flag = $flag && (mysqli_query($con, $query) != false);

            $act_invs_r_fine += $delta_r_fine;
            $act_invs_w_fine = $act_invs_w_fine - $delta_r_fine;
            $query = "UPDATE account_investments_act_invs SET act_invs_r_fine = ".sqlstrval($act_invs_r_fine).", act_invs_w_fine = ".sqlstrval($act_invs_w_fine).", act_invs_updated = ".sqlstr($nowStr)." WHERE act_invs_usr_id = ".strval($inv_act_usr_id)." AND act_invs_app_id = ".strval($lns_app_id);
            $flag = $flag && (mysqli_query($con, $query) != false);
          }
        }
        mysqli_free_result($result);
      }
      else // hyd repays all fines to investors
      {
        $inv_fine += $hyd_ln_w_fine;
        $query = "UPDATE investments_inv SET inv_fine = ".sqlstrval($inv_fine).", inv_updated = ".sqlstr($nowStr)." WHERE inv_app_id = ".strval($lns_app_id);
        $flag = $flag && (mysqli_query($con, $query) != false);

        $query = "UPDATE hyd_loans_hyd_ln SET hyd_ln_w_fine = 0, hyd_ln_updated = ".sqlstr($nowStr)." WHERE hyd_ln_app_id = ".strval($lns_app_id);
        $flag = $flag && (mysqli_query($con, $query) != false);

        $query = "SELECT inv_act_usr_id, inv_act_amount, inv_act_ratio FROM investment_accounts_inv_act WHERE inv_act_app_id = ".strval($lns_app_id);
        $result = mysqli_query($con, $query);
        while ($row = mysqli_fetch_array($result))
        {
          $inv_act_usr_id = $row['inv_act_usr_id'];
          $inv_act_amount = $row['inv_act_amount'];
          $inv_act_ratio = $row['inv_act_ratio'];

          $query = "SELECT act_invs_r_fine, act_invs_w_owned, act_invs_w_fine, act_invs_updated FROM account_investments_act_invs WHERE act_invs_usr_id = ".strval($inv_act_usr_id)." AND act_invs_app_id = ".strval($lns_app_id);
          $result1 = mysqli_query($con, $query);
          $row1 = mysqli_fetch_array($result1);
          $act_invs_r_fine = $row1['act_invs_r_fine'];
          $act_invs_w_owned = $row1['act_invs_w_owned'];
          $act_invs_w_fine = $row1['act_invs_w_fine'];
          $act_invs_updated = $row1['act_invs_updated'];
          mysqli_free_result($result1);

          $days = str2date($act_invs_updated)->diff($today)->days;
          if ($days > 0)
          {
            $delta_fine_new = compute_fine($act_invs_w_owned, $act_invs_w_fine, $inv_fine_rate, $inv_fine_rate_is_single, $days);
            $act_invs_w_fine += $delta_fine_new;
          }

          $query = "SELECT act_mny_available, act_mny_frozen, act_mny_investment, act_mny_loaned, act_mny_interest, act_mny_owned, act_mny_fine, act_mny_total, act_mny_updated FROM account_money_act_mny WHERE act_mny_usr_id = ".strval($inv_act_usr_id);
          $result1 = mysqli_query($con, $query);
          $row1 = mysqli_fetch_array($result1);
          $inv_act_mny_available = $row1['act_mny_available'];
          $inv_act_mny_frozen = $row1['act_mny_frozen'];
          $inv_act_mny_investment = $row1['act_mny_investment'];
          $inv_act_mny_loaned = $row1['act_mny_loaned'];
          $inv_act_mny_interest = $row1['act_mny_interest'];
          $inv_act_mny_owned = $row1['act_mny_owned'];
          $inv_act_mny_fine = $row1['act_mny_fine'];
          $inv_act_mny_total = $row1['act_mny_total'];
          $inv_act_mny_updated = $row1['act_mny_updated'];
          mysqli_free_result($result1);

          if ($act_invs_w_fine > 0)
          {
            $inv_act_trn_available = $inv_act_mny_available + $inv_act_mny_frozen + $act_invs_w_fine;
            $query = "INSERT INTO account_transactions_act_trn (act_trn_usr_id, act_trn_time, act_trn_type, act_trn_amount, act_trn_available, act_trn_owned, act_trn_fine, act_trn_note) VALUES (".sqlstrval($inv_act_usr_id).", ".sqlstr($nowStr).", 6, ".sqlstrval($act_invs_w_fine).", ".sqlstrval($inv_act_trn_available).", 0, 0, NULL)";
            $flag = $flag && (mysqli_query($con, $query) != false);
          }

          $inv_act_mny_available += $act_invs_w_fine;
          $inv_act_mny_total = compute_money_total($inv_act_mny_available, $inv_act_mny_frozen, $inv_act_mny_investment, $inv_act_mny_loaned, $inv_act_mny_interest, $inv_act_mny_owned, $inv_act_mny_fine);
          $query = "UPDATE account_money_act_mny SET act_mny_available = ".sqlstrval($inv_act_mny_available).", act_mny_total = ".sqlstrval($inv_act_mny_total).", act_mny_updated = ".sqlstr($nowStr)." WHERE act_mny_usr_id = ".strval($inv_act_usr_id);
          $flag = $flag && (mysqli_query($con, $query) != false);

          $act_invs_r_fine += $act_invs_w_fine;
          $query = "UPDATE account_investments_act_invs SET act_invs_r_fine = ".sqlstrval($act_invs_r_fine).", act_invs_w_fine = 0, act_invs_updated = ".sqlstr($nowStr)." WHERE act_invs_usr_id = ".strval($inv_act_usr_id)." AND act_invs_app_id = ".strval($lns_app_id);
          $flag = $flag && (mysqli_query($con, $query) != false);
        }
        mysqli_free_result($result);
      }
      if ($act_trn_owned > 0 && ($act_mny_owned - $act_trn_owned) < $hyd_ln_w_owned) // hyd will owe to investors. ($act_mny_owned - $act_trn_owned) is used to repay hyd-owned-money
      {
        $r_amount = $act_mny_owned - $act_trn_owned;
        $query = "UPDATE hyd_loans_hyd_ln SET hyd_ln_w_owned = ".sqlstrval($act_trn_owned).", hyd_ln_updated = ".sqlstr($nowStr)." WHERE hyd_ln_app_id = ".strval($lns_app_id);
        $flag = $flag && (mysqli_query($con, $query) != false);

        $query = "SELECT inv_act_usr_id, inv_act_amount, inv_act_ratio FROM investment_accounts_inv_act WHERE inv_act_app_id = ".strval($lns_app_id);
        $result = mysqli_query($con, $query);
        while ($row = mysqli_fetch_array($result))
        {
          $inv_act_usr_id = $row['inv_act_usr_id'];
          $inv_act_amount = $row['inv_act_amount'];
          $inv_act_ratio = $row['inv_act_ratio'];

          $delta_amount = round($r_amount * $inv_act_ratio, 2);
          if ($delta_amount > 0)
          {
            $query = "SELECT act_invs_r_amount, act_invs_r_interest, act_invs_a_amount, act_invs_a_interest FROM account_investments_act_invs WHERE act_invs_usr_id = ".strval($inv_act_usr_id)." AND act_invs_app_id = ".strval($lns_app_id);
            $result1 = mysqli_query($con, $query);
            $row1 = mysqli_fetch_array($result1);
            $act_invs_r_amount = $row1['act_invs_r_amount'];
            $act_invs_r_interest = $row1['act_invs_r_interest'];
            $act_invs_a_amount = $row1['act_invs_a_amount'];
            $act_invs_a_interest = $row1['act_invs_a_interest'];
            mysqli_free_result($result1);

            $query = "SELECT act_mny_available, act_mny_frozen, act_mny_investment, act_mny_loaned, act_mny_interest, act_mny_owned, act_mny_fine, act_mny_total, act_mny_updated FROM account_money_act_mny WHERE act_mny_usr_id = ".strval($inv_act_usr_id);
            $result1 = mysqli_query($con, $query);
            $row1 = mysqli_fetch_array($result1);
            $inv_act_mny_available = $row1['act_mny_available'];
            $inv_act_mny_frozen = $row1['act_mny_frozen'];
            $inv_act_mny_investment = $row1['act_mny_investment'];
            $inv_act_mny_loaned = $row1['act_mny_loaned'];
            $inv_act_mny_interest = $row1['act_mny_interest'];
            $inv_act_mny_owned = $row1['act_mny_owned'];
            $inv_act_mny_fine = $row1['act_mny_fine'];
            $inv_act_mny_total = $row1['act_mny_total'];
            $inv_act_mny_updated = $row1['act_mny_updated'];
            mysqli_free_result($result1);

            $delta_r_interest = ($act_invs_r_interest - $act_invs_a_interest) > $delta_amount ? $delta_amount : ($act_invs_r_interest - $act_invs_a_interest);
            $delta_r_amount = $delta_amount > $delta_r_interest ? (($act_invs_r_amount - $act_invs_a_amount) > ($delta_amount - $delta_r_interest) ? ($delta_amount - $delta_r_interest) : ($act_invs_r_amount - $act_invs_a_amount)) : 0;

            if ($delta_r_interest > 0)
            {
              $inv_act_trn_available = $inv_act_mny_available + $inv_act_mny_frozen + $delta_r_interest;
              $query = "INSERT INTO account_transactions_act_trn (act_trn_usr_id, act_trn_time, act_trn_type, act_trn_amount, act_trn_available, act_trn_owned, act_trn_fine, act_trn_note) VALUES (".sqlstrval($inv_act_usr_id).", ".sqlstr($nowStr).", 5, ".sqlstrval($delta_r_interest).", ".sqlstrval($inv_act_trn_available).", 0, 0, NULL)";
              $flag = $flag && (mysqli_query($con, $query) != false);
            }
            if ($delta_r_amount > 0)
            {
              $inv_act_trn_available = $inv_act_mny_available + $inv_act_mny_frozen + $delta_r_interest + $delta_r_amount;
              $query = "INSERT INTO account_transactions_act_trn (act_trn_usr_id, act_trn_time, act_trn_type, act_trn_amount, act_trn_available, act_trn_owned, act_trn_fine, act_trn_note) VALUES (".sqlstrval($inv_act_usr_id).", ".sqlstr($nowStr).", 4, ".sqlstrval($delta_r_amount).", ".sqlstrval($inv_act_trn_available).", 0, 0, NULL)";
              $flag = $flag && (mysqli_query($con, $query) != false);
            }

            $inv_act_mny_available += $delta_r_interest + $delta_r_amount;
            $inv_act_mny_total = compute_money_total($inv_act_mny_available, $inv_act_mny_frozen, $inv_act_mny_investment, $inv_act_mny_loaned, $inv_act_mny_interest, $inv_act_mny_owned, $inv_act_mny_fine);
            $query = "UPDATE account_money_act_mny SET act_mny_available = ".sqlstrval($inv_act_mny_available).", act_mny_total = ".sqlstrval($inv_act_mny_total).", act_mny_updated = ".sqlstr($nowStr)." WHERE act_mny_usr_id = ".strval($inv_act_usr_id);
            $flag = $flag && (mysqli_query($con, $query) != false);

            $act_invs_a_amount += $delta_r_amount;
            $act_invs_a_interest += $delta_r_interest;
            $act_invs_w_owned = $act_invs_w_owned - ($delta_r_amount + $delta_r_interest);
            $query = "UPDATE account_investments_act_invs SET act_invs_a_amount = ".sqlstrval($act_invs_a_amount).", act_invs_a_interest = ".sqlstrval($act_invs_a_interest).", act_invs_w_owned = ".sqlstrval($act_invs_w_owned).", act_invs_updated = ".sqlstr($nowStr)." WHERE act_invs_usr_id = ".strval($inv_act_usr_id)." AND act_invs_app_id = ".strval($lns_app_id);
            $flag = $flag && (mysqli_query($con, $query) != false);
          }
        }
        mysqli_free_result($result);
      }
      else // hyd repays all owned money to investors
      {
        $query = "UPDATE hyd_loans_hyd_ln SET hyd_ln_w_owned = 0, hyd_ln_updated = ".sqlstr($nowStr)." WHERE hyd_ln_app_id = ".strval($lns_app_id);
        $flag = $flag && (mysqli_query($con, $query) != false);

        $query = "SELECT inv_act_usr_id, inv_act_amount, inv_act_ratio FROM investment_accounts_inv_act WHERE inv_act_app_id = ".strval($lns_app_id);
        $result = mysqli_query($con, $query);
        while ($row = mysqli_fetch_array($result))
        {
          $inv_act_usr_id = $row['inv_act_usr_id'];
          $inv_act_amount = $row['inv_act_amount'];
          $inv_act_ratio = $row['inv_act_ratio'];

          $query = "SELECT act_invs_r_amount, act_invs_r_interest, act_invs_r_fine, act_invs_a_amount, act_invs_a_interest FROM account_investments_act_invs WHERE act_invs_usr_id = ".strval($inv_act_usr_id)." AND act_invs_app_id = ".strval($lns_app_id);
          $result1 = mysqli_query($con, $query);
          $row1 = mysqli_fetch_array($result1);
          $act_invs_r_amount = $row1['act_invs_r_amount'];
          $act_invs_r_interest = $row1['act_invs_r_interest'];
          $act_invs_r_fine = $row1['act_invs_r_fine'];
          $act_invs_a_amount = $row1['act_invs_a_amount'];
          $act_invs_a_interest = $row1['act_invs_a_interest'];
          mysqli_free_result($result1);

          $query = "SELECT act_mny_available, act_mny_frozen, act_mny_investment, act_mny_loaned, act_mny_interest, act_mny_owned, act_mny_fine, act_mny_total, act_mny_updated FROM account_money_act_mny WHERE act_mny_usr_id = ".strval($inv_act_usr_id);
          $result1 = mysqli_query($con, $query);
          $row1 = mysqli_fetch_array($result1);
          $inv_act_mny_available = $row1['act_mny_available'];
          $inv_act_mny_frozen = $row1['act_mny_frozen'];
          $inv_act_mny_investment = $row1['act_mny_investment'];
          $inv_act_mny_loaned = $row1['act_mny_loaned'];
          $inv_act_mny_interest = $row1['act_mny_interest'];
          $inv_act_mny_owned = $row1['act_mny_owned'];
          $inv_act_mny_fine = $row1['act_mny_fine'];
          $inv_act_mny_total = $row1['act_mny_total'];
          $inv_act_mny_updated = $row1['act_mny_updated'];
          mysqli_free_result($result1);

          $delta_r_interest = $act_invs_r_interest - $act_invs_a_interest;
          $delta_r_amount = $act_invs_r_amount - $act_invs_a_amount;

          if ($delta_r_interest > 0)
          {
            $inv_act_trn_available = $inv_act_mny_available + $inv_act_mny_frozen + $delta_r_interest;
            $query = "INSERT INTO account_transactions_act_trn (act_trn_usr_id, act_trn_time, act_trn_type, act_trn_amount, act_trn_available, act_trn_owned, act_trn_fine, act_trn_note) VALUES (".sqlstrval($inv_act_usr_id).", ".sqlstr($nowStr).", 5, ".sqlstrval($delta_r_interest).", ".sqlstrval($inv_act_trn_available).", 0, 0, NULL)";
            $flag = $flag && (mysqli_query($con, $query) != false);
          }
          if ($delta_r_amount > 0)
          {
            $inv_act_trn_available = $inv_act_mny_available + $inv_act_mny_frozen + $delta_r_interest + $delta_r_amount;
            $query = "INSERT INTO account_transactions_act_trn (act_trn_usr_id, act_trn_time, act_trn_type, act_trn_amount, act_trn_available, act_trn_owned, act_trn_fine, act_trn_note) VALUES (".sqlstrval($inv_act_usr_id).", ".sqlstr($nowStr).", 4, ".sqlstrval($delta_r_amount).", ".sqlstrval($inv_act_trn_available).", 0, 0, NULL)";
            $flag = $flag && (mysqli_query($con, $query) != false);
          }

          $inv_act_mny_available += $delta_r_interest + $delta_r_amount;
          $inv_act_mny_total = compute_money_total($inv_act_mny_available, $inv_act_mny_frozen, $inv_act_mny_investment, $inv_act_mny_loaned, $inv_act_mny_interest, $inv_act_mny_owned, $inv_act_mny_fine);
          $query = "UPDATE account_money_act_mny SET act_mny_available = ".sqlstrval($inv_act_mny_available).", act_mny_total = ".sqlstrval($inv_act_mny_total).", act_mny_updated = ".sqlstr($nowStr)." WHERE act_mny_usr_id = ".strval($inv_act_usr_id);
          $flag = $flag && (mysqli_query($con, $query) != false);

          if (is_null($hyd_ln_n_date)) // hyd investment project is finished
          {
            $query = "UPDATE account_investments_act_invs SET act_invs_is_done = 1, act_invs_a_amount = ".sqlstrval($act_invs_r_amount).", act_invs_a_interest = ".sqlstrval($act_invs_r_interest).", act_invs_w_owned = 0, act_invs_updated = ".sqlstr($nowStr)." WHERE act_invs_usr_id = ".strval($inv_act_usr_id)." AND act_invs_app_id = ".strval($lns_app_id);
            $flag = $flag && (mysqli_query($con, $query) != false);

            $query = "SELECT act_inv_amount, act_inv_interest, act_inv_fine, act_inv_interest_rate, act_inv_duration, act_inv_total, act_inv_holdings FROM account_investment_act_inv WHERE act_inv_usr_id = ".strval($inv_act_usr_id);
            $result1 = mysqli_query($con, $query);
            $row1 = mysqli_fetch_array($result1);
            $inv_act_inv_amount = $row1['act_inv_amount'];
            $inv_act_inv_interest = $row1['act_inv_interest'];
            $inv_act_inv_fine = $row1['act_inv_fine'];
            $inv_act_inv_interest_rate = $row1['act_inv_interest_rate'];
            $inv_act_inv_duration = $row1['act_inv_duration'];
            $inv_act_inv_total = $row1['act_inv_total'];
            $inv_act_inv_holdings = $row1['act_inv_holdings'];
            mysqli_free_result($result1);

            $new_interest_rate = compute_average_interest_rate($inv_act_inv_amount, $inv_act_inv_interest_rate, $inv_act_inv_duration, $act_invs_r_amount, $inv_interest_rate, $inv_duration);

            $inv_act_inv_amount += $act_invs_r_amount;
            $inv_act_inv_interest += $act_invs_r_interest;
            $inv_act_inv_fine += $act_invs_r_fine;
            $inv_act_inv_total += 1;
            $inv_act_inv_holdings = $inv_act_inv_holdings - 1;
            $query = "UPDATE account_investment_act_inv SET act_inv_amount = ".sqlstrval($inv_act_inv_amount).", act_inv_interest = ".sqlstrval($inv_act_inv_interest).", act_inv_fine = ".sqlstrval($inv_act_inv_fine).", act_inv_interest_rate = ".sqlstrval($new_interest_rate->cr1).", act_inv_duration = ".sqlstrval($new_interest_rate->cd1).", act_inv_total = ".sqlstrval($act_inv_total).", act_inv_holdings = ".sqlstrval($inv_act_inv_holdings).", act_inv_updated = ".sqlstr($nowStr)." WHERE act_inv_usr_id = ".strval($inv_act_usr_id);
            $flag = $flag && (mysqli_query($con, $query) != false);
          }
          else // hyd investment project is not finished yet
          {
            $query = "UPDATE account_investments_act_invs SET act_invs_a_amount = ".sqlstrval($act_invs_r_amount).", act_invs_a_interest = ".sqlstrval($act_invs_r_interest).", act_invs_w_owned = 0, act_invs_updated = ".sqlstr($nowStr)." WHERE act_invs_usr_id = ".strval($inv_act_usr_id)." AND act_invs_app_id = ".strval($lns_app_id);
            $flag = $flag && (mysqli_query($con, $query) != false);
          }
        }
        mysqli_free_result($result);
      }

      $query = "SELECT act_ln_amount, act_ln_interest, act_ln_fine, act_ln_interest_rate, act_ln_duration, act_ln_loans, act_ln_r_amount, act_ln_r_interest, act_ln_n_date FROM account_loan_act_ln WHERE act_ln_usr_id = ".strval($usr_id);
      $result = mysqli_query($con, $query);
      $row = mysqli_fetch_array($result);
      $act_ln_amount = $row['act_ln_amount'];
      $act_ln_interest = $row['act_ln_interest'];
      $act_ln_fine = $row['act_ln_fine'];
      $act_ln_interest_rate = $row['act_ln_interest_rate'];
      $act_ln_duration = $row['act_ln_duration'];
      $act_ln_loans = $row['act_ln_loans'];
      $act_ln_r_amount = $row['act_ln_r_amount'];
      $act_ln_r_interest = $row['act_ln_r_interest'];
      $act_ln_n_date = $row['act_ln_n_date'];
      mysqli_free_result($result);

      if ($act_trn_owned <= 0 && is_null($act_ln_n_date)) // loan finished
      {
        $query = "UPDATE loans_lns SET lns_is_done = 1, lns_finished = ".sqlstr($todayStr).", lns_updated = ".sqlstr($nowStr)." WHERE lns_app_id = ".strval($lns_app_id)." AND lns_usr_id = ".strval($usr_id);
        $flag = $flag && (mysqli_query($con, $query) != false);

        $new_interest_rate = compute_average_interest_rate($act_ln_amount, $act_ln_interest_rate, $act_ln_duration, $act_ln_r_amount, $lns_interest_rate, $lns_duration);
        $act_ln_amount += $act_ln_r_amount;
        $act_ln_interest += $act_ln_r_interest;
        $act_ln_fine += $lns_fine;
        $act_ln_loans += 1;
        $query = "UPDATE account_loan_act_ln SET act_ln_amount = ".sqlstrval($act_ln_amount).", act_ln_interest = ".sqlstrval($act_ln_interest).", act_ln_fine = ".sqlstrval($act_ln_fine).", act_ln_interest_rate = ".sqlstrval($new_interest_rate->cr1).", act_ln_duration = ".sqlstrval($new_interest_rate->cd1).", act_ln_loans = ".sqlstrval($act_ln_loans).", act_ln_app_id = NULL, act_ln_w_amount = 0, act_ln_w_fine = 0, act_ln_updated = ".sqlstr($nowStr)." WHERE act_ln_usr_id = ".strval($usr_id);
        $flag = $flag && (mysqli_query($con, $query) != false);
      }
      else // loan is not finished yet
      {
        $query = "UPDATE account_loan_act_ln SET act_ln_w_owned = ".sqlstrval($act_trn_owned).", act_ln_w_fine = ".sqlstrval($act_trn_fine).", act_ln_updated = ".sqlstr($nowStr)." WHERE act_ln_usr_id = ".strval($usr_id);
        $flag = $flag && (mysqli_query($con, $query) != false);
      }

      $act_mny_available = $act_trn_available - $act_mny_frozen;
      $act_mny_is_owned = $act_trn_owned > 0 ? 1 : 0;
      $act_mny_owned = $act_trn_owned;
      $act_mny_fine = $act_trn_fine;
      $act_mny_total = compute_money_total($act_mny_available, $act_mny_frozen, $act_mny_investment, $act_mny_loaned, $act_mny_interest, $act_mny_owned, $act_mny_fine);
      $query = "UPDATE account_money_act_mny SET act_mny_available = ".sqlstrval($act_mny_available).", act_mny_is_owned = ".sqlstrval($act_mny_is_owned).", act_mny_owned = ".sqlstrval($act_mny_owned).", act_mny_fine = ".sqlstrval($act_mny_fine).", act_mny_total = ".sqlstrval($act_mny_total).", act_mny_updated = ".sqlstr($nowStr)." WHERE act_mny_usr_id = ".strval($usr_id);
      $flag = $flag && (mysqli_query($con, $query) != false);
    }

    if ($flag)
    {
      mysqli_commit($con);
      $json = "{\"result\":1}";
    }
    else
    {
      mysqli_rollback($con);
      $json = "{\"result\":0,\"message\":\"DB write failure\"}";
    }
  }
  mysqli_query($con, "UNLOCK TABLES");

  return $json;
}
?>