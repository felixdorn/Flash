![Library logo](art/logo.png)
# Flash
![Packagist Version](https://img.shields.io/packagist/v/felixdorn/flash)
[![Build Status](https://travis-ci.org/felixdorn/flash.svg?branch=rc2.0.0)](https://travis-ci.org/felixdorn/flash)
[![codecov](https://img.shields.io/codecov/c/github/felixdorn/flash)](https://codecov.io/gh/felixdorn/flash)

* Extensible
* Fully tested and easily testable
* Allow functional use
* Support templates


## Getting started

```bash
composer require felixdorn/flash
```

Before using `Flash`, you need a [Driver](#drivers) that implements the [DriverInterface](src/Drivers/DriverInterface.php) and a template.

```php
use Felix\Flash\Drivers\SessionDriver;
use Felix\Flash\Flash;
use Felix\Flash\Templates\SpectreTemplate;

$driver = new SessionDriver([
    // session_start options
    // see https://www.php.net/manual/fr/function.session-start.php
]);


// A random template
$template = new SpectreTemplate();

$flash = new Flash($driver, $template);
```

## Usage

These are common examples to work with flash.

> In these example, i assume that you have already made the setup and have a working Flash instance.

### Flashing
```php
$flash->success('message');

$flash->warning('message');

$flash->error('message');

$flash->info('message');

$flash->flash('type', 'message');
```

### Rendering

```php
$flash->success('message');
$flash->warning('message1');

$flash->render(); // implicitly it's $flash->render('all')

// render 'message' and 'message1' using the defined template

$flash->render('success');

// render 'message' but not 'message1'
```

### Custom types
```php
$flash->message('really-important', 'In movie gone in 60 seconds, things are gone in 60 seconds');

$flash->render(); // will also render `really-important` as a normal type.

$flash->render('really-important'); // will render `really-important` flashes using the default template
```

### Clear messages

```php
$flash->success('Cool!');

$flash->clear('success'); // delete every success flash using the Driver

$flash->render(); // Won't render anything

$flash->success('Cool!');
$flash->error('Uhhhh.');

$flash->clear(); // Clear every flashes
 
$flash->render(); // Won't render anything


```

### Enabling & Disabling

```php
$flash->error('Bad thing.');

$flash->disable();
// NOTE: Here, when disabling, you can still clear or render

$flash->success('Good thing');

$flash->enable();

$flash->render('all'); // 'all' is optional, it's the default value

// Here, only 'Bad thing.' will be rendered.
```


## Drivers

There is only 2 but it's easy to implement a new one (PR appreciated :p).

* [ArrayDriver](src/Drivers/ArrayDriver.php) Driver that should only be used for testing purpose.
* [SessionDriver](src/Drivers/SessionDriver.php) Driver to work with the most common implementation of session in PHP.

Let's dive into what they do, and how they work. This part is useful if you want to create your own, otherwise jump to the [next](#templates) session.

A driver must implement these 3 methods :

* clear(): self
* push(FlashData $data): self
* all(string $type = 'all'): array

### The clear method

This is the simple one. It should clear any flash pushed.

### The push method

This one receive a FlashData with the type of flash and the value and should register it to be able to get it back.

### The all method

This one should if `$type = 'all'` return every flash pushed formatted like this :

```php
return [
    '{someType}' => [
        'someFlash'
        // ...
    ],
    // ...
];
```

If the `$type` is something else then, it should return an array with only the flash inside this type.

```php
return [
    'someFlash'
];
```

## Templates

* [BootstrapTemplate](src/Templates/BootstrapTemplate.php)
* [BulmaTemplate](src/Templates/BulmaTemplate.php)
* [Semantic2Template](src/Templates/SpectreTemplate.php)
* [SpectreTemplate](src/Templates/SpectreTemplate.php)
* [TestableTemplate](src/Templates/TestableTemplate.php)
* [NullTemplate](src/Templates/NullTemplate.php)
 
> TestableTemplate just returns `{type}: {value}`, so it's easier to test if a flash worked well instead of typing all of the boring HTML.

### Registering a template
```php
$flash->setTemplate(...);
```

> You can also set it when constructing the *Flash* object

### Template using a string
This one is the most basic, but also the most useful.

```
<div class="alert {type}">{flash}</div>
```

So, if you flash an success Hello! flash. It will output 
```
<div class="alert success">Hello!</div>
```

### Template using a callable

```php
function (string $type, string $message): string {
    return sprintf('<div class="alert %s">%s</div>', $type, $message);
}
```

In this case, you don't need a callable, and you could just use a string based template but this is how it works. 

### Template using TemplateInterface

```php

use Felix\Flash\Templates\TemplateInterface;

class MyTemplate implements TemplateInterface {
    public function toHtml(string $type,string $message){
        return sprintf('<div class="alert %s">%s</div>', $type, $message);
    }
}
```

In this case, you don't need a Template class, and you could just use a string based template but this is how it works.


## Testing

```
composer test
```

### Security

If you discover any security related issues, please email github@felixdorn.fr instead of using the issue tracker.

## Credits
* [Félix Dorn](https://felixdorn.fr)

### Contributors
* [Grafikart](https://github.com/grafikart)
