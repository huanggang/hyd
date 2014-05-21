<?php

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

$query = "SELECT app_usr_id, app_is_done, app_is_loaned, app_status, app_title, app_category, app_amount, app_duration, app_purpose, app_asset_description, app_has_certificate, app_real_estate_address, app_real_estate_area, app_real_estate_floor, app_real_estate_height, app_real_estate_facing, app_real_estate_year, app_real_estate_usage, app_real_estate_has_loan, app_vehicle_brand, app_vehicle_year, app_vehicle_vin, app_vehicle_made, app_vehicle_violations, app_vehicle_register, app_vehicle_price, app_vehicle_color, app_vehicle_features, app_vehicle_mileage, app_vehicle_transfers, app_vehicle_oversea, app_vehicle_status, app_gold_name, app_gold_weight, app_gold_purity, app_other_name, app_other_bought, app_other_price FROM applications_app WHERE app_id = ".strval($id);
if (!is_auditor($user) && !is_accountant($user) && !is_manager($user) && !is_administrator($user))
{
  $query = $query." AND app_usr_id = ".strval($usr_id);
}
mysqli_query($con, "LOCK TABLES applications_app READ");
$result = mysqli_query($con, $query);
mysqli_query($con, "UNLOCK TABLES");
if ($row = mysqli_fetch_array($result))
{
  $app_usr_id = $row['app_usr_id'];
  $app_is_done = $row['app_is_done'];
  $app_is_loaned = $row['app_is_loaned'];
  $app_status = $row['app_status'];
  $app_title = $row['app_title'];
  $app_category = $row['app_category'];
  $app_amount = $row['app_amount'];
  $app_duration = $row['app_duration'];
  $app_purpose = $row['app_purpose'];
  $app_asset_description = $row['app_asset_description'];
  $app_has_certificate = $row['app_has_certificate'];
  $app_real_estate_address = $row['app_real_estate_address'];
  $app_real_estate_area = $row['app_real_estate_area'];
  $app_real_estate_floor = $row['app_real_estate_floor'];
  $app_real_estate_height = $row['app_real_estate_height'];
  $app_real_estate_facing = $row['app_real_estate_facing'];
  $app_real_estate_year = $row['app_real_estate_year'];
  $app_real_estate_usage = $row['app_real_estate_usage'];
  $app_real_estate_has_loan = $row['app_real_estate_has_loan'];
  $app_vehicle_brand = $row['app_vehicle_brand'];
  $app_vehicle_year = $row['app_vehicle_year'];
  $app_vehicle_vin = $row['app_vehicle_vin'];
  $app_vehicle_made = $row['app_vehicle_made'];
  $app_vehicle_violations = $row['app_vehicle_violations'];
  $app_vehicle_register = $row['app_vehicle_register'];
  $app_vehicle_price = $row['app_vehicle_price'];
  $app_vehicle_color = $row['app_vehicle_color'];
  $app_vehicle_features = $row['app_vehicle_features'];
  $app_vehicle_mileage = $row['app_vehicle_mileage'];
  $app_vehicle_transfers = $row['app_vehicle_transfers'];
  $app_vehicle_oversea = $row['app_vehicle_oversea'];
  $app_vehicle_status = $row['app_vehicle_status'];
  $app_gold_name = $row['app_gold_name'];
  $app_gold_weight = $row['app_gold_weight'];
  $app_gold_purity = $row['app_gold_purity'];
  $app_other_name = $row['app_other_name'];
  $app_other_bought = $row['app_other_bought'];
  $app_other_price = $row['app_other_price'];
  mysqli_free_result($result);

  $json = "{\"id\":".jsonstrval($id).",\"user_id\":".jsonstrval($app_usr_id).",\"is_done\":".jsonstrval($app_is_done).",\"is_loaned\":".jsonstrval($app_is_loaned).",\"status\":".jsonstrval($app_status).",\"title\":".jsonstr($app_title).",\"category\":".jsonstrval($app_category).",\"amount\":".jsonstrval($app_amount).",\"duration\":".jsonstrval($app_duration).",\"purpose\":".jsonstr($app_purpose).",\"description\":".jsonstr($app_asset_description).",\"has_certificate\":".jsonstrval($app_has_certificate);
  switch ($app_category)
  {
    case 1:
      $json = $json.",\"address\":".jsonstr($app_real_estate_address).",\"area\":".jsonstrval($app_real_estate_area).",\"floor\":".jsonstrval($app_real_estate_floor).",\"height\":".jsonstrval($app_real_estate_height).",\"facing\":".jsonstrval($app_real_estate_facing).",\"year\":".jsonstrval($app_real_estate_year).",\"usage\":".jsonstr($app_real_estate_usage).",\"has_loan\":".jsonstrval($app_real_estate_has_loan)."}";
      break;
    case 2:
      $json = $json.",\"brand\":".jsonstr($app_vehicle_brand).",\"year\":".jsonstrval($app_vehicle_year).",\"vin\":".jsonstr($app_vehicle_vin).",\"made\":".jsonstr($app_vehicle_made).",\"violations\":".jsonstrval($app_vehicle_violations).",\"register\":".jsonstr($app_vehicle_register).",\"price\":".jsonstrval($app_vehicle_price).",\"color\":".jsonstr($app_vehicle_color).",\"features\":".jsonstr($app_vehicle_features).",\"mileage\":".jsonstrval($app_vehicle_mileage).",\"transfers\":".jsonstrval($app_vehicle_transfers).",\"oversea\":".jsonstrval($app_vehicle_oversea).",\"status\":".jsonstrval($app_vehicle_status)."}";
      break;
    case 3:
      $json = $json.",\"name\":".jsonstr($app_gold_name).",\"weight\":".jsonstrval($app_gold_weight).",\"purity\":".jsonstrval($app_gold_purity)."}";
      break;
    case 4:
      $json = $json.",\"name\":".jsonstr($app_other_name).",\"bought\":".jsonstr($app_other_bought).",\"price\":".jsonstrval($app_other_price)."}";
      break;
  }
}
else
{
  $json = "{\"result\":0, \"message\":\"No privilege\"}";
}

mysqli_kill($con, mysqli_thread_id($con));
mysqli_close($con);
echo $json;
?>