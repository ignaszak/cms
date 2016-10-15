<?php
namespace Form\Group;

use Ignaszak\Registry\RegistryFactory;

abstract class Group
{

    /**
     *
     * @var \Form\Form
     */
    protected $form = null;

    /**
     *
     * @var \Conf\Conf
     */
    protected $conf = null;

    /**
     *
     * @var \Ignaszak\Router\UrlGenerator
     */
    protected $url = null;

    /**
     *
     * @var string
     */
    protected $formAction = '';

    /**
     *
     * @param \Form\Form $form
     */
    public function __construct(\Form\Form $form)
    {
        $this->form = $form;
        $this->conf = RegistryFactory::start('file')->register('Conf\Conf');
        $this->url = RegistryFactory::start()->get('url');
        $this->formAction = $this->getFormAction();
    }

    /**
     *
     * @return string
     */
    public function getFormMessage(): string
    {
        if (@$this->form->getFormResponseData('form') === $this->formAction) {
            return $this->form->getFormMessage();
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
        $formTypeArray = explode('-', $this->form->getFormName());
        return @$formTypeArray[1] ?? $formTypeArray[0];
    }
}
