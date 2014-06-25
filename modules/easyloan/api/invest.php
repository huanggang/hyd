<?php

function invest(){

  include_once 'util_check_pre_investment.php';

  $todayStr = date("Y-m-d");
  $today = new DateTime($todayStr);// date_create_from_format('Y-m-d', $todayStr);
  $now = new DateTime;
  $nowStr = $now->format("Y-m-d\TH:i:sP");
  // check current time between 9am - 11pm
  if (!is_now_valid($time_user_start, $time_user_end))
  {
    echo "{\"result\":0,\"message\":\"Overtime\"}";
    exit;
  }

  $idStr = $_GET["id"];
  $id = str2int($idStr, 0);
  if ($id <= 0)
  {
    echo "{\"result\":0}";
    exit;
  }
  $amountStr = $_GET["amount"];
  $amount = str2float($amountStr, 0);
  if ($amount <= 0)
  {
    echo "{\"result\":0}";
    exit;
  }
  if ($user->uid <= 0)
  {
    echo "{\"result\":0}";
    exit;
  }
  $usr_id = $user->uid;

  $flag = false;

  $con=mysqli_connect($db_host, $db_user, $db_pwd, $db_name);
  // Check connection
  if (mysqli_connect_errno())
  {
    echo "{\"result\":0}";
    exit;
  }
  mysqli_set_charset($con, "UTF8");

  mysqli_autocommit($con, false);
  mysqli_query($con, "LOCK TABLES applications_app READ, loans_lns READ, account_money_act_mny WRITE, investments_inv WRITE, investment_accounts_inv_act WRITE");

  $query = "SELECT app_usr_id FROM applications_app WHERE app_usr_id = ".strval($usr_id)." AND (app_is_done = 0 OR (app_is_done = 1 AND app_is_loaned IS NULL))";
  $result = mysqli_query($con, $query);
  if (is_null(mysqli_fetch_array($result)))
  {
    mysqli_free_result($result);

    $query = "SELECT lns_usr_id FROM loans_lns WHERE lns_usr_id = ".strval($usr_id)." AND lns_is_done = 0";
    $result = mysqli_query($con, $query);
    if (is_null(mysqli_fetch_array($result)))
    {
      mysqli_free_result($result);

      $query = "SELECT act_mny_available, act_mny_frozen FROM account_money_act_mny WHERE act_mny_usr_id = ".strval($usr_id);
      $result = mysqli_query($con, $query);
      $row = mysqli_fetch_array($result);mysqli_query($con, $query);
      $act_mny_available = $row['act_mny_available'];
      $act_mny_frozen = $row['act_mny_frozen'];
      mysqli_free_result($result);

      if ($act_mny_available >= $amount)
      {
        $query = "SELECT inv_amount, inv_minimum, inv_step, inv_investment FROM investments_inv WHERE inv_app_id = ".strval($id)." AND inv_is_done IS NULL AND inv_start > '".$todayStr."'";
        $result = mysqli_query($con, $query);
        if ($row = mysqli_fetch_array($result))
        {
          $inv_amount = $row['inv_amount'];
          $inv_minimum = $row['inv_minimum'];
          $inv_step = $row['inv_step'];
          $inv_investment = $row['inv_investment'];
          mysqli_free_result($result);

          if ($amount >= $inv_minimum && ($amount - $inv_minimum) % $inv_step == 0 && ($inv_amount - $inv_investment) >= $amount)
          {
            $inv_investment += $amount;
            $query = "UPDATE investments_inv SET inv_investment = ".sqlstrval($inv_investment)." WHERE inv_app_id = ".strval($id);
            $flag = (mysqli_query($con, $query) != false);

            $query = "INSERT INTO investment_accounts_inv_act (inv_act_app_id, inv_act_time, inv_act_usr_id, inv_act_amount) VALUES (".sqlstrval($id).", ".sqlstr($nowStr).", ".sqlstrval($usr_id).", ".sqlstrval($amount).")";
            $flag = $flag && (mysqli_query($con, $query) != false);

            $act_mny_available = $act_mny_available - $amount;
            $act_mny_frozen = $act_mny_frozen + $amount;
            $query = "UPDATE account_money_act_mny SET act_mny_available = ".sqlstrval($act_mny_available).", act_mny_frozen = ".sqlstrval($act_mny_frozen).", act_mny_updated = ".sqlstr($nowStr)." WHERE act_mny_usr_id = ".strval($usr_id);
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
            echo "{\"result\":0,\"message\":\"Invalid investing amount of money\"}";
          }
        }
        else
        {
          echo "{\"result\":0,\"message\":\"Investment closed for investing\"}";
        }
      }
      else
      {
        echo "{\"result\":0,\"message\":\"Insufficient money\"}";
      }
    }
    else
    {
      echo "{\"result\":0,\"message\":\"Unfinished loan\"}";
    }
  }
  else
  {
    echo "{\"result\":0,\"message\":\"Under processing loan application\"}";
  }

  mysqli_query($con, "UNLOCK TABLES");
  mysqli_kill($con, mysqli_thread_id($con));
  mysqli_close($con);

  if ($flag)
  {
    check_pre_investment($id);
  }
}
?>