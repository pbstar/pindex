<?php
include "../header.php";
$name = $_GET['name'];
$ak = '46c2a260636bf5864c282d20d60a1dad';
$sk = '5f6b9c5562649cec6d898f11c7dfb0ae';
$baseurl = 'https://www.coderutil.com/api/resou/v1/' . $name . '?access-key=' . $ak . '&secret-key=' . $sk;
if ($name) {
  $res = json_decode(file_get_contents($baseurl));
}
$data = new stdClass();
if ($res->code == '200') {
  $data->code = "200";
  $data->data = $res->data;
} else {
  $data->code = "201";
  $data->data = null;
}
echo json_encode($data, JSON_UNESCAPED_UNICODE);
