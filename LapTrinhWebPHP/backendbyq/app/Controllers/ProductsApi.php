<?php
require_once 'app/Utils/RestfulAPI.php';
require_once 'app/config/Database.php';
require_once 'app/Models/Products.php';

class ProductsApi extends Restful_API{//tên class khác với tên file

    private $database;
    private $db;
    private $products;

    function __construct(){
        $this->database = new Database();
        $this->db = $this->database->getConnection();
        $this->products = new Products($this->db);
        //gọi contruct của Restful_API
        parent::__construct();
    }

    function allproducts() {
        if ($this->method == "GET") {
            $proData = isset($_GET["pro_id"]) ? $_GET["pro_id"] : null;
            if ($proData) {
                $this->products->setID($proData);
                $proArr = $this->products->getaProduct();
                if (is_array($proArr)) {   
                    $this->response(200, $proArr);
                } else
                    $this->response(404, $proArr);
            }
            //get all products
            $proArr = $this->products->getAllProducts();
            if (is_array($proArr)) {
                $this->response(200, $proArr);
            } else{
                $this->response(404, $proArr);
            }              
        } else {
            $this->response(405, array("error" => "method not allowed"));
        }
    }

    //create a product  
    function createproduct() {
        if ($this->method == "POST") {
            $proData = json_decode(file_get_contents('php://input'));
                if (property_exists($proData, "pro_name") && property_exists($proData, "pro_quantity") && property_exists($proData, "pro_categories") && property_exists($proData, "pro_saleprice") && property_exists($proData, "pro_purchaseprice")) {
                    $this->products->setID($this->genProId($proData->pro_categories));
                    $this->products->setName((string)$proData->pro_name);
                    $this->products->setQuantity($proData->pro_quantity);
                    $this->products->setCategories((string)$proData->pro_categories);
                    $this->products->setSaleprice($proData->pro_saleprice);
                    $this->products->setPurchaseprice($proData->pro_purchaseprice);
                    $this->products->setImage($proData->pro_image);
                    $addPro = $this->products->createProduct();
                    if (isset($addPro["msg"])) {
                        $this->response(200, $addPro);
                    } else {
                        $this->response(500, $addPro);
                    } 
                }                
        } else 
            $this->response(405, array("error" => "method not allowed"));
    }

    //Update product
    function updateproduct(){
        if($this->method == "POST"){
            $proData = json_decode(file_get_contents('php://input'));
            if(property_exists($proData, "pro_id") && property_exists($proData, "pro_name") && property_exists($proData, "pro_quantity") && property_exists($proData, "pro_saleprice") && property_exists($proData, "pro_purchaseprice") && property_exists($proData, "pro_image")){
                $this->products->setID($proData->pro_id);
                $this->products->setName($proData->pro_name);
                $this->products->setQuantity($proData->pro_quantity);
                $this->products->setSaleprice($proData->pro_saleprice);
                $this->products->setPurchaseprice($proData->pro_purchaseprice);
                $this->products->setImage($proData->pro_image);
                $updatePro = $this->products->updateProduct();
                if (isset($updatePro["msg"])) {
                    $this->response(200, $updatePro);
                } else {
                    $this->response(500, $updatePro);
                } 
            }else
                $this->response(400, array("error" => "bad request"));  
        }
        else {
            $this->response(405, array("error" => "method not allowed"));
        }
    }

    //Delete Products
    function deleteproduct(){
        if($this->method == "POST"){
            $proData = json_decode(file_get_contents('php://input'));
            if(property_exists($proData, "pro_id")) {
                $this->products->setID($proData->pro_id);
                $delPro = $this->products->deleteProduct();
                if(isset($delPro["msg"])){
                    $this->response(200, $delPro);
                } else{
                    $this->response(500, $delPro);
                }
            } else{
                $this->response(400, array("error" => "bad request"));
            }
        } 
        else {
            $this->response(405, array("error" => "method not allowed"));
        }
    }

    private function genProId ($products_categories) {
        $this->products->setCategories($products_categories);
        $id = $this->products->genProID();
        return $id;
    }
}
?>