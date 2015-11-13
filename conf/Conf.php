<?php

namespace Conf;

use Conf\DB\DBDoctrine;
use CMSException\ConfException;

class Conf
{

    private static $_conf;
    private $_optionsEntity;

    private function __construct()
    {
        $this->_optionsEntity = DBDoctrine::getEntityManager()->find('\\Entity\\Options', 1);
    }

    public static function instance()
    {
        if (empty(self::$_conf))
            self::$_conf = new self;

        return self::$_conf;
    }

    public function __call($function, $args)
    {
        if (method_exists($this->_optionsEntity, $function)) {
            return call_user_func_array(array($this->_optionsEntity, $function), $args);
        } else {
            throw new ConfException("Call to undefined method " . __CLASS__ . "::$function()");
        }
    }

}
