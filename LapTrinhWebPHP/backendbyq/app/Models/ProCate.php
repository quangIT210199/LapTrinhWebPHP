<?php
require_once 'vendor/autoload.php';

class ProCates {
    private $conn;
    private $proCate_id, $proCate_code, $proCate_des;

    //constructor
    public function __construct($db) {
        $this->conn = $db;
    }

    public function setproCateID($proCate_id): void {
        $this->proCate_id = $proCate_id;
    }

    public function setproCateCode($proCate_code): void {
        $this->proCate_code = $proCate_code;
    }

    public function setproCateDes($proCate_des): void {
        $this->proCate_des = $proCate_des;
    }

    //===============================================================
    //get all categories
    public function getAllCategories() {
        $sqlQuery = "SELECT * FROM products_categories";
        try {
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->execute();
            $itemCount = $stmt->rowCount();

            if ($itemCount > 0) {
                $catesArr = array();
                $catesArr["body"] = array();
                $catesArr['itemCount'] = $itemCount;

                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    extract($row);
                    $e = array(
                        "proCate_ID"=>$proCate_ID, 
                        "proCate_code"=>$proCate_code, 
                        "proCate_des"=>$proCate_des
                    );
                    array_push($catesArr["body"], $e);
                }
                return $catesArr;
            } else {
                return "Msg: No categories";
            }
        } catch (PDOException $exc) {
            return array("msg" => array("error" => $exc->getMessage()), "status" => 500);
        }
    }

    public function getaCate(){//chưa xong
        $sqlQuery = "SELECT * FROM products WHERE pro_id = :id";
    }

    //create a category
    public function createCate() {
        $sqlQuery = "INSERT INTO products_categories (proCate_code, proCate_des) VALUES (:code, :des)";
        try {
            $stmt = $this->conn->prepare($sqlQuery);
            //Data binding
            $stmt->bindValue(":code", $this->testData($this->proCate_code));
            $stmt->bindValue(":des", $this->testData($this->proCate_des));
            $stmt->execute();
            return array("msg" => "Create categories successful");
        } catch (PDOException $exc) {            
            return array("error" => $exc);
        }
    }

    //delete products
    public function delCate() {
        $sqlQuery = "DELETE FROM products_categories WHERE proCate_id REGEXP '[[:<:]]".$this->testData($this->proCate_id)."[[:>:]]'";
        try {
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->execute();
            return array("msg" => "Cate deleted successfully");
        } catch (PDOException $exc) {
            return array("error" => $exc->getMessage());
        }
    }

    //================= support function ====================
    private function testData($data) {
        return htmlspecialchars(strip_tags(trim($data)));
    }
    
    //Update Cate
    public function updatecate(){
        $sqlQuery = "UPDATE products_categories SET proCate_des = :pro_des, proCate_code = :pro_code WHERE proCate_id = :pro_id";
        
        try{
            $stmt = $this->conn->prepare($sqlQuery);

            $stmt->bindValue(":pro_id", $this->testData($this->proCate_id));
            $stmt->bindValue(":pro_code", $this->testData($this->proCate_code));
            $stmt->bindValue(":pro_des", $this->testData($this->proCate_des));
            $stmt->execute();

            return array("msg" => "ok");
        } catch(PDOException $exc) {
            return array("error" => $exc);
        }
    }
}
?>
