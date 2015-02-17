# Change Log
All notable changes to this project are documented in this file.
This project adheres to [Semantic Versioning](http://semver.org/).

## [Unreleased](https://github.com/ravage84/SwissPaymentSlipPdf/compare/0.7.0...master)
### Added

### Changed

### Fixed

## [0.7.0](https://github.com/ravage84/SwissPaymentSlipPdf/releases/tag/0.7.0) - 2015-02-17
### Added
- This change log
- .editorconfig file
- PHPUnit 3.7.38 as development dependency
- Scrutinizer CI integration & badges
- composer.lock (not ignored anymore)
- Testing with newer PHP versions and  HHVM in Travis CI
- A .gitattributes
- Packagist Download & Latest badges to the README
- PHPCS 2.1.* as developer dependency
- Setup some tests

### Changed
- Set swiss-payment-slip/swiss-payment-slip dependency to version 0.5.0
- Renamed SwissPaymentSlipPdf to PaymentSlipPdf (API breaking)
- Fully adopted the PSR2 Code Style
- Various CS and DocBlock improvements and other code clean up
- Adopted the PSR-4 autoloader standard
- Use a Type Hint for SwissPaymentSlip in the constructor
- Throw an InvalidArgumentException when constructing a SwissPaymentSlipPdf object with invalid parameters
- Reduce complexity of writePaymentSlipLines(), throw InvalidArgumentExceptions
- Implemented/Defined a fluent interface

### Fixed
- Removed misleading time key, which fooled Packagist

## [0.6.0](https://github.com/ravage84/SwissPaymentSlipPdf/releases/tag/0.6.0) - 2013-03-13
### Added
- Added parameter $elementName to SwissPaymentSlipPdf::writePaymentSlipLines()

## [0.5.0](https://github.com/ravage84/SwissPaymentSlipPdf/releases/tag/0.5.0) - 2013-03-08
### Added
- Initial commit with README, LICENSE, composer.json, Travis CI integration, PHPUnit config and actual code
