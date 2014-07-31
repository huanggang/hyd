<?php

function account_banks(){

  include_once 'util_global.php';

  if ($user->uid <= 0)
  {
    echo "{\"result\":0}";
    exit;
  }
  $usr_id = $user->uid;

  $method = $_SERVER['REQUEST_METHOD'];
  if ($method == 'POST')
  {
    $type = str2int($_POST['type']);
    if ($type < 1 || $type > 3)
    {
      echo "{\"result\":0}";
      exit;
    }
    $number = $_POST['number'];
    if (!is_valid_bank_card_number($number))
    {
      echo "{\"result\":0}";
      exit;
    }
    $bank = str2int($_POST['bank']);
    if ($type != 3 && $bank <= 0)
    {
      echo "{\"result\":0}";
      exit;
    }
    $branch = $_POST['branch'];
    $address = $_POST['address'];

    $now = new DateTime;
    $nowStr = $now->format("Y-m-d\TH:i:sP");

    $con=mysqli_connect($db_host, $db_user, $db_pwd, $db_name);
    // Check connection
    if (mysqli_connect_errno())
    {
      echo "{\"result\":0}";
      exit;
    }
    mysqli_set_charset($con, "UTF8");

    $flag = false;
    switch ($type)
    {
      case 1:
        $query = "INSERT INTO account_banks_act_bnk (act_bnk_usr_id, act_bnk_number, act_bnk_bank, act_bnk_branch, act_bnk_address, act_bnk_added, act_bnk_updated) VALUES (?,?,?,?,?,?,?) ON DUPLICATE KEY UPDATE act_bnk_deleted = 0, act_bnk_bank=?, act_bnk_branch=?, act_bnk_address=?,act_bnk_updated=?";
        if ($stmt = mysqli_prepare($con, $query))
        {
          mysqli_stmt_bind_param($stmt, "isissssisss", $usr_id, $number, $bank, $branch, $address, $nowStr, $nowStr, $bank, $branch, $address, $nowStr);

          mysqli_query($con, "LOCK TABLES account_banks_act_bnk WRITE");
          $flag = mysqli_stmt_execute($stmt) != false;
          mysqli_query($con, "UNLOCK TABLES");
          mysqli_stmt_close($stmt);
        }
        break;
      case 2:
        $query = "UPDATE account_banks_act_bnk SET act_bnk_bank=?, act_bnk_branch=?, act_bnk_address=?, act_bnk_updated=? WHERE act_bnk_usr_id=? AND act_bnk_number=?";
        if ($stmt = mysqli_prepare($con, $query))
        {
          mysqli_stmt_bind_param($stmt, "isssis", $bank, $branch, $address, $nowStr, $usr_id, $number);

          mysqli_query($con, "LOCK TABLES account_banks_act_bnk WRITE");
          $flag = mysqli_stmt_execute($stmt) != false;
          mysqli_query($con, "UNLOCK TABLES");
          mysqli_stmt_close($stmt);
        }
        break;
      case 3:
        $query = "UPDATE account_banks_act_bnk SET act_bnk_deleted = 1 WHERE act_bnk_usr_id=? AND act_bnk_number=?";
        if ($stmt = mysqli_prepare($con, $query))
        {
          mysqli_stmt_bind_param($stmt, "is", $usr_id, $number);

          mysqli_query($con, "LOCK TABLES account_banks_act_bnk WRITE");
          $flag = mysqli_stmt_execute($stmt) != false;
          mysqli_query($con, "UNLOCK TABLES");
          mysqli_stmt_close($stmt);
        }
        break;
    }

    mysqli_kill($con, mysqli_thread_id($con));
    mysqli_close($con);

    if ($flag)
    {
      echo "{\"result\":1}";
    }
    else
    {
      echo "{\"result\":0\"message\":\"DB write failure\"}";
    }
  }
  else // default GET
  {
    $con=mysqli_connect($db_host, $db_user, $db_pwd, $db_name);
    // Check connection
    if (mysqli_connect_errno())
    {
      echo "{\"result\":0}";
      exit;
    }
    mysqli_set_charset($con, "UTF8");

    mysqli_query($con, "LOCK TABLES account_banks_act_bnk READ");

    $total = 0;
    $query = "SELECT COUNT(act_bnk_number) AS cnt FROM account_banks_act_bnk WHERE act_bnk_usr_id = ".strval($usr_id)." AND act_bnk_deleted <> 1";
    $result = mysqli_query($con, $query);
    if ($row = mysqli_fetch_array($result))
    {
      $total = $row['cnt'];
      mysqli_free_result($result);
    }

    $json = "";

    $query = "SELECT act_bnk_number, act_bnk_bank, act_bnk_branch, act_bnk_address FROM account_banks_act_bnk WHERE act_bnk_usr_id = ".strval($usr_id)." AND act_bnk_deleted <> 1";
    $result = mysqli_query($con, $query);
    mysqli_query($con, "UNLOCK TABLES");
    while ($row = mysqli_fetch_array($result))
    {
      $act_bnk_number = $row['act_bnk_number'];
      $act_bnk_bank = $row['act_bnk_bank'];
      $act_bnk_branch = $row['act_bnk_branch'];
      $act_bnk_address = $row['act_bnk_address'];

      $json = $json.",{\"number\":".jsonstr($act_bnk_number).",\"bank\":".jsonstrval($act_bnk_bank).",\"branch\":".jsonstr($act_bnk_branch).",\"address\":".jsonstr($act_bnk_address)."}";
    }
    mysqli_free_result($result);

    mysqli_kill($con, mysqli_thread_id($con));
    mysqli_close($con);

    $json = substr($json, 1);
    $json = "{\"total\":".$total.",\"numbers\":[".$json."]}";

    echo $json;
  }
}
?>