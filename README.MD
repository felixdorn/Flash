# Flash
![Packagist](https://img.shields.io/packagist/l/felixdorn/flash)
![Packagist Version](https://img.shields.io/packagist/v/felixdorn/flash)
[![Build Status](https://travis-ci.org/felixdorn/flash.svg?branch=master)](https://travis-ci.org/felixdorn/flash)
[![codecov](https://img.shields.io/codecov/c/github/felixdorn/flash)](https://codecov.io/gh/felixdorn/flash)
![Packagist](https://img.shields.io/packagist/dm/felixdorn/flash)


### Installation
Via composer
> composer require felixdorn/flash

### Getting started
This package is made to work with $_SESSION and they will be automatically started. However, you could provide an array to work with instead of sessions. In this case, sessions will not be started.

```php
$flasher = Flasher::getInstance();
```

If you don't wan't to use sessions :
```php
$flasher->setStorer($myArray);
```
You're good to go.

### Usage
> Every global function is wrapped by a `function_exists()` to avoid compatibility issues.

##### Types
> There is currently 4 types of Flash
* Error
* Warning
* Success
* Info

##### Add a message

###### OOP
```php
$flasher
    ->message('Some error', 'error')
    ->error(['Error 1', 'Error 2'])
    ->success('Blabla')
    ->info('Some informations');
```

###### With a function
```php
flash('Some error', 'error');

flash(['Success 1', 'Success 2'], 'success');

flash()
    ->message(['Some message', 'A message'], 'error')
    ->success('Cool thing')
    ->info(['Information 1', 'Information 2']);   
```

##### Display

###### OOP
```php
// Display every flash
echo $flasher->display();

// Display only success flash
echo $flasher->display('success');
```
###### With a function
```php
// Display every flash
displayFlashes();
// Display only error flash
displayFlashes('error');
```

##### Clear flashes

###### OOP
```php
$flasher->clear();
```

###### With a function
```php
clearFlashes();
```

##### Templates
Flash comes with two templates,
* BulmaTemplate (.notification.is-{$type})
* BootstrapTemplate (.alert.alert-{$type})
* DefaultTemplate, same as BootstrapTemplate

##### Custom Templates
To customize the output of `display` method, you need to register a template.

###### Create a template
```php
class MyTemplate implements TemplateInterface {
    
    /**
    * @param $messages Flashes as text
    * @param $type Message type (info, success, warning, error)
    */
    public function wrap(string $messages, $type) {
        return sprintf("<div class="alert-%s>%s</div>", $type, $messages)
    }
}
```

###### Register a template
```php
$flasher->pushTemplate($template);

$template = new MyTemplate();
```

### Advanced Configuration

##### Custom array
> This is particularly useful for testing purposes, while sessions don't work well with unit tests, it's a way to bypass this limit of units tests.
```php
$flasher->setStorer($myArray);
```

### Security

If you discover any security related issues, please email github@felixdorn.fr instead of using the issue tracker.

### Credits
* [Félix Dorn](https://felixdorn.fr)

### License
This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <https://www.gnu.org/licenses/>
