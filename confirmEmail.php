
<?php
require "paddymailer/src/PHPMailer.php";
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

	

  //  $mail_body = "
  //  <p>Hi ,</p>
  //  <p>User ".$userEmail.", has requested for password reset</p>
  //  ";
  //  require 'class/class.phpmailer.php';
  //  $mail = new PHPMailer;
  //  $mail->IsSMTP();        //Sets Mailer to send message using SMTP
  //  $mail->Host = 'mail.itsmywriter.com';  //Sets the SMTP hosts of your Email hosting, this for Godaddy
  //  $mail->Port = '80';        //Sets the default SMTP server port
  //  $mail->SMTPAuth = true;       //Sets SMTP authentication. Utilizes the Username and Password variables
  //  $mail->Username = 'support@itsmywriter.com';     //Sets SMTP username
  //  $mail->Password = '2Q^yp3X]i!_H';     //Sets SMTP password
  //  $mail->SMTPSecure = '';       //Sets connection prefix. Options are "", "ssl" or "tls"
  //  $mail->From = 'info@itsmywriter.com';   //Sets the From email address for the message
  //  $mail->FromName = 'Webslesson';     //Sets the From name of the message
  //  $mail->AddAddress('paddykiprop@gmail.com');  //Adds a "To" address      
  //  $mail->To='paddykiprop@gmail.com';  //Adds a "To" address   

  //  $mail->WordWrap = 50;       //Sets word wrapping on the body of the message to a given number of characters
  //  $mail->IsHTML(true);       //Sets message type to HTML    
  //  $mail->Subject = 'Email Verification';   //Sets the Subject of the message
  //  $mail->Body = $mail_body;       //An HTML or plain text message body

  // $to = $userEmail;
  // $subject = "Password recovery";
  
  // $message = "<b>Here is your token.</b>";
  // $message .= "<b>This is headline.</b>";
  
  // $header = "From:info@itsmywriter.com \r\n";
  // $header .= "MIME-Version: 1.0\r\n";
  // $header .= "Content-type: text/html\r\n";
  
  // $retval = mail ($to,$subject,$message,$header);
  // if($retval){
  //   $response = ['status_code'=> '200', 'message'=>'Email sent, check email for verification code', 'useremail'=>$usersData[0]['email'],'userpassword'=>$usersData[0]['password'] ];
  //   echo(json_encode($response));
  // }else{       
  //   $response = ['status_code'=> '400', 'message'=>'Coulnt send email', 'useremail'=>$usersData[0]['email'],'userpassword'=>$usersData[0]['password'] ];
  //   echo(json_encode($response));
  // }

$mail = new PHPMailer; //$mail->SMTPDebug = 3;      // Enable verbose debug output
$mail->isSMTP();     // Set mailer to use SMTP
$mail->Host = ‘mail.example.com;servername.truehost.cloud’;  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;   // Enable SMTP authentication
$mail->Username = ‘support@itsmywriter.com’;     // SMTP username
$mail->Password = 2Q^yp3X]i!_H;              // SMTP password
$mail->SMTPSecure = ‘tls’;        // Enable TLS encryption, `ssl` also accepted
$mail->Port = 587;      // TCP port to connect to or 25 for non secure
$mail->setFrom('support@itsmywriter.com', ‘Mailer’);
$mail->addAddress($userEmail);     // Add a recipient
// $mail->addAddress(‘ellen@example.com’);               // Name is optional
// $mail->addReplyTo(‘info@example.com’, ‘Information’);
// $mail->addCC(‘cc@example.com’);
// $mail->addBCC(‘bcc@example.com’);
// $mail->addAttachment(‘/var/tmp/file.tar.gz’);         // Add attachments
// $mail->addAttachment(‘/tmp/image.jpg’, ‘new.jpg’);    // Optional name
$mail->isHTML(true);            // Set email format to HTML
$mail->Subject = ‘Here is the subject’;
$mail->Body    = ‘This is the HTML message body <b>in bold!</b>’;
$mail->AltBody = ‘This is the body in plain text for non-HTML mail clients’;
// if(!$mail->send()) {    echo ‘Message could not be sent.’;    echo ‘Mailer Error: ‘ .
// $mail->ErrorInfo;} else {    echo ‘Message has been sent’;}
// }
if($mail->send())
    $response = ['status_code'=> '200', 'message'=>'Email sent, check email for verification code', 'useremail'=>$usersData[0]['email'],'userpassword'=>$usersData[0]['password'] ];
    echo(json_encode($response));
  }else{       
    $response = ['status_code'=> '400', 'message'=>'Coulnt send email'.$mail->ErrorInfo, 'useremail'=>$usersData[0]['email'],'userpassword'=>$usersData[0]['password'] ];
    echo(json_encode($response));
  }

?>
