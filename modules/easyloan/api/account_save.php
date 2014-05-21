<?php

include_once 'util_global.php';

$bankStr = $_GET["bank"];
$bank = str2int($bankStr);
if ($bank < 0 || $bank > 4)
{
  echo "{\"result\":0}";
  exit;
}
$amountStr = $_GET["amount"];
$amount = str2float($amountStr);
if ($amount <= 0)
{
  echo "{\"result\":0}";
  exit;
}
$feeStr = $_GET["fee"];
$fee = str2float($feeStr);
if ($fee < 0 || $fee != compute_saving_fee($amount))
{
  echo "{\"result\":0}";
  exit;
}
// check current time between 9am - 11pm
if (!is_now_valid($time_user_start, $time_user_end))
{
  echo "{\"result\":0}";
  exit;
}
if ($user->uid <= 0)
{
  echo "{\"result\":0}";
  exit;
}
$usr_id = $user->uid;

echo "{\"result\":1}";
?>