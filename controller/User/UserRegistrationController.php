<?php
namespace Controller\User;

use FrontController\Controller;
use System\Server;
use Content\Controller\Factory;
use Content\Controller\UserController;
use Ignaszak\Registry\RegistryFactory;

class UserRegistrationController extends Controller
{

    /**
     *
     * @var string
     */
    private $login;

    /**
     *
     * @var string
     */
    private $email;

    /**
     *
     * @var string
     */
    private $password;

    public function run()
    {
        $_user = RegistryFactory::start()->get('user');
        if ($_user->isUserLoggedIn()) {
            Server::setReferData(array(
                'userMustBeLogout' => 1
            ));
            Server::headerLocationReferer();
        }
        
        $this->login = $_POST['userLogin'];
        $this->email = $_POST['userEmail'];
        $this->password = $_POST['userPassword'];
        
        $referData = array();
        if (! $this->dataNotExistInDatabase('login', $this->login)) {
            $referData['formLoginDoubled'] = 1;
        }
        if (! $this->dataNotExistInDatabase('email', $this->email)) {
            $referData['formEmailDoubled'] = 1;
        }
        
        if (count($referData) > 0) {
            Server::setReferData($referData);
            Server::headerLocationReferer();
        } else {
            $controller = new Factory(new UserController());
            $controller->setLogin($this->login)
                ->setEmail($this->email)
                ->setPassword($this->password)
                ->setRegDate(new \DateTime('now'))
                ->setLogDate(new \DateTime('now'))
                ->setRole('user')
                ->insert();
            
            Server::setReferData(array(
                'registrationSuccess' => 1
            ));
            Server::headerLocationReferer();
        }
    }

    /**
     *
     * @param string $column
     * @param string $data
     */
    private function dataNotExistInDatabase(string $column, string $data): bool
    {
        $this->query()
            ->setContent('user')
            ->findBy($column, $data)
            ->force()
            ->paginate(false);
        $result = $this->query()->getContent();
        return count($result) === 0 ? true : false;
    }
}
