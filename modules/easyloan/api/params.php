<?php

include_once 'util_global.php';

function refresh()
{
  global $site_js;
  global $db_host, $db_name, $db_user, $db_pwd;
  $con=mysqli_connect($db_host, $db_user, $db_pwd, $db_name);
  // Check connection
  if (mysqli_connect_errno())
  {
    return false;
  }
  mysqli_set_charset($con, "UTF8");
  
  // educations
  $educations = "";
  mysqli_query($con, "LOCK TABLES educations_edu READ");
  $result = mysqli_query($con, "SELECT edu_id, edu_education FROM educations_edu ORDER BY edu_id");
  mysqli_query($con, "UNLOCK TABLES");
  while ($row = mysqli_fetch_array($result))
  {
    $edu_id = $row["edu_id"];
    $edu_education = $row["edu_education"];
    $educations = $educations.",{\"id\":".jsonstrval($edu_id).",\"name\":".jsonstr($edu_education)."}";
  }
  mysqli_free_result($result);
  $educations = substr($educations, 1);
  $educations = "var educations=[".$educations."];";
  file_put_contents($site_js."educations.js", $educations);

  // marital status
  $marital_status = "";
  mysqli_query($con, "LOCK TABLES marital_status_mrt READ");
  $result = mysqli_query($con, "SELECT mrt_id, mrt_marital FROM marital_status_mrt ORDER BY mrt_id");
  mysqli_query($con, "UNLOCK TABLES");
  while ($row = mysqli_fetch_array($result))
  {
    $mrt_id = $row["mrt_id"];
    $mrt_marital = $row["mrt_marital"];
    $marital_status = $marital_status.",{\"id\":".jsonstrval($mrt_id).",\"name\":".jsonstr($mrt_marital)."}";
  }
  mysqli_free_result($result);
  $marital_status = substr($marital_status, 1);
  $marital_status = "var marital_status=[".$marital_status."];";
  file_put_contents($site_js."marital_status.js", $marital_status);

  //provinces, cities
  $provinces = "";
  mysqli_query($con, "LOCK TABLES provinces_prv READ, cities_cts READ");
  $result = mysqli_query($con, "SELECT prv_id, prv_province FROM provinces_prv ORDER BY prv_id");
  while ($row = mysqli_fetch_array($result))
  {
    $prv_id = $row["prv_id"];
    $prv_province = $row["prv_province"];
    $provinces = $provinces.",{\"id\":".jsonstrval($prv_id).",\"name\":".jsonstr($prv_province)."}";

    $cities = "";
    $result1 = mysqli_query($con, "SELECT cts_id, cts_city FROM cities_cts WHERE cts_prv_id = ".strval($prv_id)." ORDER BY cts_id");
    while ($row1 = mysqli_fetch_array($result1))
    {
      $cts_id = $row1["cts_id"];
      $cts_city = $row1["cts_city"];
      $cities = $cities.",{\"id\":".jsonstrval($cts_id).",\"name\":".jsonstr($cts_city)."}";
    }
    mysqli_free_result($result1);
    $cities = substr($cities, 1);
    $cities = "var cities_".strval($prv_id)."=[".$cities."];";
    file_put_contents($site_js."cities_".strval($prv_id).".js", $cities);
  }
  mysqli_query($con, "UNLOCK TABLES");
  mysqli_free_result($result);
  $provinces = substr($provinces, 1);
  $provinces = "var provinces=[".$provinces."];var cities = new Array();";
  file_put_contents($site_js."provinces.js", $provinces);

  // banks
  $banks = "";
  mysqli_query($con, "LOCK TABLES banks_bnk READ");
  $result = mysqli_query($con, "SELECT bnk_id, bnk_bank FROM banks_bnk ORDER BY bnk_id");
  mysqli_query($con, "UNLOCK TABLES");
  while ($row = mysqli_fetch_array($result))
  {
    $bnk_id = $row["bnk_id"];
    $bnk_bank = $row["bnk_bank"];
    $banks = $banks.",{\"id\":".jsonstrval($bnk_id).",\"name\":".jsonstr($bnk_bank)."}";
  }
  mysqli_free_result($result);
  $banks = substr($banks, 1);
  $banks = "var banks=[".$banks."];";
  file_put_contents($site_js."banks.js", $banks);

  // duration ranges
  $duration_ranges = "";
  mysqli_query($con, "LOCK TABLES duration_ranges_dur_rng READ");
  $result = mysqli_query($con, "SELECT dur_rng_id, dur_rng_name FROM duration_ranges_dur_rng ORDER BY dur_rng_id");
  mysqli_query($con, "UNLOCK TABLES");
  while ($row = mysqli_fetch_array($result))
  {
    $dur_rng_id = $row["dur_rng_id"];
    $dur_rng_name = $row["dur_rng_name"];
    $duration_ranges = $duration_ranges.",{\"id\":".jsonstrval($dur_rng_id).",\"name\":".jsonstr($dur_rng_name)."}";
  }
  mysqli_free_result($result);
  $duration_ranges = substr($duration_ranges, 1);
  $duration_ranges = "var duration_ranges=[".$duration_ranges."];";
  file_put_contents($site_js."duration_ranges.js", $duration_ranges);

  // investment status
  $investment_status = "";
  mysqli_query($con, "LOCK TABLES investment_status_inv_stt READ");
  $result = mysqli_query($con, "SELECT inv_stt_id, inv_stt_status FROM investment_status_inv_stt ORDER BY inv_stt_id");
  mysqli_query($con, "UNLOCK TABLES");
  while ($row = mysqli_fetch_array($result))
  {
    $inv_stt_id = $row["inv_stt_id"];
    $inv_stt_status = $row["inv_stt_status"];
    $investment_status = $investment_status.",{\"id\":".jsonstrval($inv_stt_id).",\"name\":".jsonstr($inv_stt_status)."}";
  }
  mysqli_free_result($result);
  $investment_status = substr($investment_status, 1);
  $investment_status = "var investment_status=[".$investment_status."];";
  file_put_contents($site_js."investment_status.js", $investment_status);

  // loan categories
  $loan_categories = "";
  mysqli_query($con, "LOCK TABLES loan_categories_ln_ctg READ");
  $result = mysqli_query($con, "SELECT ln_ctg_id, ln_ctg_category FROM loan_categories_ln_ctg ORDER BY ln_ctg_id");
  mysqli_query($con, "UNLOCK TABLES");
  while ($row = mysqli_fetch_array($result))
  {
    $ln_ctg_id = $row["ln_ctg_id"];
    $ln_ctg_category = $row["ln_ctg_category"];
    $loan_categories = $loan_categories.",{\"id\":".jsonstrval($ln_ctg_id).",\"name\":".jsonstr($ln_ctg_category)."}";
  }
  mysqli_free_result($result);
  $loan_categories = substr($loan_categories, 1);
  $loan_categories = "var loan_categories=[".$loan_categories."];";
  file_put_contents($site_js."loan_categories.js", $loan_categories);

  // repayment methods
  $repayment_methods = "";
  mysqli_query($con, "LOCK TABLES repayment_methods_rpy_mth READ");
  $result = mysqli_query($con, "SELECT rpy_mth_id, rpy_mth_method FROM repayment_methods_rpy_mth ORDER BY rpy_mth_id");
  mysqli_query($con, "UNLOCK TABLES");
  while ($row = mysqli_fetch_array($result))
  {
    $rpy_mth_id = $row["rpy_mth_id"];
    $rpy_mth_method = $row["rpy_mth_method"];
    $repayment_methods = $repayment_methods.",{\"id\":".jsonstrval($rpy_mth_id).",\"name\":".jsonstr($rpy_mth_method)."}";
  }
  mysqli_free_result($result);
  $repayment_methods = substr($repayment_methods, 1);
  $repayment_methods = "var repayment_methods=[".$repayment_methods."];";
  file_put_contents($site_js."repayment_methods.js", $repayment_methods);

  // application status
  $application_status = "";
  mysqli_query($con, "LOCK TABLES application_status_app_stt READ");
  $result = mysqli_query($con, "SELECT app_stt_id, app_stt_status FROM application_status_app_stt ORDER BY app_stt_id");
  mysqli_query($con, "UNLOCK TABLES");
  while ($row = mysqli_fetch_array($result))
  {
    $app_stt_id = $row["app_stt_id"];
    $app_stt_status = $row["app_stt_status"];
    $application_status = $application_status.",{\"id\":".jsonstrval($app_stt_id).",\"name\":".jsonstr($app_stt_status)."}";
  }
  mysqli_free_result($result);
  $application_status = substr($application_status, 1);
  $application_status = "var application_status=[".$application_status."];";
  file_put_contents($site_js."application_status.js", $application_status);

  // facing
  $facing = "";
  mysqli_query($con, "LOCK TABLES facing_fcn READ");
  $result = mysqli_query($con, "SELECT fcn_id, fcn_facing FROM facing_fcn ORDER BY fcn_id");
  mysqli_query($con, "UNLOCK TABLES");
  while ($row = mysqli_fetch_array($result))
  {
    $fcn_id = $row["fcn_id"];
    $fcn_facing = $row["fcn_facing"];
    $facing = $facing.",{\"id\":".jsonstrval($fcn_id).",\"name\":".jsonstr($fcn_facing)."}";
  }
  mysqli_free_result($result);
  $facing = substr($facing, 1);
  $facing = "var facing=[".$facing."];";
  file_put_contents($site_js."facing.js", $facing);

  // vehicle features
  $vehicle_features = "";
  mysqli_query($con, "LOCK TABLES vehicle_features_vhc_ftr READ");
  $result = mysqli_query($con, "SELECT vhc_ftr_id, vhc_ftr_feature FROM vehicle_features_vhc_ftr ORDER BY vhc_ftr_id");
  mysqli_query($con, "UNLOCK TABLES");
  while ($row = mysqli_fetch_array($result))
  {
    $vhc_ftr_id = $row["vhc_ftr_id"];
    $vhc_ftr_feature = $row["vhc_ftr_feature"];
    $vehicle_features = $vehicle_features.",{\"id\":".jsonstrval($vhc_ftr_id).",\"name\":".jsonstr($vhc_ftr_feature)."}";
  }
  mysqli_free_result($result);
  $vehicle_features = substr($vehicle_features, 1);
  $vehicle_features = "var vehicle_features=[".$vehicle_features."];";
  file_put_contents($site_js."vehicle_features.js", $vehicle_features);

  // vehicle status
  $vehicle_status = "";
  mysqli_query($con, "LOCK TABLES vehicle_status_vhc_stt READ");
  $result = mysqli_query($con, "SELECT vhc_stt_id, vhc_stt_status FROM vehicle_status_vhc_stt ORDER BY vhc_stt_id");
  mysqli_query($con, "UNLOCK TABLES");
  while ($row = mysqli_fetch_array($result))
  {
    $vhc_stt_id = $row["vhc_stt_id"];
    $vhc_stt_status = $row["vhc_stt_status"];
    $vehicle_status = $vehicle_status.",{\"id\":".jsonstrval($vhc_stt_id).",\"name\":".jsonstr($vhc_stt_status)."}";
  }
  mysqli_free_result($result);
  $vehicle_status = substr($vehicle_status, 1);
  $vehicle_status = "var vehicle_status=[".$vehicle_status."];";
  file_put_contents($site_js."vehicle_status.js", $vehicle_status);

  // transaction types
  $transaction_types = "";
  mysqli_query($con, "LOCK TABLES transaction_types_trn_typ READ");
  $result = mysqli_query($con, "SELECT trn_typ_id, trn_typ_type FROM transaction_types_trn_typ ORDER BY trn_typ_id");
  mysqli_query($con, "UNLOCK TABLES");
  while ($row = mysqli_fetch_array($result))
  {
    $trn_typ_id = $row["trn_typ_id"];
    $trn_typ_type = $row["trn_typ_type"];
    $transaction_types = $transaction_types.",{\"id\":".jsonstrval($trn_typ_id).",\"name\":".jsonstr($trn_typ_type)."}";
  }
  mysqli_free_result($result);
  $transaction_types = substr($transaction_types, 1);
  $transaction_types = "var transaction_types=[".$transaction_types."];";
  file_put_contents($site_js."transaction_types.js", $transaction_types);

  // transaction time ranges
  $transaction_time_ranges = "";
  mysqli_query($con, "LOCK TABLES transaction_time_ranges_trn_tm_rng READ");
  $result = mysqli_query($con, "SELECT trn_tm_rng_id, trn_tm_rng_range FROM transaction_time_ranges_trn_tm_rng ORDER BY trn_tm_rng_id");
  mysqli_query($con, "UNLOCK TABLES");
  while ($row = mysqli_fetch_array($result))
  {
    $trn_tm_rng_id = $row["trn_tm_rng_id"];
    $trn_tm_rng_range = $row["trn_tm_rng_range"];
    $transaction_time_ranges = $transaction_time_ranges.",{\"id\":".jsonstrval($trn_tm_rng_id).",\"name\":".jsonstr($trn_tm_rng_range)."}";
  }
  mysqli_free_result($result);
  $transaction_time_ranges = substr($transaction_time_ranges, 1);
  $transaction_time_ranges = "var transaction_time_ranges=[".$transaction_time_ranges."];";
  file_put_contents($site_js."transaction_time_ranges.js", $transaction_time_ranges);
  
  mysqli_kill($con, mysqli_thread_id($con));
  mysqli_close($con);
  return true;
}

$type = $_GET["type"];
if (is_null($type))
{
  header("HTTP/1.0 404 Not Found");
  exit;
}

$type = strtolower($type);
$redirect = "Location: ".$web_js;
if ($type == "refresh")
{
  if (refresh())
  {
    echo "{\"result\": 1}";
  }
  else
  {
    echo "{\"result\": 0}";
  }
}
else
{
  switch ($type)
  {
    case "education":
      $redirect = $redirect."educations.js";
      break;
    case "marital_status":
      $redirect = $redirect."marital_status.js";
      break;
    case "province":
      $redirect = $redirect."provinces.js";
      break;
    case "city":
      $prv_id = $_GET["province"];
      $redirect = $redirect."cities_".strval($prv_id).".js";
      break;
    case "bank":
      $redirect = $redirect."banks.js";
      break;
    case "duration_range":
      $redirect = $redirect."duration_ranges.js";
      break;
    case "investment_status":
      $redirect = $redirect."investment_status.js";
      break;
    case "loan_category":
      $redirect = $redirect."loan_categories.js";
      break;
    case "act_ln_method":
      $redirect = $redirect."repayment_methods.js";
      break;
    case "application_status":
      $redirect = $redirect."application_status.js";
      break;
    case "facing":
      $redirect = $redirect."facing.js";
      break;
    case "vehicle_feature":
      $redirect = $redirect."vehicle_features.js";
      break;
    case "vehicle_status":
      $redirect = $redirect."vehicle_status.js";
      break;
    case "transaction_type":
      $redirect = $redirect."transaction_types.js";
      break;
    case "transaction_time_range":
      $redirect = $redirect."transaction_time_ranges.js";
      break;
  }
  header($redirect); /* Redirect browser */
  exit;
}
?>