<?php
include "../header.php";
$name = $_GET['name'];
$type = 'wbHot';
if ($name == 'baidu') $type = 'baiduRD';
else if ($name == 'zhihu') $type = 'zhihuHot';
$baseurl = 'https://api.vvhan.com/api/hotlist?type=';
date_default_timezone_set("PRC");
$res = json_decode(iconv("GB2312", "UTF-8", file_get_contents($baseurl . $type)));
$data = new stdClass();
$data->code = "200";
$data->data = $res->$data;
echo json_encode($data, JSON_UNESCAPED_UNICODE);
