<?php
include "functions.php";
$action = $_POST["action"];

if (isset($_SESSION["user"]) && $_SESSION["user"] != "") $user = $_SESSION["user"];
else $user = "";

if($action == "init"){
  echo init();
}

if($action == "login"){
  //echo json_encode(array("error"=>$_POST["username"] . " " . $_POST["password"]));
  if(isset($_POST["username"]) && isset($_POST["password"]))
    echo login($_POST["username"], $_POST["password"]);
}

if($action == "register"){
  //echo json_encode(array("error"=>$_POST["username"] . " " . $_POST["password"] . " " . $_POST["cpassword"] . " " . $_POST["address"]));
  if(isset($_POST["username"]) && isset($_POST["password"]) && isset($_POST["cpassword"]) && isset($_POST["address"]))
    echo register($_POST["username"], $_POST["password"], $_POST["cpassword"], $_POST["address"]);
}

if($action == "signout"){
  echo signout();
}


?>
