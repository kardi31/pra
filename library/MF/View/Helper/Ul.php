<?php
/**
 * allagents
 * delboy1978uk
 * 23/07/15
 */


class MF_View_Helper_Ul extends MF_View_Helper_UlAbstract
{
    public function __construct()
    {
        parent::__construct();
        $element = $this->dom->createElement('ul');
        $element->setAttribute('class','bcrumbs');
        $element->setAttribute('itemscope',null);
        $element->setAttribute('itemstype','http://schema.org/BreadcrumbList');
        $this->dom->appendChild($element);

    }

    /**
     * @param $link
     * @param $text
     * @param bool $active
     * @return DOMElement
     */
    protected function generateNode($link,$text,$active = false)
    {
        
        $li = $this->dom->createElement('li');
        $a = $this->dom->createElement('a');
        $span = $this->dom->createElement('span');
        $textNode = $this->dom->createTextNode($text);
        $span->appendChild($textNode);
            
        $meta = $this->dom->createElement('meta');

        $li->setAttribute('itemscope',null);
        $li->setAttribute('itemprop','itemListElement');
        $li->setAttribute('itemtype','http://schema.org/ListItem');

        $a->setAttribute('itemprop','item');
        $a->setAttribute('href',$link);
        if($active){
            
            if($link=='#'){
                $a->setAttribute('href','http://'.$_SERVER[HTTP_HOST].$_SERVER[REQUEST_URI]);
            }
            $a->setAttribute('class','active');
        }

        $span->setAttribute('itemprop','name');

        $meta->setAttribute('itemprop','position');
        $meta->setAttribute('content',$this->getPosition());

        $a->appendChild($span);
        $li->appendChild($a);
        $li->appendChild($meta);

        return $li;
    }
}
