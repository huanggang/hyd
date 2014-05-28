<?php
function account_security(){

  include_once 'util_global.php';
  
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
      break;
    case 4: // verify email address
      $usr_id = str2int($_GET['usr_id']);
      $code = $_GET['code'];
      if ($usr_id <= 0 || is_null($code) || strlen($code) != 6)
      {
        echo "{\"result\":0}";
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

  if ($type != 4)
  {
    if ($user->uid <= 0) // except verify email address
    {
      echo "{\"result\":0}";
      exit;
    }
    $usr_id = $user->uid;
  }

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
  switch ($type)
  {
    case 1:
      $flag = verify_name_ssn($con, $usr_id, $name, $ssn, &$times);
      break;
    case 2:
      $flag = change_password($con, $usr_id, $password, $new_password);
      break;
    case 3:
      $flag = set_email($con, $usr_id, $email);
      break;
    case 4:
      $flag = bind_email($con, $usr_id, $code);
      break;
    case 5:
      $flag = send_mobile_code($con, $usr_id, $mobile);
      break;
    case 6:
      $flag = bind_mobile($con, $usr_id, $mobile, $code);
      break;
    case 7:
      $flag = unbind_mobile($con, $usr_id, $mobile, $code);
      break;
    case 8:
      $flag = set_cash_password($con, $usr_id, $cash_pass);
      break;
    case 9:
      $flag = change_cash_password($con, $usr_id, $cash_pass, $new_cash_pass);
      break;
    case 10:
      $flag = reset_cash_password($con, $usr_id, $new_cash_pass, $code);
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
  else {
    if ($flag)
    {
      echo "{\"result\":1}";
    }
    else
    {
      echo "{\"result\":0}";
    }
  }
}

function verify_name_ssn($con, $usr_id, $name, $ssn, $act_info_ssn_times)
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
        $gender = strval(substr($ssn, -2)) % 2 == 1;
        $dob = substr($ssn, 6, 8);
        $dob = substr_replace($dob, '-', 6, 0);
        $dob = substr_replace($dob, '-', 4, 0);
      	$query = "UPDATE account_info_act_info SET act_info_name = ".sqlstr($name).", act_info_ssn = ".sqlstr($ssn).", act_info_ssn_status = 1, act_info_ssn_times = ".sqlstrval($act_info_ssn_times).", act_info_gender = ".sqlstrval($gender).", act_info_dob = ".sqlstr($dob)." WHERE act_info_usr_id = ".strval($usr_id)." AND act_info_ssn_status = 0";
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

function change_password($con, $usr_id, $password, $new_password)
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

    return $flag;
  }
  return false;
}

function set_email($con, $usr_id, $email)
{
  $todayStr = date("Y-m-d");
  $today = new DateTime($todayStr);// date_create_from_format('Y-m-d', $todayStr);
  $expired = $today->add(new DateInterval("P7D"));
  $code = generate_mobile_code();
  $query = "UPDATE account_info_act_info SET act_info_email = ".sqlstr($email).", act_info_email_status = 0, act_info_email_code = ".sqlstr($code).", act_info_email_expired = ".sqlstr($expired->format("Y-m-d"))." WHERE act_info_usr_id = ".strval($usr_id);
  mysqli_query($con, "LOCK TABLES account_info_act_info WRITE");
  $flag = mysqli_query($con, $query) != false;
  mysqli_query($con, "UNLOCK TABLES");

  if ($flag)
  {
    global $email_name, $email_account;
    global $email_subject_verification, $email_content_verification;

    $content = str_replace("[{ID}]", strval($usr_id), $email_content_verification);
    $content = str_replace("[{CODE}]", $code, $content);

    return mail_utf8($email, $email_name, $email_account, $email_subject_verification, $content);
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

function send_mobile_code($con, $usr_id, $mobile)
{
  $now = new DateTime;
  $expired = $now->add(new DateInterval("PT5M")); // 5 minutes
  $code = generate_mobile_code();
  $query = "UPDATE account_info_act_info SET act_info_mobile_code = ".sqlstr($code).", act_info_mobile_expired = ".sqlstr($expired->format("Y-m-d\TH:i:sP"))." WHERE act_info_usr_id = ".strval($usr_id);
  mysqli_query($con, "LOCK TABLES account_info_act_info WRITE");
  $flag = mysqli_query($con, $query) != false;
  mysqli_query($con, "UNLOCK TABLES");

  if ($flag)
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
  return false;
}

function bind_mobile($con, $usr_id, $mobile, $code)
{
  $now = new DateTime;
  $query = "SELECT act_info_usr_id FROM account_info_act_info WHERE act_info_usr_id = ".strval($usr_id)." AND act_info_mobile IS NULL AND act_info_mobile_status = 0 AND act_info_mobile_code = '".$code."' AND act_info_mobile_expired >= '".$now->format("Y-m-d\TH:i:s")."'";
  mysqli_query($con, "LOCK TABLES account_info_act_info READ");
  $result = mysqli_query($con, $query);
  mysqli_query($con, "UNLOCK TABLES");
  if ($row = mysqli_fetch_array($result))
  {
    mysqli_free_result($result);

    $query = "UPDATE account_info_act_info SET act_info_mobile = ".sqlstr($mobile).", act_info_mobile_status = 1, act_info_mobile_code = null, act_info_mobile_expired = null WHERE act_info_usr_id = ".strval($usr_id)." AND act_info_mobile IS NULL AND act_info_mobile_status = 0 AND act_info_mobile_code = '".$code."' AND act_info_mobile_expired >= '".$now->format("Y-m-d\TH:i:s")."'";
    mysqli_query($con, "LOCK TABLES account_info_act_info WRITE");
    $flag = mysqli_query($con, $query) != false;
    mysqli_query($con, "UNLOCK TABLES");

    return $flag;
  }
  return false;
}

function unbind_mobile($con, $usr_id, $mobile, $code)
{
  $now = new DateTime;
  $query = "SELECT act_info_usr_id FROM account_info_act_info WHERE act_info_usr_id = ".strval($usr_id)." AND act_info_mobile = '".$mobile."' AND act_info_mobile_status = 1 AND act_info_mobile_code = '".$code."' AND act_info_mobile_expired >= '".$now->format("Y-m-d\TH:i:s")."'";
  mysqli_query($con, "LOCK TABLES account_info_act_info READ");
  $result = mysqli_query($con, $query);
  mysqli_query($con, "UNLOCK TABLES");
  if ($row = mysqli_fetch_array($result))
  {
    mysqli_free_result($result);

    $query = "UPDATE account_info_act_info SET act_info_mobile = null, act_info_mobile_status = 0, act_info_mobile_code = null, act_info_mobile_expired = null WHERE act_info_usr_id = ".strval($usr_id)." AND act_info_mobile = '".$mobile."' AND act_info_mobile_status = 1 AND act_info_mobile_code = '".$code."' AND act_info_mobile_expired >= '".$now->format("Y-m-d\TH:i:s")."'";
    mysqli_query($con, "LOCK TABLES account_info_act_info WRITE");
    $flag = mysqli_query($con, $query) != false;
    mysqli_query($con, "UNLOCK TABLES");

    return $flag;
  }
  return false;
}

function set_cash_password($con, $usr_id, $cash_pass)
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

    return $flag;
  }
  return false;
}

function change_cash_password($con, $usr_id, $cash_pass, $new_cash_pass)
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

    return $flag;
  }
  return false;
}

function reset_cash_password($con, $usr_id, $new_cash_pass, $code)
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

    return $flag;
  }
  return false;
}

function call_name_ssn_webservice($name, $ssn)
{
  return true;
}
?>