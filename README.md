Messages Component for Laravel and Orchestra Platform
==============

Messages Component bring a unified notification support for Laravel and Orchestra Platform.

[![Build Status](https://travis-ci.org/orchestral/messages.svg?branch=5.x)](https://travis-ci.org/orchestral/messages)
[![Latest Stable Version](https://poser.pugx.org/orchestra/messages/version)](https://packagist.org/packages/orchestra/messages)
[![Total Downloads](https://poser.pugx.org/orchestra/messages/downloads)](https://packagist.org/packages/orchestra/messages)
[![Latest Unstable Version](https://poser.pugx.org/orchestra/messages/v/unstable)](//packagist.org/packages/orchestra/messages)
[![License](https://poser.pugx.org/orchestra/messages/license)](https://packagist.org/packages/orchestra/messages)
[![Coverage Status](https://coveralls.io/repos/github/orchestral/messages/badge.svg?branch=5.x)](https://coveralls.io/github/orchestral/messages?branch=5.x)

## Table of Content

* [Version Compatibility](#version-compatibility)
* [Installation](#installation)
* [Configuration](#configuration)
* [Usage](#usage)
  - [Adding a Message](#adding-a-message)
  - [Extending a Message to Current Request](#extending-a-message-to-current-request)
  - [Displaying the Message in a View](#displaying-the-message-in-a-view)
* [Changelog](https://github.com/orchestral/messages/releases)

## Version Compatibility

Laravel    | Messages
:----------|:----------
 5.5.x     | 3.5.x
 5.6.x     | 3.6.x
 5.7.x     | 3.7.x
 5.8.x     | 3.8.x
 6.x       | 4.x
 7.x       | 5.x

## Installation

To install through composer, run the following command from terminal:

    composer require "orchestra/messages"


## Configuration

Add `Orchestra\Messages\MessagesServiceProvider` service provider in `config/app.php`.

```php
'providers' => [

    // ...

    Orchestra\Messages\MessagesServiceProvider::class,
],
```

### Aliases

You might want to add `Orchestra\Support\Facades\Messages` to class aliases in `config/app.php`:

```php
'aliases' => [

    // ...

    'Messages' => Orchestra\Support\Facades\Messages::class,
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

$message = Messages::copy();

if ($message instanceof Orchestra\Messages\MessageBag) {
    $message->setFormat('<div class="alert alert-:key">:message</div>');

    foreach (['error', 'info', 'success'] as $key) {
        if ($message->has($key)) {
            echo implode('', $message->get($key));
        }
    }
}
```
