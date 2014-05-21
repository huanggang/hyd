<?php

include_once 'util_global.php';

function hyd_log($time, $usr_id, $type, $detail, $params)
{
  global $db_host, $db_user, $db_pwd, $db_name;
  $con=mysqli_connect($db_host, $db_user, $db_pwd, $db_name);
  if (mysqli_connect_errno())
  {
    return false;
  }
  mysqli_set_charset($con, "UTF8");

  $flag = false;
  $query = "INSERT INTO admin_logs_adm_lg (adm_lg_date, adm_lg_usr_id, adm_lg_type, adm_lg_detail, adm_lg_params) VALUES (?,?,?,?,?)";
  if ($stmt = mysqli_prepare($con, $query))
  {
    mysqli_stmt_bind_param($stmt, "sisss", $time->format("Y-m-d\TH:i:sP"), $usr_id, $type, $detail, $params);

    mysqli_query($con, "LOCK TABLES admin_logs_adm_lg WRITE");
    $flag = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    mysqli_query($con, "UNLOCK TABLES");
    mysqli_kill($con, mysqli_thread_id($con));
    mysqli_close($con);
  }
  return $flag;
}
?>