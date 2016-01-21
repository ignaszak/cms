<?php
namespace Conf;

use Conf\DB\DBDoctrine;
use CMSException\ConfException;

class Conf
{

    /**
     * Stores values of Entity\Options methods
     *
     * @var mixed[]
     */
    private $optionsArray = array();

    /**
     *
     * @param string $entity
     */
    public function __construct(string $entity = 'Entity\Options')
    {
        $_options = DBDoctrine::em()->find($entity, 1);
        $optonsMethods = get_class_methods($entity);
        
        foreach ($optonsMethods as $method) {
            if (! preg_match('/^(id|set)/', $method)) {
                $this->optionsArray[$method] = $_options->$method();
            }
        }
    }

    /**
     *
     * @param string $function
     * @param array $args
     * @throws ConfException
     * @return mixed
     */
    public function __call($function, $args)
    {
        if (array_key_exists($function, $this->optionsArray)) {
            return $this->optionsArray[$function];
        } else {
            throw new ConfException("Call to undefined method " . __CLASS__ . "::$function()");
        }
    }
}
