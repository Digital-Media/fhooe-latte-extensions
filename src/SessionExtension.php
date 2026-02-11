<?php

declare(strict_types=1);

namespace Fhooe\Latte;

use Latte\Extension;

/**
 * Latte extension that allows to query entries in the $_SESSION superglobal and display them in the template.
 */
final class SessionExtension extends Extension
{
    /**
     * Provides the Latte function session($key) that allows to query an entry in $_SESSION with the given key.
     *
     * @return array<string, callable>
     */
    public function getFunctions(): array
    {
        return [
            'session' => $this->getSessionEntry(...),
        ];
    }

    /**
     * Retrieves an entry from $_SESSION with a given key.
     *
     * @return mixed Returns the entry from $_SESSION or empty string if it is not present or $_SESSION does not exist.
     */
    public function getSessionEntry(string $key): mixed
    {
        return $_SESSION[$key] ?? '';
    }
}