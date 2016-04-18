<?php
declare(strict_types=1);

namespace App\Resource;

use Ignaszak\Router\Response;
use Symfony\Component\HttpFoundation\Request;

class Http
{

    /**
     *
     * @var Response
     */
    private $router = null;

    /**
     *
     * @var \Symfony\Component\HttpFoundation\ParameterBag
     */
    private $request = null;

    public function __construct(
        Response $router,
        Request $request
    ) {
        $this->router = $router;
        $this->request = $request->request;
    }

    public function __get(string $property)
    {
        if (array_key_exists($property, get_class_vars('App\Resource\Http'))) {
            return $this->$property;
        } else {
            throw new \InvalidArgumentException(
                "Property '{$property}' does not exists"
            );
        }
    }
}
