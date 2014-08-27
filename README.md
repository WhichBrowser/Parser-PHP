WhichBrowser
============

> **Everybody lies**  — House M.D.

This is an extremely complicated and almost completely useless browser sniffing library. Useless because you shouldn't use browser sniffing. So stop right now and go read something about feature detecting instead. I'm serious. Go away. You'll thank me later.

**But why *almost completely useless* and not completely useless?**  
Well, there is always an exception to the rule. There is one valid reason to do browser sniffing: to gather intelligence about which browsers are used on your website. My website is html5test.com and I wanted to know which score belongs to which browser. And to do that you need a browser sniffing library.

**Why is it extremely complicated?**  
Because everybody lies. Seriously, there is not a single browser that is completely truthful. Almost all browsers say they are Netscape 5 and almost all WebKit browsers say they are based on Gecko. Even Internet Explorer 11 now no longer claims to be IE at all, but instead an unnamed browser that is like Gecko. And it gets worse. That is why it is complicated.

The main part of this library runs on the server and looks at the headers send by the browser, but it also collects various data from the browser itself. The first thing it looks at is the user-agent header, but there are many more headers that contain clues about the identity of the browser. Once the server finds the identity of the browser, it then looks at the data from the browser itself and check some additional characteristics and tries to determine if the headers where perhaps lying. It then gives you the result.

**What kind of information does it give?**
You get a nice JavaScript object which has information about the browser, rendering engine, os and device. It gives you names and versions and even device manufacturer and model. And WhichBrowser is pretty tenacious. It gives you info that others don't. For example:

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

The server should be able to handle PHP and included is a `.htaccess` file that instructs the server to use `detect.js` as an alias for `detect.php`. This is not required, but if your server does not support `.htaccess` files you may want to find a way to make your server do the same. Alternatively you could use the `detect.php` directly.



How to install it
-----------------

Place the files in a directory on your server. The easiest way to install is to download the files as a <a href="https://github.com/WhichBrowser/WhichBrowser/archive/master.zip">zip archive</a> from Github and place
them in a directory called `whichbrowser` on your server. However, this is not ideal for keeping WhichBrowser up-to-date.


###Using Git

It is recommended to use `git` directly on the server to make sure you get the latest changes and to make it easier to keep WhichBrowser updated.

Go to the root directory of your site and run the following command:

    git clone https://github.com/WhichBrowser/WhichBrowser.git whichbrowser

This will create a new directory called `whichbrowser` and install the latest version of WhichBrowser. If you want to update WhichBrowser to the latest version you can simply run the following command from the `whichbrowser` directory:

    git pull

Given that WhichBrowser is updated regularly - sometimes even multiple times a day - you should run this command as often as possible. You might even want to consider setting up a cron job for this purpose.


###Using Composer

As an alternative we also offer a Composer package called `whichbrowser/whichbrowser`.

    php composer.phar require whichbrowser/whichbrowser dev-master

And just like the Git method, you can easily update WhichBrowser by running a simple command.

    php composer.phar update

You should run this command as often as possible. You might even want to consider setting up a cron job for this purpose.

After installing with Composer you may need to create a symlink to the vendor directory in which WhichBrowser was installed:

    ln -s vendor/whichbrowser/whichbrowser whichbrowser

Or create a `.htaccess` file in the root of your site and add an `Alias` command:

    Alias /whichbrowser vendor/whichbrowser/whichbrowser


###Using Bower

Finally we also offer a Bower package called `whichbrowser`.

    bower install whichbrowser

And just like the Git and Composer method, you can easily update WhichBrowser by running a simple command.

    bower update

You should run this command as often as possible. You might even want to consider setting up a cron job for this purpose.

After installing with Bower you may need to create a symlink to the component directory in which WhichBrowser was installed:

    ln -s bower_components/whichbrowser whichbrowser

Or create a `.htaccess` file in the root of your site and add an `Alias` command:

    Alias /whichbrowser bower_components/whichbrowser




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

    Browsers = new WhichBrowser();


The variable `Browsers` now contains an object which you can query for information. There are various ways to access the information.


First of all, you can treat the object as a string to get a human readable identification:

    "You are using " + Browsers
    // You are using Chrome 27 on Mac OS X 10.8.4

If you need to, you can also explicitly typecast the object to a string

    String(Browsers)
    Browsers.toString()


Or you can turn the object into JSON:

    JSON.stringify(Browsers)
    // { "browser": {"name":"Chrome","version":{"value":"27"...


Another possiblity is to query the object:

    Browsers.isType('desktop')
    // true

    Browsers.isType('mobile', 'tablet', 'media')  
    // false

    Browsers.isBrowser('Maxthon', '<', '4.0.5')  
    // false

    Browsers.isOs('iOS', '>=', '5')
    // false

    Browsers.isEngine('Blink')
    // true


You can also access these properties directly:

    Browsers.browser
    // Chrome 27  

    Browsers.engine
    // Blink

    Browsers.os
    // Mac OS X 10.8.4


Or access parts of these properties directly:

    Browsers.browser.name
    // Chrome

    Browsers.browser.name + ' ' + String(Browsers.browser.version)
    // Chrome 27

    Browsers.browser.version.major
    // 27

    Browsers.browser.version.minor
    // 0

    Browsers.browser.version.original
    // 27.0.1453.110

    Browsers.engine.name
    // Blink


Finally you can also query versions directly:

    Browsers.browser.version.is('>', 26)
    // true

    Browsers.os.version.is('<', '10.7.4')
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

    Browser.os.version.is('10.7.4')  
    // true

    Browser.os.version.is('10.7')  
    // true

    Browser.os.version.is('10')  
    // true

    Browser.os.version.is('10.0')
    // false

    Browser.os.version.is('>', '10')
    // false

    Browser.os.version.is('>', '10.7')
    // false

    Browser.os.version.is('>', '10.7.3')
    // true



License
-------

Copyright (c) 2014 Niels Leenheer

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
