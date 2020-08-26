
<?php
$servername = "localhost";
$username = "transdua_cars";
$password = "WBuChjJrqApt59Z";

try {
    $conn = new PDO("mysql:host=$servername;dbname=transdua_cars", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
// echo "yes";
$_POST = json_decode(file_get_contents('php://input'), true);
$email = $_POST['email'];
$carNo = $_POST['carNo'];
$comment = $_POST['comment'];
$getUserData = "INSERT INTO `comments` (`id`, `car_id`, `comment`, `user_email`, `time`) VALUES ('', '{$carNo}', '{$comment}', '{$email}', CURRENT_TIMESTAMP) ";

// echo "yes2";

if (!empty($comment)) {
echo "yes3";
    $stmt = $conn->prepare($getUserData);
    $result = $stmt->execute();
    $response = ['status_code' => '200', 'message' => 'Comment added!', 'data' => []];
    echo (json_encode($response));
    exit;
} else  {
echo "yes4";
    $sql = "SELECT * FROM `comments` where car_id ='$carNo' order by id DESC";


    $stmt = $conn->prepare($sql);

    $result = $stmt->execute();

    if (!empty($result)) {
echo "yes5";
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $records[] = $row;
        }


        if ($records != null) {
echo "yes6";
            $response = ['status_code' => '200', 'message' => 'Comment Result', 'data' => $records];
            echo (json_encode($response));
        } else {
echo "yes7";
            $response = ['status_code' => '400', 'message' => 'Data Comments Found', 'data' => []];
            echo (json_encode($response));
            exit;
        }
    }else{
echo "yes8";
        $response = ['status_code' => '400', 'message' => 'Data Comments Found', 'data' => []];
        echo (json_encode($response));
        exit;

    }
}
?>