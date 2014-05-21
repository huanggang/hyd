<?php

include_once 'util_global.php';

if ($user->uid <= 0)
{
  echo "{\"result\":0}";
  exit;
}

if (!is_accountant($user) && !is_administrator($user))
{
  echo "{\"result\":0}";
  exit;
}

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

$json = "";
mysqli_query($con, "LOCK TABLES account_money_act_mny READ, account_info_act_info READ, loans_lns READ");
$total = 0;
if ($page == 1)
{
  $query = "SELECT COUNT(act_mny_usr_id) AS cnt FROM account_money_act_mny WHERE act_mny_is_owned = 1";
  $result = mysqli_query($con, $query);
  if ($row = mysqli_fetch_array($result))
  {
    $total = $row['cnt'];
    mysqli_free_result($result);
  }
}
$start = ($page - 1) * $per_page;
$query = "SELECT act_mny_owned, act_mny_usr_id, act_info_nick, act_info_name, lns_app_id, lns_title, lns_category, lns_amount, lns_interest, lns_interest_rate, lns_repayment_method, lns_duration, lns_start, lns_end FROM account_money_act_mny LEFT JOIN account_info_act_info ON act_mny_usr_id = act_info_usr_id LEFT JOIN loans_lns ON act_mny_usr_id = lns_usr_id WHERE act_mny_is_owned = 1 AND lns_is_done = 0 ORDER BY act_mny_owned DESC LIMIT ".strval($start).",".strval($per_page);
$result = mysqli_query($con, $query);
mysqli_query($con, "UNLOCK TABLES");
while ($row = mysqli_fetch_array($result))
{
  $act_mny_owned = $row['act_mny_owned'];
  $act_mny_usr_id = $row['act_mny_usr_id'];
  $act_info_nick = $row['act_info_nick'];
  $act_info_name = $row['act_info_name'];
  $lns_app_id = $row['lns_app_id'];
  $lns_title = $row['lns_title'];
  $lns_category = $row['lns_category'];
  $lns_amount = $row['lns_amount'];
  $lns_interest = $row['lns_interest'];
  $lns_interest_rate = $row['lns_interest_rate'];
  $lns_repayment_method = $row['lns_repayment_method'];
  $lns_duration = $row['lns_duration'];
  $lns_start = $row['lns_start'];
  $lns_end = $row['lns_end'];

  $json = $json.",{\"owned\":".jsonstrval($act_mny_owned).",\"user_id\":".jsonstrval($act_mny_usr_id).",\"nick\":".jsonstr($act_info_nick).",\"name\":".jsonstr($act_info_name).",\"app_id\":".jsonstrval($lns_app_id).",\"title\":".jsonstr($lns_title).",\"category\":".jsonstrval($lns_category).",\"amount\":".jsonstrval($lns_amount).",\"interest\":".jsonstrval($lns_interest).",\"rate\":".jsonstrval($lns_interest_rate).",\"repayment_method\":".jsonstrval($lns_repayment_method).",\"duration\":".jsonstrval($lns_duration).",\"start\":".jsonstr($lns_start).",\"end\":".jsonstr($lns_end)."}";
}
mysqli_free_result($result);

mysqli_kill($con, mysqli_thread_id($con));
mysqli_close($con);

$json = substr($json, 1);
$json = "{\"total\":".jsonstrval($total).",\"users\":[".$json."]}";
echo $json;
?>