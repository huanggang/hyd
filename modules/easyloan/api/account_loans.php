<?php

include_once 'util_global.php';

if ($user->uid <= 0)
{
  echo "{\"result\":0}";
  exit;
}
$usr_id = $user->uid;

$typeStr = $_GET["type"];
$type = str2int($typeStr);

$pageStr = $_GET["page"];
$page = str2int($pageStr);
if ($page <= 0)
{
  $page = 1;
}
else if ($page > $max_pages)
{
  $page = $max_pages;
}

$con=mysqli_connect($db_host, $db_user, $db_pwd, $db_name);
// Check connection
if (mysqli_connect_errno())
{
  echo "{\"result\":0}";
  exit;
}
mysqli_set_charset($con, "UTF8");

$json = "";
switch ($type)
{
  case 2: // loans
    $total = 0;
    if ($page == 1)
    {
      $query = "SELECT COUNT(lns_app_id) AS total FROM loans_lns WHERE lns_usr_id = ".strval($usr_id);
      mysqli_query($con, "LOCK TABLES loans_lns READ");
      $result = mysqli_query($con, $query);
      mysqli_query($con, "UNLOCK TABLES");
      if ($row = mysqli_fetch_array($result))
      {
        $total = $row['total'];
        mysqli_free_result($result);
      }
    }
    $start = ($page - 1) * $per_page;
    $query = "SELECT lns_app_id, lns_is_done, lns_title, lns_category, lns_amount, lns_interest, lns_interest_rate, lns_repayment_method, lns_duration, lns_start, lns_end, lns_fine, lns_finished FROM loans_lns WHERE lns_usr_id = ".strval($usr_id)." ORDER BY lns_created DESC LIMIT ".strval($start).",".strval($per_page);
    mysqli_query($con, "LOCK TABLES loans_lns READ");
    $result = mysqli_query($con, $query);
    mysqli_query($con, "UNLOCK TABLES");
    while ($row = mysqli_fetch_array($result))
    {
      $lns_app_id = $row['lns_app_id'];
      $lns_is_done = $row['lns_is_done'];
      $lns_title = $row['lns_title'];
      $lns_category = $row['lns_category'];
      $lns_amount = $row['lns_amount'];
      $lns_interest = $row['lns_interest'];
      $lns_interest_rate = $row['lns_interest_rate'];
      $lns_repayment_method = $row['lns_repayment_method'];
      $lns_duration = $row['lns_duration'];
      $lns_start = $row['lns_start'];
      $lns_end = $row['lns_end'];
      $lns_fine = $row['lns_fine'];
      $lns_finished = $row['lns_finished'];

      $json = $json.",{\"id\":".jsonstrval($lns_app_id).",\"is_done\":".jsonstrval($lns_is_done).",\"title\":".jsonstr($lns_title).",\"category\":".jsonstrval($lns_category).",\"amount\":".jsonstrval($lns_amount).",\"interest\":".jsonstrval($lns_interest).",\"rate\":".jsonstrval($lns_interest_rate).",\"method\":".jsonstrval($lns_repayment_method).",\"duration\":".jsonstrval($lns_duration).",\"start\":".jsonstr($lns_start).",\"end\":".jsonstr($lns_end).",\"fine\":".jsonstrval($lns_fine).",\"finished\":".jsonstr($lns_finished)."}";
    }
    mysqli_free_result($result);
    $json = substr($json, 1);
    $json = "{\"total\":".$total.",\"loans\":[".$json."]}";
    break;
  case 3: // applications
    $total = 0;
    if ($page == 1)
    {
      $query = "SELECT COUNT(app_id) AS total FROM applications_app WHERE app_usr_id = ".strval($usr_id);
      mysqli_query($con, "LOCK TABLES applications_app READ");
      $result = mysqli_query($con, $query);
      mysqli_query($con, "UNLOCK TABLES");
      if ($row = mysqli_fetch_array($result))
      {
        $total = $row['total'];
        mysqli_free_result($result);
      }
    }
    $start = ($page - 1) * $per_page;
    $query = "SELECT app_id, app_is_done, app_is_loaned, app_applied, app_status, app_title, app_category, app_amount, app_duration FROM applications_app WHERE app_usr_id = ".strval($usr_id)." ORDER BY app_applied DESC LIMIT ".strval($start).",".strval($per_page);
    mysqli_query($con, "LOCK TABLES applications_app READ");
    $result = mysqli_query($con, $query);
    mysqli_query($con, "UNLOCK TABLES");
    while ($row = mysqli_fetch_array($result))
    {
      $app_id = $row['app_id'];
      $app_is_done = $row['app_is_done'];
      $app_is_loaned = $row['app_is_loaned'];
      $app_applied = $row['app_applied'];
      $app_status = $row['app_status'];
      $app_title = $row['app_title'];
      $app_category = $row['app_category'];
      $app_amount = $row['app_amount'];
      $app_duration = $row['app_duration'];

      $json = $json.",{\"id\":".jsonstrval($app_id).",\"is_done\":".jsonstrval($app_is_done).",\"is_loaned\":".jsonstrval($app_is_loaned).",\"applied\":".jsonstr($app_applied).",\"status\":".jsonstrval($app_status).",\"title\":".jsonstr($app_title).",\"category\":".jsonstrval($app_category).",\"amount\":".jsonstrval($app_amount).",\"duration\":".jsonstrval($app_duration)."}";
    }
    mysqli_free_result($result);
    $json = substr($json, 1);
    $json = "{\"total\":".$total.",\"applications\":[".$json."]}";
    break;
  default:
    $query = "SELECT act_ln_amount, act_ln_interest, act_ln_fine, act_ln_interest_rate, act_ln_duration, act_ln_loans, act_ln_total, act_ln_count, act_ln_r_amount, act_ln_r_interest, act_ln_w_amount, act_ln_w_interest, act_ln_n_date, act_ln_n_amount, act_ln_n_interest, act_ln_w_owned, act_ln_w_fine FROM account_loan_act_ln WHERE act_ln_usr_id = ".strval($usr_id);
    mysqli_query($con, "LOCK TABLES account_loan_act_ln READ");
    $result = mysqli_query($con, $query);
    mysqli_query($con, "UNLOCK TABLES");
    if ($row = mysqli_fetch_array($result))
    {
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
      mysqli_free_result($result);
      $json = "{\"amount\":".jsonstrval($act_ln_amount).",\"interest\":".jsonstrval($act_ln_interest).",\"fine\":".jsonstrval($act_ln_fine).",\"rate\":".jsonstrval($act_ln_interest_rate).",\"duration\":".jsonstrval($act_ln_duration).",\"total\":".jsonstrval($act_ln_loans).",\"l_total\":".jsonstrval($act_ln_total).",\"l_count\":".jsonstrval($act_ln_count).",\"r_amount\":".jsonstrval($act_ln_r_amount).",\"r_interest\":".jsonstrval($act_ln_r_interest).",\"w_amount\":".jsonstrval($act_ln_w_amount).",\"w_interest\":".jsonstrval($act_ln_w_interest).",\"n_date\":".jsonstr($act_ln_n_date).",\"n_amount\":".jsonstrval($act_ln_n_amount).",\"n_interest\":".jsonstrval($act_ln_n_interest).",\"w_owned\":".jsonstrval($act_ln_w_owned).",\"w_fine\":".jsonstrval($act_ln_w_fine)."}";
    }
    break;
}

mysqli_kill($con, mysqli_thread_id($con));
mysqli_close($con);
echo $json;
?>