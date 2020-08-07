
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

	

   $mail_body = "
   <p>Hi ,</p>
   <p>User ".$userEmail.", has requested for password reset</p>
   ";
   require 'class/class.phpmailer.php';
   $mail = new PHPMailer;
   $mail->IsSMTP();        //Sets Mailer to send message using SMTP
   $mail->Host = 'mail.itsmywriter.com';  //Sets the SMTP hosts of your Email hosting, this for Godaddy
   $mail->Port = '80';        //Sets the default SMTP server port
   $mail->SMTPAuth = true;       //Sets SMTP authentication. Utilizes the Username and Password variables
   $mail->Username = 'support@itsmywriter.com';     //Sets SMTP username
   $mail->Password = '2Q^yp3X]i!_H';     //Sets SMTP password
   $mail->SMTPSecure = '';       //Sets connection prefix. Options are "", "ssl" or "tls"
   $mail->From = 'info@itsmywriter.com';   //Sets the From email address for the message
   $mail->FromName = 'Webslesson';     //Sets the From name of the message
   $mail->AddAddress('paddykiprop@gmail.com');  //Adds a "To" address      
   $mail->To='paddykiprop@gmail.com';  //Adds a "To" address   

   $mail->WordWrap = 50;       //Sets word wrapping on the body of the message to a given number of characters
   $mail->IsHTML(true);       //Sets message type to HTML    
   $mail->Subject = 'Email Verification';   //Sets the Subject of the message
   $mail->Body = $mail_body;       //An HTML or plain text message body
   if($mail->Send())        //Send an Email. Return true on success or false on error
   {

    $response = ['status_code'=> '200', 'message'=>'Email sent, check email for verification code', 'useremail'=>$usersData[0]['email'],'userpassword'=>$usersData[0]['password'] ];
    echo(json_encode($response));
   }else{
       
    $response = ['status_code'=> '400', 'message'=>'Coulnt send email', 'useremail'=>$usersData[0]['email'],'userpassword'=>$usersData[0]['password'] ];
    echo(json_encode($response));
   }
}
?>
