# Changelog

All notable changes to `disallowlister` will be documented in this file

## 0.4.0 - 2021-08-27
- Added whole word matching
- Better README

## 0.3.1 - 2021-08-23
- Added the Laravel implementation to README

## 0.3.0 - 2021-08-17
### Added
- Method add() and remove() now take both a string and an array
- Throw exception if $item is not a string or an array for method add() and remove()

## 0.2.0 - 2021-08-16
- Methods are now chainable
- Added setting for case sensivity

## 0.1.0 - 2021-08-15
### Added
- initial release
- The disallowtester tests a string aginst an array of disallowed strings.
- The disallowed strings can use wildcards.
- You can add items to the disallow list in the constructor, on the fly ande remove them.
