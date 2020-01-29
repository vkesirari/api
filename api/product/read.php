<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// database connection will be here
//include database and product object
include_once '../config/database.php';
include_once '../objects/product.php';

//instantiate database 
$database = new Database();
$db = $database->getConnection();

//initialize product objct
$product = new Product($db);

//query product 
$stmt = $product->read();
$num = $stmt->rowCount();
//check if more then record found
///var_dump(headers_list());exit;
if($num > 0){
    //product array
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
    //print_r($product_arr["records"]);
    //set response code
    http_response_code(200);
    //show product data in json form
    echo json_encode($product_arr);
}else{
    //set the resopnse code to 404 not found
    http_response_code(404);
    echo json_encode(
        array("message" => "no product found.")
    );
}

?>


