<?php

include_once 'util_notify_user.php';

class EmailSmsCount
{
  public $total_email = 0;
  public $total_sms = 0;
  public $failed_email = 0;
  public $failed_sms = 0;
}

function sum_email_sms($cnt, $type, $is_sent)
{
  switch ($type)
  {
    case 1:
      $cnt->total_email = $cnt->total_email + 1;
      break;
    case 2:
      $cnt->total_sms = $cnt->total_sms + 1;
      break;
    case 3:
      $cnt->total_email = $cnt->total_email + 1;
      $cnt->total_sms = $cnt->total_sms + 1;
      break;
  }
  $res = $type ^ $is_sent;
  if ($res > 0)
  {
    switch ($res)
    {
      case 1:
        $cnt->failed_email = $cnt->failed_email + 1;
        break;
      case 2:
        $cnt->failed_sms = $cnt->failed_sms + 1;
        break;
      case 3:
        $cnt->failed_email = $cnt->failed_email + 1;
        $cnt->failed_sms = $cnt->failed_sms + 1;
        break;
    }
  }
  return $cnt;
}

function notify()
{
  global $email_subject_repayment_7, $email_content_repayment_7, $sms_text_repayment_7, $email_subject_repayment_3, $email_content_repayment_3, $sms_text_repayment_3, $email_subject_overdue, $email_content_overdue, $sms_text_overdue, $email_subject_receive, $email_content_receive, $sms_text_receive, $email_subject_withdraw, $email_content_withdraw, $sms_text_withdraw;
  global $time_notify_start, $time_notify_end, $db_host, $db_user, $db_pwd, $db_name;
  // check if time is between 9am - 5pm
  if (!is_now_valid($time_notify_start, $time_notify_end))
  {
    return false;
  }
  $todayStr = date("Y-m-d");
  $today = new DateTime($todayStr);// date_create_from_format('Y-m-d', $todayStr);
  $now = new DateTime;
  $nowStr = $now->format("Y-m-d\TH:i:sP");

  $cnt = new EmailSmsCount();

  $con=mysqli_connect($db_host, $db_user, $db_pwd, $db_name);
  if (mysqli_connect_errno())
  {
    return false;
  }
  mysqli_set_charset($con, "UTF8");
  mysqli_query($con, "LOCK TABLES notices_nt READ");
  $result = mysqli_query($con, "SELECT nt_repayment_7, nt_repayment_3, nt_overdue, nt_receive, nt_withdraw FROM notices_nt ORDER BY nt_time DESC LIMIT 0,1");
  mysqli_query($con, "UNLOCK TABLES");
  if ($row = mysqli_fetch_array($result))
  {
    $nt_repayment_7 = $row['nt_repayment_7'];
    $nt_repayment_3 = $row['nt_repayment_3'];
    $nt_overdue = $row['nt_overdue'];
    $nt_receive = $row['nt_receive'];
    $nt_withdraw = $row['nt_withdraw'];
    mysqli_free_result($result);

    if ($nt_repayment_7 >= 1)
    {
      $day7Str = $today->add(new DateInterval('P7D'))->format("Y-m-d");
      mysqli_query($con, "LOCK TABLES account_loan_act_ln READ");
      $result1 = mysqli_query($con, "SELECT act_ln_usr_id, act_ln_app_id, act_ln_n_date, act_ln_n_amount, act_ln_n_interest FROM account_loan_act_ln WHERE act_ln_n_date IS NOT NULL AND DATE(act_ln_n_date) = ".sqlstr($day7Str));
      mysqli_query($con, "UNLOCK TABLES");
      while ($row1 = mysqli_fetch_array($result1))
      {
        $act_ln_usr_id = $row1['act_ln_usr_id'];
        $act_ln_app_id = $row1['act_ln_app_id'];
        $act_ln_n_date = $row1['act_ln_n_date'];
        $act_ln_n_amount = $row1['act_ln_n_amount'];
        $act_ln_n_interest = $row1['act_ln_n_interest'];
        $total = $act_ln_n_amount + $act_ln_n_interest;

        $subject = $email_subject_repayment_7;
        $content = str_replace("[{DATE}]", $act_ln_n_date, $email_content_repayment_7);
        $content = str_replace("[{TOTAL}]", strval($total), $content);
        $content = str_replace("[{AMOUNT}]", strval($act_ln_n_amount), $content);
        $content = str_replace("[{INTEREST}]", strval($act_ln_n_interest), $content);
        $text = str_replace("[{DATE}]", $act_ln_n_date, $sms_text_repayment_7);
        $text = str_replace("[{TOTAL}]", strval($total), $text);
        $text = str_replace("[{AMOUNT}]", strval($act_ln_n_amount), $text);
        $text = str_replace("[{INTEREST}]", strval($act_ln_n_interest), $text);

        $is_sent = notify_user($nt_repayment_7, $act_ln_usr_id, $subject, $content, $text);
        $cnt = sum_email_sms($cnt, $nt_repayment_7, $is_sent);
      }
      mysqli_free_result($result1);
    }
    if ($nt_repayment_3 >= 1)
    {
      $day3Str = $today->add(new DateInterval('P3D'))->format("Y-m-d");
      mysqli_query($con, "LOCK TABLES account_loan_act_ln READ");
      $result1 = mysqli_query($con, "SELECT act_ln_usr_id, act_ln_app_id, act_ln_n_date, act_ln_n_amount, act_ln_n_interest FROM account_loan_act_ln WHERE act_ln_n_date IS NOT NULL AND DATE(act_ln_n_date) = ".sqlstr($day3Str));
      mysqli_query($con, "UNLOCK TABLES");
      while ($row1 = mysqli_fetch_array($result1))
      {
        $act_ln_usr_id = $row1['act_ln_usr_id'];
        $act_ln_app_id = $row1['act_ln_app_id'];
        $act_ln_n_date = $row1['act_ln_n_date'];
        $act_ln_n_amount = $row1['act_ln_n_amount'];
        $act_ln_n_interest = $row1['act_ln_n_interest'];
        $total = $act_ln_n_amount + $act_ln_n_interest;

        $subject = $email_subject_repayment_3;
        $content = str_replace("[{DATE}]", $act_ln_n_date, $email_content_repayment_3);
        $content = str_replace("[{TOTAL}]", strval($total), $content);
        $content = str_replace("[{AMOUNT}]", strval($act_ln_n_amount), $content);
        $content = str_replace("[{INTEREST}]", strval($act_ln_n_interest), $content);
        $text = str_replace("[{DATE}]", $act_ln_n_date, $sms_text_repayment_3);
        $text = str_replace("[{TOTAL}]", strval($total), $text);
        $text = str_replace("[{AMOUNT}]", strval($act_ln_n_amount), $text);
        $text = str_replace("[{INTEREST}]", strval($act_ln_n_interest), $text);

        $is_sent = notify_user($nt_repayment_3, $act_ln_usr_id, $subject, $content, $text);
        $cnt = sum_email_sms($cnt, $nt_repayment_3, $is_sent);
      }
      mysqli_free_result($result1);
    }
    if ($nt_overdue >= 1)
    {
      mysqli_query($con, "LOCK TABLES account_loan_act_ln READ");
      $result1 = mysqli_query($con, "SELECT act_ln_usr_id, act_ln_app_id, act_ln_w_owned, act_ln_w_fine FROM account_loan_act_ln WHERE act_ln_w_owned IS NOT NULL AND act_ln_w_owned > 0");
      mysqli_query($con, "UNLOCK TABLES");
      while ($row1 = mysqli_fetch_array($result1))
      {
        $act_ln_usr_id = $row1['act_ln_usr_id'];
        $act_ln_app_id = $row1['act_ln_app_id'];
        $act_ln_w_owned = $row1['act_ln_w_owned'];
        $act_ln_w_fine = $row1['act_ln_w_fine'];
        $total = $act_ln_w_owned + $act_ln_w_fine;

        $subject = $email_subject_overdue;
        $content = str_replace("[{OWNED}]", strval($act_ln_w_owned), $email_content_overdue);
        $content = str_replace("[{FINE}]", strval($act_ln_w_fine), $content);
        $content = str_replace("[{TOTAL}]", strval($total), $content);
        $text = str_replace("[{OWNED}]", strval($act_ln_w_owned), $sms_text_overdue);
        $text = str_replace("[{FINE}]", strval($act_ln_w_fine), $text);
        $text = str_replace("[{TOTAL}]", strval($total), $text);
 
        $is_sent = notify_user($nt_overdue, $act_ln_usr_id, $subject, $content, $text);
        $cnt = sum_email_sms($cnt, $nt_overdue, $is_sent);
      }
      mysqli_free_result($result1);
    }
    if ($nt_receive >= 1)
    {
      mysqli_query($con, "LOCK TABLES investments_inv READ, loan_categories_ln_ctg READ, repayment_methods_rpy_mth READ");
      $result1 = mysqli_query($con, "SELECT inv_app_id, ln_ctg_category, inv_title, inv_interest_rate, rpy_mth_method, inv_duration, inv_start, inv_end FROM investments_inv LEFT JOIN loan_categories_ln_ctg ON inv_category = ln_ctg_id LEFT JOIN repayment_methods_rpy_mth ON inv_repayment_method = rpy_mth_id WHERE inv_end = ".sqlstr($todayStr));
      mysqli_query($con, "UNLOCK TABLES");
      while ($row1 = mysqli_fetch_array($result1))
      {
        $inv_app_id = $row1['inv_app_id'];
        $ln_ctg_category = $row1['ln_ctg_category'];
        $inv_title = $row1['inv_title'];
        $inv_interest_rate = $row1['inv_interest_rate'];
        $rpy_mth_method = $row1['rpy_mth_method'];
        $inv_duration = $row1['inv_duration'];
        $inv_start = $row1['inv_start'];
        $inv_end = $row1['inv_end'];

        $subject = $email_subject_receive;
        $content = str_replace("[{CATEGORY}]", $ln_ctg_category, $email_content_receive);
        $content = str_replace("[{TITLE}]", $inv_title, $content);
        $content = str_replace("[{RATE}]", strval($inv_interest_rate), $content);
        $content = str_replace("[{METHOD}]", $rpy_mth_method, $content);
        $content = str_replace("[{DURATION}]", strval($inv_duration), $content);
        $content = str_replace("[{START}]", $inv_start, $content);
        $content = str_replace("[{END}]", $inv_end, $content);
        $text = str_replace("[{CATEGORY}]", $ln_ctg_category, $sms_text_receive);
        $text = str_replace("[{TITLE}]", $inv_title, $text);
        $text = str_replace("[{RATE}]", strval($inv_interest_rate), $text);
        $text = str_replace("[{METHOD}]", $rpy_mth_method, $text);
        $text = str_replace("[{DURATION}]", strval($inv_duration), $text);
        $text = str_replace("[{START}]", $inv_start, $text);
        $text = str_replace("[{END}]", $inv_end, $text);
 
        mysqli_query($con, "LOCK TABLES investment_accounts_inv_act READ");
        $result2 = mysqli_query($con, "SELECT inv_act_usr_id, inv_act_amount FROM investment_accounts_inv_act WHERE inv_act_app_id = ".strval($inv_app_id));
        mysqli_query($con, "UNLOCK TABLES");
        while ($row2 = mysqli_fetch_array($result2))
        {
          $inv_act_usr_id = $row2['inv_act_usr_id'];
          $inv_act_amount = $row2['inv_act_amount'];

          $content1 = str_replace("[{AMOUNT}]", strval($inv_act_amount), $content);
          $text1 = str_replace("[{AMOUNT}]", strval($inv_act_amount), $text);
          $is_sent = notify_user($nt_receive, $inv_act_usr_id, $subject, $content1, $text1);
          $cnt = sum_email_sms($cnt, $nt_receive, $is_sent);
        }
        mysqli_free_result($result2);
      }
      mysqli_free_result($result1);
    }
    if ($nt_withdraw >= 1)
    {
      $yesterdayStr = $today->sub(new DateInterval('P1D'))->format("Y-m-d");
      mysqli_query($con, "LOCK TABLES account_withdraws_act_wths READ");
      $result1 = mysqli_query($con, "SELECT act_wths_usr_id, act_wths_bnk_number, act_wths_amount, act_wths_fee FROM account_withdraws_act_wths WHERE act_wths_is_done = 1 AND DATE(act_wths_done) = ".sqlstr($yesterdayStr));
      mysqli_query($con, "UNLOCK TABLES");
      while ($row1 = mysqli_fetch_array($result1))
      {
        $act_wths_usr_id = $row1['act_wths_usr_id'];
        $act_wths_bnk_number = $row1['act_wths_bnk_number'];
        $act_wths_amount = $row1['act_wths_amount'];
        $act_wths_fee = $row1['act_wths_fee'];

        $len = strlen($act_wths_bnk_number) - 8;
        $number = substr_replace($act_wths_bnk_number, " **** **** **** ", 4, $len);

        $subject = $email_subject_withdraw;
        $content = str_replace("[{NUMBER}]", $number, $email_content_withdraw);
        $content = str_replace("[{AMOUNT}]", strval($act_wths_amount), $content);
        $content = str_replace("[{FEE}]", strval($act_wths_fee), $content);
        $content = str_replace("[{TOTAL}]", strval($total), $content);
        $text = str_replace("[{NUMBER}]", $number, $email_text_withdraw);
        $text = str_replace("[{AMOUNT}]", strval($act_wths_amount), $text);
        $text = str_replace("[{FEE}]", strval($act_wths_fee), $text);
        $text = str_replace("[{TOTAL}]", strval($total), $text);
 
        $is_sent = notify_user($nt_withdraw, $act_wths_usr_id, $subject, $content, $text);
        $cnt = sum_email_sms($cnt, $nt_withdraw, $is_sent);
      }
      mysqli_free_result($result1);
    }
  }
  mysqli_kill($con, mysqli_thread_id($con));
  mysqli_close($con);
  return true;
}
?>