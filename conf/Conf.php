<?php

namespace Conf;

use Conf\DB\DBDoctrine;
use CMSException\ConfException;

class Conf
{

    /**
     * @var Conf
     */
    private static $_conf;

    /**
     * @var Entity\Options
     */
    private $_optionsEntity;

    private function __construct()
    {
        $this->_optionsEntity = DBDoctrine::em()->find('\\Entity\\Options', 1);
    }

    /**
     * @return Conf
     */
    public static function instance()
    {
        if (empty(self::$_conf))
            self::$_conf = new self;

        return self::$_conf;
    }

    /**
     * @param string $function
     * @param array $args
     * @throws ConfException
     * @return mixed
     */
    public function __call($function, $args)
    {
        if (method_exists($this->_optionsEntity, $function)) {
            return call_user_func_array(array($this->_optionsEntity, $function), $args);
        } else {
            throw new ConfException("Call to undefined method " . __CLASS__ . "::$function()");
        }
    }

}
