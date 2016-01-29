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
            'id' => 'userLogin'
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
            'minlength' => '8'
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
    private function generateInput(string $type, string $name, array $item, array $customItem = null): string
    {
        FormGenerator::start($type);
        FormGenerator::addName($name);
        FormGenerator::addItem($item);
        $this->addResponseInputValue($name);
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
            if ($name == 'userLogin' && ! @$response['error']['incorrectLogin']) {
                FormGenerator::addItem(array(
                    'value' => @$response['data']['setLogin']
                ));
            } elseif ($name == 'userEmail' && ! @$response['error']['incorrectEmail']) {
                FormGenerator::addItem(array(
                    'value' => @$response['data']['setEmail']
                ));
            }
        }
    }
}
