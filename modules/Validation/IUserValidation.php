<?php

namespace Validation;

interface IUserValidation
{

    public function validUserName($userName);
    public function validUserPassword($userPassword, $userPasswordConfirm = '', $isRegistration = '');
    public function validUserEmail($userEmail);
    public function validEmailOrUserName($value);

}
