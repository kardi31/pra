<?php

/**
 * Slider_Form_Layer
 *
 * @author Tomasz Kardas <kardi31@tlen.pl>
 */
class Review_Form_Review extends Admin_Form {
    
    
    public function init()
    {
        
        $aid = $this->createElement('hidden','agent_id');
        
        
        $rating = $this->createElement('hidden','rating');
        $rating->setRequired(true);
        $rating->setAttrib('id','rating_elem');
        $rating->setDisableLoadDefaultDecorators(true);
        $rating->removeDecorator('Label');
        
        $f_review = $this->createElement('textarea','review');
        $f_review->removeDecorators(array('Label','DtDdWrapper','HtmlTag'));
        $f_review->setAttrib('class','text-long word_count form-control');
        $f_review->setAttrib('rows',5);
        $f_review->setRequired(true);
        
        $selectbranch = $this->createElement('select','branch');
        $selectbranch->removeDecorator('Label');
        $selectbranch->removeDecorator('DtDdWrapper');
        $selectbranch->removeDecorator('HtmlTag');
        $selectbranch->removeDecorator('Description');
        $selectbranch->addMultiOption('','No branch selected');
        $selectbranch->setAttrib('class','form-control');
        
        
        $other_branch = $this->createElement('text','other_branch');
        $other_branch->removeDecorators(array('Label','DtDdWrapper','HtmlTag'));
        $other_branch->setAttrib('class','form-control');
        
        $name = $this->createElement('text','display_name');
        $name->removeDecorators(array('Label','DtDdWrapper','HtmlTag'));
        $name->setAttrib('class','form-control')->setRequired(true);
        
        $firstname = $this->createElement('text','firstname');
        $firstname->removeDecorators(array('Label','DtDdWrapper','HtmlTag'));
        $firstname->setRequired(true);
        
        $service_date = $this->createElement('text','service_date');
        $service_date->removeDecorators(array('Label','DtDdWrapper','HtmlTag'));
        $service_date->setRequired(true);
        $service_date->setAttrib('class','custompicker');
        
        $service_date->setAttrib('placeholder','dd/mm/yyyy'); 
        
        
        $lastname = $this->createElement('text','lastname');
        $lastname->removeDecorators(array('Label','DtDdWrapper','HtmlTag'));
        $lastname->setRequired(true);

        $email = $this->createElement('text','email');
        $email->removeDecorators(array('Label','DtDdWrapper','HtmlTag'));
        $email->setRequired(true);
        
        $phone = $this->createElement('text','phone');
        $phone->removeDecorators(array('Label','DtDdWrapper','HtmlTag'));
        
        $willreturn = $this->createElement('radio','recommend');
        $willreturn->addMultiOption(1,'Yes');
        $willreturn->addMultiOption(0,'No')
                ->setSeparator('')->setRequired(true)
                ;
        
        $willreturn->removeDecorators(array('Label','DtDdWrapper','HtmlTag','Description'));
      
        
        $feedback = $this->createElement('textarea','feedback');
        $feedback->removeDecorators(array('Label','DtDdWrapper','HtmlTag'));
        $feedback->setAttrib('class','text-long form-control');
        $feedback->setAttrib('rows',5);
        
        
        
        $staff1 = $this->createElement('hidden','staff1_id');
        $staff1->removeDecorators(array('Label','DtDdWrapper','HtmlTag'));
        
        $staff2 = $this->createElement('hidden','staff2_id');
        $staff2->removeDecorators(array('Label','DtDdWrapper','HtmlTag'));
        
        $staff_text = $this->createElement('hidden','staff1');
        $staff_text->removeDecorators(array('Label','DtDdWrapper','HtmlTag'));
        
        $staff2_text = $this->createElement('hidden','staff2');
        $staff2_text->removeDecorators(array('Label','DtDdWrapper','HtmlTag'));
        
        $terms = $this->createElement('checkbox','terms');
        $terms->removeDecorators(array('Label','DtDdWrapper','HtmlTag'));
        $terms->setRequired(true);
        
        $assoc = $this->createElement('checkbox','assoc');
        $assoc->removeDecorators(array('Label','DtDdWrapper','HtmlTag'));
        $assoc->setRequired(true);
        
        
        $submit = $this->createElement('button', 'submit');
        $submit->setLabel('Submit Review');
        $submit->setDecorators(array('ViewHelper'));
        $submit->setAttribs(array('class' => 'bluebtn margtop20', 'type' => 'submit'));
        
        $this->addElements(
                array(
                    $aid,
                    $rating, 
                    $f_review, 
                    $selectbranch,
                    $email,
                    $service_date,
                    $name,
                    $assoc,
                    $terms,
                    $firstname,
                    $other_branch,
                    $lastname,
                    $willreturn,
                    $staff2_text,
                    $staff_text,
                    $staff1,
                    $staff2,
                    $feedback,
                    $phone, 
                    $submit
                ));
    }
}

