<?php

function manage_withdraws(){

  include_once 'util_global.php';

  if ($user->uid <= 0)
  {
    echo "{\"result\":0}";
    exit;
  }

  if (!is_accountant($user) && !is_administrator($user))
  {
    echo "{\"result\":0, \"message\":\"No priviledge\"}";
    exit;
  }

  $type = str2int($_GET['type']);

  $page = str2int($_GET['page']);
  if ($page <= 0)
  {
    $page = 1;
  }
  else if ($page > $max_pages)
  {
    $page = $max_pages;
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
  mysqli_query($con, "LOCK TABLES account_withdraws_act_wths READ, account_banks_act_bnk READ, account_money_act_mny READ, account_info_act_info READ");
  $total = 0;
  if ($page == 1)
  {
    $query = "SELECT COUNT(act_wths_usr_id) AS cnt FROM account_withdraws_act_wths WHERE act_wths_is_done IS ";
    switch ($type)
    {
      case 2: // done
        $query = $query."NOT NULL";
        break;
      default: // doing
        $query = $query."NULL";
        break;
    }
    $result = mysqli_query($con, $query);
    if ($row = mysqli_fetch_array($result))
    {
      $total = $row['cnt'];
      mysqli_free_result($result);
    }
  }
  $start = ($page - 1) * $per_page;
  $query = "SELECT act_wths_usr_id, act_info_name, act_mny_is_owned, act_wths_amount, act_wths_fee, act_wths_time, act_wths_bnk_number, act_wths_is_done, act_wths_done FROM account_withdraws_act_wths LEFT JOIN account_info_act_info ON act_wths_usr_id = act_info_usr_id LEFT JOIN account_money_act_mny ON act_wths_usr_id = act_mny_usr_id WHERE act_wths_is_done IS ";
  switch ($type)
  {
    case 2: // done
      $query = $query."NOT NULL ORDER BY act_wths_time DESC";
      break;
    default: // doing
      $query = $query."NULL ORDER BY act_wths_time ASC";
      break;
  }
  $query = $query." LIMIT ".strval($start).",".strval($per_page);
  $result = mysqli_query($con, $query);
  while ($row = mysqli_fetch_array($result))
  {
    $act_wths_usr_id = $row['act_wths_usr_id'];
    $act_info_name = $row['act_info_name'];
    $act_mny_is_owned = $row['act_mny_is_owned'];
    $act_wths_amount = $row['act_wths_amount'];
    $act_wths_fee = $row['act_wths_fee'];
    $act_wths_time = $row['act_wths_time'];
    $act_wths_bnk_number = $row['act_wths_bnk_number'];
    $act_wths_is_done = $row['act_wths_is_done'];
    $act_wths_done = $row['act_wths_done'];

    $query = "SELECT act_bnk_bank, act_bnk_branch, act_bnk_address FROM account_banks_act_bnk WHERE act_bnk_usr_id = ".strval($act_wths_usr_id)." AND act_bnk_number = ".sqlstr($act_wths_bnk_number);
    $result1 = mysqli_query($con, $query);
    if ($row1 = mysqli_fetch_array($result1))
    {
      $act_bnk_bank = $row1['act_bnk_bank'];
      $act_bnk_branch = $row1['act_bnk_branch'];
      $act_bnk_address = $row1['act_bnk_address'];

      mysqli_free_result($result1);

      $json = $json.",{\"user_id\":".jsonstrval($act_wths_usr_id).",\"name\":".jsonstr($act_info_name).",\"is_owned\":".jsonstrval($act_mny_is_owned).",\"amount\":".jsonstrval($act_wths_amount).",\"fee\":".jsonstrval($act_wths_fee).",\"bank\":".jsonstrval($act_bnk_bank).",\"branch\":".jsonstr($act_bnk_branch).",\"number\":".jsonstr($act_wths_bnk_number).",\"address\":".jsonstr($act_bnk_address).",\"time\":".jsonstr($act_wths_time).",\"is_done\":".jsonstrval($act_wths_is_done).",\"done\":".jsonstr($act_wths_done)."}";
    }
  }
  mysqli_free_result($result);
  mysqli_query($con, "UNLOCK TABLES");

  mysqli_kill($con, mysqli_thread_id($con));
  mysqli_close($con);

  $json = substr($json, 1);
  $json = "{\"total\":".$total.",\"withdraws\":[".$json."]}";
  echo $json;
}
?>