<?php
require 'sendmail.php';
$servername = "localhost";
$username = "transdua_cars";
$password = "WBuChjJrqApt59Z";

try {
  $conn = new PDO("mysql:host=$servername;dbname=transdua_cars", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}
 $_POST = json_decode(file_get_contents('php://input'), true);
$email = $_POST['email'];

$getUserData = "SELECT * FROM users WHERE (email = '{$email}'  )  ";

$stmt = $conn->prepare($getUserData);

$result1 = $stmt->execute();
$usersData = $stmt->fetchAll();
$userEmail = $usersData[0]['email'];
$userpass = $usersData[0]['password'];

if(empty($userEmail) ){
	
	$response = ['status_code'=> '400', 'message'=>'User Not Existed!', 'data'=> []];
	echo(json_encode($response));
	exit;
}
if($userEmail){
  // echo "llll";

$message="Your secrete word is :".$usersData[0]['password'];
send_users_email($userEmail,$message,":sub",$usersData);
}
?>
