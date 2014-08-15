<?php

function manage_set_investment(){

  include_once 'util_hyd_log.php';

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

  if (!is_manager($user) && !is_administrator($user))
  {
    echo "{\"result\":0}";
    exit;
  }

  $type = str2int($_GET['type']);
  $app_id = str2int($_GET['app_id']);
  if ($app_id <= 0)
  {
    echo "{\"result\":0}";
    exit;
  }
  $amount = null; $rate = null; $method = null; $minimum = null; $step = null; $start = null; $end = null; $fine_rate = null; $fine_is_single = null; $duration = null;
  if ($type == 1)
  {
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
    $method = str2int($_GET['method']);
    if ($method <= 0)
    {
      echo "{\"result\":0}";
      exit;
    }
    $minimum = str2float($_GET['minimum']);
    if ($minimum <= 0)
    {
      echo "{\"result\":0}";
      exit;
    }
    $step = str2float($_GET['step']);
    if ($step <= 0)
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
    // check start-date > today, end-date > start-date
    if ($start >= $end || $start <= $today)
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

    $duration = compute_date_diff($start, $end);
    $duration = $duration->y * 12 + $duration->m + round($duration->d / 30.0, 0);

    $fine_rate = str2float($_GET['fine_rate']);
    if ($fine_rate < 0)
    {
      echo "{\"result\":0}";
      exit;
    }
    $fine_is_single = str2int($_GET['fine_is_single']);
    if ($fine_is_single < 0)
    {
      $fine_is_single = "NULL";
    }
    else if ($fine_is_single >= 1)
    {
      $fine_is_single = "1";
    }
    else
    {
      $fine_is_single = "0";
    }
  }

  switch ($type)
  {
    case 1:
      hyd_log($now, $usr_id, "投资产品", "发布: 借款申请编号, 投资金额, 年利率, 回收方式, 投资起点金额, 追加投资起点金额, 成立日期, 到期日期, 逾期日利率, 逾期日利率计算方式", "type=1&app_id=".strval($app_id)."&amount=".strval($amount)."&rate=".strval($rate)."&method=".strval($method)."&minimum=".strval($minimum)."&step=".strval($step)."&start=".$start->format("Y-m-d")."&end=".$end->format("Y-m-d")."&fine_rate=".strval($fine_rate)."&fine_is_single=".strval($fine_is_single));
      break;
    default:
      hyd_log($now, $usr_id, "投资产品", "拒绝: 借款申请编号", "type=0&app_id=".strval($app_id));
      break;
  }

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

  switch ($type)
  {
    case 1: // publishing
      mysqli_query($con, "LOCK TABLES loans_lns WRITE, investments_inv WRITE");
      $query = "SELECT lns_usr_id, lns_category, lns_title, lns_purpose, lns_asset_description, lns_has_certificate FROM loans_lns WHERE lns_app_id = ".strval($app_id);
      $result = mysqli_query($con, $query);
      if ($row = mysqli_fetch_array($result))
      {
        $lns_usr_id = $row['lns_usr_id'];
        $lns_category = $row['lns_category'];
        $lns_title = $row['lns_title'];
        $lns_purpose = $row['lns_purpose'];
        $lns_asset_description = $row['lns_asset_description'];
        $lns_has_certificate = $row['lns_has_certificate'];
        mysqli_free_result($result);

        $query = "UPDATE loans_lns SET lns_is_published = 1, lns_updated = ".sqlstr($nowStr)." WHERE lns_app_id = ".strval($app_id)." AND lns_is_published IS NULL";
        $flag = mysqli_query($con, $query) != false;

        $query = "INSERT INTO investments_inv (inv_app_id, inv_usr_id, inv_is_done, inv_mng_usr_id, inv_category, inv_created, inv_title, inv_amount, inv_purpose, inv_asset_description, inv_has_certificate, inv_interest_rate, inv_repayment_method, inv_minimum, inv_step, inv_duration, inv_start, inv_end, inv_investment, inv_interest, inv_fine_rate, inv_fine_rate_is_single, inv_finished, inv_fine, inv_updated) VALUES (".sqlstrval($app_id).",".sqlstrval($lns_usr_id).",0,".sqlstrval($usr_id).",".sqlstrval($lns_category).",".sqlstr($nowStr).",".sqlstr($lns_title).",".sqlstrval($amount).",".sqlstr($lns_purpose).",".sqlstr($lns_asset_description).",".sqlstrval($lns_has_certificate).",".sqlstrval($rate).",".sqlstrval($method).",".sqlstrval($minimum).",".sqlstrval($step).",".sqlstrval($duration).",".sqlstr($start->format("Y-m-d")).",".sqlstr($end->format("Y-m-d")).",0,0,".sqlstrval($fine_rate).",".sqlstrval($fine_is_single).",NULL,0,".sqlstr($nowStr).")";
        $flag = $flag && (mysqli_query($con, $query) != false);
      }
      break;
    default: // rejected
      mysqli_query($con, "LOCK TABLES loans_lns WRITE");
      $query = "UPDATE loans_lns SET lns_is_published = 0, lns_updated = ".sqlstr($nowStr)." WHERE lns_app_id = ".strval($app_id)." AND lns_is_published IS NULL";
      $flag = mysqli_query($con, $query) != false;
      break;
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