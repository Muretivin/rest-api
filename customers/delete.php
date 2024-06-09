<?php
error_reporting(0);

header('Access-Control-Allow-Origin:*');
header('Content-Type: application/jason');
header('Access-Control-Allow-Method: DELETE');
header('Access-Control-Allow-Headers: Content-type, Access-Control-Allow-Headers, Authorization,x-request-with');

include('function.php');

$requestMethod = $_SERVER["REQUEST_METHOD"];

if($requestMethod =="DELETE"){

        $deletecustomer = deleteCustomer($_GET);
        echo $deletecustomer;

    }
    else{
    $data = [
        'status' => 405,
        'message' => $requestMethod. 'Method Not Allowed',
    ];
    header("HTTP/1.0 405 Method Not Allowed");
    echo json_encode($data);
}

?>