<?php

function apply(){

  include_once 'util_global.php';

  $now = new DateTime;
  $nowStr = $now->format("Y-m-d\TH:i:sP");
  $this_year = strval($now->format("Y"));
  // check current time between 9am - 11pm
  if (!is_now_valid($time_user_start, $time_user_end))
  {
    echo "{\"result\":0,\"message\":\"Overtime\"}";
    exit;
  }

  if ($user->uid <= 0)
  {
    echo "{\"result\":0}";
    exit;
  }
  $usr_id = $user->uid;

  $categoryStr = $_POST["category"];
  $category = str2int($categoryStr, 0);
  if ($category <= 0)
  {
    echo "{\"result\":0}";
    exit;
  }
  $title = $_POST["title"];
  if (is_null($title))
  {
    echo "{\"result\":0}";
    exit;
  }
  $amountStr = $_POST["amount"];
  $amount = str2float($amountStr, 0);
  if ($amount <= 999)
  {
    echo "{\"result\":0}";
    exit;
  }
  $durationStr = $_POST["duration"];
  $duration = str2int($durationStr, 0);
  if ($duration <= 0 || $duration > 120)
  {
    echo "{\"result\":0}";
    exit;
  }
  $certificateStr = $_POST["certificate"];
  $certificate = str2int($certificateStr, 0);
  if ($certificate < 0 || $certificate > 1)
  {
    echo "{\"result\":0}";
    exit;
  }
  $purpose = $_POST["purpose"];
  if (is_null($purpose))
  {
    echo "{\"result\":0}";
    exit;
  }
  $asset_description = $_POST["asset_description"];
  if (is_null($asset_description))
  {
    echo "{\"result\":0}";
    exit;
  }

  $is_done = 0; $is_loaned = null; $status = 1;
  $address = null; $area = null; $floor = null; $height = null; $facing = null; $estate_year = null; $usage = null; $has_loan = null;
  $brand = null; $vehicle_year = null; $vin = null; $made = null; $violations = null; $register = null; $vehicle_price = null; $color = null; $features = null; $mileage = null; $transfers = null; $oversea = null; $vehicle_status = null;
  $gold_name = null; $weight = null; $purity = null;
  $other_name = null; $bought = null; $other_price = null;

  switch ($category)
  {
    case 1:
      $address = $_POST["address"];
      if (is_null($address))
      {
        echo "{\"result\":0}";
        exit;
      }
      $areaStr = $_POST["area"];
      $area = str2float($areaStr, 0);
      if ($area <= 0)
      {
        echo "{\"result\":0}";
        exit;
      }
      $floorStr = $_POST["floor"];
      $floor = str2int($floorStr, 0);
      if ($floor <= 0)
      {
        $floor = null;
      }
      $heightStr = $_POST["height"];
      $height = str2int($heightStr, 0);
      if ($height <= 0)
      {
        $height = null;
      }
      $facingStr = $_POST["facing"];
      $facing = str2int($facingStr, 0);
      if ($facing <= 0)
      {
        $facing = null;
      }
      $yearStr = $_POST["year"];
      $estate_year = str2int($yearStr, 0);
      if ($estate_year <= ($this_year - 200) && $estate_year > ($this_year + 1))
      {
        echo "{\"result\":0}";
        exit;
      }
      $usage = $_POST["usage"];
      $has_loanStr = $_POST["has_loan"];
      $has_loan = str2int($has_loanStr, 0);
      if ($has_loan < 0 || $has_loan > 1)
      {
        $has_loan = null;
      }
      break;
    case 2:
      $brand = $_POST["brand"];
      if (is_null($brand))
      {
        echo "{\"result\":0}";
        exit;
      }
      $yearStr = $_POST["year"];
      $vehicle_year = str2int($yearStr, 0);
      if ($vehicle_year <= ($this_year - 100) && $vehicle_year > $this_year)
      {
        echo "{\"result\":0}";
        exit;
      }
      $vin = $_POST["vin"];
      if (is_null($vin))
      {
        echo "{\"result\":0}";
        exit;
      }
      $made = str2datetime($_POST["made"]);
      if (!is_null($made))
      {
        $made = $made->format("Y-m-d");
      }
      $violations = str2int($_POST["violations"]);
      if ($violations < 0)
      {
        $violations = 0;
      }
      $register = str2datetime($_POST["register"]);
      if (!is_null($register))
      {
        $register = $register->format("Y-m-d");
      }
      $priceStr = $_POST["price"];
      $vehicle_price = str2float($priceStr, 0);
      if ($vehicle_price <= 999)
      {
        $vehicle_price = null;
      }
      $color = $_POST["color"];
      $features = $_POST["features"];
      $mileageStr = $_POST["mileage"];
      $mileage = str2int($mileageStr, 0);
      if ($mileage <= 0)
      {
        echo "{\"result\":0}";
        exit;
      }
      $transfersStr = $_POST["transfers"];
      $transfers = str2int($transfersStr, -1);
      if ($transfers < 0)
      {
        $transfers = null;
      }
      $overseaStr = $_POST["oversea"];
      $oversea = str2int($overseaStr, 0);
      if ($oversea < 0)
      {
        $oversea = null;
      }
      $vehicle_statusStr = $_POST["status"];
      $vehicle_status = str2int($vehicle_statusStr, 0);
      if ($vehicle_status <= 0)
      {
        $vehicle_status = null;
      }
      break;
    case 3:
      $gold_name = $_POST["name"];
      if (is_null($gold_name))
      {
        echo "{\"result\":0}";
        exit;
      }
      $weightStr = $_POST["weight"];
      $weight = str2float($weightStr, 0);
      if ($weight <= 0)
      {
        echo "{\"result\":0}";
        exit;
      }
      $purityStr = $_POST["purity"];
      $purity = str2float($purityStr, 0);
      if ($purity <= 0 && $purity > 100)
      {
        echo "{\"result\":0}";
        exit;
      }
      break;
    case 4:
      $other_name = $_POST["name"];
      if (is_null($other_name))
      {
        echo "{\"result\":0}";
        exit;
      }
      $bought = str2datetime($_POST["bought"]);
      if (is_null($bought))
      {
        echo "{\"result\":0}";
        exit;
      }
      else
      {
        $bought = $bought->format("Y-m-d");
      }
      $priceStr = $_POST["price"];
      $other_price = str2float($priceStr, 0);
      if ($other_price <= 999)
      {
        echo "{\"result\":0}";
        exit;
      }
      break;
  }

  $con=mysqli_connect($db_host, $db_user, $db_pwd, $db_name);
  // Check connection
  if (mysqli_connect_errno())
  {
    echo "{\"result\":0}";
    exit;
  }
  mysqli_set_charset($con, "UTF8");

  mysqli_autocommit($con, false);
  mysqli_query($con, "LOCK TABLES applications_app WRITE, account_info_act_info READ, loans_lns READ, account_investment_act_inv READ");

  $query = "SELECT act_info_usr_id FROM account_info_act_info WHERE act_info_usr_id = ".strval($usr_id)." AND act_info_ssn_status = 1 AND act_info_mobile_status = 1";
  $result = mysqli_query($con, $query);
  if (!is_null(mysqli_fetch_array($result)))
  {
    mysqli_free_result($result);

    $query = "SELECT app_usr_id FROM applications_app WHERE app_usr_id = ".strval($usr_id)." AND (app_is_done = 0 OR (app_is_done = 1 AND app_is_loaned IS NULL))";
    $result = mysqli_query($con, $query);
    if (is_null(mysqli_fetch_array($result)))
    {
      mysqli_free_result($result);

      $query = "SELECT lns_usr_id FROM loans_lns WHERE lns_usr_id = ".strval($usr_id)." AND lns_is_done = 0";
      $result = mysqli_query($con, $query);
      if (is_null(mysqli_fetch_array($result)))
      {
        mysqli_free_result($result);

        $query = "SELECT act_inv_usr_id FROM account_investment_act_inv WHERE act_inv_usr_id = ".strval($usr_id)." AND act_inv_holdings > 0";
        $result = mysqli_query($con, $query);
        if (is_null(mysqli_fetch_array($result)))
        {
          mysqli_free_result($result);

          $query = "INSERT INTO applications_app (app_usr_id, app_is_done, app_is_loaned, app_applied, app_status, app_category, app_title, app_amount, app_duration, app_purpose, app_asset_description, app_has_certificate, app_real_estate_address, app_real_estate_area, app_real_estate_floor, app_real_estate_height, app_real_estate_facing, app_real_estate_year, app_real_estate_usage, app_real_estate_has_loan, app_vehicle_brand, app_vehicle_year, app_vehicle_vin, app_vehicle_made, app_vehicle_violations, app_vehicle_register, app_vehicle_price, app_vehicle_color, app_vehicle_features, app_vehicle_mileage, app_vehicle_transfers, app_vehicle_oversea, app_vehicle_status, app_gold_name, app_gold_weight, app_gold_purity, app_other_name, app_other_bought, app_other_price, app_updated) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
          if ($stmt = mysqli_prepare($con, $query))
          {
            mysqli_stmt_bind_param($stmt, "iiisiisdissisdiiiisisissisdssiiiisddssds", $usr_id, $is_done, $is_loaned, $nowStr, $status, $category, $title, $amount, $duration, $purpose, $asset_description, $certificate, $address, $area, $floor, $height, $facing, $estate_year, $usage, $has_loan, $brand, $vehicle_year, $vin, $made, $violations, $register, $vehicle_price, $color, $features, $mileage, $transfers, $oversea, $vehicle_status, $gold_name, $weight, $purity, $other_name, $bought, $other_price, $nowStr);

            $flag = mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);

            if ($flag)
            {
              mysqli_commit($con);
              echo "{\"result\":1}";
            }
            else
            {
              mysqli_rollback($con);
              echo "{\"result\":0,\"message\":\"DB write failure\"}";
            }
          }
        }
        else
        {
          echo "{\"result\":0,\"message\":\"Holding investments\"}";
        }
      }
      else
      {
        echo "{\"result\":0,\"message\":\"Unfinished loan\"}";
      }
    }
    else
    {
      echo "{\"result\":0,\"message\":\"Under processing loan application\"}";
    }
  }
  else
  {
    echo "{\"result\":0,\"message\":\"Not certified yet\"}";
  }

  mysqli_query($con, "UNLOCK TABLES");
  mysqli_kill($con, mysqli_thread_id($con));
  mysqli_close($con);
}
?>