<?php

include_once 'util_global.php';

function does_contact_exist($type, $value)
{
  $query = "SELECT ";
  switch ($type)
  {
    case 1: // mobile
      if (!is_valid_mobile($value))
      {
        return true;
      }
      $query = $query."act_info_mobile FROM account_info_act_info WHERE act_info_mobile=?";
      break;
    case 2: // email
      if (!is_valid_email($value))
      {
        return true;
      }
      $query = $query."act_info_email FROM account_info_act_info WHERE act_info_email=?";

      $now = new DateTime;
      $nowStr = $now->format("Y-m-d\TH:i:sP");
      $query1 = "UPDATE account_info_act_info SET act_info_email = NULL, act_info_email_status = NULL WHERE act_info_email=".sqlstr($value)." AND act_info_email_status=0 AND act_info_email_expired<=".sqlstr($nowStr);
      mysqli_query($con, "LOCK TABLES account_info_act_info WRITE");
      mysqli_query($con, $query1);
      mysqli_query($con, "UNLOCK TABLES");
      break;
    case 3: // QQ
      if (!is_valid_qq($value))
      {
        return true;
      }
      $query = $query."usr_qq FROM users_usr WHERE usr_qq=?";
      break;
    case 4: // weibo
      if (!is_valid_weibo($value))
      {
        return true;
      }
      $query = $query."usr_weibo FROM users_usr WHERE usr_weibo=?";
      break;
    default:
      return true;
      break;
  }

  global $db_host, $db_user, $db_pwd, $db_name;
  $con=mysqli_connect($db_host, $db_user, $db_pwd, $db_name);
  if (mysqli_connect_errno())
  {
    return true;
  }
  mysqli_set_charset($con, "UTF8");
  
  if ($stmt = mysqli_prepare($con, $query))
  {
    mysqli_stmt_bind_param($stmt, "s", $value);

    if ($type == 1 || $type == 2)
    {
      mysqli_query($con, "LOCK TABLES account_info_act_info READ");
    }
    else if ($type == 3 || $type == 4)
    {
      mysqli_query($con, "LOCK TABLES users_usr READ");
    }
    $flag = mysqli_stmt_execute($stmt);
    if ($flag)
    {
      mysqli_stmt_bind_result($stmt, $col);
      $flag = is_null(mysqli_stmt_fetch($stmt));
    }
    mysqli_stmt_close($stmt);
    mysqli_query($con, "UNLOCK TABLES");
    mysqli_kill($con, mysqli_thread_id($con));
    mysqli_close($con);
    return !$flag;
  }
  return true;
}
?>