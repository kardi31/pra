<?php

/**
 * Banner_Service_Banner
 *
 * @author Tomasz Kardas <biuro@kardimobile.pl>
 */
class Banner_Service_Banner extends MF_Service_ServiceAbstract {
    
    protected $bannerTable;
    
    protected $positions = array(
        
        'Sidebar1' => 'Lewa strona(250x250px)',
        'Sidebar2' => 'Prawa strona(300x250px)',
        'Sidebar3' => 'Lewa strona #2(250x250px)',
        'UnderNews' => 'U góry na środku (728x90px)',
        'UnderNews2' => 'Pod newsami,galeria,ogloszeniami,poradnikami,forum (728x90px)',
        'Homepage' => 'Strona główna(360x260)',
//        
//        'UnderAd' => 'Pod ogłoszeniami (728x90px)',
//        'UnderAd' => 'Pod ogłoszeniami (728x90px)',
//        
//        'UnderForum' => 'Forum - temat (728x90px)',
    );
    
    public function init() {
        $this->bannerTable = Doctrine_Core::getTable('Banner_Model_Doctrine_Banner');
    }
      
    public function getBanner($id, $field = 'id', $hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        return $this->bannerTable->findOneBy($field, $id, $hydrationMode);
    }
   public function getAllBanners(){
       return $this->bannerTable->findAll();
   }
   public function getAllActiveBanners(){
       $q = $this->bannerTable->createQuery('p');
       $q->addWhere('p.status = 1');
       return $q->execute(array(),Doctrine_Core::HYDRATE_RECORD);
   }
   
   public function getPositionBanners($position,$hydrationMode = Doctrine_Core::HYDRATE_RECORD){
       $q = $this->bannerTable->createQuery('p');
       $q->addWhere('p.status = 1');
       $q->addWhere('p.date_from <= NOW()');
       $q->addWhere('p.date_to > NOW()');
       $q->addWhere('p.position = ?',$position);
       return $q->execute(array(),$hydrationMode);
   }
   
    public function getBannerForm(Banner_Model_Doctrine_Banner $banner = null) {
         $form = new Banner_Form_Banner();
        
        
        if(null != $banner) {
            $bannerArray = $banner->toArray();
            $bannerArray['date_from'] = MF_Text::timeFormat($bannerArray['date_from'], 'd/m/Y H:i');
            $bannerArray['date_to'] = MF_Text::timeFormat($bannerArray['date_to'], 'd/m/Y H:i');
            $form->populate($bannerArray);
            
            $i18nService = MF_Service_ServiceBroker::getInstance()->getService('Default_Service_I18n');
            $languages = $i18nService->getLanguageList();
            foreach($languages as $language) {
                $i18nSubform = $form->translations->getSubForm($language);
                if($i18nSubform) {
                    $i18nSubform->getElement('name')->setValue($banner->Translation[$language]->name);
                }
            }
        }   
        return $form;
    }
    
    public function getAllPositions(){
        return $this->positions;
    }
    
    public function getPosition($position){
        return $this->positions[$position];
    }
    
    public function saveBannerFromArray($values) {
        foreach($values as $key => $value) {
            if(!is_array($value) && strlen($value) == 0) {
                $values[$key] = NULL;
            }
        }
        if(!$banner = $this->bannerTable->getProxy($values['id'])) {
            $banner = $this->bannerTable->getRecord();
        }
        
        $i18nService = MF_Service_ServiceBroker::getInstance()->getService('Default_Service_I18n');
        
        if(strpos($values['website'], 'http://') !== 0 && strlen($values['website'])>0) {
          $values['website'] = 'http://' . $values['website'];
        }
        $values['date_from'] = MF_Text::timeFormat($values['date_from'],'Y-m-d H:i:s', 'd/m/Y H:i');
        $values['date_to'] = MF_Text::timeFormat($values['date_to'],'Y-m-d H:i:s', 'd/m/Y H:i');
        
        $banner->fromArray($values);
        $languages = $i18nService->getLanguageList();
        foreach($languages as $language) {
            if(is_array($values['translations'][$language]) && strlen($values['translations'][$language]['name'])) {
                $banner->Translation[$language]->name = $values['translations'][$language]['name'];
                $banner->Translation[$language]->slug = MF_Text::createUniqueTableSlug('Banner_Model_Doctrine_BannerTranslation', $values['translations'][$language]['name'], $banner->getId());
                $banner->Translation[$language]->description = $values['translations'][$language]['description'];
            }
        }
        $banner->save();
        
        return $banner;
    }
    
    public function removeBanner(Banner_Model_Doctrine_Banner $banner) {
        $banner->delete();
    }
    
    public function refreshStatusBanner($banner){
        if ($banner->isStatus()):
            $banner->setStatus(0);
        else:
            $banner->setStatus(1);
        endif;
        $banner->save();
    }
}

