<?php
include "functions.php";
$action = $_POST["action"];

if (isset($_SESSION["user"]) && $_SESSION["user"] != "") $user = $_SESSION["user"];
else $user = "";

if($action == "init"){
  echo init();
}

if($action == "login"){
  if(isset($_POST["username"]) && isset($_POST["password"]))
    echo login($_POST["username"], $_POST["password"]);
}

if($action == "register"){
  if(isset($_POST["username"]) && isset($_POST["password"]) && isset($_POST["cpassword"]) && isset($_POST["address"]))
    echo register($_POST["username"], $_POST["password"], $_POST["cpassword"], $_POST["address"]);
}

if($action == "signout"){
  echo signout();
}

if($action == "loadRegion"){
  if(isset($_POST["region"]))
    echo loadRegion($_POST["region"]);
}

if($action == "updateRegion"){
  if(isset($_POST["region"]) && isset($_POST["selected"]))
    echo updateRegion($_POST["region"], $_POST["selected"]);
}

if($action == "updatePokemon"){
  if(isset($_POST["region"]) && isset($_POST["pokemon"]) && isset($_POST["selected"]))
    echo updatePokemon($_POST["region"], $_POST["pokemon"], $_POST["selected"]);
}

?>
