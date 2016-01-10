<?php

namespace AdminController\Settings;

use FrontController\Controller;
use FrontController\ViewHelperController;

class ViewSettingsController extends Controller
{

    public function run()
    {
        $this->_view->addView('theme/settings-view.html');
        $this->setViewHelperName('AdminSettings');
    }

    /**
     * @return ViewHelperController
     */
    public function setViewHelper()
    {
        return new class ($this) extends ViewHelperController
        {
            /**
             * @var \Entity\Options
             */
            private $_options;

            /**
             * @param Controller $_controller
             */
            public function __construct(Controller $_controller)
            {
                parent::__construct($_controller);
                $this->_controller->view()->setContent('options');
                $this->_options = $this->_controller->view()->getContent()[0];
            }

            /**
             * @return string
             */
            public function getAdminSettingsFormAction(): string
            {
                return $this->_controller->getAdminAdress() . "/settings/save";;
            }

            /**
             * @return \Entity\Options
             */
            public function getAdminSettings(): \Entity\Options
            {
                return $this->_options;
            }

            /**
             * @return array
             */
            public function getAdminSettingsThemesList(): array
            {
                $baseDir = dirname(dirname(dirname(__DIR__)));
                return glob($baseDir . "/themes/*", GLOB_ONLYDIR);
            }
        };
    }

}
