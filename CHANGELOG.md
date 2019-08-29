# Changelog

This changelog references the relevant changes (bug and security fixes) done to `orchestra/messages`.

## 4.0.0

Released: 2019-08-29

### Changes

* Update support for Laravel Framework v6.0.

### Removed

* Remove deprecated `Orchestra\Messages\MessageBag::retrieve()`, use `Orchestra\Messages\MessageBag::copy()` instead.
* Remove `Orchestra\Messages\MessageBag::serialize()` as it's no longer needed to properly serialize the flash message.

## 3.8.2

Released: 2019-08-08

### Changes

* Refactor `Orchestra\Messages\MessageBag`.

## 3.8.1

Released: 2019-08-04

### Changes

* Use `static function` rather than `function` whenever possible, the PHP engine does not need to instantiate and later GC a `$this` variable for said closure.

## 3.8.0 

Released: 2018-03-02

### Changes

* Update support for Laravel Framework v5.8.
* Simplify `Orchestra\Messages\Http\Middleware\StoreMessageBag` and helper to use facade.

## 3.7.1

Released: 2019-02-21

### Changes

* Improve performance by prefixing all global functions calls with `\` to skip the look up and resolve process and go straight to the global function.

## 3.7.0 

Released: 2018-08-23

### Changes

* Update support for Laravel Framework v5.7.
* Disable `allow_classes` when running `unserialize()`.

## 3.6.1

Released: 2018-08-28

### Changes

* return `self` should only be used when method is marked as `final`.

## 3.6.0 

Released: 2018-02-08

### Changes

* Update support for Laravel Framework v5.6.
