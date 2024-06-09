<?php

require_once '../inc/dbcon.php';

function error422($message){

    $data = [
        'status' => 422,
        'message' => $message,
    ];
    header("HTTP/1.0 422 Unprocessable");
    echo json_encode($data);
    exit();

}

function storeCustomer($customerInput){
    global $conn;

    $name = mysqli_real_escape_string($conn, $customerInput['name']);
    $email = mysqli_real_escape_string($conn, $customerInput['email']);
    $phone = mysqli_real_escape_string($conn, $customerInput['phone']);

    if (empty(trim($name))) {

        return error422('Enter Your name');
        
    } elseif(empty(trim($email))) {

        return error422('Enter Your email');
        
    }elseif(empty(trim($phone))){

        return error422('Enter Your phone Number');

    }else{
        $query = "INSERT INTO customers (name,email,phone) VALUES ('$name', '$email', '$phone')";
        $result = mysqli_query($conn, $query);

        if ($result) {
            $data = [
                'status' => 201,
                'message' => 'Customer created Successfully',
            ];
            header("HTTP/1.0 201 created");
            return json_encode($data);
            
        } else {
            $data = [
                'status' => 500,
                'message' => 'Internal Server Error',
            ];
            header("HTTP/1.0 500 Internal Server Error");
            return json_encode($data);
            
        }
        
    }
    
}
function getCustomerList(){
    global $conn;

    $query = "SELECT * FROM customers";
    $query_run = mysqli_query($conn, $query);

    if($query_run){
        if (mysqli_num_rows($query_run) > 0) {
            $res = mysqli_fetch_all($query_run, MYSQLI_ASSOC);

            $data = [
                'status' => 200,
                'message' => ' Customer list Fetched Successfully',
                'data' => $res
            ];
            header("HTTP/1.0 200 Customer list Fetched Successfully");
            return json_encode($data);

            
        }else{
            $data = [
                'status' => 404,
                'message' => 'No Customer Found',
            ];
            header("HTTP/1.0 404 No Customer Found");
            return json_encode($data);

        }


    }
    else{
        $data = [
            'status' => 500,
            'message' => 'Internal Server Error',
        ];
        header("HTTP/1.0 500 Internal Server Error");
        return json_encode($data);

    }


}

function getCustomer($customerParams){
    global $conn;

    if ($customerParams['id'] == null) {
        return error422('Enter your customer id');
    }

    $customerId = mysqli_real_escape_string($conn, $customerParams['id']);

    $query = "SELECT * FROM customers WHERE id = '$customerId' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if($result){
        if(mysqli_num_rows($result) ==1){


            $res = mysqli_fetch_assoc($result);

            $data = [
                'status' => 200,
                'message' => 'Customer Fetched Successfully',
                'data' => $res 
            ];
            header("HTTP/1.0 200 Found");
            return json_encode($data);

        }
        else{
            $data = [
                'status' => 404,
                'message' => 'Customer Not Found',
            ];
            header("HTTP/1.0 500 Not Found");
            return json_encode($data);

        }

    }
    else{

        $data = [
            'status' => 500,
            'message' => 'Internal Server Error',
        ];
        header("HTTP/1.0 500 Internal Server Error");
        return json_encode($data);

    }
}

function updateCustomer($customerInput, $customerParams){
    global $conn;

    if(!isset($customerParams['id'])){

        return error422('customer id not found in this url');
    }
    elseif($customerParams['id'] == null){

        return error422('Enter the customer id');

    }

    $customerId = mysqli_real_escape_string($conn, $customerParams['id']);
    
    $name = mysqli_real_escape_string($conn, $customerInput['name']);
    $email = mysqli_real_escape_string($conn, $customerInput['email']);
    $phone = mysqli_real_escape_string($conn, $customerInput['phone']);

    if (empty(trim($name))) {

        return error422('Enter Your name');
        
    } elseif(empty(trim($email))) {

        return error422('Enter Your email');
        
    }elseif(empty(trim($phone))){

        return error422('Enter Your phone Number');

    }else{
        $query = "UPDATE customers SET name='$name', email='$email', phone='$phone' WHERE id ='$customerId' LIMIT 1";
        $result = mysqli_query($conn, $query);

        if ($result) {
            $data = [
                'status' => 200,
                'message' => 'Customer Updated Successfully',
            ];
            header("HTTP/1.0 200 success");
            return json_encode($data);
            
        } else {
            $data = [
                'status' => 500,
                'message' => 'Internal Server Error',
            ];
            header("HTTP/1.0 500 Internal Server Error");
            return json_encode($data);
            
        }
        
    }
    
}

function deleteCustomer($customerParams){
    global $conn;

    if(!isset($customerParams['id'])){

        return error422('customer id not found in this url');
    }
    elseif($customerParams['id'] == null){

        return error422('Enter the customer id');

    }

    $customerId = mysqli_real_escape_string($conn, $customerParams['id']);

    $query = "DELETE FROM customers WHERE id ='$customerId' LIMIT 1 ";
    $result = mysqli_query($conn, $query);

    if($result){
        $data = [
            'status' => 204,
            'message' => 'customer deleted successfully',
        ];
        header("HTTP/1.0 204 Deleted");
        return json_encode($data);

    }else{
        $data = [
            'status' => 404,
            'message' => 'customer id not found',
        ];
        header("HTTP/1.0 500 not found");
        return json_encode($data);

    }


}


?>