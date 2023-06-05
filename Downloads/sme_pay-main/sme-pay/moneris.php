<?php
require 'vendor/autoload.php';

// Include CORS headers
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: X-Requested-With');
header('Content-Type: application/json');
header('Content-Type: application/json; charset=utf-8');



class Moneris
{
    # for testing/development
    #private $storeId = "monca07650";
    #private $api_token = "iiMZQ5lraAj4UbOVM3MY";
    #private $checkout_id = "chktUU2U707650";

    #private $enviroment = "qa";
    #private $preloadBaseUrl = "https://gatewayt.moneris.com/chktv2/request/request.php";
    #private $receiptBaseUrl = "https://gatewayt.moneris.com/chkt/request/request.php";

    ## for production, uncomment below lines and comments above points
    private $storeId = "gwca057558";
    private $api_token = "sSFESvSIglas0ywAAu5S";
    private $checkout_id = "chktLLG8S57558";
    
    private $enviroment = "prod"; 
    private $preloadBaseUrl = "https://gateway.moneris.com/chktv2/request/request.php";
    private $receiptBaseUrl = "https://gateway.moneris.com/chkt/request/request.php";


    public function getPreloadRequest($requestParam)
    {

        if (empty($requestParam))
            return json_encode(["error" => true, "message" => "Bad Request Formed"]);


        $client = new GuzzleHttp\Client();

        // Create Preload Reqeust Parameter 



        $preloadReqeust = [
            "store_id" => $this->storeId,
            "api_token" => $this->api_token,
            "checkout_id" => $this->checkout_id,
            "txn_total" => number_format((float) $requestParam['amount'], 2, '.', ''),
            "environment" => $this->enviroment,
            "action" => "preload",
            "order_no" => $requestParam['invoice'],
            "cust_id" => $requestParam['first_name'] . " " . $requestParam['last_name'],
            "contact_details" => [
                "first_name" => $requestParam['first_name'],
                "last_name" => $requestParam['last_name']
            ]

        ];



        $res = $client->request('POST', $this->preloadBaseUrl, [
            GuzzleHttp\RequestOptions::JSON => $preloadReqeust
        ]);


        echo $res->getBody();

        // echo json_encode($res->getBody());


    }

    public function receiptCheck($ticketNo)
    {

        if (empty($ticketNo))
            return json_encode(["error" => true, "message" => "Bad Request Formed"]);


        $client = new GuzzleHttp\Client();

        // Create Preload Reqeust Parameter 



        $receiptReqeust = [
            "store_id" => $this->storeId,
            "api_token" => $this->api_token,
            "checkout_id" => $this->checkout_id,
            "environment" => $this->enviroment,
            "action" => "receipt",
            "ticket" => $ticketNo,
        ];



        $res = $client->request('POST', $this->receiptBaseUrl, [
            GuzzleHttp\RequestOptions::JSON => $receiptReqeust
        ]);

        echo $res->getBody();

    }


    // Sanitize Inputs
    public function test_input($data)
    {
        $data = strip_tags($data);
        $data = htmlspecialchars($data);
        $data = stripslashes($data);
        $data = trim($data);
        return $data;
    }


}


// Create object of Users class
$moneris = new Moneris();

// create a api variable to get HTTP method dynamically
$api = $_SERVER['REQUEST_METHOD'];


// Add a new user into database
if ($api == 'POST') {

    // Takes raw data from the request
    $json = file_get_contents('php://input');


    // Converts it into a PHP object
    $data = json_decode($json);





    $first_name = $moneris->test_input($data->first_name);
    $last_name = $moneris->test_input($data->last_name);
    $company = $moneris->test_input($data->company);
    $invoice = $moneris->test_input($data->invoice);
    $transaction = $moneris->test_input($data->amount);
    $comments = $moneris->test_input($data->comments);


    $requestParams = [
        "first_name" => $first_name,
        "last_name" => $last_name,
        "company" => $company,
        "amount" => $transaction,
        "comments" => $comments,
        "invoice" => $invoice,
    ];



    $response = $moneris->getPreloadRequest($requestParams);

}

// Verify Request Receipt
if ($api == "GET") {


    // Converts it into a PHP object
    $ticketNo = $_GET["ticket"];

    $ticketNo = $moneris->test_input($ticketNo);

    $response = $moneris->receiptCheck($ticketNo);
}