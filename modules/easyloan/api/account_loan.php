<?php

function loan(){

  include_once 'util_global.php';

  if ($user->uid <= 0)
  {
    echo "{\"result\":0}";
    exit;
  }
  $usr_id = $user->uid;

  $idStr = $_GET["id"];
  $id = str2int($idStr);
  if ($id <= 0)
  {
    echo "{\"result\":0}";
    exit;
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

  $query = "SELECT lns_usr_id, lns_is_done, lns_title, lns_category, lns_amount, lns_interest, lns_interest_rate, lns_repayment_method, lns_duration, lns_start, lns_end, lns_fine_rate, lns_fine_rate_is_single, lns_fine, lns_finished FROM loans_lns WHERE lns_app_id = ".strval($id);
  if (!is_auditor($user) && !is_accountant($user) && !is_manager($user) && !is_administrator($user))
  {
    $query = $query." AND lns_usr_id = ".strval($usr_id);
  }
  mysqli_query($con, "LOCK TABLES loans_lns READ");
  $result = mysqli_query($con, $query);
  mysqli_query($con, "UNLOCK TABLES");
  if ($row = mysqli_fetch_array($result))
  {
    $lns_usr_id = $row['lns_usr_id'];
    $lns_is_done = $row['lns_is_done'];
    $lns_title = $row['lns_title'];
    $lns_category = $row['lns_category'];
    $lns_amount = $row['lns_amount'];
    $lns_interest = $row['lns_interest'];
    $lns_interest_rate = $row['lns_interest_rate'];
    $lns_repayment_method = $row['lns_repayment_method'];
    $lns_duration = $row['lns_duration'];
    $lns_start = $row['lns_start'];
    $lns_end = $row['lns_end'];
    $lns_fine_rate = $row['lns_fine_rate'];
    $lns_fine_rate_is_single = $row['lns_fine_rate_is_single'];
    $lns_fine = $row['lns_fine'];
    $lns_finished = $row['lns_finished'];
    mysqli_free_result($result);

    $json = "{\"id\":".strval($id).",\"user_id\":".jsonstrval($lns_usr_id).",\"is_done\":".jsonstrval($lns_is_done).",\"title\":".jsonstr($lns_title).",\"category\":".jsonstrval($lns_category).",\"amount\":".jsonstrval($lns_amount).",\"interest\":".jsonstrval($lns_interest).",\"rate\":".jsonstrval($lns_interest_rate).",\"method\":".jsonstrval($lns_repayment_method).",\"duration\":".jsonstrval($lns_duration).",\"start\":".jsonstr($lns_start).",\"end\":".jsonstr($lns_end).",\"fine_rate\":".jsonstrval($lns_fine_rate).",\"fine_is_single\":".jsonstrval($lns_fine_rate_is_single).",\"fine\":".jsonstrval($lns_fine).",\"finished\":".jsonstr($lns_finished);

    if ($lns_is_done != 1)
    {
      $query = "SELECT act_ln_w_amount, act_ln_w_interest FROM account_loan_act_ln WHERE act_ln_usr_id = ".strval($lns_usr_id);
      mysqli_query($con, "LOCK TABLES account_loan_act_ln READ");
      $result = mysqli_query($con, $query);
      mysqli_query($con, "UNLOCK TABLES");
      if ($row = mysqli_fetch_array($result))
      {
        $act_ln_w_amount = $row['act_ln_w_amount'];
        $act_ln_w_interest = $row['act_ln_w_interest'];
        mysqli_free_result($result);

        $json = $json.",\"w_amount\":".jsonstrval($act_ln_w_amount).",\"w_interest\":".jsonstrval($act_ln_w_interest);
      }
    }
    
    $json = $json."}";
  }
  else
  {
    $json = "{\"result\":0,\"message\":\"Not found or no privileges\"}";
  }

  mysqli_kill($con, mysqli_thread_id($con));
  mysqli_close($con);
  echo $json;
}
?>