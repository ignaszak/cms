<?php
namespace Form;

use Ignaszak\Registry\RegistryFactory;

class FormSearch extends Form
{

    /**
     *
     * @var \Conf\Conf
     */
    private $_conf;

    /**
     *
     * @var string
     */
    private $formAction;

    /**
     *
     * @param string $formAction
     */
    public function __construct(string $formAction)
    {
        $this->_conf = RegistryFactory::start('file')->register('Conf\Conf');
        $this->formAction = $formAction;
    }

    /**
     *
     * @return string
     */
    public function getFormActionAdress(): string
    {
        return $this->_conf->getBaseUrl() . 'search/';
    }

    /**
     *
     * @param array $customItem
     * @return string
     */
    public function inputSearch(array $customItem = null): string
    {
        FormGenerator::start('text');
        FormGenerator::addName('search');
        FormGenerator::addItem(['class' => 'form-control', 'id' => 'search']);
        FormGenerator::addItem($customItem);
        FormGenerator::required();
        return FormGenerator::render();
    }
}
