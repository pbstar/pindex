<?php
header('Content-Type:text/json;charset=utf-8');
header("Access-Control-Allow-Origin:*");
header("Access-Control-Allow-Headers:token,Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods:POST,GET');
header('Access-Control-Expose-Headers:*');
if (strtoupper($_SERVER['REQUEST_METHOD']) == 'OPTIONS') exit;
$origin = $_SERVER['HTTP_ORIGIN'];
$allowOrigin = array(
    'http://pindex.mcweb.club',
    'http://localhost:8080',
    'http://localhost:8081'
);
$boo=1;
if (in_array($origin, $allowOrigin)) $boo=2;
if($boo==1){
    $data = new stdClass();
    $data->code = "500";
    die(json_encode($data, JSON_UNESCAPED_UNICODE));
}
