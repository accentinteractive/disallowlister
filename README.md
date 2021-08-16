# Disallowlister

[![Latest Version on Packagist](https://img.shields.io/packagist/v/accentinteractive/disallowlister.svg?style=flat-square)](https://packagist.org/packages/accentinteractive/disallowlister)
[![Build Status](https://img.shields.io/travis/accentinteractive/disallowlister/master.svg?style=flat-square)](https://travis-ci.org/accentinteractive/disallowlister)
[![Quality Score](https://img.shields.io/scrutinizer/g/accentinteractive/disallowlister.svg?style=flat-square)](https://scrutinizer-ci.com/g/accentinteractive/disallowlister)
[![Total Downloads](https://img.shields.io/packagist/dt/accentinteractive/disallowlister.svg?style=flat-square)](https://packagist.org/packages/accentinteractive/disallowlister)

This little package tests a string against a disallowlist. 

The `isDisallowed()` method can use wildcards, like *. 

Under the hood, `accentinteractive/disallowtester` uses `fnmatch()`, so you can use the same wildcards as in that php function (the globbing wildcard patterns):
- `*sex*` disallows **sex**, **sex**uality and bi**sex**ual.
- `cycle*` disallows cycle and cycles, but not bicycle.
- `m[o,u]m` disallows mom and mum, but allows mam.
- `m?n` disallows man and men, but allows moon.

- [Installation](#installation) 
- [Examples](#usage) 
- [Config settings](#config-settings)

## Installation

You can install the package via composer:

```bash
composer require accentinteractive/disallowlister
```

## Usage
```php
// Create a new Disallowlister and add items to the disallow list.
$disallowLister = new DisallowLister(['foo', '*bar*']);
$disallowLister->addItem('b?t');

// Match a sting agains it.
$disallowLister->isDisallowed('My favorite bars'); // Returns true
$disallowLister->isDisallowed('My favorite bit'); // Returns true
$disallowLister->isDisallowed('My favorite footer'); // Returns false
```

### Testing

``` bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email joost@accentinteractive.nl instead of using the issue tracker.

## Credits

- [Joost van Veen](https://github.com/accentinteractive)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
