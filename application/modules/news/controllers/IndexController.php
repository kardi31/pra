<?php

/**
 * News_IndexController
 *
 * @author Tomasz Kardas <biuro@kardimobile.pl>
 */
class News_IndexController extends MF_Controller_Action {

    public static $articleItemCountPerPage = 12;

    public function indexAction() {
        
        $newsService = $this->_service->getService('News_Service_News');
        $agentService = $this->_service->getService('Agent_Service_Agent');


        $query = $newsService->getNewsPaginationQuery($this->language);

        $adapter = new MF_Paginator_Adapter_Doctrine($query, Doctrine_Core::HYDRATE_ARRAY);
        $paginator = new Zend_Paginator($adapter);
        $paginator->setCurrentPageNumber($this->getRequest()->getParam('page', 1));
        $paginator->setItemCountPerPage(self::$articleItemCountPerPage);
        
        $metatagService = $this->_service->getService('Default_Service_Metatag');
        $metatagService->setCustomViewMetatags(array(
            'pl' => array(
                'title' => 'Aktualności',
                'description' => 'Aktualności dla pracowników'
            ),
            'en' => array(
                'title' => 'News for Polish employees',
                'description' => 'Read advertisments for Polish employees'
            )
        ),$this->view);
        

        $premiumAgents = $agentService->getRandomPremiumAgents();
        $popularAgents = $agentService->getMostPopularAgents();
        
        $popularArticles = $newsService->getPopularNews(10); 
        
        $this->view->assign('premiumAgents', $premiumAgents);
        $this->view->assign('popularAgents', $popularAgents);
        $this->view->assign('popularArticles', $popularArticles);
        $this->view->assign('paginator', $paginator);
        $this->_helper->actionStack('layout', 'index', 'default');

        $this->_helper->layout->setLayout('page');
    }

    

    public function articleAction() {
        $newsService = $this->_service->getService('News_Service_News');
        if (!$article = $newsService->getFullArticle($this->getRequest()->getParam('slug'), 'slug')) {
            throw new Zend_Controller_Action_Exception('Article not found', 404);
        }
        
        $agentService = $this->_service->getService('Agent_Service_Agent');

        $metatagService = $this->_service->getService('Default_Service_Metatag');
        $metatagService->setCustomViewMetatags(array(
            'pl' => array(
                'title' => $article['Translation'][$this->view->language]['title'],
                'description' => $article['Translation'][$this->view->language]['content']
            ),
            'en' => array(
                'title' => $article['Translation'][$this->view->language]['title'],
                'description' => $article['Translation'][$this->view->language]['content']
            )
        ),$this->view);
        $metatagService->setOgMetatags($this->view,$article['Translation'][$this->view->language]['title'],'/media/photos/'.$article['Photos'][1]['offset']."/".$article['Photos'][1]['filename'],$article['Translation'][$this->view->language]['content']);
    
        
        $premiumAgents = $agentService->getRandomPremiumAgents();
        $popularAgents = $agentService->getMostPopularAgents();
        
        $popularArticles = $newsService->getPopularNews(10); 
        
        $this->view->assign('premiumAgents', $premiumAgents);
        $this->view->assign('popularAgents', $popularAgents);
        $this->view->assign('popularArticles', $popularArticles);
        $this->_helper->actionStack('layout', 'index', 'default');

        $this->_helper->layout->setLayout('page');

        $this->view->assign('article', $article);


        $this->_helper->actionStack('layout', 'index', 'default');

        $this->_helper->layout->setLayout('page');
    }
}
