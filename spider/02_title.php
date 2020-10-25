<?php
// 永不超时 -- cli    不能用nginx apache
set_time_limit(0);

include __DIR__ . '/function.php';
require __DIR__ . '/vendor/autoload.php';

use QL\QueryList;

$url = 'https://news.ke.com/bj/baike/0033/';
$html = http_request($url);

$datalist = QueryList::Query($html, [
    "img" => ['.lj-lazy', 'data-original'],
    "title" => ['.item .text .LOGCLICK', 'text'],
    "desn" => ['.item .text .summary', 'text'],
    "href" => ['.item .text > a', 'href']
])->data;


var_dump($datalist);

