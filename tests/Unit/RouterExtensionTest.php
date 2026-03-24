<?php

declare(strict_types=1);

/**
 * Tests for RouterExtension.
 */

use Fhooe\Latte\RouterExtension;
use Fhooe\Router\Router;

/**
 * Creates a Router and a RouterExtension before each test.
 */
beforeEach(function () {
    $this->router = new Router();
    $this->routerExtension = new RouterExtension($this->router);
    $_SERVER["REQUEST_METHOD"] = "GET";
    $_SERVER["REQUEST_URI"] = "/test";
});

/**
 * Checks that the extension exposes the expected Latte functions.
 */
it("provides the url_for and get_base_path functions", function () {
    $functions = $this->routerExtension->getFunctions();

    expect($functions)->toHaveKeys(["url_for", "get_base_path"]);
});

/**
 * Uses url_for() in a template to output the correct URL when no base path is set.
 */
it("renders the correct url from url_for() when no base path is set", function () {
    $output = render($this->routerExtension, "{url_for('/test')}");

    expect($output)->toBe("/test");
});

/**
 * Uses url_for() in a template to output the correct URL when a base path is set.
 */
it("renders the correct url from url_for() when a base path is set", function () {
    $_SERVER["REQUEST_URI"] = "/some/basepath/test";
    $this->router->basePath = "/some/basepath";

    $output = render($this->routerExtension, "{url_for('/test')}");

    expect($output)->toBe("/some/basepath/test");
});

/**
 * Uses get_base_path() in a template to output an empty string when no base path is set.
 */
it("renders an empty string from get_base_path() when no base path is set", function () {
    $output = render($this->routerExtension, "{get_base_path()}");

    expect($output)->toBeEmpty();
});

/**
 * Uses get_base_path() in a template to output the base path when one is set.
 */
it("renders the base path from get_base_path() when a base path is set", function () {
    $this->router->basePath = "/some/basepath";

    $output = render($this->routerExtension, "{get_base_path()}");

    expect($output)->toBe("/some/basepath");
});

/**
 * Uses url_for() with a nested path in a template.
 */
it("renders a nested path correctly from url_for()", function () {
    $output = render($this->routerExtension, "{url_for('/deep/nested/path')}");

    expect($output)->toBe("/deep/nested/path");
});

/**
 * Uses url_for() with a nested path and a base path set.
 */
it("renders a nested path with a base path correctly from url_for()", function () {
    $this->router->basePath = "/api/v1";

    $output = render($this->routerExtension, "{url_for('/users/123')}");

    expect($output)->toBe("/api/v1/users/123");
});

/**
 * Uses url_for() with a query string in a template.
 * The |noescape filter prevents Latte from HTML-encoding the ampersand.
 */
it("renders a url with a query string correctly from url_for()", function () {
    $output = render($this->routerExtension, "{url_for('/search?q=hello&page=2')|noescape}");

    expect($output)->toBe("/search?q=hello&page=2");
});

/**
 * Verifies that url_for() throws an InvalidArgumentException when the pattern has no leading slash.
 */
it("throws InvalidArgumentException from url_for() when the pattern has no leading slash", function () {
    expect(fn() => render($this->routerExtension, "{url_for('no-slash')}"))
        ->toThrow(InvalidArgumentException::class, "Route pattern must start with a slash");
});
