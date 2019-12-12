<img src="https://api.whichbrowser.net/whichbrowser.svg" width="400">

This is an extremely complicated and almost completely useless browser sniffing library. Useless because you shouldn't use browser sniffing. So stop right now and go read something about feature detecting instead. I'm serious. Go away. You'll thank me later.


WhichBrowser/Parser-PHP
=======================

The PHP version of WhichBrowser for use on a server. Fully compatible with PHP 5.4 or higher, including PHP 7.

[![Build Status](https://travis-ci.org/WhichBrowser/Parser-PHP.svg?branch=master)](https://travis-ci.org/WhichBrowser/Parser-PHP)
[![Coverage Status](https://coveralls.io/repos/WhichBrowser/Parser-PHP/badge.svg?branch=master&service=github)](https://coveralls.io/github/WhichBrowser/Parser-PHP?branch=master)
[![License](https://poser.pugx.org/whichbrowser/parser/license)](https://packagist.org/packages/whichbrowser/parser)
[![Latest Stable Version](https://poser.pugx.org/whichbrowser/parser/v/stable)](https://packagist.org/packages/whichbrowser/parser)

[![Twitter Follow](https://img.shields.io/twitter/follow/whichbrowserlib.svg?style=social)](https://twitter.com/whichbrowserlib)

Also available:

- [WhichBrowser/Parser-JavaScript](https://github.com/WhichBrowser/Parser-JavaScript)<br>
  A JavaScript version of WhichBrowser for use with Node.js on the server

- [WhichBrowser/Server](https://github.com/WhichBrowser/Server)<br>
  A server written in PHP that provides a JavaScript API for use in the browser

---


About WhichBrowser
------------------

**But why *almost completely useless* and not completely useless?**
Well, there is always an exception to the rule. There are valid reasons to do browser sniffing: to improve the user experience or to gather intelligence about which browsers are used on your website. My website is html5test.com and I wanted to know which score belongs to which browser. And to do that you need a browser sniffing library.

**Why is it extremely complicated?**  
Because everybody lies. Seriously, there is not a single browser that is completely truthful. Almost all browsers say they are Netscape 5 and almost all WebKit browsers say they are based on Gecko. Even Internet Explorer 11 now no longer claims to be IE at all, but instead an unnamed browser that is like Gecko. And it gets worse. That is why it is complicated.

**What kind of information does it give?**
You get a nice object which has information about the browser, rendering engine, os and device. It gives you names and versions and even device manufacturer and model. And WhichBrowser is pretty tenacious. It gives you info that others don't. For example:

    JUC (Linux; U; 2.3.6; zh-cn; GT-I8150; 480*800) UCWEB8.7.4.225/145/800  
    UC Browser 8.7 on a Samsung Galaxy W running Android 2.3.6

Android is never mentioned

    Mozilla/5.0 (Series40; Nokia501/10.0.2; Profile/MIDP-2.1 Configuration/CLDC-1.1) Gecko/20100401 S40OviBrowser/3.0.0.0.73  
    Nokia Xpress 3.0.0 on a Nokia Asha 501 running Nokia Asha Platform

Despite the useragent header claiming to be a Series40 device, we know it's actually running the Asha Platform and we also know that OviBrowser has been renamed to Nokia Xpress.

    Opera/9.80 (X11; Linux zvav; U; zh) Presto/2.8.119 Version/11.10  
    Opera Mini on a Nokia 5230 running Series60 5.0

The useragent header looks like Opera 11.10 on Linux, but we know it's Opera Mini. We can even figure out the real operating system and device model from other headers.



Requirements
-----------------

WhichBrowser requires with PHP 5.4 or higher and supports PHP 7. WhichBrowser is compatible with the PSR-4 autoloading standard and follows PSR-1 and PSR-2 coding style.


How to install it
-----------------

You can install WhichBrowser by using Composer - the standard package manager for PHP. The package is called `whichbrowser/parser`.

    composer require whichbrowser/parser

You can easily update WhichBrowser by running a simple command.

    composer update whichbrowser/parser

You should run this command as often as possible. You might even want to consider setting up a cron job for this purpose.




How to use it
-------------

The first step require the Composer autoloader:

```php
<?php

    require 'vendor/autoload.php';
```

The second step is to create a new `WhichBrowser\Parser` object. This object will contain all the information the library could find about the browser. The object has a required parameter, either the headers send by the browser, or a useragent string. Using the headers is preferable, because it will allow a better detection, but if you have just the useragent string, this will also work.

For example:

```php
$result = new WhichBrowser\Parser(getallheaders());
```

or:

```php
$result = new WhichBrowser\Parser($_SERVER['HTTP_USER_AGENT']);
```


The variable `$result` now contains an object which you can query for information. There are various ways to access the information.


First of all, you can call to `toString()` function to get a human readable identification:

```php
"You are using " . $result->toString();
// You are using Chrome 27 on OS X Mountain Lion 10.8
```

Another possiblity is to query the object:

```php
$result->isType('desktop');
// true

$result->isType('mobile', 'tablet', 'media', 'gaming:portable');
// false

$result->isBrowser('Maxthon', '<', '4.0.5');
// false

$result->isOs('iOS', '>=', '8');
// false

$result->isOs('OS X');
// true

$result->isEngine('Blink');
// true
```

You can also access these properties directly:

```php
$result->browser->toString();
// Chrome 27  

$result->engine->toString();
// Blink

$result->os->toString();
// OS X Mountain Lion 10.8
```

Or access parts of these properties directly:

```php
$result->browser->name;
// Chrome

$result->browser->name . ' ' . $result->browser->version.toString();
// Chrome 27

$result->browser->version->value;
// 27.0.1453.110

$result->engine->name;
// Blink
```

Finally you can also query versions directly:

```php
$result->browser->version->is('>', 26);
// true

$result->os->version->is('<', '10.7.4');
// false
```

Options
-------

It is possible to set additional options by passing an array as the second parameter when creating the `Parser` object.

### Disabling detection of bots

In some cases you may want to disable the detection of bots. This allows the bot the deliberately fool WhichBrowser, so you can pick up the identity of useragent what the bot tries to mimic. This is especially handy when you want to use WhichBrowser to switch between different variants of your website and want to make sure crawlers see the right variant of the website. For example, a bot that mimics a mobile device will see the mobile variant of you site.

```php
$result = new WhichBrowser\Parser(getallheaders(), [ 'detectBots' => false ]);
```

Enable result caching
---------------------

WhichBrowser supports PSR-6 compatible cache adapters for caching results between requests. Using a cache is especially useful if you use WhichBrowser on every page of your website and a user visits multiple pages. During the first visit the headers will be parsed and the result will be cached. Upon further visits, the cached results will be used, which is much faster than having to parse the headers again and again.

There are adapters available for other types of caches, such as APC, Doctrine, Memcached, MongoDB, Redis and many more. The configuration of these adapters all differ from each other, but once configured, all you have to do is pass it as an option when creating the `Parser` object, or use the `setCache()` function to set it afterwards. WhichBrowser has been tested to work with the adapters provided by [PHP Cache](http://php-cache.readthedocs.org/en/latest/). For a list of other packages that provide adapters see [Packagist](https://packagist.org/providers/psr/cache-implementation).

For example, if you want to enable a memcached based cache you need to install an extra composer package:

    composer require cache/memcached-adapter

And change the call to WhichBrowser/Parser as follows:

```php
$client = new \Memcached();
$client->addServer('localhost', 11211);

$pool = new \Cache\Adapter\Memcached\MemcachedCachePool($client);

$result = new WhichBrowser\Parser(getallheaders(), [ 'cache' => $pool ]);
```

or

```php
$client = new \Memcached();
$client->addServer('localhost', 11211);

$pool = new \Cache\Adapter\Memcached\MemcachedCachePool($client);

$result = new WhichBrowser\Parser();
$result->setCache($pool);
$result->analyse(getallheaders());
```

You can also specify after how many seconds a cached result should be discarded. The default value is 900 seconds or 15 minutes. If you think WhichBrowser uses too much memory for caching, you should lower this value. You can do this by setting the `cacheExpires` option or passing it as a second parameter to the `setCache()` function.


API reference
-------------

### The Parser object

After a new `WhichBrowser\Parser` object is created, it contains a number of properties and functions. All of these properties are guaranteed to be present.

**Properties:**

* `browser`  
  an object that contains information about the browser itself
* `engine`  
  an object that contains information about the rendering engine
* `os`  
  an object that contains information about the operating system
* `device`  
  an object that contains information about the device

**Functions:**

`getType()`  
Returns the `type` and `subtype` property of the `device` object. If a subtype is present it is concatenated to the type and seperated by a semicolor, for example: `mobile:smart` or `gaming:portable`. If the subtype is not applicable, it just return the type, for example: `desktop` or `ereader`.

`isType($type [,$type [,$type [,$type]]])`  
If a single argument is used, the function returns `true` if the argument matches the `type` propery of `device` object. The argument can optionally also provide a subtype by concatenating it to the type and seperating it with a semicolon. It can use multiple arguments in which case the function returns `true` if one of the arguments matches. If none of the arguments matches, it returns `false`

`isMobile()`  
Return `true` if the browser is a mobile device, like a phone, tablet, ereader, camera, portable media player, watch or portable gaming console. Otherwise it returns `false`.

`isBrowser($name [, $comparison, $version])`  
Is used to query the `name` and `version` property of the `browser` object. The funcion can contain a single argument to a simple comparison based on `name`, or three arguments to compare both `name` and `version`. The first argument always contains the name of the browser. The second arguments is a string that can container either `<`, `<=`, `=`, `=>` or `>`. The third is an integer, float or string that contains the version. You can use versions like `10`, `10.7` or `'10.7.4'`. For more information about how version comparisons are performed, please see the `is()` function of the `Version` object.

`isEngine($name [, $comparison, $version])`  
Is used to query the `name` and `version` property of the `engine` object. This function works in exactly the same way as `isBrowser`.

`isOs($name [, $comparison, $version])`  
Is used to query the `name` and `version` property of the `os` object. This function works in exactly the same way as `isBrowser`.

`isDetected()`  
Is there actually some browser detected, for did we fail to detect anything?

`toString()`  
Get a human readable representation of the detected browser, including operating system and device information.


### The browser object

An object of the `WhichBrowser\Model\Browser` class is used for the `browser` property of the main `WhichBrowser\Parser` object and contains a number of properties. If a property is not applicable in this situation it will be null or undefined.

**Properties:**

* `name`  
  a string containing the name of the browser
* `alias`  
  a string containing an alternative name of the browser
* `version`  
  a version object containing information about the version of the browser
* `stock`  
  a boolean, true if the browser is the default browser of the operating system, false otherwise
* `channel`  
  a string containing the distribution channel, ie. 'Nightly' or 'Next'.
* `mode`  
  a string that can contain the operating mode of the browser, ie. 'proxy'.
* `hidden`  
  a boolean that is true if the browser does not have a name and is the default of the operating system.
* `family`  
  an object that contains information about to which family this browser belongs
* `using`  
  an object that contains information about to which kind of webview this browser uses

**Functions:**

`isFamily($name)`  
Does the family of this browser have this name, or does the browser itself have this name.

`isUsing($name)`  
Is the browser using a webview using with the provided name.

`getName()`  
Get the name of the browser

`getVersion()`  
Get the version of the browser

`toString()`  
Get a human readable representation of the detected browser


### The engine object

An object of the `WhichBrowser\Model\Engine` class is used for the `engine` property of the main `WhichBrowser\Parser` object and contains a number of properties. If a property is not applicable in this situation it will be null or undefined.

**Properties:**

* `name`  
  a string containing the name of the rendering engine
* `version`  
  a version object containing information about the version of the rendering engine

**Functions:**

`getName()`  
Get the name of the rendering engine

`getVersion()`  
Get the version of the rendering engine

`toString()`  
Get a human readable representation of the detected rendering engine


### The os object

An object of the `WhichBrowser\Model\Os` class is used for the `os` property of the main `WhichBrowser\Parser` object and contains a number of properties. If a property is not applicable in this situation it will be null or undefined.

**Properties:**

* `name`  
  a string containing the name of the operating system
* `version`  
  a version object containing information about the version of the operating system
* `family`  
  an object that contains information about to which family this operating system belongs

**Functions:**

`isFamily($name)`  
Does the family of this operating system have this name, or does the operating system itself have this name.

`getName()`  
Get the name of the operating system

`getVersion()`  
Get the version of the operating system

`toString()`  
Get a human readable representation of the detected operating system


### The device object

An object of the `WhichBrowser\Model\Device` class is used for the `device` property of the main `WhichBrowser\Parser` object and contains a number of properties. If a property is not applicable in this situation it will be null or undefined.

**Properties:**

* `type`  
  a string containing the type of the browser.
* `subtype`  
  a string containing the subtype of the browser.
* `identified`  
  a boolean that is true if the device has been positively identified.
* `manufacturer`  
  a string containing the manufacturer of the device, ie. 'Apple' or 'Samsung'.
* `model`  
  as string containing the model of the device, ie. 'iPhone' or 'Galaxy S4'.

The `type` property can contain any value from the following list:

* desktop
* mobile
* pda
* dect
* tablet
* gaming
* ereader
* media
* headset
* watch
* emulator
* television
* monitor
* camera
* printer
* signage
* whiteboard
* devboard
* inflight
* appliance
* gps
* car
* pos
* bot
* projector

If the `type` is "mobile", the `subtype` property can contain any value from the following list:

* feature
* smart

If the `type` is "gaming", the `subtype` property can contain any value from the following list:

* console
* portable

**Functions:**

`getManufacturer()`  
Get the name of the manufacturer

`getModel()`  
Get the name of the model

`toString()`  
Get a human readable representation of the detected device


### The family object

An object of the `WhichBrowser\Model\Family` class is used for the `family` property of the `WhichBrowser\Model\Browser` and `WhichBrowser\Model\Os` object and contains a number of properties. If a property is not applicable in this situation it will be null or undefined.

**Properties:**

* `name`  
  a string containing the name of the family
* `version`  
  a version object containing information about the version of the family

**Functions:**

`getName()`  
Get the name of the family

`getVersion()`  
Get the version of the family

`toString()`  
Get a human readable representation of the family


### The using object

An object of the `WhichBrowser\Model\Using` class is used for the `using` property of the `WhichBrowser\Model\Browser` object and contains a number of properties. If a property is not applicable in this situation it will be null or undefined.

**Properties:**

* `name`  
  a string containing the name of the webview
* `version`  
  a version object containing information about the version of the webview

**Functions:**

`getName()`  
Get the name of the webview

`getVersion()`  
Get the version of the webview

`toString()`  
Get a human readable representation of the webview


### The version object

An object of the `WhichBrowser\Model\Version` class is used for the `version` property of the `browser`, `engine` and `os` object and contains a number of properties and functions. If a property is not applicable in this situation it will be null or undefined.

**Properties:**

* `value`  
  a string containing the original version number.
* `alias`  
  a string containing an alias for the version number, ie. 'XP' for Windows '5.1'.
* `nickname`  
  a string containing a nickname for the version number, ie. 'Mojave' for OS X '10.14'.
* `details`  
  an integer containing the number of digits of the version number that should be printed.

**Functions:**

`is($version)` or `is($comparison, $version)`  
Using this function it is easy to compare a version to another version. If you specify only one argument, this function will return if the versions are the same. You can also specify two arguments, in that case the first argument contains the comparison operator, such as `<`, `<=`, `=`, `=>` or `>`. The second argument is the version you want to compare it to. You can use versions like `10`, `10.7` or `'10.7.4'`, but be aware that `10` is not the same as `10.0`. For example if our OS version is `10.7.4`:

```php
$result->os->version->is('10.7.4');
// true

$result->os->version->is('10.7');
// true

$result->os->version->is('10');
// true

$result->os->version->is('10.0');
// false

$result->os->version->is('>', '10');
// false

$result->os->version->is('>', '10.7');
// false

$result->os->version->is('>', '10.7.3');
// true
```
