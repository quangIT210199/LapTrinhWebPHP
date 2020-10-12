<?php
    require_once 'vendor/autoload.php';

class Products{
    private $conn;

    private $pro_id, $pro_name, $pro_quantity, $pro_cate, $pro_saleprice, $pro_purchaseprice, $pro_image;

    public function __construct($db){
        $this->conn = $db;
    }

    public function setID($pro_id): void {
        $this->pro_id = $pro_id;
    }
    
    public function setName($pro_name): void {
        $this->pro_name = $pro_name;
    }

    public function setQuantity($pro_quantity): void {
        $this->pro_quantity = $pro_quantity;
    }

    public function setCategories($pro_cate): void {
        $this->pro_cate = $pro_cate;
    }

    public function setSaleprice($pro_saleprice): void {
        $this->pro_saleprice = $pro_saleprice;
    }

    public function setPurchaseprice($pro_purchaseprice): void {
        $this->pro_purchaseprice = $pro_purchaseprice;
    }

    public function setImage($pro_image): void {
        $this->pro_image = $pro_image;
    }

    ////Get all products
    public function getAllProducts() {
        $sqlQuery = "SELECT * FROM products";

        try{//thay các tham số đó bằng các biến ẩn danh chong chen SQLijection
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->execute();
            $itemCount = $stmt->rowCount();

            if($itemCount > 0){
                $proArr = array();
                $proArr["body"] = array();
                $proArr['itemCount'] = $itemCount;
                
                while( $row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    extract($row);// Nó nhận một mảng liên hợp array và coi các key như là các tên biến và các value là
                    //các giá trị biến. 
                    $e = array(
                        "pro_id"=>$pro_id,
                        "pro_name"=>$pro_name, 
                        "pro_quantity"=>$pro_quantity, 
                        "pro_cate"=>$pro_cate, 
                        "pro_saleprice"=>$pro_saleprice, 
                        "pro_purchaseprice"=>$pro_purchaseprice,
                        "pro_image"=>$this->getImage($pro_id, $pro_image)
                    );
                    array_push($proArr["body"], $e);
                }
                return $proArr;
            }
            else {
                return "msg: empty";
            }
        }catch(PDOException $exc){
            return array("msg" => array("error" => $exc->getMessage()), "status" => 500);
        }
    }
    
    //Get single Products
    //get a product
    public function getaProduct() {
        $sqlQuery = "SELECT * FROM products WHERE pro_id = :id";
        try {
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->bindValue(":id", htmlspecialchars(strip_tags($this->pro_id)));
            $stmt->execute();

            $itemCount = $stmt->rowCount();
            if ($itemCount > 0) {
                $proArr = array();
                $proArr["body"] = array();
                $proArr['itemCount'] = $itemCount;

                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    extract($row);
                    $e = array(
                        "pro_id"=>$pro_id, 
                        "pro_name"=>$pro_name, 
                        "pro_quantity"=>$pro_quantity, 
                        "pro_cate"=>$pro_cate, 
                        "pro_saleprice"=>$pro_saleprice, 
                        "pro_purchaseprice"=>$pro_purchaseprice,
                        "pro_image"=>$this->getImage($pro_id, $pro_image)
                    );
                    array_push($proArr["body"], $e);
                }
                return $proArr;
            } else {
                return "msg: empty";
            }
        } catch (PDOException $exc) {
            return array("msg" => array("error" => $exc->getMessage()), "status" => 500);
        }
    }

    public function createproduct(){
        $sqlQuery = "INSERT INTO products (pro_id, pro_name, pro_quantity, pro_cate, pro_saleprice, pro_purchaseprice, pro_image) VALUES (:id, :name, :quantity, :cate, :saleprice, :purchaseprice, :image)";
        try {
            $stmt = $this->conn->prepare($sqlQuery);
            //Data binding
            $stmt->bindValue(":id", $this->testData($this->pro_id));
            $stmt->bindValue(":name", $this->testData($this->pro_name));
            $stmt->bindValue(":quantity", $this->testData($this->pro_quantity));
            $stmt->bindValue(":cate", $this->testData($this->pro_cate));
            $stmt->bindValue(":saleprice", $this->testData($this->pro_saleprice));
            $stmt->bindValue(":purchaseprice", $this->testData($this->pro_purchaseprice));
            $stmt->bindValue(":image", $this->saveImage($this->pro_id, $this->pro_image));
            $stmt->execute();
            return array("msg" => "ok");
        } catch (PDOException $exc) {            
            return array("error" => $exc);
        }
    }

    //Edit product
    public function updateProduct(){
        $sqlQuery = "UPDATE products SET pro_name = :name, pro_quantity = :quantity, pro_saleprice = :saleprice, pro_purchaseprice = :purchaseprice, pro_image = :image WHERE pro_id = :id";
        try{
            $stmt = $this->conn->prepare($sqlQuery);

            $stmt->bindValue(":id", $this->testData($this->pro_id));
            $stmt->bindValue(":name", $this->testData($this->pro_name));
            $stmt->bindValue(":quantity", $this->testData($this->pro_quantity));
            $stmt->bindValue(":saleprice", $this->testData($this->pro_saleprice));
            $stmt->bindValue(":purchaseprice", $this->testData($this->pro_purchaseprice));
            $stmt->bindValue(":image", $this->saveImage($this->pro_id,$this->pro_image));
            $stmt->execute();

            return array("msg"=> "ok");
        }catch(PDOException $exc){
            return array("error" => $exc);
        }
    }

    //Delete Products
    public function deleteProduct(){
        $sqlQuery = "DELETE FROM products WHERE pro_id REGEXP '[[:<:]]".$this->testData($this->pro_id)."[[:>:]]'";
        try{
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->execute();

            return array("msg" => "ok");
        } catch(PDOException $exc) {
            return array("error" => $exc->getMessage());
        }
    }

    //================= support function =====================
    
    private function testData($data) {
        return htmlspecialchars(strip_tags(trim($data)));
    }

    // Hàm sinh chuỗi cùng với cate
    public function genProID() {
        $sqlQuery = "SELECT pro_id FROM products WHERE pro_cate = :cate ORDER BY pro_id DESC LIMIT 1";
        $cateLeng = strlen($this->pro_cate)+1;
        try {
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->bindValue(":cate", htmlspecialchars(strip_tags($this->pro_cate)));
            $stmt->execute();
            $proArr = array();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $e = $pro_id;
                array_push($proArr, $e);
            }
            if (!empty($proArr)) {
                $nextID = (int)substr($proArr[0], $cateLeng)+1;
            } else {
                $nextID = 1;
            }           
            return $this->pro_cate."-".(string)$nextID;
        } catch (PDOException $exc) {
            return array("msg" => array("error" => $exc->getMessage()), "status" => 500);
        }
    }

    private function saveImage($product_id, $base64String){
        $fileName = "app/images/".$product_id.".txt";
        $pro_imageFile = fopen($fileName, "w") or die("Fail to create File");
        fwrite($pro_imageFile, $base64String);
        fclose($pro_imageFile);
        return $fileName;
    }

    private function getImage($product_id, $path){
        $pro_imageFile = fopen($path, "r") or die("Fail to open File");
        $image = fread($pro_imageFile, filesize($path));
        fclose($pro_imageFile);
        return $image;
    }
}
// Cơ chế này hoạt động như sau: Khi chúng ta
// viết câu truy vấn mà có dữ liệu động thì thay vì truyền trực tiếp tham số thì chúng ta sẽ thay các tham số đó bằng các biến ẩn danh, rồi sau đó chúng ta sẽ truyền các giá trị cho các biến ẩn danh đó và PHP sẽ prepared sao cho bảo mật nhất rồi mới chạy câu truy vấn.
?>
