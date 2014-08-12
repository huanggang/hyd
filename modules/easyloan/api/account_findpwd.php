<?php

include_once 'util_global.php';
include_once 'sys_contact.php';

function account_findpwd(){
  $mobile = null; $code = null;

  $type = 0;
  $method = $_SERVER['REQUEST_METHOD'];
  if ($method == 'POST')
  {
    $type = str2int($_POST['type']);
  }
  else 
  {
    $type = str2int($_GET['type']);
  }
  if ($type < 1 || $type > 10)
  {
    echo "{\"result\":0}";
    exit;
  }

  switch ($type)
  {
    case 1: // send mobile code
      $mobile = $_POST['mobile'];
      if (!is_valid_mobile($mobile))
      {
        echo "{\"result\":0}";
        exit;
      }
      break;
    case 2: // reset password
      $mobile = $_POST['mobile'];
      $code = $_POST['code'];
      if (!is_valid_mobile($mobile) || is_null($code) || strlen($code) != 6)
      {
        echo "{\"result\":0}";
        exit;
      }
      break;
  }

  global $db_host, $db_user, $db_pwd, $db_name;
  $con=mysqli_connect($db_host, $db_user, $db_pwd, $db_name);
  // Check connection
  if (mysqli_connect_errno())
  {
    echo "{\"result\":0}";
    exit;
  }

  mysqli_set_charset($con, "UTF8");
  $flag = false;
  switch ($type)
  {
    case 1:
      $flag = send_mobile_code($con, $mobile, $message);
      break;
    case 2:
      $flag = reset_password($con, $mobile, $code, $message);
      break;
  }
  mysqli_kill($con, mysqli_thread_id($con));
  mysqli_close($con);

  if ($flag)
  {
    echo "{\"result\":1}";
  }
  else
  {
    echo "{\"result\":0,\"message\":".jsonstr($message)."}";
  }
}

function send_mobile_code($con, $mobile, &$message)
{
  $now = new DateTime;
  $expired = $now->add(new DateInterval("PT5M")); // 5 minutes

  $query = "SELECT act_info_usr_id, act_info_mobile_times FROM account_info_act_info WHERE act_info_mobile_status = 1 AND act_info_mobile = '" . strval($mobile) . "'";
  mysqli_query($con, "LOCK TABLES account_info_act_info READ");
  $result = mysqli_query($con, $query);
  mysqli_query($con, "UNLOCK TABLES");
  if ($row = mysqli_fetch_array($result))
  {
    $act_info_mobile_times = $row['act_info_mobile_times'];
    $usr_id = $row['act_info_usr_id'];
    mysqli_free_result($result);

    if ($act_info_mobile_times < 3)
    {
      $act_info_mobile_times += 1;
      // generate new random code
      $code = generate_mobile_code();
      $user = user_load($usr_id);

      global $sms_url, $sms_user, $sms_password, $sms_reset_pass_code;

      $text = str_replace("[{NICKNAME}]", $user->name, $sms_reset_pass_code);
      $text = str_replace("[{CODE}]", $code, $text);
      $url = str_replace("[{USER}]", $sms_user, $sms_url);
      $url = str_replace("[{PASSWORD}]", $sms_password, $url);
      $url = str_replace("[{MOBILE}]", $mobile, $url);

      $ch = curl_init();
      $content = curl_escape($ch, $text);
      $url = str_replace("[{CONTENT}]", $content, $url);
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      $output = curl_exec($ch);
      curl_close($ch);

      //if (1)
      if (strpos($output, "OK") !== false)
      {
        $query = "UPDATE account_info_act_info SET act_info_mobile_times = $act_info_mobile_times, act_info_mobile_code = ".sqlstr($code).", act_info_mobile_expired = ".sqlstr($expired->format("Y-m-d\TH:i:sP"))." WHERE act_info_mobile_status = 1 AND act_info_mobile = '" . strval($mobile) . "'";
        mysqli_query($con, "LOCK TABLES account_info_act_info WRITE");
        $flag = mysqli_query($con, $query) != false;
        mysqli_query($con, "UNLOCK TABLES");
        return $flag;
      }
    } else {
      // request too many times 
      $message = 'request too many times';
      return false;
    }
  } else { 
    // no such mobile found 
    $message = 'no such mobile found';
    return false;
  } 
}

function reset_password($con, $mobile, $code, &$message)
{
  $now = new DateTime;
  $query = "SELECT act_info_usr_id FROM account_info_act_info WHERE act_info_mobile_status = 1 AND act_info_mobile = ".sqlstr($mobile)." AND act_info_mobile_code = '".$code."' AND act_info_mobile_expired >= '".$now->format("Y-m-d\TH:i:s")."'";
  mysqli_query($con, "LOCK TABLES account_info_act_info READ");
  $result = mysqli_query($con, $query);
  mysqli_query($con, "UNLOCK TABLES");
  if ($row = mysqli_fetch_array($result))
  {
    mysqli_free_result($result);
    $usr_id = $row['act_info_usr_id'];
    $user = user_load($usr_id);

    $new_password = generate_user_password();

    $query = "UPDATE users_usr SET usr_password = SHA2(".sqlstr($new_password).",256) WHERE usr_id = ".strval($usr_id);
    //$query = "UPDATE users_usr SET usr_password = ".sqlstr($new_password)." WHERE usr_id = ".strval($usr_id);
    mysqli_query($con, "LOCK TABLES users_usr WRITE");
    $flag = mysqli_query($con, $query) != false;
    mysqli_query($con, "UNLOCK TABLES");

    if ($flag){
      user_save($user, array('pass' => $new_password));
    }
    return $flag;
  }
  return false;
}
