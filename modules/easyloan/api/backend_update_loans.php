<?php

include_once 'util_update_account.php';

function update_loans()
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
  mysqli_query($con, "LOCK TABLES loans_lns READ");
  $result = mysqli_query($con, "SELECT lns_usr_id FROM loans_lns WHERE lns_is_done = 0 AND lns_updated < ".sqlstr($nowStr));
  mysqli_query($con, "UNLOCK TABLES");
  mysqli_kill($con, mysqli_thread_id($con));
  mysqli_close($con);
  while ($row = mysqli_fetch_array($result)) // has unfinished loans
  {
    $lns_usr_id = $row['lns_usr_id'];
    $is_owned = update_account($lns_usr_id);
  }
  mysqli_free_result($result);
  return true;
}

update_loans();
?>