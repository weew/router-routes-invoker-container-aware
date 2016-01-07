# Routes invoker

[![Build Status](https://img.shields.io/travis/weew/php-router-routes-invoker-container-aware.svg)](https://travis-ci.org/weew/php-router-routes-invoker-container-aware)
[![Code Quality](https://img.shields.io/scrutinizer/g/weew/php-router-routes-invoker-container-aware.svg)](https://scrutinizer-ci.com/g/weew/php-router-routes-invoker-container-aware)
[![Test Coverage](https://img.shields.io/coveralls/weew/php-router-routes-invoker-container-aware.svg)](https://coveralls.io/github/weew/php-router-routes-invoker-container-aware)
[![Dependencies](https://img.shields.io/versioneye/d/php/weew:php-router-routes-invoker-container-aware.svg)](https://versioneye.com/php/weew:php-router-routes-invoker-container-aware)
[![Version](https://img.shields.io/packagist/v/weew/php-router-routes-invoker-container-aware.svg)](https://packagist.org/packages/weew/php-router-routes-invoker-container-aware)
[![Licence](https://img.shields.io/packagist/l/weew/php-router-routes-invoker-container-aware.svg)](https://packagist.org/packages/weew/php-router-routes-invoker-container-aware)

## Table of contents

- [Installation]
- [Introduction]
- [Usage]

## Installation

`composer require weew/php-router-routes-invoker-container-aware`

## Introduction

This package is meant to be used in combination with [weew/php-router](https://github.com/weew/php-router). It's job is to invoke routes that have been successfully matched by the router. It uses the [weew/php-container](https://github.com/weew/php-container) package to provide dependency injection.

## Usage

Lets say you have successfully matched a route:

```php
$route = $router->match(HttpRequestMethod::GET, new Url('foo-bar'));
```

Now you have to invoke the matched route:

```php
$routesInvoker = new RoutesInvoker(new Container());
$response = $routesInvoker->invoke($route);
$response->send();
```

Note: router returns `null` when no route could be matched. If that's the case, RouteInvoker will return a 404 response for you.
