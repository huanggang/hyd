<?php

include_once 'util_global.php';

if ($user->uid <= 0)
{
  echo "{\"result\":0}";
  exit;
}
$usr_id = $user->uid;

$con=mysqli_connect($db_host, $db_user, $db_pwd, $db_name);
// Check connection
if (mysqli_connect_errno())
{
  echo "{\"result\":0}";
  exit;
}
mysqli_set_charset($con, "UTF8");

mysqli_query($con, "LOCK TABLES account_info_act_info READ, account_money_act_mny READ, account_investment_act_inv READ, account_load_act_ln READ");

$query = "SELECT act_info_nick, act_info_ssn_status, act_info_mobile_status, act_info_email_status, act_info_cash_pass FROM account_info_act_info WHERE act_info_usr_id = ".strval($usr_id);
$result = mysqli_query($con, $query);
if ($row = mysqli_fetch_array($result))
{
  $act_info_nick = $row['act_info_nick'];
  $act_info_ssn_status = $row['act_info_ssn_status'];
  $act_info_mobile_status = $row['act_info_mobile_status'];
  $act_info_email_status = $row['act_info_email_status'];
  $act_info_cash_pass = $row['act_info_cash_pass'];  
  mysqli_free_result($result);

  $query = "SELECT act_mny_available, act_mny_frozen, act_mny_investment, act_mny_loaned, act_mny_interest, act_mny_owned, act_mny_fine, act_mny_total FROM account_money_act_mny WHERE act_mny_usr_id = ".strval($usr_id);
  $result = mysqli_query($con, $query);
  if ($row = mysqli_fetch_array($result))
  {
    $act_mny_available = $row['act_mny_available'];
    $act_mny_frozen = $row['act_mny_frozen'];
    $act_mny_investment = $row['act_mny_investment'];
    $act_mny_loaned = $row['act_mny_loaned'];
    $act_mny_interest = $row['act_mny_interest'];
    $act_mny_owned = $row['act_mny_owned'];
    $act_mny_fine = $row['act_mny_fine'];
    $act_mny_total = $row['act_mny_total'];
    mysqli_free_result($result);

    $query = "SELECT act_inv_interest, act_inv_fine, act_inv_interest_rate FROM account_investment_act_inv WHERE act_inv_usr_id = ".strval($usr_id);
    $result = mysqli_query($con, $query);
    if ($row = mysqli_fetch_array($result))
    {
      $act_inv_interest = $row['act_inv_interest'];
      $act_inv_fine = $row['act_inv_fine'];
      $act_inv_interest_rate = $row['act_inv_interest_rate'];
      mysqli_free_result($result);

      $query = "SELECT act_ln_w_amount, act_ln_w_interest, act_ln_interest, act_ln_fine, act_ln_interest_rate, act_ln_w_owned, act_ln_w_fine FROM account_loan_act_ln WHERE act_ln_usr_id = ".strval($usr_id);
      $result = mysqli_query($con, $query);
      if ($row = mysqli_fetch_array($result))
      {
        $act_ln_w_amount = $row['act_ln_w_amount'];
        $act_ln_w_interest = $row['act_ln_w_interest'];
        $act_ln_interest = $row['act_ln_interest'];
        $act_ln_fine = $row['act_ln_fine'];
        $act_ln_interest_rate = $row['act_ln_interest_rate'];
        $act_ln_w_owned = $row['act_ln_w_owned'];
        $act_ln_w_fine = $row['act_ln_w_fine'];
        mysqli_free_result($result);

        $info = "{\"nick\":\"%s\",\"amount_available\":%f,\"amount_frozen\":%f,\"amount_investment\":%f,\"amount_loaned\":%f,\"amount_interest\":%f,\"amount_owned\":%f,\"amount_fine\":%f,\"amount_total\":%f,\"investment\":{\"interest\":%f,\"fine\":%f,\"rate\":%f},\"loan\":{\"w_amount\":%f,\"w_interest\":%f,\"w_owned\":%f,\"w_fine\":%f,\"interest\":%f,\"fine\":%f,\"rate\":%f},\"has_mobile\":%d,\"has_ssn\":%d,\"has_email\":%d,\"has_cash_password\":%d}";
        $info = sprintf($info, $act_info_nick, $act_mny_available, $act_mny_frozen, $act_mny_investment, $act_mny_loaned, $act_mny_interest, $act_mny_owned, $act_mny_fine, $act_mny_total, $act_inv_interest, $act_inv_fine, $act_inv_interest_rate, $act_ln_w_amount, $act_ln_w_interest, $act_ln_w_owned, $act_ln_w_fine, $act_ln_interest, $act_ln_fine, $act_ln_interest_rate, $act_info_mobile_status, $act_info_ssn_status, $act_info_email_status, !is_null($act_info_cash_pass));
        echo $info;
      }
      else
      {
        echo "{\"result\":0,\"message\":\"User loan account not found\"}";
      }
    }
    else
    {
      echo "{\"result\":0,\"message\":\"User investment account not found\"}";
    }
  }
  else
  {
    echo "{\"result\":0,\"message\":\"User money account not found\"}";
  }
}
else
{
  echo "{\"result\":0,\"message\":\"User not found\"}";
}

mysqli_query($con, "UNLOCK TABLES");
mysqli_kill($con, mysqli_thread_id($con));
mysqli_close($con);
?>