<?php

include_once 'util_global.php';

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
mysqli_query($con, "LOCK TABLES applications_app READ, account_info_act_info READ");
$total = 0;
if ($page == 1)
{
  $query = "SELECT COUNT(app_usr_id) AS cnt FROM applications_app WHERE app_is_done = 1 AND app_is_loaned IS NULL";
  $result = mysqli_query($con, $query);
  if ($row = mysqli_fetch_array($result))
  {
    $total = $row['cnt'];
    mysqli_free_result($result);
  }
}
$start = ($page - 1) * $per_page;
$query = "SELECT app_id, app_title, app_usr_id, act_info_nick, app_category, app_amount, app_duration, app_applied, app_comment FROM applications_app LEFT JOIN account_info_act_info ON app_usr_id = act_info_usr_id WHERE app_is_done = 1 AND app_is_loaned IS NULL ORDER BY app_applied ASC LIMIT ".strval($start).",".strval($per_page);
$result = mysqli_query($con, $query);
mysqli_query($con, "UNLOCK TABLES");
while ($row = mysqli_fetch_array($result))
{
  $app_id = $row['app_id'];
  $app_title = $row['app_title'];
  $app_usr_id = $row['app_usr_id'];
  $act_info_nick = $row['act_info_nick'];
  $app_category = $row['app_category'];
  $app_amount = $row['app_amount'];
  $app_duration = $row['app_duration'];
  $app_applied = $row['app_applied'];
  $app_comment = $row['app_comment'];

  $json = $json.",{\"app_id\":".jsonstrval($app_id).",\"title\":".jsonstr($app_title).",\"user_id\":".jsonstrval($app_usr_id).",\"nick\":".jsonstr($act_info_nick).",\"category\":".jsonstrval($app_category).",\"amount\":".jsonstrval($app_amount).",\"duration\":".jsonstrval($app_duration).",\"applied\":".jsonstr($app_applied).",\"comment\":".jsonstr($app_comment)."}";
}
mysqli_free_result($result);

mysqli_kill($con, mysqli_thread_id($con));
mysqli_close($con);

$json = substr($json, 1);
$json = "{\"total\":".jsonstrval($total).",\"applications\":[".$json."]}";
echo $json;
?>