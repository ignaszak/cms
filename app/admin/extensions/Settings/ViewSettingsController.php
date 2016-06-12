<?php
namespace AdminController\Settings;

use FrontController\Controller as FrontController;
use FrontController\ViewHelperController;

class ViewSettingsController extends FrontController
{

    public function run()
    {
        $this->view->addView('theme/settings-view.html');
    }

    /**
     *
     * @return ViewHelperController
     */
    public function setViewHelper()
    {
        return new class($this) extends ViewHelperController
        {

            /**
             *
             * @var \Entity\Options
             */
            private $options;

            /**
             *
             * @param Controller $controller
             */
            public function __construct(FrontController $controller)
            {
                parent::__construct($controller);
                $this->controller->query->setQuery('options');
                $this->options = $this->controller->query->getQuery()[0];
            }

            /**
             *
             * @return string
             */
            public function getAdminSettingsFormAction(): string
            {
                return $this->controller->url('admin-settings-save');
            }

            /**
             *
             * @return \Entity\Options
             */
            public function getAdminSettings(): \Entity\Options
            {
                return $this->options;
            }

            /**
             *
             * @return array
             */
            public function getAdminSettingsThemesList(): array
            {
                return glob(__VIEWDIR__ . "/public/*", GLOB_ONLYDIR);
            }
        };
    }
}
