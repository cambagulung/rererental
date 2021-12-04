<?php

namespace App\Extensions\Repositories;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Routing\Route;
use Illuminate\Routing\Router;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class EndpointRepository implements Arrayable
{
    protected Collection $endpoints;

    public function __construct(protected Router $router)
    {
        //
    }

    public function __get($name)
    {
        return $this->getManyByNamePrefix($name);
    }

    public function getManyByNamePrefix($prefix)
    {
        $routes = $this->getEndpoints()->filter(fn ($route) => Str::startsWith($route['name'], Str::snake(Str::camel($prefix), '.')));

        return collect(array_values($routes->toArray()));
    }

    public function getOneByName(string $name)
    {
        return $this->getManyByNamePrefix($name)->first();
    }

    public function getEndpoints()
    {
        if (isset($this->endpoints)) return $this->endpoints;

        return $this->endpoints = collect($this->router->getRoutes())->map(fn (Route $route) => $this->parseRoute($route));
    }

    protected function parseRoute(Route $route)
    {
        return [
            'domain'    => $route->domain(),
            'methods'   => $route->methods(),
            'uri'       => $route->uri(),
            'name'      => $route->getName()
        ];
    }

    public function toArray()
    {
        return $this->getEndpoints()->toArray();
    }
}
