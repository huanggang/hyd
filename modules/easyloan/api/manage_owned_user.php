<?php
function manage_owned_user(){

  include_once 'util_global.php';

  if ($user->uid <= 0)
  {
    echo "{\"result\":0}";
    exit;
  }

  if (!is_accountant($user) && !is_administrator($user))
  {
    echo "{\"result\":0}";
    exit;
  }

  $id = str2int($_GET['id']);
  if ($id <= 0)
  {
    echo "{\"result\":0}";
    exit;
  }
  $start = str2date($_GET['start']);
  if ($start == null)
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
  $total = 0;
  mysqli_query($con, "LOCK TABLES account_transactions_act_trn READ");
  $query = "SELECT act_trn_time, act_trn_type, act_trn_amount, act_trn_available, act_trn_owned, act_trn_fine, act_trn_note FROM account_transactions_act_trn WHERE act_trn_usr_id = ".strval($id)." AND act_trn_time >= '".$start->format('Y-m-d')."' ORDER BY act_trn_time ASC";
  $result = mysqli_query($con, $query);
  mysqli_query($con, "UNLOCK TABLES");
  while ($row = mysqli_fetch_array($result))
  {
    $act_trn_time = $row['act_trn_time'];
    $act_trn_type = $row['act_trn_type'];
    $act_trn_amount = $row['act_trn_amount'];
    $act_trn_available = $row['act_trn_available'];
    $act_trn_owned = $row['act_trn_owned'];
    $act_trn_fine = $row['act_trn_fine'];
    $act_trn_note = $row['act_trn_note'];

    $json = $json.",{\"time\":".jsonstr($act_trn_time).",\"type\":".jsonstrval($act_trn_type).",\"amount\":".jsonstrval($act_trn_amount).",\"available\":".jsonstrval($act_trn_available).",\"owned\":".jsonstrval($act_trn_owned).",\"fine\":".jsonstrval($act_trn_fine).",\"note\":".jsonstr($act_trn_note)."}";
    $total += 1;
  }
  mysqli_free_result($result);

  mysqli_kill($con, mysqli_thread_id($con));
  mysqli_close($con);

  $json = substr($json, 1);
  $json = "{\"total\":".jsonstrval($total).",\"transcations\":[".$json."]}";

  echo $json;
}
?>