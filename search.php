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
$search_value= $_POST['numberplate'];
$description = $_POST['description'];
if($search_value!=null){
  $sql="SELECT * FROM numberplates WHERE numberplate like '%$search_value' ";
  $stmt = $conn->prepare($sql);
  $result = $stmt->execute();
}
if($search_value!=null && $description!=null){
  $sql="SELECT * FROM numberplates WHERE numberplate like '%$search_value' AND description like '%$description%' ";
  $stmt = $conn->prepare($sql);
  $result = $stmt->execute();
}

if($description !=null){
  $sql="SELECT * FROM numberplates WHERE description like '$description%' ";
  $stmt = $conn->prepare($sql);
  $result = $stmt->execute();
}
if($search_value!=null){
  $countRecord =  "SELECT * FROM `numberplates` WHERE numberplate like '%$search_value%' "; 
  $stmt = $conn->prepare($countRecord); 
  $result=$stmt->execute(); 
  
  
}


//$usersData = $stmt->fetchAll();

if(!empty($result)) {
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $records[] = $row;
  }	
    
     
      
    if($records!=null){
    	$response = ['status_code'=> '200', 'message'=>'Search Result', 'data'=> $records];
  		echo(json_encode($response));
    }else{
    	$response = ['status_code'=> '400', 'message'=>'Data Not Found', 'data'=> []];
  		echo(json_encode($response));
  		exit;
    }
 
  
}
?>