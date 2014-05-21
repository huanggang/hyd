<?php

include_once 'util_check_pre_investment.php';

function check_pre_investments()
{
  global $time_backend_start, $time_backend_end, $db_host, $db_user, $db_pwd, $db_name;
  if (!is_now_valid($time_backend_start, $time_backend_end))
  {
    return false;
  }
  $now = new DateTime;
  $nowStr = $now->format("Y-m-d\TH:i:sP");

  $con=mysqli_connect($db_host, $db_user, $db_pwd, $db_name);
  if (mysqli_connect_errno())
  {
    return false;
  }
  mysqli_set_charset($con, "UTF8");
  mysqli_query($con, "LOCK TABLES investments_inv READ");
  $result = mysqli_query($con, "SELECT inv_app_id FROM investments_inv WHERE inv_is_done IS NULL AND inv_updated < '".$nowStr."'");
  mysqli_query($con, "UNLOCK TABLES");
  mysqli_kill($con, mysqli_thread_id($con));
  mysqli_close($con);
  while ($row = mysqli_fetch_array($result)) // has unfinished loans
  {
    $inv_app_id = $row['inv_app_id'];
    $is_created = check_pre_investment($inv_app_id);
  }
  mysqli_free_result($result);
  return true;
}
?>