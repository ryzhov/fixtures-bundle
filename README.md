FixturesBundle
==============

The `FixturesBundle` provides usefull service for load fixtures from yml or csv files

License
=======

This bundle is released under the [MIT license](LICENSE)

Installation
============

Require the bundle and its dependencies with composer:

```bash
$ composer require ryzhov/fixtures-bundle
```

Register the bundle:

```php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        new Ryzhov\Bundle\FixturesBundle(),
    );
}
```

Usage
=====

Add the `asterisk` section in your configuration file:

```php

```
