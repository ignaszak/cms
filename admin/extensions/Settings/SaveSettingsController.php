<?php

namespace AdminController\Settings;

use FrontController\Controller;
use Content\Controller\Factory;
use Content\Controller\OptionController;
use System\Server;

class SaveSettingsController extends Controller
{

    public function run()
    {
        $this->view()->setContent('options');
        $_option = $this->view()->getContent()[0];

        
        $controller = new Factory(new OptionController);
        $controller->find(1)
            ->setSiteTitle(  @$_POST['title']      ?? $_option->getSiteTitle() )
            ->setAdminEmail( @$_POST['email']      ?? $_option->getAdminEmail() )
            ->setPostLimit(  @$_POST['postLimit']  ?? $_option->getPostLimit() )
            ->setDateFormat( @$_POST['dateFormat'] ?? $_option->getDateFormat() )
            ->setBaseUrl(    $this->getBaseUrl()   ?? $_option->getBaseUrl() )
            ->setRequestUri( @$_POST['requestURI'] ?? $_option->getRequestUri() )
            ->setTheme(      @$_POST['theme']      ?? $_option->getTheme() )
            ->insert();

        Server::headerLocationReferer();
    }

    /**
     * @return string
     */
    private function getBaseUrl(): string
    {
        if (!empty(@$_POST['adress'])) {
            return @$_POST['adress'] . (substr(@$_POST['adress'], -1) == "/" ?
                "" : "/");
        }
        return "";
    }

}
