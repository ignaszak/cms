<?php

namespace Form;

class Form
{

    private static $_formInstance;
    private $formType;

    public function getFormResponseData($key='')
    {
        $responseArray = \System\Server::getReferData();
        return (!empty($key) ? @$responseArray[$key] : @$responseArray);
    }

    public function createForm($formType)
    {
        $this->setFormType($formType);

        switch ($this->getFormGroup()) {
            case 'user':
                $this->setFormInstance('FormUser');
                break;
        }
        return $this->getFormInstance();
    }

    private function setFormInstance($formClassName)
    {
        $className = __NAMESPACE__ . '\\' . $formClassName;
        return self::$_formInstance = new $className($this->getFormAction());
    }

    private function getFormInstance()
    {
        return self::$_formInstance;
    }

    private function setFormType($formType)
    {
        $this->formType = $formType;
    }

    private function getFormGroup()
    {
        $formTypeArray = explode('-', $this->formType);
        return $formTypeArray[0];
    }

    private function getFormAction()
    {
        $formTypeArray = explode('-', $this->formType);
        return $formTypeArray[1];
    }

}
