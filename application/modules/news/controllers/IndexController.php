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
        $metatagService = $this->_service->getService('Default_Service_Metatag');
        $agentService = $this->_service->getService('Agent_Service_Agent');


        $query = $newsService->getNewsPaginationQuery($this->language);

        $adapter = new MF_Paginator_Adapter_Doctrine($query, Doctrine_Core::HYDRATE_ARRAY);
        $paginator = new Zend_Paginator($adapter);
        $paginator->setCurrentPageNumber($this->getRequest()->getParam('page', 1));
        $paginator->setItemCountPerPage(self::$articleItemCountPerPage);
        
//        $metatagService->setViewMetatags(array('title' => 'Wiadomości - Polacy w Wielkiej Brytanii'),$this->view);

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

    public function breakingNewsAction() {
        $newsService = $this->_service->getService('News_Service_News');

        $breakingNews = $newsService->getBreakingNews(Doctrine_Core::HYDRATE_ARRAY);
        $this->view->assign('breakingNews', $breakingNews);


        $this->_helper->viewRenderer->setResponseSegment('breakingNews');
    }

    public function lastCategoriesNewsAction() {
        $newsService = $this->_service->getService('News_Service_News');
        $categoryService = $this->_service->getService('News_Service_Category');


        $categories = $categoryService->getAllCategories();
        $newsList = array();
        foreach ($categories as $category):
            if ($category['title'] == "Reportaże")
                continue;
            $newsList[$category['title']] = $newsService->getLastCategoryNews($category['id'], 6, Doctrine_Core::HYDRATE_ARRAY);
        endforeach;

        $this->view->assign('newsList', $newsList);


        $this->_helper->viewRenderer->setResponseSegment('lastCategoriesNews');
    }

    public function lastNewsSidebarAction() {
        $newsService = $this->_service->getService('News_Service_News');

        $lastNewsSidebar = $newsService->getLastNews(3, Doctrine_Core::HYDRATE_ARRAY);

        $this->view->assign('lastNewsSidebar', $lastNewsSidebar);


        $this->_helper->viewRenderer->setResponseSegment('lastNewsSidebar');
    }

    public function listNewsAction() {
        $newsService = $this->_service->getService('News_Service_News');
        $metatagService = $this->_service->getService('Default_Service_Metatag');


        $query = $newsService->getNewsPaginationQuery($this->language);

        $adapter = new MF_Paginator_Adapter_Doctrine($query, Doctrine_Core::HYDRATE_ARRAY);
        $paginator = new Zend_Paginator($adapter);
        $paginator->setCurrentPageNumber($this->getRequest()->getParam('page', 1));
        $paginator->setItemCountPerPage(self::$articleItemCountPerPage);
        
        $metatagService->setViewMetatags(array('title' => 'Wiadomości - Polacy w Wielkiej Brytanii'),$this->view);

        $this->view->assign('paginator', $paginator);
        $this->_helper->actionStack('layout', 'index', 'default');

        $this->_helper->layout->setLayout('page');
    }

    public function listNewsCategoryAction() {
        $newsService = $this->_service->getService('News_Service_News');
        $categoryService = $this->_service->getService('News_Service_Category');


        if (!$category = $categoryService->getCategory($this->getRequest()->getParam('category'), 'slug', Doctrine_Core::HYDRATE_RECORD)) {
            throw new Zend_Controller_Action_Exception('Category not found');
        }


        $newsList = $newsService->getLastCategoryNews($category['id'], null, Doctrine_Core::HYDRATE_ARRAY);


        $this->view->assign('category', $category);
        $this->view->assign('newsList', $newsList);

        $this->_helper->layout->setLayout('article');

        $this->_helper->actionStack('layout', 'index', 'default');
    }

    public function categoryAction() {

        $this->_helper->layout->setLayout('article');
        $this->_helper->actionStack('layout', 'index', 'default');


        $pageService = $this->_service->getService('Page_Service_Page');
        $metatagService = $this->_service->getService('Default_Service_Metatag');
        $newsService = $this->_service->getService('News_Service_News');
        $categoryService = $this->_service->getService('News_Service_Category');

        if (!$category = $categoryService->getCategory($this->getRequest()->getParam('slug'), 'slug')) {
            throw new Zend_Controller_Action_Exception('Category not found', 404);
        }

        if (!$page = $pageService->getPage($this->getRequest()->getParam('slug'), 'type')) {
            
        }

        $query = $newsService->getCategoryPaginationQuery($category['id'], $this->language);

        $adapter = new MF_Paginator_Adapter_Doctrine($query, Doctrine_Core::HYDRATE_ARRAY);
        $paginator = new Zend_Paginator($adapter);
        $paginator->setCurrentPageNumber($this->getRequest()->getParam('page', 1));
        $paginator->setItemCountPerPage(self::$articleItemCountPerPage);

        $this->view->assign('paginator', $paginator);


        $metatagService->setViewMetatags($page['metatag_id'], $this->view);


        $this->view->assign('paginator', $paginator);
        $this->view->assign('category', $category);
    }

    public function searchAction() {
        $newsService = $this->_service->getService('News_Service_News');
        $pageService = $this->_service->getService('Page_Service_Page');
        $metatagService = $this->_service->getService('Default_Service_Metatag');

        $search = $this->getRequest()->getParam('search_name');
        $search = $this->view->escape($search);
        $searchResults = $newsService->findNews($search, Doctrine_Core::HYDRATE_ARRAY);

        if (!$page = $pageService->getPage('wyniki-wyszukiwania', 'type')) {
            
        }

        $metatagService->setViewMetatags($page['metatag_id'], $this->view);

        $this->view->assign('newsList', $searchResults);
        $this->view->assign('search', $search);

        $this->_helper->layout->setLayout('article');

        $this->_helper->actionStack('layout', 'index', 'default');
    }

    public function groupAction() {

        $this->_helper->layout->setLayout('article');
        $this->_helper->actionStack('layout', 'index', 'default');


        $pageService = $this->_service->getService('Page_Service_Page');
        $metatagService = $this->_service->getService('Default_Service_Metatag');
        $newsService = $this->_service->getService('News_Service_News');
        $groupService = $this->_service->getService('News_Service_Group');

        if (!$group = $groupService->getGroup($this->getRequest()->getParam('slug'), 'slug')) {
            throw new Zend_Controller_Action_Exception('Group not found', 404);
        }

        if (!$page = $pageService->getPage($this->getRequest()->getParam('slug'), 'type')) {
            
        }

        $metatagService->setViewMetatags($page['metatag_id'], $this->view);

        $newsList = $newsService->getGroupNews($group['id'], Doctrine_Core::HYDRATE_ARRAY);

        $this->view->assign('newsList', $newsList);
        $this->view->assign('group', $group);
    }

    public function tagAction() {

        $this->_helper->layout->setLayout('article');
        $this->_helper->actionStack('layout', 'index', 'default');


        $pageService = $this->_service->getService('Page_Service_Page');
        $metatagService = $this->_service->getService('Default_Service_Metatag');
        $newsService = $this->_service->getService('News_Service_News');
        $tagService = $this->_service->getService('News_Service_Tag');

        if (!$tag = $tagService->getTag($this->getRequest()->getParam('slug'), 'slug')) {
            throw new Zend_Controller_Action_Exception('Tag not found', 404);
        }


        $metatagService->setViewMetatags($tag['metatag_id'], $this->view);

        $newsList = $newsService->getTagNews($tag['id'], Doctrine_Core::HYDRATE_ARRAY);

        $this->view->assign('newsList', $newsList);
        $this->view->assign('tag', $tag);
    }

    public function studentAction() {

        $this->_helper->layout->setLayout('article');
        $this->_helper->actionStack('layout', 'index', 'default');


        $pageService = $this->_service->getService('Page_Service_Page');
        $metatagService = $this->_service->getService('Default_Service_Metatag');
        $newsService = $this->_service->getService('News_Service_News');
        if (!$page = $pageService->getPage('studencka-tworczosc', 'type')) {
            
        }

        $metatagService->setViewMetatags($page['metatag_id'], $this->view);

        $newsList = $newsService->getStudentNews(Doctrine_Core::HYDRATE_ARRAY);

        $this->view->assign('newsList', $newsList);
    }

    public function articleAction() {
        $newsService = $this->_service->getService('News_Service_News');
        $adService = $this->_service->getService('Banner_Service_Ad');
        $metatagService = $this->_service->getService('Default_Service_Metatag'); 
        if (!$article = $newsService->getFullArticle($this->getRequest()->getParam('slug'), 'slug')) {
            throw new Zend_Controller_Action_Exception('Article not found', 404);
        }
        
        $agentService = $this->_service->getService('Agent_Service_Agent');


        
//        $metatagService->setViewMetatags(array('title' => 'Wiadomości - Polacy w Wielkiej Brytanii'),$this->view);

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

    
    public function guideAction() {
        $guideService = $this->_service->getService('News_Service_Guide');
        $metatagService = $this->_service->getService('Default_Service_Metatag');
        if (!$guide = $guideService->getFullGuide($this->getRequest()->getParam('slug'), 'slug')) {
            throw new Zend_Controller_Action_Exception('Article not found', 404);
        }

        $pageWasRefreshed = isset($_SERVER['HTTP_CACHE_CONTROL']) && $_SERVER['HTTP_CACHE_CONTROL'] === 'max-age=0';

        if (!$pageWasRefreshed) {
            $guide->increaseView();
        }

        $lastCategoryOtherArticles = $guideService->getLastCategoryOtherArticles($guide, Doctrine_Core::HYDRATE_ARRAY);


        $metatagService->setViewMetatags(array('title' => $guide['Translation'][$this->view->language]['title']." - Poradniki dla Polaków w Wielkiej Brytanii",'description' => $guide['Translation'][$this->view->language]['content']), $this->view);
        $metatagService->setOgMetatags($this->view, $guide['Translation'][$this->view->language]['title'], '/img/logo.png', $guide['Translation'][$this->view->language]['content']);

        $this->view->assign('guide', $guide);

        $this->view->assign('lastCategoryOtherArticles', $lastCategoryOtherArticles);


        $this->_helper->actionStack('layout', 'index', 'default');

        $this->_helper->layout->setLayout('page');
    }
    
    public function streamAction() {
        $streamService = $this->_service->getService('News_Service_Stream');
        $metatagService = $this->_service->getService('Default_Service_Metatag');

        if (!$stream = $streamService->getFullStream($this->getRequest()->getParam('slug'), 'slug')) {
            throw new Zend_Controller_Action_Exception('Stream not found', 404);
        }

        $metatagService->setViewMetatags($stream->get('Metatags'), $this->view);
        $metatagService->setOgMetatags($this->view, $stream['Translation'][$this->view->language]['title'], '', $stream['Translation'][$this->view->language]['content']);


        $this->view->assign('stream', $stream);


        $this->_helper->actionStack('layout', 'index', 'default');

        $this->_helper->layout->setLayout('article');
    }

    public function facebookAction() {
        
    }

}
