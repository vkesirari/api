<?php
class Product
{
    //database connection and table name
    private $conn;
    private $table_name = "products";
    //objects properties
    public $id;
    public $name;
    public $description;
    public $price;
    public $category_id;
    public $created;
    //constructor with $db as db con
    public function __construct($db){
        $this->conn = $db;
    }
    //read all products from the table 
    function read(){
        //select query
        $query = "SELECT c.name as category_name ,p.id,p.name,p.description,p.price,p.category_id,p.created FROM " . $this->table_name . " p LEFT JOIN categories c ON p.category_id = c.id ORDER BY p.created DESC";
        //prepare query statement
        $stmt = $this->conn->prepare($query);
        //execute query
        $stmt->execute();
        return $stmt;
        //echo "<pre>";print_r($stmt);

    }
    //create the product
    function create(){
        //quert to insert the records to the product table
        $query = "INSERT INTO ".$this->table_name." SET name =:name, price=:price, description=:description, category_id=:category_id, created=:created";
        //prepare query
        $stmt = $this->conn->prepare($query);
        //initialize
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->price = htmlspecialchars(strip_tags($this->price));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));
        $this->created = htmlspecialchars(strip_tags($this->created));
        //bind value
        $stmt->bindParam(":name",$this->name);
        $stmt->bindParam(":price",$this->price);
        $stmt->bindParam(":description",$this->description);
        $stmt->bindParam(":category_id",$this->category_id);
        $stmt->bindParam(":created",$this->created);
        //execute query
        if($stmt->execute()){
            return true;

        }
        return false;
    }
    //select particular record from the records
    function readOne(){
        $query = "SELECT c.name as category_name,p.id,p.name,p.description,p.price,p.category_id,p.created FROM ".$this->table_name." p LEFT JOIN categories c on p.category_id = c.id where p.id = ? LIMIT 0,1";
        //prepare query
        $stmt = $this->conn->prepare($query);
        //bind id to product to update
        $stmt->bindParam(1,$this->id);
        //execute query
        $stmt->execute();
        //get reterieved row
        $row = $stmt->fetch(PDO :: FETCH_ASSOC);
        //set the value to object properties
        $this->name = $row["name"];
        $this->price = $row["price"];
        $this->description = $row["description"];
        $this->category_id = $row["category_id"];
        $this->category_name = $row["category_name"];
    }
    //to update the record for particular id
    function update(){
        $query = "UPDATE ".$this->table_name." SET name = :name, price = :price, description = :description,category_id = :category_id WHERE id = :id"; 
        $stmt = $this->conn->prepare($query);
        //initize
        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->price=htmlspecialchars(strip_tags($this->price));
        $this->description=htmlspecialchars(strip_tags($this->description));
        $this->category_id=htmlspecialchars(strip_tags($this->category_id));
        $this->id=htmlspecialchars(strip_tags($this->id));
    
        // bind new values
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':price', $this->price);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':category_id', $this->category_id);
        $stmt->bindParam(':id', $this->id);
        if($stmt->execute()){
            return true;
        } 
        return false;
    }
    //delete product by id
    function delete(){
        $query = "DELETE FROM ".$this->table_name." WHERE id = ?";
        //prepare statment
        $stmt = $this->conn->prepare($query);
        //santize
        $this->id = htmlspecialchars(strip_tags($this->id));
        //bin value
        $stmt->bindParam(1,$this->id);
        if($stmt->execute()){
            return true;
        }
        return false;
    }

    function search($keywords){
        $query = "SELECT c.name as category_name , p.id ,p.name,p.description,p.price,p.category_id,p.created FROM ".$this->table_name." p LEFT JOIN categories c ON p.category_id = c.id WHERE p.name LIKE ? OR p.description LIKE ? OR c.name LIKE ? ORDER BY p.created DESC";    
        //prepaare query 
        $stmt = $this->conn->prepare($query);
        //santize
        $keywords = htmlspecialchars(strip_tags($keywords));
        $keywords = "%{$keywords}%";
        //bind statemnt
        $stmt->bindParam(1,$keywords);
        $stmt->bindParam(2,$keywords);
        $stmt->bindParam(3,$keywords);
        //execute query 
        $stmt->execute();
        return $stmt;




    }


}
?>
