<?php
namespace Form\Group;

use Ignaszak\Registry\RegistryFactory;
use Form\FormGenerator;

class User extends Group
{

    /**
     *
     * @var \Entity\Users
     */
    private $_user;

    /**
     *
     * @param \Form\Form $_form
     */
    public function __construct(\Form\Form $_form)
    {
        parent::__construct($_form);
        $this->_user = RegistryFactory::start()->get('user');
    }

    /**
     *
     * {@inheritDoc}
     * @see \Form\Group\Group::getFormActionAdress()
     */
    public function getFormActionAdress(): string
    {
        return $this->_conf->getBaseUrl() . 'user/post/' . $this->selectAction();
    }

    /**
     *
     * @param array $customItem
     * @return string
     */
    public function inputLogin(array $customItem = null): string
    {
        return $this->generateInput('text', 'userLogin', [
            'class' => 'form-control',
            'id' => 'userLogin',
            'minlength' => 2
        ], $customItem);
    }

    /**
     *
     * @param array $customItem
     * @return string
     */
    public function inputEmail(array $customItem = null): string
    {
        return $this->generateInput('email', 'userEmail', [
            'class' => 'form-control',
            'id' => 'userEmail'
        ], $customItem);
    }

    /**
     *
     * @param array $customItem
     * @return string
     */
    public function inputPassword(array $customItem = null): string
    {
        return $this->generateInput('password', 'userPassword', [
            'class' => 'form-control',
            'id' => 'userPassword',
            'minlength' => 8
        ], $customItem);
    }

    /**
     *
     * @param array $customItem
     * @return string
     */
    public function inputNewPassword(array $customItem = null): string
    {
        return $this->generateInput('password', 'userNewPassword', [
            'class' => 'form-control',
            'id' => 'userNewPassword',
            'minlength' => 8
        ], $customItem);
    }

    /**
     *
     * @return string
     */
    private function selectAction(): string
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
            case 'accountData':
            case 'accountPassword':
                return 'account';
            break;
        }
    }

    /**
     *
     * @param string $type
     * @param string $name
     * @param array $item
     * @param array $customItem
     * @return string
     */
    private function generateInput(
        string $type,
        string $name,
        array $item,
        array $customItem = null
    ): string {

        FormGenerator::start($type);
        FormGenerator::addName($name);
        FormGenerator::addItem($item);
        if ($type != 'password') {
            $this->addResponseInputValue($name);
        }
        $this->addAccountValue($name);
        FormGenerator::addItem($customItem);
        FormGenerator::required();
        return FormGenerator::render();
    }

    /**
     *
     * @param string $name
     */
    private function addResponseInputValue(string $name)
    {
        if ($this->formAction == 'registration') {
            $response = \System\Server::getReferData();
            $field = str_replace('user', '', $name);
            if (! @$response['error']['valid' . $field] &&
                ! @$response['error']['unique' . $field]) {
                FormGenerator::addItem([
                    'value' => @$response['data']['set' . $field]
                ]);
            }
        }
    }

    /**
     *
     * @param string $name
     */
    private function addAccountValue(string $name)
    {
        if ($this->formAction == 'accountData') {
            $entityGetter = $this->getEntityGetter($name);
            FormGenerator::addItem([
                'value' => $this->_user->getUserSession()->$entityGetter()
            ]);
        }
    }

    /**
     *
     * @param string $name
     */
    private function getEntityGetter(string $name): string
    {
        switch ($name) {
            case 'userLogin':
                return 'getLogin';
            break;
            case 'userEmail':
                return 'getEmail';
            break;
        }
    }
}
