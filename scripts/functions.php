<?php
require_once ('constants.php');
require_once ('connect.php');
ini_set("log_errors", 1);
ini_set('display_errors', '1');
error_reporting(E_ALL);

session_start();

function init(){
  //if(true){
  if(isset($_SESSION["user"]) && strlen($_SESSION["user"]) > 0){
    $regions = "";
    $stmt = db_op("select * from regions");
    while($row = $stmt->fetch_array(MYSQLI_ASSOC)){
      $regions .= "<li><a class='region' id=" . $row["code"] . " href='region.php#" . $row["code"] . "'>" . $row["name"] . "</a></li>";
    }

    return json_encode(array("regions" => $regions));
  }else{

    $login = "
    <div class='container'>
        	<div class='row'>
    			<div class='col-md-6 col-md-offset-3'>
    				<div class='panel panel-login'>
    					<div class='panel-heading'>
    						<div class='row'>
    							<div class='col-xs-6'>
    								<a href='#' class='active' id='login-form-link'>Login</a>
    							</div>
    							<div class='col-xs-6'>
    								<a href='#' id='register-form-link'>Register</a>
    							</div>
    						</div>
    						<hr>
    					</div>
    					<div class='panel-body'>
    						<div class='row'>
    							<div class='col-lg-12'>
    								<div id='login' style='display: block;'>
    									<div class='form-group'>
    										<input type='text' name='username' id='username-l' tabindex='1' class='form-control' placeholder='Username' value=''>
    									</div>
    									<div class='form-group'>
    										<input type='password' name='password' id='password-l' tabindex='2' class='form-control' placeholder='Password'>
    									</div>
    									<div class='form-group text-center'>
    										<input type='checkbox' tabindex='3' class='' name='remember' id='remember'>
    										<label for='remember'> Remember Me</label>
    									</div>
    									<div class='form-group'>
    										<div class='row'>
    											<div class='col-sm-6 col-sm-offset-3'>
    												<input type='submit' name='login-submit' id='login-submit' tabindex='4' class='form-control btn btn-login' value='Log In'>
    											</div>
    										</div>
    									</div>
    									<div class='form-group'>
    										<div class='row'>
    											<div class='col-lg-12'>
    												<div class='text-center'>
    													<a href='http://phpoll.com/recover' tabindex='5' class='forgot-password'>Forgot Password?</a>
    												</div>
    											</div>
    										</div>
    									</div>
    								</div>
    								<div id='register' style='display: none;'>
    									<div class='form-group'>
    										<input type='text' name='username' id='username-r' tabindex='1' class='form-control' placeholder='Username' value=''>
    									</div>
    									<div class='form-group'>
    										<input type='password' name='password' id='password-r' tabindex='2' class='form-control' placeholder='Password'>
    									</div>
    									<div class='form-group'>
    										<input type='password' name='confirm-password' id='confirm-password-r' tabindex='2' class='form-control' placeholder='Confirm Password'>
    									</div>
    									<div class='form-group'>
    										<input type='email' name='address' id='address-r' tabindex='3' class='form-control' placeholder='Contact Address' value=''>
    									</div>
    									<div class='form-group'>
    										<div class='row'>
    											<div class='col-sm-6 col-sm-offset-3'>
    												<input type='submit' name='register-submit' id='register-submit' tabindex='4' class='form-control btn btn-register' value='Register Now'>
    											</div>
    										</div>
    									</div>
    								</div>
    							</div>
    						</div>
    					</div>
    				</div>
    			</div>
    		</div>
    	</div>

    ";

    return json_encode(array("login" => $login));
  }
}

function login($username, $pass){
  $username = preg_replace('/[^\w]/', '', $username);
  $pass = preg_replace('/[^\w]/', '', $pass);
  $stmt = db_op("select * from users where username = '$username' and pass = '$pass'");
  if($stmt->num_rows != 1){
    return json_encode(array("error"=>"Invalid username or password."));
  }

  $_SESSION["user"] = $username;
  return json_encode(array());
}

function register($username, $pass, $cpass, $address){
  $error = "";

  if(!ctype_alnum($username)){
    $error .= "Only alphanumerics are allowed for usernames.\n";
  }
  if(!ctype_alnum($pass)){
    $error .= "Only alphanumerics are allowed for usernames.\n";
  }
  if(strlen($username) <= 5){
    $error .= "Please enter a username longer than 5 characters.\n";
  }
  if(strlen($pass) <= 5){
    $error .= "Please enter a password longer than 5 characters.\n";
  }
  if($pass != $cpass){
    $error .= "The entered passwords are not identical.\n";
  }

  $stmt = db_op("select * from users where username = '$username'");
  if($stmt->num_rows > 0){
    $error .= "This username is already in use.\n";
  }
  $stmt = db_op("select * from users where address = '$address'");
  if($stmt->num_rows > 0 && strlen($address) != 0){
    $error .= "This address is already in use.\n";
  }

  if(!filter_var($address, FILTER_VALIDATE_EMAIL) || strlen($address) == 0){
    $error .= "The address supplied is not valid.\n";
  }

  if(strlen($error) > 0){
    return json_encode(array("error"=>$error));
  }else{
    $stmt = db_op("insert into users(username, pass, address, verification_code) values('$username', '$pass', '$address', '" . getVerificationCode() . "')");
    db_op("insert into notifications(address) values('$address');");

    $stmt = db_op("select * from regions");
    while($row = $stmt->fetch_array(MYSQLI_ASSOC)){
      db_op("insert into not_" . $row["code"] . "(address) values('$address');");
    }
    return json_encode(array());
  }
}

function signout(){
  session_destroy();
}

function loadRegion($region){

}

function db_op($query){
  $dbConn = db_connect();
  $stmt = $dbConn->query($query);
  return $stmt;
}

function getVerificationCode(){
	$characters = "0123456789abcdefghijklmnopqrstuvwxyz";
	$ret = "";
	for ($i = 0; $i < 6; $i++) {
		$ret .= $characters[rand(0, strlen($characters) - 1)];
	}
	return $ret;
}

?>
