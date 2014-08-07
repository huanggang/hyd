<?php

include_once 'util_global.php';

function initialize_user($id)
{
  global $db_host, $db_user, $db_pwd, $db_name;
  $con=mysqli_connect($db_host, $db_user, $db_pwd, $db_name);
  if (mysqli_connect_errno())
  {
    return false;
  }
  mysqli_set_charset($con, "UTF8");

  $now = new DateTime;
  $nowStr = $now->format("Y-m-d\TH:i:sP");

  mysqli_autocommit($con, false);
  mysqli_query($con, "LOCK TABLES account_saving_act_sv WRITE, account_withdraw_act_wth WRITE, account_investment_act_inv WRITE, account_loan_act_ln WRITE, account_money_act_mny WRITE");

  $flag = mysqli_query($con, "INSERT IGNORE INTO account_saving_act_sv (act_sv_usr_id, act_sv_amount, act_sv_fee, act_sv_times, act_sv_updated) VALUES (".strval($id).", 0, 0, 0, '".$nowStr."')") != false;
  $flag = $flag && (mysqli_query($con, "INSERT IGNORE INTO account_withdraw_act_wth (act_wth_usr_id, act_wth_amount, act_wth_fee, act_wth_times, act_wth_updated) VALUES (".strval($id).", 0, 0, 0, '".$nowStr."')") != false);
  $flag = $flag && (mysqli_query($con, "INSERT IGNORE INTO account_investment_act_inv (act_inv_usr_id, act_inv_amount, act_inv_interest, act_inv_fine, act_inv_interest_rate, act_inv_duration, act_inv_total, act_inv_holdings, act_inv_updated) VALUES (".strval($id).",0,0,0,0,0,0,0,'".$nowStr."')") != false);
  $flag = $flag && (mysqli_query($con, "INSERT IGNORE INTO account_loan_act_ln (act_ln_usr_id, act_ln_amount, act_ln_interest, act_ln_fine, act_ln_interest_rate, act_ln_duration, act_ln_loans, act_ln_app_id, act_ln_total, act_ln_count, act_ln_r_amount, act_ln_r_interest, act_ln_w_amount, act_ln_w_interest, act_ln_n_date, act_ln_n_amount, act_ln_n_interest, act_ln_w_owned, act_ln_w_fine, act_ln_updated) VALUES (".strval($id).", 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, '".$nowStr."')") != false);
  $flag = $flag && (mysqli_query($con, "INSERT IGNORE INTO account_money_act_mny (act_mny_usr_id, act_mny_available, act_mny_frozen, act_mny_investment, act_mny_loaned, act_mny_interest, act_mny_is_owned, act_mny_owned, act_mny_fine, act_mny_total, act_mny_updated) VALUES (".strval($id).", 0, 0, 0, 0, 0, 0, 0, 0, 0, '".$nowStr."')") != false);

  if ($flag)
  {
    mysqli_commit($con);
  }
  else
  {
    mysqli_rollback($con);
  }

  mysqli_query($con, "UNLOCK TABLES");
  mysqli_kill($con, mysqli_thread_id($con));
  mysqli_close($con);

  return $flag;
}
?>