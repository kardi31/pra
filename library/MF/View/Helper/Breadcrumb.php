<?php
/**

 * Google SEO Friendly Breadcrumbs
 *

 */
class MF_View_Helper_Breadcrumb
{
    private static $instance = null;

    private $_ul;

    private $page;
    
    public function __construct() {
        $this->_ul = new MF_View_Helper_Ul();
    }
    
    public static function getInstance()
    {
        if (!isset(static::$instance)) {
            static::$instance = new MF_View_Helper_Breadcrumb();
        }
        return static::$instance;
    }


    
    public function addLink($link,$name,$active = false)
    {
        $this->_ul->addLink($link,$name,$active);
    }

    
    public function getHtml(){
        $this->page ? $this->page->generate($this) : null;
        return $this->_ul->getHtml();
    }
    
    public function getBreadcrumbs(){
        return '<div class="container breadcrub">
            <div>
                <a class="homebtn left" href="/"></a>
                <div class="left">
                    <ul class="bcrumbs">
                        '.$this->getHtml().'
                    </ul>				
                </div>

            </div>
            <div class="clearfix"></div>
            <div class="brlines"></div>
        </div>';
    }

}