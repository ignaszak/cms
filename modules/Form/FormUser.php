<?php

namespace Form;

use Ignaszak\Registry\RegistryFactory;

class FormUser
{

    private  $_conf;
    private $formAction;

    public function __construct($formAction)
    {
        $this->_conf = RegistryFactory::start('file')->register('Conf\Conf');
        $this->formAction = $formAction;
    }

    public function getFormActionAdress()
    {
        return $this->_conf->getBaseUrl() . 'user/post/' . $this->selectAction();
    }

    public function getAjaxActionAdress()
    {
        return $this->_conf->getBaseUrl() . 'user/ajax/' . $this->selectAction();
    }

    private function selectAction()
    {
        switch ($this->formAction) {
            case 'registration':
                return 'registration';
                break;
            case 'login':
                return 'login';
                break;
            case 'logout':
                return 'logout';
                break;
            case 'remind':
                return 'remind';
                break;
        }
    }

    public function inputLogin(array $customItem = null)
    {
        FormGenerator::start('text');
        FormGenerator::addName('userLogin');
        FormGenerator::addItem(array(
            'class' => 'form-control',
            'id'    => 'userLogin'
        ));
        FormGenerator::addItem($customItem);
        FormGenerator::required();
        return FormGenerator::render();
    }

    public function inputEmail(array $customItem = null)
    {
        FormGenerator::start('email');
        FormGenerator::addName('userEmail');
        FormGenerator::addItem(array(
            'class' => 'form-control',
            'id'    => 'userEmail'
        ));
        FormGenerator::addItem($customItem);
        FormGenerator::required();
        return FormGenerator::render();
    }

    public function inputPassword(array $customItem = null)
    {
        FormGenerator::start('password');
        FormGenerator::addName('userPassword');
        FormGenerator::addItem(array(
            'class' => 'form-control',
            'id'    => 'userPassword'
        ));
        FormGenerator::addItem($customItem);
        FormGenerator::required();
        return FormGenerator::render();
    }

}
