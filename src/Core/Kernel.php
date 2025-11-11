<?php

declare(strict_types=1);

namespace App\Core;

use Exception;
use Psr\Log\LoggerInterface;

class Kernel
{
    public function __construct(
        protected Router $router,
        protected Container $container,
        protected LoggerInterface $logger
    ) {}

    /**
     * @throws Exception
     */
    public function handle(Request $request): Response
    {
        try {
            $this->logger->info("Handling request", [
                'method' => $request->method(),
                'path' => $request->path(),
                'input' => $request->all()
            ]);

            return $this->router->dispatch($request, $this->container);
        } catch (\Throwable $e) {
            $this->logger->error("Exception caught in Kernel", [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);

            throw $e;
        }
    }
}