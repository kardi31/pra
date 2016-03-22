<?php

/**
 * Review_Form_Comment
 *
 * @author Tomasz Kardas <kardi31@tlen.pl>
 */
class Review_Form_Comment extends Admin_Form {
    
    
    public function init()
    {
        
        $aid = $this->createElement('hidden','review_id');
        
        $comment = $this->createElement('textarea','comment');
        $comment->removeDecorators(array('Label','DtDdWrapper','HtmlTag'));
        $comment->setAttrib('class','text-long word_count form-control');
        $comment->setAttrib('rows',5);
        $comment->setRequired(true);
        
        $name = $this->createElement('text','name');
        $name->removeDecorators(array('Label','DtDdWrapper','HtmlTag'));
        $name->setAttrib('class','form-control')->setRequired(true);

        $email = $this->createElement('text','email');
        $email->removeDecorators(array('Label','DtDdWrapper','HtmlTag'));
        $email->setAttrib('class','form-control')->setRequired(true);
        
       
        $terms = $this->createElement('checkbox','terms');
        $terms->removeDecorators(array('Label','DtDdWrapper','HtmlTag'));
        $terms->setRequired(true);
        
        $submit = $this->createElement('button', 'submit');
        $submit->setLabel('Add');
        $submit->setDecorators(array('ViewHelper'));
        $submit->setAttribs(array('class' => 'bluebtn margtop20', 'type' => 'submit'));
        
        $this->addElements(
            array(
                $aid,
                $comment, 
                $email,
                $name,
                $terms,
                $submit
            )
        );
    }
}

