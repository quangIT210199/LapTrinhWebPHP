<?php
//      Allow CORS

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");

require_once "vendor/autoload.php";
require_once 'app/Controllers/UserApi.php';
require_once './app/Controllers/ProCatesApi.php';
require_once './app/Controllers/ProductsApi.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$userApi = new UserApi();
$proCateApi = new ProCatesApi();
$proApi = new ProductsApi();

http_response_code(500);

echo json_encode(array("msg" => "Unknow endpoint quang oi"));

