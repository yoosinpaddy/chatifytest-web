
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
 $total = $conn->query('
        SELECT
            COUNT(*)
        FROM
            numberplates
    ')->fetchColumn();
    
    $limit = 10;

    // How many pages will there be
    $pages = ceil($total / $limit);
    $_POST = json_decode(file_get_contents('php://input'), true);
    // What page are we currently on?
    $page = $_POST['page'];

    // Calculate the offset for the query
    $offset = ($page - 1)  * $limit;

    // Some information to display to the user
    $start = $offset + 1;
    $end = min(($offset + $limit), $total);
    $stmt = $conn->prepare('
        SELECT
            *
        FROM
            numberplates
        ORDER BY 
        id DESC
        LIMIT
            :limit
        OFFSET
            :offset
    ');

    // Bind the query params
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();

    // Do we have any results?
    if ($stmt->rowCount() > 0) {
        // Define how we want to fetch the results
        $allrec = $stmt->fetchAll(PDO::FETCH_ASSOC);
        

       echo(json_encode(['status_code'=> '200','records'=>$allrec,'pages'=>$pages]));
    } else {
        $response = ['status_code'=> '400', 'message'=>'Data Not Found', 'data'=> []];
        echo(json_encode($response));
    }
?>