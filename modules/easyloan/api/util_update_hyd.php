<?php

include_once 'util_global.php';
include_once 'util_compute_interest.php';
include_once 'util_compute_average_interest_rate.php';
include_once 'util_compute_fine.php';

function update_hyd($app_id)
{
  global $db_host, $db_user, $db_pwd, $db_name;
  $con=mysqli_connect($db_host, $db_user, $db_pwd, $db_name);
  if (mysqli_connect_errno())
  {
    return false;
  }
  mysqli_set_charset($con, "UTF8");

  $flag = true;
  $is_owned = false;
  $todayStr = date("Y-m-d");
  $today = new DateTime($todayStr);// date_create_from_format('Y-m-d', $todayStr);
  $now = new DateTime;
  $nowStr = $now->format("Y-m-d\TH:i:sP");

  mysqli_autocommit($con, false);
  mysqli_query($con, "LOCK TABLES hyd_loans_hyd_ln WRITE, loans_lns READ, investments_inv WRITE, account_loan_act_ln READ, investment_accounts_inv_act READ, account_investments_act_invs WRITE, account_money_act_mny WRITE, account_transactions_act_trn WRITE, account_investment_act_inv WRITE");

  $result = mysqli_query($con, "SELECT hyd_ln_usr_id, hyd_ln_total, hyd_ln_count, hyd_ln_r_amount, hyd_ln_r_interest, hyd_ln_w_amount, hyd_ln_w_interest, hyd_ln_n_date, hyd_ln_n_amount, hyd_ln_n_interest, hyd_ln_w_owned, hyd_ln_w_fine, hyd_ln_updated FROM hyd_loans_hyd_ln WHERE hyd_ln_app_id = ".strval($app_id)." AND (hyd_ln_n_date IS NOT NULL OR hyd_ln_w_owned > 0) AND hyd_ln_updated < ".sqlstr($nowStr));
  if ($row = mysqli_fetch_array($result))
  {
    $hyd_ln_usr_id = $row['hyd_ln_usr_id'];
    $hyd_ln_total = $row['hyd_ln_total'];
    $hyd_ln_count = $row['hyd_ln_count'];
    $hyd_ln_r_amount = $row['hyd_ln_r_amount'];
    $hyd_ln_r_interest = $row['hyd_ln_r_interest'];
    $hyd_ln_w_amount = $row['hyd_ln_w_amount'];
    $hyd_ln_w_interest = $row['hyd_ln_w_interest'];
    $hyd_ln_n_date = $row['hyd_ln_n_date'];
    $hyd_ln_n_amount = $row['hyd_ln_n_amount'];
    $hyd_ln_n_interest = $row['hyd_ln_n_interest'];
    $hyd_ln_w_owned = $row['hyd_ln_w_owned'];
    $hyd_ln_w_fine = $row['hyd_ln_w_fine'];
    $hyd_ln_updated = $row['hyd_ln_updated'];
    mysqli_free_result($result);

    $result = mysqli_query($con, "SELECT lns_is_done FROM loans_lns WHERE lns_app_id = ".strval($app_id));
    $row = mysqli_fetch_array($result);
    $lns_is_done = $row['lns_is_done'];
    mysqli_free_result($result);

    $result = mysqli_query($con, "SELECT inv_investment, inv_interest_rate, inv_repayment_method, inv_duration, inv_start, inv_end, inv_fine_rate, inv_fine_rate_is_single, inv_fine FROM investments_inv WHERE inv_app_id = ".strval($app_id));
    $row = mysqli_fetch_array($result);
    $inv_investment = $row['inv_investment'];
    $inv_interest_rate = $row['inv_interest_rate'];
    $inv_repayment_method = $row['inv_repayment_method'];
    $inv_duration = $row['inv_duration'];
    $inv_start = $row['inv_start'];
    $inv_end = $row['inv_end'];
    $inv_fine_rate = $row['inv_fine_rate'];
    $inv_fine_rate_is_single = $row['inv_fine_rate_is_single'];
    $inv_fine = $row['inv_fine'];
    mysqli_free_result($result);

    $result = mysqli_query($con, "SELECT act_ln_w_owned, act_ln_w_fine FROM account_loan_act_ln WHERE act_ln_usr_id = ".strval($hyd_ln_usr_id));
    $row = mysqli_fetch_array($result);
    $act_ln_w_owned = $row['act_ln_w_owned'];
    $act_ln_w_fine = $row['act_ln_w_fine'];
    mysqli_free_result($result);

    if (!is_null($hyd_ln_n_date) && (new DateTime($hyd_ln_n_date)) <= $today) // it is the time to repay
    {
      $interest = compute_interest($inv_investment, $inv_interest_rate, $inv_repayment_method, $inv_start, $inv_end, $todayStr);
      $is_done = is_null($interest->n_date); // investment finished?
      if (is_null($inv_fine_rate_is_single) || (($act_ln_w_owned == 0 || $lns_is_done == 1) && $hyd_ln_w_owned == 0)) // HYD never overdues the repayment to the investers
      {
        if ($is_done)
        {
          $flag = $flag && (mysqli_query($con, "UPDATE hyd_loans_hyd_ln SET hyd_ln_count = ".sqlstrval($interest->count).", hyd_ln_r_amount = ".sqlstrval($interest->r_amount).", hyd_ln_r_interest = ".sqlstrval($interest->r_interest).", hyd_ln_w_amount = ".sqlstrval($interest->w_amount).", hyd_ln_w_interest = ".sqlstrval($interest->w_interest).", hyd_ln_n_date = NULL, hyd_ln_n_amount = ".sqlstrval($interest->n_amount).", hyd_ln_n_interest = ".sqlstrval($interest->n_interest).", hyd_ln_updated = ".sqlstr($nowStr)." WHERE hyd_ln_app_id = ".strval($app_id)) != false);
          $flag = $flag && (mysqli_query($con, "UPDATE investments_inv SET inv_is_done = 1, inv_finished = ".sqlstr($todayStr).", inv_updated = ".sqlstr($nowStr)." WHERE inv_app_id = ".strval($app_id)) != false);
        }
        else
        {
          $flag = $flag && (mysqli_query($con, "UPDATE hyd_loans_hyd_ln SET hyd_ln_count = ".sqlstrval($interest->count).", hyd_ln_r_amount = ".sqlstrval($interest->r_amount).", hyd_ln_r_interest = ".sqlstrval($interest->r_interest).", hyd_ln_w_amount = ".sqlstrval($interest->w_amount).", hyd_ln_w_interest = ".sqlstrval($interest->w_interest).", hyd_ln_n_date = ".sqlstr($interest->n_date).", hyd_ln_n_amount = ".sqlstrval($interest->n_amount).", hyd_ln_n_interest = ".sqlstrval($interest->n_interest).", hyd_ln_updated = ".sqlstr($nowStr)." WHERE hyd_ln_app_id = ".strval($app_id)) != false);
        }
        $result = mysqli_query($con, "SELECT inv_act_usr_id, inv_act_amount, inv_act_ratio FROM investment_accounts_inv_act WHERE inv_act_app_id = ".strval($app_id));
        while ($row = mysqli_fetch_array($result))
        {
          $inv_act_usr_id = $row['inv_act_usr_id'];
          $inv_act_amount = $row['inv_act_amount'];
          $inv_act_ratio = $row['inv_act_ratio'];

          $result1 = mysqli_query($con, "SELECT act_invs_r_fine, act_invs_n_amount, act_invs_n_interest, act_invs_a_amount, act_invs_a_interest, act_invs_updated FROM account_investments_act_invs WHERE act_invs_usr_id = ".strval($inv_act_usr_id)." AND act_invs_app_id = ".strval($app_id));
          $row1 = mysqli_fetch_array($result1);
          $act_invs_r_fine = $row1['act_invs_r_fine'];
          $act_invs_n_amount = $row1['act_invs_n_amount'];
          $act_invs_n_interest = $row1['act_invs_n_interest'];
          $act_invs_a_amount = $row1['act_invs_a_amount'];
          $act_invs_a_interest = $row1['act_invs_a_interest'];
          $act_invs_updated = $row1['act_invs_updated'];
          mysqli_free_result($result1);

          $result1 = mysqli_query($con, "SELECT act_mny_available, act_mny_frozen, act_mny_investment, act_mny_loaned, act_mny_interest, act_mny_is_owned, act_mny_owned, act_mny_fine, act_mny_total, act_mny_updated FROM account_money_act_mny WHERE act_mny_usr_id = ".strval($inv_act_usr_id));
          $row1 = mysqli_fetch_array($result1);
          $act_mny_available = $row1['act_mny_available'];
          $act_mny_frozen = $row1['act_mny_frozen'];
          $act_mny_investment = $row1['act_mny_investment'];
          $act_mny_loaned = $row1['act_mny_loaned'];
          $act_mny_interest = $row1['act_mny_interest'];
          $act_mny_is_owned = $row1['act_mny_is_owned'];
          $act_mny_owned = $row1['act_mny_owned'];
          $act_mny_fine = $row1['act_mny_fine'];
          $act_mny_total = $row1['act_mny_total'];
          $act_mny_updated = $row1['act_mny_updated'];
          mysqli_free_result($result1);

          $act_trn_available = $act_mny_available + $act_mny_frozen;
          if ($act_invs_n_interest > 0)
          {
            $act_trn_available += $act_invs_n_interest;
            $act_mny_available += $act_invs_n_interest;
            $flag = $flag && (mysqli_query($con, "INSERT INTO account_transactions_act_trn (act_trn_usr_id, act_trn_time, act_trn_type, act_trn_amount, act_trn_available, act_trn_owned, act_trn_fine, act_trn_note) VALUES (".sqlstrval($inv_act_usr_id).", ".sqlstr($nowStr).", 5, ".sqlstrval($act_invs_n_interest).", ".sqlstrval($act_trn_available).", ".sqlstrval($act_mny_owned).", ".sqlstrval($act_mny_fine).", NULL)") != false);
          }
          if ($act_invs_n_amount > 0)
          {
            $act_trn_available += $act_invs_n_amount;
            $act_mny_available += $act_invs_n_amount;
            $act_mny_investment -= $act_invs_n_amount;
            $flag = $flag && (mysqli_query($con, "INSERT INTO account_transactions_act_trn (act_trn_usr_id, act_trn_time, act_trn_type, act_trn_amount, act_trn_available, act_trn_owned, act_trn_fine, act_trn_note) VALUES (".sqlstrval($inv_act_usr_id).", ".sqlstr($nowStr).", 4, ".sqlstrval($act_invs_n_amount).", ".sqlstrval($act_trn_available).", ".sqlstrval($act_mny_owned).", ".sqlstrval($act_mny_fine).", NULL)") != false);
          }
          $act_mny_total = compute_money_total($act_mny_available, $act_mny_frozen, $act_mny_investment, $act_mny_loaned, $act_mny_interest, $act_mny_owned, $act_mny_fine);
          $flag = $flag && (mysqli_query($con, "UPDATE account_money_act_mny SET act_mny_available = ".sqlstrval($act_mny_available).", act_mny_investment = ".sqlstrval($act_mny_investment).", act_mny_total = ".sqlstrval($act_mny_total).", act_mny_updated = ".sqlstr($nowStr)." WHERE act_mny_usr_id = ".strval($inv_act_usr_id)) != false);
          $act_invs_a_amount += $act_invs_n_amount;
          $act_invs_a_interest += $act_invs_n_interest;
          $act_interest = compute_interest($inv_act_amount, $inv_interest_rate, $inv_repayment_method, $inv_start, $inv_end, $todayStr);
          if ($is_done)
          {
            $flag = $flag && (mysqli_query($con, "UPDATE account_investments_act_invs SET act_invs_is_done = 1, act_invs_r_amount = ".sqlstrval($act_interest->r_amount).", act_invs_r_interest = ".sqlstrval($act_interest->r_interest).", act_invs_w_amount = ".sqlstrval($act_interest->w_amount).", act_invs_w_interest = ".sqlstrval($act_interest->w_interest).", act_invs_n_date = NULL, act_invs_n_amount = ".sqlstrval($act_interest->n_amount).", act_invs_n_interest = ".sqlstrval($act_interest->n_interest).", act_invs_a_amount = ".sqlstrval($act_invs_a_amount).", act_invs_a_interest = ".sqlstrval($act_invs_a_interest).", act_invs_updated = ".sqlstr($nowStr)." WHERE act_invs_usr_id = ".strval($inv_act_usr_id)." AND act_invs_app_id = ".strval($app_id)) != false);
            $result1 = mysqli_query($con, "SELECT act_inv_amount, act_inv_interest, act_inv_fine, act_inv_interest_rate, act_inv_duration, act_inv_total, act_inv_holdings, act_inv_updated FROM account_investment_act_inv WHERE act_inv_usr_id = ".strval($inv_act_usr_id));
            $row1 = mysqli_fetch_array($result1);
            $act_inv_amount = $row1['act_inv_amount'];
            $act_inv_interest = $row1['act_inv_interest'];
            $act_inv_fine = $row1['act_inv_fine'];
            $act_inv_interest_rate = $row1['act_inv_interest_rate'];
            $act_inv_duration = $row1['act_inv_duration'];
            $act_inv_total = $row1['act_inv_total'];
            $act_inv_holdings = $row1['act_inv_holdings'];
            $act_inv_updated = $row1['act_inv_updated'];
            mysqli_free_result($result1);

            $act_rate = compute_average_interest_rate($act_inv_amount, $act_inv_interest_rate, $act_inv_duration, $inv_act_amount, $inv_interest_rate, round($inv_duration / 12.0, 4));
            $flag = $flag && (mysqli_query($con, "UPDATE account_investment_act_inv SET act_inv_amount = ".sqlstrval($act_inv_amount + $act_interest->r_amount).", act_inv_interest = ".sqlstrval($act_inv_interest + $act_interest->r_interest).", act_inv_fine = ".sqlstrval($act_inv_fine + $act_invs_r_fine).", act_inv_interest_rate = ".sqlstrval($act_rate->cr1).", act_inv_duration = ".sqlstrval($act_rate->cd1).", act_inv_total = ".sqlstrval($act_inv_total + 1).", act_inv_holdings = ".sqlstrval($act_inv_holdings - 1).", act_inv_updated = ".sqlstr($nowStr)." WHERE act_inv_usr_id = ".strval($inv_act_usr_id)) != false);
          }
          else
          {
            $flag = $flag && (mysqli_query($con, "UPDATE account_investments_act_invs SET act_invs_r_amount = ".sqlstrval($act_interest->r_amount).", act_invs_r_interest = ".sqlstrval($act_interest->r_interest).", act_invs_w_amount = ".sqlstrval($act_interest->w_amount).", act_invs_w_interest = ".sqlstrval($act_interest->w_interest).", act_invs_n_date = ".sqlstr($act_interest->n_date).", act_invs_n_amount = ".sqlstrval($act_interest->n_amount).", act_invs_n_interest = ".sqlstrval($act_interest->n_interest).", act_invs_a_amount = ".sqlstrval($act_invs_a_amount).", act_invs_a_interest = ".sqlstrval($act_invs_a_interest).", act_invs_updated = ".sqlstr($nowStr)." WHERE act_invs_usr_id = ".strval($inv_act_usr_id)." AND act_invs_app_id = ".strval($app_id)) != false);
          }
        }
        mysqli_free_result($result);
      }
      else // HYD may overdues the repayment to the investers
      {
        $date1 = str2date($hyd_ln_updated);
        $date2 = str2date($hyd_ln_n_date);
        if ($hyd_ln_w_owned > 0) // HYD has been owning to investers
        {
          if ($date1 < $date2)
          {
            $days = $date1->diff($date2)->days;
            if ($days > 0)
            {
              $delta_fine = compute_fine($hyd_ln_w_owned, $hyd_ln_w_fine, $inv_fine_rate, $inv_fine_rate_is_single, $days);
              $hyd_ln_w_fine += $delta_fine;
            }
          }
        }
        $hyd_ln_w_owned += $hyd_ln_n_amount + $hyd_ln_n_interest;
        if ($hyd_ln_w_owned > 0)
        {
          if ($date2 < $today)
          {
            $days = $date2->diff($today)->days;
            if ($days > 0)
            {
              $delta_fine = compute_fine($hyd_ln_w_owned, $hyd_ln_w_fine, $inv_fine_rate, $inv_fine_rate_is_single, $days);
              $hyd_ln_w_fine += $delta_fine;
            }
          }
        }

        $repay_amount = 0;
        $repay_fine = 0;
        if ($act_ln_w_owned == 0 || $lns_is_done == 1) // THEN previously: $hyd_ln_w_owned > 0
        {
          $repay_amount = $hyd_ln_w_owned;
          $repay_fine = $hyd_ln_w_fine;
          $hyd_ln_w_owned = 0;
          $hyd_ln_w_fine = 0;
        }
        else // THEN $act_ln_w_owned > 0 && $lns_is_done == 0
        { // previously: $hyd_ln_w_owned == 0 OR $hyd_ln_w_owned > 0
          $is_owned = true;
          if ($act_ln_w_owned < $hyd_ln_w_owned)
          {
            $repay_amount = $hyd_ln_w_owned - $act_ln_w_owned;
            $hyd_ln_w_owned = $act_ln_w_owned;
          }
          if ($act_ln_w_fine < $hyd_ln_w_fine)
          {
            $repay_fine = $hyd_ln_w_fine - $act_ln_w_fine;
            $hyd_ln_w_fine = $act_ln_w_fine;
          }
        }

        if ($is_done)
        {
          $flag = $flag && (mysqli_query($con, "UPDATE hyd_loans_hyd_ln SET hyd_ln_count = ".sqlstrval($interest->count).", hyd_ln_r_amount = ".sqlstrval($interest->r_amount).", hyd_ln_r_interest = ".sqlstrval($interest->r_interest).", hyd_ln_w_amount = ".sqlstrval($interest->w_amount).", hyd_ln_w_interest = ".sqlstrval($interest->w_interest).", hyd_ln_n_date = NULL, hyd_ln_n_amount = ".sqlstrval($interest->n_amount).", hyd_ln_n_interest = ".sqlstrval($interest->n_interest).", hyd_ln_w_owned = ".sqlstrval($hyd_ln_w_owned).", hyd_ln_w_fine = ".sqlstrval($hyd_ln_w_fine).", hyd_ln_updated = ".sqlstr($nowStr)." WHERE hyd_ln_app_id = ".strval($app_id)) != false);
          if ($hyd_ln_w_owned == 0)
          {
            $flag = $flag && (mysqli_query($con, "UPDATE investments_inv SET inv_is_done = 1, inv_finished = ".sqlstr($todayStr).", inv_fine = ".sqlstrval($inv_fine + $repay_fine).", inv_updated = ".sqlstr($nowStr)." WHERE inv_app_id = ".strval($app_id)) != false);
          }
          else if ($repay_fine > 0)
          {
            $flag = $flag && (mysqli_query($con, "UPDATE investments_inv SET inv_fine = ".sqlstrval($inv_fine + $repay_fine).", inv_updated = ".sqlstr($nowStr)." WHERE inv_app_id = ".strval($app_id)) != false);
          }
        }
        else
        {
          $flag = $flag && (mysqli_query($con, "UPDATE hyd_loans_hyd_ln SET hyd_ln_count = ".sqlstrval($interest->count).", hyd_ln_r_amount = ".sqlstrval($interest->r_amount).", hyd_ln_r_interest = ".sqlstrval($interest->r_interest).", hyd_ln_w_amount = ".sqlstrval($interest->w_amount).", hyd_ln_w_interest = ".sqlstrval($interest->w_interest).", hyd_ln_n_date = ".sqlstr($interest->n_date).", hyd_ln_n_amount = ".sqlstrval($interest->n_amount).", hyd_ln_n_interest = ".sqlstrval($interest->n_interest).", hyd_ln_w_owned = ".sqlstrval($hyd_ln_w_owned).", hyd_ln_w_fine = ".sqlstrval($hyd_ln_w_fine).", hyd_ln_updated = ".sqlstr($nowStr)." WHERE hyd_ln_app_id = ".strval($app_id)) != false);
          if ($repay_fine > 0)
          {
            $flag = $flag && (mysqli_query($con, "UPDATE investments_inv SET inv_fine = ".sqlstrval($inv_fine + $repay_fine).", inv_updated = ".sqlstr($nowStr)." WHERE inv_app_id = ".strval($app_id)) != false);
          }
        }
        $result = mysqli_query($con, "SELECT inv_act_usr_id, inv_act_amount, inv_act_ratio FROM investment_accounts_inv_act WHERE inv_act_app_id = ".strval($app_id));
        while ($row = mysqli_fetch_array($result))
        {
          $inv_act_usr_id = $row['inv_act_usr_id'];
          $inv_act_amount = $row['inv_act_amount'];
          $inv_act_ratio = $row['inv_act_ratio'];

          $result1 = mysqli_query($con, "SELECT act_invs_r_amount, act_invs_r_interest, act_invs_r_fine, act_invs_n_amount, act_invs_n_interest, act_invs_a_amount, act_invs_a_interest, act_invs_w_owned, act_invs_w_fine, act_invs_updated FROM account_investments_act_invs WHERE act_invs_usr_id = ".strval($inv_act_usr_id)." AND act_invs_app_id = ".strval($app_id));
          $row1 = mysqli_fetch_array($result1);
          $act_invs_r_amount = $row1['act_invs_r_amount'];
          $act_invs_r_interest = $row1['act_invs_r_interest'];
          $act_invs_r_fine = $row1['act_invs_r_fine'];
          $act_invs_n_amount = $row1['act_invs_n_amount'];
          $act_invs_n_interest = $row1['act_invs_n_interest'];
          $act_invs_a_amount = $row1['act_invs_a_amount'];
          $act_invs_a_interest = $row1['act_invs_a_interest'];
          $act_invs_w_owned = $row1['act_invs_w_owned'];
          $act_invs_w_fine = $row1['act_invs_w_fine'];
          $act_invs_updated = $row1['act_invs_updated'];
          mysqli_free_result($result1);

          $result1 = mysqli_query($con, "SELECT act_mny_available, act_mny_frozen, act_mny_investment, act_mny_loaned, act_mny_interest, act_mny_is_owned, act_mny_owned, act_mny_fine, act_mny_total, act_mny_updated FROM account_money_act_mny WHERE act_mny_usr_id = ".strval($inv_act_usr_id));
          $row1 = mysqli_fetch_array($result1);
          $act_mny_available = $row1['act_mny_available'];
          $act_mny_frozen = $row1['act_mny_frozen'];
          $act_mny_investment = $row1['act_mny_investment'];
          $act_mny_loaned = $row1['act_mny_loaned'];
          $act_mny_interest = $row1['act_mny_interest'];
          $act_mny_is_owned = $row1['act_mny_is_owned'];
          $act_mny_owned = $row1['act_mny_owned'];
          $act_mny_fine = $row1['act_mny_fine'];
          $act_mny_total = $row1['act_mny_total'];
          $act_mny_updated = $row1['act_mny_updated'];
          mysqli_free_result($result1);

          $date1 = str2date($act_invs_updated);
          $date2 = str2date($hyd_ln_n_date);
          if ($act_invs_w_owned > 0)
          {
            if ($date1 < $date2)
            {
              $days = $date1->diff($date2)->days;
              if ($days > 0)
              {
                $delta_fine = compute_fine($act_invs_w_owned, $act_invs_w_fine, $inv_fine_rate, $inv_fine_rate_is_single, $days);
                $act_invs_w_fine += $delta_fine;
              }
            }
          }
          $act_invs_w_owned += $act_invs_n_amount + $act_invs_n_interest;
          $act_interest = compute_interest($inv_act_amount, $inv_interest_rate, $inv_repayment_method, $inv_start, $inv_end, $todayStr);
          if ($act_invs_w_owned > 0)
          {
            if ($date2 < $today)
            {
              $days = $date2->diff($today)->days;
              if ($days > 0)
              {
                $delta_fine = compute_fine($act_invs_w_owned, $act_invs_w_fine, $inv_fine_rate, $inv_fine_rate_is_single, $days);
                $act_invs_w_fine += $delta_fine;
              }
            }
          }

          $act_repay_amount = 0;
          $act_repay_fine = 0;
          if ($hyd_ln_w_owned == 0)
          {
            $act_repay_amount = $act_invs_w_owned;
          }
          else
          {
            $act_repay_amount = round($repay_amount * $inv_act_ratio, 2);
          }
          if ($hyd_ln_w_fine == 0)
          {
            $act_repay_fine = $act_invs_w_fine;
          }
          else
          {
            $act_repay_fine = round($repay_fine * $inv_act_ratio, 2);
          }
          $act_invs_w_owned -= $act_repay_amount;
          if ($act_invs_w_owned < 0)
          {
            $act_invs_w_owned = 0;
          }
          $act_invs_w_fine -= $act_repay_fine;
          if ($act_invs_w_fine < 0)
          {
            $act_invs_w_fine = 0;
          }

          if ($act_repay_fine > 0)
          {
            $act_mny_available += $act_repay_fine;
            $flag = $flag && (mysqli_query($con, "INSERT INTO account_transactions_act_trn (act_trn_usr_id, act_trn_time, act_trn_type, act_trn_amount, act_trn_available, act_trn_owned, act_trn_fine, act_trn_note) VALUES (".sqlstrval($inv_act_usr_id).", ".sqlstr($nowStr).", 6, ".sqlstrval($act_repay_fine).", ".sqlstrval($act_mny_available + $act_mny_frozen).", ".sqlstrval($act_mny_owned).", ".sqlstrval($act_mny_fine).", NULL)") != false);

            $act_invs_r_fine += $act_repay_fine;
          }

          if ($act_repay_amount > 0)
          {
            $act_mny_available += $act_repay_amount;
            $flag = $flag && (mysqli_query($con, "INSERT INTO account_transactions_act_trn (act_trn_usr_id, act_trn_time, act_trn_type, act_trn_amount, act_trn_available, act_trn_owned, act_trn_fine, act_trn_note) VALUES (".sqlstrval($inv_act_usr_id).", ".sqlstr($nowStr).", 11, ".sqlstrval($act_repay_amount).", ".sqlstrval($act_mny_available + $act_mny_frozen).", ".sqlstrval($act_mny_owned).", ".sqlstrval($act_mny_fine).", NULL)") != false);

            $act_delta_amount = $act_interest->r_amount > $act_invs_a_amount ? ($act_interest->r_amount - $act_invs_a_amount) : 0;
            $act_delta_interest = $act_interest->r_interest > $act_invs_a_interest ? ($act_interest->r_interest - $act_invs_a_interest) : 0;
            if ($act_repay_amount < $act_delta_amount) // repay amount first
            {
              $act_delta_amount = $act_repay_amount;
              $act_delta_interest = 0;
            }
            else
            {
              $tmp_act_delta_interest = $act_repay_amount - $act_delta_amount;
              if ($tmp_act_delta_interest < $act_delta_interest)
              {
                $act_delta_interest = $tmp_act_delta_interest;
              }
            }
            $act_mny_investment -= $act_delta_amount;
            $act_invs_a_amount += $act_delta_amount;
            $act_invs_a_interest += $act_delta_interest;
          }

          $act_mny_total = compute_money_total($act_mny_available, $act_mny_frozen, $act_mny_investment, $act_mny_loaned, $act_mny_interest, $act_mny_owned, $act_mny_fine);
          $flag = $flag && (mysqli_query($con, "UPDATE account_money_act_mny SET act_mny_available = ".sqlstrval($act_mny_available).", act_mny_investment = ".sqlstrval($act_mny_investment).", act_mny_total = ".sqlstrval($act_mny_total).", act_mny_updated = ".sqlstr($nowStr)." WHERE act_mny_usr_id = ".strval($inv_act_usr_id)) != false);
          if ($is_done)
          {
            $act_invs_is_done = $act_invs_w_owned == 0 ? 1 : 0;
            $flag = $flag && (mysqli_query($con, "UPDATE account_investments_act_invs SET act_invs_is_done = ".sqlstrval($act_invs_is_done).", act_invs_r_amount = ".sqlstrval($act_interest->r_amount).", act_invs_r_interest = ".sqlstrval($act_interest->r_interest).", act_invs_r_fine = ".sqlstrval($act_invs_r_fine).", act_invs_w_amount = ".sqlstrval($act_interest->w_amount).", act_invs_w_interest = ".sqlstrval($act_interest->w_interest).", act_invs_n_date = NULL, act_invs_n_amount = ".sqlstrval($act_interest->n_amount).", act_invs_n_interest = ".sqlstrval($act_interest->n_interest).", act_invs_a_amount = ".sqlstrval($act_invs_a_amount).", act_invs_a_interest = ".sqlstrval($act_invs_a_interest).", act_invs_w_owned = ".sqlstrval($act_invs_w_owned).", act_invs_w_fine = ".sqlstrval($act_invs_w_fine).", act_invs_updated = ".sqlstr($nowStr)." WHERE act_invs_usr_id = ".strval($inv_act_usr_id)." AND act_invs_app_id = ".strval($app_id)) != false);

            if ($act_invs_is_done)
            {
              $result1 = mysqli_query($con, "SELECT act_inv_amount, act_inv_interest, act_inv_fine, act_inv_interest_rate, act_inv_duration, act_inv_total, act_inv_holdings, act_inv_updated FROM account_investment_act_inv WHERE act_inv_usr_id = ".strval($inv_act_usr_id));
              $row1 = mysqli_fetch_array($result1);
              $act_inv_amount = $row1['act_inv_amount'];
              $act_inv_interest = $row1['act_inv_interest'];
              $act_inv_fine = $row1['act_inv_fine'];
              $act_inv_interest_rate = $row1['act_inv_interest_rate'];
              $act_inv_duration = $row1['act_inv_duration'];
              $act_inv_total = $row1['act_inv_total'];
              $act_inv_holdings = $row1['act_inv_holdings'];
              $act_inv_updated = $row1['act_inv_updated'];
              mysqli_free_result($result1);

              $act_rate = compute_average_interest_rate($act_inv_amount, $act_inv_interest_rate, $act_inv_duration, $inv_act_amount, $inv_interest_rate, round($inv_duration / 12.0, 4));
              $flag = $flag && (mysqli_query($con, "UPDATE account_investment_act_inv SET act_inv_amount = ".sqlstrval($act_inv_amount + $act_interest->r_amount).", act_inv_interest = ".sqlstrval($act_inv_interest + $act_interest->r_interest).", act_inv_fine = ".sqlstrval($act_inv_fine + $act_invs_r_fine).", act_inv_interest_rate = ".sqlstrval($act_rate->cr1).", act_inv_duration = ".sqlstrval($act_rate->cd1).", act_inv_total = ".sqlstrval($act_inv_total + 1).", act_inv_holdings = ".sqlstrval($act_inv_holdings - 1).", act_inv_updated = ".sqlstr($nowStr)." WHERE act_inv_usr_id = ".strval($inv_act_usr_id)) != false);
            }
          }
          else
          {
            $flag = $flag && (mysqli_query($con, "UPDATE account_investments_act_invs SET act_invs_r_amount = ".sqlstrval($act_interest->r_amount).", act_invs_r_interest = ".sqlstrval($act_interest->r_interest).", act_invs_r_fine = ".sqlstrval($act_invs_r_fine).", act_invs_w_amount = ".sqlstrval($act_interest->w_amount).", act_invs_w_interest = ".sqlstrval($act_interest->w_interest).", act_invs_n_date = ".sqlstr($act_interest->n_date).", act_invs_n_amount = ".sqlstrval($act_interest->n_amount).", act_invs_n_interest = ".sqlstrval($act_interest->n_interest).", act_invs_a_amount = ".sqlstrval($act_invs_a_amount).", act_invs_a_interest = ".sqlstrval($act_invs_a_interest).", act_invs_w_owned = ".sqlstrval($act_invs_w_owned).", act_invs_w_fine = ".sqlstrval($act_invs_w_fine).", act_invs_updated = ".sqlstr($nowStr)." WHERE act_invs_usr_id = ".strval($inv_act_usr_id)." AND act_invs_app_id = ".strval($app_id)) != false);
          }
        }
        mysqli_free_result($result);
      }
    }
    else // not repayment day
    {
      if ($hyd_ln_w_owned > 0)
      {
        $date1 = str2date($hyd_ln_updated);
        if ($date1 < $today)
        {
          $days = $date1->diff($today)->days;
          if ($days > 0)
          {
            $delta_fine = compute_fine($hyd_ln_w_owned, $hyd_ln_w_fine, $inv_fine_rate, $inv_fine_rate_is_single, $days);
            $hyd_ln_w_fine += $delta_fine;
          }
        }

        $repay_amount = 0;
        $repay_fine = 0;
        if ($act_ln_w_owned == 0 || $lns_is_done == 1) // THEN previously: $hyd_ln_w_owned > 0
        {
          $repay_amount = $hyd_ln_w_owned;
          $repay_fine = $hyd_ln_w_fine;
          $hyd_ln_w_owned = 0;
          $hyd_ln_w_fine = 0;
        }
        else // THEN $act_ln_w_owned > 0 && $lns_is_done == 0
        { // previously: $hyd_ln_w_owned == 0 OR $hyd_ln_w_owned > 0
          $is_owned = true;
          if ($act_ln_w_owned < $hyd_ln_w_owned)
          {
            $repay_amount = $hyd_ln_w_owned - $act_ln_w_owned;
            $hyd_ln_w_owned = $act_ln_w_owned;
          }
          if ($act_ln_w_fine < $hyd_ln_w_fine)
          {
            $repay_fine = $hyd_ln_w_fine - $act_ln_w_fine;
            $hyd_ln_w_fine = $act_ln_w_fine;
          }
        }

        $is_done = is_null($hyd_ln_n_date);

        if ($is_done && $hyd_ln_w_owned == 0)
        {
          $flag = $flag && (mysqli_query($con, "UPDATE investments_inv SET inv_is_done = 1, inv_finished = ".sqlstr($todayStr).", inv_fine = ".sqlstrval($inv_fine + $repay_fine).", inv_updated = ".sqlstr($nowStr)." WHERE inv_app_id = ".strval($app_id)) != false);
        }
        else if ($repay_fine > 0)
        {
          $flag = $flag && (mysqli_query($con, "UPDATE investments_inv SET inv_fine = ".sqlstrval($inv_fine + $repay_fine).", inv_updated = ".sqlstr($nowStr)." WHERE inv_app_id = ".strval($app_id)) != false);
        }

        $flag = $flag && (mysqli_query($con, "UPDATE hyd_loans_hyd_ln SET hyd_ln_w_owned = ".sqlstrval($hyd_ln_w_owned).", hyd_ln_w_fine = ".sqlstrval($hyd_ln_w_fine).", hyd_ln_updated = ".sqlstr($nowStr)." WHERE hyd_ln_app_id = ".strval($app_id)) != false);

        $result = mysqli_query($con, "SELECT inv_act_usr_id, inv_act_amount, inv_act_ratio FROM investment_accounts_inv_act WHERE inv_act_app_id = ".strval($app_id));
        while ($row = mysqli_fetch_array($result))
        {
          $inv_act_usr_id = $row['inv_act_usr_id'];
          $inv_act_amount = $row['inv_act_amount'];
          $inv_act_ratio = $row['inv_act_ratio'];

          $result1 = mysqli_query($con, "SELECT act_invs_r_amount, act_invs_r_interest, act_invs_r_fine, act_invs_n_amount, act_invs_n_interest, act_invs_a_amount, act_invs_a_interest, act_invs_w_owned, act_invs_w_fine, act_invs_updated FROM account_investments_act_invs WHERE act_invs_usr_id = ".strval($inv_act_usr_id)." AND act_invs_app_id = ".strval($app_id));
          $row1 = mysqli_fetch_array($result1);
          $act_invs_r_amount = $row1['act_invs_r_amount'];
          $act_invs_r_interest = $row1['act_invs_r_interest'];
          $act_invs_r_fine = $row1['act_invs_r_fine'];
          $act_invs_n_amount = $row1['act_invs_n_amount'];
          $act_invs_n_interest = $row1['act_invs_n_interest'];
          $act_invs_a_amount = $row1['act_invs_a_amount'];
          $act_invs_a_interest = $row1['act_invs_a_interest'];
          $act_invs_w_owned = $row1['act_invs_w_owned'];
          $act_invs_w_fine = $row1['act_invs_w_fine'];
          $act_invs_updated = $row1['act_invs_updated'];
          mysqli_free_result($result1);

          $result1 = mysqli_query($con, "SELECT act_mny_available, act_mny_frozen, act_mny_investment, act_mny_loaned, act_mny_interest, act_mny_is_owned, act_mny_owned, act_mny_fine, act_mny_total, act_mny_updated FROM account_money_act_mny WHERE act_mny_usr_id = ".strval($inv_act_usr_id));
          $row1 = mysqli_fetch_array($result1);
          $act_mny_available = $row1['act_mny_available'];
          $act_mny_frozen = $row1['act_mny_frozen'];
          $act_mny_investment = $row1['act_mny_investment'];
          $act_mny_loaned = $row1['act_mny_loaned'];
          $act_mny_interest = $row1['act_mny_interest'];
          $act_mny_is_owned = $row1['act_mny_is_owned'];
          $act_mny_owned = $row1['act_mny_owned'];
          $act_mny_fine = $row1['act_mny_fine'];
          $act_mny_total = $row1['act_mny_total'];
          $act_mny_updated = $row1['act_mny_updated'];
          mysqli_free_result($result1);

          if ($act_invs_w_owned > 0)
          {
            $date1 = str2date($act_invs_updated);
            if ($date1 < $today)
            {
              $days = $date1->diff($today)->days;
              if ($days > 0)
              {
                $delta_fine = compute_fine($act_invs_w_owned, $act_invs_w_fine, $inv_fine_rate, $inv_fine_rate_is_single, $days);
                $act_invs_w_fine += $delta_fine;
              }
            }
          }

          $act_repay_amount = 0;
          $act_repay_fine = 0;
          if ($hyd_ln_w_owned == 0)
          {
            $act_repay_amount = $act_invs_w_owned;
          }
          else
          {
            $act_repay_amount = round($repay_amount * $inv_act_ratio, 2);
          }
          if ($hyd_ln_w_fine == 0)
          {
            $act_repay_fine = $act_invs_w_fine;
          }
          else
          {
            $act_repay_fine = round($repay_fine * $inv_act_ratio, 2);
          }
          $act_invs_w_owned -= $act_repay_amount;
          if ($act_invs_w_owned < 0)
          {
            $act_invs_w_owned = 0;
          }
          $act_invs_w_fine -= $act_repay_fine;
          if ($act_invs_w_fine < 0)
          {
            $act_invs_w_fine = 0;
          }

          if ($act_repay_fine > 0)
          {
            $act_mny_available += $act_repay_fine;
            $flag = $flag && (mysqli_query($con, "INSERT INTO account_transactions_act_trn (act_trn_usr_id, act_trn_time, act_trn_type, act_trn_amount, act_trn_available, act_trn_owned, act_trn_fine, act_trn_note) VALUES (".sqlstrval($inv_act_usr_id).", ".sqlstr($nowStr).", 6, ".sqlstrval($act_repay_fine).", ".sqlstrval($act_mny_available + $act_mny_frozen).", ".sqlstrval($act_mny_owned).", ".sqlstrval($act_mny_fine).", NULL)") != false);

            $act_invs_r_fine += $act_repay_fine;
          }

          if ($act_repay_amount > 0)
          {
            $act_mny_available += $act_repay_amount;
            $flag = $flag && (mysqli_query($con, "INSERT INTO account_transactions_act_trn (act_trn_usr_id, act_trn_time, act_trn_type, act_trn_amount, act_trn_available, act_trn_owned, act_trn_fine, act_trn_note) VALUES (".sqlstrval($inv_act_usr_id).", ".sqlstr($nowStr).", 11, ".sqlstrval($act_repay_amount).", ".sqlstrval($act_mny_available + $act_mny_frozen).", ".sqlstrval($act_mny_owned).", ".sqlstrval($act_mny_fine).", NULL)") != false);

            $act_delta_amount = $act_invs_r_amount > $act_invs_a_amount ? ($act_invs_r_amount - $act_invs_a_amount) : 0;
            $act_delta_interest = $act_invs_r_interest > $act_invs_a_interest ? ($act_invs_r_interest - $act_invs_a_interest) : 0;
            if ($act_repay_amount < $act_delta_amount) // repay amount first
            {
              $act_delta_amount = $act_repay_amount;
              $act_delta_interest = 0;
            }
            else
            {
              $tmp_act_delta_interest = $act_repay_amount - $act_delta_amount;
              if ($tmp_act_delta_interest < $act_delta_interest)
              {
                $act_delta_interest = $tmp_act_delta_interest;
              }
            }
            $act_mny_investment -= $act_delta_amount;
            $act_invs_a_amount += $act_delta_amount;
            $act_invs_a_interest += $act_delta_interest;
          }

          $act_mny_total = compute_money_total($act_mny_available, $act_mny_frozen, $act_mny_investment, $act_mny_loaned, $act_mny_interest, $act_mny_owned, $act_mny_fine);
          $flag = $flag && (mysqli_query($con, "UPDATE account_money_act_mny SET act_mny_available = ".sqlstrval($act_mny_available).", act_mny_investment = ".sqlstrval($act_mny_investment).", act_mny_total = ".sqlstrval($act_mny_total).", act_mny_updated = ".sqlstr($nowStr)." WHERE act_mny_usr_id = ".strval($inv_act_usr_id)) != false);
          if ($is_done)
          {
            $act_invs_is_done = $act_invs_w_owned == 0 ? 1 : 0;
            $flag = $flag && (mysqli_query($con, "UPDATE account_investments_act_invs SET act_invs_is_done = ".sqlstrval($act_invs_is_done).", act_invs_r_fine = ".sqlstrval($act_invs_r_fine).", act_invs_a_amount = ".sqlstrval($act_invs_a_amount).", act_invs_a_interest = ".sqlstrval($act_invs_a_interest).", act_invs_w_owned = ".sqlstrval($act_invs_w_owned).", act_invs_w_fine = ".sqlstrval($act_invs_w_fine).", act_invs_updated = ".sqlstr($nowStr)." WHERE act_invs_usr_id = ".strval($inv_act_usr_id)." AND act_invs_app_id = ".strval($app_id)) != false);

            if ($act_invs_is_done)
            {
              $result1 = mysqli_query($con, "SELECT act_inv_amount, act_inv_interest, act_inv_fine, act_inv_interest_rate, act_inv_duration, act_inv_total, act_inv_holdings, act_inv_updated FROM account_investment_act_inv WHERE act_inv_usr_id = ".strval($inv_act_usr_id));
              $row1 = mysqli_fetch_array($result1);
              $act_inv_amount = $row1['act_inv_amount'];
              $act_inv_interest = $row1['act_inv_interest'];
              $act_inv_fine = $row1['act_inv_fine'];
              $act_inv_interest_rate = $row1['act_inv_interest_rate'];
              $act_inv_duration = $row1['act_inv_duration'];
              $act_inv_total = $row1['act_inv_total'];
              $act_inv_holdings = $row1['act_inv_holdings'];
              $act_inv_updated = $row1['act_inv_updated'];
              mysqli_free_result($result1);

              $act_rate = compute_average_interest_rate($act_inv_amount, $act_inv_interest_rate, $act_inv_duration, $inv_act_amount, $inv_interest_rate, round($inv_duration / 12.0, 4));
              $flag = $flag && (mysqli_query($con, "UPDATE account_investment_act_inv SET act_inv_amount = ".sqlstrval($act_inv_amount + $act_invs_r_amount).", act_inv_interest = ".sqlstrval($act_inv_interest + $act_invs_r_interest).", act_inv_fine = ".sqlstrval($act_inv_fine + $act_invs_r_fine).", act_inv_interest_rate = ".sqlstrval($act_rate->cr1).", act_inv_duration = ".sqlstrval($act_rate->cd1).", act_inv_total = ".sqlstrval($act_inv_total + 1).", act_inv_holdings = ".sqlstrval($act_inv_holdings - 1).", act_inv_updated = ".sqlstr($nowStr)." WHERE act_inv_usr_id = ".strval($inv_act_usr_id)) != false);
            }
          }
          else
          {
            $flag = $flag && (mysqli_query($con, "UPDATE account_investments_act_invs SET act_invs_r_fine = ".sqlstrval($act_invs_r_fine).", act_invs_a_amount = ".sqlstrval($act_invs_a_amount).", act_invs_a_interest = ".sqlstrval($act_invs_a_interest).", act_invs_w_owned = ".sqlstrval($act_invs_w_owned).", act_invs_w_fine = ".sqlstrval($act_invs_w_fine).", act_invs_updated = ".sqlstr($nowStr)." WHERE act_invs_usr_id = ".strval($inv_act_usr_id)." AND act_invs_app_id = ".strval($app_id)) != false);
          }
        }
        mysqli_free_result($result);
      }
      else // not own anything to the investers
      {
        $flag = $flag && (mysqli_query($con, "UPDATE hyd_loans_hyd_ln SET hyd_ln_updated = ".sqlstr($nowStr)." WHERE hyd_ln_app_id = ".strval($app_id)) != false);
      }
    }
    $flag = $flag && (mysqli_query($con, "UPDATE investments_inv SET inv_updated = ".sqlstr($nowStr)." WHERE inv_app_id = ".strval($app_id)) != false);
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
  return ($is_owned && $flag);
}
?>