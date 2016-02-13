<?php
namespace Form\Group;

use Ignaszak\Registry\RegistryFactory;

abstract class Group
{

    /**
     *
     * @var \Form\Form
     */
    protected $_form;

    /**
     *
     * @var \Conf\Conf
     */
    protected $_conf;

    /**
     *
     * @var string
     */
    protected $formAction;

    /**
     *
     * @param \Form\Form $_form
     */
    public function __construct(\Form\Form $_form)
    {
        $this->_form = $_form;
        $this->_conf = RegistryFactory::start('file')->register('Conf\Conf');
        $this->formAction = $this->getFormAction();
    }

    /**
     *
     * @return string
     */
    public function getFormMessage(): string
    {
        if (@$this->_form->getFormResponseData('form') == $this->formAction) {
            return $this->_form->getFormMessage();
        }
        return "";
    }

    /**
     * @return string
     */
    abstract public function getFormActionAdress(): string;

    /**
     *
     * @return string
     */
    private function getFormAction(): string
    {
        $formTypeArray = explode('-', $this->_form->getFormName());
        return @$formTypeArray[1] ?? $formTypeArray[0];
    }
}
