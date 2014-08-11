<?php

include_once 'util_global.php';
include_once 'sys_contact.php';
include_once 'verify_id.php';

function account_security(){

  $name = null; $ssn = null;
  $password = null; $new_password = null;
  $email = null;
  $mobile = null; $code = null;
  $cash_pass = null; $new_cash_pass = null;

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

  if ($type != 4)
  {
    global $user;
    if ($user->uid <= 0) // except verify email address
    {
      echo "{\"result\":0}";
      exit;
    }
    $usr_id = $user->uid;
  }

  switch ($type)
  {
    case 1: // verify name and ssn
      $name = $_POST['name'];
      $ssn = $_POST['ssn'];
      if (is_null($name) || strlen($name) < 2 || !is_valid_ssn($ssn))
      {
        echo "{\"result\":0}";
        exit;
      }
      break;
    case 2: // change password
      $password = $_POST['password'];
      $new_password = $_POST['new_password'];
      if (!(is_valid_password($password) && is_valid_password($new_password)))
      {
        echo "{\"result\":0}";
        exit;
      }
      break;
    case 3: // set email
      $email = $_POST['email'];
      if (is_null($email) || !filter_var($email, FILTER_VALIDATE_EMAIL))
      {
        echo "{\"result\":0}";
        exit;
      } 
      else if (does_contact_exist(2, $email) && !is_user_email($usr_id, $email))
      {
        echo "{\"result\":0, \"exists\": 1}";
        exit;
      }
      break;
    case 4: // verify email address
      $usr_id = str2int($_GET['usr_id']);
      $code = $_GET['code'];
      if ($usr_id <= 0 || is_null($code) || strlen($code) != 6)
      {
        //echo "{\"result\":0}";
        drupal_goto('notfound');
        exit;
      }
      break;
    case 5: // send mobile code
      $mobile = $_POST['mobile'];
      if (!is_valid_mobile($mobile))
      {
        echo "{\"result\":0}";
        exit;
      }
      break;
    case 6: // bind mobile
    case 7: // unbind mobile
      $mobile = $_POST['mobile'];
      $code = $_POST['code'];
      if (!is_valid_mobile($mobile) || is_null($code) || strlen($code) != 6)
      {
        echo "{\"result\":0}";
        exit;
      }
      break;
    case 8: // set cash password
      $cash_pass = $_POST['cash_pass'];
      if (!is_valid_password($cash_pass))
      {
        echo "{\"result\":0}";
        exit;
      }
      break;
    case 9: // change cash password
      $cash_pass = $_POST['cash_pass'];
      $new_cash_pass = $_POST['new_cash_pass'];
      if (!(is_valid_password($cash_pass) && is_valid_password($new_cash_pass)))
      {
        echo "{\"result\":0}";
        exit;
      }
      break;
    case 10: // reset cash password
      $code = $_POST['code'];
      $new_cash_pass = $_POST['new_cash_pass'];
      if (!is_valid_password($new_cash_pass) || is_null($code) || strlen($code) != 6)
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
  $times = 0;
  $message = "";
  switch ($type)
  {
    case 1:
      $flag = verify_name_ssn($con, $usr_id, $name, $ssn, $times);
      break;
    case 2:
      $flag = change_password($con, $usr_id, $password, $new_password, $message);
      break;
    case 3:
      $flag = set_email($con, $usr_id, $email, $message);
      break;
    case 4:
      $flag = bind_email($con, $usr_id, $code);
      break;
    case 5:
      $flag = send_mobile_code($con, $usr_id, $mobile, $message);
      break;
    case 6:
      $flag = bind_mobile($con, $usr_id, $mobile, $code, $message);
      break;
    case 7:
      $flag = unbind_mobile($con, $usr_id, $mobile, $code, $message);
      break;
    case 8:
      $flag = set_cash_password($con, $usr_id, $cash_pass, $message);
      break;
    case 9:
      $flag = change_cash_password($con, $usr_id, $cash_pass, $new_cash_pass, $message);
      break;
    case 10:
      $flag = reset_cash_password($con, $usr_id, $new_cash_pass, $code, $message);
      break;
  }
  mysqli_kill($con, mysqli_thread_id($con));
  mysqli_close($con);

  if ($type == 1)
  {
    if ($flag)
    {
      echo "{\"result\":1,\"verified\":".jsonstrval($times)."}";
    }
    else
    {
      echo "{\"result\":0,\"verified\":".jsonstrval($times)."}";
    }
  }
  else if ($type == 4)
  {
    if ($flag)
    {
      drupal_goto('account_management/security');
    }
    else
    {
      drupal_goto('notfound');
    }
  }
  else {
    if ($flag)
    {
      echo "{\"result\":1}";
    }
    else
    {
      echo "{\"result\":0,\"message\":".jsonstr($message)."}";
    }
  }
}

function verify_name_ssn($con, $usr_id, $name, $ssn, &$act_info_ssn_times)
{
  $act_info_ssn_times = 0;
  $query = "SELECT act_info_ssn_times FROM account_info_act_info WHERE act_info_usr_id = ".strval($usr_id)." AND act_info_ssn_status = 0";
  mysqli_query($con, "LOCK TABLES account_info_act_info READ");
  $result = mysqli_query($con, $query);
  mysqli_query($con, "UNLOCK TABLES");
  if ($row = mysqli_fetch_array($result))
  {
    $act_info_ssn_times = $row['act_info_ssn_times'];
    mysqli_free_result($result);

    if ($act_info_ssn_times < 2)
    {
      $act_info_ssn_times += 1;
      // call the third party verification url to verify the name and ssn
      if (call_name_ssn_webservice($name, $ssn))
      {
        // parse gender and date of birth
        $gender = strval(substr($ssn, -2, 1)) % 2 == 1;
        $gender = $gender ? "1" : "0";
        $dob = substr($ssn, 6, 8);
        $dob = substr_replace($dob, '-', 6, 0);
        $dob = substr_replace($dob, '-', 4, 0);
        $query = "UPDATE account_info_act_info SET act_info_name = ".sqlstr($name).", act_info_ssn = ".sqlstr($ssn).", act_info_ssn_status = 1, act_info_ssn_times = ".sqlstrval($act_info_ssn_times).", act_info_gender = ".$gender.", act_info_dob = ".sqlstr($dob)." WHERE act_info_usr_id = ".strval($usr_id)." AND act_info_ssn_status = 0";
        mysqli_query($con, "LOCK TABLES account_info_act_info WRITE");
        $flag = mysqli_query($con, $query) != false;
        mysqli_query($con, "UNLOCK TABLES");

        return $flag;
      }
      else
      {
        $query = "UPDATE account_info_act_info SET act_info_ssn_times = ".sqlstrval($act_info_ssn_times)." WHERE act_info_usr_id = ".strval($usr_id)." AND act_info_ssn_status = 0";
        mysqli_query($con, "LOCK TABLES account_info_act_info WRITE");
        $flag = mysqli_query($con, $query);
        mysqli_query($con, "UNLOCK TABLES");
      }
    }
  }
  return false;
}

function change_password($con, $usr_id, $password, $new_password, &$message)
{
  $query = "SELECT usr_password FROM users_usr WHERE usr_id = ".strval($usr_id)." AND usr_password = SHA2('".$password."',256)";
  mysqli_query($con, "LOCK TABLES users_usr READ");
  $result = mysqli_query($con, $query);
  mysqli_query($con, "UNLOCK TABLES");
  if ($row = mysqli_fetch_array($result))
  {
    mysqli_free_result($result);

    $query = "UPDATE users_usr SET usr_password = SHA2(".sqlstr($new_password).",256) WHERE usr_id = ".strval($usr_id)." AND usr_password = SHA2('".$password."',256)";
    mysqli_query($con, "LOCK TABLES users_usr WRITE");
    $flag = mysqli_query($con, $query) != false;
    mysqli_query($con, "UNLOCK TABLES");

    if ($flag)
    {
      global $user;
      user_save($user, array('pass' => $new_password));
    }
    else
    {
      $message = "Failed to update password";
    }

    return $flag;
  }
  else
  {
    $message = "Original password is wrong";
  }
  return false;
}

function is_user_email($usr_id, $email)
{
  $query = "SELECT act_info_usr_id FROM account_info_act_info WHERE act_info_usr_id = ".strval($usr_id)." AND act_info_email = ".sqlstr($email);
  mysqli_query($con, "LOCK TABLES account_info_act_info READ");
  $result = mysqli_query($con, $query);
  mysqli_query($con, "UNLOCK TABLES");
  if ($row = mysqli_fetch_array($result))
  {
    mysqli_free_result($result);
    return true;
  }  
  return false;
}

function set_email($con, $usr_id, $email, &$message)
{
  $flag1 = true;
  $flag2 = true;

  $todayStr = date("Y-m-d");
  $today = new DateTime($todayStr);// date_create_from_format('Y-m-d', $todayStr);
  $expired = $today->add(new DateInterval("P7D"));
  $code = generate_mobile_code();
  $query1 = "SELECT act_info_usr_id FROM account_info_act_info WHERE act_info_email = ".sqlstr($email);
  $query2 = "UPDATE account_info_act_info SET act_info_email = ".sqlstr($email).", act_info_email_status = 0, act_info_email_code = ".sqlstr($code).", act_info_email_expired = ".sqlstr($expired->format("Y-m-d"))." WHERE act_info_usr_id = ".strval($usr_id);
  mysqli_query($con, "LOCK TABLES account_info_act_info WRITE");
  $result = mysqli_query($con, $query1);
  if ($row = mysqli_fetch_array($result))
  {
    mysqli_free_result($result);

    $message = "Email exists";
    $flag1 = false;
  }
  else
  {
    $flag2 = mysqli_query($con, $query2) != false;
  }
  mysqli_query($con, "UNLOCK TABLES");

  if ($flag1)
  {
    if ($flag2)
    {
      global $email_name, $email_account;
      global $email_subject_verification, $email_content_verification;

      $content = str_replace("[{ID}]", strval($usr_id), $email_content_verification);
      $content = str_replace("[{CODE}]", $code, $content);

      return mail_utf8($email, $email_name, $email_account, $email_subject_verification, $content);
    }
    else
    {
      $message = "Failed to set email";
    }
  }
  return false;
}

function bind_email($con, $usr_id, $code)
{
  $todayStr = date("Y-m-d");
  $today = new DateTime($todayStr);// date_create_from_format('Y-m-d', $todayStr);

  $query = "SELECT act_info_usr_id FROM account_info_act_info WHERE act_info_usr_id = ".strval($usr_id)." AND act_info_email_code = '".$code."' AND act_info_email_expired >= '".$today->format("Y-m-d")."'";
  mysqli_query($con, "LOCK TABLES account_info_act_info READ");
  $result = mysqli_query($con, $query);
  mysqli_query($con, "UNLOCK TABLES");
  if ($row = mysqli_fetch_array($result))
  {
    mysqli_free_result($result);

    $query = "UPDATE account_info_act_info SET act_info_email_status = 1, act_info_email_code = null, act_info_email_expired = null WHERE act_info_usr_id = ".strval($usr_id)." AND act_info_email_code = '".$code."' AND act_info_email_expired >= '".$today->format("Y-m-d")."'";
    mysqli_query($con, "LOCK TABLES account_info_act_info WRITE");
    $flag = mysqli_query($con, $query) != false;
    mysqli_query($con, "UNLOCK TABLES");

    return $flag;
  }
  return false;
}

function send_mobile_code($con, $usr_id, $mobile, &$message)
{
  $flag1 = true;
  $flag2 = true;

  $now = new DateTime;
  $expired = $now->add(new DateInterval("PT5M"))->format("Y-m-d\TH:i:sP"); // 5 minutes
  $code = generate_mobile_code();
  $query1 = "SELECT act_info_mobile, act_info_mobile_expired, act_info_mobile_times FROM account_info_act_info WHERE act_info_usr_id = ".strval($usr_id);
  $query2 = "SELECT act_info_mobile FROM account_info_act_info WHERE act_info_mobile = ".sqlstr($mobile);
  mysqli_query($con, "LOCK TABLES account_info_act_info WRITE");
  $result = mysqli_query($con, $query1);
  if ($row = mysqli_fetch_array($result))
  {
    $act_info_mobile = $row['act_info_mobile'];
    $act_info_mobile_expired = $row['act_info_mobile_expired'];
    $act_info_mobile_times = $row['act_info_mobile_times'];

    mysqli_free_result($result);

    if (is_null($act_info_mobile))
    {
      $result = mysqli_query($con, $query2);
      if ($row = mysqli_fetch_array($result))
      {
        mysqli_free_result($result);
        $message = "Mobile exists";
        $flag1 = false;
      }
    }
    else if ($act_info_mobile != $mobile)
    {
      $message = "Unmatched mobile";
      $flag1 = false;
    }
    if ($flag1)
    {
      if (is_null($act_info_mobile_expired) || (new DateTime($act_info_mobile_expired)) <= $now->sub(new DateInterval("P1D")))
      {
        $act_info_mobile_times = 0;
      }
      else if ($act_info_mobile_times >= 3)
      {
        $message = "Over 3 times within 24 hours";
        $flag1 = false;
      }
      if ($flag1)
      {
        $act_info_mobile_times = $act_info_mobile_times + 1;
        $query3 = "UPDATE account_info_act_info SET act_info_mobile_code = ".sqlstr($code).", act_info_mobile_expired = ".sqlstr($expired).", act_info_mobile_times = ".strval($act_info_mobile_times)." WHERE act_info_usr_id = ".strval($usr_id);
        $flag2 = mysqli_query($con, $query3) != false;
      }
    }
  }
  mysqli_query($con, "UNLOCK TABLES");

  if ($flag1)
  {
    if ($flag2)
    {
      global $sms_url, $sms_user, $sms_password, $sms_security_code;

      $text = str_replace("[{CODE}]", $code, $sms_security_code);
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

      return (strpos($output, "OK") !== false);
    }
    else
    {
      $message = "Failed to set security code";
    }
  }
  return false;
}

function bind_mobile($con, $usr_id, $mobile, $code, &$message)
{
  $flag1 = true;
  $flag2 = true;

  $now = new DateTime;
  $query1 = "SELECT act_info_mobile FROM account_info_act_info WHERE act_info_mobile = ".sqlstr($mobile);
  $query2 = "SELECT act_info_usr_id FROM account_info_act_info WHERE act_info_usr_id = ".strval($usr_id)." AND act_info_mobile IS NULL AND act_info_mobile_status = 0 AND act_info_mobile_code = '".$code."' AND act_info_mobile_expired >= '".$now->format("Y-m-d\TH:i:s")."'";
  $query3 = "UPDATE account_info_act_info SET act_info_mobile = ".sqlstr($mobile).", act_info_mobile_status = 1, act_info_mobile_code = null, act_info_mobile_expired = null WHERE act_info_usr_id = ".strval($usr_id);
  mysqli_query($con, "LOCK TABLES account_info_act_info WRITE");
  $result = mysqli_query($con, $query1);
  if ($row = mysqli_fetch_array($result))
  {
    mysqli_free_result($result);
    $message = "Mobile exists";
    $flag1 = false;
  }
  else
  {
    $result = mysqli_query($con, $query2);
    if ($row = mysqli_fetch_array($result))
    {
      mysqli_free_result($result);

      $flag2 = mysqli_query($con, $query3) != false;
      if (!$flag2)
      {
        $message = "Failed to bind mobile";
      }
    }
    else
    {
      $message = "Code is wrong";
      $flag1 = false;
    }
  }
  mysqli_query($con, "UNLOCK TABLES");

  return $flag1 && $flag2;
}

function unbind_mobile($con, $usr_id, $mobile, $code, &$message)
{
  $flag1 = true;
  $flag2 = true;

  $now = new DateTime;
  $query1 = "SELECT act_info_usr_id FROM account_info_act_info WHERE act_info_usr_id = ".strval($usr_id)." AND act_info_mobile = '".$mobile."' AND act_info_mobile_status = 1 AND act_info_mobile_code = '".$code."' AND act_info_mobile_expired >= '".$now->format("Y-m-d\TH:i:s")."'";
  $query2 = "UPDATE account_info_act_info SET act_info_mobile = null, act_info_mobile_status = 0, act_info_mobile_times = 0, act_info_mobile_code = null, act_info_mobile_expired = null WHERE act_info_usr_id = ".strval($usr_id);
  mysqli_query($con, "LOCK TABLES account_info_act_info WRITE");
  $result = mysqli_query($con, $query1);
  if ($row = mysqli_fetch_array($result))
  {
    mysqli_free_result($result);

    $flag2 = mysqli_query($con, $query2) != false;
    if (!$flag2)
    {
      $message = "Failed to unbind mobile";
    }
  }
  else
  {
    $message = "Code is wrong";
    $flag1 = false;
  }
  mysqli_query($con, "UNLOCK TABLES");

  return $flag1 && $flag2;
}

function set_cash_password($con, $usr_id, $cash_pass, &$message)
{
  $query = "SELECT act_info_usr_id FROM account_info_act_info WHERE act_info_usr_id = ".strval($usr_id)." AND act_info_cash_pass IS NULL";
  mysqli_query($con, "LOCK TABLES account_info_act_info READ");
  $result = mysqli_query($con, $query);
  mysqli_query($con, "UNLOCK TABLES");
  if ($row = mysqli_fetch_array($result))
  {
    mysqli_free_result($result);

    $query = "UPDATE account_info_act_info SET act_info_cash_pass = SHA2(".sqlstr($cash_pass).",256) WHERE act_info_usr_id = ".strval($usr_id)." AND act_info_cash_pass IS NULL";
    mysqli_query($con, "LOCK TABLES account_info_act_info WRITE");
    $flag = mysqli_query($con, $query) != false;
    mysqli_query($con, "UNLOCK TABLES");

    if (!$flag)
    {
      $message = "Failed to set cash password";
    }
    return $flag;
  }
  else
  {
    $message = "Already set cash password";
  }
  return false;
}

function change_cash_password($con, $usr_id, $cash_pass, $new_cash_pass, &$message)
{
  $query = "SELECT act_info_usr_id FROM account_info_act_info WHERE act_info_usr_id = ".strval($usr_id)." AND act_info_cash_pass = SHA2('".$cash_pass."',256)";
  mysqli_query($con, "LOCK TABLES account_info_act_info READ");
  $result = mysqli_query($con, $query);
  mysqli_query($con, "UNLOCK TABLES");
  if ($row = mysqli_fetch_array($result))
  {
    mysqli_free_result($result);

    $query = "UPDATE account_info_act_info SET act_info_cash_pass = SHA2(".sqlstr($new_cash_pass).",256) WHERE act_info_usr_id = ".strval($usr_id)." AND act_info_cash_pass = SHA2('".$cash_pass."',256)";
    mysqli_query($con, "LOCK TABLES account_info_act_info WRITE");
    $flag = mysqli_query($con, $query) != false;
    mysqli_query($con, "UNLOCK TABLES");

    if (!$flag)
    {
      $message = "Failed to set new cash password";
    }
    return $flag;
  }
  else 
  {
    $message = "Original cash password is wrong";
  }
  return false;
}

function reset_cash_password($con, $usr_id, $new_cash_pass, $code, &$message)
{
  $now = new DateTime;
  $query = "SELECT act_info_usr_id FROM account_info_act_info WHERE act_info_usr_id = ".strval($usr_id)." AND act_info_mobile IS NOT NULL AND act_info_mobile_status = 1 AND act_info_mobile_code = '".$code."' AND act_info_mobile_expired >= '".$now->format("Y-m-d\TH:i:s")."'";
  mysqli_query($con, "LOCK TABLES account_info_act_info READ");
  $result = mysqli_query($con, $query);
  mysqli_query($con, "UNLOCK TABLES");
  if ($row = mysqli_fetch_array($result))
  {
    mysqli_free_result($result);

    $query = "UPDATE account_info_act_info SET act_info_cash_pass = SHA2(".sqlstr($new_cash_pass).",256), act_info_mobile_code = null, act_info_mobile_expired = null WHERE act_info_usr_id = ".strval($usr_id)." AND act_info_mobile IS NOT NULL AND act_info_mobile_status = 1 AND act_info_mobile_code = '".$code."' AND act_info_mobile_expired >= '".$now->format("Y-m-d\TH:i:s")."'";
    mysqli_query($con, "LOCK TABLES account_info_act_info WRITE");
    $flag = mysqli_query($con, $query) != false;
    mysqli_query($con, "UNLOCK TABLES");

    if (!$flag)
    {
      $message = "Failed to reset cash password";
    }
    return $flag;
  }
  else
  {
    $message = "Code is wrong";
  }
  return false;
}

function call_name_ssn_webservice($name, $ssn)
{
  $flag = verify_id($name, $ssn);
  return $flag == 1;
}