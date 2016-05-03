<?php
namespace Conf;

use Conf\DB\DBDoctrine;

class Conf
{

    /**
     * Stores values of Entity\Options methods
     *
     * @var mixed[]
     */
    private $optionsArray = [];

    /**
     *
     * @param string $entity
     */
    public function __construct(string $entity = 'Entity\Options')
    {
        $options = DBDoctrine::em()->find($entity, 1);
        $optonsMethods = get_class_methods($entity);

        foreach ($optonsMethods as $method) {
            if (! preg_match('/^(id|set)/', $method)) {
                $this->optionsArray[$method] = $options->$method();
            }
        }
    }

    /**
     *
     * @param string $function
     * @param array $args
     * @throws \BadMethodCallException
     * @return mixed
     */
    public function __call(string $function, array $args)
    {
        if (array_key_exists($function, $this->optionsArray)) {
            return $this->optionsArray[$function];
        } else {
            throw new \BadMethodCallException(
                "Call to undefined method " . __CLASS__ . "::$function()"
            );
        }
    }
}
