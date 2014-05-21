<?php

include_once 'util_global.php';

if ($user->uid <= 0)
{
  echo "{\"result\":0}";
  exit;
}

if (!is_manager($user) && !is_administrator($user))
{
  echo "{\"result\":0}";
  exit;
}

$type = str2int($_GET['type']);
if ($type < 1 || $type > 3)
{
  echo "{\"result\":0}";
  exit;
}
$condition = "";
switch ($type)
{
  case 1:
    $id = str2int($_GET['id']);
    if ($id <= 0)
    {
      echo "{\"result\":0}";
      exit;
    }
    $condition = "act_info_usr_id = ".strval($id);
    break;
  case 2:
    $mobile = $_GET['mobile'];
    if (!is_valid_mobile($mobile))
    {
      echo "{\"result\":0}";
      exit;
    }
    $condition = "act_info_mobile = '".$mobile."'";
    break;
  case 3:
    $ssn = $_GET['ssn'];
    if (!is_valid_ssn($ssn))
    {
      echo "{\"result\":0}";
      exit;
    }
    $condition = "act_info_ssn = '".$ssn."'";
    break;
}

$con=mysqli_connect($db_host, $db_user, $db_pwd, $db_name);
// Check connection
if (mysqli_connect_errno())
{
  echo "{\"result\":0}";
  exit;
}
mysqli_set_charset($con, "UTF8");

$json = "";
$total = 0;

$query = "SELECT act_info_usr_id, act_info_nick, act_info_ssn_status, act_info_name, act_info_ssn, act_info_mobile_status, act_info_mobile, act_info_email_status, act_info_email, act_info_gender, act_info_dob, act_info_edu, act_info_marital, act_info_province, act_info_city, act_info_address, act_mny_available, act_mny_frozen, act_mny_investment, act_mny_loaned, act_mny_interest, act_mny_owned, act_mny_fine, act_mny_total, act_inv_interest, act_inv_fine, act_inv_interest_rate, act_ln_w_amount, act_ln_w_interest, act_ln_interest, act_ln_fine, act_ln_interest_rate FROM account_info_act_info LEFT JOIN account_money_act_mny ON act_info_usr_id = act_mny_usr_id LEFT JOIN account_investment_act_inv ON act_info_usr_id = act_inv_usr_id LEFT JOIN account_loan_act_ln ON act_info_usr_id = act_ln_usr_id WHERE ".$condition;
mysqli_query($con, "LOCK TABLES account_info_act_info READ, account_money_act_mny READ, account_investment_act_inv READ, account_loan_act_ln READ");
$result = mysqli_query($con, $query);
mysqli_query($con, "UNLOCK TABLES");
while ($row = mysqli_fetch_array($result))
{
  $act_info_usr_id = $row['act_info_usr_id'];
  $act_info_nick = $row['act_info_nick'];
  $act_info_ssn_status = $row['act_info_ssn_status'];
  $act_info_name = $row['act_info_name'];
  $act_info_ssn = $row['act_info_ssn'];
  $act_info_mobile_status = $row['act_info_mobile_status'];
  $act_info_mobile = $row['act_info_mobile'];
  $act_info_email_status = $row['act_info_email_status'];
  $act_info_email = $row['act_info_email'];
  $act_info_gender = $row['act_info_gender'];
  $act_info_dob = $row['act_info_dob'];
  $act_info_edu = $row['act_info_edu'];
  $act_info_marital = $row['act_info_marital'];
  $act_info_province = $row['act_info_province'];
  $act_info_city = $row['act_info_city'];
  $act_info_address = $row['act_info_address'];
  $act_mny_available = $row['act_mny_available'];
  $act_mny_frozen = $row['act_mny_frozen'];
  $act_mny_investment = $row['act_mny_investment'];
  $act_mny_loaned = $row['act_mny_loaned'];
  $act_mny_interest = $row['act_mny_interest'];
  $act_mny_owned = $row['act_mny_owned'];
  $act_mny_fine = $row['act_mny_fine'];
  $act_mny_total = $row['act_mny_total'];
  $act_inv_interest = $row['act_inv_interest'];
  $act_inv_fine = $row['act_inv_fine'];
  $act_inv_interest_rate = $row['act_inv_interest_rate'];
  $act_ln_w_amount = $row['act_ln_w_amount'];
  $act_ln_w_interest = $row['act_ln_w_interest'];
  $act_ln_interest = $row['act_ln_interest'];
  $act_ln_fine = $row['act_ln_fine'];
  $act_ln_interest_rate = $row['act_ln_interest_rate'];

  $json = $json.",{\"id\":".jsonstrval($act_info_usr_id).",\"nick\":".jsonstr($act_info_nick).",\"ssn_status\":".jsonstrval($act_info_ssn_status).",\"name\":".jsonstr($act_info_name).",\"ssn\":".jsonstr($act_info_ssn).",\"mobile_status\":".jsonstrval($act_info_mobile_status).",\"mobile\":".jsonstr($act_info_mobile).",\"email_status\":".jsonstrval($act_info_email_status).",\"email\":".jsonstr($act_info_email).",\"gender\":".jsonstrval($act_info_gender).",\"dob\":".jsonstr($act_info_dob).",\"education\":".jsonstrval($act_info_edu).",\"marital\":".jsonstrval($act_info_marital).",\"province\":".jsonstrval($act_info_province).",\"city\":".jsonstrval($act_info_city).",\"address\":".jsonstr($act_info_address).",\"amount_available\":".jsonstrval($act_mny_available).",\"amount_frozen\":".jsonstrval($act_mny_frozen).",\"amount_investment\":".jsonstrval($act_mny_investment).",\"amount_loaned\":".jsonstrval($act_mny_loaned).",\"amount_interest\":".jsonstrval($act_mny_interest).",\"amount_owned\":".jsonstrval($act_mny_owned).",\"amount_fine\":".jsonstrval($act_mny_fine).",\"amount_total\":".jsonstrval($act_mny_total).",\"inv_interest\":".jsonstrval($act_inv_interest).",\"inv_fine\":".jsonstrval($act_inv_fine).",\"inv_rate\":".jsonstrval($act_inv_interest_rate).",\"ln_w_amount\":".jsonstrval($act_ln_w_amount).",\"ln_w_interest\":".jsonstrval($act_ln_w_interest).",\"ln_interest\":".jsonstrval($act_ln_interest).",\"ln_fine\":".jsonstrval($act_ln_fine).",\"ln_rate\":".jsonstrval($act_ln_interest_rate)."}";
  $total += 1;
}
mysqli_free_result($result);

mysqli_kill($con, mysqli_thread_id($con));
mysqli_close($con);

$json = substr($json, 1);
$json = "{\"result\":1,\"total\":".jsonstrval($total).",\"users\":[".$json."]}";

echo $json;
?>