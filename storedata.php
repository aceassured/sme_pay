<?php
include "connect.php";

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    // Taking all 5 values from the form data(input)
    $json = file_get_contents('php://input');


    // Converts it into a PHP object
    $data = json_decode($json);

    $store_id = '';
    $first_name = $data->first_name;
    $last_name = $data->last_name;
    $invoice = $data->invoice;
    $amount = (float)$data->amount;
    $company = $data->company;
    $comments = $data->comments;
    $ticket = $data->ticket;
    $reference_no = $data->reference_no;
    $status = $data->status;
    
    $created_at = date('Y-m-d H:i:s', time());
    

  // Prepare the insert query with placeholders
    $sql = "INSERT INTO `responses`(`first_name`, `last_name`, `company`, `invoice_no`, `amount`, `comments`, `ticket_no`, `reference_no`, `status`, `created_at`) VALUES('$first_name', '$last_name', '$company', '$invoice', '$amount', '$comments', '$ticket', '$reference_no', '$status', '$created_at')";
    $result = $conn->query($sql);

    echo json_encode($data);
}


?>