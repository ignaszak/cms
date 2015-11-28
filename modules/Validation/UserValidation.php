<?php

namespace Validation;

class UserValidation extends Validator
{

    /**
     * @param string $login
     * @return boolean
     */
    public function validLogin($login)
    {
        return parent::$_auraFilter->validate($login, 'alnum')
            && parent::$_auraFilter->validate($login, 'strlenBetween', 3, 15)
            && parent::$_auraFilter->sanitize($login, 'string');
    }

    /**
     * @param string $password
     * @param string $passwordConfirm
     * @param string $isRegistration
     * @return boolean
     */
    public function validPassword($password, $passwordConfirm = '', $isRegistration = '')
    {
        $passValid = parent::$_auraFilter->validate($password, 'strlenMin', 6);

        if ($isRegistration == 'REGISTRATION') {
            return $passValid && parent::$_auraFilter->validate($password, 'equalToValue', $passwordConfirm);
        } else {
            return $passValid;
        }

        return false;
    }

    /**
     * @param string $email
     * @return boolean
     */
    public function validEmail($email)
    {
        return parent::$_auraFilter->validate($email, 'email');
    }

    /**
     * @param string $value
     * @return boolean
     */
    public function validEmailOrLogin($value)
    {
        if (!$this->validLogin($value)) {
            return $this->validEmail($value);
        } else {
            return true;
        }
    }

}
