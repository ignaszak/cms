<?php

namespace Form;

class Form
{

    /**
     * @var Form
     */
    private static $_formInstance;

    /**
     * @var string
     */
    private $formType;

    /**
     * @param string $key
     * @return (array|integer)
     */
    public function getFormResponseData(string $key = '')
    {
        $responseArray = \System\Server::getReferData();
        return (!empty($key) ? @$responseArray[$key] : @$responseArray);
    }

    /**
     * @param unknown $formType
     * @return \Form\Form
     */
    public function createForm(string $formType)
    {
        $this->formType = $formType;

        switch ($this->getFormGroup()) {
            case 'user':
                $this->setFormInstance('FormUser');
                break;
        }
        return self::$_formInstance;
    }

    /**
     * @param string $formClassName
     */
    private function setFormInstance(string $formClassName)
    {
        $className = __NAMESPACE__ . '\\' . $formClassName;
        self::$_formInstance = new $className($this->getFormAction());
    }

    /**
     * @return string
     */
    private function getFormGroup(): string
    {
        $formTypeArray = explode('-', $this->formType);
        return $formTypeArray[0];
    }

    /**
     * @return string
     */
    private function getFormAction(): string
    {
        $formTypeArray = explode('-', $this->formType);
        return $formTypeArray[1];
    }

}
