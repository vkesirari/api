<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
include_once("../objects/product.php");
include_once("../config/database.php");
 $database = new Database();
 $db = $database->getConnection();
 $product = new Product($db);

 //get keywords
 $keywords = isset($_GET["s"]) ? $_GET["s"] : "";
 //query 
 $stmt = $product->search($keywords);
 $num = $stmt->rowCount();

 if($num > 0 ){

    $product_arr = array();
    $product_arr["records"] = array();
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        //it will output the data according to the query and then after that we wil bind this data with request and response
        extract($row);
       //print_r($row);ECHO "-----------";
       //this is blank product array for the data
        $product_item = array(
            "id" => $id,
            "name" => $name,
            "description" =>html_entity_decode($description),
            "category_id" => $category_id,
            "category_name" => $category_name
        );
       //we are assiging values to product array
        array_push($product_arr["records"],$product_item);
    } 
 }else{
     //not found  404
     http_response_code(404);
     echo json_encode(array("messsage" => "No record found"));
 }