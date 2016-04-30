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
            private $_options;

            /**
             *
             * @param Controller $_controller
             */
            public function __construct(FrontController $_controller)
            {
                parent::__construct($_controller);
                $this->_controller->query->setQuery('options');
                $this->_options = $this->_controller->query->getQuery()[0];
            }

            /**
             *
             * @return string
             */
            public function getAdminSettingsFormAction(): string
            {
                return $this->_controller->url('admin-settings-save', []);
            }

            /**
             *
             * @return \Entity\Options
             */
            public function getAdminSettings(): \Entity\Options
            {
                return $this->_options;
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
