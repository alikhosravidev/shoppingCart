<?php

namespace App;

use App\Core\Config;
use App\Core\Container;
use App\Core\DatabaseManager;
use App\Core\Request;
use App\Core\Response;

class Kernel
{
    protected Container $container;

    public function __construct(protected array $configs)
    {
        $this->register();
        $this->boot();
    }

    protected function register()
    {
        $container = Container::getInstance();
        $container->set('app', $this);
        $container->set(Container::class, $container);
        $this->container = $container;

        $config = new Config($this->configs);
        $container->set(Config::class, $config);

        $container->set(Request::class, Request::createFromGlobals());

        $response = $container->get(Response::class);
        $container->set(Response::class, $response);

        $this->boot();
    }

    protected function boot()
    {
        $database = $this->container->get(DatabaseManager::class);
        $this->container->set(DatabaseManager::class, $database);

    }

    public function sendResponse()
    {
        $this->container->get(Response::class)->send();
    }

    protected function __clone()
    {
    }

    /**
     * @throws \Exception
     */
    public function __wakeup()
    {
        throw new Exception("Cannot unserialize a singleton.");
    }
}