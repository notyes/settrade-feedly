<?php 
require "vendor/autoload.php";
use PHPHtmlParser\Dom;

if ( empty( $_GET['set'] ) ) {
    echo 'require set name ???'; die();
}

$dom = new Dom;
$dom->loadFromUrl('http://stock.gapfocus.com/detail/'.strtoupper($_GET['set']));
$domList = $dom->find('#result');
$domFilter = $domList->find('.filter')->delete();

$items = array();

foreach ($domList->find('a') as $key => $value) {
    $image_link = $value->find('img')->getAttribute('src');
    $value->find('img')->setAttribute('src', 'http://stock.gapfocus.com'.$image_link);
    $htmlData = $value->outerHtml;

    $link = $value->getAttribute('href');
    $image_url = $value->find('img')->getAttribute('src');

    $time = $value->find('.talk-date')->text;
    $detail = $value->find('.talk-row .talk-detail l')->text;

    $time = explode( ' ', $time );
    $timestamp = strtotime( $time[0].' '.$time[1].' '.date('Y').' '.$time[2] );
    $timeSet = date( 'D, d M Y H:i:s O', $timestamp );

    $items[] = array(
        'title' => $detail,
        'description' => $detail,
        'url' => $link,
        'category' => 'Set',
        'date' => $timeSet,
        'img' => $img = ( ! empty( $image_url ) ) ? $image_url : 'https://placeholdit.imgix.net/~text?txtsize=130&txt=No-Image&w=1520&h=500' ,
        );
}

require 'rss.php';

$rss = new RSS;
$rss->title = 'RSS Storylog';
$rss->url = 'http://storylog.rss.acofy.com/';
$rss->description = 'Storylog - Storytelling Community';
$rss->date = $items[0]['date'];
$rss->items = $items;
echo $rss->generate();

