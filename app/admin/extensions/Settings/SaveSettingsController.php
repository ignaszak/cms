<?php
namespace AdminController\Settings;

use FrontController\Controller as FrontController;
use DataBase\Controller\Decorator\ConfDecorator;
use Entity\Options;
use App\Resource\Server;

class SaveSettingsController extends FrontController
{

    /**
     *
     * @var array
     */
    private $request = [];

    public function run()
    {
        $this->request = $this->http->request->all();

        $this->query->setQuery('options');
        $_option = $this->query->getQuery()[0];

        $controller = new ConfDecorator(new Options());
        $controller->find(1)
            ->setSiteTitle($this->request['title'] ?? $_option->getSiteTitle())
            ->setSiteDescription($this->request['description'] ?? $_option->getSiteDescription())
            ->setAdminEmail($this->request['email'] ?? $_option->getAdminEmail())
            ->setViewLimit($this->request['viewLimit'] ?? $_option->getViewLimit())
            ->setDateFormat($this->request['dateFormat'] ?? $_option->getDateFormat())
            ->setBaseUrl($this->getBaseUrl() ?? $_option->getBaseUrl())
            ->setRequestUri($this->request['requestURI'] ?? $_option->getRequestUri())
            ->setTheme($this->request['theme'] ?? $_option->getTheme())
            ->insert();

        Server::headerLocationReferer();
    }

    /**
     *
     * @return string
     */
    private function getBaseUrl(): string
    {
        if (! empty(@$this->request['adress'])) {
            return (substr($this->request['adress'], - 1) == "/" ?
                substr(
                    $this->request['adress'],
                    0,
                    strlen($this->request['adress']) - 1
                ) : $this->request['adress']);
        }
        return '';
    }
}
