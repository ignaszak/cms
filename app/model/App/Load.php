<?php
declare(strict_types=1);

namespace App;

use App\Resource\Http;
use App\Resource\Server;
use FrontController\FrontController;
use UserAuth\User;
use View\View;
use Ignaszak\Exception\Start as ExceptionHandler;
use Ignaszak\Registry\Conf as RegistryConf;
use Ignaszak\Registry\RegistryFactory;
use Ignaszak\Router\Collection\Yaml as RouterYaml;
use Ignaszak\Router\Matcher\Matcher;
use Ignaszak\Router\Host;
use Ignaszak\Router\Response;
use Ignaszak\Router\UrlGenerator;
use Ignaszak\Router\Collection\Cache;
use Symfony\Component\HttpFoundation\Request;
use ViewHelper\ViewHelperExtension;


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

    /**
     *
     * @var AdminExtension
     */
    private $adminExtension = null;

    /**
     *
     * @var ExceptionHandler
     */
    private $exceptionHandler = null;

    /**
     *
     * @var \Ignaszak\Registry\Registry
     */
    private $registry = null;

    /**
     *
     * @var array
     */
    private $conf = [];

    /**
     * Defines router conf file
     *
     * @var string
     */
    private $routerYaml = __CONFDIR__ . '/router.yml';

    /**
     *
     * @param array $array
     */
    public function __construct(array $array)
    {
        $this->conf = $array;
        $this->adminExtension = new AdminExtension(
            $this->dir($this->conf['conf']['admin']['extensionDir'] ?? '')
        );
        $this->exceptionHandler = new ExceptionHandler();
        $this->registry = RegistryFactory::start();
    }

    /**
     * Exception handler configuration file
     * @link https://github.com/ignaszak/php-exception
     */
    public function loadExceptionHandler()
    {
        $conf = $this->conf['conf']['exceptionHandler'] ?? [];
        $this->exceptionHandler->errorReporting = eval(
            ($conf['errorReporting'] ?? '') . ";"
        );
        $this->exceptionHandler->userReporting = eval(
            ($conf['userReporting'] ?? '') . ";"
        );
        $this->exceptionHandler->display = $conf['display'] ?? '';
        $this->exceptionHandler->userMessage = $conf['message'] ?? '';
        $this->exceptionHandler->userLocation = $conf['location'] ?? '';
        $this->exceptionHandler->createLogFile = $conf['createLogFile'] ?? '';
        $this->exceptionHandler->logFileDir = $this->dir(
            $conf['logFileDir'] ?? ''
        );
        $this->exceptionHandler->run();
    }

    /**
     *
     * @return ExceptionHandler
     */
    public function getExceptionHandler(): ExceptionHandler
    {
        return $this->exceptionHandler;
    }

    /**
     * Configures Registry tmp path
     * @link https://github.com/ignaszak/php-registry
     */
    public function loadRegistry()
    {
        RegistryConf::setTmpPath(
            $this->dir($this->conf['conf']['tmp']['registry'] ?? '')
        );
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
     * Configures and loads http
     * @link https://github.com/ignaszak/php-router
     */
    public function loadHttp()
    {
        $yaml = new RouterYaml();
        //new \Admin\Extension\ExtensionLoader;
        $yaml->add($this->routerYaml);
        $cache = new Cache($yaml);
        $cache->tmpDir = $this->dir($this->conf['conf']['tmp']['router'] ?? '');
        $matcher = new Matcher($cache);
        //RegistryFactory::start('file')->register('Conf\Conf')->getBaseUrl();
        $host = new Host('/~tomek/Eclipse/PHP/cms');
        $response = new Response($matcher->match($host));
        $this->registry->set('url', new UrlGenerator($cache, $host));
        $this->http = new Http($response, Request::createFromGlobals());
        $this->registry->set('http', $this->http);
    }

    /**
     * View helper extensions
     */
    public function loadViewHelper()
    {
        ViewHelperExtension::addExtensionClass($this->conf['viewHelper'] ?? []);
    }

    /**
     * Sets instance of View class
     */
    public function loadView()
    {
        $this->registry->set('view', new View());
        $this->view = $this->registry->get('view');
    }

    /**
     * Sets instance of User class
     */
    public function loadUser()
    {
        $this->registry->set('user', new User());
        $this->user = $this->registry->get('user');
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
            ViewHelperExtension::addExtensionClass(
                $this->conf['adminViewHelper'] ?? []
            );
        }
    }

    /**
     * Initialize front controller
     */
    public function loadFrontController()
    {
        new FrontController($this->http);
    }

    /**
     * Load theme index file
     */
    public function loadTheme()
    {
        $this->view->loadFile('index.html');
    }

    /**
     *
     * @param string $dir
     * @return string
     */
    private function dir(string $dir): string
    {
        return empty($dir) ? '' : __BASEDIR__ . $dir;
    }
}
