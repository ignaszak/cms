<?php
declare(strict_types=1);

namespace App;

use App\Resource\Server;
use Ignaszak\Registry\Conf as RegistryConf;
use Ignaszak\Registry\RegistryFactory;
use View\View;
use UserAuth\User;
use FrontController\FrontController;
use Ignaszak\Router\Collection\Yaml;
use Ignaszak\Router\Matcher\Matcher;
use Ignaszak\Router\Host;
use Ignaszak\Router\Response;
use App\Resource\Http;
use Symfony\Component\HttpFoundation\Request;
use Ignaszak\Router\UrlGenerator;
use Ignaszak\Router\Collection\Cache;

class Load
{

    /**
     *
     * @var \Ignaszak\Exception\Start
     */
    private $exception = null;

    /**
     *
     * @var \UserAuth\User
     */
    private $user = null;

    /**
     *
     * @var \View\View
     */
    private $view = null;

    /**
     *
     * @var Resource\Http
     */
    private $http = null;

    public function __construct()
    {

    }

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
        $yaml = new Yaml();
        //new \Admin\Extension\ExtensionLoader;
        $yaml->add(__CONFDIR__ . '/router.yml');
        $cache = new Cache($yaml);
        $cache->tmpDir = __BASEDIR__ . "/data/cache/router";
        $matcher = new Matcher($cache);
        //RegistryFactory::start('file')->register('Conf\Conf')->getBaseUrl();
        $host = new Host('/~tomek/Eclipse/PHP/cms');
        $response = new Response($matcher->match($host));
        RegistryFactory::start()->set('url', new UrlGenerator($cache, $host));
        $this->http = new Http($response, Request::createFromGlobals());
        RegistryFactory::start()->set('http', $this->http);
    }

    /**
     * Method checks if admin panel route is open and then valid permission to
     * stay there. If user is admin (or moderator) method loads necessary extensions
     */
    public function loadAdmin()
    {
        if ($this->http->router->group() == 'admin') {
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
        new FrontController($this->http);
    }

    /**
     * Load view index file
     */
    public function loadView()
    {
        $this->view->loadFile('index.html');
    }
}
