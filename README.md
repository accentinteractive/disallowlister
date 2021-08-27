# Disallowlister

[![Latest Version on Packagist](https://img.shields.io/packagist/v/accentinteractive/disallowlister.svg?style=flat-square)](https://packagist.org/packages/accentinteractive/disallowlister)
[![Build Status](https://img.shields.io/travis/accentinteractive/disallowlister/master.svg?style=flat-square)](https://travis-ci.org/accentinteractive/disallowlister)
[![Quality Score](https://img.shields.io/scrutinizer/g/accentinteractive/disallowlister.svg?style=flat-square)](https://scrutinizer-ci.com/g/accentinteractive/disallowlister)
[![Total Downloads](https://img.shields.io/packagist/dt/accentinteractive/disallowlister.svg?style=flat-square)](https://packagist.org/packages/accentinteractive/disallowlister)

This little package tests a string against a disallowlist. 

If you are looking for a Laravel-specific implementation, see https://github.com/accentinteractive/laravel-disallowlister 

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

### Setting the disallowlist
You can pass the disallowlist in the constructor or via other methods.
```php
// Pass the disallowlist in the constructor 
$disallowLister = new DisallowLister(['foo']); // ['foo']

// Set the disallowlist in the setter method
$disallowLister->setDisallowList(['bar']); // ['bar']

// Add an item to the disallowlist
$disallowLister->add('baz'); // ['bar', 'baz']

// Add multiple items to the disallowlist
$disallowLister->add(['bat', 'fiz']); // ['bar', 'baz', 'bat', 'fiz']

// Remove an item from the disallowlist
$disallowLister->remove('fiz'); // ['bar', 'baz', 'bat']

// Remove multiple items from the disallowlist
$disallowLister->remove(['baz', 'bat']); // ['bar']
```

### Checking data against the disallowlist
```php
## Literal string
$disallowLister = new DisallowLister(['bar', 'foo']);

$disallowLister->isDisallowed('bar'); // Returns true
$disallowLister->isDisallowed('bars'); // Returns false

## Wildcards
// Under the hood, `accentinteractive/disallowtester` 
// uses `fnmatch()`, so you can use the same 
// wildcards as in that php function (the 
// globbing wildcard patterns):
(new DisallowLister(['b?r']))->isDisallowed('bar'); // Returns true
(new DisallowLister(['m[o,u]m']))->isDisallowed('mom'); // Returns true
(new DisallowLister(['*bar*']))->isDisallowed('I like crowbars'); // Returns true
```

### Case sensitivity
```php
// By default, matching is not case sensitive
(new DisallowLister(['bar']))->isDisallowed('BAR'); // Returns true

// To set case sensitive matching
(new DisallowLister(['bar']))->caseSensitive(true)->isDisallowed('BAR'); // Returns false
```

### Whole word checking
```php
// By default the entire string is checked. 
(new DisallowLister())->setDisallowList(['bar'])->isDisallowed('My favorite bar'); // Returns false

// Check word for word.
(new DisallowLister())->setDisallowList(['bar'])->setWordForWord(true)->isDisallowed('My favorite bar'); // Returns true
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
