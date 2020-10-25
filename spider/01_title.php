<?php
// 推荐使用curl
// curl是一个需要手动开启
include __DIR__.'/function.php';

$url = 'https://news.ke.com/bj/baike/0033/';

$html = http_request($url);

// 正则表达式来匹配出 title

// 修饰符
// i 不区分大小写  U 禁止贪婪 s 忽略换行
/*#$preg = '/<title>(.*)<\/title>/iUs';
$preg = '#<title>(.*)</title>#iUs';

preg_match_all($preg,$html,$arr);

print_r($arr);*/

// 申明一个dom对象
$dom = new DOMDocument();
// 忽略html不严格的格式
libxml_use_internal_errors(1);
$dom->loadHTML($html);
// 转为xpath对象
$xpath = new DOMXPath($dom);

// 查询路径
/*$query = '/html/head/title';

$nodeList = $xpath->query($query);

foreach ($nodeList as $item){
    echo $item->nodeValue;
}*/

//查询所有的图片
//$query = '//img/@data-original';
$query = '/html/body/div[3]/div[2]/div/div[2]/div[2]//img/@data-original';
$nodeList = $xpath->query($query);

foreach ($nodeList as $item){
    echo $item->nodeValue."\n";
}




