<?php
namespace Form\Group;

use Form\FormGenerator;

class Search extends Group
{

    /**
     *
     * {@inheritDoc}
     * @see \Form\Group\Group::getFormActionAdress()
     */
    public function getFormActionAdress(): string
    {
        return $this->_conf->getBaseUrl() . '/search/';
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
        FormGenerator::addItem(['class' => 'form-control']);
        FormGenerator::addItem($customItem);
        FormGenerator::required();
        return FormGenerator::render();
    }
}
