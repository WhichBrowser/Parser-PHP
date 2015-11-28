<!doctype html>

<html>
	<head>
		<meta charset="utf-8">
		<title>Which browser?</title>

		<style>

			html {
				font-family: "HelveticaNeue-Light", "Helvetica Neue Light", "Helvetica Neue", "Helvetica", "Arial", "Lucida Grande", sans-serif;
				font-size: 1.1em;
			}

			body {
				background: #d9d9d9;
				text-align: left;
			}

			header {
				width: 70%;
				margin: 100px auto 50px;
				padding: 30px;
			}

			a {
				color: #0092bf;
				text-decoration: none;
			}

			a:hover {
				text-decoration: underline;
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

			h2 {
				font-size: 2.2em;
				font-weight: normal;
			}

			pre {
				text-align: left;
			}


		</style>
	</head>

	<body>
		<header>
			<form action='' method='post'>
				<div>
					<input type='text' name='useragent' placeholder='UA string' value='<?php echo isset($_REQUEST['useragent']) ? $_REQUEST['useragent'] : ''; ?>'>
				</div>
				<div>
					<textarea name='headers' placeholder='Headers'><?php echo isset($_REQUEST['headers']) ? $_REQUEST['headers'] : ''; ?></textarea>
				</div>

				<input type='submit' value='Detect'>

			</form>

			<?php if($_SERVER['REQUEST_METHOD'] == 'POST'): ?>
			<hr>
			<div>
				<?php

					error_reporting(E_ALL);
					ini_set('display_errors', true);

					include('../src/parser/src/Parser.php');

					$headers = array();
					if (isset($_REQUEST['useragent']) && $_REQUEST['useragent'] != '') $headers['User-Agent'] = $_REQUEST['useragent'];
					if (isset($_REQUEST['headers']) && $_REQUEST['headers'] != '') {

						$h = explode("\n", $_REQUEST['headers']);
						for ($i = 0; $i < count($h); $i++) {
							@list($k, $v) = explode(':', $h[$i], 2);
							if ($k != '' && $v != '') {
								$headers[$k] = trim($v);
							}
						}
					}

					if (count($headers)) {
						$detected = new WhichBrowser\Parser($headers);

						echo "<h2>" . $detected->toString() ."</h2>\n\n";
						echo "<pre>" . htmlentities($detected->toJavaScript()) . "</pre>";
					}

				?>
			</div>
			<?php endif; ?>
		</header>

	</body>
</html>
