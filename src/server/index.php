<!doctype html>

<html>
	<head>
		<meta charset="utf-8">
		<title>WhichBrowser</title>

		<script>
			(function(){var p=[],w=window,d=document,e=f=0;p.push('ua='+encodeURIComponent(navigator.userAgent));e|=w.ActiveXObject?1:0;e|=w.opera?2:0;e|=w.chrome?4:0;
			e|='getBoxObjectFor' in d || 'mozInnerScreenX' in w?8:0;e|=('WebKitCSSMatrix' in w||'WebKitPoint' in w||'webkitStorageInfo' in w||'webkitURL' in w)?16:0;
			e|=(e&16&&({}.toString).toString().indexOf("\n")===-1)?32:0;p.push('e='+e);f|='sandbox' in d.createElement('iframe')?1:0;f|='WebSocket' in w?2:0;
			f|=w.Worker?4:0;f|=w.applicationCache?8:0;f|=w.history && history.pushState?16:0;f|=d.documentElement.webkitRequestFullScreen?32:0;f|='FileReader' in w?64:0;
			p.push('f='+f);p.push('r='+Math.random().toString(36).substring(7));p.push('w='+screen.width);p.push('h='+screen.height);var s=d.createElement('script');
			s.src='detect.php?' + p.join('&');d.getElementsByTagName('head')[0].appendChild(s);})();
		</script>

		<style>

			html {
				font-family: "HelveticaNeue-Light", "Helvetica Neue Light", "Helvetica Neue", "Helvetica", "Arial", "Lucida Grande", sans-serif;
				font-size: 1.1em;
				font-weight: 200;
			}

			body {
				background: #d9d9d9;
				text-align: left;
			}

			header {
				width: 70%;
				margin: 50px auto 50px;
				padding: 30px;
			}

			a {
				color: #0092bf;
				text-decoration: none;
			}

			a:hover {
				text-decoration: underline;
			}


			h1 {
				font-weight: 300;
			}


			input,
			textarea {
				font-family: "HelveticaNeue-Light", "Helvetica Neue Light", "Helvetica Neue", "Helvetica", "Arial", "Lucida Grande", sans-serif;
				font-size: 14pt;
				border: none;
				padding: 10px;
			}

			input[type=text] {
				width: 100%;
			}

			textarea {
				width: 100%;
				height: 100px;
				margin: 10px 0;
			}

			input[type=submit] {
				background: #0092bf;
				color: #fff;
				cursor: pointer;
				width: 100px;
				font-size: 13px;
			}

			hr {
				border: none;
				border-top: 1px solid #bbb;
				margin: 40px 0;
			}

			pre {
				text-align: left;
				overflow-x: scroll;
				background: #f6f6f6;
				padding: 20px;
				line-height: 140%;
			}
			
			pre span {
				display: block;
				padding-top: 5px;
				color: #888;
			}
			
			pre hr {
				border: 1px solid #d9d9d9;
				border-bottom: none;
				margin: 20px -20px;
				padding: 0;
			}
			
			#example pre {
				overflow-x: hidden;
			}

		</style>
	</head>

	<body>
		<?php
			
			$working = false;
			$local = false;
			$redirect = false;
			
			if ($_SERVER['HTTP_HOST'] == '127.0.0.1:8080') {
				$working = true;
				$local = true;
			} 
			else {
				$base = preg_replace('/index.php.*/', '', $_SERVER['REQUEST_URI']); 

				$result = file_get_contents(($_SERVER['HTTPS'] ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . $base . 'detect.php');
				if ($result) $working = preg_match('/var WhichBrowser/', $result);

				$result = file_get_contents(($_SERVER['HTTPS'] ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . $base . 'detect.js');
				if ($result) $redirect = preg_match('/var WhichBrowser/', $result);
			}
		?>
		
		<header>
			<h1>WhichBrowser</h1>

<?php if ($working): ?>
			<p>
				Place the following script tag on your site:
			</p>
			
			<pre>&lt;script&gt;
    (function(){var p=[],w=window,d=document,e=f=0;p.push('ua='+encodeURIComponent(navigator.userAgent));e|=w.ActiveXObject?1:0;e|=w.opera?2:0;e|=w.chrome?4:0;
    e|='getBoxObjectFor' in d || 'mozInnerScreenX' in w?8:0;e|=('WebKitCSSMatrix' in w||'WebKitPoint' in w||'webkitStorageInfo' in w||'webkitURL' in w)?16:0;
    e|=(e&16&&({}.toString).toString().indexOf("\n")===-1)?32:0;p.push('e='+e);f|='sandbox' in d.createElement('iframe')?1:0;f|='WebSocket' in w?2:0;
    f|=w.Worker?4:0;f|=w.applicationCache?8:0;f|=w.history && history.pushState?16:0;f|=d.documentElement.webkitRequestFullScreen?32:0;f|='FileReader' in w?64:0;
    p.push('f='+f);p.push('r='+Math.random().toString(36).substring(7));p.push('w='+screen.width);p.push('h='+screen.height);var s=d.createElement('script');
    s.src='//<?php echo $_SERVER['HTTP_HOST'];?><?php echo $local ? '' : '/whichbrowser'; ?>/detect.<?php echo $redirect ? 'js' : 'php'; ?>?' + p.join('&');d.getElementsByTagName('head')[0].appendChild(s);})();
&lt;/script&gt;</pre>
			
			<p>
				After the script has been loaded, you need to create a new WhichBrowser object, which you can query for details about the browser that is currently being used:
			</p>
			
			<div id='example'></pre>

			<script>
	
				function waitForWhichBrowser(cb) {
					var callback = cb;
					
					function wait() {
						if (typeof WhichBrowser == 'undefined') 
							window.setTimeout(wait, 100)
						else 
							callback();
					}
					
					wait();
				}
	
				waitForWhichBrowser(function() {
					try {
						result = new WhichBrowser({
							useFeatures:		true,
							detectCamouflage:	true
						});
					
						var o = document.getElementById('example');
						o.innerHTML = 	"<pre>result = new WhichBrowser();" +
										"<hr>" +
									  	"\"You are using \" + result\n<span>// You are using " + result + "</span>" +
									  	"<hr>" +
									  	"JSON.stringify(result)\n<span>// " + JSON.stringify(result) + "</span>" +
									  	"<hr>" +
									  	"result.isType('desktop')\n<span>// " + result.isType('desktop') + "</span>\n" +
										"result.isType('mobile', 'tablet', 'media')\n<span>// " + result.isType('mobile', 'tablet', 'media') + "</span>\n" +
										"result.isBrowser('Chrome', '>', '28')\n<span>// " + result.isBrowser('Chrome', '>', '28') + "</span>\n" +
										"result.isEngine('Gecko')\n<span>// " + result.isEngine('Gecko') + "</span>" +
									  	"<hr>" +
									  	"result.browser\n<span>// " + result.browser + "</span>\n" +
										"result.engine\n<span>// " + result.engine + "</span>\n" +
										"result.os\n<span>// " + result.os + "</span>" +
									  	"<hr>" +
									  	"result.browser.name\n<span>// " + result.browser.name + "</span>\n" +
										"result.browser.name + ' ' + String(result.browser.version)\n<span>// " + (result.browser.name + ' ' + String(result.browser.version)) + "</span>\n" +
										"result.browser.version.major\n<span>// " + result.browser.version.major + "</span>\n" +
										"result.browser.version.minor\n<span>// " + result.browser.version.minor + "</span>\n" +
										"result.browser.version.original\n<span>// " + result.browser.version.original + "</span>" +
									  	"<hr>" +
									  	"result.browser.name == 'Chrome' && result.browser.version.is('>', 28)\n<span>// " + (result.browser.name == 'Chrome' && result.browser.version.is('>', 28)) + "</span>\n" +
										"result.os.name == 'OS X' && result.os.version.is('>', '10.7.4')\n<span>// " + (result.os.name == 'OS X' && result.os.version.is('>', '10.7.4')) + "</span>" +
										"</pre>";
					} catch (e) {
					}
				});
				
			</script>

<?php else: ?>

			<p>Unfortunately WhichBrowser does not appear to be installed properly</p>

<?php endif; ?>
		</header>
	</body>
</html>
