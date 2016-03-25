<?php

/**
 * User_Form_Update
 *
 * @author Michał Folga <michalfolga@gmail.com>
 */
class User_Form_UpdatePassword extends Admin_Form {

    const salt = '6e26899d3195dabb8553dffe84899e0c';

    public function init() {
        $csrf = $this->createElement('hash', 'csrf');
        $csrf->setSalt(self::salt);
        $csrf->setDecorators(array('ViewHelper'));

        $userId = $this->createElement('hidden', 'user_id');
        $userId->setDecorators(array('ViewHelper'));


        $password = $this->createElement('password', 'password');
        $password->setLabel('New password');
        $password->setRequired();
        $password->setDecorators(self::$textAdminDecorators);
        $password->setAttrib('class', 'form-control');

        $confirmPassword = $this->createElement('password', 'confirm_password');
        $confirmPassword->setLabel('Confirm new password');
        $confirmPassword->setRequired();
        $confirmPassword->setValidators(array(array('Identical', false, array('token' => 'password'))));
        $confirmPassword->setDecorators(self::$textAdminDecorators);
        $confirmPassword->setAttrib('class', 'form-control');


        $oldpassword = $this->createElement('password', 'old_password');
        $oldpassword->setLabel('Your current password');
        $oldpassword->setDecorators(array('ViewHelper'));
        $oldpassword->setRequired();
        $oldpassword->setDecorators(self::$textAdminDecorators);
        $oldpassword->setAttrib('class', 'form-control');

        $token = $this->createElement('hidden', 'token');
        $token->setDecorators(array('ViewHelper'));

        $submit = $this->createElement('button', 'submit');
        $submit->setLabel('Save');
        $submit->setDecorators(self::$submitDecorators);
        $submit->setAttribs(array('class' => 'btn btn-info', 'type' => 'submit'));

        $this->setElements(array(
            $userId,
            $password,
            $oldpassword,
            $confirmPassword,
            $token,
            $submit
        ));
    }

}
