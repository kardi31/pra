<?php

/**
 * Advertisment_Form_Advertisment
 *
 * @author Tomasz Kardas <biuro@kardimobile.pl>
 */
class Advertisment_Form_Stream extends Admin_Form {
    
    public function init() {
        $i18nService = MF_Service_ServiceBroker::getInstance()->getService('Default_Service_I18n');
        
        $id = $this->createElement('hidden', 'id');
        $id->setDecorators(array('ViewHelper'));
        
        $type = $this->createElement('select', 'type');
        $type->setLabel('Type');
        $type->setRequired();
        $type->setDecorators(self::$selectDecorators);
        $type->addMultiOption('','');
        $type->addMultiOption('rtmp/mp4','rtmp/mp4');
        $type->addMultiOption('video/mp4','video/mp4');
//        $type->addMultiOption('application/x-mpegURL','http/m3u8');
        
        $languages = $i18nService->getLanguageList();

        $translations = new Zend_Form_SubForm();

        foreach($languages as $language) {
            $translationForm = new Zend_Form_SubForm();
            $translationForm->setName($language);
            $translationForm->setDecorators(array(
                'FormElements'
            ));

            $title = $translationForm->createElement('text', 'title');
            $title->setBelongsTo($language);
            $title->setLabel('Title');
            $title->setDecorators(self::$textDecorators);
            $title->setAttrib('class', 'span8');
            
            $content = $translationForm->createElement('textarea', 'content');
            $content->setBelongsTo($language);
            $content->setLabel('Content');
            $content->setDecorators(self::$tinymceDecorators);
            $content->setAttrib('class', 'span8 tinymce');
            
            $translationForm->setElements(array(
                $title,
                $content
            ));

            $translations->addSubForm($translationForm, $language);
        }
        
        $this->addSubForm($translations, 'translations');

        $url = $this->createElement('text', 'url');
        $url->setLabel('Url');
        $url->setDecorators(self::$textDecorators);
        $url->setAttrib('class', 'span8');
        $url->setRequired(false);
        
        $publish = $this->createElement('checkbox', 'publish');
        $publish->setLabel('Publish');
        $publish->setDecorators(self::$checkgroupDecorators);
        $publish->setAttrib('class', 'span8');
        
        
        
        $submit = $this->createElement('button', 'submit');
        $submit->setLabel('Save');
        $submit->setDecorators(array('ViewHelper'));
        $submit->setAttribs(array('class' => 'btn btn-info', 'type' => 'submit'));

        $this->setElements(array(
            $id,
            $publish,
            $url,
            $type,
            $submit
        ));
    }
}

