
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
    $last_id = $_POST['last_id'];

    $stmt = $conn->prepare('
        SELECT
            *
        FROM
            numberplates where id>:theid
        ORDER BY 
        id DESC
    ');

    // Bind the query params
    $stmt->bindParam(':theid', $last_id, PDO::PARAM_INT);
    $stmt->execute();

    // Do we have any results?
    if ($stmt->rowCount() > 0) {
        // Define how we want to fetch the results
        $allrec = $stmt->fetchAll(PDO::FETCH_ASSOC);
        

       echo(json_encode(['status_code'=> '200','data'=>$allrec]));
    } else {
        $response = ['status_code'=> '400', 'message'=>'Data Not Found', 'data'=> []];
        echo(json_encode($response));
    }
?>