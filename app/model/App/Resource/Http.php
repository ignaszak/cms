<?php
declare(strict_types=1);

namespace App\Resource;

use Ignaszak\Router\Response;
use Symfony\Component\HttpFoundation\Request;

/**
 *
 * @author Tomasz Ignaszak
 *
 * @property-read Response $router
 * @property-read \Symfony\Component\HttpFoundation\ParameterBag $request
 */
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

    /**
     *
     * @param Response $router
     * @param Request $request
     */
    public function __construct(
        Response $router,
        Request $request
    ) {
        $this->router = $router;
        $this->request = $request->request;
    }

    /**
     *
     * @param string $property
     * @throws \InvalidArgumentException
     * @return mixed
     */
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

    /**
     *
     * @return boolean
     */
    public function isAdmin(): bool
    {
        return (bool) preg_match(
            '/^admin-[a-zA-Z0-9_-]*/',
            $this->router->name()
        );
    }
}
