kucera/monolog-extensions
======
[![Build Status](https://travis-ci.org/pavelkucera/monolog-extensions.svg?branch=master)](https://travis-ci.org/pavelkucera/monolog-extensions)
[![Downloads this Month](https://img.shields.io/packagist/dm/kucera/monolog-extensions.svg)](https://packagist.org/packages/kucera/monolog-extensions)
[![Latest stable](https://img.shields.io/packagist/v/kucera/monolog-extensions.svg)](https://packagist.org/packages/kucera/monolog-extensions)


A set of [Monolog](http://github.com/seldaek/monolog) extensions.

Installation
------------

Using  [Composer](http://getcomposer.org/):

```sh
$ composer require kucera/monolog-extensions:~0.2.0
```


Blue Screen Handler
------------
Converts your exception reports into beautiful and clear html files using [Tracy](https://github.com/nette/tracy).

[![Uncaught exception rendered by Tracy](http://nette.github.io/tracy/images/tracy-exception.png)](http://nette.github.io/tracy/tracy-exception.html)

### Tell me how!
Just push the handler into the stack.
```php
use Kucera\Monolog\BlueScreenFactory;
use Kucera\Monolog\BlueScreenHandler;
use Monolog\Logger;

$logger = new Monolog\Logger('channel');

$logDirectory = __DIR__ . '/log';
$logger->pushHandler(new BlueScreenHandler(
    Factory::blueScreen(),
    $logDirectory,
    Logger::DEBUG,
    $bubble = TRUE
));
```
… Profit!
```php
$logger->critical('Exception occured!', array(
    'exception' => new Exception(),
));
```

#### Tips
You don't have to use the factory method, handler is instantiable on its own. `Kucera\Monolog\BlueScreenFactory::create()` might come in handy then.
