WhichBrowser
============

> **Everybody lies**  — House M.D.

This is a extremely complicated and almost completely useless browser sniffing library. Useless because you shouldn't use browser sniffing. So stop right now and go read something about feature detecting instead. I'm serious. Go away. You'll thank me later.

**But why *almost completely useless* and not completely useless?**  
Well, there is always an exception to the rule. There is one valid reason to do browser sniffing: to gather intelligence about which browsers are used on your website. My website is html5test.com and I wanted to know which score belongs to which browser. And to do that you need a browser sniffing library.

**Why is it extremely complicated?**  
Because everybody lies. Seriously, there is not a single browser that is completely truthful. Almost all browser say they are Netscape 5 and almost all WebKit browser say they are based on Gecko. Even Internet Explorer 11 now no longer claims to be IE at all, but instead an unnamed browser that is like Gecko. And it gets worse. That is why it is complicated.

The main part of this library runs on the server and looks at the headers send by browser. The first thing it looks at is the user-agent header, but there are many more headers that contain clues about the identity of the browser. Once the server finds the identity of the browser, it hands over the results to the browser itself. The browser then check some additional characteristics and tries to determine if the headers where perhaps lying. It then gives you the result.


How to install it
-----------------

Place the files in a directory on your server. The server should be able to handle PHP and included is a `.htaccess` file that instructs the server to also use PHP to parse the `detect.js` file. This is required and if your server does not support `.htaccess` files you need to find a way to make your browser do the same.

Then load the `detect.js` file on your webpage.


How to use it
-------------

The first step is to create a new `WhichBrowser` object. This object will contain all the information the library could find about your browser.

    new WhichBrowser({ [options] });
  
The options you can use are:

* `detectCamouflage` - should be try to find out if the browser lies about it's identity?
* `useFeatures` - if so, should be use feature detection to do so? 

For example:

    Browsers = new WhichBrowser({ detectCamouflage: true, useFeatures: true });


The variable `Browsers` now contains an object which you can query for information. There are various ways to access the information.


First of all, you can treat the object as a string to get a human readable identification:

    "You are using " + Browsers
    // You are using Chrome 27 on Mac OS X 10.8.4
    
If you need to, you can also explicitly typecast the object to a string

    String(Browsers)
    ('' + Browsers)
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

    Browsers.browser.name
    // Chrome
    
    Browsers.browser.name + ' ' + Browsers.browser.version 
    // Chrome 27
    
    Browsers.browser.version.major
    // 27
    
    Browsers.browser.version.minor
    // 0
    
    Browsers.browser.version.original
    // 27.0.1453.110
    
    Browsers.engine.name
    // Blink
    
    
Finally you can also query these properies:

    Browsers.browser.version.isNewer(26)
    // true
    
    Browsers.os.version.isOlder('10.7.4')
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
Is used to query the `name` and `version` property of the `browser` object. The funcion can contain a single argument to a simple comparison based on `name`, or three arguments to compare both `name` and `version`. The first argument always contains the name of the browser. The second arguments is a string that can container either `<`, `<=`, `=`, `=>` or `>`. The third is an integer, float or string that contains the version. You can use versions like `10`, `10.7` or `'10.7.4'`. 

`isEngine(name [, comparison, version])`  
Is used to query the `name` and `version` property of the `engine` object. This function works in exactly the same way as `isBrowser`.

`isOs(name [, comparison, version])`  
Is used to query the `name` and `version` property of the `os` object. This function works in exactly the same way as `isBrowser`.
 

### The browser object

The `browser` object is a child of the main `WhichBrowser` object and contains a number of properties. If a property is not applicable in this situation it will be undefined.

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

The `engine` object is a child of the main `WhichBrowser` object and contains a number of properties. If a property is not applicable in this situation it will be undefined.

**Properties:**

* `name`  
  a string containing the name of the rendering engine
* `version`  
  a version object containing information about the version of the rendering engine


### The os object

The `os` object is a child of the main `WhichBrowser` object and contains a number of properties. If a property is not applicable in this situation it will be undefined.

**Properties:**

* `name`  
  a string containing the name of the operating system
* `version`  
  a version object containing information about the version of the operating system


### The device object

The `device` object is a child of the main `WhichBrowser` object and contains a number of properties. If a property is not applicable in this situation it will be undefined.

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

The `version` object is used for the `version` property of the `browser`, `engine` and `os` object and contains a number of properties and functions. If a property is not applicable in this situation it will be undefined.

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

* `is()`
* `isOlder()`
* `isNewer()`
