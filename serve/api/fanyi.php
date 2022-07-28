<?php
include "../header.php";
$text = $_GET['text'];
$from = $_GET['from'];
$to = $_GET['to'];
$appid = $_GET['appid'];
$salt = $_GET['salt'];
$sign = $_GET['sign'];
$baseurl = 'http://api.fanyi.baidu.com/api/trans/vip/translate?q=';
$urlPre = $baseurl . $text . '&from=' . $from . '&to=' . $to . '&appid=' . $appid . '&salt=' . $salt . '&sign=' . $sign;
$res = json_decode(iconv("GB2312", "UTF-8", file_get_contents($urlPre)));
$data = new stdClass();
$data->code = "200";
$data->data = new stdClass();
$data->data->text = $res->trans_result[0]->dst;
echo json_encode($data, JSON_UNESCAPED_UNICODE);
