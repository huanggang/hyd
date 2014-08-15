<?php

function manage_set_loan(){

  include_once 'util_hyd_log.php';
  include_once 'util_compute_interest.php';

  $todayStr = date("Y-m-d");
  $today = new DateTime($todayStr);// date_create_from_format('Y-m-d', $todayStr);
  $now = new DateTime;
  $nowStr = $now->format("Y-m-d\TH:i:sP");

  if ($user->uid <= 0)
  {
    echo "{\"result\":0}";
    exit;
  }
  $usr_id = $user->uid;

  if (!is_accountant($user) && !is_administrator($user))
  {
    echo "{\"result\":0}";
    exit;
  }

  $app_id = str2int($_GET['app_id']);
  if ($app_id <= 0)
  {
    echo "{\"result\":0}";
    exit;
  }
  $loaned = str2datetime($_GET['loaned']);
  if (is_null($loaned))
  {
    echo "{\"result\":0}";
    exit;
  }
  $amount = str2float($_GET['amount']);
  if ($amount <= 0)
  {
    echo "{\"result\":0}";
    exit;
  }
  $rate = str2float($_GET['rate']);
  if ($rate <= 0)
  {
    echo "{\"result\":0}";
    exit;
  }
  $repayment_method = str2int($_GET['repayment_method']);
  if ($repayment_method <= 0 || $repayment_method > 5)
  {
    echo "{\"result\":0}";
    exit;
  }
  $start = str2datetime($_GET['start']);
  if (is_null($start))
  {
    echo "{\"result\":0}";
    exit;
  }
  $end = str2datetime($_GET['end']);
  if (is_null($end))
  {
    echo "{\"result\":0}";
    exit;
  }
  // check end-date > today, start-date < end-date, loaned-date < end-date, today - start-date < 1 month
  if ($loaned >= $end || $start >= $end || $end <= $today || ($start < $today && $start->diff($today)->days >= 28))
  {
    echo "{\"result\":0}";
    exit;
  }
  if ($repayment_method == 1)
  {// end-date - start-date >= 3 dyas
    if ($start->diff($end)->days < 3){
      echo "{\"result\":0}";
      exit;
    }
  }
  else if ($repayment_method == 2 || $repayment_method == 3)
  { // end-date - start-date >= 2 months
    if ($start->diff($end)->days < 59){
      echo "{\"result\":0}";
      exit;
    }
  }
  else if ($repayment_method == 4 || $repayment_method == 5) 
  { // end-date - start-date >= 3 months
    if ($start->diff($end)->days < 89){
      echo "{\"result\":0}";
      exit;
    }
  }

  $fine_rate = str2float($_GET['fine_rate']);
  if ($fine_rate < 0)
  {
    echo "{\"result\":0}";
    exit;
  }
  $fine_rate_is_single = str2int($_GET['fine_rate_is_single']);
  if ($fine_rate_is_single < 0 || $fine_rate_is_single > 1)
  {
    echo "{\"result\":0}";
    exit;
  }

  hyd_log($now, $usr_id, "借款放款", "借款申请编号, 放款日期, 借款金额, 年利率, 还款方式, 借款日期, 还款日期, 逾期日利率, 逾期日利率计算方式", "app_id=".strval($app_id)."&loaned=".$loaned->format("Y-m-d")."&amount=".strval($amount)."&rate=".strval($rate)."&repayment_method=".strval($repayment_method)."&start=".$start->format("Y-m-d")."&end=".$end->format("Y-m-d")."&fine_rate=".strval($fine_rate)."&fine_rate_is_single=".strval($fine_rate_is_single));

  $con=mysqli_connect($db_host, $db_user, $db_pwd, $db_name);
  // Check connection
  if (mysqli_connect_errno())
  {
    echo "{\"result\":0}";
    exit;
  }
  mysqli_set_charset($con, "UTF8");

  $flag = false;

  mysqli_autocommit($con, false);
  mysqli_query($con, "LOCK TABLES applications_app WRITE, loans_lns WRITE, account_loan_act_ln WRITE, account_money_act_mny WRITE, account_transactions_act_trn WRITE");

  $query = "SELECT lns_app_id FROM loans_lns WHERE lns_app_id = ".strval($app_id);
  $result = mysqli_query($con, $query);
  if (is_null(mysqli_fetch_array($result)))
  {
    mysqli_free_result($result);

    $query = "SELECT app_usr_id, app_category, app_title, app_purpose, app_asset_description, app_has_certificate FROM applications_app WHERE app_id = ".strval($app_id)." AND app_is_done = 1 AND app_is_loaned IS NULL";
    $result = mysqli_query($con, $query);
    if ($row = mysqli_fetch_array($result))
    {
      $app_usr_id = $row['app_usr_id'];
      $app_category = $row['app_category'];
      $app_title = $row['app_title'];
      $app_purpose = $row['app_purpose'];
      $app_asset_description = $row['app_asset_description'];
      $app_has_certificate = $row['app_has_certificate'];
      mysqli_free_result($result);

      $query = "SELECT act_mny_available, act_mny_frozen, act_mny_investment, act_mny_loaned, act_mny_interest, act_mny_owned, act_mny_fine FROM account_money_act_mny WHERE act_mny_usr_id = ".strval($app_usr_id);
      $result = mysqli_query($con, $query);
      if ($row = mysqli_fetch_array($result))
      {
        $act_mny_available = $row['act_mny_available'];
        $act_mny_frozen = $row['act_mny_frozen'];
        $act_mny_investment = $row['act_mny_investment'];
        $act_mny_loaned = $row['act_mny_loaned'];
        $act_mny_interest = $row['act_mny_interest'];
        $act_mny_owned = $row['act_mny_owned'];
        $act_mny_fine = $row['act_mny_fine'];
        mysqli_free_result($result);

        $query = "UPDATE applications_app SET app_is_loaned = 1 WHERE app_id = ".sqlstrval($app_id)." AND app_is_done = 1 AND app_is_loaned IS NULL";
        $flag = mysqli_query($con, $query) != false;

        $interest = compute_interest($amount, $rate, $repayment_method, $start->format("Y-m-d"), $end->format("Y-m-d"), $today->format("Y-m-d"));

        $duration = compute_date_diff($start, $end);
        $lns_duration = $duration->y * 12 + $duration->m + round($duration->d / 30.0, 0);

        $lns_interest = $interest->r_interest + $interest->w_interest;
        $query = "INSERT INTO loans_lns (lns_app_id, lns_usr_id, lns_is_done, lns_created, lns_mng_usr_id, lns_category, lns_title, lns_amount, lns_purpose, lns_asset_description, lns_has_certificate, lns_interest_rate, lns_repayment_method, lns_duration, lns_start, lns_end, lns_interest, lns_fine_rate, lns_fine_rate_is_single, lns_finished, lns_fine, lns_updated) VALUES (".sqlstrval($app_id).",".sqlstrval($app_usr_id).",0,".sqlstr($loaned->format("Y-m-d")).",".sqlstrval($usr_id).",".sqlstrval($app_category).",".sqlstr($app_title).",".sqlstrval($amount).",".sqlstr($app_purpose).",".sqlstr($app_asset_description).",".sqlstrval($app_has_certificate).",".sqlstrval($rate).",".sqlstrval($repayment_method).",".sqlstrval($lns_duration).",".sqlstr($start->format("Y-m-d")).",".sqlstr($end->format("Y-m-d")).",".sqlstrval($lns_interest).",".sqlstrval($fine_rate).",".sqlstrval($fine_rate_is_single).",NULL,0,".sqlstr($nowStr).")";
        $flag = $flag && (mysqli_query($con, $query) != false);
        
        $query = "UPDATE account_loan_act_ln SET act_ln_app_id = ".sqlstrval($app_id).", act_ln_total = ".sqlstrval($interest->total).", act_ln_count = ".sqlstrval($interest->count).", act_ln_r_amount = ".sqlstrval($interest->r_amount).", act_ln_r_interest = ".sqlstrval($interest->r_interest).", act_ln_w_amount = ".sqlstrval($interest->w_amount).", act_ln_w_interest = ".sqlstrval($interest->w_interest).", act_ln_n_date = ".sqlstr($interest->n_date).", act_ln_n_amount = ".sqlstrval($interest->n_amount).", act_ln_n_interest = ".sqlstrval($interest->n_interest).", act_ln_updated = ".sqlstr($nowStr)." WHERE act_ln_usr_id = ".strval($app_usr_id);
        $flag = $flag && (mysqli_query($con, $query) != false);

        $act_mny_loaned += $interest->w_amount;
        $act_mny_interest += $interest->w_interest;
        $act_mny_total = compute_money_total($act_mny_available, $act_mny_frozen, $act_mny_investment, $act_mny_loaned, $act_mny_interest, $act_mny_owned, $act_mny_fine);

        $query = "UPDATE account_money_act_mny SET act_mny_loaned = ".sqlstrval($act_mny_loaned).", act_mny_interest = ".sqlstrval($act_mny_interest).", act_mny_total = ".sqlstrval($act_mny_total).", act_mny_updated = ".sqlstr($nowStr)." WHERE act_mny_usr_id = ".strval($app_usr_id);
        $flag = $flag && (mysqli_query($con, $query) != false);

        $query = "INSERT INTO account_transactions_act_trn (act_trn_usr_id, act_trn_time, act_trn_type, act_trn_amount, act_trn_available, act_trn_owned, act_trn_fine, act_trn_note) VALUES (".sqlstrval($app_usr_id).",".sqlstr($nowStr).",7,".sqlstrval($act_mny_loaned).",".sqlstrval($act_mny_available).",".sqlstrval($act_mny_owned).",".sqlstrval($act_mny_fine).",NULL)";
        $flag = $flag && (mysqli_query($con, $query) != false);

        if ($interest->r_interest > 0)
        {
          $query = "INSERT INTO account_transactions_act_trn (act_trn_usr_id, act_trn_time, act_trn_type, act_trn_amount, act_trn_available, act_trn_owned, act_trn_fine, act_trn_note) VALUES (".sqlstrval($app_usr_id).",".sqlstr($nowStr).",9,".sqlstrval($interest->r_interest).",".sqlstrval($act_mny_available).",".sqlstrval($act_mny_owned).",".sqlstrval($act_mny_fine).",NULL)";
          $flag = $flag && (mysqli_query($con, $query) != false);
        }
      }
    }
  }
  if ($flag)
  {
    mysqli_commit($con);
    echo "{\"result\":1}";
  }
  else
  {
    mysqli_rollback($con);
    echo "{\"result\":0,\"message\":\"DB write failure\"}";
  }
  mysqli_query($con, "UNLOCK TABLES");

  mysqli_kill($con, mysqli_thread_id($con));
  mysqli_close($con);
}
?>