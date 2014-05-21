<?php

include_once 'util_global.php';

function notify_user($type, $id, $subject, $content, $text)
{
  $is_sent = 0;
  if ($type > 0)
  {
    global $sms_url, $sms_residure_url, $sms_user, $sms_password, $email_name, $email_account;
    global $db_host, $db_user, $db_pwd, $db_name;
    $con=mysqli_connect($db_host, $db_user, $db_pwd, $db_name);
    if (mysqli_connect_errno())
    {
      return false;
    }
    mysqli_set_charset($con, "UTF8");

    mysqli_query($con, "LOCK TABLES account_info_act_info READ");
    $result = mysqli_query($con, "SELECT act_info_name, act_info_ssn, act_info_ssn_status, act_info_mobile, act_info_mobile_status, act_info_email, act_info_email_status, act_info_gender FROM account_info_act_info WHERE act_info_usr_id = ".strval($id));
    mysqli_query($con, "UNLOCK TABLES");
    mysqli_kill($con, mysqli_thread_id($con));
    mysqli_close($con);
    if ($row = mysqli_fetch_array($result))
    {
      $act_info_name = $row['act_info_name'];
      $act_info_ssn = $row['act_info_ssn'];
      $act_info_ssn_status = $row['act_info_ssn_status'];
      $act_info_mobile = $row['act_info_mobile'];
      $act_info_mobile_status = $row['act_info_mobile_status'];
      $act_info_email = $row['act_info_email'];
      $act_info_email_status = $row['act_info_email_status'];
      $act_info_gender = $row['act_info_gender'];
      mysqli_free_result($result);

      if ($act_info_ssn_status == 1)
      {
        $act_info_ssn = substr_replace($act_info_ssn, " **** **** **** ", 2, 12);
        if (($type == 1 || $type == 3) && $act_info_email_status == 1 && !is_null($act_info_email) && !is_null($subject) && !is_null($content))
        {
          $subject = str_replace("[{NAME}]", $act_info_name, $subject);
          $subject = str_replace("[{SSN}]", $act_info_ssn, $subject);
          $content = str_replace("[{NAME}]", $act_info_name, $content);
          $content = str_replace("[{SSN}]", $act_info_ssn, $content);
          if ($act_info_gender == 1)
          {
            $subject = str_replace("[{GENDER}]", "先生", $subject);
            $content = str_replace("[{GENDER}]", "先生", $content);
          }
          else if ($act_info_gender == 0)
          {
            $subject = str_replace("[{GENDER}]", "女士", $subject);
            $content = str_replace("[{GENDER}]", "女士", $content);
          }
          else
          {
            $subject = str_replace("[{GENDER}]", "", $subject);
            $content = str_replace("[{GENDER}]", "", $content);
          }
          $output = mail_utf8($act_info_email, $email_name, $email_account, $subject, $content);
          if ($output)
          {
            $is_sent += 1;
          }
        }
        if (($type == 2 || $type == 3) && $act_info_mobile_status == 1 && !is_null($act_info_mobile) && !is_null($text))
        {
          $text = str_replace("[{NAME}]", $act_info_name, $text);
          $text = str_replace("[{SSN}]", $act_info_ssn, $text);
          if ($act_info_gender == 1)
          {
            $text = str_replace("[{GENDER}]", "先生", $text);
          }
          else if ($act_info_gender == 0)
          {
            $text = str_replace("[{GENDER}]", "女士", $text);
          }
          else
          {
            $text = str_replace("[{GENDER}]", "", $text);
          }
          $url = str_replace("[{USER}]", $sms_user, $sms_url);
          $url = str_replace("[{PASSWORD}]", $sms_password, $url);
          $url = str_replace("[{MOBILE}]", $act_info_mobile, $url);

          $ch = curl_init();
          
          $content = curl_escape($ch, $text);
          $url = str_replace("[{CONTENT}]", $content, $url);

          curl_setopt($ch, CURLOPT_URL, $url);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
          $output = curl_exec($ch);
          curl_close($ch);
          if (strpos($output, "OK") !== false)
          {
            $is_sent += 2;
          }
        }
      }
    }
  }
  return $is_sent;
}
?>