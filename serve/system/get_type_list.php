<?php
include "../header.php";
$data = new stdClass();
$data->code = "200";
$data->data = array();
$type = new stdClass();
$type->type = 1;
$type->text = 'fanyi';
array_push($data->data, $type);
$type = new stdClass();
$type->type = 2;
$type->text = 'shoucang';
array_push($data->data, $type);
echo json_encode($data, JSON_UNESCAPED_UNICODE);
