<?php

class Branch_Form_OpeningHours extends Admin_Form
{

    public function init()
    {
        $this->setName('opening_hours'); 
		
        $start_mon = new Zend_Form_Element_Select('start_mon');
        $start_mon->setAttrib('class','form-control')->removeDecorator('Label');
        $start_tue = new Zend_Form_Element_Select('start_tue');
        $start_tue->setAttrib('class','form-control')->removeDecorator('Label');
        $start_wed = new Zend_Form_Element_Select('start_wed');
        $start_wed->setAttrib('class','form-control')->removeDecorator('Label');
        $start_thu = new Zend_Form_Element_Select('start_thu');
        $start_thu->setAttrib('class','form-control')->removeDecorator('Label');
        $start_fri = new Zend_Form_Element_Select('start_fri');
        $start_fri->setAttrib('class','form-control')->removeDecorator('Label');
        $start_sat = new Zend_Form_Element_Select('start_sat');
        $start_sat->setAttrib('class','form-control')->removeDecorator('Label');
        $start_sun = new Zend_Form_Element_Select('start_sun');
        $start_sun->setAttrib('class','form-control')->removeDecorator('Label');
        $end_mon = new Zend_Form_Element_Select('end_mon');
        $end_mon->setAttrib('class','form-control')->removeDecorator('Label');
        $end_tue = new Zend_Form_Element_Select('end_tue');
        $end_tue->setAttrib('class','form-control')->removeDecorator('Label');
        $end_wed = new Zend_Form_Element_Select('end_wed');
        $end_wed->setAttrib('class','form-control')->removeDecorator('Label');
        $end_thu = new Zend_Form_Element_Select('end_thu');
        $end_thu->setAttrib('class','form-control')->removeDecorator('Label');
        $end_fri = new Zend_Form_Element_Select('end_fri');
        $end_fri->setAttrib('class','form-control')->removeDecorator('Label');
        $end_sat = new Zend_Form_Element_Select('end_sat');
        $end_sat->setAttrib('class','form-control')->removeDecorator('Label');
        $end_sun = new Zend_Form_Element_Select('end_sun');
        $end_sun->setAttrib('class','form-control')->removeDecorator('Label');
        $closed_mon = new Zend_Form_Element_Checkbox('closed_mon');
        $closed_mon->setAttrib('class','closed')->removeDecorator('Label');
        
        $closed_tue = new Zend_Form_Element_Checkbox('closed_tue');
        $closed_tue->setAttrib('class','closed')->removeDecorator('Label');
        $closed_wed = new Zend_Form_Element_Checkbox('closed_wed');
        $closed_wed->setAttrib('class','closed')->removeDecorator('Label');
        $closed_thu = new Zend_Form_Element_Checkbox('closed_thu');
        $closed_thu->setAttrib('class','closed')->removeDecorator('Label');
        $closed_fri = new Zend_Form_Element_Checkbox('closed_fri');
        $closed_fri->setAttrib('class','closed')->removeDecorator('Label');
        $closed_sat = new Zend_Form_Element_Checkbox('closed_sat');
        $closed_sat->setAttrib('class','closed')->removeDecorator('Label');
        $closed_sat->setChecked(true);
        $closed_sun = new Zend_Form_Element_Checkbox('closed_sun');
        $closed_sun->setAttrib('class','closed')->removeDecorator('Label');
        $closed_sun->setChecked(true);
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setAttrib('class','btn btn-info')->setLabel('Submit');
        
        
		
		$this->addElements(array(
		    $start_mon,
		    $end_mon,
		    $closed_mon,
		    $start_tue,
		    $end_tue,
		    $closed_tue,
		    $start_wed,
		    $end_wed,
		    $closed_wed,
		    $start_thu,
		    $end_thu,
		    $closed_thu,
		    $start_fri,
		    $end_fri,
		    $closed_fri,
		    $start_sat,
		    $end_sat,
		    $closed_sat,
		    $start_sun,
		    $end_sun,
		    $closed_sun,
		    $submit
		));
		
		$this->addTimes('start_mon');
        $this->addTimes('start_tue');
        $this->addTimes('start_wed');
        $this->addTimes('start_thu');
        $this->addTimes('start_fri');
        $this->addTimes('start_sat');
        $this->addTimes('start_sun');
        $this->addTimes('end_mon');
        $this->addTimes('end_tue');
        $this->addTimes('end_wed');
        $this->addTimes('end_thu');
        $this->addTimes('end_fri');
        $this->addTimes('end_sat');
        $this->addTimes('end_sun');
        
        foreach($this->getElements() as $element):
            $element->removeDecorator('HtmlTag');
        endforeach;
    }

    /**
     * adds the times to select from
     * @param Zend_Form_Element_Select
     */
    private function addTimes($element)
    {
        for($hour = 6; $hour < 24; $hour ++)
        {
            for($quarter = 1; $quarter < 5; $quarter ++)
            {
                $hh = str_pad($hour, 2,'0',STR_PAD_LEFT);
                switch ($quarter)
                {
                    case 1:
                        $mm = '00';
                        break;
                    case 2:
                        $mm = '15';
                        break;
                    case 3:
                        $mm = '30';
                        break;
                    case 4:
                        $mm = '45';
                        break;
                }
                $this->getElement($element)->addMultiOption($hh.':'.$mm,$hh.':'.$mm);
            }
        }
        
        
            if (strpos($element, 'end') !== false) {
                $this->getElement($element)->setValue('17:30');
            }
            elseif(strpos($element, 'start') !== false) {
                $this->getElement($element)->setValue('09:00');
            }
    }
    
    public function populateForm($hoursData){
        $populateArray = array();
        foreach($hoursData as $hour){
            $i = $hour['day_id'];
            $populateArray['start_'.strtolower(jddayofweek($i-1, 2))] = substr($hour['from'],0,5);
            $populateArray['end_'.strtolower(jddayofweek($i-1, 2))] = substr($hour['to'],0,5);
            $populateArray['closed_'.strtolower(jddayofweek($i-1, 2))] = $hour['closed'];
        }
            
        $this->populate($populateArray);
    }
}

