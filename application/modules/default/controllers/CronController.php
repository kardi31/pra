<?php

class Default_CronController extends MF_Controller_Action {

    protected $xml;
    protected $output;
    protected $filename;

    public function init() {
        ini_set('max_execution_time', 3600);

        Zend_Layout::getMvcInstance()->disableLayout();

        $this->_helper->viewRenderer->setNoRender();

        parent::init();

        $this->filename = 'sitemap_ocen.xml';
    }

    public function calculateVotesAndRatingAction() {
        $this->_helper->actionStack('layout');

        $reviewService = $this->_service->getService('Review_Service_Review');

        $reviewService->calculateBranchesVotesAndRating();
        $reviewService->calculateAgentsVotesAndRating();

        echo 'Cronbjob done';
        exit;
    }

    public function rankAgentsAction() {
        set_time_limit(0);

        $this->_helper->actionStack('layout');

        $agentService = $this->_service->getService('Agent_Service_Agent');

        $agentService->calculateAgentsRank();

        echo 'Cronbjob done';
        exit;
    }

    public function rankBranchesAction() {
        set_time_limit(0);

        $this->_helper->actionStack('layout');

        $branchService = $this->_service->getService('Branch_Service_Branch');

        $branchService->calculateBranchesRank();

        echo 'Cronbjob done';
        exit;
    }

    public function generateSitemapAction() {

        $this->output .= "Generating branches sitemap..." . date('H:i:s', time()) . "\n";
        $this->xml = new SimpleXMLElement('<urlset/>');
        $this->xml->addAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');

        $this->generateAgentsSitemap();
        $this->generateBranchesSitemap();
        $this->generateStaticSitemap();
        $this->generateSearchAreaSitemap();
        $this->generateRankingSitemap();
        
        $input = $this->xml->asXML();
        $output = APPLICATION_PATH . '/../public_html/' . $this->filename;

        $this->output .= $this->zipItUp($input, $output);

        die('done');
    }

    private function generateStaticSitemap() {
        
        try {
            $this->addUrl($this->view->url(array(),'domain-find-specialist'));
            $this->addUrl($this->view->url(array(),'domain-search-company'));
            $this->addUrl($this->view->url(array(),'domain-awards'));
            $this->addUrl($this->view->url(array(),'domain-premium-package'));
//            $this->addUrl($this->view->url(array(),'domain-advertising'));
            $this->addUrl($this->view->url(array(),'domain-about-reviews'));
            $this->addUrl($this->view->url(array(),'domain-privacy-policy'));
            $this->addUrl($this->view->url(array(),'domain-cookie-policy'));
            $this->addUrl($this->view->url(array(),'domain-terms-conditions'));
            $this->addUrl($this->view->url(array(),'domain-ranking'));
            $this->addUrl($this->view->url(array(),'domain-add-company'));
            $this->addUrl($this->view->url(array(),'domain-add-and-review-company'));
            $this->addUrl($this->view->url(array(),'domain-advertisment'));
            $this->addUrl($this->view->url(array(),'domain-news'));
            $this->addUrl($this->view->url(array(),'domain-contact'));
        } catch (Exception $e) {
            $this->output .= $e;
        }
    }
    
    private function generateAgentsSitemap() {
        $agentService = $this->_service->getService('Agent_Service_Agent');
        $agents = $agentService->getAllAgents();

        try {

            $x = 0;
            $file = 0;
            foreach ($agents as $agent) {
                if (count($agent['Branches']) > 1) {
                    $this->addUrl($this->view->url(array('slug' => $agent['link']), 'domain-agent-details'), $agent['updated_at']);
                }
            }
            $this->output .= 'Saving Branch Sitemap...' . $x . ' urls.' . "\n";

            //save AND Zip
        } catch (Exception $e) {
            $this->output .= $e;
        }
    }

    private function generateBranchesSitemap() {
        $branchService = $this->_service->getService('Branch_Service_Branch');
        $branches = $branchService->getAllBranches();

        try {

            foreach ($branches as $branch) {
                $this->addUrl($this->view->url(array('agent' => $branch['Agent']['link'], 'slug' => $branch['office_link']), 'domain-branch-details'), $branch['updated_at']);
                $this->addUrl($this->view->url(array('agent' => $branch['Agent']['link'], 'branch' => $branch['office_link']), 'domain-add-review-branch'));
            }
            //save AND Zip
        } catch (Exception $e) {
            $this->output .= $e;
        }
    }
    
    private function generateSearchAreaSitemap() {
        $branchService = $this->_service->getService('Branch_Service_Branch');
        $branches = $branchService->getBranchesByCategoryAndTown();
        $branchesRegion = $branchService->getBranchesByCategoryAndRegion();
        try {

            foreach ($branches as $branch) {
                $this->addUrl($this->view->url(array('categoryslug' => $branch['Agent']['Categories'][0]['Translation'][$this->view->language]['slug'], 'search' => strtolower($branch['town'])), 'domain-area-category-search-result'));
            }
            
            foreach ($branchesRegion as $branch) {
                $this->addUrl($this->view->url(array('categoryslug' => $branch['Agent']['Categories'][0]['Translation'][$this->view->language]['slug'], 'search' => strtolower($branch['county'])), 'domain-area-category-search-result'));
            }
            //save AND Zip
        } catch (Exception $e) {
            var_dump(($e->getMessage()));exit;
            $this->output .= $e;
        }
    }
    
    private function generateRankingSitemap() {
        $branchService = $this->_service->getService('Branch_Service_Branch');
        $branches = $branchService->getBranchesByCategoryAndTown();
        $branchesRegion = $branchService->getBranchesByCategoryAndRegion();
        try {

            foreach ($branches as $branch) {
                $this->addUrl($this->view->url(array('category' => $branch['Agent']['Categories'][0]['Translation'][$this->view->language]['slug'], 'region' => strtolower($branch['town'])), 'domain-ranking-region-category'));
            }
            
            foreach ($branchesRegion as $branch) {
                $this->addUrl($this->view->url(array('category' => $branch['Agent']['Categories'][0]['Translation'][$this->view->language]['slug'], 'region' => strtolower($branch['county'])), 'domain-ranking-region-category'));
            }
            //save AND Zip
        } catch (Exception $e) {
            var_dump(($e->getMessage()));exit;
            $this->output .= $e;
        }
    }
    
    

    private function addUrl($url, $last_modified = false) {
        $xml = $this->xml->addChild('url');
        $xml->addChild('loc', $url);
        if($last_modified)
        $xml->addChild('lastmod', gmdate('c', strtotime($last_modified)));
//        $xml->addChild('priority',$priority);
    }

    private function zipItUp($data, $output_file) {
        $ex = explode('/', $output_file);
        $file = end($ex);
        $fp = fopen($file, 'w');
        fwrite($fp, $data);
        fclose($fp);
        return 'Saved ' . $file . ' successfully' . "\n";
    }

}
