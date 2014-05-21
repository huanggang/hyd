<?php

include_once 'util_global.php';

if ($user->uid <= 0)
{
  echo "{\"result\":0}";
  exit;
}

if (!is_manager($user) && !is_administrator($user))
{
  echo "{\"result\":0}";
  exit;
}

$type = str2int($_GET['type']);

$page = str2int($_GET['page']);
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

$total = 0;
$json = "";
switch ($type)
{
  case 2: // published
    mysqli_query($con, "LOCK TABLES investments_inv READ, loans_lns READ, account_info_act_info READ");
    if ($page == 1)
    {
      $query = "SELECT COUNT(inv_app_id) AS cnt FROM investments_inv";
      $result = mysqli_query($con, $query);
      if ($row = mysqli_fetch_array($result))
      {
        $total = $row['cnt'];
        mysqli_free_result($result);
      }
    }
    $start = ($page - 1) * $per_page;
    $query = "SELECT inv_app_id, inv_title, inv_usr_id, act_info_nick, inv_category, lns_amount, lns_interest, lns_interest_rate, lns_repayment_method, lns_duration, lns_start, lns_end, lns_fine_rate, lns_fine_rate_is_single, lns_finished, lns_fine, inv_amount, inv_interest_rate, inv_repayment_method, inv_duration, inv_start, inv_end, inv_investment, inv_interest, inv_fine_rate, inv_fine_rate_is_single, inv_finished, inv_fine, inv_created FROM investments_inv LEFT JOIN account_info_act_info ON inv_usr_id = act_info_usr_id LEFT JOIN loans_lns ON inv_app_id = lns_app_id ORDER BY inv_created DESC LIMIT ".strval($start).",".strval($per_page);
    $result = mysqli_query($con, $query);
    while ($row = mysqli_fetch_array($result))
    {
      $inv_app_id = $row['inv_app_id'];
      $inv_title = $row['inv_title'];
      $inv_usr_id = $row['inv_usr_id'];
      $act_info_nick = $row['act_info_nick'];
      $inv_category = $row['inv_category'];
      $lns_amount = $row['lns_amount'];
      $lns_interest = $row['lns_interest'];
      $lns_interest_rate = $row['lns_interest_rate'];
      $lns_repayment_method = $row['lns_repayment_method'];
      $lns_duration = $row['lns_duration'];
      $lns_start = $row['lns_start'];
      $lns_end = $row['lns_end'];
      $lns_fine_rate = $row['lns_fine_rate'];
      $lns_fine_rate_is_single = $row['lns_fine_rate_is_single'];
      $lns_finished = $row['lns_finished'];
      $lns_fine = $row['lns_fine'];
      $inv_amount = $row['inv_amount'];
      $inv_interest_rate = $row['inv_interest_rate'];
      $inv_repayment_method = $row['inv_repayment_method'];
      $inv_duration = $row['inv_duration'];
      $inv_start = $row['inv_start'];
      $inv_end = $row['inv_end'];
      $inv_investment = $row['inv_investment'];
      $inv_interest = $row['inv_interest'];
      $inv_fine_rate = $row['inv_fine_rate'];
      $inv_fine_rate_is_single = $row['inv_fine_rate_is_single'];
      $inv_finished = $row['inv_finished'];
      $inv_fine = $row['inv_fine'];
      $inv_created = $row['inv_created'];

      $value = "{\"app_id\":%d,\"title\":\"%s\",\"user_id\":%d,\"nick\":\"%s\",\"category\":%d,\"loan_amount\":%f,\"loan_interest\":%f,\"loan_rate\":%f,\"loan_duration\":%d,\"loan_start\":\"%s\",\"loan_end\":\"%s\",\"loan_fine_rate\":%f,\"loan_fine_is_single\":%d,\"loan_finished\":%s,\"loan_fine\":%f,\"investment_amount\":%f,\"investment_rate\":%f,\"investment_method\":%d,\"investment_duration\":%d,\"investment_start\":\"%s\",\"investment_end\":\"%s\",\"investment\":%f,\"investment_interest\":%f,\"investment_fine_rate\":%f,\"investment_fine_is_single\":%s,\"investment_finished\":%s,\"investment_fine\":%f,\"investment_created\":\"%s\"}";
      $value = sprintf($value, $inv_app_id, $inv_title, $inv_usr_id, $act_info_nick, $inv_category, $lns_amount, $lns_interest, $lns_interest_rate, $lns_repayment_method, $lns_duration, $lns_start, $lns_end, $lns_fine_rate, $lns_fine_rate_is_single, is_null($lns_finished) ? "null" : "\"".$lns_finished."\"", $lns_fine, $inv_amount, $inv_interest_rate, $inv_repayment_method, $inv_duration, $inv_start, $inv_end, $inv_investment, $inv_interest, $inv_fine_rate, is_null($inv_fine_rate_is_single) ? "null" : strval($inv_fine_rate_is_single), is_null($inv_finished) ? "null" : "\"".$inv_finished."\"", $inv_fine, $inv_created);
      $json = $json.",".$value;
    }
    mysqli_free_result($result);
    break;
  default: // not yet
    mysqli_query($con, "LOCK TABLES loans_lns READ, account_info_act_info READ");
    if ($page == 1)
    {
      $query = "SELECT COUNT(lns_app_id) AS cnt FROM loans_lns WHERE lns_is_published IS NULL";
      $result = mysqli_query($con, $query);
      if ($row = mysqli_fetch_array($result))
      {
        $total = $row['cnt'];
        mysqli_free_result($result);
      }
    }
    $start = ($page - 1) * $per_page;
    $query = "SELECT lns_app_id, lns_title, lns_usr_id, act_info_nick, lns_category, lns_amount, lns_interest, lns_interest_rate, lns_repayment_method, lns_duration, lns_start, lns_end, lns_fine_rate, lns_fine_rate_is_single, lns_created FROM loans_lns LEFT JOIN account_info_act_info ON lns_usr_id = act_info_usr_id WHERE lns_is_published IS NULL ORDER BY lns_created LIMIT ".strval($start).",".strval($per_page);
    $result = mysqli_query($con, $query);
    while ($row = mysqli_fetch_array($result))
    {
      $lns_app_id = $row['lns_app_id'];
      $lns_title = $row['lns_title'];
      $lns_usr_id = $row['lns_usr_id'];
      $act_info_nick = $row['act_info_nick'];
      $lns_category = $row['lns_category'];
      $lns_amount = $row['lns_amount'];
      $lns_interest = $row['lns_interest'];
      $lns_interest_rate = $row['lns_interest_rate'];
      $lns_repayment_method = $row['lns_repayment_method'];
      $lns_duration = $row['lns_duration'];
      $lns_start = $row['lns_start'];
      $lns_end = $row['lns_end'];
      $lns_fine_rate = $row['lns_fine_rate'];
      $lns_fine_rate_is_single = $row['lns_fine_rate_is_single'];
      $lns_created = $row['lns_created'];

      $json = $json.",{\"app_id\":".jsonstrval($lns_app_id).",\"title\":".jsonstr($lns_title).",\"user_id\":".jsonstrval($lns_usr_id).",\"nick\":".jsonstr($act_info_nick).",\"category\":".jsonstrval($lns_category).",\"amount\":".jsonstrval($lns_amount).",\"interest\":".jsonstrval($lns_interest).",\"rate\":".jsonstrval($lns_interest_rate).",\"method\":".jsonstrval($lns_repayment_method).",\"duration\":".jsonstrval($lns_duration).",\"start\":".jsonstr($lns_start).",\"end\":".jsonstr($lns_end).",\"fine_rate\":".jsonstrval($lns_fine_rate).",\"fine_is_single\":".jsonstrval($lns_fine_rate_is_single).",\"created\":".jsonstr($lns_created)."}";
    }
    mysqli_free_result($result);
    break;
}
mysqli_query($con, "UNLOCK TABLES");

mysqli_kill($con, mysqli_thread_id($con));
mysqli_close($con);

$json = substr($json, 1);
$json = "{\"total\":".jsonstrval($total).",\"withdraws\":[".$json."]}";
echo $json;
?>