<?php

function account_withdraw(){

  include_once 'util_global.php';

  if ($user->uid <= 0)
  {
    echo "{\"result\":0}";
    exit;
  }
  $usr_id = $user->uid;
  // check current time between 9am - 11pm
  if (!is_now_valid($time_user_start, $time_user_end))
  {
    echo "{\"result\":0,\"message\":\"Overtime\"}";
    exit;
  }

  $number = $_GET["number"];
  if (!is_valid_bank_card_number($number))
  {
    echo "{\"result\":0}";
    exit;
  }
  $amountStr = $_GET["amount"];
  $amount = str2float($amountStr);
  if ($amount <= 0)
  {
    echo "{\"result\":0}";
    exit;
  }
  $feeStr = $_GET["fee"];
  $fee = str2float($feeStr);
  if ($fee < 0 || $fee != compute_withdrawing_fee($amount))
  {
    echo "{\"result\":0}";
    exit;
  }
  $cash_pass = $_GET["cash_pass"];

  $now = new DateTime;
  $nowStr = $now->format("Y-m-d\TH:i:sP");

  $con=mysqli_connect($db_host, $db_user, $db_pwd, $db_name);
  // Check connection
  if (mysqli_connect_errno())
  {
    echo "{\"result\":0}";
    exit;
  }
  mysqli_set_charset($con, "UTF8");

  mysqli_autocommit($con, false);
  mysqli_query($con, "LOCK TABLES account_info_act_info READ, account_banks_act_bnk READ, account_money_act_mny WRITE, account_withdraws_act_wths WRITE");

  $query = "SELECT act_info_usr_id FROM account_info_act_info WHERE act_info_usr_id = ".strval($usr_id)." AND act_info_cash_pass = SHA2('".$cash_pass."',256)";
  $result = mysqli_query($con, $query);
  if (mysqli_fetch_array($result))
  {
    mysqli_free_result($result);

    $query = "SELECT act_bnk_number FROM account_banks_act_bnk WHERE act_bnk_usr_id = ".strval($usr_id)." AND act_bnk_number = '".$number."'";
    $result = mysqli_query($con, $query);
    if (mysqli_fetch_array($result))
    {
      mysqli_free_result($result);

      $query = "SELECT act_mny_available, act_mny_frozen FROM account_money_act_mny WHERE act_mny_usr_id = ".strval($usr_id);
      $result = mysqli_query($con, $query);
      $row = mysqli_fetch_array($result);
      $act_mny_available = $row['act_mny_available'];
      $act_mny_frozen = $row['act_mny_frozen'];
      mysqli_free_result($result);

      if ($act_mny_available >= ($amount + $fee))
      {
        $act_mny_available = $act_mny_available - ($amount + $fee);
        $act_mny_frozen += $amount + $fee;
        $query = "UPDATE account_money_act_mny SET act_mny_available = ".sqlstrval($act_mny_available).", act_mny_frozen = ".sqlstrval($act_mny_frozen).", act_mny_updated = ".sqlstr($nowStr)." WHERE act_mny_usr_id = ".strval($usr_id);
        $flag = mysqli_query($con, $query) != false;

        $query = "INSERT INTO account_withdraws_act_wths (act_wths_usr_id, act_wths_time, act_wths_bnk_number, act_wths_amount, act_wths_fee, act_wths_is_done, act_wths_done) VALUES (".sqlstrval($usr_id).", ".sqlstr($nowStr).", ".sqlstr($number).", ".sqlstrval($amount).", ".sqlstrval($fee).", NULL, NULL)";
        $flag = $flag && (mysqli_query($con, $query) != false);
        if ($flag)
        {
          mysqli_commit($con);
          echo "{\"result\":1}";
        }
        else
        {
          mysqli_rollback($con);
          echo "{\"result\":0,\"message\":\"DB write failure\"}";
        }
      }
      else
      {
        echo "{\"result\":0, \"message\":\"Not enough money\"}";
      }
    }
    else
    {
      echo "{\"result\":0, \"message\":\"Invalid bank card number\"}";
    }
  }
  else
  {
    echo "{\"result\":0, \"message\":\"Invalid cash password\"}";
  }
  mysqli_query($con, "UNLOCK TABLES");
  mysqli_kill($con, mysqli_thread_id($con));
  mysqli_close($con);
}
?>