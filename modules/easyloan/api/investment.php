<?php

function investment(){

  include_once 'util_global.php';

  $todayStr = date("Y-m-d");
  $today = new DateTime($todayStr);// date_create_from_format('Y-m-d', $todayStr);

  $idStr = $_GET["id"];
  $id = str2int($idStr, 0);
  if ($id <= 0)
  {
    echo "{\"result\":0}";
    exit;
  }

  $is_super_user = false;
  if ($user->uid > 0)
  {
    $is_super_user = is_manager($user) || is_administrator($user);
  }

  $con=mysqli_connect($db_host, $db_user, $db_pwd, $db_name);
  // Check connection
  if (mysqli_connect_errno())
  {
    echo "{\"result\":0}";
    exit;
  }
  mysqli_set_charset($con, "UTF8");

  $investment = "{\"id\":".jsonstrval($id);

  // get investment
  $query = "SELECT inv_title, inv_category, inv_usr_id, inv_interest_rate, inv_repayment_method, inv_amount, inv_duration, inv_is_done, inv_created, inv_start, inv_end, inv_minimum, inv_step, inv_fine_rate, inv_fine_rate_is_single, inv_investment, inv_finished, inv_fine, inv_purpose, inv_asset_description, inv_has_certificate FROM investments_inv WHERE inv_app_id = ".strval($id);
  mysqli_query($con, "LOCK TABLES investments_inv READ");
  $result = mysqli_query($con, $query);
  mysqli_query($con, "UNLOCK TABLES");
  if ($row = mysqli_fetch_array($result))
  {
    $inv_title = $row['inv_title'];
    $inv_category = $row['inv_category'];
    $inv_usr_id = $row['inv_usr_id'];
    $inv_interest_rate = $row['inv_interest_rate'];
    $inv_repayment_method = $row['inv_repayment_method'];
    $inv_amount = $row['inv_amount'];
    $inv_duration = $row['inv_duration'];
    $inv_is_done = $row['inv_is_done'];
    $inv_created = $row['inv_created'];
    $inv_start = $row['inv_start'];
    $inv_end = $row['inv_end'];
    $inv_minimum = $row['inv_minimum'];
    $inv_step = $row['inv_step'];
    $inv_fine_rate = $row['inv_fine_rate'];
    $inv_fine_rate_is_single = $row['inv_fine_rate_is_single'];
    $inv_investment = $row['inv_investment'];
    $inv_finished = $row['inv_finished'];
    $inv_fine = $row['inv_fine'];
    $inv_purpose = $row['inv_purpose'];
    $inv_asset_description = $row['inv_asset_description'];
    $inv_has_certificate = $row['inv_has_certificate'];
    mysqli_free_result($result);

    // get user info
    $query = "SELECT act_info_usr_id, act_info_name, act_info_nick, act_info_gender, act_info_dob, act_info_edu, act_info_marital, act_info_province, act_info_city FROM account_info_act_info WHERE act_info_usr_id = ".strval($inv_usr_id);
    mysqli_query($con, "LOCK TABLES account_info_act_info READ");
    $result = mysqli_query($con, $query);
    mysqli_query($con, "UNLOCK TABLES");
    $row = mysqli_fetch_array($result);
    $act_info_usr_id = $row['act_info_usr_id'];
    $act_info_name = $row['act_info_name'];
    $act_info_nick = $row['act_info_nick'];
    $act_info_gender = $row['act_info_gender'];
    $act_info_dob = $row['act_info_dob'];
    $act_info_edu = $row['act_info_edu'];
    $act_info_marital = $row['act_info_marital'];
    $act_info_province = $row['act_info_province'];
    $act_info_city = $row['act_info_city'];
    mysqli_free_result($result);

    $age = compute_date_diff(str2date($act_info_dob), $today)->y;

    $investment = $investment.",\"title\":".jsonstr($inv_title).",\"category\":".jsonstrval($inv_category);
    if ($is_super_user){
      $investment = $investment.",\"user_id\":".jsonstrval($act_info_usr_id).",\"name\":".jsonstr($act_info_name);
    }
    $investment = $investment.",\"nick\":".jsonstr($act_info_nick).",\"rate\":".jsonstrval($inv_interest_rate).",\"repayment_method\":".jsonstrval($inv_repayment_method).",\"amount\":".jsonstrval($inv_amount).",\"duration\":".jsonstrval($inv_duration).",\"is_done\":".jsonstrval($inv_is_done).",\"created\":".jsonstr($inv_created).",\"start\":".jsonstr($inv_start).",\"end\":".jsonstr($inv_end).",\"minimum\":".jsonstrval($inv_minimum).",\"step\":".jsonstrval($inv_step).",\"fine_rate\":".jsonstrval($inv_fine_rate).",\"fine_is_single\":".jsonstrval($inv_fine_rate_is_single).",\"investment\":".jsonstrval($inv_investment).",\"finished\":".jsonstr($inv_finished).",\"fine\":".jsonstrval($inv_fine).",\"purpose\":".jsonstr($inv_purpose).",\"description\":".jsonstr($inv_asset_description).",\"has_certificate\":".jsonstrval($inv_has_certificate).",\"gender\":".jsonstrval($act_info_gender).",\"age\":".jsonstrval($age).",\"education\":".jsonstrval($act_info_edu).",\"marital\":".jsonstrval($act_info_marital).",\"province\":".jsonstrval($act_info_province).",\"city\":".jsonstrval($act_info_city);

    // get hyd loans 
    $query = "SELECT hyd_ln_total, hyd_ln_count, hyd_ln_r_amount, hyd_ln_r_interest, hyd_ln_w_amount, hyd_ln_w_interest, hyd_ln_n_date, hyd_ln_n_amount, hyd_ln_n_interest, hyd_ln_w_owned, hyd_ln_w_fine FROM hyd_loans_hyd_ln WHERE hyd_ln_app_id = ".strval($id);
    mysqli_query($con, "LOCK TABLES hyd_loans_hyd_ln READ");
    $result = mysqli_query($con, $query);
    mysqli_query($con, "UNLOCK TABLES");
    if ($row = mysqli_fetch_array($result))
    {
      $hyd_ln_total = $row['hyd_ln_total'];
      $hyd_ln_count = $row['hyd_ln_count'];
      $hyd_ln_r_amount = $row['hyd_ln_r_amount'];
      $hyd_ln_r_interest = $row['hyd_ln_r_interest'];
      $hyd_ln_w_amount = $row['hyd_ln_w_amount'];
      $hyd_ln_w_interest = $row['hyd_ln_w_interest'];
      $hyd_ln_n_date = $row['hyd_ln_n_date'];
      $hyd_ln_n_amount = $row['hyd_ln_n_amount'];
      $hyd_ln_n_interest = $row['hyd_ln_n_interest'];
      $hyd_ln_w_owned = $row['hyd_ln_w_owned'];
      $hyd_ln_w_fine = $row['hyd_ln_w_fine'];

      $investment = $investment.",\"total\":".jsonstrval($hyd_ln_total).",\"count\":".jsonstrval($hyd_ln_count).",\"r_amount\":".jsonstrval($hyd_ln_r_amount).",\"r_interest\":".jsonstrval($hyd_ln_r_interest).",\"w_amount\":".jsonstrval($hyd_ln_w_amount).",\"w_interest\":".jsonstrval($hyd_ln_w_interest).",\"n_date\":".jsonstr($hyd_ln_n_date).",\"n_amount\":".jsonstrval($hyd_ln_n_amount).",\"n_interest\":".jsonstrval($hyd_ln_n_interest).",\"w_owned\":".jsonstrval($hyd_ln_w_owned).",\"w_fine\":".jsonstrval($hyd_ln_w_fine);
    }

    // for login-user
    if ($user->uid > 0)
    {
      //user is logged in
      $query = "SELECT act_mny_available FROM account_money_act_mny WHERE act_mny_usr_id = ".strval($user->uid);
      mysqli_query($con, "LOCK TABLES account_money_act_mny READ");
      $result = mysqli_query($con, $query);
      mysqli_query($con, "UNLOCK TABLES");
      $row = mysqli_fetch_array($result);
      $act_mny_available = $row['act_mny_available'];
      mysqli_free_result($result);

      $investment = $investment.",\"available\":".jsonstrval($act_mny_available);

      // get list of investors
      $investors = "";
      $query = "SELECT inv_act_time, inv_act_amount, act_info_nick, act_info_usr_id, act_info_name FROM investment_accounts_inv_act LEFT JOIN account_info_act_info ON inv_act_usr_id = act_info_usr_id WHERE inv_act_app_id = ".strval($id);
      mysqli_query($con, "LOCK TABLES investment_accounts_inv_act READ");
      $result = mysqli_query($con, $query);
      mysqli_query($con, "UNLOCK TABLES");
      while ($row = mysqli_fetch_array($result))
      {
        $inv_act_time = $row['inv_act_time'];
        $inv_act_amount = $row['inv_act_amount'];
        $inv_act_info_nick = $row['act_info_nick'];
        $act_info_usr_id = $row['act_info_usr_id'];
        $act_info_name = $row['act_info_name'];
        $nick = is_null($inv_act_info_nick) ? "null" : $inv_act_info_nick;
        $investors = $investors.",{\"nick\":".jsonstr($nick).",\"amount\":".jsonstrval($inv_act_amount).",\"time\":".jsonstr($inv_act_time);
        if ($is_super_user){
          $investors = $investors.",\"user_id\":".jsonstrval($act_info_usr_id).",\"name\":".jsonstr($act_info_name);
        }
        $investors = $investors."}";
      }
      mysqli_free_result($result);
      $investors = substr($investors, 1);
      $investment = $investment.",\"investments\":[".$investors."]";
    }
  }
  else
  {
    $investment = $investment.",\"result\":0,\"message\":\"Not found\"";
  }
  mysqli_kill($con, mysqli_thread_id($con));
  mysqli_close($con);
    
  $investment = $investment."}";
  echo $investment;
}
?>