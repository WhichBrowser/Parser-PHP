<?php

	namespace WhichBrowser\Analyser\Header\Useragent\Device;

	use WhichBrowser\Constants;
	use WhichBrowser\Data;
	use WhichBrowser\Family;
	use WhichBrowser\Using;
	use WhichBrowser\Version;

	trait Television {


		private function detectTelevisionFromUseragent($ua) {

			/* Detect the type based on some common markers */
			$this->detectGenericTelevisionFromUseragent($ua);

			/* Try to parse some generic methods to store device information */
			$this->detectGenericTelevisionModelsFromUseragent($ua);
			$this->detectGenericInettvBrowserFromUseragent($ua);
			$this->detectGenericHbbTVFromUseragent($ua);

			/* Look for specific manufacturers and models */
			$this->detectPanasonicTelevisionFromUseragent($ua);
			$this->detectSharpTelevisionFromUseragent($ua);
			$this->detectSamsungTelevisionFromUseragent($ua);
			$this->detectSonyTelevisionFromUseragent($ua);
			$this->detectPhilipsTelevisionFromUseragent($ua);
			$this->detectLgTelevisionFromUseragent($ua);
			$this->detectToshibaTelevisionFromUseragent($ua);

			/* Try to detect set top boxes from various manufacturers */
			$this->detectSettopboxesFromUseragent($ua);

			/* Improve model names */
			$this->improveModelsOnDeviceTypeTelevision($ua);
		}





		/* Generic markers */

		private function detectGenericTelevisionFromUseragent($ua) {
			if (preg_match('/SmartTvA\//u', $ua)) {
				$this->device->type = Constants\DeviceType::TELEVISION;
			}

			if (preg_match('/NETRANGEMMH/u', $ua)) {
				$this->device->type = Constants\DeviceType::TELEVISION;
			}
		}


		/* Toshiba */

		private function detectToshibaTelevisionFromUseragent($ua) {
			if (preg_match('/Toshiba_?TP\//u', $ua) || preg_match('/TSBNetTV\//u', $ua)) {
				$this->device->manufacturer = 'Toshiba';
				$this->device->series = 'Smart TV';
				$this->device->type = Constants\DeviceType::TELEVISION;
				$this->device->identified |= Constants\Id::MATCH_UA;
			}

			if (preg_match('/TOSHIBA;[^;]+;([A-Z]+[0-9]+[A-Z]+);/u', $ua, $match)) {
				$this->device->manufacturer = 'Toshiba';
				$this->device->model = $match[1];
				$this->device->series = 'Smart TV';
				$this->device->type = Constants\DeviceType::TELEVISION;
				$this->device->identified |= Constants\Id::MATCH_UA;
			}
		}


		/* LG */

		private function detectLgTelevisionFromUseragent($ua) {
			if (preg_match('/LGSmartTV/u', $ua)) {
				$this->device->manufacturer = 'LG';
				$this->device->series = 'Smart TV';
				$this->device->type = Constants\DeviceType::TELEVISION;
				$this->device->identified |= Constants\Id::MATCH_UA;
			}

			if (preg_match('/UPLUSTVBROWSER/u', $ua)) {
				$this->device->manufacturer = 'LG';
				$this->device->series = 'U+ tv';
				$this->device->type = Constants\DeviceType::TELEVISION;
				$this->device->identified |= Constants\Id::MATCH_UA;
			}


			/* NetCast */

			if (preg_match('/LG NetCast\.(TV|Media)-([0-9]*)/u', $ua, $match)) {
				$this->device->manufacturer = 'LG';
				$this->device->series = 'NetCast ' . $match[1] . ' ' . $match[2];
				$this->device->type = Constants\DeviceType::TELEVISION;
				$this->device->identified |= Constants\Id::MATCH_UA;

				if (preg_match('/LG Browser\/[0-9.]+\([^;]+; LGE; ([^;]+);/u', $ua, $match)) {
					if (substr($match[1], 0, 6) != 'GLOBAL') {
						$this->device->model = $match[1];
					}
				}
			}

			/* NetCast */

			if ($ua == "Mozilla/5.0 (X11; Linux; ko-KR) AppleWebKit/534.26+ (KHTML, like Gecko) Version/5.0 Safari/534.26+" ||
				$ua == "Mozilla/5.0 (DirectFB; Linux; ko-KR) AppleWebKit/534.26+ (KHTML, like Gecko) Version/5.0 Safari/534.26+") 
			{
				$this->device->manufacturer = 'LG';
				$this->device->series = 'NetCast TV 2012';
				$this->device->type = Constants\DeviceType::TELEVISION;
				$this->device->identified |= Constants\Id::MATCH_UA;
			}


			/* NetCast or WebOS */

			if (preg_match('/NetCast/u', $ua) && preg_match('/SmartTV\/([0-9])/u', $ua, $match)) {
				$this->device->manufacturer = 'LG';
				$this->device->type = Constants\DeviceType::TELEVISION;
				$this->device->identified |= Constants\Id::MATCH_UA;

				if (intval($match[1]) < 5) {
					$this->device->series = 'NetCast TV';
				} 
				else {
					$this->device->series = 'webOS TV';
				}
			}

			/* WebOS */

			if (preg_match('/Web[O0]S/u', $ua) && preg_match('/Large Screen/u', $ua)) {
				$this->device->manufacturer = 'LG';
				$this->device->series = 'webOS TV';
				$this->device->type = Constants\DeviceType::TELEVISION;
				$this->device->identified |= Constants\Id::MATCH_UA;
			}

			if (preg_match('/webOS\.TV-([0-9]+)/u', $ua, $match)) {
				$this->device->manufacturer = 'LG';
				$this->device->series = 'webOS TV'; // . $match[1];
				$this->device->type = Constants\DeviceType::TELEVISION;
				$this->device->identified |= Constants\Id::MATCH_UA;

				if (preg_match('/LG Browser\/[0-9.]+\(LGE; ([^;]+);/u', $ua, $match)) {
					if (strtoupper(substr($match[1], 0, 5)) != 'WEBOS') {
						$this->device->model = $match[1];
					}
				}
			}
		}


		/* Philips */

		private function detectPhilipsTelevisionFromUseragent($ua) {
			if (preg_match('/NETTV\//u', $ua)) {
				$this->device->manufacturer = 'Philips';
				$this->device->series = 'Net TV';
				$this->device->type = Constants\DeviceType::TELEVISION;
				$this->device->identified |= Constants\Id::MATCH_UA;

				if (preg_match('/AquosTV/u', $ua)) {
					$this->device->manufacturer = 'Sharp';
					$this->device->series = 'Aquos TV';
				}

				if (preg_match('/BANGOLUFSEN/u', $ua)) {
					$this->device->manufacturer = 'Bang & Olufsen';
					$this->device->series = 'Smart TV';
				}

				if (preg_match('/PHILIPS-AVM/u', $ua)) {
					$this->device->series = 'Blu-ray Player';
				}
			}
		}


		/* Sony */

		private function detectSonyTelevisionFromUseragent($ua) {
			if (preg_match('/SonyCEBrowser/u', $ua)) {
				$this->device->manufacturer = 'Sony';
				$this->device->series = 'Smart TV';
				$this->device->type = Constants\DeviceType::TELEVISION;
				$this->device->identified |= Constants\Id::MATCH_UA;

				if (preg_match('/SonyCEBrowser\/[0-9.]+ \((?:BDPlayer; |DTV[0-9]+\/)?([^;_]+)/u', $ua, $match)) {
					if ($match[1] != 'ModelName') {
						$this->device->model = $match[1];
					}
				}
			}

			if (preg_match('/SonyDTV/u', $ua)) {
				$this->device->manufacturer = 'Sony';
				$this->device->series = 'Smart TV';
				$this->device->type = Constants\DeviceType::TELEVISION;
				$this->device->identified |= Constants\Id::MATCH_UA;

				if (preg_match('/(KDL-?[0-9]+[A-Z]+[0-9]+)/u', $ua, $match)) {
					$this->device->model = $match[1];
					$this->device->generic = false;
				}

				if (preg_match('/(XBR-?[0-9]+[A-Z]+[0-9]+)/u', $ua, $match)) {
					$this->device->model = $match[1];
					$this->device->generic = false;
				}
			}

			if (preg_match('/SonyBDP/u', $ua)) {
				$this->device->manufacturer = 'Sony';
				$this->device->series = "Blu-ray Player";
				$this->device->type = Constants\DeviceType::TELEVISION;
				$this->device->identified |= Constants\Id::MATCH_UA;
			}

			if (preg_match('/SmartBD/u', $ua) && preg_match('/(BDP-[A-Z][0-9]+)/u', $ua, $match)) {
				$this->device->manufacturer = 'Sony';
				$this->device->model = $match[1];
				$this->device->series = 'Blu-ray Player';
				$this->device->type = Constants\DeviceType::TELEVISION;
				$this->device->identified |= Constants\Id::MATCH_UA;
			}

			if (preg_match('/\s+([0-9]+)BRAVIA/u', $ua, $match)) {
				$this->device->manufacturer = 'Sony';
				$this->device->model = 'Bravia';
				$this->device->series = 'Smart TV';
				$this->device->type = Constants\DeviceType::TELEVISION;
				$this->device->identified |= Constants\Id::MATCH_UA;
			}
		}


		/* Samsung */

		private function detectSamsungTelevisionFromUseragent($ua) {
			if (preg_match('/SMART-TV/u', $ua)) {
				$this->device->manufacturer = 'Samsung';
				$this->device->series = 'Smart TV';
				$this->device->type = Constants\DeviceType::TELEVISION;
				$this->device->identified |= Constants\Id::MATCH_UA;

				if (preg_match('/Linux\/SmartTV\+([0-9]*)/u', $ua, $match)) {
					$this->device->series = 'Smart TV ' . $match[1];
				}

				elseif (preg_match('/Maple([0-9]*)/u', $ua, $match)) {
					$this->device->series = 'Smart TV ' . $match[1];
				}
			}

			if (preg_match('/Maple_([0-9][0-9][0-9][0-9])/u', $ua, $match)) {
				$this->device->manufacturer = 'Samsung';
				$this->device->series = 'Smart TV ' . $match[1];
				$this->device->type = Constants\DeviceType::TELEVISION;
				$this->device->identified |= Constants\Id::MATCH_UA;
			}

			if (preg_match('/Maple ([0-9]+\.[0-9]+)\.[0-9]+/u', $ua, $match)) {
				$this->device->manufacturer = 'Samsung';
				$this->device->series = 'Smart TV';
				$this->device->type = Constants\DeviceType::TELEVISION;
				$this->device->identified |= Constants\Id::MATCH_UA;

				switch ($match[1]) {
					case '5.0':		$this->device->series = 'Smart TV 2009'; break;
					case '5.1':		$this->device->series = 'Smart TV 2010'; break;
					case '6.0':		$this->device->series = 'Smart TV 2011'; break;
				}
			}

			if (preg_match('/Model\/Samsung-(BD-[A-Z][0-9]+)/u', $ua, $match)) {
				$this->device->manufacturer = 'Samsung';
				$this->device->model = $match[1];
				$this->device->series = 'Blu-ray Player';
				$this->device->type = Constants\DeviceType::TELEVISION;
				$this->device->identified |= Constants\Id::MATCH_UA;
			}
		}


		/* Sharp */

		private function detectSharpTelevisionFromUseragent($ua) {
			if (preg_match('/AQUOSBrowser/u', $ua) || preg_match('/AQUOS-(AS|DMP)/u', $ua)) {
				$this->device->manufacturer = 'Sharp';
				$this->device->series = 'Aquos TV';
				$this->device->type = Constants\DeviceType::TELEVISION;
				$this->device->identified |= Constants\Id::MATCH_UA;

				if (preg_match('/LC\-([0-9]+[A-Z]+[0-9]+[A-Z]+)/u', $ua, $match)) {
					$this->device->model = $match[1];
					$this->device->generic = false;
				}
			}
		}


		/* Panasonic */

		private function detectPanasonicTelevisionFromUseragent($ua) {
			if (preg_match('/Viera/u', $ua)) {
				$this->device->manufacturer = 'Panasonic';
				$this->device->series = 'Viera';
				$this->device->type = Constants\DeviceType::TELEVISION;
				$this->device->identified |= Constants\Id::MATCH_UA;

				if (preg_match('/Panasonic\.tv\.([0-9]+)/u', $ua, $match)) {
					$this->device->series = 'Viera ' . $match[1];
				}

				if (preg_match('/\(Panasonic, ([0-9]+),/u', $ua, $match)) {
					$this->device->series = 'Viera ' . $match[1];
				}

				if (preg_match('/Viera\; rv\:34/u', $ua, $match)) {
					$this->device->series = 'Viera 2015';
				}
			}

			if (preg_match('/; Diga;/u', $ua)) {
				$this->device->manufacturer = 'Panasonic';
				$this->device->series = 'Diga';
				$this->device->type = Constants\DeviceType::TELEVISION;
				$this->device->identified |= Constants\Id::MATCH_UA;
			}
		}


		/* Various set top boxes */

		private function detectSettopboxesFromUseragent($ua) {

			/* Loewe */

			if (preg_match('/LOEWE\/TV/u', $ua)) {
				$this->device->manufacturer = 'Loewe';
				$this->device->series = 'Smart TV';
				$this->device->type = Constants\DeviceType::TELEVISION;
				$this->device->identified |= Constants\Id::MATCH_UA;

				if (preg_match('/((?:SL|ID)[0-9]+)/u', $ua, $match)) {
					$this->device->model = $match[1];
				}
			}

			/* KreaTV */

			if (preg_match('/KreaTV/u', $ua)) {
				unset($this->os->name);
				unset($this->os->version);

				$this->device->series = 'KreaTV';
				$this->device->type = Constants\DeviceType::TELEVISION;
				$this->device->identified |= Constants\Id::MATCH_UA;
				$this->device->generic = false;

				if (preg_match('/Motorola/u', $ua)) {
					$this->device->manufacturer = 'Motorola';
				}
			}

			/* ADB */

			if (preg_match('/\(ADB; ([^\)]+)\)/u', $ua, $match)) {
				unset($this->os->name);
				unset($this->os->version);

				$this->device->manufacturer = 'ADB';
				$this->device->model = ($match[1] != 'Unknown' ? str_replace('ADB', '', $match[1]) . ' ' : '') . 'IPTV receiver';
				$this->device->type = Constants\DeviceType::TELEVISION;
				$this->device->identified |= Constants\Id::MATCH_UA;
				$this->device->generic = false;
			}

			/* MStar */

			if (preg_match('/Mstar;OWB/u', $ua)) {
				unset($this->os->name);
				unset($this->os->version);

				$this->device->manufacturer = 'MStar';
				$this->device->model = 'PVR';
				$this->device->type = Constants\DeviceType::TELEVISION;
				$this->device->identified |= Constants\Id::MATCH_UA;

				$this->browser->name = 'Origyn Web Browser';
			}

			/* TechniSat */

			if (preg_match('/TechniSat ([^;]+);/u', $ua, $match)) {
				unset($this->os->name);
				unset($this->os->version);

				$this->device->manufacturer = 'TechniSat';
				$this->device->model = $match[1];
				$this->device->type = Constants\DeviceType::TELEVISION;
				$this->device->identified |= Constants\Id::MATCH_UA;
				$this->device->generic = false;
			}

			/* Technicolor */

			if (preg_match('/Technicolor_([^;]+);/u', $ua, $match)) {
				unset($this->os->name);
				unset($this->os->version);

				$this->device->manufacturer = 'Technicolor';
				$this->device->model = $match[1];
				$this->device->type = Constants\DeviceType::TELEVISION;
				$this->device->identified |= Constants\Id::MATCH_UA;
				$this->device->generic = false;
			}

			/* Winbox Evo2 */

			if (preg_match('/Winbox Evo2/u', $ua)) {
				unset($this->os->name);
				unset($this->os->version);

				$this->device->manufacturer = 'Winbox';
				$this->device->model = 'Evo2';
				$this->device->type = Constants\DeviceType::TELEVISION;
				$this->device->identified |= Constants\Id::MATCH_UA;
				$this->device->generic = false;
			}

			/* DuneHD */

			if (preg_match('/DuneHD\//u', $ua)) {
				unset($this->os->name);
				unset($this->os->version);

				$this->device->manufacturer = 'Dune HD';
				$this->device->model = '';
				$this->device->type = Constants\DeviceType::TELEVISION;
				$this->device->identified |= Constants\Id::MATCH_UA;

				if (preg_match('/DuneHD\/[0-9.]+ \(([^;]+);/u', $ua, $match)) {
					$this->device->model = $match[1];
				}
			}

			/* Roku  */

			if (preg_match('/^Roku\/DVP-([0-9]+)/u', $ua, $match)) {
				unset($this->os->name);
				unset($this->os->version);

				$this->device->manufacturer = 'Roku';
				$this->device->type = Constants\DeviceType::TELEVISION;

				switch ($match[1]) {
					case '2000':	$this->device->model = 'HD'; $this->device->generic = false; break;
					case '2050':	$this->device->model = 'XD'; $this->device->generic = false; break;
					case '2100':	$this->device->model = 'XDS'; $this->device->generic = false; break;
					case '2400':	$this->device->model = 'LT'; $this->device->generic = false; break;
					case '3000':	$this->device->model = '2 HD'; $this->device->generic = false; break;
					case '3050':	$this->device->model = '2 XD'; $this->device->generic = false; break;
					case '3100':	$this->device->model = '2 XS'; $this->device->generic = false; break;
				}

				$this->device->identified |= Constants\Id::MATCH_UA;
			}

			/* AppleTV */

			if (preg_match('/AppleTV[0-9],[0-9]/u', $ua)) {
				unset($this->os->name);
				unset($this->os->version);

				$this->device->manufacturer = 'Apple';
				$this->device->model = 'AppleTV';
				$this->device->type = Constants\DeviceType::TELEVISION;
				$this->device->identified |= Constants\Id::MATCH_UA;
				$this->device->generic = false;
			}

			/* WebTV */

			if (preg_match('/WebTV\/[0-9.]/u', $ua)) {
				unset($this->os->name);
				unset($this->os->version);

				$this->device->manufacturer = 'Microsoft';
				$this->device->model = 'WebTV';
				$this->device->type = Constants\DeviceType::TELEVISION;
				$this->device->identified |= Constants\Id::MATCH_UA;
				$this->device->generic = false;
			}

			/* OpenTV */

			if (preg_match('/OpenTV/u', $ua)) {
				$this->device->series = 'OpenTV';
				$this->device->type = Constants\DeviceType::TELEVISION;
			}

			/* MediStream */

			if (preg_match('/MediStream/u', $ua)) {
				unset($this->os->name);
				unset($this->os->version);

				$this->device->manufacturer = 'Bewatec';
				$this->device->model = 'MediStream';
				$this->device->type = Constants\DeviceType::TELEVISION;
				$this->device->identified |= Constants\Id::MATCH_UA;
				$this->device->generic = false;
			}
		}


		/* Generic model information */

		private function detectGenericTelevisionModelsFromUseragent($ua) {
			if (preg_match('/\(([^,\(]+),\s*([^,\(]+),\s*(?:[Ww]ired|[Ww]ireless)\)/u', $ua, $match)) {
				$vendorName = Data\Manufacturers::identify(Constants\DeviceType::TELEVISION, $match[1]);
				$modelName = trim($match[2]);

				$this->device->type = Constants\DeviceType::TELEVISION;
				$this->device->identified |= Constants\Id::PATTERN;
				if (!isset($this->device->series)) $this->device->series = 'Smart TV';

				switch ($vendorName) {
					case 'ARRIS':			$this->device->manufacturer = 'Arris';
											$this->device->model = $modelName;
											break;

					case 'LG':				$this->device->manufacturer = 'LG';

											switch($modelName) {
												case 'webOS.TV':		$this->device->series = 'webOS TV'; break;
												case 'WEBOS1':			$this->device->series = 'webOS TV'; break;
												case 'GLOBAL-PLAT3':	$this->device->series = 'NetCast TV 2012'; break;
												case 'GLOBAL-PLAT4':	$this->device->series = 'NetCast TV 2013'; break;
												case 'GLOBAL-PLAT5':	$this->device->series = 'NetCast TV 2014'; break;
												default:				$this->device->model = $modelName; break;
											}

											break;

					case 'TiVo':			$this->device->manufacturer = 'TiVo';
											$this->device->series = 'DVR';
											break;

					default:				$this->device->manufacturer = $vendorName;
											$this->device->model = $modelName;
											break;
				}
			}
		}


		/* InettvBrowser model information */

		private function detectGenericInettvBrowserFromUseragent($ua) {
			if (preg_match('/(?:DTVNetBrowser|InettvBrowser|Hybridcast)\/[0-9\.]+[A-Z]? \(/u', $ua, $match)) {
				$this->device->type = Constants\DeviceType::TELEVISION;

				$found = false;

				if (preg_match('/(?:DTVNetBrowser|InettvBrowser)\/[0-9\.]+[A-Z]? \(([^;]*)\s*;\s*([^;]*)\s*;/u', $ua, $match)) {
					$vendorName = trim($match[1]);
					$modelName = trim($match[2]);
					$found = true;
				}

				if (preg_match('/Hybridcast\/[0-9\.]+ \([^;]*;([^;]*)\s*;\s*([^;]*)\s*;/u', $ua, $match)) {
					$vendorName = trim($match[1]);
					$modelName = trim($match[2]);
					$found = true;
				}

				if ($found) {
					$this->device->identified |= Constants\Id::PATTERN;
					if (!isset($this->device->series)) $this->device->series = 'Smart TV';

					switch($vendorName . '#') {
						case '000087#':			$this->device->manufacturer = 'Hitachi';
												break;

						case '00E091#':			$this->device->manufacturer = 'LG';

												switch($modelName) {
													case 'LGE2D2012M':		$this->device->series = 'NetCast TV 2012'; break;
													case 'LGE3D2012M':		$this->device->series = 'NetCast TV 2012'; break;
												}

												break;

						case '38E08E#':			$this->device->manufacturer = 'Mitsubishi';
												break;

						case '008045#':			$this->device->manufacturer = 'Panasonic';
												break;

						case '00E064#':			$this->device->manufacturer = 'Samsung';
												break;

						case '08001F#':			$this->device->manufacturer = 'Sharp';
												break;

						case '00014A#':			$this->device->manufacturer = 'Sony';
												break;

						case '000039#':			$this->device->manufacturer = 'Toshiba';
												break;
					}
				}
			}
		}


		/* HbbTV model information */

		private function detectGenericHbbTVFromUseragent($ua) {
			if (preg_match('/(?:HbbTV|SmartTV)\/[0-9\.]+ \(/iu', $ua, $match)) {
				$this->device->type = Constants\DeviceType::TELEVISION;

				$found = false;

				if (preg_match('/HbbTV\/[0-9\.]+ \(([^;]*);\s*([^;]*)\s*;\s*([^;]*)\s*;/u', $ua, $match)) {
					if (trim($match[1]) == "" || trim($match[1]) == "PVR" || strpos($match[1], '+') !== false) {
						$vendorName = Data\Manufacturers::identify(Constants\DeviceType::TELEVISION, $match[2]);
						$modelName = trim($match[3]);
					} else {
						$vendorName = Data\Manufacturers::identify(Constants\DeviceType::TELEVISION, $match[1]);
						$modelName = trim($match[2]);
					}

					$found = true;
				}

				if (preg_match('/(?:^|\s)SmartTV\/[0-9\.]+ \(([^;]*)\s*;\s*([^;]*)\s*;/u', $ua, $match)) {
					$vendorName = Data\Manufacturers::identify(Constants\DeviceType::TELEVISION, $match[1]);
					$modelName = trim($match[2]);
					$found = true;
				}

				if ($found) {
					$this->device->identified |= Constants\Id::PATTERN;

					switch($vendorName) {
						case 'LG':				$this->device->manufacturer = 'LG';

												switch($modelName) {
													case 'GLOBAL_PLAT3':	$this->device->series = 'NetCast TV 2012'; break;
													case 'GLOBAL_PLAT4':	$this->device->series = 'NetCast TV 2013'; break;
													case 'GLOBAL_PLAT5':	$this->device->series = 'NetCast TV 2014'; break;
													case 'NetCast 2.0':		$this->device->series = 'NetCast TV 2011'; break;
													case 'NetCast 3.0':		$this->device->series = 'NetCast TV 2012'; break;
													case 'NetCast 4.0':		$this->device->series = 'NetCast TV 2013'; break;
													case 'NetCast 4.5':		$this->device->series = 'NetCast TV 2014'; break;
													default:				$this->device->model = $modelName; break;
												}

												break;

						case 'SAMSUNG':	
						case 'Samsung':			$this->device->manufacturer = 'Samsung';

												switch($modelName) {
													case 'SmartTV2012':		$this->device->series = 'Smart TV 2012'; break;
													case 'SmartTV2013':		$this->device->series = 'Smart TV 2013'; break;
													case 'SmartTV2014':		$this->device->series = 'Smart TV 2014'; break;
													case 'OTV-SMT-E5015':	$this->device->model = 'Olleh SkyLife Smart Settopbox'; unset($this->device->series); break;
													default:				$this->device->model = $modelName; break;
												}

												break;

						case 'Panasonic':		$this->device->manufacturer = 'Panasonic';

												switch($modelName) {
													case 'VIERA 2011':		$this->device->series = 'Viera 2011'; break;
													case 'VIERA 2012':		$this->device->series = 'Viera 2012'; break;
													case 'VIERA 2013':		$this->device->series = 'Viera 2013'; break;
													case 'VIERA 2014':		$this->device->series = 'Viera 2014'; break;
													case 'VIERA 2015':		$this->device->series = 'Viera 2015'; break;
													default:				$this->device->model = $modelName; break;
												}

												break;

						case 'TV2N':			$this->device->manufacturer = 'TV2N';

												switch($modelName) {
													case 'videoweb':		$this->device->model = 'Videoweb'; break;
													default:				$this->device->model = $modelName; break;
												}

												break;

						default:				if ($vendorName != '' && $vendorName != 'vendorName') $this->device->manufacturer = $vendorName;
												if ($modelName != '' && $modelName != 'modelName') $this->device->model = $modelName;
												break;
					}

					switch($modelName) {
						case 'hdr1000s':		$this->device->manufacturer = 'Humax';
												$this->device->model = 'HDR-1000S';
												$this->device->identified |= Constants\Id::MATCH_UA;
												$this->device->generic = false;
												break;

						case 'hms1000s':
						case 'hms1000sph2':		$this->device->manufacturer = 'Humax';
												$this->device->model = 'HMS-1000S';
												$this->device->identified |= Constants\Id::MATCH_UA;
												$this->device->generic = false;
												break;
					}
				}
			}

			if (preg_match('/HbbTV\/[0-9.]+;CE-HTML\/[0-9.]+;([^\s;]+)\s[^\s;]+;/u', $ua, $match)) {
				$this->device->manufacturer = Data\Manufacturers::identify(Constants\DeviceType::TELEVISION, $match[1]);
				if (!isset($this->device->series)) $this->device->series = 'Smart TV';
			}

			if (preg_match('/HbbTV\/[0-9.]+;CE-HTML\/[0-9.]+;Vendor\/([^\s;]+);/u', $ua, $match)) {
				$this->device->manufacturer = Data\Manufacturers::identify(Constants\DeviceType::TELEVISION, $match[1]);
				if (!isset($this->device->series)) $this->device->series = 'Smart TV';
			}
		}
	

		/* Try to reformat some of the detected generic models */

		private function improveModelsOnDeviceTypeTelevision() {
			if ($this->device->type != Constants\DeviceType::TELEVISION) return;


			if (isset($this->device->model) && isset($this->device->manufacturer)) {

				if ($this->device->manufacturer == 'Dune HD') {
					if (preg_match('/tv([0-9]+[a-z]?)/u', $this->device->model, $match)) {
						$this->device->model = 'TV-' . strtoupper($match[1]);
					}

					if ($this->device->model == 'connect') {
						$this->device->model = 'Connect';
					}
				}

				if ($this->device->manufacturer == 'Humax') {
					$this->device->series = "Digital Receiver";
				}

				if ($this->device->manufacturer == 'Inverto') {
					if (preg_match('/IDL[ -]?([0-9]+.*)/u', $this->device->model, $match)) {
						$this->device->model = 'IDL ' . $match[1];
					}

					if (preg_match('/MBN([0-9]+)/u', $this->device->model, $match)) {
						$this->device->model = 'MBN ' . $match[1];
					}
				}

				if ($this->device->manufacturer == 'HyperPanel') {
					$this->device->model = strtok(strtoupper($this->device->model), ' ');
				}

				if ($this->device->manufacturer == 'LG') {
					if (preg_match('/(?:ATSC|DVB)-(.*)/u', $this->device->model, $match)) {
						$this->device->model = $match[1];
						$this->device->generic = false;
					}

					if (preg_match('/[0-9][0-9]([A-Z][A-Z][0-9][0-9][0-9][0-9A-Z])/u', $this->device->model, $match)) {
						$this->device->model = $match[1];
						$this->device->generic = false;
					}

					if (preg_match('/Media\/(.*)/u', $this->device->model, $match)) {
						$this->device->model = $match[1];
						$this->device->generic = false;
					}
				}

				if ($this->device->manufacturer == 'Loewe') {
					$this->device->series = 'Smart TV';

					if (preg_match('/((?:ID|SL)[0-9]+)/u', $this->device->model, $match)) {
						$this->device->model = 'Connect '.  $match[1];
						$this->device->generic = false;
					}
				}

				if ($this->device->manufacturer == 'Philips') {
					if (preg_match('/[0-9][0-9]([A-Z][A-Z][A-Z][0-9][0-9][0-9][0-9])/u', $this->device->model, $match)) {
						$this->device->model = $match[1];
						$this->device->generic = false;
					}

					if (preg_match('/(MT[0-9]+)/u', $this->device->model, $match)) {
						$this->device->model = $match[1];
						$this->device->series = "Digital Receiver";
						$this->device->generic = false;
					}

					if (preg_match('/(BDP[0-9]+)/u', $this->device->model, $match)) {
						$this->device->model = $match[1];
						$this->device->series = "Blu-ray Player";
						$this->device->generic = false;
					}
				}

				if ($this->device->manufacturer == 'Toshiba') {
					if (preg_match('/DTV_(.*)/u', $this->device->model, $match)) {
						$this->device->model = 'Regza ' . $match[1];
						$this->device->generic = false;
					}

					if (preg_match('/[0-9][0-9]([A-Z][A-Z][0-9][0-9][0-9])/u', $this->device->model, $match)) {
						$this->device->model = 'Regza ' . $match[1];
						$this->device->generic = false;
					}

					if (preg_match('/[0-9][0-9](ZL[0-9])/u', $this->device->model, $match)) {
						$this->device->model = $match[1] . ' Cevo';
						$this->device->generic = false;
					}

					if (preg_match('/(BDX[0-9]+)/u', $this->device->model, $match)) {
						$this->device->model = $match[1];
						$this->device->series = "Blu-ray Player";
						$this->device->generic = false;
					}
				}

				if ($this->device->manufacturer == 'Selevision') {
					$this->device->model = str_replace('Selevision ', '', $this->device->model);
				}

				if ($this->device->manufacturer == 'Sharp') {
					if (preg_match('/[0-9][0-9]([A-Z]+[0-9]+[A-Z]+)/u', $this->device->model, $match)) {
						$this->device->model = $match[1];
						$this->device->generic = false;
					}
				}

				if ($this->device->manufacturer == 'Sony') {
					if (preg_match('/(BDP[0-9]+G)/u', $this->device->model, $match)) {
						$this->device->model = $match[1];
						$this->device->series = "Blu-ray Player";
						$this->device->generic = false;
					}

					if (preg_match('/KDL?-?[0-9]*([A-Z]+[0-9]+)[A-Z]*/u', $this->device->model, $match)) {
						$this->device->model = 'Bravia ' . $match[1];
						$this->device->series = 'Smart TV';
						$this->device->generic = false;
					}
				}

				if ($this->device->manufacturer == 'Pioneer') {
					if (preg_match('/(BDP-[0-9]+)/u', $this->device->model, $match)) {
						$this->device->model = $match[1];
						$this->device->series = "Blu-ray Player";
						$this->device->generic = false;
					}
				}
			}
		}
	}