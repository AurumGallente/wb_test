<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        if ($this->_helper->FlashMessenger->hasMessages()) {
            $this->view->messages = $this->_helper->FlashMessenger->getMessages();
            $messages = $this->_helper->flashMessenger->getMessages();
            if(!empty($messages)){
                $this->_helper->layout->getView()->message = $messages[0];
            }            
        }
    }

    public function indexAction()
    {
        $this->getHelper('Layout')
             ->disableLayout();

        $this->getHelper('ViewRenderer')
             ->setNoRender();

        $this->getResponse()
             ->setHeader('Content-Type', 'application/json');        
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
        echo $this->_helper->json->sendJson($result);
        //print_r($channel);
    }


}

