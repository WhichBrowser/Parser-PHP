WhichBrowser/Server
===================

A server for the WhichBrowser/Parser library that exposes an API for use in the browser. 



Requirements
-----------------

The server should be able to handle PHP and included is a `.htaccess` file that instructs the server to use `detect.js` as an alias for `detect.php`. This is not required, but if your server does not support `.htaccess` files you may want to find a way to make your server do the same. Alternatively you could use the `detect.php` directly.



How to install it
-----------------

You can install WhichBrowser by using Composer - the standard package manager for PHP. The package is called `whichbrowser/server`. This sets up all dependancies like the PHP parser library.

    composer require whichbrowser/server

You can easily update WhichBrowser by running a simple command. 

    composer update

You should run this command as often as possible. You might even want to consider setting up a cron job for this purpose.

After installing with Composer you may need to create a symlink to the vendor directory in which WhichBrowser was installed:

    ln -s vendor/whichbrowser/server whichbrowser

Or create a `.htaccess` file in the root of your site and add an `Alias` command:

    Alias /whichbrowser vendor/whichbrowser/server



How to use it
-------------

The first step is to place a snippet of code on you webpage.

    <script>
        (function(){var p=[],w=window,d=document,e=f=0;p.push('ua='+encodeURIComponent(navigator.userAgent));e|=w.ActiveXObject?1:0;e|=w.opera?2:0;e|=w.chrome?4:0;
        e|='getBoxObjectFor' in d || 'mozInnerScreenX' in w?8:0;e|=('WebKitCSSMatrix' in w||'WebKitPoint' in w||'webkitStorageInfo' in w||'webkitURL' in w)?16:0;
        e|=(e&16&&({}.toString).toString().indexOf("\n")===-1)?32:0;p.push('e='+e);f|='sandbox' in d.createElement('iframe')?1:0;f|='WebSocket' in w?2:0;
        f|=w.Worker?4:0;f|=w.applicationCache?8:0;f|=w.history && history.pushState?16:0;f|=d.documentElement.webkitRequestFullScreen?32:0;f|='FileReader' in w?64:0;
        p.push('f='+f);p.push('r='+Math.random().toString(36).substring(7));p.push('w='+screen.width);p.push('h='+screen.height);var s=d.createElement('script');
        s.src='//yourserver/whichbrowser/detect.js?' + p.join('&');d.getElementsByTagName('head')[0].appendChild(s);})();
    </script>

Please make sure you change the URL of the detect.js file to point it to your own server.

To get the exact snippet you need to include visit the directory in which you installed WhichBrowser in your browser.

The second step is to create a new `WhichBrowser` object. This object will contain all the information the library could find about your browser.

For example:

    result = new WhichBrowser();


The variable `result` now contains an object which you can query for information. There are various ways to access the information.


First of all, you can treat the object as a string to get a human readable identification:

    "You are using " + result
    // You are using Chrome 27 on Mac OS X 10.8.4

If you need to, you can also explicitly typecast the object to a string

    String(result)
    result.toString()


Or you can turn the object into JSON:

    JSON.stringify(result)
    // { "browser": {"name":"Chrome","version":{"value":"27"...


Another possiblity is to query the object:

    result.isType('desktop')
    // true

    result.isType('mobile', 'tablet', 'media')  
    // false

    result.isBrowser('Maxthon', '<', '4.0.5')  
    // false

    result.isOs('iOS', '>=', '5')
    // false

    result.isEngine('Blink')
    // true


You can also access these properties directly:

    result.browser
    // Chrome 27  

    result.engine
    // Blink

    result.os
    // Mac OS X 10.8.4


Or access parts of these properties directly:

    result.browser.name
    // Chrome

    result.browser.name + ' ' + String(result.browser.version)
    // Chrome 27

    result.browser.version.major
    // 27

    result.browser.version.minor
    // 0

    result.browser.version.original
    // 27.0.1453.110

    result.engine.name
    // Blink


Finally you can also query versions directly:

    result.browser.version.is('>', 26)
    // true

    result.os.version.is('<', '10.7.4')
    // false


API reference
-------------

### The WhichBrowser object

After a new `WhichBrowser` object is created, it contains a number of properties and functions. All of these properties are guaranteed to be present.

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

`isType(type [,type [,type [,type]]])`  
If a single argument is used, the function returns `true` if the argument matches the `type` propery of `device` obejct. It can use multiple arguments in which case the function returns `true` if one of the arguments matches. If none of the arguments matches, it returns `false`

`isBrowser(name [, comparison, version])`  
Is used to query the `name` and `version` property of the `browser` object. The funcion can contain a single argument to a simple comparison based on `name`, or three arguments to compare both `name` and `version`. The first argument always contains the name of the browser. The second arguments is a string that can container either `<`, `<=`, `=`, `=>` or `>`. The third is an integer, float or string that contains the version. You can use versions like `10`, `10.7` or `'10.7.4'`. For more information about how version comparisons are performed, please see the `is()` function of the `Version` object.

`isEngine(name [, comparison, version])`  
Is used to query the `name` and `version` property of the `engine` object. This function works in exactly the same way as `isBrowser`.

`isOs(name [, comparison, version])`  
Is used to query the `name` and `version` property of the `os` object. This function works in exactly the same way as `isBrowser`.


### The browser object

The `Browser` object is used for the `browser` property of the main `WhichBrowser` object and contains a number of properties. If a property is not applicable in this situation it will be null.

**Properties:**

* `name`  
  a string containing the name of the browser
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


### The engine object

The `Engine` object is used for the `engine` property of the main `WhichBrowser` object and contains a number of properties. If a property is not applicable in this situation it will be null.

**Properties:**

* `name`  
  a string containing the name of the rendering engine
* `version`  
  a version object containing information about the version of the rendering engine


### The os object

The `Os` object is used for the `os` property of the main `WhichBrowser` object and contains a number of properties. If a property is not applicable in this situation it will be null.

**Properties:**

* `name`  
  a string containing the name of the operating system
* `version`  
  a version object containing information about the version of the operating system


### The device object

The `Device` object is used for the `device` property of the main `WhichBrowser` object and contains a number of properties. If a property is not applicable in this situation it will be null.

**Properties:**

* `type`  
  a string containing the type of the browser.
* `identified`  
  a boolean that is true if the device has been positively identified.
* `manufacturer`  
  a string containing the manufacturer of the device, ie. 'Apple' or 'Samsung'.
* `model`  
  as string containing the model of the device, ie. 'iPhone' or 'Galaxy S4'.

The `type` property can contain any value from the following list:

* desktop
* mobile
* tablet
* gaming
* headset
* ereader
* media
* emulator
* television
* monitor
* camera
* signage
* whiteboard
* car
* pos
* bot


### The version object

The `Version` object is used for the `version` property of the `browser`, `engine` and `os` object and contains a number of properties and functions. If a property is not applicable in this situation it will be null.

**Properties:**

* `original`  
  a string containing the original version number.
* `alias`  
  a string containing an alias for the version number, ie. 'XP' for Windows '5.1'.
* `details`  
  an integer containing the number of digits of the version number that should be printed.
* `major`  
  an integer containing the major version number.
* `minor`  
  an integer containing the minor version number.
* `type`  
  a string containing a type indicator, ie. 'beta' or 'alpha'.

**Functions:**

`is(version)` or `is(comparison, version)`  
Using this function it is easy to compare a version to another version. If you specify only one argument, this function will return if the versions are the same. You can also specify two arguments, in that case the first argument contains the comparison operator, such as `<`, `<=`, `=`, `=>` or `>`. The second argument is the version you want to compare it to. You can use versions like `10`, `10.7` or `'10.7.4'`, but be aware that `10` is not the same as `10.0`. For example if our OS version is `10.7.4`:

    result.os.version.is('10.7.4')  
    // true

    result.os.version.is('10.7')  
    // true

    result.os.version.is('10')  
    // true

    result.os.version.is('10.0')
    // false

    result.os.version.is('>', '10')
    // false

    result.os.version.is('>', '10.7')
    // false

    result.os.version.is('>', '10.7.3')
    // true



License
-------

Copyright (c) 2015 Niels Leenheer

Permission is hereby granted, free of charge, to any person obtaining
a copy of this software and associated documentation files (the
"Software"), to deal in the Software without restriction, including
without limitation the rights to use, copy, modify, merge, publish,
distribute, sublicense, and/or sell copies of the Software, and to
permit persons to whom the Software is furnished to do so, subject to
the following conditions:

The above copyright notice and this permission notice shall be
included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION
WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
