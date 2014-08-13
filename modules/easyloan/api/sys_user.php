<?php

include_once 'util_global.php';

function set_user($type, $id, $value = null)
{
  if (is_null($id) || $id <= 0)
  {
    return false;
  }
  $query = "";
  switch ($type)
  {
    case 1: // register
      $now = new DateTime;
      $nowStr = $now->format("Y-m-d\TH:i:sP");
      if (!is_valid_password($value))
      {
        return false;
      }

      $namepass = preg_split('/;/', $value);
      $name = $namepass[0];
      $pass = $namepass[1];

      $query = $query."INSERT INTO users_usr (usr_id,usr_password,usr_registered) VALUES (".strval($id).",SHA2(".sqlstr($pass).",256),".sqlstr($nowStr).");";
      $query = $query."INSERT INTO account_info_act_info(act_info_usr_id,act_info_nick,act_info_ssn_status,act_info_ssn_times,act_info_mobile_status,act_info_email_status) VALUES (".strval($id).", ".sqlstr($name).", '0',  '0', '0', '0')";
      break;
    case 2: // login
      $now = new DateTime;
      $nowStr = $now->format("Y-m-d\TH:i:sP");
      $query = $query."UPDATE users_usr SET usr_logined=".sqlstr($nowStr)." WHERE usr_id=".strval($id);
      break;
    case 3: // bind QQ
      if (!is_valid_qq($value))
      {
        return false;
      }
      $query = $query."UPDATE users_usr SET usr_qq=".sqlstr($value)." WHERE usr_id=".strval($id);
      break;
    case 4: // bind weibo
      if (!is_valid_weibo($value))
      {
        return false;
      }
      $query = $query."UPDATE users_usr SET usr_weibo=".sqlstr($value)." WHERE usr_id=".strval($id);
      break;
    case 5: // bind avatar file-path
      $query = $query."UPDATE users_usr SET usr_avatar=".sqlstr($value)." WHERE usr_id=".strval($id);
      break;
    case 6: // change password
      if (!is_valid_password($value))
      {
        return false;
      }
      $query = $query."UPDATE users_usr SET usr_password = SHA2(".sqlstr($value).",256) WHERE usr_id=".strval($id);
      break;
    default:
      return false;
      break;
  }
  global $db_host, $db_user, $db_pwd, $db_name;

  $con=mysqli_connect($db_host, $db_user, $db_pwd, $db_name);
  if (mysqli_connect_errno())
  {
    return false;
  }
  mysqli_set_charset($con, "UTF8");

  if ($type==1){
    mysqli_query($con, "LOCK TABLES users_usr WRITE, account_info_act_info WRITE");
    $flag = mysqli_multi_query($con, $query) != false;
  } else {
    mysqli_query($con, "LOCK TABLES users_usr WRITE");
    $flag = mysqli_query($con, $query) != false;
  }
  
  mysqli_query($con, "UNLOCK TABLES");
  mysqli_kill($con, mysqli_thread_id($con));
  mysqli_close($con);

  return $flag;
}
?>