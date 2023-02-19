<?php

namespace App;

use App\Cart\Cart;
use App\Contract\Cart\CartStore;
use App\Core\Config;
use App\Core\Container;
use App\Core\DatabaseManager;
use App\Core\Event;
use App\Core\Request;
use App\Core\Response;
use App\Listeners\UpdateCartAfterEntityDeleted;
use App\Listeners\UpdateCartAfterEntityUpdated;
use App\Notifications\ProductCreatedNotification;
use Symfony\Component\Console\Application;

class Kernel
{
    protected Container $container;

    protected array $events = [
        'productCreated' => ProductCreatedNotification::class,
        'productUpdated' => UpdateCartAfterEntityUpdated::class,
        'unitUpdated' => UpdateCartAfterEntityUpdated::class,
        'unitDeleted' => UpdateCartAfterEntityDeleted::class,
        'productDeleted' => UpdateCartAfterEntityDeleted::class,
    ];

    public function __construct(protected array $configs)
    {
        $this->register();
        $this->registerEvents();
        $this->boot();
        $this->registerCommands();
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
    }

    protected function registerEvents()
    {
        foreach ($this->events as $event => $listener) {
            Event::listen($event, $listener);
        }
    }

    protected function boot()
    {
        $database = $this->container->get(DatabaseManager::class);
        $this->container->set(DatabaseManager::class, $database);

        $config = $this->container->get(Config::class);
        $cartStorage = $config->get('cart.storage');
        $cartStorage = $this->container->get($cartStorage);
        $this->container->set(CartStore::class, $cartStorage);
    }

    protected function registerCommands()
    {
        $application = new Application;
        $commands = $this->container->get(Config::class)->get('commands');
        foreach ($commands as $command) {
            $application->add($this->container->get($command));
        }
        $application->run();
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