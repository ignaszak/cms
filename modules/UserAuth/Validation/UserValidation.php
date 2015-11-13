<?php

namespace UserAuth\Validation;

class UserValidation implements UserValidationInterface
{

    private $_auraFilter;

    public function __construct()
    {
        $filterFactory = new \Aura\Filter\FilterFactory();
        $this->_auraFilter = $filterFactory->newValueFilter();
    }

    public function validUserName($userName)
    {
        return $this->_auraFilter->validate($userName, 'alnum')
            && $this->_auraFilter->validate($userName, 'strlenBetween', 3, 15)
            && $this->_auraFilter->sanitize($userName, 'string');
    }

    public function validUserPassword($userPassword, $userPasswordConfirm = '', $isRegistration = '')
    {   
        $passValid = $this->_auraFilter->validate($userPassword, 'strlenMin', 6);
        
        if ($isRegistration == 'REGISTRATION') {
            return $passValid && $this->_auraFilter->validate($userPassword, 'equalToValue', $userPasswordConfirm);
        } else {
            return $passValid;
        }
    }

    public function validUserEmail($userEmail)
    {
        return $this->_auraFilter->validate($userEmail, 'email');
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
