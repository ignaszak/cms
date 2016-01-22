<?php
namespace App;

use System\Server;
use Ignaszak\Registry\Conf as RegistryConf;
use Ignaszak\Registry\RegistryFactory;
use View\View;
use UserAuth\User;
use Ignaszak\Router\Start as Router;
use Ignaszak\Router\Client as RouterClient;
use FrontController\FrontController;

class Load
{

    /**
     *
     * @var string
     */
    private $baseDir;

    /**
     *
     * @var \Ignaszak\Exception\Start
     */
    private $exception;

    /**
     *
     * @var \UserAuth\User
     */
    private $user;

    /**
     *
     * @var \View\View
     */
    private $view;

    public function __construct()
    {
        $this->baseDir = dirname(dirname(__DIR__));
    }

    /**
     * Exception handler configuration file
     * @link https://github.com/ignaszak/exception
     */
    public function loadExceptionHandler()
    {
        $exception = new \Ignaszak\Exception\Start;
        require "{$this->baseDir}/conf/exception-handler.php";
        $exception->run();
        $this->exception = $exception;
    }

    /**
     *
     * @return \Ignaszak\Exception\Start
     */
    public function getException(): \Ignaszak\Exception\Start
    {
        return $this->exception;
    }

    /**
     * Start session
     */
    public function loadSession()
    {
        session_save_path("{$this->baseDir}/cache/session");
        session_start();
    }

    /**
     * This method loads refer data from session
     * and pass their into System\Server::getReferData().
     * This method is used e.g. to show message about
     * invalid login or password
     */
    public function loadRefererData()
    {
        Server::readReferData();
    }

    /**
     * Configure registry
     * @link https://github.com/ignaszak/registry
     */
    public function loadRegistry()
    {
        RegistryConf::setTmpPath("{$this->baseDir}/cache/registry");
        RegistryFactory::start()->set('view', new View);
        $this->view = RegistryFactory::start()->get('view');
        RegistryFactory::start()->set('user', new User);
        $this->user = RegistryFactory::start()->get('user');
    }

    /**
     * Configures and loads router patterns
     * @link https://github.com/ignaszak/router
     */
    public function loadRouter()
    {
        $router = Router::instance();
        $router->baseURL = RegistryFactory::start('file')->register('Conf\Conf')->getBaseUrl();
        $router->defaultRoute = 'post';
        require "{$this->baseDir}/conf/router.php";
        $router->run();
    }

    /**
     * Method checks if admin panel route is open and then valid permission to
     * stay there. If user is admin (or moderator) method loads necessary extensions
     */
    public function loadAdmin()
    {
        if (RouterClient::isRouteName('admin')) {
            // If not logged open login panel
            if (! $this->user->isUserLoggedIn()) {
                $this->view->loadFile('../../extensions/Index/login.html');
                exit;
            }
            // Check permissions
            if ($this->user->getUserSession()->getRole() != 'admin') {
                Server::headerLocation(''); // Go to main page
            }
            new \Admin\Extension\ExtensionLoader();
            // Admin view helper classes
            require "{$this->baseDir}/" . ADMIN_FOLDER . "/conf/view-helper.php";
        }
    }

    /**
     * View helper extensions
     */
    public function loadViewHelper()
    {
        require "{$this->baseDir}/conf/view-helper.php";
    }

    /**
     * Initialize front controller
     */
    public function loadFrontController()
    {
        FrontController::run();
    }

    /**
     * Load view index file
     */
    public function loadView()
    {
        $this->view->loadFile('index.html');
    }
}
