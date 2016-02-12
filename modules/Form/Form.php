<?php
namespace Form;

use CMSException\InvalidClassException;
use System\Server;

class Form
{

    /**
     *
     * @var string
     */
    private $formName;

    /**
     *
     * @param string $key
     * @return (array|integer)
     */
    public function getFormResponseData(string $key = "")
    {
        $responseArray = Server::getReferData();
        return (! empty($key) ? @$responseArray[$key] : @$responseArray);
    }

    /**
     *
     * @param string $formType
     * @return \Form\Group\Group
     * @throws InvalidClassException
     */
    public function createForm(string $formName): Group\Group
    {
        $this->formName = $formName;
        $formClass = 'Form\\Group\\' . ucfirst($this->getFormGroup());
        if (class_exists($formClass)) {
            return new $formClass($this);
        } else {
            throw new InvalidClassException("Class {$formClass} not exists");
        }
    }

    /**
     *
     * @return string
     */
    public function getFormName(): string
    {
        return $this->formName;
    }

    public function getFormMessage()
    {
        return print_r(@$this->getFormResponseData()['error'], true);
    }

    /**
     *
     * @param string $formClassName
     */
    private function setFormInstance(string $className)
    {
        self::$_formInstance = new $className($this->getFormAction());
    }

    /**
     *
     * @return string
     */
    private function getFormGroup(): string
    {
        $formTypeArray = explode('-', $this->formName);
        return $formTypeArray[0];
    }
}
