<?php

declare(strict_types=1);

/**
 * Tests for SessionExtension.
 */

use Fhooe\Latte\SessionExtension;

/**
 * Creates a SessionExtension and initializes a clean session before each test.
 */
beforeEach(function () {
    $this->sessionExtension = new SessionExtension();
    if (session_status() === PHP_SESSION_ACTIVE) {
        session_destroy();
    }
    session_start();
    $_SESSION = [];
});

afterEach(function () {
    $_SESSION = [];
    if (session_status() === PHP_SESSION_ACTIVE) {
        session_destroy();
    }
});

/**
 * Checks that the extension exposes the expected Latte function.
 */
it("provides the session function", function () {
    $functions = $this->sessionExtension->getFunctions();

    expect($functions)->toHaveKey("session");
});

/**
 * Verifies that a missing key returns an empty string via the PHP method.
 */
it("returns an empty string for a missing session key", function () {
    expect($this->sessionExtension->getSessionEntry("missing"))->toBe("");
});

/**
 * Verifies that an existing string value is returned correctly via the PHP method.
 */
it("returns the correct value for an existing session key", function () {
    $_SESSION["name"] = "Alice";

    expect($this->sessionExtension->getSessionEntry("name"))->toBe("Alice");
});

/**
 * Verifies that the session function returns an empty string for a missing key when rendered in a template.
 */
it("renders an empty string from session() for a missing key", function () {
    $output = render($this->sessionExtension, "{session('missing')}");

    expect($output)->toBe("");
});

/**
 * Verifies that the session function renders an existing string value correctly in a template.
 */
it("renders an existing session value from session()", function () {
    $_SESSION["greeting"] = "Hello, World!";

    $output = render($this->sessionExtension, "{session('greeting')}");

    expect($output)->toBe("Hello, World!");
});

/**
 * Verifies that scalar types (string, int, bool) are rendered correctly in a template.
 */
it("renders different scalar session types correctly", function () {
    $_SESSION["str"] = "hello";
    $_SESSION["num"] = 42;
    $_SESSION["flag"] = true;

    $output = render($this->sessionExtension, "{session('str')} {session('num')} {session('flag')}");

    expect($output)->toBe("hello 42 1");
});

/**
 * Verifies that array and nested values are accessible via the PHP method.
 */
it("returns array values correctly from getSessionEntry()", function () {
    $_SESSION["user"] = ["id" => 1, "name" => "Alice"];

    expect($this->sessionExtension->getSessionEntry("user"))->toBe(["id" => 1, "name" => "Alice"]);
});

/**
 * Verifies that getSessionEntry() returns an empty string when $_SESSION is not initialized.
 */
it("returns an empty string when the session is not started", function () {
    session_destroy();
    unset($_SESSION);

    expect($this->sessionExtension->getSessionEntry("key"))->toBe("");
});
