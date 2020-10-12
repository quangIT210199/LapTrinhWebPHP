<?php

require_once 'vendor/autoload.php';
use Firebase\JWT\JWT;

class User {

    // Connection
    private $conn;
    // Columns
    private $id;
    private $password;
    private $name;
    private $phone;
    private $email;
    private $date;
    private $role;
    private $address;
    private $created;
    private $sex;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function setSex($sex): void {
        $this->sex= $sex;
    }

    public function setId($id): void {
        $this->id = $id;
    }

    public function setPassword($password): void {
        $this->password = $password;
    }

    public function setName($name): void {
        $this->name = $name;
    }

    public function setPhone($phone): void {
        $this->phone = $phone;
    }

    public function setEmail($email): void {
        $this->email = $email;
    }

    public function setDate($date): void {
        $this->date = $date;
    }

    public function setRole($role): void {
        $this->role = $role;
    }

    public function setAddress($address): void {
        $this->address = $address;
    }

    public function setCreated($created): void {
        $this->created = $created;
    }

    function getSex() {
        return $this->sex;
    }

    function getId() {
        return $this->id;
    }

    function getPassword() {
        return $this->password;
    }

    function getName() {
        return $this->name;
    }

    function getPhone() {
        return $this->phone;
    }

    function getEmail() {
        return $this->email;
    }

    function getDate() {
        return $this->date;
    }

    function getRole() {
        return $this->role;
    }

    function getAddress() {
        return $this->address;
    }

    function getCreated() {
        return $this->created;
    }

    // Get all users
    public function getAllUsers() {
        
        $sqlQuery = "SELECT * FROM User";
        try {
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->execute();
            $itemCount = $stmt->rowCount();

            if ($itemCount > 0) {
                $userArr = array();
                $userArr["body"] = array();
                $userArr['itemCount'] = $itemCount;

                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    extract($row);
                    $e = array(
                        "id" => $id,
                        "name" => $name,
                        "email" => $email,
                        // "password" => $password,
                        "sex" => $sex,
                        "phone" => $phone,
                        "date" => $date,
                        "role" => $role,
                        "address" => $address,
                        "created" => $created
                    );
                    array_push($userArr["body"], $e);
                }
                return $userArr;
            } else {
                return "Msg: No user.";
            }
        } catch (PDOException $exc) {
            return array("msg" => array("error" => $exc->getMessage()), "status" => 500);
        }
    }

    // Get single User
    function getSingleUser() {

        // $sqlQuery = "SELECT * FROM User WHERE id = :id"; // tìm kiếm theo id
        $sqlQuery = "SELECT *, DATE_FORMAT(date, \"%d-%m-%Y\") as date FROM User WHERE id REGEXP '[[:<:]]"
            . $this->testData($this->id) . "[[:>:]]'";
        try {
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->bindValue(":id", htmlspecialchars(strip_tags($this->id)));
            $stmt->execute();

            $itemCount = $stmt->rowCount();
            if ($itemCount > 0) {
                $userArr = array();//tạo 2 mảng với 2 key
                $userArr["body"] = array();
                $userArr['itemCount'] = $itemCount;

                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                extract($row);
                $e = array(
                    "id" => $id,
                    "name" => $name,
                    "email" => $email,
                    // "password" => $password,
                    "sex" => $sex,
                    "phone" => $phone,
                    "date" => $date,
                    "role" => $role,
                    "address" => $address,
                    "created" => $created
                );
                array_push($userArr["body"], $e);//return data với key là body

                return $userArr;
            } else {
                return "Msg: No user.";
            }
        } catch (PDOException $exc) {
            return array("msg" => array("error" => $exc->getMessage()), "status" => 500);
        }
    }
    //Create User
    public function createUser() {
        $sqlQuery = "INSERT INTO User (name, phone, email, password, sex, date, role, address, created) "
                . "VALUES (:name, :phone, :email, :password, :sex, :date, :role, :address, :created)";
        try {
            $stmt = $this->conn->prepare($sqlQuery);
            //        Data binding
            $stmt->bindValue(":name", htmlspecialchars(strip_tags($this->name)));
            $stmt->bindValue(":email", htmlspecialchars(strip_tags($this->email)));
            $stmt->bindValue(":phone", htmlspecialchars(strip_tags($this->phone)));

            $password_hashed = password_hash(htmlspecialchars(strip_tags($this->password)), PASSWORD_BCRYPT, ["cost" => 11]);
            $stmt->bindValue(":password", $password_hashed);

            $stmt->bindValue(":sex", htmlspecialchars(strip_tags($this->sex)));
            $stmt->bindValue(":date", htmlspecialchars(strip_tags($this->date)));
            $stmt->bindValue(":role", htmlspecialchars(strip_tags($this->role)));
            $stmt->bindValue(":address", htmlspecialchars(strip_tags($this->address)));
            $stmt->bindValue(":created", htmlspecialchars(strip_tags($this->created)));
            $stmt->execute();
            return array("msg" => "Create user successful");
            // return array("msg" => array("msg" => "Create user successful."), "status" => 200);
        } catch (PDOException $e) {
            // return array("error" => $exc); 
            $arr_err = explode("1062", $e->getMessage());
            return array("msg" => array("error" => $arr_err[1]), "status" => 500);
        }
    }

    // Edit Employee
    //update product
    public function editEmployee() {
        $sqlQuery = "UPDATE user SET name = :name, email = :email, phone = :phone, password = :password, sex = :sex, role = :role, date = :date, address = :address, created = :created WHERE id = :id";
        try {
            $stmt = $this->conn->prepare($sqlQuery);

            $stmt->bindValue(":id", htmlspecialchars(strip_tags($this->id)));
            $stmt->bindValue(":name", htmlspecialchars(strip_tags($this->name)));
            $stmt->bindValue(":email", htmlspecialchars(strip_tags($this->email)));
            $stmt->bindValue(":phone", htmlspecialchars(strip_tags($this->phone)));

            $password_hashed = password_hash(htmlspecialchars(strip_tags($this->password)), PASSWORD_BCRYPT, ["cost" => 11]);
            $stmt->bindValue(":password", $password_hashed);

            $stmt->bindValue(":sex", htmlspecialchars(strip_tags($this->sex)));
            $stmt->bindValue(":date", htmlspecialchars(strip_tags($this->date)));
            $stmt->bindValue(":role", htmlspecialchars(strip_tags($this->role)));
            $stmt->bindValue(":address", htmlspecialchars(strip_tags($this->address)));
            $stmt->bindValue(":created", htmlspecialchars(strip_tags($this->created)));

            $stmt->execute();

            return array("msg" => "Edit employee successful");
        } catch (PDOException $exc) {            
            return array("error" => $exc);
        }
    }
    
    //Delete Employee
    function delEmployee(){
        //chống khi query id bị tìm thấy khi nhập cả String
        $sqlQuery = "DELETE FROM User WHERE id REGEXP '[[:<:]]"
            . $this->testData($this->id) . "[[:>:]]'";

        try{
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->execute();//thực hiện query
            return array("msg" => "Employee deleted successfully");
        } catch (PDOException $exc) {
            return array("error" => $exc->getMessage());
        }
    }

    //Search Employee Model
    function searchEmployee(){
        $sqlQuery = "SELECT *, DATE_FORMAT(date, \"%d-%m-%Y\") as date FROM User WHERE name LIKE '%" . $this->testData($this->name) . "%' OR phone LIKE '%" . $this->testData($this->phone) . "%'";
        try{
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->execute();//thực hiện sql
            
            $itemCount = $stmt->rowCount(); //đếm các ptu
            if($itemCount > 0){
                $employee_arr = array();
                $employee_arr["body"] = array();
                $employee_arr["itemCount"] = $itemCount;
                
                //Lấy ra taats cả các phần tử
                while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    extract($row);
                    $e = array(

                    );

                    array_push($customer_arr["body"], $e);
                }

                return $customer_arr;
            }

            else{
                return "Msg: No user.";
            }

        }catch(PDOException $exc){
            return array("error" => $exc->getMessage());
        }
    }

    //
    private function testData($data)
    {
        return htmlspecialchars(strip_tags(trim($data)));
    }

    public function findByCredentials() {//phương thức xác thực
        $sqlQuery = "SELECT * FROM User WHERE email = :email";

        try{
            $stmt = $this->conn->prepare($sqlQuery);
            //Data binding
            $stmt->bindValue(":email", $this->testData($this->email));
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            //hàm xác minh lại mk khớp với hàm băm hay ko
            if(!password_verify($this->testData($this->password), $row["password"])){
                throw new Exception("Invalid login credentials");
            }

            $profile = [
                "userID" => $row["id"],
                "name" => $row["name"],
                "email" => $row["email"],
                "role" => $row["role"]
            ];

            //Tạo access token bao gồm header playload và signature(header , payload kèm theo một chuỗi secret (khóa bí mật) )
            $accesstoken = $this->generateAccessToken($profile, $_ENV["ACCESSTOKENKEY"], $_ENV['TOKEN_LIFE']);// TOKEN_LIFE seconds
            return array("access_token" => $accesstoken, "profile" => $profile);

        } catch(PDOException $exc){
            throw new Exception($exc->getMessage());
        }
    }

    private function generateAccessToken($data, $key, $expTime) {//tạo access token
        $tokenId = uniqid(rand(), true);
        $issuedAt = time();
        $notBefore = $issuedAt;
        $expire = $notBefore + $expTime;            // Adding expTime seconds
        $serverName = $_SERVER["SERVER_NAME"]; // Retrieve the server name from config file

        /*
         * Create the token as an array
         */

        $payload = [
            'iat' => $issuedAt, // Issued at: time when the token was generated
            'jti' => $tokenId, // Json Token Id: an unique identifier for the token
            'iss' => $serverName, // Issuer
            'nbf' => $notBefore, // Not before
            'exp' => $expire, // Expire
            'data' => $data
        ];

        $accessToken = JWT::encode($payload, $key);
        return $accessToken;
    }
}
