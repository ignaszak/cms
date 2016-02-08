<?php
namespace AdminController\Settings;

use FrontController\Controller as FrontController;
use Content\Controller\Decorator\ConfDecorator;
use Entity\Options;
use System\Server;

class SaveSettingsController extends FrontController
{

    public function run()
    {
        $this->query()->setContent('options');
        $_option = $this->query()->getContent()[0];

        $controller = new ConfDecorator(new Options());
        $controller->find(1)
            ->setSiteTitle(@$_POST['title'] ?? $_option->getSiteTitle())
            ->setSiteDescription(@$_POST['description'] ?? $_option->getSiteDescription())
            ->setAdminEmail(@$_POST['email'] ?? $_option->getAdminEmail())
            ->setViewLimit(@$_POST['viewLimit'] ?? $_option->getViewLimit())
            ->setDateFormat(@$_POST['dateFormat'] ?? $_option->getDateFormat())
            ->setBaseUrl($this->getBaseUrl() ?? $_option->getBaseUrl())
            ->setRequestUri(@$_POST['requestURI'] ?? $_option->getRequestUri())
            ->setTheme(@$_POST['theme'] ?? $_option->getTheme())
            ->insert();

        Server::headerLocationReferer();
    }

    /**
     *
     * @return string
     */
    private function getBaseUrl(): string
    {
        if (! empty(@$_POST['adress'])) {
            return @$_POST['adress'] . (substr(@$_POST['adress'], - 1) == "/" ? "" : "/");
        }
        return "";
    }
}
