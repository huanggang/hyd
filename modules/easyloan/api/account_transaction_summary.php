<?php
function transaction_summary(){

  include_once 'util_global.php';

  if ($user->uid <= 0)
  {
    echo "{\"result\":0}";
    exit;
  }

  $idStr = $_GET["id"];
  $id = str2int($idStr);
  if ($id <= 0)
  {
    $id = $user->uid; // check the transactions of the login user
  }
  else
  {
    // check if the user is an accountant
    if (!is_accountant($user) && !is_administrator($user)) 
    {
      $id = $user->uid;
    }
  }

  $con=mysqli_connect($db_host, $db_user, $db_pwd, $db_name);
  // Check connection
  if (mysqli_connect_errno())
  {
    echo "{\"result\":0}";
    exit;
  }
  mysqli_set_charset($con, "UTF8");

  $query = "SELECT act_mny_available, act_mny_frozen, act_sv_amount, act_sv_fee, act_sv_times, act_wth_amount, act_wth_fee, act_wth_times FROM account_money_act_mny LEFT JOIN account_saving_act_sv ON act_mny_usr_id = act_sv_usr_id LEFT JOIN account_withdraw_act_wth ON act_mny_usr_id = act_wth_usr_id WHERE act_mny_usr_id = ".strval($id);
  mysqli_query($con, "LOCK TABLES account_money_act_mny READ, account_saving_act_sv READ, account_withdraw_act_wth READ");
  $result = mysqli_query($con, $query);
  mysqli_query($con, "UNLOCK TABLES");
  if ($row = mysqli_fetch_array($result))
  {
    $act_mny_available = $row['act_mny_available'];
    $act_mny_frozen = $row['act_mny_frozen'];
    $act_sv_amount = $row['act_sv_amount'];
    $act_sv_fee = $row['act_sv_fee'];
    $act_sv_times = $row['act_sv_times'];
    $act_wth_amount = $row['act_wth_amount'];
    $act_wth_fee = $row['act_wth_fee'];
    $act_wth_times = $row['act_wth_times'];
    mysqli_free_result($result);
  }

  mysqli_kill($con, mysqli_thread_id($con));
  mysqli_close($con);
  $summary = "{\"result\":1,\"available\":".jsonstrval($act_mny_available).",\"frozen\":".jsonstrval($act_mny_frozen).",\"sv_amount\":".jsonstrval($act_sv_amount).",\"sv_fee\":".jsonstrval($act_sv_fee).",\"sv_times\":".jsonstrval($act_sv_times).",\"wth_amount\":".jsonstrval($act_wth_amount).",\"wth_fee\":".jsonstrval($act_wth_fee).",\"wth_times\":".jsonstrval($act_wth_times)."}";
  echo $summary;
}
?>