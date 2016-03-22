<?php

/**
 * Class FormRecaptcha
 *
 * @package Cgsmith
 * @license MIT
 * @author  Chris Smith
 */
require_once 'Zend/View/Helper/FormElement.php';
class Zend_View_Helper_FormRecaptcha extends Zend_View_Helper_FormElement
{
    /**
     * For google recaptcha div to render properly
     *
     * @param $name
     * @param null $value
     * @param null $attribs
     * @param null $options
     * @param string $listsep
     * @return string
     * @throws Zend_Exception
     */
    public function formRecaptcha($name, $value = null, $attribs = null, $options = null, $listsep = '')
    {
        if (!isset($attribs['siteKey']) || !isset($attribs['secretKey'])) {
            throw new Zend_Exception('Site key is not set in the view helper');
        }
        return '<script src="https://www.google.com/recaptcha/api.js"></script><div class="g-recaptcha" data-sitekey="' . $attribs['siteKey'] . '"></div>';
    }

}
