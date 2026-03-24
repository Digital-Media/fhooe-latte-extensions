# fhooe/latte-extensions

A collection of Latte extensions for other *fhooe* packages used in the [Media Technology and Design](https://fh-ooe.at/en/degree-programs/media-technology-and-design-bachelor) program at the [University of Applied Sciences Upper Austria](https://fh-ooe.at/en/campus-hagenberg). It is intended to be used with packages such as [*fhooe/router*](https://github.com/Digital-Media/fhooe-router) or [*fhooe/router-skeleton*](https://github.com/Digital-Media/fhooe-router-skeleton), respectively.

## Installation

Integrate the package into your project using [Composer](https://getcomposer.org/):

```bash
composer require fhooe/latte-extensions
```

## Contents

This package contains the following extensions:

### `RouterExtension`

An extension to access the *fhooe/router* package from within Latte templates. It provides the following functions:
- `url_for("/some/route")`: Returns the full URL for the given route.
- `get_base_path()`: Returns the base path if the application is not in the server's document root.

### `SessionExtension`

Provides the function `session("someKey")`, which returns the value of the given key in the session. That way, not every needed entry in `$_SESSION` (or even the whole superglobal) must be passed to the template.

## Usage

Register the extensions with your Latte engine, then use the provided functions in your templates:

### `RouterExtension`

Register the extension and provide an instance of `Fhooe\Router\Router`.

```php
$latte->addExtension(new Fhooe\Latte\RouterExtension($router));
```

Use the functions:

```latte
{url_for("/some/route")}
{get_base_path()}
```

This will output the full path for the route or a base path (if you need to prefix static paths for stylesheets or other files).

### `SessionExtension`

Register the extension:

```php
$latte->addExtension(new Fhooe\Latte\SessionExtension());
```

Use the function:

```latte
{session("someKey")}
```

This will output the value of `$_SESSION["someKey"]`. If nothing is stored under that key, sessions are inactive, or the session superglobal is unavailable, an empty string will be returned so that you can use the function safely.

## Contributing

If you'd like to contribute, please refer to [CONTRIBUTING](https://github.com/Digital-Media/fhooe-latte-extensions/blob/main/CONTRIBUTING.md) for details.

## License

*fhooe/latte-extensions* is licensed under the MIT license. See [LICENSE](https://github.com/Digital-Media/fhooe-latte-extensions/blob/main/LICENSE) for more information.
