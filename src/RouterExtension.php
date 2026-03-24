<?php

declare(strict_types=1);

namespace Fhooe\Latte;

use Fhooe\Router\Router;
use Latte\Extension;

/**
 * Latte extension that exposes fhooe/router's urlFor() and the read-only basePath in templates as url_for and get_base_path.
 */
final class RouterExtension extends Extension
{
    public function __construct(private readonly Router $router)
    {
    }

    /**
     * Provides url_for(pattern) and get_base_path() for Latte templates (router uses public readonly basePath).
     * @return array<string, callable>
     */
    public function getFunctions(): array
    {
        return [
            "url_for" => $this->router->urlFor(...),
            "get_base_path" => fn (): string => $this->router->basePath,
        ];
    }
}