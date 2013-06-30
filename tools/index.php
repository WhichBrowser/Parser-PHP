<!doctype html>

<html>
	<head>
		<meta charset="utf-8">
		<title>Useragents</title>
		
		<style>
			body {
				padding: 40px;
			}
		
			input[type=text] {
				width: 100%;
				font-size: 12pt;
			}
			
			textarea {
				margin: 10px 0;
				font-size: 12pt;
				width: 100%;
				height: 100px;
			}
			
			hr {
				margin: 40px -40px;
			}
		
		</style>
	</head>
	
	<body>
		<header>
			<form action='index.php' method='post'>
				<div>
					<input type='text' name='useragent' value='<?php echo isset($_REQUEST['useragent']) ? $_REQUEST['useragent'] : ''; ?>'>
				</div>
				<div>
					<textarea name='headers'><?php echo isset($_REQUEST['headers']) ? $_REQUEST['headers'] : ''; ?></textarea>
				</div>
				
				<input type='submit' value='Detect'>
			
			</form>
			
			<?php if($_SERVER['REQUEST_METHOD'] == 'POST'): ?>
			<hr>
			<div>
				<pre><?php 
				
					include('../useragents.lib.php');
		
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
					
					$detected = new Detected($headers);
										
					echo "{\n";
					if (isset($detected->browser)) echo "\tbrowser: " . htmlentities(json_encode($detected->browser)) . "\n"; 
					if (isset($detected->engine)) echo "\tengine: " . htmlentities(json_encode($detected->engine)) . "\n"; 
					if (isset($detected->os)) echo "\tos: " . htmlentities(json_encode($detected->os)) . "\n"; 
					if (isset($detected->device)) echo "\tdevice: " . htmlentities(json_encode($detected->device)) . "\n"; 
					echo "}";
				
				?></pre>
			</div>
			<?php endif; ?>
		</header>
	
	</body>
</html>