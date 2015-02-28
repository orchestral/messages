Messages Component for Laravel and Orchestra Platform
==============

Messages Component bring a unified notification support for Laravel and Orchestra Platform.

[![Latest Stable Version](https://img.shields.io/github/release/orchestral/messages.svg?style=flat)](https://packagist.org/packages/orchestra/messages)
[![Total Downloads](https://img.shields.io/packagist/dt/orchestra/messages.svg?style=flat)](https://packagist.org/packages/orchestra/messages)
[![MIT License](https://img.shields.io/packagist/l/orchestra/messages.svg?style=flat)](https://packagist.org/packages/orchestra/messages)
[![Build Status](https://img.shields.io/travis/orchestral/messages/master.svg?style=flat)](https://travis-ci.org/orchestral/messages)
[![Coverage Status](https://img.shields.io/coveralls/orchestral/messages/master.svg?style=flat)](https://coveralls.io/r/orchestral/messages?branch=master)
[![Scrutinizer Quality Score](https://img.shields.io/scrutinizer/g/orchestral/messages/master.svg?style=flat)](https://scrutinizer-ci.com/g/orchestral/messages/)

## Table of Content

* [Version Compatibility](#version-compatibility)
* [Installation](#installation)
* [Configuration](#configuration)
* [Usage](#usage)
  - [Adding a Message](#adding-a-message)
  - [Extending a Message to Current Request](#extending-a-message-to-current-request)
  - [Displaying the Message in a View](#displaying-the-message-in-a-view)
* [Change Log](http://orchestraplatform.com/docs/latest/components/messages/changes#v3-0)

## Version Compatibility

Laravel    | Messages
:----------|:----------
 4.2.x     | 2.2.x
 5.0.x     | 3.0.x
 5.1.x     | 3.1.x@dev

## Installation

To install through composer, simply put the following in your `composer.json` file:

```json
{
    "require": {
        "orchestra/messages": "3.1.*"
    }
}
```

And then run `composer install` from the terminal.

### Quick Installation

Above installation can also be simplify by using the following command:

    composer require "orchestra/messages=3.1.*"


## Configuration

Add `Orchestra\Messages\MessagesServiceProvider` service provider in `config/app.php`.

```php
'providers' => [

    // ...

    'Orchestra\Messages\MessagesServiceProvider',
],
```

### Aliases

You might want to add `Orchestra\Support\Facades\Messages` to class aliases in `config/app.php`:

```php
'aliases' => [

    // ...

    'Messages' => 'Orchestra\Support\Facades\Messages',
],
```

## Usage

### Adding a Message

Adding a message is as easy as following:

```php
Messages::add('success', 'A successful message');
```

You can also chain messages:

```php
Messages::add('success', 'A successful message')
    ->add('error', 'Some error');
```

### Extending a Message to Current Request

There might be situation where you need to extend a message to the current response instead of the following request. You can do this with:

```php
Messages::extend(function ($message) {
    $message->add('info', 'Read-only mode');
});
```

### Displaying the Message in a View

Here's an example how you can display the message:

```php
<?php

$message = Messages::retrieve();

if ($message instanceof Orchestra\Messages\MessageBag) {
    foreach (['error', 'info', 'success'] as $key) {
        if ($message->has($key)) {
            $message->setFormat(
                '<div class="alert alert-'.$key.'">:message</div>'
            );
            echo implode('', $message->get($key));
        }
    }
}
```

## Resources

* [Documentation](http://orchestraplatform.com/docs/latest/components/messages)
