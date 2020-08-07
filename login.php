
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

$password = $_POST['password'];
$hashed  =md5($password);
$getUserData = "SELECT * FROM users WHERE (email = '{$email}'  ) AND password='{$hashed}' ";

$stmt = $conn->prepare($getUserData);

$result1 = $stmt->execute();
$usersData = $stmt->fetchAll();
$userEmail = $usersData[0]['email'];

if(empty($userEmail) ){
	
	$response = ['status_code'=> '400', 'message'=>'User Not Existed!', 'data'=> []];
	echo(json_encode($response));
	exit;
}
if($userEmail){

	$chkloggedIn = "SELECT * FROM users WHERE status=1 AND email='{$userEmail}'";

	$stmt = $conn->prepare($chkloggedIn);
	$result = $stmt->execute();
	$usersData1 = $stmt->fetchAll();

	$userEmail1 = $usersData1[0]['email'];

	if($userEmail1 !=null){
		$response = ['status_code'=> '400', 'message'=>'User is Already Logged In.', 'data'=> []];
		echo(json_encode($response));
	}else{

		$token = sha1(time());
		$sql = "UPDATE users SET token ='{$token}',status = '1' WHERE id = ".$usersData[0]['id']."";
		$stmt = $conn->prepare($sql);
		$result = $stmt->execute();

		$response = ['status_code'=> '200', 'message'=>'Logged in!', 'useremail'=>$usersData[0]['email'],'userpassword'=>$usersData[0]['password'] ];
		echo(json_encode($response));
	}
	
}
?>