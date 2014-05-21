<?php

include_once 'util_hyd_log.php';

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

$type = str2int($_GET['type']);
if ($type == 2)
{
  $repayment_7 = str2int($_GET['repayment_7']);
  if ($repayment_7 < 0 || $repayment_7 > 3)
  {
    $repayment_7 = 0;
  }
  $repayment_3 = str2int($_GET['repayment_3']);
  if ($repayment_3 < 0 || $repayment_3 > 3)
  {
    $repayment_3 = 0;
  }
  $overdue = str2int($_GET['overdue']);
  if ($overdue < 0 || $overdue > 3)
  {
    $overdue = 0;
  }
  $investment = str2int($_GET['investment']);
  if ($investment < 0 || $investment > 3)
  {
    $investment = 0;
  }
  $withdraw = str2int($_GET['withdraw']);
  if ($withdraw < 0 || $withdraw > 3)
  {
    $withdraw = 0;
  }
  hyd_log($now, $usr_id, "通知设置", "还款前7天, 还款前3天, 还款逾期, 投资到期, 提现结果", "type=".strval($type)."&repayment_7=".strval($repayment_7)."&repayment_3=".strval($repayment_3)."&overdue=".strval($overdue)."&investment=".strval($investment)."&withdraw=".strval($withdraw));
}

$con=mysqli_connect($db_host, $db_user, $db_pwd, $db_name);
// Check connection
if (mysqli_connect_errno())
{
  echo "{\"result\":0}";
  exit;
}
mysqli_set_charset($con, "UTF8");

$json = "{\"result\":0}";
switch ($type)
{
  case 2: // inserting
    $query = "INSERT INTO notices_nt (nt_time, nt_usr_id, nt_repayment_7, nt_repayment_3, nt_overdue, nt_receive, nt_withdraw) VALUES (".sqlstr($nowStr).",".sqlstrval($usr_id).",".sqlstrval($repayment_7).",".sqlstrval($repayment_3).",".sqlstrval($overdue).",".sqlstrval($investment).",".sqlstrval($withdraw).")";
    mysqli_query($con, "LOCK TABLES notices_nt WRITE");
    $flag = mysqli_query($con, $query) != false;
    mysqli_query($con, "UNLOCK TABLES");
    if ($flag)
    {
      $json = "{\"result\":1}";
    }
    else
    {
      $json = "{\"result\":0,\"message\":\"DB write failure\"}";
    }
    break;
  default: // read
    $query = "SELECT nt_repayment_7, nt_repayment_3, nt_overdue, nt_receive, nt_withdraw FROM notices_nt ORDER BY nt_time DESC LIMIT 0,1";
    mysqli_query($con, "LOCK TABLES notices_nt READ");
    $result = mysqli_query($con, $query);
    mysqli_query($con, "UNLOCK TABLES");
    if ($row = mysqli_fetch_array($result))
    {
      $nt_repayment_7 = $row['nt_repayment_7'];
      $nt_repayment_3 = $row['nt_repayment_3'];
      $nt_overdue = $row['nt_overdue'];
      $nt_receive = $row['nt_receive'];
      $nt_withdraw = $row['nt_withdraw'];
      mysqli_free_result($result1);
      $json = "{\"repayment_7\":".jsonstrval($nt_repayment_7).",\"repayment_3\":".jsonstrval($nt_repayment_3).",\"overdue\":".jsonstrval($nt_overdue).",\"investment\":".jsonstrval($nt_receive).",\"withdraw\":".jsonstrval($nt_withdraw)."}";
    }
    break;
}

mysqli_kill($con, mysqli_thread_id($con));
mysqli_close($con);
echo $json;
?>