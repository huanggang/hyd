<?php

include_once 'util_global.php';

if ($user->uid <= 0)
{
  echo "{\"result\":0}";
  exit;
}
$usr_id = $user->uid;

$typeStr = $_GET["type"];
$type = str2int($typeStr);

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

$con=mysqli_connect($db_host, $db_user, $db_pwd, $db_name);
// Check connection
if (mysqli_connect_errno())
{
  echo "{\"result\":0}";
  exit;
}
mysqli_set_charset($con, "UTF8");

$json = "";
switch ($type)
{
  case 2: // holding
    $total = 0;
    if ($page == 1)
    {
      $query = "SELECT COUNT(act_invs_app_id) AS total FROM account_investments_act_invs WHERE act_invs_usr_id = ".strval($usr_id)." AND act_invs_is_done <> 1";
      mysqli_query($con, "LOCK TABLES account_investments_act_invs READ");
      $result = mysqli_query($con, $query);
      mysqli_query($con, "UNLOCK TABLES");
      if ($row = mysqli_fetch_array($result))
      {
        $total = $row['total'];
        mysqli_free_result($result);
      }
    }
    $start = ($page - 1) * $per_page;
    $query = "SELECT act_invs_app_id, act_invs_is_done, inv_title, inv_category, act_invs_amount, act_invs_r_amount, act_invs_r_interest, act_invs_w_amount, act_invs_w_interest, act_invs_a_amount, act_invs_a_interest, act_invs_r_fine, act_invs_rate, inv_repayment_method, inv_duration, inv_start, inv_end, inv_finished FROM account_investments_act_invs LEFT JOIN investments_inv ON act_invs_app_id = inv_app_id WHERE act_invs_usr_id = ".strval($usr_id)." AND act_invs_is_done <> 1 ORDER BY act_invs_time ASC LIMIT ".strval($start).",".strval($per_page);
    mysqli_query($con, "LOCK TABLES account_investments_act_invs READ, investments_inv READ");
    $result = mysqli_query($con, $query);
    mysqli_query($con, "UNLOCK TABLES");
    while ($row = mysqli_fetch_array($result))
    {
      $act_invs_app_id = $row['act_invs_app_id'];
      $act_invs_is_done = $row['act_invs_is_done'];
      $inv_title = $row['inv_title'];
      $inv_category = $row['inv_category'];
      $act_invs_amount = $row['act_invs_amount'];
      $act_invs_r_amount = $row['act_invs_r_amount'];
      $act_invs_r_interest = $row['act_invs_r_interest'];
      $act_invs_w_amount = $row['act_invs_w_amount'];
      $act_invs_w_interest = $row['act_invs_w_interest'];
      $act_invs_a_amount = $row['act_invs_a_amount'];
      $act_invs_a_interest = $row['act_invs_a_interest'];
      $act_invs_r_fine = $row['act_invs_r_fine'];
      $act_invs_rate = $row['act_invs_rate'];
      $inv_repayment_method = $row['inv_repayment_method'];
      $inv_duration = $row['inv_duration'];
      $inv_start = $row['inv_start'];
      $inv_end = $row['inv_end'];
      $inv_finished = $row['inv_finished'];

      $json = $json.",{\"id\":".jsonstrval($act_invs_app_id).",\"is_done\":".jsonstrval($act_invs_is_done).",\"title\":".jsonstr($inv_title).",\"category\":".jsonstrval($inv_category).",\"amount\":".jsonstrval($act_invs_amount).",\"r_amount\":".jsonstrval($act_invs_r_amount).",\"r_interest\":".jsonstrval($act_invs_r_interest).",\"w_amount\":".jsonstrval($act_invs_w_amount).",\"w_interest\":".jsonstrval($act_invs_w_interest).",\"a_amount\":".jsonstrval($act_invs_a_amount).",\"a_interest\":".jsonstrval($act_invs_a_interest).",\"r_fine\":".jsonstrval($act_invs_r_fine).",\"rate\":".jsonstrval($act_invs_rate).",\"method\":".jsonstrval($inv_repayment_method).",\"duration\":".jsonstrval($inv_duration).",\"start\":".jsonstr($inv_start).",\"end\":".jsonstr($inv_end).",\"finished\":null}";
    }
    mysqli_free_result($result);
    $json = substr($json, 1);
    $json = "{\"total\":".$total.",\"investments\":[".$json."]}";
    break;
  case 3: // finished
    $total = 0;
    if ($page == 1)
    {
      $query = "SELECT COUNT(act_invs_app_id) AS total FROM account_investments_act_invs WHERE act_invs_usr_id = ".strval($usr_id)." AND act_invs_is_done = 1";
      mysqli_query($con, "LOCK TABLES account_investments_act_invs READ");
      $result = mysqli_query($con, $query);
      mysqli_query($con, "UNLOCK TABLES");
      if ($row = mysqli_fetch_array($result))
      {
        $total = $row['total'];
        mysqli_free_result($result);
      }
    }
    $start = ($page - 1) * $per_page;
    $query = "SELECT act_invs_app_id, act_invs_is_done, inv_title, inv_category, act_invs_amount, act_invs_r_amount, act_invs_r_interest, act_invs_w_amount, act_invs_w_interest, act_invs_a_amount, act_invs_a_interest, act_invs_r_fine, act_invs_rate, inv_repayment_method, inv_duration, inv_start, inv_end, inv_finished FROM account_investments_act_invs LEFT JOIN investments_inv ON act_invs_app_id = inv_app_id WHERE act_invs_usr_id = ".strval($usr_id)." AND act_invs_is_done = 1 ORDER BY act_invs_time ASC LIMIT ".strval($start).",".strval($per_page);
    mysqli_query($con, "LOCK TABLES account_investments_act_invs READ, investments_inv READ");
    $result = mysqli_query($con, $query);
    mysqli_query($con, "UNLOCK TABLES");
    while ($row = mysqli_fetch_array($result))
    {
      $act_invs_app_id = $row['act_invs_app_id'];
      $act_invs_is_done = $row['act_invs_is_done'];
      $inv_title = $row['inv_title'];
      $inv_category = $row['inv_category'];
      $act_invs_amount = $row['act_invs_amount'];
      $act_invs_r_amount = $row['act_invs_r_amount'];
      $act_invs_r_interest = $row['act_invs_r_interest'];
      $act_invs_w_amount = $row['act_invs_w_amount'];
      $act_invs_w_interest = $row['act_invs_w_interest'];
      $act_invs_a_amount = $row['act_invs_a_amount'];
      $act_invs_a_interest = $row['act_invs_a_interest'];
      $act_invs_r_fine = $row['act_invs_r_fine'];
      $act_invs_rate = $row['act_invs_rate'];
      $inv_repayment_method = $row['inv_repayment_method'];
      $inv_duration = $row['inv_duration'];
      $inv_start = $row['inv_start'];
      $inv_end = $row['inv_end'];
      $inv_finished = $row['inv_finished'];

      $json = $json."{\"id\":".jsonstrval($act_invs_app_id).",\"is_done\":".jsonstrval($act_invs_is_done).",\"title\":".jsonstr($inv_title).",\"category\":".jsonstrval($inv_category).",\"amount\":".jsonstrval($act_invs_amount).",\"r_amount\":".jsonstrval($act_invs_r_amount).",\"r_interest\":".jsonstrval($act_invs_r_interest).",\"w_amount\":".jsonstrval($act_invs_w_amount).",\"w_interest\":".jsonstrval($act_invs_w_interest).",\"a_amount\":".jsonstrval($act_invs_a_amount).",\"a_interest\":".jsonstrval($act_invs_a_interest).",\"r_fine\":".jsonstrval($act_invs_r_fine).",\"rate\":".jsonstrval($act_invs_rate).",\"method\":".jsonstrval($inv_repayment_method).",\"duration\":".jsonstrval($inv_duration).",\"start\":".jsonstr($inv_start).",\"end\":".jsonstr($inv_end).",\"finished\":".jsonstr($inv_finished)."}";
    }
    mysqli_free_result($result);
    $json = substr($json, 1);
    $json = "{\"total\":".$total.",\"investments\":[".$json."]}";
    break;
  default:
    $query = "SELECT act_inv_amount, act_inv_interest, act_inv_fine, act_inv_interest_rate, act_inv_duration, act_inv_total, act_inv_holdings FROM account_investment_act_inv WHERE act_inv_usr_id = ".strval($usr_id);
    mysqli_query($con, "LOCK TABLES account_investment_act_inv READ");
    $result = mysqli_query($con, $query);
    mysqli_query($con, "UNLOCK TABLES");
    if ($row = mysqli_fetch_array($result))
    {
      $act_inv_amount = $row['act_inv_amount'];
      $act_inv_interest = $row['act_inv_interest'];
      $act_inv_fine = $row['act_inv_fine'];
      $act_inv_interest_rate = $row['act_inv_interest_rate'];
      $act_inv_duration = $row['act_inv_duration'];
      $act_inv_total = $row['act_inv_total'];
      $act_inv_holdings = $row['act_inv_holdings'];
      mysqli_free_result($result);
      $json = "{\"amount\":".jsonstrval($act_inv_amount).",\"interest\":".jsonstrval($act_inv_interest).",\"fine\":".jsonstrval($act_inv_fine).",\"rate\":".jsonstrval($act_inv_interest_rate).",\"duration\":".jsonstrval($act_inv_duration).",\"total\":".jsonstrval($act_inv_total).",\"holdings\":".jsonstrval($act_inv_holdings)."}";
    }
    break;
}

mysqli_kill($con, mysqli_thread_id($con));
mysqli_close($con);
echo $json;
?>