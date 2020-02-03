<?php 
header("Access-Control-Allow-Origin");
header("content-Type: application/json;charset=UTF-8"); 
include_once("../config/database.php");
include_once("../objects/product.php");
include_once("../config/core.php");
include_once("../shared/utilities.php");

//utilities
$utilities = new Utilities();
$database = new Database();
$db = $database->getConnection();
$product = new Product($db);

//query string
$stmt = $product->readPaging($from_record_num,$records_per_page);

$num =$stmt->rowCount();
//print_r($num);die;
//check if more than 0 records
if($num > 0){
    $product_arr = array();
    $product_arr["records"]= array();
    $product_arr["paging"]= array();
    //reterive table contents
    while($row = $stmt ->fetch(PDO :: FETCH_ASSOC)){
        extract($row);
        $product_items = array(
            "id" => $id,
            "name" =>  $name,
            "description" => html_entity_decode($description),
            "category_id" => $category_id,
            "category_name" => $category_name
        );
        //it is used for pussing the data to the array for while conditions
        array_push($product_arr["records"],$product_items);
    }
    //inlcude paging 
    $total_rows = $product->count();
    $page_url = "{$home_url}/product/read_paging.php?";
    //class->function(paramters){} 
    $paging = $utilities->getPaging($page,$total_rows,$records_per_page,$page_url);
    $product_arr["paging"] = $paging;

    //response
    http_response_code(200);
    //for echo
    echo json_encode($product_arr);

}
else{
    http_response_code(404);
    echo json_encode(
        array("message" => "records not found")
    );

}
