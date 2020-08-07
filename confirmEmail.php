<?php
require 'paddymailer/src/Exception.php';
require 'paddymailer/src/PHPMailer.php';
require 'paddymailer/src/SMTP.php';
require 'sendmail.php';
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
$servername = "localhost";
$username = "transdua_cars";
$password = "WBuChjJrqApt59Z";

try {
  $conn = new PDO("mysql:host=$servername;dbname=transdua_cars", $username, $password);
  // set the PDO error mode to exception
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
  // echo "llll";


$mail = new PHPMailer\PHPMailer\PHPMailer(); //$mail->SMTPDebug = 3;      // Enable verbose debug output
$mail->isSMTP();     // Set mailer to use SMTP
$mail->Host = "mail.itsmywriter.com";  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;   // Enable SMTP authentication
$mail->Username = 'support@itsmywriter.com';     // SMTP username
$mail->Password = '2Q^yp3X]i!_H';              // SMTP password
$mail->SMTPSecure = 'tls';        // Enable TLS encryption, `ssl` also accepted
$mail->Port = 465;      // TCP port to connect to or 25 for non secure
$mail->setFrom('support@itsmywriter.com', 'Its my writer');
$mail->addAddress($userEmail);     // Add a recipient
// $mail->addAddress('ellen@example.com');               // Name is optional
// $mail->addReplyTo('info@example.com', 'Information');
// $mail->addCC('cc@example.com');
// $mail->addBCC('bcc@example.com');
// $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
// $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
$mail->isHTML(true);            // Set email format to HTML
$mail->Subject = 'Here is the subject';
$mail->Body    = 'This is the HTML message body <b>in bold!</b>';
$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
// if(!$mail->send()) {    echo 'Message could not be sent.';    echo 'Mailer Error: ' .
// $mail->ErrorInfo;} else {    echo 'Message has been sent';}
// }
// echo "sada";
send_users_email($userEmail,"tester",":sub");
if($mail->send()){
    $response = ['status_code'=> '200', 'message'=>'Email sent, check email for verification code', 'useremail'=>$usersData[0]['email'],'userpassword'=>$usersData[0]['password'] ];
    // echo $response;
    echo(json_encode($response));
  }else{       
    $response = ['status_code'=> '400', 'message'=>'Couln t send email c'.$mail->ErrorInfo, 'useremail'=>$usersData[0]['email'],'userpassword'=>$usersData[0]['password'] ];
    echo(json_encode($response));
  }
}
?>
