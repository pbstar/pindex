<?php
include "../header.php";
$type = $_GET['type'];
$data = new stdClass();
$data->code = "200";
$data->data = array();
if ($type == 0) {
  array_push($data->data, 'cd');
  array_push($data->data, 'help');
} else {
  array_push($data->data, 'cd..');
  if ($type == 2) {
    array_push($data->data, 'add');
    array_push($data->data, 'del');
    array_push($data->data, 'list');
  }
}
echo json_encode($data, JSON_UNESCAPED_UNICODE);
