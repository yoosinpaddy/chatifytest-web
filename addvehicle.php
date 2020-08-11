
<?php
$servername = "localhost";
$username = "transdua_cars";
$password = "WBuChjJrqApt59Z";
//transdua_cars
//WBuChjJrqApt59Z
try {
  $conn = new PDO("mysql:host=$servername;dbname=transdua_cars", $username, $password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}


  $numberplate = $_REQUEST['numberplate'];
  $location = $_REQUEST['location'];
  $description = $_REQUEST['description'];
  $useremail = $_REQUEST['useremail'];
  $target_dir="uploads/";
  $target_file = $target_dir . basename($_FILES['image']['name']);

  if(move_uploaded_file($_FILES['image']['tmp_name'], $target_file)){
    
    $imglink= basename($_FILES['image']['name']);
    
  }
  $mylog="user ".$useremail." has submited car plate no ".$numberplate." in location ".$location." with the desctiption: ".$description;
 $sql = "INSERT INTO numberplates (numberplate, location,description,image,useremail,logs)
    VALUES (:numberplate, :location,:description,:image,:useremail,:logs)";
    $arrya  = array('numberplate' => $numberplate,'location'=>$location,'description'=>$description,'image'=>$imglink ,'useremail'=>$useremail,'logs'=>$mylog );

  // use exec() because no results are returned
  $stmt = $conn->prepare($sql);
  $result = $stmt->execute($arrya);
  $response = ['status_code'=> '200', 'message'=>'Data Inserted Successfully!', 'data'=> $result];
  echo(json_encode($response));

?>