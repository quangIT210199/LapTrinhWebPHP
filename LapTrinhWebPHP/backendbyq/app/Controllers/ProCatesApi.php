<?php

require_once 'app/Utils/RestfulAPI.php';
require_once 'app/config/Database.php';
require_once 'app/Models/ProCate.php';

class ProCatesApi extends RestFul_API {
    private $database;
    private $db;
    private $procates;

    function __construct()
    {
        $this->database = new Database();
        $this->db = $this->database->getConnection();
        $this->procates = new ProCates($this->db);
        parent::__construct();
    }

    public function allcates() {
        if ($this->method == "GET") {
            //get all categories
            $catesArr = $this->procates->getAllCategories();
            if (is_array($catesArr)) {
                $this->response(200, $catesArr);
            } else
                $this->response(404, $catesArr);
        } else {
            $this->response(405, array("error" => "method not allowed"));
        }
    }

    public function createcate() {
        //request method: POST
        // request data form = {
        //     cateCode: "pork",
        //     cateDes: "thịt lợn"
        // }
        if ($this->method == "POST") {
            $proCateData = json_decode(file_get_contents('php://input'));
            if ($proCateData->cateCode) {
                $this->procates->setproCateCode($proCateData->cateCode);
                $this->procates->setproCateDes($proCateData->cateDes);
                $addCates = $this->procates->createCate();
                if (isset($addCates["msg"])) {
                    $this->response(200, $addCates);
                } else {
                    $this->response(500, $addCates);
                } 
            }            
        } else {
            $this->response(405, array("error" => "method not allowed"));
        }
    }

        //delete product
    function delCate() {
        if ($this->method == "POST") {
            $cateData = $_POST;
            if ($cateData['proCate_ID']) {

                $this->procates->setproCateID($cateData['proCate_ID']);
                
                $del_Cate = $this->procates->delCate();
                if (isset($del_Cate["msg"])) {
                    $this->response(200, $del_Cate);
                } else {
                    $this->response(500, $del_Cate);
                } 
            } 
        } else {
            $this->response(405, array("error" => "method not allowed"));
        }
    }

    //Update cate model
    function updatecategory(){
        if($this->method == "POST"){
            $cateData = json_decode(file_get_contents('php://input'));
            if(property_exists($cateData, "cate_id") && property_exists($cateData, "cate_name")&& property_exists($cateData, "cate_code")){
                $this->procates->setproCateID($cateData->cate_id);
                $this->procates->setproCateDes($cateData->cate_name);
                $this->procates->setproCateCode($cateData->cate_code);
                $updateCate = $this->procates->updatecate();

                if(isset($updateCate["msg"])){
                    $this->response(200, $updateCate);
                }else {
                    $this->response(500, $updateCate);
                }
            }else {
                $this->response(400, array("error" => "bad request"));
            }           
        } else {
            $this->response(405, array("error" => "method not allowed"));
        }
    }
}
?>
