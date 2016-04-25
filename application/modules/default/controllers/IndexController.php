<?php

class Default_IndexController extends MF_Controller_Action {

    public function indexAction() {
        $this->_helper->actionStack('layout');

        $agentService = $this->_service->getService('Agent_Service_Agent');
        $branchService = $this->_service->getService('Branch_Service_Branch');



        if (!$category = $agentService->getFullCategory($_COOKIE['category'], 'slug', $this->view->language)) {
            $category = $agentService->getRandomCategory();
        }

        $categoryBranches = $branchService->rankBranchesByCategory($category['Translation'][$this->view->language]['slug'], $this->view->language, Doctrine_Core::HYDRATE_RECORD, 3);

        $geolocationData = var_export(unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip=' . $_SERVER['REMOTE_ADDR'])), true);
        $userTown = (isset($geolocationData['geoplugin_city']) && strlen($geolocationData['geoplugin_city'])) ? $geolocationData['geoplugin_city'] : 'Kraków';

        $premiumBranches = $branchService->getRandomPremiumBranches();
        $bestTownBranches = $branchService->getBestTownBranches($userTown, 3);
        $newestBranches = $branchService->getNewestBranches(3);
//        $mapBranches = $branchService->getMapBranches(500, Doctrine_Core::HYDRATE_ARRAY);


        $bannerService = $this->_service->getService('Banner_Service_Banner');

        $banner = $bannerService->getPositionBanners('Homepage');
        $banner = $banner[0];
        $this->view->assign('banner', $banner);

        $metatagService = $this->_service->getService('Default_Service_Metatag');
        $metatagService->setCustomViewMetatags(array(
            'pl' => array(
                'title' => 'Opinie o firmach',
                'description' => 'Lista najlepszych firm w Polsce, opinie klientów o firmach.'
            ),
            'en' => array(
                'title' => 'Reviews of Polish companies',
                'description' => 'List of the best Polish companies, customer reviews, rankings.'
            )
                ), $this->view);


        $newsService = $this->_service->getService('News_Service_News');

        $lastNews = $newsService->getLastNews(6, Doctrine_Core::HYDRATE_ARRAY);

        $this->view->assign('lastNews', $lastNews);

        $this->view->assign('premiumBranches', $premiumBranches);
        $this->view->assign('bestTownBranches', $bestTownBranches);
        $this->view->assign('userTown', $userTown);
        $this->view->assign('category', $category);
//        $this->view->assign('mapBranches', $mapBranches);
        $this->view->assign('newestBranches', $newestBranches);
        $this->view->assign('categoryBranches', $categoryBranches);



        $form = new Branch_Form_RankingSearch();

        $form->getElement('category_id')->addMultiOption('', '');
        $form->getElement('category_id')->addMultiOptions($agentService->prependMainCategories($this->view->language, false));
        $form->getElement('category_id')->setName('category');
        $form->getElement('category_id')->setValue('');

        $form2 = new Agent_Form_SelectAgent();

        $this->view->assign('form', $form);
        $this->view->assign('form2', $form2);
    }
    public function searchAction() {
        $this->_helper->viewRenderer->setResponseSegment('search');
        $this->_helper->actionStack('layout', 'index', 'default');
    }
    
    public function sitemapAction(){
        if($this->view->language=='pl'){
            include(APPLICATION_PATH.'/../public_html/sitemap_ocen.xml');
        }
        else{
            include(APPLICATION_PATH.'/../public_html/sitemap_rate.xml');
        }
        exit;
    }

    public function awardsAction() {
        $this->_helper->actionStack('layout', 'index', 'default');
        $this->_helper->layout->setLayout('page');
        
        $metatagService = $this->_service->getService('Default_Service_Metatag');
        $metatagService->setCustomViewMetatags(array(
            'pl' => array(
                'title' => 'Nagrody dla firm',
                'description' => 'Nagrody dla najlepszych firma w opinii klientów.'
            ),
            'en' => array(
                'title' => 'Best Polish company awards',
                'description' => 'Best Polish company awards according to customers'
            )
                ), $this->view);
    }

    public function layoutAction() {


        $bannerService = $this->_service->getService('Banner_Service_Banner');
        $banners = $bannerService->getAllActiveBanners();
        $this->view->assign('banners', $banners);
        $this->_helper->actionStack('slider');
        $this->_helper->actionStack('menu');
        $this->_helper->viewRenderer->setNoRender(true);
    }

    public function thankYouAction() {
        $param = $this->getParam('type');
        $this->view->assign('param', $param);

        $metatagService = $this->_service->getService('Default_Service_Metatag');
        $metatagService->setCustomViewMetatags(array(
            'pl' => array(
                'title' => 'Dziękujemy'
            ),
            'en' => array(
                'title' => 'Thank you'
            )
                ), $this->view);

        $this->view->headMeta()->appendName('robots', 'noindex, follow');


        $this->_helper->actionStack('layout');

        $this->_helper->layout->setLayout('page');
    }

    public function sorryAction() {
        $param = $this->getParam('type');
        $this->view->assign('param', $param);

        $metatagService = $this->_service->getService('Default_Service_Metatag');
        $metatagService->setCustomViewMetatags(array(
            'pl' => array(
                'title' => 'Wystąpił błąd na stronie'
            ),
            'en' => array(
                'title' => 'An error occurred'
            )
                ), $this->view);

        $this->view->headMeta()->appendName('robots', 'noindex, follow');


        $this->_helper->actionStack('layout');

        $this->_helper->layout->setLayout('page');
    }

    public function footerAction() {
        $this->_helper->viewRenderer->setResponseSegment('footer');
    }

    public function contactAction() {

        $this->_helper->layout->setLayout('page');

        $serviceService = $this->_service->getService('Default_Service_Service');

        $mailService = $this->_service->getService('User_Service_Mail');

        $metatagService = $this->_service->getService('Default_Service_Metatag');
        $metatagService->setCustomViewMetatags(array(
            'pl' => array(
                'title' => 'Kontakt',
                'description' => 'Skontaktuj się z Oceń Fachowca'
            ),
            'en' => array(
                'title' => 'Contact',
                'description' => 'Contact with Rate Pole'
            )
                ), $this->view);

        $contactEmail = $this->getInvokeArg('bootstrap')->getOption('contact_email');
        $mailerEmail = $this->getInvokeArg('bootstrap')->getOption('mailer_email');
        $form = new Default_Form_ContactPage();

        if ($this->getRequest()->isPost()) {
            if ($form->isValid($this->getRequest()->getParams())) {
                try {
                    if (!strlen($contactEmail)) {
                        $this->_helper->alertor->gotoUrl($this->view->url(array('success' => 'fail'), 'domain-contact'));
                    }
                    
                    $values = $_POST;
                    
                    $options = $this->getFrontController()->getParam('bootstrap')->getOptions();
                    
                    $mail = new Zend_Mail('UTF-8');
                    $mail->setSubject($this->view->translate('Contact message Rate Pole'));
                    $mail->addTo($options['reply_email'], $options['reply_email']);
                    $mail->setReplyTo($values['email'], $values['name']);

                    $mailService->sendContactMail($values,$mail, $this->view);
                    

                    $this->_helper->getHelper('FlashMessenger')->setNamespace('success')->addMessage($this->view->translate('Thank you for your message. We will contact you soon.'));

                    $this->_helper->redirector->gotoUrl($this->view->url(array('success' => 'fail'), 'domain-contact'));
                } catch (Exception $e) {
                    $this->_service->get('doctrine')->getCurrentConnection()->rollback();
                    $this->_service->get('log')->log($e->getMessage(), 4);
                }
            }
        }
//          
//
//        $this->view->assign('form', $form);
        $this->_helper->actionStack('layout', 'index', 'default');
    }

    public function sliderAction() {
        $agentService = $this->_service->getService('Agent_Service_Agent');
        $rankingService = $this->_service->getService('Agent_Service_Ranking');

        $bestAgent = $rankingService->getBestAgentOfLastMonth();

//        $sliderService = $this->_service->getService('Slider_Service_Slider');
//        $slideLayerService = $this->_service->getService('Slider_Service_SlideLayer');
//        $mainSliderSlides = $sliderService->getAllForSlider("main");
//        $mainSlides = array();
//        foreach($mainSliderSlides[0]['Slides'] as $slide):
//            $layers = $slideLayerService->getLayersForSlide($slide['id']);
//            $slide['Layers'] = $layers;
//            $mainSlides[] = $slide;
//        endforeach;
//        $this->view->assign('mainSlides',$mainSlides);

        $this->view->assign('bestAgent', $bestAgent);
        $this->_helper->viewRenderer->setResponseSegment('slider');
    }

    public function menuAction() {
        $i18nService = $this->_service->getService('Default_Service_I18n');
        $menuService = $this->_service->getService('Menu_Service_Menu');


        if (!$menu = $menuService->getMenu(1)) {
            throw new Zend_Controller_Action_Exception('Menu not found');
        }

        $treeRoot = $menuService->getMenuItemTree($menu, $this->view->language);
        $tree = $treeRoot[0]->getNode()->getChildren();

        $activeLanguages = $i18nService->getLanguageList();

        $this->view->assign('activeLanguages', $activeLanguages);

        $this->view->assign('menu', $menu);
        $this->view->assign('tree', $tree);

        $this->_helper->viewRenderer->setNoRender();
    }

    public function aboutUsAction() {

        $pageService = $this->_service->getService('Page_Service_Page');
        $metatagService = $this->_service->getService('Default_Service_Metatag');

        if (!$page = $pageService->getI18nPage('about-us', 'type', $this->language, Doctrine_Core::HYDRATE_RECORD)) {
            throw new Zend_Controller_Action_Exception('Page not found');
        }

        if (!$dlaMediow = $pageService->getI18nPage('dla-mediow', 'type', $this->language, Doctrine_Core::HYDRATE_RECORD)) {
            throw new Zend_Controller_Action_Exception('Page not found');
        }

        $boardService = $this->_service->getService('League_Service_Board');
        $boards = $boardService->getAllBoards(Doctrine_Core::HYDRATE_ARRAY);
        $this->view->assign('boards', $boards);

        $metatagService->setViewMetatags($page['metatag_id'], $this->view);

        $this->_helper->actionStack('layout', 'index', 'default');
        $this->view->assign('page', $page);
        $this->view->assign('dlaMediow', $dlaMediow);
        $this->view->assign('hideSlider', true);
    }

    public function aboutReviewsAction() {
        $agentService = $this->_service->getService('Agent_Service_Agent');

        $metatagService = $this->_service->getService('Default_Service_Metatag');
        $metatagService->setCustomViewMetatags(array(
            'pl' => array(
                'title' => 'Wskazówki o opiniach',
                'description' => 'Przeczytaj nasze wskazówki dla oceniających i firm przed dodaniem opinii. Podstawowe informacje o opiniach.'
            ),
            'en' => array(
                'title' => 'About reviews',
                'description' => 'Read our review guidelines for reviewers and companies before adding a review. Basic informations about reviews'
            )
                ), $this->view);

        if ($this->view->language == 'pl') {
            $this->_helper->viewRenderer('index/about-reviews-pl', null, true);
        }

        $premiumAgents = $agentService->getRandomPremiumAgents();
        $popularAgents = $agentService->getMostPopularAgents();

        $this->view->assign('premiumAgents', $premiumAgents);
        $this->view->assign('popularAgents', $popularAgents);
        $this->_helper->actionStack('layout', 'index', 'default');

        $this->_helper->layout->setLayout('page');
    }

    public function privacyPolicyAction() {
        $agentService = $this->_service->getService('Agent_Service_Agent');

        $metatagService = $this->_service->getService('Default_Service_Metatag');
        $metatagService->setCustomViewMetatags(array(
            'pl' => array(
                'title' => 'Polityka prywatności',
                'description' => 'Polityka prywatności Oceń Fachowca'
            ),
            'en' => array(
                'title' => 'Privacy policy',
                'description' => 'Privacy policy of Rate Pole'
            )
                ), $this->view);

        if ($this->view->language == 'pl') {
            $this->_helper->viewRenderer('index/privacy-policy-pl', null, true);
        }

        $premiumAgents = $agentService->getRandomPremiumAgents();
        $popularAgents = $agentService->getMostPopularAgents();

        $this->view->assign('premiumAgents', $premiumAgents);
        $this->view->assign('popularAgents', $popularAgents);
        $this->_helper->actionStack('layout', 'index', 'default');

        $this->_helper->layout->setLayout('page');
    }

    public function cookiePolicyAction() {
        $agentService = $this->_service->getService('Agent_Service_Agent');

        $metatagService = $this->_service->getService('Default_Service_Metatag');
        $metatagService->setCustomViewMetatags(array(
            'pl' => array(
                'title' => 'Polityka cookie',
                'description' => 'Polityka cookie Oceń Fachowca'
            ),
            'en' => array(
                'title' => 'Cookie policy',
                'description' => 'Cookie policy of Rate Pole'
            )
                ), $this->view);

        if ($this->view->language == 'pl') {
            $this->_helper->viewRenderer('index/cookie-policy-pl', null, true);
        }

        $premiumAgents = $agentService->getRandomPremiumAgents();
        $popularAgents = $agentService->getMostPopularAgents();

        $this->view->assign('premiumAgents', $premiumAgents);
        $this->view->assign('popularAgents', $popularAgents);
        $this->_helper->actionStack('layout', 'index', 'default');

        $this->_helper->layout->setLayout('page');
    }

    public function termsConditionsAction() {
        $agentService = $this->_service->getService('Agent_Service_Agent');

        $metatagService = $this->_service->getService('Default_Service_Metatag');
        $metatagService->setCustomViewMetatags(array(
            'pl' => array(
                'title' => 'Zasady użytkowania strony',
                'description' => 'Zasady użytkowania strony Oceń Fachowca'
            ),
            'en' => array(
                'title' => 'Terms and conditions',
                'description' => 'Terms and conditions of Rate Pole'
            )
                ), $this->view);

        if ($this->view->language == 'pl') {
            $this->_helper->viewRenderer('index/terms-conditions-pl', null, true);
        }

        $premiumAgents = $agentService->getRandomPremiumAgents();
        $popularAgents = $agentService->getMostPopularAgents();

        $this->view->assign('premiumAgents', $premiumAgents);
        $this->view->assign('popularAgents', $popularAgents);
        $this->_helper->actionStack('layout', 'index', 'default');

        $this->_helper->layout->setLayout('page');
    }

    public function newsletterAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender('sidemenu');

        $subscriberService = $this->_service->getService('Newsletter_Service_Subscriber');

        $translator = $this->_service->get('Zend_Translate');
        $form = $subscriberService->getRegisterForm();

        $form->removeElement('first_name');
        $form->removeElement('last_name');


        if ($this->getRequest()->isPost()) {
            if ($form->isValid($this->getRequest()->getPost())) {
                try {
                    $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();

                    if ($subscriberService->subscriberExists(array('email' => $form->getValue('email')))) {
                        $this->_helper->redirector->gotoUrl($this->view->url(array('type' => 'newsletter'), 'domain-sorry'));
                    } else {

                        $values = $form->getValues();
                        $values['token'] = MF_Text::createUniqueToken($values['salt'] . $values['email']);
                        $values['lang'] = $this->view->language;

                        $subscriberService->saveSubscriberFromArray($values);


                        $this->_helper->redirector->gotoUrl($this->view->url(array('type' => 'newsletter'), 'domain-thank-you'));
                    }

                    $this->_service->get('doctrine')->getCurrentConnection()->commit();
                    $this->_helper->redirector->gotoRoute(array('type' => 'newsletter'), 'domain-thank-you');
                } catch (User_Model_UserWithEmailAlreadyExistsException $e) {
                    $this->_service->get('doctrine')->getCurrentConnection()->rollback();
                    $form->getElement('email')->markAsError();
                    $form->getElement('email')->setErrors(array($e->getMessage()));
                } catch (Exception $e) {
                    $this->_service->get('doctrine')->getCurrentConnection()->rollback();
                    $this->_service->get('log')->log($e->getMessage(), 4);
                }
            }
        }
        $this->view->assign('form', $form);

        $this->_helper->actionStack('layout', 'index', 'default');
    }

    
    public function findSpecialistAction() {
        $messageService = $this->_service->getService('Default_Service_Message');
        $form = new Default_Form_FindSpecialist();
        $this->view->assign('form', $form);

        $config = Zend_Controller_Front::getInstance()->getParam('bootstrap');
        $apikeys = $config->getOption('apikeys');
        $form->addElement('Recaptcha', 'g-recaptcha-response', [
            'siteKey' => $apikeys['google']['siteKey'],
            'secretKey' => $apikeys['google']['secretKey']
        ]);
//        
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($this->getRequest()->getPost())) {
                try {
                    $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();

                    $values = $form->getValues();

                    $messageService->saveMessageFromArray($values);

                    $this->_helper->redirector->gotoUrl($this->view->url(array('type' => 'find-specialist'), 'domain-thank-you'));

                    $this->_service->get('doctrine')->getCurrentConnection()->commit();
                } catch (Exception $e) {
                    $this->_service->get('doctrine')->getCurrentConnection()->rollback();
                    $this->_service->get('log')->log($e->getMessage(), 4);
                }
            }
        }
    }
    
    public function premiumPackageAction(){
        $agentService = $this->_service->getService('Agent_Service_Agent');

        $metatagService = $this->_service->getService('Default_Service_Metatag');
        $metatagService->setCustomViewMetatags(array(
            'pl' => array(
                'title' => 'Pakiet premium',
                'description' => 'Odkryj zalety pakietu premium'
            ),
            'en' => array(
                'title' => 'Premium Package',
                'description' => 'Find benefits of premium package'
            )
        ),$this->view);
        
        if($this->view->language=='pl'){
            $this->_helper->viewRenderer('index/premium-package-pl', null, true);
        }

        $premiumAgents = $agentService->getRandomPremiumAgents();
        $popularAgents = $agentService->getMostPopularAgents();
        
        $this->view->assign('premiumAgents', $premiumAgents);
        $this->view->assign('popularAgents', $popularAgents);
        $this->_helper->actionStack('layout', 'index', 'default');

        $this->_helper->layout->setLayout('page');
    }
}
