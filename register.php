
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
$getUserData = "SELECT * FROM users WHERE email = '{$email}'";

$stmt = $conn->prepare($getUserData);

$result = $stmt->execute();
$usersData = $stmt->fetchAll();
$userEmail = $usersData[0]['email'];

if(!empty($userEmail) ){
  $response = ['status_code'=> '400', 'message'=>'User Already Existed!', 'data'=> []];
  echo(json_encode($response));
  exit;
}else{
 $_POST = json_decode(file_get_contents('php://input'), true);
  
 
  $email = $_POST['email'];
  $password = $_POST['password'];
  $cell = $_POST['cellno'];
  $hashed_password = md5($password);
  $sql = "INSERT INTO users ( email,cellno, password)
  VALUES ( :email,:cellno, :password)";
  $arrya  = array('email'=>$email,'cellno'=>$cell,'password' => $hashed_password);
  // use exec() because no results are returned
  $stmt = $conn->prepare($sql);
  $result = $stmt->execute($arrya);
  $response = ['status_code'=> '200', 'message'=>'Data Inserted Successfully!', 'data'=> $result];
  echo(json_encode($response));
  exit;
}

?>