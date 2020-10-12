<?php

/**
 * Tiền xử lý api
 */
class Restful_API {

    /**
     * Property: $method
     * Method được gọi, GET POST PUT hoặc DELETE
     */
    protected $method = '';

    /**
     * Property: $endpoint
     * Endpoint của api
     */
    protected $endpoint = '';

    /**
     * Property: $params
     * Các tham số khác sau endpoint, ví dụ /<endpoint>/<param1>/<param2>
     */
    protected $params = array();

    /**
     * Function: __construct
     * Just a constructor
     */
    public function __construct() {
        $this->_input();
        $this->_process_api();
    }

    private function _input() {
//      Allow CORS

        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: *");       
        header("Access-Control-Allow-Methods: GET,POST,PUT,OPTIONS");
        header('Access-Control-Max-Age: 1000');
        header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');

//      Xử lý URL
        $this->params = explode("/", trim($_SERVER["PHP_SELF"]));
        $index_position = array_search("index.php", $this->params);
        if ($this->params[$index_position + 1] != "api") {
            $this->response(500, array("msg" => "Unknow Enpoint."));
        }
        $this->endpoint = $this->params[$index_position + 2];

        // Lấy method của request
        $method = $_SERVER['REQUEST_METHOD'];
        $allow_method = array(
            'GET',
            'POST',
            'PUT',
            'DELETE'
        );        
        if (in_array($method, $allow_method)) {
            $this->method = $method;
        }
    }

    /**
     * Thực hiện xử lý request
     */
    private function _process_api() {
        if (method_exists($this, $this->endpoint)) {
            $this->{$this->endpoint}();
        } else {
            return 0;
        }
    }

    /**
     * Trả dữ liệu về client
     *
     * @param: $status_code: mã http trả về
     * @param: $data: dữ liệu trả về
     */
    protected function response($status_code, $data = NULL) {
        // header("Access-Control-Allow-Origin: *");
        // header("Access-Control-Allow-Headers: *");       
        // header("Access-Control-Allow-Methods: GET,POST,PUT,OPTIONS");
        // header('Access-Control-Max-Age: 1000');
        // header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
        // header($this->_build_http_header_string($status_code));
        // header("Content-Type: application/json");
        // http_response_code($status_code);
        // echo json_encode($data);
        // exit();       
        header($this->_build_http_header_string($status_code));
        header("Content-Type: application/json");
        http_response_code($status_code);
        echo json_encode($data);
        exit();    
    }

    /**
     * Tạo chuỗi http header
     *
     * @param: $status_code: mã http
     * @return: Chuỗi http header, ví dụ: HTTP/1.1 404 Not Found
     */
    private function _build_http_header_string($status_code) {
        $status = array(
            200 => 'OK',
            400 => "Bad request",
            401 => "UNAUTHORIZED",
            404 => "Not Found",
            405 => 'Method Not Allowed',
            500 => 'Internal Server Error'
        );
        return "HTTP/1.1 " . $status_code . " " . $status[$status_code];
    }
}
