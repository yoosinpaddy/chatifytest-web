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
$phone = $_POST['phone'];
$getUserData = "SELECT * FROM blocked_user WHERE phone = '{$phone}'";

$stmt = $conn->prepare($getUserData);

$result = $stmt->execute();
$usersData = $stmt->fetchAll();
$userPhone = $usersData[0]['phone'];

if(!empty($userPhone) ){
  $response = ['status_code'=> '400', 'message'=>'User is bocked', 'data'=> []];
  echo(json_encode($response));
  exit;
}else{
    $response = ['status_code'=> '200', 'message'=>'User i not bocked', 'data'=> []];
    echo(json_encode($response));
    exit;

}
// // Database Structure
// CREATE TABLE 'blocked_user' (
// 'phone' text NOT NULL,
// ) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1
