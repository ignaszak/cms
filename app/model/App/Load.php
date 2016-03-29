<?php
namespace App;

use App\Resource\Server;
use Ignaszak\Registry\Conf as RegistryConf;
use Ignaszak\Registry\RegistryFactory;
use View\View;
use UserAuth\User;
use FrontController\FrontController;
use Ignaszak\Router\Route;
use Ignaszak\Router\Router;
use Ignaszak\Router\Conf\Host;
use App\Resource\RouterStatic;

class Load
{

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

    /**
     * Exception handler configuration file
     * @link https://github.com/ignaszak/php-exception
     */
    public function loadExceptionHandler()
    {
        $exception = new \Ignaszak\Exception\Start;
        require __CONFDIR__ . "/exception-handler.php";
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
     * Start session and loads refer data from session
     * and pass their into System\Server::getReferData().
     * This method is used e.g. to show message about
     * invalid login or password
     */
    public function loadSession()
    {
        session_start();
        Server::readReferData();
    }

    /**
     * Configures Registry tmp path
     */
    public function loadRegistryConf()
    {
        RegistryConf::setTmpPath(__BASEDIR__ . "/data/cache/registry");
    }

    /**
     * Configure registry
     * @link https://github.com/ignaszak/php-registry
     */
    public function loadRegistry()
    {
        RegistryFactory::start()->set('view', new View);
        $this->view = RegistryFactory::start()->get('view');
        RegistryFactory::start()->set('user', new User);
        $this->user = RegistryFactory::start()->get('user');
    }

    /**
     * Configures and loads router patterns
     * @link https://github.com/ignaszak/php-router
     */
    public function loadRouter()
    {
        $route = Route::start();
        $router = new Router($route);
        $route->get('default', '/@base');
        $route->group('admin');
        $route->get('admin', '/admin');
        //new \Admin\Extension\ExtensionLoader;
        $route->group();
        require __CONFDIR__ . "/router.php";
        $router->run(new Host(
            '/~tomek/Eclipse/PHP/cms'
            //RegistryFactory::start('file')->register('Conf\Conf')->getBaseUrl()
        ));
    }

    /**
     * Method checks if admin panel route is open and then valid permission to
     * stay there. If user is admin (or moderator) method loads necessary extensions
     */
    public function loadAdmin()
    {
        if (RouterStatic::getGroup() == 'admin') {
            // If not logged open login panel
            if (! $this->user->isUserLoggedIn()) {
                $this->view->loadFile('../../extensions/Index/login.html');
                exit;
            }
            // Check permissions
            if ($this->user->getUserSession()->getRole() != 'admin') {
                Server::headerLocation(''); // Go to main page
            }
            // Admin view helper classes
            require __ADMINDIR__ . "/conf/view-helper.php";
        }
    }

    /**
     * View helper extensions
     */
    public function loadViewHelper()
    {
        require __CONFDIR__ . "/view-helper.php";
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
