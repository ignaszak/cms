<?php

namespace Validation;

class UserValidation extends Validator implements IUserValidation
{

    public function validUserName($userName)
    {
        return parent::$_auraFilter->validate($userName, 'alnum')
            && parent::$_auraFilter->validate($userName, 'strlenBetween', 3, 15)
            && parent::$_auraFilter->sanitize($userName, 'string');
    }

    public function validUserPassword($userPassword, $userPasswordConfirm = '', $isRegistration = '')
    {
        $passValid = parent::$_auraFilter->validate($userPassword, 'strlenMin', 6);

        if ($isRegistration == 'REGISTRATION') {
            return $passValid && parent::$_auraFilter->validate($userPassword, 'equalToValue', $userPasswordConfirm);
        } else {
            return $passValid;
        }
    }

    public function validUserEmail($userEmail)
    {
        return parent::$_auraFilter->validate($userEmail, 'email');
    }

    public function validEmailOrUserName($value)
    {
        if (!$this->validUserName($value)) {
            return $this->validUserEmail($value);
        } else {
            return 1;
        }
    }

}
