# Validator interface

[![Tests](https://github.com/quillstack/validator-interface/actions/workflows/tests.yml/badge.svg)](https://github.com/quillstack/validator-interface/actions/workflows/tests.yml)
[![Latest Version](https://img.shields.io/packagist/v/quillstack/validator-interface.svg)](https://packagist.org/packages/quillstack/validator-interface)
[![Downloads](https://img.shields.io/packagist/dt/quillstack/validator-interface.svg)](https://packagist.org/packages/quillstack/validator-interface)
[![PHP Version](https://img.shields.io/packagist/php-v/quillstack/validator-interface)](https://packagist.org/packages/quillstack/validator-interface)
[![StyleCI](https://github.styleci.io/repos/294927453/shield?branch=main)](https://github.styleci.io/repos/294927453?branch=main)
[![CodeFactor](https://www.codefactor.io/repository/github/quillstack/validator-interface/badge)](https://www.codefactor.io/repository/github/quillstack/validator-interface)
[![Quality Gate](https://sonarcloud.io/api/project_badges/measure?project=quillstack_validator-interface&metric=alert_status)](https://sonarcloud.io/summary/new_code?id=quillstack_validator-interface)
[![Coverage](https://sonarcloud.io/api/project_badges/measure?project=quillstack_validator-interface&metric=coverage)](https://sonarcloud.io/summary/new_code?id=quillstack_validator-interface)
[![Maintainability](https://sonarcloud.io/api/project_badges/measure?project=quillstack_validator-interface&metric=sqale_rating)](https://sonarcloud.io/summary/new_code?id=quillstack_validator-interface)
[![Reliability](https://sonarcloud.io/api/project_badges/measure?project=quillstack_validator-interface&metric=reliability_rating)](https://sonarcloud.io/summary/new_code?id=quillstack_validator-interface)
[![Security](https://sonarcloud.io/api/project_badges/measure?project=quillstack_validator-interface&metric=security_rating)](https://sonarcloud.io/summary/new_code?id=quillstack_validator-interface)
[![Maintainability](https://api.codeclimate.com/v1/badges/61a2e307aa53b1287d3f/maintainability)](https://codeclimate.com/github/quillstack/validator-interface/maintainability)
[![License](https://img.shields.io/packagist/l/quillstack/validator-interface)](https://github.com/quillstack/validator-interface/blob/main/LICENSE)

Common interface for Validator classes. Full documentation:
https://quillstack.org/validator-interface

One method, and two exception interfaces. Something which validates says so by implementing
this, and something which fails validation says so by implementing the other — so a caller can
tell a value it does not like from a mistake in the code.

## Why this exists

Validation is the one part of an application that everybody writes differently, and the one part
that everything else needs to be able to ask about. A request wants to know whether what arrived
is acceptable; it should not need to know how that was decided.

This is that question as an interface, in its own package, so a package can depend on *something
validating* without depending on how.

## Requirements

- PHP 8.1 or newer

## Installation

```shell
composer require quillstack/validator-interface
```

## Usage

```php
use Quillstack\ValidatorInterface\ValidatorInterface;

final class HostValidator implements ValidatorInterface
{
    public function __construct(private readonly string $host)
    {
    }

    public function validate(): bool
    {
        if (filter_var($this->host, FILTER_VALIDATE_DOMAIN) === false) {
            throw new UnknownHostException("Not a host: {$this->host}");
        }

        return true;
    }
}
```

The exception says which kind of thing went wrong:

```php
use Quillstack\ValidatorInterface\ValidationExceptionInterface;

final class UnknownHostException extends UriException implements ValidationExceptionInterface
{
}
```

Catching it is then catching one thing:

```php
try {
    $validator->validate();
} catch (ValidationExceptionInterface $exception) {
    // What was given is wrong — not the code that was given it.
}
```

## Technical documentation

| Interface | What it means |
| --- | --- |
| `ValidatorInterface` | `validate(): bool` — the thing validates something |
| `ValidatorExceptionInterface` | something went wrong in a validator |
| `ValidationExceptionInterface` | the value was wrong, which is the usual case; extends the one above |

`validate()` answers `true` or throws. It does not answer `false`: a caller which ignores the
answer would carry on with a value nobody accepted, and a thrown exception cannot be ignored
by accident.

### Who implements it

- [quillstack/uri](https://github.com/quillstack/uri) — the scheme and the host of a URI
- [quillstack/server-request](https://github.com/quillstack/server-request) — what `$_SERVER` must hold
- [quillstack/response](https://github.com/quillstack/response) — that a status code is one that exists

There is nothing to run here: a package which only names things has no behaviour to test.

## Benchmark

**There is nothing here to measure.**

This package is an interface. It has no behaviour of its own, so there is no operation to time
and no library that does the same nothing to compare it with.

What is worth comparing is an implementation, and the honest place for that table is in whichever
package implements it rather than here.

## Tests

```shell
composer test
composer stan
```

## The rest of Quillstack

This is one component of [Quillstack](https://github.com/quillstack), a PHP framework which is
as simple to use as it is strict about what it does.

- [quillstack/framework](https://github.com/quillstack/framework) — where validation runs before a controller
- [quillstack/server-request](https://github.com/quillstack/server-request) — where a request class declares its own rules
- [quillstack/storage-interface](https://github.com/quillstack/storage-interface) — the same idea, for files

## License

MIT. See [LICENSE](LICENSE).
