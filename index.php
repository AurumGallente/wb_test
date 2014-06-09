<?php
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(1);
error_reporting(E_ALL);
set_include_path(implode(PATH_SEPARATOR, array(
    realpath('./library'),//the path
    get_include_path(),
)));
require "Zend/Loader/Autoloader.php";
$autoloader = Zend_Loader_Autoloader::getInstance();
require_once 'ImageClass.php';
$imageParser = new Parser_Provider_Image();
$channel = new Zend_Feed_Rss('http://feeds.bbci.co.uk/news/rss.xml?edition=uk');    
        $channel = new Zend_Feed_Rss('http://feeds.bbci.co.uk/news/rss.xml?edition=uk');
        //echo $channel->title();
        $i = 0;
        $result = array();
        foreach ($channel as $item) {
            $height = 10;
            $width = 10;
            $news = array();
            $news['title'] = $item->title();
            $news['description'] = $item->description();
            $news['link'] = $item->link();
            $i++;
            $client = new Zend_Http_Client();
            $client->setUri($item->link());
            $response = $client->request(); 
            $html = $response->getBody();
            $value=preg_match_all('/width\">(.*?)<\/div>/s',$html,$m);
            $images = array();
            foreach($m[0] as $image){
               $v = preg_match_all('/src=\"(.*?)\"\s/', $image, $n);
               $image = $n[1][0];
               $dimentions = $imageParser->getImageSize($image);
               if($dimentions[0]*$dimentions[1]> $height*$width){
                   if($dimentions[0]>10){
                    $news['img'] = $n[1][0];
                    $width = $dimentions[0];
                    $height = $dimentions[1];
                   }
               }
               $images[] = $news['img'];
               $d = $imageParser->getImageSize($news['img']);
            }            
            $result[] = $news;         
            if($i >= 10)
                break;          
        }
        header('Content-Type: application/json');
        echo json_encode($result);