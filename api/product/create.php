<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
//print_r(headers_list());exit;

//include database and product
include_once("../config/database.php");
include_once("../objects/product.php");

//for insitiate database and product
$database = new Database();
$db = $database->getConnection();
$product = new Product($db);

/*
php://input: This is a read-only stream that allows us to read raw data from the request body. It returns all the raw data after the HTTP-headers of the request, regardless of the content type.
file_get_contents() function: This function in PHP is used to read a file into a string.
json_decode() function: This function takes a JSON string and converts it into a PHP variable that may be an array or an object.
*/
$data = json_decode(file_get_contents("php://input"));
//print_r($data);

//make sure data is not empty if empty tell the user that it is empty

if(!empty($data->name) && !empty($data->price) && !empty($data->description) && !empty($data->category_id) && !empty($data->created)){
    //set product property values
    $product->name = $data->name;
    $product->price = $data->price;
    $product->description = $data->description;
    $product->category_id = $data->category_id;
    $product->created = date('y-m-d H:i:s');
    if($product->create()){
        //set resopnse code to 201 created
        http_response_code(201);
        echo json_encode(array("message" =>"Product was created" ));
    }else{
        //bad request
        http_response_code(503);
        echo json_encode(array("message" => "unable to create the product"));
    }
}else{
    //unable to complte the request of data is incomplted
    http_response_code(400);
    echo json_encode(array("message" => "unable to complete request and data is incomplte"));
}
?>