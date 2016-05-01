<?php
namespace Form\Group;

use Ignaszak\Registry\RegistryFactory;

abstract class Group
{

    /**
     *
     * @var \Form\Form
     */
    protected $_form = null;

    /**
     *
     * @var \Conf\Conf
     */
    protected $_conf = null;

    /**
     *
     * @var \Ignaszak\Router\UrlGenerator
     */
    protected $url = null;

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
        $this->url = RegistryFactory::start()->get('url');
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
