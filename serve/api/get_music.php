<?php
include "../header.php";

date_default_timezone_set(PRC);
$currenttime=date("Ymd");

if(file_exists('../file/music/'.$currenttime.'.txt')){
  $file = fopen('../file/music/'.$currenttime.'.txt', 'r');
  $filesize = filesize('../file/music/'.$currenttime.'.txt');
  $content = json_decode(fread($file, $filesize));
}else{
  $ak = '46c2a260636bf5864c282d20d60a1dad';
  $sk = '5f6b9c5562649cec6d898f11c7dfb0ae';
  $baseurl = 'https://www.coderutil.com/api/music/v1/recommend?access-key=' . $ak . '&secret-key=' . $sk;
  $content = json_decode(file_get_contents($baseurl));
  $file = fopen('../file/music/'.$currenttime.'.txt', 'w');
  fwrite($file, file_get_contents($baseurl));
  fclose($file);
}

$data = new stdClass();
if ($content->code == '200') {
  $data->code = "200";
  $data->data = $content->data;
} else {
  $data->code = "201";
  $data->data = null;
}
echo json_encode($data, JSON_UNESCAPED_UNICODE);
