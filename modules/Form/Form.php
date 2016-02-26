<?php
namespace Form;

use System\Server;

class Form
{

    /**
     *
     * @var \Form\Message
     */
    private $_message;

    /**
     *
     * @var string
     */
    private $formName;

    public function __construct()
    {
        $this->_message = new Message($this);
    }

    /**
     *
     * @param string $key
     * @return (array|integer)
     */
    public function getFormResponseData(string $key = "")
    {
        $responseArray = Server::getReferData();
        if ($key != "") {
            return @$responseArray[$key] ?? null;
        } else {
            return $responseArray;
        }
    }

    /**
     *
     * @param string $formType
     * @return \Form\Group\Group
     * @throws \RuntimeException
     */
    public function createForm(string $formName): Group\Group
    {
        $this->formName = $formName;
        $formClass = 'Form\\Group\\' . ucfirst($this->getFormGroup());
        if (class_exists($formClass)) {
            return new $formClass($this);
        } else {
            throw new \RuntimeException("Class {$formClass} not exists");
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

    /**
     * @return string
     */
    public function getFormMessage(): string
    {
        return $this->_message->getMessage();
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
