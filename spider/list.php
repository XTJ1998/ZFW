<?php
// 永不超时 -- cli    不能用nginx apache
set_time_limit(0);

include __DIR__ . '/function.php';
require __DIR__ . '/vendor/autoload.php';

use QL\QueryList;

$db = new PDO('mysql:host=localhost;dbname=wwwzfwcom;charset=utf8mb4', 'root', 'root');

$rang = range(1, 2);

foreach ($rang as $page) {
    $url = 'https://news.ke.com/bj/baike/0033/pg' . $page . '/';
    $html = http_request($url);
    // 分析采集到的内容
    $datalist = QueryList::Query($html, [
        "pic" => ['.lj-lazy', 'data-original', '', function ($item) {
            // 得到扩展名
            $ext = pathinfo($item, PATHINFO_EXTENSION);
            // 生成文件名
            $filename = md5($item) . '_' . time() . '.' . $ext;
            // 生成的本地路径
            $filepath = dirname(__DIR__) . '/public/uploads/article/' . $filename;
            file_put_contents($filepath, http_request($item));
            return '/uploads/article/' . $filename;
        }],
        "title" => ['.item .text .LOGCLICK', 'text'],
        "desn" => ['.item .text .summary', 'text'],
        "url" => ['.item .text > a', 'href']
    ])->data;

    // 入库
    foreach ($datalist as $val) {

        // 判断标题是否存在，存在则不进行入库

        //extract($val);
        // 添加的sql预处理
        $sql = "insert into zfw_articles (title,desn,pic,url,body) values (?,?,?,?,'')";
        //echo "insert into zfw_articles (title,desn,pic,url) values ('$title','$desn','$pic','$url')";
        //exit;
        $stmt = $db->prepare($sql);
        // 入库
        $stmt->execute([$val['title'], $val['desn'], $val['pic'], $val['url']]);
    }

}



