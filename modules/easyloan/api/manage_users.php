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
if ($type < 1 || $type > 3)
{
  echo "{\"result\":0}";
  exit;
}
$order = str2int($_GET['order']);
if ($order == 2)
{
  $order = "DESC";
}
else
{
  $order = "ASC";
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

mysqli_query($con, "LOCK TABLES users_usr READ, account_info_act_info READ, account_money_act_mny READ");

$total = 0;
if ($page == 1)
{
  $query = "SELECT COUNT(usr_id) AS cnt FROM users_usr";
  $result = mysqli_query($con, $query);
  if ($row = mysqli_fetch_array($result))
  {
    $total = $row['cnt'];
    mysqli_free_result($result);
  }
}

$start = ($page - 1) * $per_page;
$query = "SELECT usr_id, act_info_nick, act_info_name, act_mny_total, act_mny_available, act_mny_owned, act_mny_frozen, usr_registered, usr_logined FROM ";
switch ($type)
{
  case 1: // register time
    $query = $query."users_usr LEFT JOIN account_info_act_info ON usr_id = act_info_usr_id LEFT JOIN account_money_act_mny ON usr_id = act_mny_usr_id ORDER BY usr_registered ";
    break;
  case 2: // total money
    $query = $query."account_money_act_mny LEFT JOIN users_usr ON act_mny_usr_id = usr_id LEFT JOIN account_info_act_info ON usr_id = act_info_usr_id ORDER BY act_mny_total ";
    break;
  case 3: // login time
    $query = $query."users_usr LEFT JOIN account_info_act_info ON usr_id = act_info_usr_id LEFT JOIN account_money_act_mny ON usr_id = act_mny_usr_id ORDER BY usr_logined ";
    break;
}
$query = $query.$order." LIMIT ".strval($start).",".strval($per_page);

$json = "";

$result = mysqli_query($con, $query);
mysqli_query($con, "UNLOCK TABLES");
while ($row = mysqli_fetch_array($result))
{
  $usr_id = $row['usr_id'];
  $act_info_nick = $row['act_info_nick'];
  $act_info_name = $row['act_info_name'];
  $act_mny_total = $row['act_mny_total'];
  $act_mny_available = $row['act_mny_available'];
  $act_mny_owned = $row['act_mny_owned'];
  $act_mny_frozen = $row['act_mny_frozen'];
  $usr_registered = $row['usr_registered'];
  $usr_logined = $row['usr_logined'];

  $json = $json.",{\"id\":".jsonstrval($usr_id).",\"nick\":".jsonstr($act_info_nick).",\"name\":".jsonstr($act_info_name).",\"amount_total\":".jsonstrval($act_mny_total).",\"amount_available\":".jsonstrval($act_mny_available).",\"amount_owned\":".jsonstrval($act_mny_owned).",\"amount_frozen\":".jsonstrval($act_mny_frozen).",\"registered\":".jsonstr($usr_registered).",\"logined\":".jsonstr($usr_logined)."}";
}
mysqli_free_result($result);

mysqli_kill($con, mysqli_thread_id($con));
mysqli_close($con);

$json = substr($json, 1);
$json = "{\"result\":1,\"total\":".jsonstrval($total).",\"users\":[".$json."]}";

echo $json;
?>