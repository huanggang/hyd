<?php

function manage_loans(){

  include_once 'util_global.php';

  if ($user->uid <= 0)
  {
    echo "{\"result\":0}";
    exit;
  }
  $usr_id = $user->uid;

  if (!is_accountant($user) && !is_administrator($user))
  {
    echo "{\"result\":0}";
    exit;
  }

  $type = str2int($_GET['type']);
  if ($type < 1 || $type > 3)
  {
    echo "{\"result\":0}";
    exit;
  }
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

  $total = 0;
  $json = "";
  switch ($type)
  {
    case 1: // not loaned yet
      mysqli_query($con, "LOCK TABLES applications_app READ, account_info_act_info READ");
      if ($page == 1)
      {
        $query = "SELECT COUNT(app_usr_id) AS cnt FROM applications_app WHERE app_is_done = 1 AND app_is_loaned IS NULL";
        $result = mysqli_query($con, $query);
        if ($row = mysqli_fetch_array($result))
        {
          $total = $row['cnt'];
          mysqli_free_result($result);
        }
      }
      $start = ($page - 1) * $per_page;
      $query = "SELECT app_id, app_title, app_usr_id, act_info_nick, act_info_name, app_category, app_amount, app_duration, app_applied, app_comment FROM applications_app LEFT JOIN account_info_act_info ON app_usr_id = act_info_usr_id WHERE app_is_done = 1 AND app_is_loaned IS NULL ORDER BY app_applied ASC LIMIT ".strval($start).",".strval($per_page);
      $result = mysqli_query($con, $query);
      mysqli_query($con, "UNLOCK TABLES");
      while ($row = mysqli_fetch_array($result))
      {
        $app_id = $row['app_id'];
        $app_title = $row['app_title'];
        $app_usr_id = $row['app_usr_id'];
        $act_info_nick = $row['act_info_nick'];
        $act_info_name = $row['act_info_name'];
        $app_category = $row['app_category'];
        $app_amount = $row['app_amount'];
        $app_duration = $row['app_duration'];
        $app_applied = $row['app_applied'];
        $app_comment = $row['app_comment'];

        $json = $json.",{\"app_id\":".jsonstrval($app_id).",\"title\":".jsonstr($app_title).",\"user_id\":".jsonstrval($app_usr_id).",\"nick\":".jsonstr($act_info_nick).",\"name\":".jsonstr($act_info_name).",\"category\":".jsonstrval($app_category).",\"amount\":".jsonstrval($app_amount).",\"duration\":".jsonstrval($app_duration).",\"applied\":".jsonstr($app_applied).",\"comment\":".jsonstr($app_comment)."}";
      }
      mysqli_free_result($result);
      break;
    case 2: // repaying
      mysqli_query($con, "LOCK TABLES loans_lns READ, account_info_act_info READ");
      if ($page == 1)
      {
        $query = "SELECT COUNT(lns_usr_id) AS cnt FROM loans_lns WHERE lns_is_done = 0";
        $result = mysqli_query($con, $query);
        if ($row = mysqli_fetch_array($result))
        {
          $total = $row['cnt'];
          mysqli_free_result($result);
        }
      }
      $start = ($page - 1) * $per_page;
      $query = "SELECT lns_app_id, lns_title, lns_usr_id, act_info_nick, act_info_name, lns_category, lns_amount, lns_interest, lns_interest_rate, lns_repayment_method, lns_duration, lns_start, lns_end, lns_fine_rate, lns_fine_rate_is_single, lns_fine, lns_created FROM loans_lns LEFT JOIN account_info_act_info ON lns_usr_id = act_info_usr_id WHERE lns_is_done = 0 ORDER BY lns_created ASC LIMIT ".strval($start).",".strval($per_page);
      $result = mysqli_query($con, $query);
      mysqli_query($con, "UNLOCK TABLES");
      while ($row = mysqli_fetch_array($result))
      {
        $lns_app_id = $row['lns_app_id'];
        $lns_title = $row['lns_title'];
        $lns_usr_id = $row['lns_usr_id'];
        $act_info_nick = $row['act_info_nick'];
        $act_info_name = $row['act_info_name'];
        $lns_category = $row['lns_category'];
        $lns_amount = $row['lns_amount'];
        $lns_interest = $row['lns_interest'];
        $lns_interest_rate = $row['lns_interest_rate'];
        $lns_repayment_method = $row['lns_repayment_method'];
        $lns_duration = $row['lns_duration'];
        $lns_start = $row['lns_start'];
        $lns_end = $row['lns_end'];
        $lns_fine_rate = $row['lns_fine_rate'];
        $lns_fine_rate_is_single = $row['lns_fine_rate_is_single'];
        $lns_fine = $row['lns_fine'];
        $lns_created = $row['lns_created'];

        $json = $json.",{\"app_id\":".jsonstrval($lns_app_id).",\"title\":".jsonstr($lns_title).",\"user_id\":".jsonstrval($lns_usr_id).",\"nick\":".jsonstr($act_info_nick).",\"name\":".jsonstr($act_info_name).",\"category\":".jsonstrval($lns_category).",\"amount\":".jsonstrval($lns_amount).",\"interest\":".jsonstrval($lns_interest).",\"rate\":".jsonstrval($lns_interest_rate).",\"method\":".jsonstrval($lns_repayment_method).",\"duration\":".jsonstrval($lns_duration).",\"start\":".jsonstr($lns_start).",\"end\":".jsonstr($lns_end).",\"fine_rate\":".jsonstrval($lns_fine_rate).",\"fine_is_single\":".jsonstrval($lns_fine_rate_is_single).",\"fine\":".jsonstrval($lns_fine).",\"created\":".jsonstr($lns_created)."}";
      }
      mysqli_free_result($result);
      break;
    case 3: // finished
      mysqli_query($con, "LOCK TABLES loans_lns READ, account_info_act_info READ");
      if ($page == 1)
      {
        $query = "SELECT COUNT(lns_usr_id) AS cnt FROM loans_lns WHERE lns_is_done = 1";
        $result = mysqli_query($con, $query);
        if ($row = mysqli_fetch_array($result))
        {
          $total = $row['cnt'];
          mysqli_free_result($result);
        }
      }
      $start = ($page - 1) * $per_page;
      $query = "SELECT lns_app_id, lns_title, lns_usr_id, act_info_nick, act_info_name, lns_category, lns_amount, lns_interest, lns_interest_rate, lns_repayment_method, lns_duration, lns_start, lns_end, lns_fine_rate, lns_fine_rate_is_single, lns_finished, lns_fine, lns_created FROM loans_lns LEFT JOIN account_info_act_info ON lns_usr_id = act_info_usr_id WHERE lns_is_done = 1 ORDER BY lns_created DESC LIMIT ".strval($start).",".strval($per_page);
      $result = mysqli_query($con, $query);
      mysqli_query($con, "UNLOCK TABLES");
      while ($row = mysqli_fetch_array($result))
      {
        $lns_app_id = $row['lns_app_id'];
        $lns_title = $row['lns_title'];
        $lns_usr_id = $row['lns_usr_id'];
        $act_info_nick = $row['act_info_nick'];
        $act_info_name = $row['act_info_name'];
        $lns_category = $row['lns_category'];
        $lns_amount = $row['lns_amount'];
        $lns_interest = $row['lns_interest'];
        $lns_interest_rate = $row['lns_interest_rate'];
        $lns_repayment_method = $row['lns_repayment_method'];
        $lns_duration = $row['lns_duration'];
        $lns_start = $row['lns_start'];
        $lns_end = $row['lns_end'];
        $lns_fine_rate = $row['lns_fine_rate'];
        $lns_fine_rate_is_single = $row['lns_fine_rate_is_single'];
        $lns_finished = $row['lns_finished'];
        $lns_fine = $row['lns_fine'];
        $lns_created = $row['lns_created'];

        $json = $json.",{\"app_id\":".jsonstrval($lns_app_id).",\"title\":".jsonstr($lns_title).",\"user_id\":".jsonstrval($lns_usr_id).",\"nick\":".jsonstr($act_info_nick).",\"name\":".jsonstr($act_info_name).",\"category\":".jsonstrval($lns_category).",\"amount\":".jsonstrval($lns_amount).",\"interest\":".jsonstrval($lns_interest).",\"rate\":".jsonstrval($lns_interest_rate).",\"method\":".jsonstrval($lns_repayment_method).",\"duration\":".jsonstrval($lns_duration).",\"start\":".jsonstr($lns_start).",\"end\":".jsonstr($lns_end).",\"fine_rate\":".jsonstrval($lns_fine_rate).",\"fine_is_single\":".jsonstrval($lns_fine_rate_is_single).",\"finished\":".jsonstrval($lns_finished).",\"fine\":".jsonstrval($lns_fine).",\"created\":".jsonstr($lns_created)."}";
      }
      mysqli_free_result($result);
      break;
  }
  mysqli_kill($con, mysqli_thread_id($con));
  mysqli_close($con);

  $json = substr($json, 1);
  $json = "{\"total\":".jsonstrval($total).",\"loans\":[".$json."]}";
  echo $json;
}
?>