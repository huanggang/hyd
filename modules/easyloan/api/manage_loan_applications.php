<?php

function manage_loan_applications(){

  include_once 'util_hyd_log.php';

  if ($user->uid <= 0)
  {
    echo "{\"result\":0}";
    exit;
  }
  $usr_id = $user->uid;

  if (!is_auditor($user) && !is_administrator($user))
  {
    echo "{\"result\":0}";
    exit;
  }

  $now = new DateTime;

  $app_id = null; $status = null; $comment = null;
  $type = null; $page = null;

  $method = $_SERVER['REQUEST_METHOD'];
  if ($method == 'POST')
  {
    $app_id = str2int($_POST['app_id']);
    if ($app_id <= 0)
    {
      echo "{\"result\":0}";
      exit;
    }
    $status = str2int($_POST['status']);
    if ($status <= 0 || $status > 6)
    {
      echo "{\"result\":0}";
      exit;
    }
    $comment = strip_tags($_POST['comment']);
  }
  else // GET
  {
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
  }

  if ($method == 'POST')
  {
    hyd_log($now, $usr_id, "借款申请审核", "申请编号, 状态, 备注", "app_id=".strval($app_id)."&status=".strval($status)."&comment=".$comment);
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
  switch ($method)
  {
    case 'POST':
      $is_done = 0;
      $is_loaned = null;
      $query = "UPDATE applications_app SET app_status = ?, app_comment = ?, app_mng_usr_id = ?, app_is_done = ?, app_is_loaned = ? WHERE app_id = ? AND (app_is_done = 0 OR app_is_done IS NULL)";
      if ($stmt = mysqli_prepare($con, $query))
      {
        if ($status == 5)
        {
        	$is_done = 1;
        	$is_loaned = 0;
        }
        else if ($status == 6)
        {
          $is_done = 1;
        }
        mysqli_stmt_bind_param($stmt, "isiiii", $status, $comment, $usr_id, $is_done, $is_loaned, $app_id);

        mysqli_query($con, "LOCK TABLES applications_app WRITE");
        $flag = mysqli_stmt_execute($stmt);
        mysqli_query($con, "UNLOCK TABLES");
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
      break;
    default: // GET
      mysqli_query($con, "LOCK TABLES applications_app READ, account_info_act_info READ");
      $total = 0;
      if ($page == 1)
      {
        $query = "SELECT COUNT(app_id) AS cnt FROM applications_app WHERE app_is_done = ";
        switch ($type)
        {
          case 2: // done
            $query = $query."1";
            break;
          case 1: // doing
            $query = $query."0 OR app_is_done IS NULL";
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
      $query = "SELECT app_id, app_is_done, app_is_loaned, app_title, app_usr_id, act_info_nick, act_info_name, app_category, app_amount, app_duration, app_status, app_applied, app_comment FROM applications_app LEFT JOIN account_info_act_info ON app_usr_id = act_info_usr_id WHERE app_is_done = ";
      switch ($type)
      {
        case 2: // done
          $query = $query."1 ORDER BY app_applied DESC";
          break;
        default: // doing
          $query = $query."0 OR app_is_done IS NULL ORDER BY app_applied ASC";
          break;
      }
      $query = $query." LIMIT ".strval($start).",".strval($per_page);
      $result = mysqli_query($con, $query);
      mysqli_query($con, "UNLOCK TABLES");
      while ($row = mysqli_fetch_array($result))
      {
        $app_id = $row['app_id'];
        $app_is_done = $row['app_is_done'];
        $app_is_loaned = $row['app_is_loaned'];
        $app_title = $row['app_title'];
        $app_usr_id = $row['app_usr_id'];
        $act_info_nick = $row['act_info_nick'];
        $act_info_name = $row['act_info_name'];
        $app_category = $row['app_category'];
        $app_amount = $row['app_amount'];
        $app_duration = $row['app_duration'];
        $app_status = $row['app_status'];
        $app_applied = $row['app_applied'];
        $app_comment = $row['app_comment'];

        if (!is_accountant($user) && !is_manager($user) && !is_administrator($user))
        {
          $app_usr_id = null;
        }

        $json = $json.",{\"app_id\":".jsonstrval($app_id).",\"is_done\":".jsonstrval($app_is_done).",\"is_loaned\":".jsonstrval($app_is_loaned).",\"title\":".jsonstr($app_title).",\"user_id\":".jsonstrval($app_usr_id).",\"nick\":".jsonstr($act_info_nick).",\"name\":".jsonstr($act_info_name).",\"category\":".jsonstrval($app_category).",\"amount\":".jsonstrval($app_amount).",\"duration\":".jsonstrval($app_duration).",\"status\":".jsonstrval($app_status).",\"applied\":".jsonstr($app_applied).",\"comment\":".jsonstr($app_comment)."}";
      }
      mysqli_free_result($result);

      $json = substr($json, 1);
      $json = "{\"total\":".jsonstrval($total).",\"applications\":[".$json."]}";
      break;
  }

  mysqli_kill($con, mysqli_thread_id($con));
  mysqli_close($con);

  echo $json;
}
?>