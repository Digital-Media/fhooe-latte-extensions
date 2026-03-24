<?php

declare(strict_types=1);

use Latte\Engine;
use Latte\Extension;
use Latte\Loaders\StringLoader;

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
*/

/**
 * Helper function to render a Latte template string with a given extension.
 * Uses StringLoader with null (name = content) so Latte caches by template content.
 * @param Extension $extension The extension to add to the Latte engine.
 * @param string $template The Latte template string to render.
 * @param array<string, mixed> $data Variables to pass to the template.
 * @return string The rendered output.
 */
function render(Extension $extension, string $template, array $data = []): string
{
    $latte = new Engine();
    $latte->setLoader(new StringLoader());
    $latte->setTempDirectory(sys_get_temp_dir());
    $latte->addExtension($extension);
    return $latte->renderToString($template, $data);
}
