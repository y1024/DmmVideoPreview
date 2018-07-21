<?php
require 'functions.php';
use QL\QueryList;

$sort = isset($_GET['sort']) ? $_GET['sort'] : 'date';
$page = isset($_GET['page']) ? $_GET['page'] :1;
$prev = $page > 1 ? $page -1 : '#';
$newUrl = $baseUrl . '-/list/=/limit=30/';

//搜索时，变更baseurl
$searchStr = isset($_GET['searchstr']) ? $_GET['searchstr'] : false;
if($searchStr){
    $newUrl = 'http://www.dmm.co.jp/search/=/searchstr='.$searchStr.'/';
}

$n1 = isset($_GET['n1']) ? $_GET['n1'] : false;
if($n1){
    $newUrl .= "n1=$n1/";
    $n2 = isset($_GET['n2']) ? $_GET['n2'] : false;
    if($n2){
        $newUrl .= "n2=$n2/";
    }
}

if(isset($sort)){
    $newUrl .= "sort=$sort/";
}
if($page >1){
    $newUrl = $newUrl . "page=$page/";
}else{
    $page =1;
}
//echo $newUrl;
$html = "";
$html = getHtml($newUrl);

//采集规则
$rules = [
    'title' => ['.flb-works-detail dt','text','-span'],
    'img' => ['img','src'],
    'video' => ['.ds-btn-play a','href']
];
if($searchStr){
    $rules = [
        'title' => ['.ttl-list','text'],
        'img' => ['img','src'],
        'video' => ['.btn a','href']
    ];
}
$ql = QueryList::html($html)->rules($rules)->range('.flb-works')->query();
$data = $ql->getData()->all();

$datas = [];
$num = 0;
foreach($data as $d){
    if($d['video'] != null){
        $d['img'] = str_replace('ps.','pl.',$d['img']);
        $datas[$num] = $d;
        $num = $num +1;
    }
}
//print_r($datas);
$titleList=[
    'date'=>'最近更新',
    "ranking"=>'人气最佳',
    "saleranking_asc"=>'销量排序',
    "review_rank"=>'评价排序'
];

echo $twig->render('index.html', array('title' => $titleList[$sort],'page'=>$page,'sort'=>$sort,'data'=>$datas));

?>
