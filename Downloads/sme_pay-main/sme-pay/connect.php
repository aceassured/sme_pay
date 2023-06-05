<?php

header('Content-Type: application/json; charset=utf-8');

$servername = "localhost";
$username = "smepay";
$password = "avgOniU0NfhL";
$database = "smepay";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $database);

if($_SERVER['REQUEST_METHOD'] == 'GET'){
    $sql = "SELECT * FROM responses WHERE created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)";
    $result = mysqli_query($conn, $sql);
    
    $rows = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }

    echo json_encode($rows);
}

?>