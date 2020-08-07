<?php
$servername = "localhost";
$username = "transdua_cars";
$password = "WBuChjJrqApt59Z";

try {
  $conn = new PDO("mysql:host=$servername;dbname=transdua_cars", $username, $password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}

$_POST = json_decode(file_get_contents('php://input'), true);
$email = $_POST['email'];
if($email !=null){
	$sql= "UPDATE users SET status = 0 WHERE email = '{$email}'";
	$stmt = $conn->prepare($sql);
	$result = $stmt->execute();
	$response = ['status_code'=> '200', 'message'=>'Logged Out Successfully!', 'data'=> []];
	echo(json_encode($response));
	
}else{
	$response = ['status_code'=> '400', 'message'=>'Invaid Email!', 'data'=> []];
	echo(json_encode($response));
	exit;
}


?>