<?php
include "functions.php";
$action = $_POST["action"];

if($action == "login"){
  if($_POST["pass"] == "0401"){
    session_start();
    $_SESSION["user"] = "b";
    echo init();
  }else if($_POST["pass"] == "4958"){
    session_start();
    $_SESSION["user"] = "j";
    echo init();
  }else
    echo json_encode(array());
}

if($action == "edit"){
  echo edit($_POST["id"], $_POST["col"], $_POST["val"]);
}

if($action == "add"){
  if($_POST["question"] == "test") echo json_encode(array("return"=>loadTable()));
  else echo add($_POST["date"], $_POST["asker"], $_POST["question"], $_POST["banswer"], $_POST["janswer"]);
}

if($action == "refresh"){
  echo loadTable();
}

?>
