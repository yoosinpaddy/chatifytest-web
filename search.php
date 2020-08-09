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
$location= $_POST['location'];
$description = $_POST['description'];
if($search_value!=null){
  if($description!=null){
    if($location!=null){
      $sql="SELECT * FROM numberplates WHERE numberplate like '%$search_value%' AND location like '%$location%' AND description like '%$description%' order by create_date DESC";
      $stmt = $conn->prepare($sql);
      $result = $stmt->execute();
    }else{

    $sql="SELECT * FROM numberplates WHERE numberplate like '%$search_value%' AND description like '%$description%'  order by create_date DESC";
    $stmt = $conn->prepare($sql);
    $result = $stmt->execute();
    }
  }else{
  $sql="SELECT * FROM numberplates WHERE numberplate like '%$search_value%'  order by create_date DESC";
  $stmt = $conn->prepare($sql);
  $result = $stmt->execute();
  }
  
}else if($description!=null){
  if($location!=null){
    $sql="SELECT * FROM numberplates WHERE location like '%$location%' AND description like '%$description%'  order by create_date DESC";
    $stmt = $conn->prepare($sql);
    $result = $stmt->execute();
  }else{
    $sql="SELECT * FROM numberplates WHERE description like '%$description%'  order by create_date DESC";
    $stmt = $conn->prepare($sql);
    $result = $stmt->execute();
  }
}else if($location!=null){
  $sql="SELECT * FROM numberplates WHERE location like '%$location%' AND description like '%$description%'  order by create_date DESC";
  $stmt = $conn->prepare($sql);
  $result = $stmt->execute();
} 

// if($description !=null){
//   $sql="SELECT * FROM numberplates WHERE description like '$description%' ";
//   $stmt = $conn->prepare($sql);
//   $result = $stmt->execute();
// }
// if($search_value!=null){
//   $countRecord =  "SELECT * FROM `numberplates` WHERE numberplate like '%$search_value%' "; 
//   $stmt = $conn->prepare($countRecord); 
//   $result=$stmt->execute(); 
  
  
// }


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