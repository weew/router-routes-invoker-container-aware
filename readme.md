# Routes invoker

[![Build Status](https://img.shields.io/travis/weew/router-routes-invoker-container-aware.svg)](https://travis-ci.org/weew/router-routes-invoker-container-aware)
[![Code Quality](https://img.shields.io/scrutinizer/g/weew/router-routes-invoker-container-aware.svg)](https://scrutinizer-ci.com/g/weew/router-routes-invoker-container-aware)
[![Test Coverage](https://img.shields.io/coveralls/weew/router-routes-invoker-container-aware.svg)](https://coveralls.io/github/weew/router-routes-invoker-container-aware)
[![Version](https://img.shields.io/packagist/v/weew/router-routes-invoker-container-aware.svg)](https://packagist.org/packages/weew/router-routes-invoker-container-aware)
[![Licence](https://img.shields.io/packagist/l/weew/router-routes-invoker-container-aware.svg)](https://packagist.org/packages/weew/router-routes-invoker-container-aware)

## Table of contents

- [Installation](#installation)
- [Introduction](#introduction)
- [Usage](#usage)

## Installation

`composer require weew/router-routes-invoker-container-aware`

## Introduction

This package is meant to be used in combination with [weew/router](https://github.com/weew/router). It's job is to invoke routes that have been successfully matched by the router. It uses the [weew/container](https://github.com/weew/container) package to provide dependency injection.

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

If response object implements either the `IHttpResponseHolder` or `IHttpResponseable` interface, invoker will extract the http response and return it instead.

Router returns `null` whenever a route could not be matched. In this case, `RoutesInvoker` will return a 404 `HttpResponse` object instead.
