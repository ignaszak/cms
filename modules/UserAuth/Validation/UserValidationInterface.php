<?php

namespace UserAuth\Validation;

interface UserValidationInterface
{
    public function validUserName($userName);
    public function validUserPassword($userPassword, $userPasswordConfirm = '', $isRegistration = '');
    public function validUserEmail($userEmail);
    public function validEmailOrUserName($value);
}
