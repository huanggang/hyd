<?php
global $user;

global $db_host, $db_user, $db_pwd, $db_name;

global $sms_url, $sms_user, $sms_password, $sms_reset_pass_code, $sms_security_code;

global $web_js, $site_js;

$site_name = "清远好易贷";

// web site url
$http_scheme = "http";
$host = "localhost";//"www.hyd1818.com";

#$web_js = "http://www.hyd1818.com/js/";
$web_js = $http_scheme."://".$host."/sites/all/themes/easyloan/js/";
// web site directory
$site_js = "/var/www/sites/all/themes/easyloan/js/";

// database
$db_host = "localhost";
$db_user = "hyd";
$db_pwd = "P@ssw0rd#2014";
$db_name = "hyd";

// products displaying / listing
$max_pages = 50;
$front_per_page = 4;
$per_page = 20;

// time settings for backend applications and investing, applying loans, etc.
$time_user_start = 9;
$time_user_end = 23;
$time_backend_start = 0;
$time_backend_end = 8;
$time_notify_start = 9;
$time_notify_end = 17;

// mobile phone - sms notification
$sms_url = "http://sms.amyone.com/sms?user=[{USER}]&pass=[{PASSWORD}]&phones=[{MOBILE}]&content=[{CONTENT}]";
$sms_residure_url = "http://sms.amyone.com/user/[{USER}]";
$sms_user = "weijian";
$sms_password = md5("weijian4020");

// email notification
$email_name = $site_name;
$email_account = "no-reply@hyd1818.com";

// email and sms messages
$email_subject_repayment_7 = $site_name."还款7天通知 - [{NAME}][{GENDER}] - 身份证号: [{SSN}]";
$email_content_repayment_7 = "[{NAME}][{GENDER}]\r\n身份证号: [{SSN}]\r\n\r\n还款日期: [{DATE}]\r\n还款总额: [{TOTAL}]元\r\n\r\n其中本金: [{AMOUNT}]元, 利息: [{INTEREST}]元";
$sms_text_repayment_7 = "[{NAME}][{GENDER}], 还款日期: [{DATE}], 还款总额: [{TOTAL}]元, 其中本金: [{AMOUNT}]元, 利息: [{INTEREST}]元";

$email_subject_repayment_3 = $site_name."还款3天通知 - [{NAME}][{GENDER}] - 身份证号: [{SSN}]";
$email_content_repayment_3 = "[{NAME}][{GENDER}]\r\n身份证号: [{SSN}]\r\n\r\n还款日期: [{DATE}]\r\n还款总额: [{TOTAL}]元\r\n\r\n其中本金: [{AMOUNT}]元, 利息: [{INTEREST}]元";
$sms_text_repayment_3 = "[{NAME}][{GENDER}], 还款日期: [{DATE}], 还款总额: [{TOTAL}]元, 其中本金: [{AMOUNT}]元, 利息: [{INTEREST}]元";

$email_subject_overdue = $site_name."欠款通知 - [{NAME}][{GENDER}] - 身份证号: [{SSN}]";
$email_content_overdue = "[{NAME}][{GENDER}]\r\n身份证号: [{SSN}]\r\n\r\n欠款总额: [{TOTAL}]元\r\n\r\n其中欠款: [{OWNED}]元, 罚金: [{FINE}]元";
$sms_text_overdue = "[{NAME}][{GENDER}], 欠款总额: [{TOTAL}]元, 其中欠款: [{OWNED}]元, 罚金: [{FINE}]元";

$email_subject_receive = $site_name."投资到期通知 - [{NAME}][{GENDER}] - 身份证号: [{SSN}]";
$email_content_receive = "[{NAME}][{GENDER}]\r\n身份证号: [{SSN}]\r\n\r\n贷款类型: [{CATEGORY}]\r\n贷款标题: [{TITLE}]\r\n年利率: [{RATE}]\r\n还款方式: [{METHOD}]\r\n起息日期: [{START}]\r\n到期日期: [{END}]\r\n投资期限: [{DURATION}]月\r\n投资总额: [{AMOUNT}]元";
$sms_text_receive = "[{NAME}][{GENDER}], 贷款类型: [{CATEGORY}], 贷款标题: [{TITLE}], 年利率: [{RATE}], 还款方式: [{METHOD}], 起息日期: [{START}], 到期日期: [{END}], 投资期限: [{DURATION}]月, 投资总额: [{AMOUNT}]元";

$email_subject_withdraw = $site_name."提现通知 - [{NAME}][{GENDER}] - 身份证号: [{SSN}]";
$email_content_withdraw = "[{NAME}][{GENDER}]\r\n身份证号: [{SSN}]\r\n\r\n银行卡号: [{NUMBER}]\r\n提现金额: [{AMOUNT}]元\r\n手续费: [{FEE}]元\r\n扣款总额: [{TOTAL}]元";
$sms_text_withdraw = "[{NAME}][{GENDER}], 银行卡号: [{NUMBER}], 提现金额: [{AMOUNT}], 手续费: [{FEE}], 扣款总额: [{TOTAL}]";

// email verification message
$email_subject_verification = $site_name."邮箱认证";
$email_url_verification = $http_scheme."://".$host."/api/security?type=4&usr_id=[{ID}]&code=[{CODE}]";
$email_content_verification = "请点击下面链接激活帐户，完成邮箱认证。<br />\r\n<a href='".$email_url_verification."'>".$email_url_verification."</a><br /><br />\r\n\r\n如果该链接无法点击，请直接拷贝以上网址到浏览器地址栏中访问。<br />\r\n".$email_url_verification."<br /><br />\r\n\r\n此信是由".$site_name."系统发出，系统不接受回信，请勿直接回复。<br /><br />\r\n\r\n如有任何疑问，请联系我们。";

// mobile security code sms-message
$sms_security_code = $site_name."手机验证码: [{CODE}]";
$sms_reset_pass_code = $site_name."手机验证码: [{CODE}], 用户名: [{NICKNAME}]";

date_default_timezone_set('Asia/Chongqing');

// compute the total money of the user account
function compute_money_total($available, $frozen, $investment, $loaned, $interest, $owned, $fine)
{
  return ($available + $frozen + $investment - ($loaned + $interest + $owned + $fine));
}

// convert string to interger with default value
function str2int($str, $default = 0)
{
  if (is_null($str) || strlen($str) == 0)
  {
    $value = $default;
  }
  else
  {
    $value = intval($str);
  }
  return $value;
}

// convert string to float with default value
function str2float($str, $default = 0)
{
  if (is_null($str) || strlen($str) == 0)
  {
    $value = $default;
  }
  else
  {
    $value = floatval($str);
  }
  return $value;
}

// convert string to datetime with default value
function str2datetime($str, $default = null)
{
  if (!is_null($str) && strlen($str) != 0)
  {
    try
    {
      $value = new DateTime($str);
    }
    catch (Exception $e)
    {
      $value = $default;
    }
  }
  else
  {
    $value = $default;
  }
  return $value;
}

// convert string to date with default value
function str2date($str, $default = null)
{
  if (!is_null($str) && strlen($str) != 0)
  {
    try
    {
      $value = new DateTime((new DateTime($str))->format("Y-m-d"));
    }
    catch (Exception $e)
    {
      $value = $default;
    }
  }
  else
  {
    $value = $default;
  }
  return $value;
}

// check if the current time (now) is in the rage: $start - $end
function is_now_valid($start, $end)
{
  $now = new DateTime;
  $hour = strval($now->format("H"));
  if ($hour >= $start && $hour < $end)
  {
    return true;
  }
  return false;
}

// compute the fee to save money
function compute_saving_fee($amount)
{
  $fee = 0;
  if (!is_null($amount) && $amount > 0)
  {
    $fee = $amount * 0.5;
    if ($fee > 10000)
    {
      $fee = 10000;
    }
    else 
    {
      $fee = ceil($fee);
    }
    $fee = $fee * 0.01;
  }
  return $fee;
}

// compute the fee for withdrawing
function compute_withdrawing_fee($amount)
{
  $fee = 0;
  if (!is_null($amount) && $amount > 0)
  {
    if ($amount < 20000)
    {
      $fee = 1;
    }
    else if ($amount < 50000)
    {
      $fee = 3;
    }
    else
    {
      $fee = 5;
    }
  }
  return $fee;
}

// check if the user is an auditor
function is_auditor($user)
{
  return is_array($user->roles) && in_array('auditor', $user->roles);
}

// check if the user is an accountant
function is_accountant($user)
{
  return is_array($user->roles) && in_array('accountant', $user->roles);
}

// check if the user is a manager
function is_manager($user)
{
  return is_array($user->roles) && in_array('manager', $user->roles);
}

// check if the user is the super-administrator
function is_administrator($user)
{
  return is_array($user->roles) && in_array('administrator', $user->roles);
}

// check if it is a valid ssn in China
function is_valid_ssn($ssn)
{
  if(is_null($ssn) || strlen($ssn) != 18)
  {
    return false;
  }
  $pattern = "/^[1-8][0-7]\d{4}(19|20)\d{2}(0[1-9]|1(0|1|2))(0[1-9]|(1|2)\d|3(0|1))\d{3}(\d|x)$/i";
  return preg_match($pattern, $ssn) == 1;
}

// check if it is a valid mobile phone number in China
function is_valid_mobile($mobile)
{
  if (is_null($mobile) || strlen($mobile) != 11)
  {
    return false;
  }
  $pattern = "/^1(3|4|5|7|8)\d{9}$/";
  return preg_match($pattern, $mobile) == 1;
}

// check if it is a valid password for our site
function is_valid_password($password)
{
  if (is_null($password) || strlen($password) < 6 || strlen($password) > 40)
  {
    return false;
  }
  $pattern = "/^[a-z0-9~`!@#\$%\^&\*\-_\+=\(\)\{\}\[\]\|:;\"\'\<\>\.,\?\/]{6,40}$/i";

  return (preg_match($pattern, $password) == 1);
}

// check if it is a secured password
function is_secured_password($password)
{
  if (is_null($password) || strlen($password) < 6 || strlen($password) > 40)
  {
    return false;
  }
  $pattern = "/^[a-z0-9~`!@#\$%\^&\*\-_\+=\(\)\{\}\[\]\|:;\"\'\<\>\.,\?\/]{6,40}$/i";
  $pattern1 = "/[A-Z]/";
  $pattern2 = "/[a-z]/";
  $pattern3 = "/[0-9]/";
  $pattern4 = "/[~`!@#\$%\^&\*\-_\+=\(\)\{\}\[\]\|:;\"\'\<\>\.,\?\/]/";

  return (preg_match($pattern, $password) == 1) && (preg_match($pattern1, $password) == 1) && (preg_match($pattern2, $password) == 1) && (preg_match($pattern3, $password) == 1) && (preg_match($pattern4, $password) == 1);
}

// check if it is a valid bank card number
function is_valid_bank_card_number($number)
{
  if (is_null($number) || strlen($number) < 16 || strlen($number) > 19)
  {
    return false;
  }
  $pattern = "/^\d{16,19}$/";
  return (preg_match($pattern, $number) == 1);
}

// check if it is a valid QQ
function is_valid_qq($qq)
{
  if (is_null($qq) || strlen($qq) < 3 || strlen($qq) > 16)
  {
    return false;
  }
  $pattern = "/^\d{3,18}$/";
  return (preg_match($pattern, $qq) == 1);
}

// check if it is a valid email
function is_valid_email($email)
{
  if (is_null($email) || strlen($email) < 6)
  {
    return false;
  }
  $pattern = "/^[_a-z0-9\-]+(\.[_a-z0-9\-]+)*@[a-z0-9\-]+(\.[a-z0-9\-]+)*(\.[a-z]{2,4})$/";
  return (preg_match($pattern, $email) == 1);
}

// check if it is a valid account
function is_valid_account($account)
{
  if (is_null($account) || strlen($account) < 2)
  {
    return false;
  }
  $pattern = "/^[_a-z0-9\-]+(\.[_a-z0-9\-]+)*$/";
  return (preg_match($pattern, $account) == 1);
}

// check if it is a valid weibo
function is_valid_weibo($weibo)
{
  if (is_null($weibo) || strlen($weibo) < 2)
  {
    return false;
  }
  return (is_valid_mobile($weibo) || is_valid_email($weibo) || is_valid_account($weibo));
}

// Randomly generate 6 digits mobile security code
function generate_mobile_code()
{
  $chars = "0123456789";
  srand((double)microtime()*1000000);
  $code = "";
  for ($i = 0; $i < 6; $i++)
  {
    $num = rand() % 10;
    $tmp = substr($chars, $num, 1);
    $code = $code . $tmp;
  }
  return $code;
}

// Randomly generate 6 digits user password
function generate_user_password()
{
  $chars = "0123456789abcdefghijklmnpqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ";

  srand((double)microtime()*1000000);
  $code = "";
  
  for ($i = 0; $i < 6; $i++)
  {
    $num = rand() % 60;
    $tmp = substr($chars, $num, 1);
    $code = $code . $tmp;
  }
  return $code;
}

function jsonstr($str)
{
  return (is_null($str) || empty($str)) ? "null" : "\"".str_replace("\"", "\\\"", str_replace("\r", "", str_replace("\n", "<br/>", $str)))."\"";
}

function jsonstrval($val)
{
  return is_null($val) ? "null" : strval($val);
}

function sqlstr($str)
{
  return (is_null($str) || empty($str)) ? "null" : "'".str_replace("'", "\\'", $str)."'";
}

function sqlstrval($val)
{
  return is_null($val) ? "null" : strval($val);
}


function mail_utf8($to, $from_user, $from_email, $subject = '(No subject)', $message = '')
{ 
  $from_user = "=?UTF-8?B?".base64_encode($from_user)."?=";
  $subject = "=?UTF-8?B?".base64_encode($subject)."?=";

  $headers = "From: $from_user <$from_email>\r\n".
      "MIME-Version: 1.0" . "\r\n". 
        "Content-type: text/html; charset=UTF-8" . "\r\n".
    "Return-Path:<no-reply@boryi.com>\r\n".
    "X-Mailer: PHP/" . phpversion();

  return mail($to, $subject, $message, $headers); 
}

/*
$todayStr = date("Y-m-d");
$today = new DateTime($todayStr);// date_create_from_format('Y-m-d', $todayStr);
$now = new DateTime;
$nowStr = $now->format("Y-m-d\TH:i:sP");
*/
?>
