<?php
namespace Form\Group;

use Auth\Auth;
use Form\FormGenerator;
use App\Resource\Server;

class User extends Group
{

    /**
     *
     * @var \Entity\Users
     */
    private $user = null;

    /**
     *
     * @param \Form\Form $form
     */
    public function __construct(\Form\Form $form)
    {
        parent::__construct($form);
        $auth = new Auth();
        $this->user = $auth->getUser();
    }

    /**
     *
     * {@inheritDoc}
     * @see \Form\Group\Group::getFormActionAdress()
     */
    public function getFormActionAdress(): string
    {
        $action = $this->selectAction();
        return $this->url->url("user-{$action}", [
            'method' => 'post',
            'action' => $action
        ]);
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
            case 'login':
                return 'login';
            case 'logout':
                return 'logout';
            case 'remind':
                return 'remind';
            case 'accountData':
            case 'accountPassword':
                return 'save';
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
        if ($this->formAction === 'registration') {
            $response = Server::getReferData();
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
        if ($this->formAction === 'accountData') {
            $entityGetter = $this->getEntityGetter($name);
            FormGenerator::addItem([
                'value' => $this->user->$entityGetter()
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
            case 'userEmail':
                return 'getEmail';
        }
    }
}
