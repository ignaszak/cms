<?php
namespace Form;

use Ignaszak\Registry\RegistryFactory;

class FormUser extends Form
{

    /**
     *
     * @var \Conf\Conf
     */
    private $_conf;

    /**
     *
     * @var \Entity\Users
     */
    private $_user;

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
        $this->_user = RegistryFactory::start()->get('user');
        $this->formAction = $formAction;
    }

    /**
     *
     * @return string
     */
    public function getFormMessage(): string
    {
        $response = $this->getFormResponseData();
        if (@$response['form'] == $this->formAction) {
            $array = array();
            if (@$response['error']['incorrectLoginOrPassword']) {
                $array[] = 'Incorrect login or/and password.';
            }
            if (@$response['error']['incorrectLogin']) {
                $array[] = 'Incorrect login.';
            }
            if (@$response['error']['formLoginDoubled']) {
                $array[] = 'Login alredy exists.';
            }
            if (@$response['error']['incorrectEmail']) {
                $array[] = 'Incorrect email.';
            }
            if (@$response['error']['formEmailDoubled']) {
                $array[] = 'Email alredy exists.';
            }
            if (@$response['error']['formEmailNotExists']) {
                $array[] = 'Email not exists.';
            }
            if (@$response['error']['incorrectPassword']) {
                $array[] = 'Incorrect password.';
            }
            return count($array) ? implode('<br>', $array) : "";
        }
        return "";
    }

    /**
     *
     * @return string
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
        return $this->generateInput('text', 'userLogin', array(
            'class' => 'form-control',
            'id' => 'userLogin',
            'minlength' => 2
        ), $customItem);
    }

    /**
     *
     * @param array $customItem
     * @return string
     */
    public function inputEmail(array $customItem = null): string
    {
        return $this->generateInput('email', 'userEmail', array(
            'class' => 'form-control',
            'id' => 'userEmail'
        ), $customItem);
    }

    /**
     *
     * @param array $customItem
     * @return string
     */
    public function inputPassword(array $customItem = null): string
    {
        return $this->generateInput('password', 'userPassword', array(
            'class' => 'form-control',
            'id' => 'userPassword',
            'minlength' => 8
        ), $customItem);
    }

    /**
     *
     * @param array $customItem
     * @return string
     */
    public function inputNewPassword(array $customItem = null): string
    {
        return $this->generateInput('password', 'userNewPassword', array(
            'class' => 'form-control',
            'id' => 'userNewPassword',
            'minlength' => 8
        ), $customItem);
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
        $this->addResponseInputValue($name);
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
            $response = $this->getFormResponseData();
            if ($name == 'userLogin' &&
                ! @$response['error']['incorrectLogin']) {
                FormGenerator::addItem(array(
                    'value' => @$response['data']['setLogin']
                ));
            } elseif ($name == 'userEmail' &&
                ! @$response['error']['incorrectEmail']) {
                FormGenerator::addItem(array(
                    'value' => @$response['data']['setEmail']
                ));
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
            FormGenerator::addItem(array(
                'value' => $this->_user->getUserSession()->$entityGetter()
            ));
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
