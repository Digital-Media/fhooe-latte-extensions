<?php

declare(strict_types=1);

namespace Fhooe\Latte;

use Fhooe\Router\Router;
use Latte\Extension;

/**
 * Latte extension that allows to use the fhooe/router methods urlFor() and getBasePath() within a Latte template.
 */
final class RouterExtension extends Extension
{
    public function __construct(private readonly Router $router)
    {
    }

    /**
     * Provides the router methods urlFor() and getBasePath() as Latte functions url_for and get_base_path.
     *
     * @return array<string, callable>
     */
    public function getFunctions(): array
    {
        return [
            'url_for' => $this->router->urlFor(...),
            'get_base_path' => $this->router->getBasePath(...),
        ];
    }
}