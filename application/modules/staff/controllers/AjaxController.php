<?php

/**
 * User_AjaxController
 *
 * @author Michał Folga <michalfolga@gmail.com>
 */
class Staff_AjaxController extends MF_Controller_Action {

    public function init() {
        $this->_helper->layout->disableLayout();
        $this->_helper->ajaxContext
                ->addActionContext('find-staff', 'json')
                ->initContext();
        parent::init();
    }

    public function findStaffAction() {

        $staffService = $this->_service->getService('Staff_Service_Staff');


        $params = $this->getRequest()->getParams();
        
        $dom = new DOMDocument();
        $ul = $dom->createElement('ul');
        $staffList = $staffService->findStaff($params);
        foreach ($staffList as $staff) {
            $this->staffReviewRow($staff, $dom, $ul);
        }
        
        if(!count($staffList)>0){
            if(strlen($params['query'])){ 
                $selected = false;
                if($params['sid']=='new'){
                    $selected = true;
                }

                $this->newStaffReviewRow($params['query'],$dom,$ul,$selected);
            }
        }

        $dom->appendChild($ul);

        $response['result'] = $dom->saveHTML();

        echo json_encode($response);
        exit;
    }

    protected function staffReviewRow($staff, $dom, $ul, $selected = false) {
        $li = $dom->createElement('li');
        $li->setAttribute('data-id', $staff->get('id'));
        $li->setAttribute('data-name', $staff->getFullName());
        if ($selected) {
            $li->setAttribute('class', 'selected');
            $button = $dom->createElement('button', 'X');
            $button->setAttribute('class', 'removeStaff');
            $li->appendChild($button);
        }

        $imgUrl = $staff->getPictureUrl();
        $img = $dom->createElement('img');
        $img->setAttribute('src', $imgUrl);
        $img->setAttribute('class', 'fleft');

        $spanright = $dom->createElement('span');
        $spanright->setAttribute('class', 'spanright');

        $rating = round($staff->get('rating'));
        $namespan = $dom->createElement('span', $staff->getFullName());
        $namespan->setAttribute('class', 'namespan');

        $span = $dom->createElement('span');
        $span->setAttribute('class', 'rating-review stars rating' . $rating);

        for ($j = 0; $j < $rating; $j++) {
            $i = $dom->createElement('img');
            $i->setAttribute('src', '/images/star.png');
            $i->setAttribute('class', 'star');
            $span->appendChild($i);
        }


        $li->appendChild($img);


        $spanVotes = $dom->createElement('span', (int)$staff->get('active_reviews') . " ".$this->view->translate('reviews'));
        $spanVotes->setAttribute('class', 'spanVotes');

        $spanright->appendChild($namespan);
        $spanright->appendChild($span);
        $spanright->appendChild($spanVotes);

        $li->appendChild($spanright);
        $ul->appendChild($li);
    }

    protected function newStaffReviewRow($query, $dom, $ul, $selected = false) {
        $li = $dom->createElement('li');
        $li->setAttribute('data-id', 'new');
        $li->setAttribute('data-name', $query);
        if ($selected) {
            $li->setAttribute('class', 'selected newstaff');
        } else {
            $li->setAttribute('class', 'newstaff');
        }

        $img = $dom->createElement('img');
        $img->setAttribute('src', '/assets/images/user-avatar.jpg');
        $img->setAttribute('class', 'fleft');

        $spanright = $dom->createElement('span');
        $spanright->setAttribute('class', 'spanright');

//                        $d->firstname." ".$d->lastname
//                        $namespan = $dom->createElement('span', $query);
//                        $namespan->setAttribute('class','namespan');

        $span = $dom->createElement('span', $query . ' '.$this->view->translate('currently does not exist'));
        $span->setAttribute('class', 'namespan namespan3');


        $span2 = $dom->createElement('span');
        $span2->setAttribute('class', 'namespan noexists namespan3 addnewperson');

        $i = $dom->createElement('i');
        $i->setAttribute('class', 'fa fa-plus pull-left');

        $span2->appendChild($i);

        $span2Txt = $dom->createTextNode($this->view->translate('Click here to add this person'));
        $span2->appendChild($span2Txt);


        $li->appendChild($img);



//                        $spanright->appendChild($namespan);
        $spanright->appendChild($span);
        $spanright->appendChild($span2);

        $li->appendChild($spanright);
        $ul->appendChild($li);
    }

}
