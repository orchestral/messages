Notification for Laravel 4
==============

Messages Component bring a unified notification support for Laravel 4.

[![Latest Stable Version](https://poser.pugx.org/orchestra/messages/v/stable.png)](https://packagist.org/packages/orchestra/support)
[![Total Downloads](https://poser.pugx.org/orchestra/messages/downloads.png)](https://packagist.org/packages/orchestra/support)
[![Build Status](https://travis-ci.org/orchestral/messages.svg?branch=master)](https://travis-ci.org/orchestral/support)
[![Coverage Status](https://coveralls.io/repos/orchestral/messages/badge.png?branch=master)](https://coveralls.io/r/orchestral/support?branch=master)
[![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/orchestral/messages/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/orchestral/support/)

## Quick Installation

To install through composer, simply put the following in your `composer.json` file:

```json
{
    "require": {
        "orchestra/messages": "2.2.*"
    }
}
```

Next add the service provider in `app/config/app.php`.

```php
'providers' => array(

    // ...

    'Orchestra\Messages\MessagesServiceProvider',
),
```

## Resources

* [Documentation](http://orchestraplatform.com/docs/latest/components/support)
* [Change Log](http://orchestraplatform.com/docs/latest/components/messages/changes#v2-2)
