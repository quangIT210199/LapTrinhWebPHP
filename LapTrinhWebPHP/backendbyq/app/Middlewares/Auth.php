<?php

require 'vendor/autoload.php';

use Firebase\JWT\JWT;


class Auth
{
    public static function authMiddleware($roles = [])//trao quyền
    {   //lấy ra request header
        $headers = apache_request_headers();//Header (Cookie header, Authorization header, Custom header)
        if (isset($headers["Authorization"])) {//nếu có 
            $arr = explode(" ", $headers["Authorization"]);
            $jwt = $arr[1];
            if ($jwt) {
                try {
                    $decoded = JWT::decode($jwt, $_ENV["ACCESSTOKENKEY"], array('HS256'));
                    
                    $data =  (array) $decoded->data;
                    $checkRole = 0;
                    if (count($roles)) {//nếu k checkrole thì tk nào cũng vào dc
                        foreach ($roles as $role) {
                            if ($data["role"] == $role) {
                                $checkRole++;
                            }
                        }
                        if (!$checkRole) {
                            return array("error" => "Unauthorized");
                        }
                    }                    
                    return $data;
                } catch (Exception $e) {
                    return array("error" => $e->getMessage());
                }
            }
        } else {
            return array("error" => "Unauthorized");
        }
    }
}
