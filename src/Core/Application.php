<?php

declare(strict_types=1);

namespace App\Core;

use App\routes;
use Exception;
use Psr\Log\LoggerInterface;

class Application
{
    public Container $container;
    public string $basePath;

    /**
     * @throws Exception
     */

    public function __construct(?string $basePath = null)
    {
        $this->basePath = $basePath ?? dirname(__DIR__, 2);
        $this->container = Container::getInstance();

        $this->registerBaseBindings();
        $this->registerConfig();
        $this->registerRouterAndRoutes();

        $this->container->singleton(LoggerInterface::class, function () {
            return new Logger($this->basePath . '/storage/logs/app.log');
        });

        $this->container->singleton(Kernel::class, function ($container) {
            $router = $container->make(Router::class);
            $logger = $container->make(LoggerInterface::class);
            return new Kernel($router, $container, $logger);
        });
    }


    protected function registerBaseBindings(): void
    {
        $this->container->instance(self::class, $this);
        $this->container->instance(Container::class, $this->container);
    }

    protected function registerConfig(): void
    {
        $this->container->instance(Config::class, new Config());
    }

    /**
     * @throws Exception
     */
    protected function registerRouterAndRoutes(): void
    {
        $router = $this->container->make(Router::class);
        $this->container->instance(Router::class, $router);

        if (class_exists(routes::class)) {
            routes::register();
        }
    }

    public function run(): void
    {
        try {
            $request = Request::capture();
            $kernel = $this->container->make(Kernel::class);
            $response = $kernel->handle($request);
            $response->send();
        } catch (\Throwable $e) {
            echo "ERROR: " . $e->getMessage();
            echo "<br>FILE: " . $e->getFile();
            echo "<br>LINE: " . $e->getLine();
        }
    }
}