<?php
require 'vendor/autoload.php';

use QL\QueryList;

$loader = new Twig_Loader_Filesystem('templates');
$twig = new Twig_Environment($loader);

//配置信息
$baseUrl = 'http://www.dmm.co.jp/digital/videoa/';

function getHtml($url){
    global $baseUrl;
    $ql = QueryList::get($url,[],[
        'headers' => [
            'User-Agent' => 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.87 Mobile Safari/537.36', 
            "Referer" => $baseUrl,
            'Accept-Language' => 'en'
        ]
    ]);
    return $ql->getHtml();
    //echo $ql->find('title')->text();
}



