<?php
//"C:\Program Files (x86)\Google\Chrome\Application\chrome.exe" --disable-web-security --disable-gpu --user-data-dir=~/chromeTemp
require_once 'app/Utils/RestfulAPI.php';
require_once 'app/Middlewares/Auth.php';
require_once 'app/config/Database.php';
require_once 'app/Models/User.php';


class UserApi extends Restful_API
{

    private $database;
    private $db;
    private $user;

    function __construct()
    {   //tạo đối tượng db và kết nối
        $this->database = new Database();
        $this->db = $this->database->getConnection();
        $this->user = new User($this->db);
        //gọi RESTFUL API
        parent::__construct();
    }

    function user()
    {   
        //Author:trao quyền
        $role = [$_ENV["ROLE_ADMIN"]];
        $authMid = Auth::authMiddleware($role);
        if (isset($authMid["error"])) {
            $this->response(401, $authMid);
        }

        if ($this->method == "GET") {

            $UserID = isset($_GET["id"]) ? $_GET["id"] : null;
            if ($UserID) {
                $this->user->setId($UserID);
                $userArr = $this->user->getSingleUser();
                if (is_array($userArr)) {   
                    $this->response(200, $userArr);
                } else
                    $this->response(404, $userArr);
            }

            $userArr = $this->user->getAllUsers();

            if (is_array($userArr)) {
                $this->response(200, $userArr);
            } else
                $this->response(404, $userArr);
        }else {
            $this->response(405, array("error" => "method not allowed"));
        }
    }

    function addEmployee() {
        if ($this->method == "POST") {
            //Author:trao quyền
            $role = [$_ENV["ROLE_ADMIN"]];
            $authMid = Auth::authMiddleware($role);
            if (isset($authMid["error"])) {
                $this->response(401, $authMid);
            }
            $data = json_decode(file_get_contents('php://input'));//chuyển thành đối tượng
            // $data = $_POST;//lấy tất cả tham số truyền vào và ktra   
            if (!isset($data->name))
                $this->response(500, array("error" => "No name provided."));

            else if (!isset($data->email))
                $this->response(500, array("error" => "No email provided."));

            else if (!isset($data->password))
                $this->response(500, array("error" => "No password provided."));

            else if (!isset($data->sex))
                $this->response(500, array("error" => "No sex provided."));

            else if (!isset($data->phone))
                $this->response(500, array("error" => "No phone number provided."));

            else if (!isset($data->role))
                $this->response(500, array("error" => "No role provided."));
            
            else if (!isset($data->address))
                $this->response(500, array("error" => "No address provided."));
            
            else if (!isset($data->date))
                $this->response(500, array("error" => "No date provided."));

            $this->user->setName($data->name);
            $this->user->setPhone($data->phone);
            $this->user->setEmail($data->email);
            $this->user->setPassword($data->password);
            $this->user->setSex($data->sex);
            $this->user->setDate(date("Y-m-d", strtotime($data->date)));
            $this->user->setRole($data->role);
            $this->user->setAddress($data->address);
            $this->user->setCreated(date('Y-m-d H:i:s'));

            $result = $this->user->createUser();//gọi hàm create
            // $this->response($result["status"], $result["msg"]);
            if (isset($result["msg"])) {
                $this->response(200, $result);
            } else {
                $this->response(500, $result);
            } 
        }
        else {
            $this->response(405, array("error" => "method not allowed"));
        }
    }
    
    //Delete controller
    // function delEmployee(){
    //     if($this->method == "DELETE"){
    //         $employeeID = isset($_GET["id"]) ? $_GET["id"] : null;//ktra param id tồn tại trong method GET ko
    //         if($employeeID){ //ktra tồn tại k
    //             $this->user->setId($employeeID); // xét đối tg đó với id để ktra trong model
    //             $del_employee = $this->user->delEmployee();//gọi hàm delEmployee bên User

    //             if(isset($del_employee["error"])){
    //                 $this->response(500, $del_employee);
    //             }
    //             else {
    //                 $this->response(200, $del_employee);
    //             }

    //             if($employeeID === "" ){//nếu rỗng thì :V
    //                 $this->response(500, array("error" => "No ID provied"));
    //             }
    //         }
    //     }
    // }
    function delEmployee() {
        if ($this->method == "POST") {
            //Author:trao quyền
            $role = [$_ENV["ROLE_ADMIN"]];
            $authMid = Auth::authMiddleware($role);
            if (isset($authMid["error"])) {
                $this->response(401, $authMid);
            }
            $userData = json_decode(file_get_contents('php://input'));
            //chú ý key : value là theo bên fontend
            if ($userData->id) {//id nay cua ben FE dinh nghia ra
                $this->user->setId($userData->id);
                $del_employee = $this->user->delEmployee();
                if (isset($del_employee["msg"])) {
                    $this->response(200, $del_employee);
                } else {
                    $this->response(500, $del_employee);
                }
            }
        }else {
            $this->response(405, array("error" => "method not allowed"));
        }
    }

    //Edit Employee 
    function editEmployee() {
        if ($this->method == "POST") {
            // //Author:trao quyền
            // $role = [$_ENV["ROLE_ADMIN"]];
            // $authMid = Auth::authMiddleware($role);
            // if (isset($authMid["error"])) {
            //     $this->response(401, $authMid);
            // }
            $userData = json_decode(file_get_contents('php://input'));
            //biến userData này sẽ lấy các giá trị của data bên FE
            if ($userData->id2) {//lấy id2 đề tìm
                $this->user->setID($userData->id2);//ví dụ ntn n đc định danh key bên FE
                $this->user->setName($userData->name);
                $this->user->setPhone($userData->phone);
                $this->user->setEmail($userData->email);
                $this->user->setPassword($userData->password);
                $this->user->setSex($userData->sex);
                $this->user->setDate($userData->date);
                $this->user->setRole($userData->role);
                $this->user->setAddress($userData->address);
                $this->user->setCreated(date('Y-m-d H:i:s'));

                $edit_employee = $this->user->editEmployee();
                if (isset($edit_employee["msg"])) {
                    $this->response(200, $edit_employee);
                } else {
                    $this->response(500, $edit_employee);
                } 
            }            
        }else {
            $this->response(405, array("error" => "method not allowed"));
        }
    }
    //Search controller API
    
    function login()
    {
        if ($this->method == "POST") {
            $data = $_POST;//tài khoản và mk

            if (!isset($data["email"]) || $data["email"] == "")
                $this->response(500, array("error" => "No Email provided."));
            else if (!isset($data["password"]) || $data["password"] == "")
                $this->response(500, array("error" => "No password provided."));

            $this->user->setEmail($data["email"]);
            $this->user->setPassword($data["password"]);
            try {
                $result = $this->user->findByCredentials();//gọi hàm xác thực
                $this->response(200, array("access_token" => $result["access_token"], "profile" =>  $result["profile"]));
            } catch (Exception $ex) {
                $msg = $ex->getMessage();
                $this->response(500, array("error" => $msg));
            }
        }
    }

    //Hàm Profile dùng để thấy thông tin của ng login vào để dùng cho việc trao quyền
    function profile()
    {
        if ($this->method == "GET") {
            $authMid = Auth::authMiddleware();
            if (isset($authMid["error"])) {
                $this->response(401, $authMid);
            }
            $this->response(200, $authMid);
        }
    }
}
