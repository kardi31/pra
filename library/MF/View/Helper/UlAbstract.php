<?php
/**
 * allagents
 * delboy1978uk
 * 23/07/15
 */

abstract class MF_View_Helper_UlAbstract
{
    /** @var \DOMDocument */
    protected $dom;

    public function __construct()
    {
        $dom = new DOMDocument('1.0', 'utf-8');
        $this->dom = $dom;
    }

    /**
     * @return string
     */
    public function getHtml()
    {
        return $this->dom->saveHTML();
    }

    /**
     * @return int
     */
    protected function getPosition()
    {
        return $this->dom->childNodes->length + 1;
    }

    /**
     * @param $link
     * @param $text
     */
    public function addLink($link,$text,$active = false)
    {
        $node = $this->generateNode($link,$text,$active);
        $this->dom->getElementsByTagName('ul')->item(0)->appendChild($node);
    }

    /**
     * @param $link
     * @param $text
     * @return DOMElement
     */
    protected abstract function generateNode($link,$text);
}