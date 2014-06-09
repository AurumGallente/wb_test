<?php
set_include_path(implode(PATH_SEPARATOR, array(
    realpath('./library'),//the path
    get_include_path(),
)));
require "Zend/Loader/Autoloader.php";
$autoloader = Zend_Loader_Autoloader::getInstance();

$channel = new Zend_Feed_Rss('http://feeds.bbci.co.uk/news/rss.xml?edition=uk');
    
        $channel = new Zend_Feed_Rss('http://feeds.bbci.co.uk/news/rss.xml?edition=uk');
        //echo $channel->title();
        $i = 0;
        $result = array();
        foreach ($channel as $item) {
            $news = array();
            $news['title'] = $item->title();
            $news['description'] = $item->description();
            $news['link'] = $item->link();
            //echo $item->title();
           // echo $item->description();
            //echo $item->link();
            $i++;
            $client = new Zend_Http_Client();
            $client->setUri($item->link());
            $response = $client->request(); 
            $html = $response->getBody();
            $value=preg_match_all('/width\">(.*?)<\/div>/s',$html,$m);
            $value = preg_match_all('/src=\"(.*?)\"\s/', $m[0][0], $n);
            $news['img'] = $n[1][0];
            $result[] = $news;
           //echo ($n[1][0]);            
            if($i >= 10)
                break;
           
        }
        header('Content-Type: application/json');
        echo json_encode($result);


 

