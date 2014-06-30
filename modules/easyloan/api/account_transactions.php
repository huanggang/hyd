<?php
function transactions(){

  include_once 'util_global.php';

  $todayStr = date("Y-m-d");
  $today = new DateTime($todayStr);// date_create_from_format('Y-m-d', $todayStr);

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
  $typeStr = $_GET["type"];
  $type = str2int($typeStr);
  $rangeStr = $_GET["range"];
  $range = str2int($rangeStr);
  $pageStr = $_GET["page"];
  $page = str2int($pageStr);
  if ($page <= 0)
  {
    $page = 1;
  }
  else if ($page > $max_pages)
  {
    $page = $max_pages;
  }

  $limit = " ORDER BY act_trn_time DESC LIMIT ";
  $start = ($page - 1) * $per_page;
  $limit = $limit.strval($start).",".strval($per_page);

  $condition = "";
  if ($type >= 1 && $type <= 10)
  {
    $condition = $condition." AND act_trn_type = ".strval($type);
  }
  switch ($range)
  {
    case 1:
      $date = $today->sub(new DateInterval("P3D"));
      $condition = $condition." AND act_trn_time >= '".$date->format("Y-m-d")."'";
      break;
    case 2:
      $date = $today->sub(new DateInterval("P7D"));
      $condition = $condition." AND act_trn_time >= '".$date->format("Y-m-d")."'";
      break;
    case 3:
      $date = $today->sub(new DateInterval("P1M"));
      $condition = $condition." AND act_trn_time >= '".$date->format("Y-m-d")."'";
      break;
    case 4:
      $date = $today->sub(new DateInterval("P3M"));
      $condition = $condition." AND act_trn_time >= '".$date->format("Y-m-d")."'";
      break;
    case 5:
      $date = $today->sub(new DateInterval("P1Y"));
      $condition = $condition." AND act_trn_time >= '".$date->format("Y-m-d")."'";
      break;
  }
  $total = 0;

  $con=mysqli_connect($db_host, $db_user, $db_pwd, $db_name);
  // Check connection
  if (mysqli_connect_errno())
  {
    echo "{\"result\":0}";
    exit;
  }
  mysqli_set_charset($con, "UTF8");

  if ($page == 1)
  {
    $query = "SELECT COUNT(act_trn_time) AS total FROM account_transactions_act_trn WHERE act_trn_usr_id = ".strval($id).$condition;
    mysqli_query($con, "LOCK TABLES account_transactions_act_trn READ");
    $result = mysqli_query($con, $query);
    mysqli_query($con, "UNLOCK TABLES");
    if ($row = mysqli_fetch_array($result))
    {
      $total = $row['total'];
      mysqli_free_result($result);
    }
  }

  $transactions = "";
  $query = "SELECT act_trn_time, act_trn_type, act_trn_amount, act_trn_available, act_trn_owned, act_trn_fine, act_trn_note FROM account_transactions_act_trn WHERE act_trn_usr_id = ".strval($id).$condition.$limit;
  mysqli_query($con, "LOCK TABLES account_transactions_act_trn READ");
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

    $transactions = $transactions.",{\"time\":".jsonstr($act_trn_time).",\"type\":".jsonstrval($act_trn_type).",\"amount\":".jsonstrval($act_trn_amount).",\"available\":".jsonstrval($act_trn_available).",\"owned\":".jsonstrval($act_trn_owned).",\"fine\":".jsonstrval($act_trn_fine).",\"note\":".jsonstr($act_trn_note)."}";
  }
  mysqli_free_result($result);

  mysqli_kill($con, mysqli_thread_id($con));
  mysqli_close($con);
  $transactions = substr($transactions, 1);
  $list = "{\"result\":1,\"total\":".jsonstrval($total).",\"transactions\":[".$transactions."]}";
  echo $list;
}
?>