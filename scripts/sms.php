<?php
//ini_set("sendmail_from", "alert@mtupogo.com");
//ini_set("sendmail_path", "/usr/sbin/sendmail -t -i -f alert@mtupogo.com");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once ('constants.php');
require ('functions.php');

if(!isset($_GET["region"]) || !isset($_GET["pokemon"]) || !isset($_GET["msg"]) || !isset($_GET["key"]) || $_GET["key"] != SMSKEY){
  echo "INVALID";
  return;
}

$msg = $_GET["msg"];
$pokemon = $_GET["pokemon"];
$regionName = $_GET["region"];

$stmt = db_op("select code from regions where name = '$regionName'");
$row = $stmt->fetch_array(MYSQLI_ASSOC);
$region = $row["code"];

$recipients = "";

$stmt = db_op("select address from not_override where p$pokemon = 1");
while($row = $stmt->fetch_array(MYSQLI_ASSOC)){
  $recipients .= $row["address"] . ",";
}

$stmt = db_op("select address from not_$region where p$pokemon = 1");
echo "select address from not_$region where p$pokemon = 1";
while($row = $stmt->fetch_array(MYSQLI_ASSOC)){
  if(strpos($recipients, $row["address"]) !== false) continue;
  $recipients .= $row["address"] . ",";
}

if(strlen($recipients) > 0)
  sendMessage($recipients, $msg);

?>
