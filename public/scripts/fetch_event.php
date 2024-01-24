<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'crud-app';



// Create connection
$connection = new mysqli($servername, $username, $password, $dbname, 3306);

// Check connection
if ($connection->connect_error) {
    header('HTTP/1.1 500 Internal Server Error');
    echo json_encode(['error' => 'Failed to connect to the database']);
    exit;
}


$query = "SELECT eventName, dateStart, dateEnd, timeStart, timeEnd, venue, description FROM events";
$result = $connection->query($query);

if (!$result) {
    header('HTTP/1.1 500 Internal Server Error');
    echo json_encode(['error' => 'Failed to execute the query']);
    exit;
}

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

$connection->close();




header('Content-Type: application/json');
echo json_encode($data);
?>
