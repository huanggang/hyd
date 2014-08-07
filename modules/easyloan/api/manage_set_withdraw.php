<?php

function manage_set_withdraw(){
  include_once 'util_hyd_log.php';

  $todayStr = date("Y-m-d");
  $today = new DateTime($todayStr);// date_create_from_format('Y-m-d', $todayStr);
  $now = new DateTime;
  $nowStr = $now->format("Y-m-d\TH:i:sP");

  if ($user->uid <= 0)
  {
    echo "{\"result\":0}";
    exit;
  }
  $usr_id = $user->uid;

  if (!is_accountant($user) && !is_administrator($user))
  {
    echo "{\"result\":0}";
    exit;
  }

  // check current time between 9am - 11pm
  if (!is_now_valid($time_user_start, $time_user_end))
  {
    echo "{\"result\":0}";
    exit;
  }

  $type = str2int($_GET['type']);
  $id = str2int($_GET['id']);
  if ($id <= 0)
  {
    echo "{\"result\":0}";
    exit;
  }
  $time = str2datetime($_GET['time']);
  if (is_null($time))
  {
    echo "{\"result\":0}";
    exit;
  }
  $number = $_GET['number'];
  if (!is_valid_bank_card_number($number))
  {
    echo "{\"result\":0}";
    exit;
  }
  $amount = str2float($_GET['amount']);
  if ($amount <= 0)
  {
    echo "{\"result\":0}";
    exit;
  }
  $fee = str2float($_GET['fee']);
  if ($fee <= 0)
  {
    echo "{\"result\":0}";
    exit;
  }

  switch ($type)
  {
    case 1: // granted
      hyd_log($now, $usr_id, "提现申请审批", "转账: 提现用户, 提现申请时间, 用户银行卡号, 金额, 费用", "type=1&id=".strval($id)."&time=".$_GET['time']."&number=".$number."&amount=".strval($amount)."&fee=".strval($fee));
      break;
    default: // rejected
      hyd_log($now, $usr_id, "提现申请审批", "拒绝: 提现用户, 提现申请时间, 用户银行卡号, 金额, 费用", "type=0&id=".strval($id)."&time=".$_GET['time']."&number=".$number."&amount=".strval($amount)."&fee=".strval($fee));
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

  $flag = false;
  mysqli_autocommit($con, false);

  switch ($type)
  {
    case 1: // granted
      mysqli_query($con, "LOCK TABLES account_withdraws_act_wths WRITE, account_withdraw_act_wth WRITE, account_money_act_mny WRITE, account_transactions_act_trn WRITE");

      $query = "SELECT act_wths_usr_id FROM account_withdraws_act_wths WHERE act_wths_usr_id = ".strval($id)." AND act_wths_time = '".$time->format("Y-m-d\TH:i:s")."' AND act_wths_bnk_number = '".$number."' AND act_wths_amount = ".strval($amount)." AND act_wths_fee = ".strval($fee)." AND act_wths_is_done IS NULL AND act_wths_done IS NULL";
      $result = mysqli_query($con, $query);
      if ($row = mysqli_fetch_array($result))
      {
        mysqli_free_result($result);

        $query = "SELECT act_wth_amount, act_wth_fee, act_wth_times FROM account_withdraw_act_wth WHERE act_wth_usr_id = ".strval($id);
        $result = mysqli_query($con, $query);
        if ($row = mysqli_fetch_array($result))
        {
          $act_wth_amount = $row['act_wth_amount'];
          $act_wth_fee = $row['act_wth_fee'];
          $act_wth_times = $row['act_wth_times'];
          $act_wth_amount += $amount;
          $act_wth_fee += $fee;
          $act_wth_times += 1;
          mysqli_free_result($result);

          $query = "SELECT act_mny_available, act_mny_frozen, act_mny_investment, act_mny_loaned, act_mny_interest, act_mny_owned, act_mny_fine FROM account_money_act_mny WHERE act_mny_usr_id = ".strval($id);
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
            mysqli_free_result($result);

            if ($act_mny_frozen >= ($amount + $fee))
            {
              $query = "UPDATE account_withdraws_act_wths SET act_wths_is_done = 1, act_wths_done = ".sqlstr($nowStr).", act_wths_mng_usr_id = ".sqlstrval($usr_id)." WHERE act_wths_usr_id = ".strval($id)." AND act_wths_time = '".$time->format("Y-m-d\TH:i:s")."' AND act_wths_bnk_number = ".$number." AND act_wths_amount = ".strval($amount)." AND act_wths_fee = ".strval($fee)." AND act_wths_is_done IS NULL AND act_wths_done IS NULL";
              $flag = mysqli_query($con, $query) != false;

              $query = "UPDATE account_withdraw_act_wth SET act_wth_amount = ".sqlstrval($act_wth_amount).", act_wth_fee = ".sqlstrval($act_wth_fee).", act_wth_times = ".sqlstrval($act_wth_times).", act_wth_updated = ".sqlstr($nowStr)." WHERE act_wth_usr_id = ".strval($id);
              $flag = $flag && (mysqli_query($con, $query) != false);

              $act_mny_frozen = $act_mny_frozen - $amount - $fee;
              $act_mny_total = compute_money_total($act_mny_available, $act_mny_frozen, $act_mny_investment, $act_mny_loaned, $act_mny_interest, $act_mny_owned, $act_mny_fine);
              $query = "UPDATE account_money_act_mny SET act_mny_frozen = ".sqlstrval($act_mny_frozen).", act_mny_total = ".sqlstrval($act_mny_total).", act_mny_updated = ".sqlstr($nowStr)." WHERE act_mny_usr_id = ".strval($id);
              $flag = $flag && (mysqli_query($con, $query) != false);

              $total = $amount + $fee;
              $act_trn_available = $act_mny_available + $act_mny_frozen;
              $query = "INSERT INTO account_transactions_act_trn (act_trn_usr_id, act_trn_time, act_trn_type, act_trn_amount, act_trn_available, act_trn_owned, act_trn_fine, act_trn_note) VALUES (".sqlstrval($id).",".sqlstr($nowStr).",2,".sqlstrval($total).",".sqlstrval($act_trn_available).",".sqlstrval($act_mny_owned).",".sqlstrval($act_mny_fine).",'".sqlstrval($fee)."')";
              $flag = $flag && (mysqli_query($con, $query) != false);
            }
          }
        }
      }
      break;
    default: // rejected
      mysqli_query($con, "LOCK TABLES account_withdraws_act_wths WRITE, account_money_act_mny WRITE");

      $query = "SELECT act_wths_usr_id FROM account_withdraws_act_wths WHERE act_wths_usr_id = ".strval($id)." AND act_wths_time = '".$time->format("Y-m-d\TH:i:s")."' AND act_wths_bnk_number = '".$number."' AND act_wths_amount = ".strval($amount)." AND act_wths_fee = ".strval($fee)." AND act_wths_is_done IS NULL AND act_wths_done IS NULL";
      $result = mysqli_query($con, $query);
      if ($row = mysqli_fetch_array($result))
      {
        mysqli_free_result($result);

        $query = "SELECT act_mny_available, act_mny_frozen, act_mny_investment, act_mny_loaned, act_mny_interest, act_mny_owned, act_mny_fine FROM account_money_act_mny WHERE act_mny_usr_id = ".strval($id);
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
          mysqli_free_result($result);

          if ($act_mny_frozen >= ($amount + $fee))
          {
            $query = "UPDATE account_withdraws_act_wths SET act_wths_is_done = 0, act_wths_done = ".sqlstr($nowStr).", act_wths_mng_usr_id = ".sqlstrval($usr_id)." WHERE act_wths_usr_id = ".strval($id)." AND act_wths_time = '".$time->format("Y-m-d\TH:i:s")."' AND act_wths_bnk_number = '".$number."' AND act_wths_amount = ".strval($amount)." AND act_wths_fee = ".strval($fee)." AND act_wths_is_done IS NULL AND act_wths_done IS NULL";
            $flag = mysqli_query($con, $query) != false;

            $amount += $fee;
            $act_mny_frozen = $act_mny_frozen - $amount;

            $act_mny_available += $amount;
            $query = "UPDATE account_money_act_mny SET act_mny_available = ".sqlstrval($act_mny_available).", act_mny_frozen = ".sqlstrval($act_mny_frozen).", act_mny_updated = ".sqlstr($nowStr)." WHERE act_mny_usr_id = ".strval($id);
            $flag = $flag && (mysqli_query($con, $query) != false);
          }
        }
      }
      break;
  }

  if ($flag)
  {
    mysqli_commit($con);
    echo "{\"result\":1}";
  }
  else
  {
    mysqli_rollback($con);
    echo "{\"result\":0, \"message\":\"DB write failure\"}";
  }
  mysqli_query($con, "UNLOCK TABLES");

  mysqli_kill($con, mysqli_thread_id($con));
  mysqli_close($con);
}
?>