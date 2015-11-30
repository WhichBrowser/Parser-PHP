WhichBrowser
============

> **Everybody lies**  — House M.D.

This is an extremely complicated and almost completely useless browser sniffing library written in PHP. Useless because you shouldn't use browser sniffing. So stop right now and go read something about feature detecting instead. I'm serious. Go away. You'll thank me later.

**But why *almost completely useless* and not completely useless?**  
Well, there is always an exception to the rule. There is one valid reason to do browser sniffing: to gather intelligence about which browsers are used on your website. My website is html5test.com and I wanted to know which score belongs to which browser. And to do that you need a browser sniffing library.

**Why is it extremely complicated?**  
Because everybody lies. Seriously, there is not a single browser that is completely truthful. Almost all browsers say they are Netscape 5 and almost all WebKit browsers say they are based on Gecko. Even Internet Explorer 11 now no longer claims to be IE at all, but instead an unnamed browser that is like Gecko. And it gets worse. That is why it is complicated.

WhichBrowser consists of two parts: a PHP library that tries to detect which browser is used based on headers and the useragent string. And a server that exposes an API that can be used directly from JavaScript in the browser.



WhichBrowser library for PHP
----------------------------

WhichBrowser consists of a PHP library: [WhichBrowser/Parser](https://github.com/WhichBrowser/Parser). You can install it by using Composer. It is available as the `whichbrowser/parser` package using Composer.

    composer require whichbrowser/parser

For more information about the API and how to install, please see the [WhichBrowser/Parser](https://github.com/WhichBrowser/Parser) project.



WhichBrowser server for Javascript
----------------------------------

There is also a server component that can called from your webpage and queried from Javascript: [WhichBrowser/Server](https://github.com/WhichBrowser/Server). You can install it by using Composer. It is available as the `whichbrowser/server` package using Composer.

    composer create-project whichbrowser/server .

For more information about the API and how to install, please see the [WhichBrowser/Server](https://github.com/WhichBrowser/Server) project.



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
