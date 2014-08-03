Messages Component for Laravel 4 and Orchestra Platform 2
==============

Messages Component bring a unified notification support for Laravel 4 and Orchestra Platform 2.

[![Latest Stable Version](https://poser.pugx.org/orchestra/messages/v/stable.png)](https://packagist.org/packages/orchestra/messages)
[![Total Downloads](https://poser.pugx.org/orchestra/messages/downloads.png)](https://packagist.org/packages/orchestra/messages)
[![Build Status](https://travis-ci.org/orchestral/messages.svg?branch=master)](https://travis-ci.org/orchestral/messages)
[![Coverage Status](https://coveralls.io/repos/orchestral/messages/badge.png?branch=master)](https://coveralls.io/r/orchestral/messages?branch=master)
[![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/orchestral/messages/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/orchestral/messages/)

## Table of Content

* [Version Compatibility](#version-compatibility)
* [Installation](#installation)
* [Configuration](#configuration)
* [Usage](#usage)
  - [Adding a Message](#adding-a-message)
  - [Extending a Message to Current Request](#extending-a-message-to-current-request)
  - [Displaying the Message in a View](#displaying-the-message-in-a-view)
* [Change Log](http://orchestraplatform.com/docs/latest/components/messages/changes#v2-2)

Laravel    | Messages
:----------|:----------
 4.2.x     | 2.2.x@dev

## Installation

To install through composer, simply put the following in your `composer.json` file:

```json
{
    "require": {
        "orchestra/messages": "2.2.*"
    }
}
```

And then run `composer install` from the terminal.

### Quick Installation

Above installation can also be simplify by using the following command:

    composer require "orchestra/messages=2.2.*"

Next add the service provider in `app/config/app.php`.

## Configuration

Add `Orchestra\Messages\MessagesServiceProvider` service provider in `app/config/app.php`.

```php
'providers' => array(

    // ...

    'Orchestra\Messages\MessagesServiceProvider',
),
```

### Aliases

You might want to add `Orchestra\Messages\Facade` to class aliases in `app/config/app.php`:

```php
'aliases' => array(

    // ...

    'Orchestra\Messages' => 'Orchestra\Messages\Facade',
),
```

## Usage

### Adding a Message

Adding a message is as easy as following:

```php
Orchestra\Messages::add('success', 'A successful message');
```

You can also chain messages:

```php
Orchestra\Messages::add('success', 'A successful message')
    ->add('error', 'Some error');
```

### Extending a Message to Current Request

There might be situation where you need to extend a message to the current response instead of the following request. You can do this with:

```php
Orchestra\Messages::extend(function ($message) {
    $message->add('info', 'Read-only mode');
});
```

### Displaying the Message in a View

Here's an example how you can display the message:

```php
<?php

$message = Orchestra\Messages::retrieve();

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
