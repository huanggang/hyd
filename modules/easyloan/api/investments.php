<?php

function investments(){

  include_once 'util_global.php';

  $todayStr = date("Y-m-d");
  $today = new DateTime($todayStr);// date_create_from_format('Y-m-d', $todayStr);
  $twoYearsAgoStr = $today->sub(new DateInterval("P2Y"))->format("Y-m-d");

  $frontStr = $_GET["front"];
  $durationStr = $_GET["duration"];
  $statusStr = $_GET["status"];
  $pageStr = $_GET["page"];

  $front = str2int($frontStr, 0);
  $duration = str2int($durationStr, 0);
  $status = str2int($statusStr, 0);
  $page = str2int($pageStr, 1);
  if ($page <= 0)
  {
    $page = 1;
  }
  else if ($page > $max_pages)
  {
    $page = $max_pages;
  }

  $limit = " ORDER BY inv_created DESC LIMIT ";
  if ($front == 1)
  {
    $limit = $limit."0,".$front_per_page;
  }
  else
  {
    $start = ($page - 1) * $per_page;
    $limit = $limit.strval($start).",".strval($per_page);
  }
  $condition = "";
  switch ($duration)
  {
    case 1:
      $condition = $condition." AND inv_duration >= 0 AND inv_duration <= 3";
      break;
    case 2:
      $condition = $condition." AND inv_duration > 3 AND inv_duration <= 9";
      break;
    case 3:
      $condition = $condition." AND inv_duration > 9 AND inv_duration <= 18";
      break;
    case 4:
      $condition = $condition." AND inv_duration > 18";
      break;
  }
  switch ($status)
  {
    case 1:
      $condition = $condition." AND inv_is_done IS NULL";
      break;
    case 2:
      $condition = $condition." AND inv_is_done = 0 AND inv_start > ".sqlstr($todayStr);
      break;
    case 3:
      $condition = $condition." AND inv_is_done = 0 AND inv_start <= ".sqlstr($todayStr);
      break;
    case 4:
      $condition = $condition." AND inv_is_done = 1";
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

  if ($page == 1 && $front == 0)
  {
    $qTotal = "SELECT COUNT(inv_app_id) AS total FROM investments_inv WHERE DATE(inv_created) >= ".sqlstr($twoYearsAgoStr).$condition;
    mysqli_query($con, "LOCK TABLES investments_inv READ");
    $result = mysqli_query($con, $qTotal);
    mysqli_query($con, "UNLOCK TABLES");
    if ($row = mysqli_fetch_array($result))
    {
      $total = $row["total"];
      mysqli_free_result($result);
    }
  }
  $products = "";
  $query = "SELECT inv_app_id, inv_title, inv_category, inv_interest_rate, inv_repayment_method, inv_amount, inv_duration, inv_start, inv_end, inv_is_done, inv_investment, inv_created FROM investments_inv WHERE DATE(inv_created) >= ".sqlstr($twoYearsAgoStr).$condition.$limit;
  mysqli_query($con, "LOCK TABLES investments_inv READ");
  $result = mysqli_query($con, $query);
  mysqli_query($con, "UNLOCK TABLES");
  while ($row = mysqli_fetch_array($result))
  {
    $inv_app_id = $row['inv_app_id'];
    $inv_title = $row['inv_title'];
    $inv_category = $row['inv_category'];
    $inv_interest_rate = $row['inv_interest_rate'];
    $inv_repayment_method = $row['inv_repayment_method'];
    $inv_amount = $row['inv_amount'];
    $inv_duration = $row['inv_duration'];
    $inv_start = $row['inv_start'];
    $inv_end = $row['inv_end'];
    $inv_is_done = $row['inv_is_done'];
    $inv_investment = $row['inv_investment'];
    $inv_created = $row['inv_created'];

    $products = $products.",{\"id\":".jsonstrval($inv_app_id).",\"title\":".jsonstr($inv_title).",\"category\":".jsonstrval($inv_category).",\"rate\":".jsonstrval($inv_interest_rate).",\"repayment_method\":".jsonstrval($inv_repayment_method).",\"amount\":".jsonstrval($inv_amount).",\"duration\":".jsonstrval($inv_duration).",\"start\":".jsonstr($inv_start).",\"end\":".jsonstr($inv_end).",\"is_done\":".jsonstrval($inv_is_done).",\"investment\":".jsonstrval($inv_investment).",\"created\":".jsonstr($inv_created)."}";
  }
  mysqli_free_result($result);
  mysqli_kill($con, mysqli_thread_id($con));
  mysqli_close($con);
  $products = substr($products, 1);
  $list = "{\"result\":1,\"total\":".jsonstrval($total).",\"products\":[".$products."],\"today\":".jsonstr($todayStr)."}";
  echo $list;
}
?>