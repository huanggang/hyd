<?php

function account_info(){
  
  include_once 'util_global.php';

  if ($user->uid <= 0)
  {
    echo "{\"result\":0}";
    exit;
  }
  $usr_id = $user->uid;

  $method = $_SERVER['REQUEST_METHOD'];

  $con=mysqli_connect($db_host, $db_user, $db_pwd, $db_name);
  // Check connection
  if (mysqli_connect_errno())
  {
    echo "{\"result\":0}";
    exit;
  }
  mysqli_set_charset($con, "UTF8");

  $json = "{\"result\":0}";
  if ($method == 'POST')
  {
    $education = str2int($_POST['education']);
    if ($education <= 0)
    {
      $education = null;
    }
    $marital = str2int($_POST['marital']);
    if ($marital <= 0)
    {
      $marital = null;
    }
    $province = str2int($_POST['province']);
    if ($province <= 0)
    {
      $province = null;
    }
    $city = str2int($_POST['city']);
    if ($city <= 0)
    {
      $city = null;
    }
    $address = $_POST['address'];
    if (is_null($address) || empty($address))
    {
      $address = null;
    }

    $query = "UPDATE account_info_act_info SET act_info_edu=?, act_info_marital=?, act_info_province=?, act_info_city=?, act_info_address=? WHERE act_info_usr_id=?";



    mysqli_query($con, "LOCK TABLES account_info_act_info WRITE");
    if ($stmt = mysqli_prepare($con, $query))
    {
      mysqli_stmt_bind_param($stmt, "iiiisi", $education, $marital, $province, $city, $address, $usr_id);

      $flag = mysqli_stmt_execute($stmt);
      mysqli_stmt_close($stmt);
      if ($flag)
      {
        $json = "{\"result\":1}";
      }
      else
      {
        $json = "{\"result\":0,\"message\":\"DB write failure\"}";
      }
    }
    mysqli_query($con, "UNLOCK TABLES");
  }
  else // default GET
  {
    $query = "SELECT act_info_nick, act_info_ssn_status, act_info_name, act_info_ssn, act_info_mobile_status, act_info_mobile, act_info_email_status, act_info_email, act_info_gender, act_info_dob, act_info_edu, act_info_marital, act_info_province, act_info_city, act_info_address FROM account_info_act_info WHERE act_info_usr_id = ".strval($usr_id);
    mysqli_query($con, "LOCK TABLES account_info_act_info READ");
    $result = mysqli_query($con, $query);
    mysqli_query($con, "UNLOCK TABLES");
    if ($row = mysqli_fetch_array($result))
    {
      $act_info_nick = $row['act_info_nick'];
      $act_info_ssn_status = $row['act_info_ssn_status'];
      $act_info_name = $row['act_info_name'];
      $act_info_ssn = $row['act_info_ssn'];
      $act_info_mobile_status = $row['act_info_mobile_status'];
      $act_info_mobile = $row['act_info_mobile'];
      $act_info_email_status = $row['act_info_email_status'];
      $act_info_email = $row['act_info_email'];
      $act_info_gender = $row['act_info_gender'];
      $act_info_dob = $row['act_info_dob'];
      $act_info_edu = $row['act_info_edu'];
      $act_info_marital = $row['act_info_marital'];
      $act_info_province = $row['act_info_province'];
      $act_info_city = $row['act_info_city'];
      $act_info_address = $row['act_info_address'];
      mysqli_free_result($result);

      if ($act_info_ssn_status == 1)
      {
        $act_info_ssn = substr_replace($act_info_ssn, " **** **** **** ****", 2, 16);;
      }
      if ($act_info_mobile_status == 1)
      {
        $act_info_mobile = substr_replace($act_info_mobile, " **** ", 3, 4);;
      }

      $json = "{\"nick\":".jsonstr($act_info_nick).",\"ssn_status\":".jsonstrval($act_info_ssn_status).",\"name\":".jsonstr($act_info_name).",\"ssn\":".jsonstr($act_info_ssn).",\"mobile_status\":".jsonstrval($act_info_mobile_status).",\"mobile\":".jsonstr($act_info_mobile).",\"email_status\":".jsonstrval($act_info_email_status).",\"email\":".jsonstr($act_info_email).",\"gender\":".jsonstrval($act_info_gender).",\"dob\":".jsonstr($act_info_dob).",\"education\":".jsonstrval($act_info_edu).",\"marital\":".jsonstrval($act_info_marital).",\"province\":".jsonstrval($act_info_province).",\"city\":".jsonstrval($act_info_city).",\"address\":".jsonstr($act_info_address)."}";
    }
  }

  mysqli_kill($con, mysqli_thread_id($con));
  mysqli_close($con);
  echo $json;
}
?>