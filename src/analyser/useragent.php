<?php

	namespace WhichBrowser\Analyser;

	use WhichBrowser\Constants;
	use WhichBrowser\Data;
	use WhichBrowser\Family;
	use WhichBrowser\Using;
	use WhichBrowser\Version;

	trait Useragent {

		private function analyseUserAgent($ua) {
			$ua = preg_replace("/^(Mozilla\/[0-9]\.[0-9].*)\s+Mozilla\/[0-9]\.[0-9].*$/iu", '$1', $ua);

			/****************************************************
			 *		Unix
			 */

			if (preg_match('/Unix/u', $ua)) {
				$this->os->name = 'Unix';
			}

			/****************************************************
			 *		Digital Unix
			 */

			if (preg_match('/OSF1 /u', $ua)) {
				$this->os->name = 'Digital Unix';

				if (preg_match('/OSF1 V([0-9.]*)/u', $ua, $match)) {
					$this->os->version = new Version([ 'value' => $match[1] ]);
				}

				$this->device->type = Constants\DeviceType::DESKTOP;
			}

			/****************************************************
			 *		FreeBSD
			 */

			if (preg_match('/FreeBSD/u', $ua)) {
				$this->os->name = 'FreeBSD';
			}

			/****************************************************
			 *		OpenBSD
			 */

			if (preg_match('/OpenBSD/u', $ua)) {
				$this->os->name = 'OpenBSD';
			}

			/****************************************************
			 *		NetBSD
			 */

			if (preg_match('/NetBSD/u', $ua)) {
				$this->os->name = 'NetBSD';
			}


			/****************************************************
			 *		Solaris
			 */

			if (preg_match('/SunOS/u', $ua)) {
				$this->os->name = 'Solaris';
				$this->device->type = Constants\DeviceType::DESKTOP;
			}


			/****************************************************
			 *		IRIX
			 */

			if (preg_match('/IRIX/u', $ua)) {
				$this->os->name = 'IRIX';

				if (preg_match('/IRIX ([0-9.]*)/u', $ua, $match)) {
					$this->os->version = new Version([ 'value' => $match[1] ]);
				}

				if (preg_match('/IRIX;?(?:64|32) ([0-9.]*)/u', $ua, $match)) {
					$this->os->version = new Version([ 'value' => $match[1] ]);
				}

				$this->device->type = Constants\DeviceType::DESKTOP;
			}


			/****************************************************
			 *		Syllable
			 */

			if (preg_match('/Syllable/u', $ua)) {
				$this->os->name = 'Syllable';
				$this->device->type = Constants\DeviceType::DESKTOP;
			}


			/****************************************************
			 *		Linux
			 */

			if (preg_match('/Linux/u', $ua)) {
				$this->os->name = 'Linux';

				if (preg_match('/CentOS/u', $ua)) {
					$this->os->name = 'CentOS';
					if (preg_match('/CentOS\/[0-9\.\-]+el([0-9_]+)/u', $ua, $match)) {
						$this->os->version = new Version([ 'value' => str_replace('_', '.', $match[1]) ]);
					}

					$this->device->type = Constants\DeviceType::DESKTOP;
				}

				if (preg_match('/Debian/u', $ua)) {
					$this->os->name = 'Debian';
					$this->device->type = Constants\DeviceType::DESKTOP;
				}

				if (preg_match('/Fedora/u', $ua)) {
					$this->os->name = 'Fedora';
					if (preg_match('/Fedora\/[0-9\.\-]+fc([0-9]+)/u', $ua, $match)) {
						$this->os->version = new Version([ 'value' => str_replace('_', '.', $match[1]) ]);
					}

					$this->device->type = Constants\DeviceType::DESKTOP;
				}

				if (preg_match('/Gentoo/u', $ua)) {
					$this->os->name = 'Gentoo';
					$this->device->type = Constants\DeviceType::DESKTOP;
				}

				if (preg_match('/gNewSense/u', $ua)) {
					$this->os->name = 'gNewSense';
					if (preg_match('/gNewSense\/[^\(]+\(([0-9\.]+)/u', $ua, $match)) {
						$this->os->version = new Version([ 'value' => $match[1] ]);
					}

					$this->device->type = Constants\DeviceType::DESKTOP;
				}

				if (preg_match('/Kubuntu/u', $ua)) {
					$this->os->name = 'Kubuntu';
					$this->device->type = Constants\DeviceType::DESKTOP;
				}

				if (preg_match('/Mandriva Linux/u', $ua)) {
					$this->os->name = 'Mandriva';
					if (preg_match('/Mandriva Linux\/[0-9\.\-]+mdv([0-9]+)/u', $ua, $match)) {
						$this->os->version = new Version([ 'value' => $match[1] ]);
					}

					$this->device->type = Constants\DeviceType::DESKTOP;
				}

				if (preg_match('/Mageia/u', $ua)) {
					$this->os->name = 'Mageia';
					if (preg_match('/Mageia\/[0-9\.\-]+mga([0-9]+)/u', $ua, $match)) {
						$this->os->version = new Version([ 'value' => $match[1] ]);
					}

					$this->device->type = Constants\DeviceType::DESKTOP;
				}

				if (preg_match('/Mandriva/u', $ua)) {
					$this->os->name = 'Mandriva';
					if (preg_match('/Mandriva\/[0-9\.\-]+mdv([0-9]+)/u', $ua, $match)) {
						$this->os->version = new Version([ 'value' => $match[1] ]);
					}

					$this->device->type = Constants\DeviceType::DESKTOP;
				}

				if (preg_match('/Red Hat/u', $ua)) {
					$this->os->name = 'Red Hat';
					if (preg_match('/Red Hat[^\/]*\/[0-9\.\-]+el([0-9_]+)/u', $ua, $match)) {
						$this->os->version = new Version([ 'value' => str_replace('_', '.', $match[1]) ]);
					}

					$this->device->type = Constants\DeviceType::DESKTOP;
				}

				if (preg_match('/Slackware/u', $ua)) {
					$this->os->name = 'Slackware';
					$this->device->type = Constants\DeviceType::DESKTOP;
				}

				if (preg_match('/SUSE/u', $ua)) {
					$this->os->name = 'SUSE';
					$this->device->type = Constants\DeviceType::DESKTOP;
				}

				if (preg_match('/Turbolinux/u', $ua)) {
					$this->os->name = 'Turbolinux';
					$this->device->type = Constants\DeviceType::DESKTOP;
				}

				if (preg_match('/Ubuntu/u', $ua)) {
					$this->os->name = 'Ubuntu';
					if (preg_match('/Ubuntu\/([0-9.]*)/u', $ua, $match)) {
						$this->os->version = new Version([ 'value' => $match[1] ]);
					}

					$this->device->type = Constants\DeviceType::DESKTOP;
				}

				if (preg_match('/Linux\/X2\/R1/u', $ua)) {
					$this->os->name = 'LiMo';
					$this->device->type = Constants\DeviceType::MOBILE;
				}
			}

			else if (preg_match('/\(Ubuntu; (Mobile|Tablet)/u', $ua)) {
				$this->os->name = 'Ubuntu Touch';

				if (preg_match('/\(Ubuntu; Mobile/u', $ua)) $this->device->type = Constants\DeviceType::MOBILE;
				if (preg_match('/\(Ubuntu; Tablet/u', $ua)) $this->device->type = Constants\DeviceType::TABLET;
			}

			else if (preg_match('/\(Ubuntu ([0-9.]+) like Android/u', $ua, $match)) {
				$this->os->name = 'Ubuntu Touch';
				$this->os->version = new Version([ 'value' => $match[1] ]);
				$this->device->type = Constants\DeviceType::MOBILE;
			}



			/****************************************************
			 *		iOS
			 */

			if ((preg_match('/iPhone/u', $ua) && !preg_match('/like iPhone/u', $ua)) || 
				preg_match('/iPad/u', $ua) || preg_match('/iPod/u', $ua)) 
			{
				$this->os->name = 'iOS';
				$this->os->version = new Version([ 'value' => '1.0' ]);

				if (preg_match('/OS (.*) like Mac OS X/u', $ua, $match)) {
					$this->os->version = new Version([ 'value' => str_replace('_', '.', $match[1]) ]);
					if ($this->os->version->is('<', '4')) $this->os->alias = 'iPhone OS';
				}

				if (preg_match('/iPhone Simulator;/u', $ua)) {
					$this->device->type = Constants\DeviceType::EMULATOR;
				}

				else {
					if (preg_match('/(iPad|iPhone( 3GS| 3G| 4S| 4| 5)?|iPod( touch)?)/u', $ua, $match)) {
						$device = Data\DeviceModels::identify('ios', $match[0]);

						if ($device) {
							$this->device = $device;
						}
					}

					if (preg_match('/(iPad|iPhone|iPod)[0-9],[0-9]/u', $ua, $match)) {
						$device = Data\DeviceModels::identify('ios', $match[0]);

						if ($device) {
							$this->device = $device;
						}
					}
				}
			}


			/****************************************************
			 *		OS X
			 */

			else if (preg_match('/Mac OS X/u', $ua) || preg_match('/;os=Mac/u', $ua)) {
				$this->os->name = 'OS X';

				if (preg_match('/Mac OS X (10[0-9\._]*)/u', $ua, $match)) {
					$this->os->version = new Version([ 'value' => str_replace('_', '.', $match[1]), 'details' => 2 ]);
				}

				if (preg_match('/;os=Mac (10[0-9\.]*)/u', $ua, $match)) {
					$this->os->version = new Version([ 'value' => $match[1], 'details' => 2 ]);
				}

				if (!empty($this->os->version)) {
					if ($this->os->version->is('<', '10.7')) $this->os->alias = 'Mac OS X';
					if ($this->os->version->is('10.7')) $this->os->version->nickname = 'Lion';
					if ($this->os->version->is('10.8')) $this->os->version->nickname = 'Mountain Lion';
					if ($this->os->version->is('10.9')) $this->os->version->nickname = 'Mavericks';
					if ($this->os->version->is('10.10')) $this->os->version->nickname = 'Yosemite';
					if ($this->os->version->is('10.11')) $this->os->version->nickname = 'El Capitan';
				}

				$this->device->type = Constants\DeviceType::DESKTOP;
			}


			/****************************************************
			 *		Darwin
			 */

			else if (preg_match('/Darwin\/([0-9]+.[0-9]+)/u', $ua, $match)) {
				$this->os->name = "Darwin";
				$this->os->version = new Version([ 'value' => $match[1], 'details' => 2 ]);
			}


			/****************************************************
			 *		Windows
			 */

			if (preg_match('/Windows/u', $ua) || preg_match('/Win[9MX]/u', $ua)) {
				$this->os->name = 'Windows';
				$this->device->type = Constants\DeviceType::DESKTOP;

				if (preg_match('/Windows NT ([0-9][0-9]?\.[0-9])/u', $ua, $match)) {
					$this->os->version = new Version([ 'value' => $match[1] ]);

					switch($match[1]) {
						case '10.0':
						case '6.4':		if (preg_match('/; ARM;/u', $ua))
											$this->os->version = new Version([ 'value' => $match[1], 'alias' => 'RT 10' ]);
										else
											$this->os->version = new Version([ 'value' => $match[1], 'alias' => '10' ]);
										break;

						case '6.3':		if (preg_match('/; ARM;/u', $ua))
											$this->os->version = new Version([ 'value' => $match[1], 'alias' => 'RT 8.1' ]);
										else
											$this->os->version = new Version([ 'value' => $match[1], 'alias' => '8.1' ]);
										break;

						case '6.2':		if (preg_match('/; ARM;/u', $ua))
											$this->os->version = new Version([ 'value' => $match[1], 'alias' => 'RT' ]);
										else
											$this->os->version = new Version([ 'value' => $match[1], 'alias' => '8' ]);
										break;

						case '6.1':		$this->os->version = new Version([ 'value' => $match[1], 'alias' => '7' ]); break;
						case '6.0':		$this->os->version = new Version([ 'value' => $match[1], 'alias' => 'Vista' ]); break;
						case '5.2':		$this->os->version = new Version([ 'value' => $match[1], 'alias' => 'Server 2003' ]); break;
						case '5.1':		$this->os->version = new Version([ 'value' => $match[1], 'alias' => 'XP' ]); break;
						case '5.0':		$this->os->version = new Version([ 'value' => $match[1], 'alias' => '2000' ]); break;
						default:		$this->os->version = new Version([ 'value' => $match[1], 'alias' => 'NT ' . $match[1] ]); break;
					}
				}

				if (preg_match('/Windows 95/u', $ua) || preg_match('/Win95/u', $ua) || preg_match('/Win 9x 4.00/u', $ua)) {
					$this->os->version = new Version([ 'value' => '4.0', 'alias' => '95' ]);
				}

				if (preg_match('/Windows 98/u', $ua) || preg_match('/Win98/u', $ua) || preg_match('/Win 9x 4.10/u', $ua)) {
					$this->os->version = new Version([ 'value' => '4.1', 'alias' => '98' ]);
				}

				if (preg_match('/Windows ME/u', $ua) || preg_match('/WinME/u', $ua) || preg_match('/Win 9x 4.90/u', $ua)) {
					$this->os->version = new Version([ 'value' => '4.9', 'alias' => 'ME' ]);
				}

				if (preg_match('/Windows XP/u', $ua) || preg_match('/WinXP/u', $ua)) {
					$this->os->version = new Version([ 'value' => '5.1', 'alias' => 'XP' ]);
				}

				if (preg_match('/WPDesktop/u', $ua)) {
					$this->os->name = 'Windows Phone';
					$this->os->version = new Version([ 'value' => '8.0', 'details' => 1 ]);
					$this->device->type = Constants\DeviceType::MOBILE;
					$this->browser->mode = 'desktop';
				}

				if (preg_match('/WP7/u', $ua)) {
					$this->os->name = 'Windows Phone';
					$this->os->version = new Version([ 'value' => '7', 'details' => 1 ]);
					$this->device->type = Constants\DeviceType::MOBILE;
					$this->browser->mode = 'desktop';
				}

				if (preg_match('/Windows CE/u', $ua) || preg_match('/WinCE/u', $ua) || preg_match('/WindowsCE/u', $ua)) {
					if (preg_match('/ IEMobile/u', $ua)) {
						$this->os->name = 'Windows Mobile';

						if (preg_match('/ IEMobile 8/u', $ua)) {
							$this->os->version = new Version([ 'value' => '6.5', 'details' => 2 ]);
						}

						if (preg_match('/ IEMobile 7/u', $ua)) {
							$this->os->version = new Version([ 'value' => '6.1', 'details' => 2 ]);
						}

						if (preg_match('/ IEMobile 6/u', $ua)) {
							$this->os->version = new Version([ 'value' => '6.0', 'details' => 2 ]);
						}
					}
					else {
						$this->os->name = 'Windows CE';

						if (preg_match('/WindowsCEOS\/([0-9.]*)/u', $ua, $match)) {
							$this->os->version = new Version([ 'value' => $match[1], 'details' => 2 ]);
						}

						if (preg_match('/Windows CE ([0-9.]*)/u', $ua, $match)) {
							$this->os->version = new Version([ 'value' => $match[1], 'details' => 2 ]);
						}
					}

					$this->device->type = Constants\DeviceType::MOBILE;
				}

				if (preg_match('/Windows ?Mobile/u', $ua)) {
					$this->os->name = 'Windows Mobile';
					$this->device->type = Constants\DeviceType::MOBILE;
				}

				if (preg_match('/WindowsMobile\/([0-9.]*)/u', $ua, $match)) {
					$this->os->name = 'Windows Mobile';
					$this->os->version = new Version([ 'value' => $match[1], 'details' => 2 ]);
					$this->device->type = Constants\DeviceType::MOBILE;
				}

				if (preg_match('/Windows Phone/u', $ua) || preg_match('/WPDesktop/u', $ua)) {
					$this->os->name = 'Windows Phone';
					$this->device->type = Constants\DeviceType::MOBILE;

					if (preg_match('/Windows Phone (?:OS )?([0-9.]*)/u', $ua, $match)) {
						$this->os->version = new Version([ 'value' => $match[1], 'details' => 2 ]);

						if (intval($match[1]) < 7) {
							$this->os->name = 'Windows Mobile';
						}
					}

					/* Windows Phone OS 7 and 8 */
					if (preg_match('/IEMobile\/[^;]+;(?: ARM; Touch; )?(?: WpsLondonTest; )?\s*([^;\s][^;]*);\s*([^;\)\s][^;\)]*)[;|\)]/u', $ua, $match)) {
						$this->device->manufacturer = $match[1];
						$this->device->model = $match[2];
						$this->device->identified |= Constants\Id::PATTERN;

						$device = Data\DeviceModels::identify('wp', $match[2]);
						if ($device->identified) {
							$device->identified |= $this->device->identified;
							$this->device = $device;
						}
					}

					/* Windows Phone 10 */
					if (preg_match('/Windows Phone 1[0-9]\.[0-9]; Android [0-9\.]+; ([^;\s][^;]*);\s*([^;\)\s][^;\)]*)[;|\)]/u', $ua, $match)) {
						$this->device->manufacturer = $match[1];
						$this->device->model = $match[2];
						$this->device->identified |= Constants\Id::PATTERN;

						$device = Data\DeviceModels::identify('wp', $match[2]);
						if ($device->identified) {
							$device->identified |= $this->device->identified;
							$this->device = $device;
						}
					}

					/* Third party browsers */
					if (preg_match('/IEMobile\/[^;]+;(?: ARM; Touch; )?\s*(?:[^\/]+\/[^\/]+);\s*([^;\s][^;]*);\s*([^;\)\s][^;\)]*)[;|\)]/u', $ua, $match)) {
						$this->device->manufacturer = $match[1];
						$this->device->model = $match[2];
						$this->device->identified |= Constants\Id::PATTERN;

						$device = Data\DeviceModels::identify('wp', $match[2]);
						if ($device->identified) {
							$device->identified |= $this->device->identified;
							$this->device = $device;
						}
					}

					/* Desktop mode of WP 8.1 */
					if (preg_match('/WPDesktop;\s*([^;\)]*)(?:;\s*([^;\)]*))?(?:;\s*([^;\)]*))?\) like Gecko/u', $ua, $match)) {
						$this->os->version = new Version([ 'value' => '8.1', 'details' => 2 ]);

						if (preg_match("/^[A-Z]+$/", $match[1])) {
							$this->device->manufacturer = $match[1];
							$this->device->model = $match[2];
						} else {
							$this->device->model = $match[1];
						}

						$this->device->identified |= Constants\Id::PATTERN;

						$device = Data\DeviceModels::identify('wp', $this->device->model);
						if ($device->identified) {
							$device->identified |= $this->device->identified;
							$this->device = $device;
						}
					}

					/* Desktop mode of WP 8.1 Update (buggy version) */
					if (preg_match('/Touch; WPDesktop;\s*([^;\)]*)(?:;\s*([^;\)]*))?(?:;\s*([^;\)]*))?\)/u', $ua, $match)) {
						$this->os->version = new Version([ 'value' => '8.1', 'details' => 2 ]);

						if (preg_match("/^[A-Z]+$/", $match[1]) && isset($match[2])) {
							$this->device->manufacturer = $match[1];
							$this->device->model = $match[2];
						} else {
							$this->device->model = $match[1];
						}

						$this->device->identified |= Constants\Id::PATTERN;

						$device = Data\DeviceModels::identify('wp', $this->device->model);
						if ($device->identified) {
							$device->identified |= $this->device->identified;
							$this->device = $device;
						}
					}

					if (isset($this->device->manufacturer) && isset($this->device->model)) {
						if ($this->device->manufacturer == 'ARM' && $this->device->model == 'Touch') {
							$this->device->manufacturer = null;
							$this->device->model = null;
							$this->device->identified = Constants\Id::NONE;
						}

						if ($this->device->manufacturer == 'Microsoft' && $this->device->model == 'XDeviceEmulator') {
							$this->device->manufacturer = null;
							$this->device->model = null;
							$this->device->type = Constants\DeviceType::EMULATOR;
							$this->device->identified |= Constants\Id::MATCH_UA;
						}
					}
				}
			}



			/****************************************************
			 *		Android
			 */

			if (preg_match('/Android/u', $ua)) {
				$falsepositive = false;

				/* Prevent the Mobile IE 11 Franken-UA from matching Android */
				if (preg_match('/IEMobile\/1/u', $ua)) $falsepositive = true;
				if (preg_match('/Windows Phone 10/u', $ua)) $falsepositive = true;

				/* Prevent from OSes that claim to be 'like' Android from matching */
				if (preg_match('/like Android/u', $ua)) $falsepositive = true;
				if (preg_match('/COS like Android/u', $ua)) $falsepositive = false;

				if (!$falsepositive) {
					$this->os->name = 'Android';
					$this->os->version = new Version();

					if (preg_match('/Android(?: )?(?:AllPhone_|CyanogenMod_|OUYA )?(?:\/)?v?([0-9.]+)/u', str_replace('-update', ',', $ua), $match)) {
						$this->os->version = new Version([ 'value' => $match[1], 'details' => 3 ]);
					}

					if (preg_match('/Android [0-9][0-9].[0-9][0-9].[0-9][0-9]\(([^)]+)\);/u', str_replace('-update', ',', $ua), $match)) {
						$this->os->version = new Version([ 'value' => $match[1], 'details' => 3 ]);
					}

					if (preg_match('/Android Eclair/u', $ua)) {
						$this->os->version = new Version([ 'value' => '2.0', 'details' => 3 ]);
					}

					if (preg_match('/Android KeyLimePie/u', $ua)) {
						$this->os->version = new Version([ 'value' => '4.4', 'details' => 3 ]);
					}

					if (preg_match('/Android 5.[01].99/u', $ua)) {
						$this->os->version = new Version([ 'value' => '6', 'details' => 3, 'alias' => 'M' ]);
					}

					$this->device->type = Constants\DeviceType::MOBILE;
					if ($this->os->version->toFloat() >= 3) $this->device->type = Constants\DeviceType::TABLET;
					if ($this->os->version->toFloat() >= 4 && preg_match('/Mobile/u', $ua)) $this->device->type = Constants\DeviceType::MOBILE;


					if (preg_match('/Eclair; (?:[a-zA-Z][a-zA-Z](?:[-_][a-zA-Z][a-zA-Z])?) Build\/([^\/]*)\//u', $ua, $match)) {
						$this->device->model = $match[1];
					}

					else if (preg_match('/; ?([^;]*[^;\s])\s+[Bb]uild/u', $ua, $match)) {
						$this->device->model = $match[1];
					}

					else if (preg_match('/Linux;Android [0-9.]+,([^\)]+)\)/u', $ua, $match)) {
						$this->device->model = $match[1];
					}

					else if (preg_match('/[a-zA-Z][a-zA-Z](?:[-_][a-zA-Z][a-zA-Z])?; ([^;]*[^;\s])\s?;\s+[Bb]uild/u', $ua, $match)) {
						$this->device->model = $match[1];
					}

					else if (preg_match('/\(([^;]+);U;Android\/[^;]+;[0-9]+\*[0-9]+;CTC\/2.0\)/u', $ua, $match)) {
						$this->device->model = $match[1];
					}

					else if (preg_match('/;\s?([^;]+);\s?[0-9]+\*[0-9]+;\s?CTC\/2.0/u', $ua, $match)) {
						$this->device->model = $match[1];
					}

					else if (preg_match('/Android [^;]+; (?:[a-zA-Z][a-zA-Z](?:[-_][a-zA-Z][a-zA-Z])?; )?([^)]+)\)/u', $ua, $match)) {
						if (!preg_match('/[a-zA-Z][a-zA-Z](?:[-_][a-zA-Z][a-zA-Z])?/u', $ua)) {
							$this->device->model = $match[1];
						}
					}

					/* Sometimes we get a model name that starts with Android, in that case it is a mismatch and we should ignore it */
					if (isset($this->device->model) && substr($this->device->model, 0, 7) == 'Android') {
						$this->device->model = null;
					}

					/* Sometimes we get version and API numbers and display size too */
					if (isset($this->device->model) && preg_match('/(.*) - [0-9\.]+ - (?:with Google Apps - )?API [0-9]+ - [0-9]+x[0-9]+/', $this->device->model, $matches)) {
						$this->device->model = $matches[1];
					}

					/* Sometimes we get a model that is actually an old style useragent */
					if (isset($this->device->model) && preg_match('/([^\/]+?)(?:\/[0-9\.]+)? (?:Android|Release)\//', $this->device->model, $matches)) {
						$this->device->model = $matches[1];
					}

					if (isset($this->device->model) && $this->device->model) {
						$this->device->identified |= Constants\Id::PATTERN;

						$device = Data\DeviceModels::identify('android', $this->device->model);
						if ($device->identified) {
							$device->identified |= $this->device->identified;
							$this->device = $device;
						}
					}

					if (preg_match('/HP eStation/u', $ua)) 	{ $this->device->manufacturer = 'HP'; $this->device->model = 'eStation'; $this->device->type = Constants\DeviceType::TABLET; $this->device->identified |= Constants\Id::MATCH_UA; $this->device->generic = false; }
					if (preg_match('/Pre\/1.0/u', $ua)) 		{ $this->device->manufacturer = 'Palm'; $this->device->model = 'Pre'; $this->device->identified |= Constants\Id::MATCH_UA; $this->device->generic = false; }
					if (preg_match('/Pre\/1.1/u', $ua)) 		{ $this->device->manufacturer = 'Palm'; $this->device->model = 'Pre Plus'; $this->device->identified |= Constants\Id::MATCH_UA; $this->device->generic = false; }
					if (preg_match('/Pre\/1.2/u', $ua)) 		{ $this->device->manufacturer = 'Palm'; $this->device->model = 'Pre 2'; $this->device->identified |= Constants\Id::MATCH_UA; $this->device->generic = false; }
					if (preg_match('/Pre\/3.0/u', $ua)) 		{ $this->device->manufacturer = 'HP'; $this->device->model = 'Pre 3'; $this->device->identified |= Constants\Id::MATCH_UA; $this->device->generic = false; }
					if (preg_match('/Pixi\/1.0/u', $ua)) 	{ $this->device->manufacturer = 'Palm'; $this->device->model = 'Pixi'; $this->device->identified |= Constants\Id::MATCH_UA; $this->device->generic = false; }
					if (preg_match('/Pixi\/1.1/u', $ua)) 	{ $this->device->manufacturer = 'Palm'; $this->device->model = 'Pixi Plus'; $this->device->identified |= Constants\Id::MATCH_UA; $this->device->generic = false; }
					if (preg_match('/P160UN?A?\/1.0/u', $ua)) { $this->device->manufacturer = 'HP'; $this->device->model = 'Veer'; $this->device->identified |= Constants\Id::MATCH_UA; $this->device->generic = false; }
				}
			}

			if (preg_match('/\(Linux; ([^;]+) Build/u', $ua, $match)) {
				$device = Data\DeviceModels::identify('android', $match[1]);
				if ($device->identified) {
					$device->identified |= Constants\Id::PATTERN;
					$device->identified |= $this->device->identified;

					$this->os->name = 'Android';
					$this->device = $device;
				}
			}


			/****************************************************
			 *		Aliyun OS
			 */

			if (preg_match('/Aliyun/u', $ua) || preg_match('/YunOs/ui', $ua)) {
				$this->os->name = 'Aliyun OS';
				$this->os->family = new Family([ 'name' => 'Android' ]);
				$this->os->version = new Version();

				if (preg_match('/YunOs[ \/]([0-9.]+)/iu', $ua, $match)) {
					$this->os->version = new Version([ 'value' => $match[1], 'details' => 3 ]);
				}

				if (preg_match('/AliyunOS ([0-9.]+)/u', $ua, $match)) {
					$this->os->version = new Version([ 'value' => $match[1], 'details' => 3 ]);
				}

				$this->device->type = Constants\DeviceType::MOBILE;

				if (preg_match('/; ([^;]*[^;\s])\s+Build/u', $ua, $match)) {
					$this->device->model = $match[1];
				}

				if (isset($this->device->model)) {
					$this->device->identified |= Constants\Id::PATTERN;

					$device = Data\DeviceModels::identify('android', $this->device->model);
					if ($device->identified) {
						$device->identified |= $this->device->identified;
						$this->device = $device;
					}
				}
			}

			if (preg_match('/Android/u', $ua)) {
				if (preg_match('/Android v(1.[0-9][0-9])_[0-9][0-9].[0-9][0-9]-/u', $ua, $match)) {
					$this->os->name = 'Aliyun OS';
					$this->os->family = new Family([ 'name' => 'Android' ]);
					$this->os->version = new Version([ 'value' => $match[1], 'details' => 3 ]);
				}

				if (preg_match('/Android (1.[0-9].[0-9].[0-9]+)-R?T/u', $ua, $match)) {
					$this->os->name = 'Aliyun OS';
					$this->os->family = new Family([ 'name' => 'Android' ]);
					$this->os->version = new Version([ 'value' => $match[1], 'details' => 3 ]);
				}

				if (preg_match('/Android ([12].[0-9].[0-9]+)-R-20[0-9]+/u', $ua, $match)) {
					$this->os->name = 'Aliyun OS';
					$this->os->family = new Family([ 'name' => 'Android' ]);
					$this->os->version = new Version([ 'value' => $match[1], 'details' => 3 ]);
				}

				if (preg_match('/Android 20[0-9]+/u', $ua, $match)) {
					$this->os->name = 'Aliyun OS';
					$this->os->family = new Family([ 'name' => 'Android' ]);
					$this->os->version = null;
				}
			}



			/****************************************************
			 *		Baidu Yi
			 */

			if (preg_match('/Baidu Yi/u', $ua)) {
				$this->os->name = 'Baidu Yi';
				$this->os->version = null;
			}




			/****************************************************
			 *		Google TV
			 */

			if (preg_match('/GoogleTV/u', $ua)) {
				$this->os->name = 'Google TV';
				$this->os->family = new Family([ 'name' => 'Android' ]);

				$this->device->type = Constants\DeviceType::TELEVISION;

				if (preg_match('/GoogleTV [0-9\.]+; ?([^;]*[^;\s])\s+Build/u', $ua, $match)) {
					$this->device->model = $match[1];
				}

				if (isset($this->device->model) && $this->device->model) {
					$this->device->identified |= Constants\Id::PATTERN;

					$device = Data\DeviceModels::identify('android', $this->device->model);
					if ($device->identified) {
						$device->identified |= $this->device->identified;
						$this->device = $device;
					}
				}
			}


			/****************************************************
			 *		Chromecast
			 */

			if (preg_match('/CrKey/u', $ua) && !preg_match('/Espial/u', $ua)) {
				$this->device->manufacturer = 'Google';
				$this->device->model = 'Chromecast';
				$this->device->type = Constants\DeviceType::TELEVISION;
				$this->device->identified |= Constants\Id::MATCH_UA;
				$this->device->generic = false;
			}


			/****************************************************
			 *		WoPhone
			 */

			if (preg_match('/WoPhone/u', $ua)) {
				$this->os->name = 'WoPhone';

				if (preg_match('/WoPhone\/([0-9\.]*)/u', $ua, $match)) {
					$this->os->version = new Version([ 'value' => $match[1] ]);
				}

				$this->device->type = Constants\DeviceType::MOBILE;
			}

			/****************************************************
			 *		BlackBerry
			 */

			if (preg_match('/BlackBerry/u', $ua) && !preg_match('/BlackBerry Runtime for Android Apps/u', $ua)) {
				$this->os->name = 'BlackBerry OS';

				$this->device->model = 'BlackBerry';
				$this->device->manufacturer = 'RIM';
				$this->device->type = Constants\DeviceType::MOBILE;
				$this->device->identified = Constants\Id::INFER;

				if (!preg_match('/Opera/u', $ua)) {
					if (preg_match('/BlackBerry([0-9]*)\/([0-9.]*)/u', $ua, $match)) {
						$this->device->model = $match[1];
						$this->os->version = new Version([ 'value' => $match[2], 'details' => 2 ]);
					}

					if (preg_match('/; BlackBerry ([0-9]*);/u', $ua, $match)) {
						$this->device->model = $match[1];
					}

					if (preg_match('/; ([0-9]+)[^;\)]+\)/u', $ua, $match)) {
						$this->device->model = $match[1];
					}

					if (preg_match('/Version\/([0-9.]*)/u', $ua, $match)) {
						$this->os->version = new Version([ 'value' => $match[1], 'details' => 2 ]);
					}

					if (isset($this->os->version) && $this->os->version->toFloat() >= 10) {
						$this->os->name = 'BlackBerry';
					}

					if ($this->device->model) {
						$device = Data\DeviceModels::identify('blackberry', $this->device->model);

						if ($device->identified) {
							$device->identified |= $this->device->identified;
							$this->device = $device;
						}
					}
				}
			}

			if (preg_match('/\(BB(1[^;]+); ([^\)]+)\)/u', $ua, $match)) {
				$this->os->name = 'BlackBerry';
				$this->os->version = new Version([ 'value' => $match[1], 'details' => 2 ]);

				$this->device->manufacturer = 'BlackBerry';
				$this->device->model = $match[2];

				if ($this->device->model == 'Kbd') {
					$this->device->model = 'Q series or Passport';
				}

				if ($this->device->model == 'Touch') {
					$this->device->model = 'A or Z series';
				}

				$this->device->type = preg_match('/Mobile/u', $ua) ? Constants\DeviceType::MOBILE : Constants\DeviceType::TABLET;
				$this->device->identified |= Constants\Id::MATCH_UA;

				if (preg_match('/Version\/([0-9.]*)/u', $ua, $match)) {
					$this->os->version = new Version([ 'value' => $match[1], 'details' => 2 ]);
				}
			}

			/****************************************************
			 *		BlackBerry PlayBook
			 */

			if (preg_match('/RIM Tablet OS ([0-9.]*)/u', $ua, $match)) {
				$this->os->name = 'BlackBerry Tablet OS';
				$this->os->version = new Version([ 'value' => $match[1], 'details' => 2 ]);

				$this->device->manufacturer = 'RIM';
				$this->device->model = 'BlackBerry PlayBook';
				$this->device->type = Constants\DeviceType::TABLET;
				$this->device->identified |= Constants\Id::MATCH_UA;
			}

			else if (preg_match('/\(PlayBook;/u', $ua) && preg_match('/PlayBook Build\/([0-9.]*)/u', $ua, $match)) {
				$this->os->name = 'BlackBerry Tablet OS';
				$this->os->version = new Version([ 'value' => $match[1], 'details' => 2 ]);

				$this->device->manufacturer = 'RIM';
				$this->device->model = 'BlackBerry PlayBook';
				$this->device->type = Constants\DeviceType::TABLET;
				$this->device->identified |= Constants\Id::MATCH_UA;
			}

			else if (preg_match('/PlayBook/u', $ua) && !preg_match('/Android/u', $ua)) {
				if (preg_match('/Version\/([0-9.]*)/u', $ua, $match)) {
					$this->os->name = 'BlackBerry Tablet OS';
					$this->os->version = new Version([ 'value' => $match[1], 'details' => 2 ]);

					$this->device->manufacturer = 'RIM';
					$this->device->model = 'BlackBerry PlayBook';
					$this->device->type = Constants\DeviceType::TABLET;
					$this->device->identified |= Constants\Id::MATCH_UA;
				}
			}


			/****************************************************
			 *		WebOS
			 */

			if (preg_match('/(?:web|hpw)OS\/(?:HP webOS )?([0-9.]*)/u', $ua, $match)) {
				$this->os->name = 'webOS';
				$this->os->version = new Version([ 'value' => $match[1], 'details' => 2 ]);
				$this->device->type = preg_match('/Tablet/iu', $ua) ? Constants\DeviceType::TABLET : Constants\DeviceType::MOBILE;
				$this->device->generic = false;

				if (preg_match('/Pre\/1.0/u', $ua)) $this->device->model = 'Pre';
				if (preg_match('/Pre\/1.1/u', $ua)) $this->device->model = 'Pre Plus';
				if (preg_match('/Pre\/1.2/u', $ua)) $this->device->model = 'Pre 2';
				if (preg_match('/Pre\/3.0/u', $ua)) $this->device->model = 'Pre 3';
				if (preg_match('/Pixi\/1.0/u', $ua)) $this->device->model = 'Pixi';
				if (preg_match('/Pixi\/1.1/u', $ua)) $this->device->model = 'Pixi Plus';
				if (preg_match('/P160UN?A?\/1.0/u', $ua)) $this->device->model = 'Veer';
				if (preg_match('/TouchPad\/1.0/u', $ua)) $this->device->model = 'TouchPad';
				if (isset($this->device->model)) $this->device->manufacturer = preg_match('/hpwOS/u', $ua) ? 'HP' : 'Palm';

				if (preg_match('/Emulator\//u', $ua) || preg_match('/Desktop\//u', $ua)) {
					$this->device->type = Constants\DeviceType::EMULATOR;
					$this->device->manufacturer = null;
					$this->device->model = null;
				}

				$this->device->identified |= Constants\Id::MATCH_UA;
			}

			if (preg_match('/elite\/fzz/u', $ua, $match)) {
				$this->os->name = 'webOS';
			}


			/****************************************************
			 *		S80
			 */

			if (preg_match('/Series80\/([0-9.]*)/u', $ua, $match)) {
				$this->os->name = 'Series80';
				$this->os->version = new Version([ 'value' => $match[1] ]);

				if (preg_match('/Nokia([^\/;\)]+)[\/|;|\)]/u', $ua, $match)) {
					if ($match[1] != 'Browser') {
						$this->device->manufacturer = 'Nokia';
						$this->device->model = Data\DeviceModels::cleanup($match[1]);
						$this->device->identified |= Constants\Id::PATTERN;
					}
				}
			}


			/****************************************************
			 *		S60
			 */

			if (preg_match('/Symbian/u', $ua) || preg_match('/Series[ ]?60/u', $ua) || preg_match('/S60;/u', $ua) || preg_match('/S60V/u', $ua)) {
				$this->os->name = 'Series60';

				if (preg_match('/SymbianOS\/9.1/u', $ua) && !preg_match('/Series60/u', $ua)) {
					$this->os->version = new Version([ 'value' => '3.0' ]);
				}

				if (preg_match('/Series60\/([0-9.]*)/u', $ua, $match)) {
					$this->os->version = new Version([ 'value' => $match[1] ]);
				}

				if (preg_match('/S60V([0-9.]*)/u', $ua, $match)) {
					$this->os->version = new Version([ 'value' => $match[1] ]);
				}

				if (preg_match('/Nokia([^\/;\)]+)[\/|;|\)]/u', $ua, $match)) {
					if ($match[1] != 'Browser') {
						$this->device->manufacturer = 'Nokia';
						$this->device->model = Data\DeviceModels::cleanup($match[1]);
						$this->device->identified |= Constants\Id::PATTERN;
					}
				}

				if (preg_match('/Symbian; U; (?:Nokia)?([^;]+); [a-z][a-z](?:\-[a-z][a-z])?/u', $ua, $match)) {
					$this->device->manufacturer = 'Nokia';
					$this->device->model = Data\DeviceModels::cleanup($match[1]);
					$this->device->identified |= Constants\Id::PATTERN;
				}

				if (preg_match('/Vertu([^\/;]+)[\/|;]/u', $ua, $match)) {
					$this->device->manufacturer = 'Vertu';
					$this->device->model = Data\DeviceModels::cleanup($match[1]);
					$this->device->identified |= Constants\Id::PATTERN;
				}

				if (preg_match('/Samsung\/([^;]*);/u', $ua, $match)) {
					$this->device->manufacturer = 'Samsung';
					$this->device->model = Data\DeviceModels::cleanup($match[1]);
					$this->device->identified |= Constants\Id::PATTERN;
				}

				if (isset($this->device->model)) {
					$device = Data\DeviceModels::identify('s60', $this->device->model);
					if ($device->identified) {
						$device->identified |= $this->device->identified;
						$this->device = $device;
					}
				}

				$this->device->type = Constants\DeviceType::MOBILE;
			}

			/****************************************************
			 *		S40
			 */

			if (preg_match('/Series40/u', $ua)) {
				$this->os->name = 'Series40';

				if (preg_match('/Nokia([^\/]+)\//u', $ua, $match)) {
					$this->device->manufacturer = 'Nokia';
					$this->device->model = Data\DeviceModels::cleanup($match[1]);
					$this->device->identified |= Constants\Id::PATTERN;
				}

				if (isset($this->device->model)) {
					$device = Data\DeviceModels::identify('s40', $this->device->model);
					if ($device->identified) {
						$device->identified |= $this->device->identified;
						$this->device = $device;
					}
				}

				if (isset($this->device->model)) {
					$device = Data\DeviceModels::identify('asha', $this->device->model);
					if ($device->identified) {
						$device->identified |= $this->device->identified;
						$this->os->name = 'Nokia Asha Platform';
						$this->os->version = new Version([ 'value' => '1.0' ]);
						$this->device = $device;
					}

					if (preg_match('/java_runtime_version=Nokia_Asha_([0-9_]+);/u', $ua, $match)) {
						$this->os->version = new Version([ 'value' => str_replace('_', '.', $match[1]) ]);
					}
				}

				$this->device->type = Constants\DeviceType::MOBILE;
			}

			/****************************************************
			 *		S30
			 */

			if (preg_match('/Series30/u', $ua)) {
				$this->os->name = 'Series30';

				if (preg_match('/Nokia([^\/]+)\//u', $ua, $match)) {
					$this->device->manufacturer = 'Nokia';
					$this->device->model = Data\DeviceModels::cleanup($match[1]);
					$this->device->identified |= Constants\Id::PATTERN;
				}

				if (isset($this->device->model)) {
					$device = Data\DeviceModels::identify('s30', $this->device->model);
					if ($device->identified) {
						$device->identified |= $this->device->identified;
						$this->device = $device;
					}
				}

				$this->device->type = Constants\DeviceType::MOBILE;
			}

			/****************************************************
			 *		MeeGo
			 */

			if (preg_match('/MeeGo/u', $ua)) {
				$this->os->name = 'MeeGo';
				$this->device->type = Constants\DeviceType::MOBILE;

				if (preg_match('/Nokia([^\)]+)\)/u', $ua, $match)) {
					$this->device->manufacturer = 'Nokia';
					$this->device->model = Data\DeviceModels::cleanup($match[1]);
					$this->device->identified |= Constants\Id::PATTERN;
					$this->device->generic = false;
				}
			}

			/****************************************************
			 *		Maemo
			 */

			if (preg_match('/Maemo/u', $ua)) {
				$this->os->name = 'Maemo';
				$this->device->type = Constants\DeviceType::MOBILE;

				if (preg_match('/(N[0-9]+)/u', $ua, $match)) {
					$this->device->manufacturer = 'Nokia';
					$this->device->model = $match[1];
					$this->device->identified |= Constants\Id::PATTERN;
					$this->device->generic = false;
				}
			}

			/****************************************************
			 *		Tizen
			 */

			if (preg_match('/Tizen/u', $ua)) {
				$this->os->name = 'Tizen';

				if (preg_match('/Tizen[\/ ]([0-9.]*[0-9])/u', $ua, $match)) {
					$this->os->version = new Version([ 'value' => $match[1] ]);
				}

				if (preg_match('/\(([^;]+); ([^\/]+)\//u', $ua, $match)) {
					$falsepositive = false;
					if (strtoupper($match[1]) == 'SMART-TV') $falsepositive = true;
					if ($match[1] == 'Linux') $falsepositive = true;
					if ($match[1] == 'Tizen') $falsepositive = true;

					if (!$falsepositive) {
						$this->device->manufacturer = $match[1];
						$this->device->model = $match[2];
						$this->device->identified = Constants\Id::PATTERN;

						$device = Data\DeviceModels::identify('tizen', $match[2]);

						if ($device->identified) {
							$device->identified |= $this->device->identified;
							$this->device = $device;
						}
					}
				}

				if (preg_match('/\s*([^;]+);\s+([^;\)]+)\)/u', $ua, $match)) {
					$falsepositive = false;
					if ($match[1] == 'U') $falsepositive = true;
					if (substr($match[2], 0, 5) == 'Tizen') $falsepositive = true;
					if (substr($match[2], 0, 11) == 'AppleWebKit') $falsepositive = true;
					if (preg_match("/^[a-z]{2,2}(?:\-[a-z]{2,2})?$/", $match[2])) $falsepositive = true;

					if (!$falsepositive) {
						$this->device->model = $match[2];
						$this->device->identified = Constants\Id::PATTERN;

						$device = Data\DeviceModels::identify('tizen', $match[2]);

						if ($device->identified) {
							$device->identified |= $this->device->identified;
							$this->device = $device;
						}
					}
				}


				if (!$this->device->type && preg_match('/Mobile/iu', $ua, $match)) {
					$this->device->type = Constants\DeviceType::MOBILE;
				}


				if (preg_match('/\(SMART[ -]TV;/iu', $ua, $match)) {
					$this->device->type = Constants\DeviceType::TELEVISION;
					$this->device->manufacturer = 'Samsung';
					$this->device->series = 'Smart TV';
					$this->device->identified = Constants\Id::PATTERN;
				}


				if (preg_match('/(?:Samsung|Tizen ?)Browser\/([0-9.]*)/u', $ua, $match)) {
					$this->browser->name = "Samsung Browser";
					$this->browser->channel = null;
					$this->browser->stock = true;
					$this->browser->version = new Version([ 'value' => $match[1] ]);
					$this->browser->channel = null;
				}
			}

			if (preg_match('/Linux\; U\; Android [0-9.]+\; ko\-kr\; SAMSUNG\; (NX[0-9]+[^\)]]*)/u', $ua, $match)) {
				$this->os->name = 'Tizen';
				$this->os->version = null;

				$this->device->type = Constants\DeviceType::CAMERA;
				$this->device->manufacturer = 'Samsung';
				$this->device->model = $match[1];
				$this->device->identified = Constants\Id::PATTERN;
			}


			/****************************************************
			 *		Jolla Sailfish
			 */

			if (preg_match('/Sailfish;/u', $ua)) {
				$this->os->name = 'Sailfish';
				$this->os->version = null;

				if (preg_match('/Jolla;/u', $ua)) {
					$this->device->manufacturer = 'Jolla';
				}

				if (preg_match('/Mobile/u', $ua)) { 
					$this->device->model = 'Phone';
					$this->device->type = Constants\DeviceType::MOBILE;
					$this->device->identified = Constants\Id::PATTERN;
				}

				if (preg_match('/Tablet/u', $ua)) { 
					$this->device->model = 'Tablet';
					$this->device->type = Constants\DeviceType::TABLET;
					$this->device->identified = Constants\Id::PATTERN;
				}
			}

			/****************************************************
			 *		Bada
			 */

			if (preg_match('/[b|B]ada/u', $ua)) {
				$this->os->name = 'Bada';

				if (preg_match('/[b|B]ada[\/ ]([0-9.]*)/u', $ua, $match)) {
					$this->os->version = new Version([ 'value' => $match[1], 'details' => 2 ]);
				}

				$this->device->type = Constants\DeviceType::MOBILE;

				if (preg_match('/\(([^;]+); ([^\/]+)\//u', $ua, $match)) {
					if ($match[1] != 'Bada') {
						$this->device->manufacturer = $match[1];
						$this->device->model = $match[2];
						$this->device->identified = Constants\Id::PATTERN;

						$device = Data\DeviceModels::identify('bada', $match[2]);

						if ($device->identified) {
							$device->identified |= $this->device->identified;
							$this->device = $device;
						}
					}
				}
			}

			/****************************************************
			 *		Brew
			 */

			if (preg_match('/BREW/ui', $ua) || preg_match('/BMP( [0-9.]*)?; U/u', $ua) || preg_match('/BMP\/([0-9.]*)/u', $ua)) {
				$this->os->name = 'Brew';

				if (preg_match('/; Brew ([0-9.]*);/iu', $ua, $match)) {
					$this->os->version = new Version([ 'value' => $match[1] ]);
				}

				if (preg_match('/BREW; U; ([0-9.]*)/iu', $ua, $match)) {
					$this->os->version = new Version([ 'value' => $match[1] ]);
				}

				else if (preg_match('/BREW MP ([0-9.]*)/iu', $ua, $match)) {
					$this->os->version = new Version([ 'value' => $match[1] ]);
				}

				else if (preg_match('/[\(;]BREW[\/ ]([0-9.]*)/iu', $ua, $match)) {
					$this->os->version = new Version([ 'value' => $match[1] ]);
				}

				else if (preg_match('/BMP ([0-9.]*); U/iu', $ua, $match)) {
					$this->os->version = new Version([ 'value' => $match[1] ]);
				}

				else if (preg_match('/BMP\/([0-9.]*)/iu', $ua, $match)) {
					$this->os->version = new Version([ 'value' => $match[1] ]);
				}


				$this->device->type = Constants\DeviceType::MOBILE;

				if (preg_match('/(?:Brew MP|BREW|BMP) [^;]+; U; [^;]+; ([^;]+); NetFront[^\)]+\) [^\s]+ ([^\s]+)/u', $ua, $match)) {
					$this->device->manufacturer = trim($match[1]);
					$this->device->model = $match[2];
					$this->device->identified = Constants\Id::PATTERN;

					$device = Data\DeviceModels::identify('brew', $match[2]);

					if ($device->identified) {
						$device->identified |= $this->device->identified;
						$this->device = $device;
					}
				}

				if (preg_match('/\(([^;]+);U;REX\/[^;]+;BREW\/[^;]+;(?:.*;)?[0-9]+\*[0-9]+(?:;CTC\/2.0)?\)/u', $ua, $match)) {
					$this->device->model = $match[1];
					$this->device->identified = Constants\Id::PATTERN;

					$device = Data\DeviceModels::identify('brew', $match[1]);

					if ($device->identified) {
						$device->identified |= $this->device->identified;
						$this->device = $device;
					}
				}
			}

			/****************************************************
			 *		MTK
			 */

			if (preg_match('/\(MTK;/u', $ua) || preg_match('/\/MTK /u', $ua)) {
				$this->os->name = 'MTK';
				$this->device->type = Constants\DeviceType::MOBILE;
			}

			/****************************************************
			 *		MAUI Runtime
			 */

			if (preg_match('/\(MAUI Runtime;/u', $ua) || preg_match('/MAUI[_-][bB]rowser/u', $ua) || preg_match('/Browser\/MAUI/u', $ua)) {
				$this->os->name = 'MAUI Runtime';
				$this->device->type = Constants\DeviceType::MOBILE;
			}

			/****************************************************
			 *		VRE
			 */

			if (preg_match('/\(VRE;/u', $ua)) {
				$this->os->name = 'VRE';
				$this->device->type = Constants\DeviceType::MOBILE;
			}

			/****************************************************
			 *		SpreadTrum
			 */

			if (preg_match('/\(SpreadTrum;/u', $ua)) {
				$this->os->name = 'SpreadTrum';
				$this->device->type = Constants\DeviceType::MOBILE;
			}

			/****************************************************
			 *		ThreadX
			 */

			if (preg_match('/ThreadX(?:_OS)?\/([0-9.]*)/ui', $ua, $match)) {
				$this->os->name = 'ThreadX';
				$this->os->version = new Version([ 'value' => $match[1] ]);
			}

			/****************************************************
			 *		COS
			 */

			if (preg_match('/COS like Android/ui', $ua, $match)) {
				$this->os->name = 'COS';
				$this->os->family = new Family([ 'name' => 'Android' ]);
				$this->os->version = null;
				$this->device->type = Constants\DeviceType::MOBILE;
			}

			if (preg_match('/COSBrowser\//ui', $ua, $match)) {
				$this->os->name = 'COS';
				$this->os->family = new Family([ 'name' => 'Android' ]);
			}

			if (preg_match('/COS\/([0-9.]*)/ui', $ua, $match)) {
				$this->os->name = 'COS';
				$this->os->family = new Family([ 'name' => 'Android' ]);
				$this->os->version = new Version([ 'value' => $match[1], 'details' => 2 ]);
			}

			if (preg_match('/(?:\(|; )COS/ui', $ua, $match)) {
				$this->os->name = 'COS';
				$this->os->family = new Family([ 'name' => 'Android' ]);
			}

			if (preg_match('/(?:\(|; )Chinese Operating System ([0-9]\.[0-9.]*);/ui', $ua, $match)) {
				$this->os->name = 'COS';
				$this->os->family = new Family([ 'name' => 'Android' ]);
				$this->os->version = new Version([ 'value' => $match[1], 'details' => 2 ]);
			}

			if (preg_match('/(?:\(|; )COS ([0-9]\.[0-9.]*);/ui', $ua, $match)) {
				$this->os->name = 'COS';
				$this->os->family = new Family([ 'name' => 'Android' ]);
				$this->os->version = new Version([ 'value' => $match[1], 'details' => 2 ]);
			}


			/****************************************************
			 *		CrOS
			 */

			if (preg_match('/CrOS/u', $ua)) {
				$this->os->name = 'Chrome OS';
				$this->device->type = Constants\DeviceType::DESKTOP;
			}

			/****************************************************
			 *		Joli OS
			 */

			if (preg_match('/Joli OS\/([0-9.]*)/ui', $ua, $match)) {
				$this->os->name = 'Joli OS';
				$this->os->version = new Version([ 'value' => $match[1] ]);
				$this->device->type = Constants\DeviceType::DESKTOP;
			}

			/****************************************************
			 *		BeOS
			 */

			if (preg_match('/BeOS/u', $ua)) {
				$this->os->name = 'BeOS';
				$this->device->type = Constants\DeviceType::DESKTOP;
			}

			/****************************************************
			 *		Haiku
			 */

			if (preg_match('/Haiku/u', $ua)) {
				$this->os->name = 'Haiku';
				$this->device->type = Constants\DeviceType::DESKTOP;
			}

			/****************************************************
			 *		QNX
			 */

			if (preg_match('/QNX/u', $ua)) {
				$this->os->name = 'QNX';
				$this->device->type = Constants\DeviceType::MOBILE;
			}

			/****************************************************
			 *		OS/2 Warp
			 */

			if (preg_match('/OS\/2; (?:U; )?Warp ([0-9.]*)/iu', $ua, $match)) {
				$this->os->name = 'OS/2 Warp';
				$this->os->version = new Version([ 'value' => $match[1] ]);
				$this->device->type = Constants\DeviceType::DESKTOP;
			}

			/****************************************************
			 *		Palm OS
			 */

			if (preg_match('/PalmOS/iu', $ua, $match)) {
				$this->os->name = 'Palm OS';
				$this->device->type = Constants\DeviceType::MOBILE;

				if (preg_match('/; ([^;)]+)\)/u', $ua, $match)) {
					$device = Data\DeviceModels::identify('palmos', $match[1]);

					if ($device->identified) {
						$device->identified |= $this->device->identified;
						$this->device = $device;
					}
				}
			}

			if (preg_match('/Palm OS ([0-9.]*)/iu', $ua, $match)) {
				$this->os->name = 'Palm OS';
				$this->os->version = new Version([ 'value' => $match[1] ]);
				$this->device->type = Constants\DeviceType::MOBILE;
			}

			if (preg_match('/PalmSource/u', $ua, $match)) {
				$this->os->name = 'Palm OS';
				$this->os->version = null;
				$this->device->type = Constants\DeviceType::MOBILE;

				if (preg_match('/PalmSource\/([^;]+)/u', $ua, $match)) {
					$this->device->model = $match[1];
					$this->device->identified = Constants\Id::PATTERN;
				}

				if (isset($this->device->model) && $this->device->model) {
					$device = Data\DeviceModels::identify('palmos', $this->device->model);

					if ($device->identified) {
						$device->identified |= $this->device->identified;
						$this->device = $device;
					}
				}
			}

			/****************************************************
			 *		Grid OS
			 */

			if (preg_match('/Grid OS ([0-9.]*)/iu', $ua, $match)) {
				$this->os->name = 'Grid OS';
				$this->os->version = new Version([ 'value' => $match[1] ]);
				$this->device->type = Constants\DeviceType::TABLET;
			}

			/****************************************************
			 *		RISC OS
			 */

			if (preg_match('/RISC OS/iu', $ua, $match)) {
				$this->os->name = 'RISC OS';
				$this->device->type = Constants\DeviceType::DESKTOP;

				if (preg_match('/RISC OS(?:-NC)? ([0-9.]*)/iu', $ua, $match)) {
					$this->os->version = new Version([ 'value' => $match[1] ]);
				}
			}

			/****************************************************
			 *		AmigaOS
			 */

			if (preg_match('/Amiga/iu', $ua, $match)) {
				$this->os->name = 'AmigaOS';
				$this->device->type = Constants\DeviceType::DESKTOP;

				if (preg_match('/AmigaOS ([0-9.]*)/iu', $ua, $match)) {
					$this->os->version = new Version([ 'value' => $match[1] ]);
				}
			}

			/****************************************************
			 *		MorphOS
			 */

			if (preg_match('/MorphOS/iu', $ua, $match)) {
				$this->os->name = 'MorphOS';
				$this->device->type = Constants\DeviceType::DESKTOP;

				if (preg_match('/MorphOS ([0-9.]*)/iu', $ua, $match)) {
					$this->os->version = new Version([ 'value' => $match[1] ]);
				}
			}

			/****************************************************
			 *		AROS
			 */

			if (preg_match('/AROS/u', $ua, $match)) {
				$this->os->name = 'AROS';
				$this->device->type = Constants\DeviceType::DESKTOP;
			}

			/****************************************************
			 *		Kindle
			 */

			if (preg_match('/Kindle/u', $ua) && !preg_match('/Fire/u', $ua)) {
				$this->os->name = '';

				$this->device->manufacturer = 'Amazon';
				$this->device->series = 'Kindle';
				$this->device->type = Constants\DeviceType::EREADER;

				if (preg_match('/Kindle\/1.0/u', $ua)) $this->device->model = 'Kindle 1';
				if (preg_match('/Kindle\/2.0/u', $ua)) $this->device->model = 'Kindle 2';
				if (preg_match('/Kindle\/2.5/u', $ua)) $this->device->model = 'Kindle 2';
				if (preg_match('/Kindle\/3.0/u', $ua)) $this->device->model = 'Kindle 3';
				if (preg_match('/Kindle\/3.0\+/u', $ua)) $this->device->model = 'Kindle 3 or later';
				if (preg_match('/Kindle SkipStone/u', $ua)) $this->device->model = 'Kindle Touch or later';

				if (!empty($this->device->model)) $this->device->series = null;

				$this->device->identified |= Constants\Id::MATCH_UA;
			}

			/****************************************************
			 *		NOOK
			 */

			if (preg_match('/nook browser/u', $ua)) {
				$this->os->name = 'Android';

				$this->device->manufacturer = 'Barnes & Noble';
				$this->device->series = 'NOOK';
				$this->device->type = Constants\DeviceType::EREADER;
				$this->device->identified |= Constants\Id::MATCH_UA;
			}

			/****************************************************
			 *		Bookeen
			 */

			if (preg_match('/bookeen\/cybook/u', $ua)) {
				$this->os->name = '';

				$this->device->manufacturer = 'Bookeen';
				$this->device->series = 'Cybook';
				$this->device->type = Constants\DeviceType::EREADER;

				$this->device->identified |= Constants\Id::MATCH_UA;
			}

			/****************************************************
			 *		Kobo Reader
			 */

			if (preg_match('/Kobo Touch/u', $ua, $match)) {
				$this->os->name = '';
				$this->os->version = null;

				$this->device->manufacturer = 'Kobo';
				$this->device->series = 'eReader';
				$this->device->type = Constants\DeviceType::EREADER;
				$this->device->identified |= Constants\Id::MATCH_UA;
			}

			/****************************************************
			 *		Sony Reader
			 */

			if (preg_match('/EBRD([0-9]+)/u', $ua, $match)) {
				$this->os->name = '';


				$this->device->manufacturer = 'Sony';
				$this->device->series = 'Reader';
				$this->device->type = Constants\DeviceType::EREADER;
				$this->device->identified |= Constants\Id::MATCH_UA;

				switch($match[1]) {
					case '1101':	$this->device->model = 'PRS-T1'; $this->device->generic = false; break;
					case '1102':	$this->device->model = 'PRS-T1'; $this->device->generic = false; break;
					case '1201':	$this->device->model = 'PRS-T2'; $this->device->generic = false; break;
					case '1301':	$this->device->model = 'PRS-T3'; $this->device->generic = false; break;
				}
			}

			/****************************************************
			 *		PocketBook
			 */

			if (preg_match('/PocketBook\/([0-9]+)/u', $ua, $match)) {
				$this->os->name = '';

				$this->device->manufacturer = 'PocketBook';
				$this->device->type = Constants\DeviceType::EREADER;
				$this->device->identified |= Constants\Id::MATCH_UA;

				switch($match[1]) {
					case '515':	$this->device->model = 'Mini'; $this->device->generic = false; break;
					case '614':	$this->device->model = 'Basic 2'; $this->device->generic = false; break;
					case '622':	$this->device->model = 'Touch'; $this->device->generic = false; break;
					case '623':	$this->device->model = 'Touch Lux'; $this->device->generic = false; break;
					case '624':	$this->device->model = 'Basic Touch'; $this->device->generic = false; break;
					case '626':	$this->device->model = 'Touch Lux 2'; $this->device->generic = false; break;
					case '630':	$this->device->model = 'Sense'; $this->device->generic = false; break;
					case '640':	$this->device->model = 'Auqa'; $this->device->generic = false; break;
					case '650':	$this->device->model = 'Ultra'; $this->device->generic = false; break;
					case '801':	$this->device->model = 'Color Lux'; $this->device->generic = false; break;
					case '840':	$this->device->model = 'InkPad'; $this->device->generic = false; break;
				}
			}

			/****************************************************
			 *		iRiver
			 */

			if (preg_match('/Iriver ;/u', $ua)) {
				$this->os->name = '';

				$this->device->manufacturer = 'iRiver';
				$this->device->series = 'Story';
				$this->device->type = Constants\DeviceType::EREADER;

				if (preg_match('/EB07/u', $ua)) {
					$this->device->model = 'Story HD EB07'; $this->device->generic = false;
				}

				$this->device->identified |= Constants\Id::MATCH_UA;
			}

			/****************************************************
			 *		Tesla Model S in-car browser
			 */

			if (preg_match('/QtCarBrowser/u', $ua)) {
				$this->os->name = '';

				$this->device->manufacturer = 'Tesla';
				$this->device->model = 'Model S';
				$this->device->type = Constants\DeviceType::CAR;
				$this->device->identified |= Constants\Id::MATCH_UA;
			}


			/****************************************************
			 *		Nintendo
			 */

			if (preg_match('/Nintendo Wii/u', $ua)) {
				$this->os->name = '';

				$this->device->manufacturer = 'Nintendo';
				$this->device->model = 'Wii';
				$this->device->type = Constants\DeviceType::GAMING;
				$this->device->subtype = Constants\DeviceSubType::CONSOLE;
				$this->device->identified |= Constants\Id::MATCH_UA;
				$this->device->generic = false;
			}

			if (preg_match('/Nintendo Wii ?U/u', $ua)) {
				$this->os->name = '';

				$this->device->manufacturer = 'Nintendo';
				$this->device->model = 'Wii U';
				$this->device->type = Constants\DeviceType::GAMING;
				$this->device->subtype = Constants\DeviceSubType::CONSOLE;
				$this->device->identified |= Constants\Id::MATCH_UA;
				$this->device->generic = false;
			}

			if (preg_match('/Nintendo DS/u', $ua)) {
				$this->os->name = '';

				$this->device->manufacturer = 'Nintendo';
				$this->device->model = 'DS';
				$this->device->type = Constants\DeviceType::GAMING;
				$this->device->subtype = Constants\DeviceSubType::PORTABLE;
				$this->device->identified |= Constants\Id::MATCH_UA;
				$this->device->generic = false;
			}

			if (preg_match('/Nintendo DSi/u', $ua)) {
				$this->os->name = '';

				$this->device->manufacturer = 'Nintendo';
				$this->device->model = 'DSi';
				$this->device->type = Constants\DeviceType::GAMING;
				$this->device->subtype = Constants\DeviceSubType::PORTABLE;
				$this->device->identified |= Constants\Id::MATCH_UA;
				$this->device->generic = false;
			}

			if (preg_match('/Nintendo 3DS/u', $ua)) {
				$this->os->name = '';

				if (preg_match('/Version\/([0-9.]*)/u', $ua, $match)) {
					$this->os->version = new Version([ 'value' => $match[1] ]);
				}

				$this->device->manufacturer = 'Nintendo';
				$this->device->model = '3DS';
				$this->device->type = Constants\DeviceType::GAMING;
				$this->device->subtype = Constants\DeviceSubType::PORTABLE;
				$this->device->identified |= Constants\Id::MATCH_UA;
				$this->device->generic = false;
			}

			if (preg_match('/New Nintendo 3DS/u', $ua)) {
				$this->os->name = '';

				if (preg_match('/Version\/([0-9.]*)/u', $ua, $match)) {
					$this->os->version = new Version([ 'value' => $match[1] ]);
				}

				$this->device->manufacturer = 'Nintendo';
				$this->device->model = 'New 3DS';
				$this->device->type = Constants\DeviceType::GAMING;
				$this->device->subtype = Constants\DeviceSubType::PORTABLE;
				$this->device->identified |= Constants\Id::MATCH_UA;
				$this->device->generic = false;
			}

			/****************************************************
			 *		Sony Playstation
			 */

			if (preg_match('/PlayStation Portable/u', $ua)) {
				$this->os->name = '';

				$this->device->manufacturer = 'Sony';
				$this->device->model = 'Playstation Portable';
				$this->device->type = Constants\DeviceType::GAMING;
				$this->device->subtype = Constants\DeviceSubType::PORTABLE;
				$this->device->identified |= Constants\Id::MATCH_UA;
				$this->device->generic = false;
			}

			if (preg_match('/PlayStation Vita ([0-9.]*)/u', $ua, $match)) {
				$this->os->name = '';
				$this->os->version = new Version([ 'value' => $match[1] ]);

				$this->device->manufacturer = 'Sony';
				$this->device->model = 'Playstation Vita';
				$this->device->type = Constants\DeviceType::GAMING;
				$this->device->subtype = Constants\DeviceSubType::PORTABLE;
				$this->device->identified |= Constants\Id::MATCH_UA;
				$this->device->generic = false;

				if (preg_match('/VTE\//u', $ua, $match)) {
					$this->device->model = 'Playstation TV';
				}
			}

			if (preg_match('/PlayStation 3/ui', $ua)) {
				$this->os->name = '';

				if (preg_match('/PLAYSTATION 3;? ([0-9.]*)/u', $ua, $match)) {
					$this->os->version = new Version([ 'value' => $match[1] ]);
				}

				$this->device->manufacturer = 'Sony';
				$this->device->model = 'Playstation 3';
				$this->device->type = Constants\DeviceType::GAMING;
				$this->device->subtype = Constants\DeviceSubType::CONSOLE;
				$this->device->identified |= Constants\Id::MATCH_UA;
				$this->device->generic = false;
			}

			if (preg_match('/PlayStation 4/ui', $ua)) {
				$this->os->name = '';

				if (preg_match('/PlayStation 4 ([0-9.]*)/u', $ua, $match)) {
					$this->os->version = new Version([ 'value' => $match[1] ]);
				}

				$this->device->manufacturer = 'Sony';
				$this->device->model = 'Playstation 4';
				$this->device->type = Constants\DeviceType::GAMING;
				$this->device->subtype = Constants\DeviceSubType::CONSOLE;
				$this->device->identified |= Constants\Id::MATCH_UA;
				$this->device->generic = false;
			}

			/****************************************************
			 *		XBox
			 */

			if (preg_match('/Xbox\)$/u', $ua, $match)) {
				unset($this->os->name);
				unset($this->os->version);

				$this->device->manufacturer = 'Microsoft';
				$this->device->model = 'Xbox 360';
				$this->device->type = Constants\DeviceType::GAMING;
				$this->device->subtype = Constants\DeviceSubType::CONSOLE;
				$this->device->identified |= Constants\Id::MATCH_UA;
				$this->device->generic = false;
			}

			if (preg_match('/Xbox One\)/u', $ua, $match)) {
				if ($this->isOs('Windows Phone', '=', '10')) {
					$this->os->name = 'Windows';
					$this->os->version->alias = '10';
				}

				if (!$this->isOs('Windows', '=', '10')) {
					unset($this->os->name);
					unset($this->os->version);
				}

				$this->device->manufacturer = 'Microsoft';
				$this->device->model = 'Xbox One';
				$this->device->type = Constants\DeviceType::GAMING;
				$this->device->subtype = Constants\DeviceSubType::CONSOLE;
				$this->device->identified |= Constants\Id::MATCH_UA;
				$this->device->generic = false;
			}

			/****************************************************
			 *		Kin
			 */

			if (preg_match('/KIN\.(One|Two) ([0-9.]*)/ui', $ua, $match)) {
				$this->os->name = 'Kin OS';
				$this->os->version = new Version([ 'value' => $match[2], 'details' => 2 ]);

				switch($match[1]) {
					case 'One':		$this->device->manufacturer = 'Microsoft';
									$this->device->model = 'Kin ONE';
									$this->device->identified |= Constants\Id::MATCH_UA;
									$this->device->generic = false;
									break;

					case 'Two':		$this->device->manufacturer = 'Microsoft';
									$this->device->model = 'Kin TWO';
									$this->device->identified |= Constants\Id::MATCH_UA;
									$this->device->generic = false;
									break;
				}
			}

			/****************************************************
			 *		Zune HD
			 *
			 *		Mozilla/4.0 (compatible; MSIE 6.0; Windows CE; IEMobile 6.12; Microsoft ZuneHD 4.5)
			 */

			if (preg_match('/Microsoft ZuneHD/u', $ua)) {
				unset($this->os->name);
				unset($this->os->version);

				$this->device->manufacturer = 'Microsoft';
				$this->device->model = 'Zune HD';
				$this->device->type = Constants\DeviceType::MEDIA;
				$this->device->identified |= Constants\Id::MATCH_UA;
				$this->device->generic = false;
			}








			/****************************************************
			 *		Generic television detection
			 */

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



			/****************************************************
			 *		Panasonic Smart Viera
			 */

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

			/****************************************************
			 *		Panasonic Diga
			 */

			if (preg_match('/; Diga;/u', $ua)) {
				$this->device->manufacturer = 'Panasonic';
				$this->device->series = 'Diga';
				$this->device->type = Constants\DeviceType::TELEVISION;
				$this->device->identified |= Constants\Id::MATCH_UA;
			}



			/****************************************************
			 *		Sharp AQUOS TV
			 */

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


			/****************************************************
			 *		Samsung Smart TV
			 */

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


			/****************************************************
			 *		Sony Internet TV
			 */

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

			/****************************************************
			 *		Philips Net TV
			 */

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

			/****************************************************
			 *		LG NetCast TV
			 */

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


			/****************************************************
			 *		Toshiba Smart TV
			 */

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


			/****************************************************
			 *		Loewe
			 */

			if (preg_match('/LOEWE\/TV/u', $ua)) {
				$this->device->manufacturer = 'Loewe';
				$this->device->series = 'Smart TV';
				$this->device->type = Constants\DeviceType::TELEVISION;
				$this->device->identified |= Constants\Id::MATCH_UA;

				if (preg_match('/((?:SL|ID)[0-9]+)/u', $ua, $match)) {
					$this->device->model = $match[1];
				}
			}


			/****************************************************
			 *		KreaTV
			 */

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


			/****************************************************
			 *		ADB
			 */

			if (preg_match('/\(ADB; ([^\)]+)\)/u', $ua, $match)) {
				unset($this->os->name);
				unset($this->os->version);

				$this->device->manufacturer = 'ADB';
				$this->device->model = ($match[1] != 'Unknown' ? str_replace('ADB', '', $match[1]) . ' ' : '') . 'IPTV receiver';
				$this->device->type = Constants\DeviceType::TELEVISION;
				$this->device->identified |= Constants\Id::MATCH_UA;
				$this->device->generic = false;
			}

			/****************************************************
			 *		MStar
			 */

			if (preg_match('/Mstar;OWB/u', $ua)) {
				unset($this->os->name);
				unset($this->os->version);

				$this->device->manufacturer = 'MStar';
				$this->device->model = 'PVR';
				$this->device->type = Constants\DeviceType::TELEVISION;
				$this->device->identified |= Constants\Id::MATCH_UA;

				$this->browser->name = 'Origyn Web Browser';
			}

			/****************************************************
			 *		TechniSat
			 */

			if (preg_match('/TechniSat ([^;]+);/u', $ua, $match)) {
				unset($this->os->name);
				unset($this->os->version);

				$this->device->manufacturer = 'TechniSat';
				$this->device->model = $match[1];
				$this->device->type = Constants\DeviceType::TELEVISION;
				$this->device->identified |= Constants\Id::MATCH_UA;
				$this->device->generic = false;
			}

			/****************************************************
			 *		Technicolor
			 */

			if (preg_match('/Technicolor_([^;]+);/u', $ua, $match)) {
				unset($this->os->name);
				unset($this->os->version);

				$this->device->manufacturer = 'Technicolor';
				$this->device->model = $match[1];
				$this->device->type = Constants\DeviceType::TELEVISION;
				$this->device->identified |= Constants\Id::MATCH_UA;
				$this->device->generic = false;
			}

			/****************************************************
			 *		Winbox Evo2
			 */

			if (preg_match('/Winbox Evo2/u', $ua)) {
				unset($this->os->name);
				unset($this->os->version);

				$this->device->manufacturer = 'Winbox';
				$this->device->model = 'Evo2';
				$this->device->type = Constants\DeviceType::TELEVISION;
				$this->device->identified |= Constants\Id::MATCH_UA;
				$this->device->generic = false;
			}

			/****************************************************
			 *		DuneHD
			 */

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

			/****************************************************
			 *		Roku
			 */

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


			/****************************************************
			 *		AppleTV
			 */

			if (preg_match('/AppleTV[0-9],[0-9]/u', $ua)) {
				unset($this->os->name);
				unset($this->os->version);

				$this->device->manufacturer = 'Apple';
				$this->device->model = 'AppleTV';
				$this->device->type = Constants\DeviceType::TELEVISION;
				$this->device->identified |= Constants\Id::MATCH_UA;
				$this->device->generic = false;
			}


			/****************************************************
			 *		WebTV
			 */

			if (preg_match('/WebTV\/[0-9.]/u', $ua)) {
				unset($this->os->name);
				unset($this->os->version);

				$this->device->manufacturer = 'Microsoft';
				$this->device->model = 'WebTV';
				$this->device->type = Constants\DeviceType::TELEVISION;
				$this->device->identified |= Constants\Id::MATCH_UA;
				$this->device->generic = false;
			}


			/****************************************************
			 *		OpenTV
			 */

			if (preg_match('/OpenTV/u', $ua)) {
				$this->device->series = 'OpenTV';
				$this->device->type = Constants\DeviceType::TELEVISION;
			}


			/****************************************************
			 *		MediStream
			 */

			if (preg_match('/MediStream/u', $ua)) {
				unset($this->os->name);
				unset($this->os->version);

				$this->device->manufacturer = 'Bewatec';
				$this->device->model = 'MediStream';
				$this->device->type = Constants\DeviceType::TELEVISION;
				$this->device->identified |= Constants\Id::MATCH_UA;
				$this->device->generic = false;
			}


			/****************************************************
			 *		BrightSign
			 */

			if (preg_match('/BrightSign\/[0-9\.]+(?:-[a-z0-9\-]+)? \(([^\)]+)/u', $ua, $match)) {
				unset($this->os->name);
				unset($this->os->version);

				$this->device->manufacturer = 'BrightSign';
				$this->device->model = $match[1];
				$this->device->type = Constants\DeviceType::SIGNAGE;
				$this->device->identified |= Constants\Id::MATCH_UA;
				$this->device->generic = false;
			}


			/****************************************************
			 *		Iadea
			 */

			if (preg_match('/ADAPI/u', $ua) && preg_match('/\(MODEL:([^\)]+)\)/u', $ua, $match)) {
				unset($this->os->name);
				unset($this->os->version);

				$this->device->manufacturer = 'Iadea';
				$this->device->model = $match[1];
				$this->device->type = Constants\DeviceType::SIGNAGE;
				$this->device->identified |= Constants\Id::MATCH_UA;
				$this->device->generic = false;
			}


			/****************************************************
			 *		Generic
			 */

			if ($this->device->type == Constants\DeviceType::TELEVISION) {

				/* Drop OS */
				if (isset($this->os->name) && !in_array($this->os->name, [ 'Aliyun OS', 'Tizen', 'Android', 'Google TV', 'Firefox OS' ])) {
					unset($this->os->name);
					unset($this->os->version);
				}


				/* Format model numbers */
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

						if (preg_match('/((?:ID|SL)[0-9]+)/u', $ua, $match)) {
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




			/****************************************************
			 *		Detect type based on common identifiers
			 */

			if (preg_match('/SmartTvA\//u', $ua)) {
				$this->device->type = Constants\DeviceType::TELEVISION;
			}

			if (preg_match('/NETRANGEMMH/u', $ua)) {
				$this->device->type = Constants\DeviceType::TELEVISION;
			}

			if (preg_match('/MIDP/u', $ua)) {
				$this->device->type = Constants\DeviceType::MOBILE;
			}

			/****************************************************
			 *		Try to detect any devices based on common
			 *		locations of model ids
			 */

			if (!isset($this->device->model) && !isset($this->device->manufacturer)) {
				$candidates = [];

				if (!preg_match('/^(Mozilla|Opera)/u', $ua)) if (preg_match('/^(?:MQQBrowser\/[0-9\.]+\/)?([^\s]+)/u', $ua, $match)) {
					$match[1] = preg_replace('/_TD$/u', '', $match[1]);
					$match[1] = preg_replace('/_CMCC$/u', '', $match[1]);
					$match[1] = preg_replace('/[_ ]Mozilla$/u', '', $match[1]);
					$match[1] = preg_replace('/ Linux$/u', '', $match[1]);
					$match[1] = preg_replace('/ Opera$/u', '', $match[1]);
					$match[1] = preg_replace('/\/[0-9].*$/u', '', $match[1]);

					array_push($candidates, $match[1]);
				}

				if (preg_match('/^((?:SAMSUNG|TCL|ZTE) [^\s]+)/u', $ua, $match)) {
					array_push($candidates, $match[1]);
				}

				if (preg_match('/(Samsung (?:GT|SCH|SGH|SHV|SHW|SPH)-[A-Z-0-9]+)/ui', $ua, $match)) {
					array_push($candidates, $match[1]);
				}

				if (preg_match('/[0-9]+x[0-9]+; ([^;]+)/u', $ua, $match)) {
					array_push($candidates, $match[1]);
				}

				if (preg_match('/[0-9]+x[0-9]+; [^;]+; ([^;]+)/u', $ua, $match)) {
					array_push($candidates, $match[1]);
				}

				if (preg_match('/\s*([^;]*[^\s])\s*; [0-9]+\*[0-9]+\)/u', $ua, $match)) {
					array_push($candidates, $match[1]);
				}

				if (preg_match('/[0-9]+X[0-9]+ ([^;\/\(\)]+)/u', $ua, $match)) {
					array_push($candidates, $match[1]);
				}

				if (preg_match('/Windows NT 5.1; ([^;]+); Windows Phone/u', $ua, $match)) {
					array_push($candidates, $match[1]);
				}

				if (preg_match('/\) PPC; (?:[0-9]+x[0-9]+; )?([^;\/\(\)]+)/u', $ua, $match)) {
					array_push($candidates, $match[1]);
				}

				if (preg_match('/Windows Mobile; ([^;]+); PPC;/u', $ua, $match)) {
					array_push($candidates, $match[1]);
				}

				if (preg_match('/\(([^;]+); U; Windows Mobile/u', $ua, $match)) {
					array_push($candidates, $match[1]);
				}

				if (preg_match('/MSIEMobile [0-9.]+\) ([^\s]+)/u', $ua, $match)) {
					array_push($candidates, $match[1]);
				}

				if (preg_match('/Series60\/[0-9\.]+ ([^\s]+) Profile/u', $ua, $match)) {
					array_push($candidates, $match[1]);
				}

				if (preg_match('/Vodafone\/1.0\/([^\/]+)/u', $ua, $match)) {
					array_push($candidates, $match[1]);
				}

				if (preg_match('/Huawei\/1.0\/([^\s]+)/u', $ua, $match)) {
					array_push($candidates, $match[1]);
				}

				if (preg_match('/^(DoCoMo[^(]+)/u', $ua, $match)) {
					array_push($candidates, $match[1]);
				}

				if (preg_match('/\ ([^\s]+)$/u', $ua, $match)) {
					array_push($candidates, $match[1]);
				}

				if (preg_match('/; ([^;\)]+)\)/u', $ua, $match)) {
					array_push($candidates, $match[1]);
				}

				if (preg_match('/^(.*)\/UCWEB/u', $ua, $match)) {
					array_push($candidates, $match[1]);
				}

				if (preg_match('/^([^\s]+\s[^\s]+)\s+Opera/u', $ua, $match)) {
					array_push($candidates, $match[1]);
				}

				if (preg_match('/^([a-z0-9\.\_\-\+\/ ]+) Linux/iu', $ua, $match)) {
					array_push($candidates, $match[1]);
				}

				if (preg_match('/^([a-z0-9\.\_\-\+\/ ]+) Android/iu', $ua, $match)) {
					array_push($candidates, $match[1]);
				}

				if (preg_match('/\(([a-z0-9\.\_\-\+\/ ]+) Browser/iu', $ua, $match)) {
					array_push($candidates, $match[1]);
				}

				if (preg_match('/^([a-z0-9\.\_\-\+\/ ]+) Release/iu', $ua, $match)) {
					array_push($candidates, $match[1]);
				}

				if (preg_match('/Mozilla\/[0-9.]+ ([a-z0-9\.\-\_\+\/ ]+) Browser/iu', $ua, $match)) {
					array_push($candidates, $match[1]);
				}

				if (preg_match('/ \(([^\)]+)\)/u', $ua, $match)) {
					array_push($candidates, $match[1]);
				}

				if (preg_match('/([a-z][a-z0-9\_]+)\/[a-z]/iu', $ua, $match)) {
					array_push($candidates, $match[1]);
				}

				if (preg_match('/^([a-z0-9\.\_\+\/ ]+)_TD\//iu', $ua, $match)) {
					array_push($candidates, $match[1]);
				}

				if (preg_match('/^$([a-z0-9\.\_\+ ]+)\//iu', $ua, $match)) {
					array_push($candidates, $match[1]);
				}

				if (preg_match('/^([a-z]+\s[a-z0-9\-\_\.]+)/iu', $ua, $match)) {
					array_push($candidates, $match[1]);
				}

				if (isset($this->os->name)) {
					for ($i = 0; $i < count($candidates); $i++) {
						$result = false;

						if (!isset($this->device->model) && !isset($this->device->manufacturer)) {
							if (isset($this->os->name) && ($this->os->name == 'Android' || $this->os->name == 'Linux')) {
								$device = Data\DeviceModels::identify('android', $candidates[$i]);
								if ($device->identified) {
									$result = true;

									$device->identified |= $this->device->identified;
									$this->device = $device;

									if ($this->os->name != 'Android') {
										$this->os->name = 'Android';
										$this->os->version = null;
									}
								}
							}

							if (!isset($this->os->name) || $this->os->name == 'Windows' || $this->os->name == 'Windows Mobile' || $this->os->name == 'Windows CE') {
								$device = Data\DeviceModels::identify('wm', $candidates[$i]);
								if ($device->identified) {
									$result = true;

									$device->identified |= $this->device->identified;
									$this->device = $device;

									if (isset($this->os->name) && $this->os->name != 'Windows Mobile') {
										$this->os->name = 'Windows Mobile';
										$this->os->version = null;
									}
								}
							}
						}
					}
				}

				if (!isset($this->device->model) && !isset($this->device->manufacturer)) {
					$identified = false;

					for ($i = 0; $i < count($candidates); $i++) {
						if (!$this->device->identified) {
							if (preg_match('/^acer_([^\/]*)/ui', $candidates[$i], $match)) {
								$this->device->manufacturer = 'Acer';
								$this->device->model = Data\DeviceModels::cleanup($match[1]);
								$this->device->type = Constants\DeviceType::MOBILE;
								$this->device->generic = false;
								$identified = true;
							}

							if (preg_match('/^AIRNESS-([^\/]*)/ui', $candidates[$i], $match)) {
								$this->device->manufacturer = 'Airness';
								$this->device->model = Data\DeviceModels::cleanup($match[1]);
								$this->device->type = Constants\DeviceType::MOBILE;
								$this->device->generic = false;
								$identified = true;
							}

							if (preg_match('/^ALCATEL[_-]([^\/]*)/ui', $candidates[$i], $match)) {
								$this->device->manufacturer = 'Alcatel';
								$this->device->model = Data\DeviceModels::cleanup($match[1]);
								$this->device->type = Constants\DeviceType::MOBILE;
								$this->device->generic = false;

								if (preg_match('/^TRIBE ([^\s]+)/ui', $this->device->model, $match)) {
									$this->device->model = 'One Touch Tribe ' . $match[1];
								}

								elseif (preg_match('/^ONE TOUCH ([^\s]*)/ui', $this->device->model, $match)) {
									$this->device->model = 'One Touch ' . $match[1];
								}

								elseif (preg_match('/^OT[-\s]*([^\s]*)/ui', $this->device->model, $match)) {
									$this->device->model = 'One Touch ' . $match[1];
								}

								$identified = true;
							}

							if (preg_match('/^BenQ-([^\/]*)/ui', $candidates[$i], $match)) {
								$this->device->manufacturer = 'BenQ';
								$this->device->model = Data\DeviceModels::cleanup($match[1]);
								$this->device->type = Constants\DeviceType::MOBILE;
								$this->device->generic = false;
								$identified = true;
							}

							if (preg_match('/^Bird[ _]([^\/]*)/ui', $candidates[$i], $match)) {
								$this->device->manufacturer = 'Bird';
								$this->device->model = Data\DeviceModels::cleanup($match[1]);
								$this->device->type = Constants\DeviceType::MOBILE;
								$this->device->generic = false;
								$identified = true;
							}

							if (preg_match('/^(?:YL-|YuLong-)?COOLPAD([^\s]+)/ui', $candidates[$i], $match)) {
								$this->device->manufacturer = 'Coolpad';
								$this->device->model = Data\DeviceModels::cleanup($match[1]);
								$this->device->type = Constants\DeviceType::MOBILE;
								$this->device->generic = false;
								$identified = true;
							}

							if (preg_match('/^CELKON\.([^\s]+)/ui', $candidates[$i], $match)) {
								$this->device->manufacturer = 'Celkon';
								$this->device->model = Data\DeviceModels::cleanup($match[1]);
								$this->device->type = Constants\DeviceType::MOBILE;
								$this->device->generic = false;
								$identified = true;
							}

							if (preg_match('/^Coship ([^\s]+)/ui', $candidates[$i], $match)) {
								$this->device->manufacturer = 'Coship';
								$this->device->model = Data\DeviceModels::cleanup($match[1]);
								$this->device->type = Constants\DeviceType::MOBILE;
								$this->device->generic = false;
								$identified = true;
							}

							if (preg_match('/^Cricket-([^\s]+)/ui', $candidates[$i], $match)) {
								$this->device->manufacturer = 'Cricket';
								$this->device->model = Data\DeviceModels::cleanup($match[1]);
								$this->device->type = Constants\DeviceType::MOBILE;
								$this->device->generic = false;
								$identified = true;
							}

							if (preg_match('/^DESAY[ _]([^\s]+)/ui', $candidates[$i], $match)) {
								$this->device->manufacturer = 'DESAY';
								$this->device->model = Data\DeviceModels::cleanup($match[1]);
								$this->device->type = Constants\DeviceType::MOBILE;
								$this->device->generic = false;
								$identified = true;
							}

							if (preg_match('/^Diamond_([^\s]+)/ui', $candidates[$i], $match)) {
								$this->device->manufacturer = 'Diamond';
								$this->device->model = Data\DeviceModels::cleanup($match[1]);
								$this->device->type = Constants\DeviceType::MOBILE;
								$this->device->generic = false;
								$identified = true;
							}

							if (preg_match('/^DoCoMo\/[0-9\.]+[ \/]([^\s\/]+)/ui', $candidates[$i], $match)) {
								$this->device->manufacturer = 'DoCoMo';
								$this->device->model = Data\DeviceModels::cleanup($match[1]);
								$this->device->type = Constants\DeviceType::MOBILE;
								$this->device->generic = false;
								$identified = true;
							}

							if (preg_match('/^dopod[-_]?([^\s]+)/ui', $candidates[$i], $match)) {
								$this->device->manufacturer = 'Dopod';
								$this->device->model = Data\DeviceModels::cleanup($match[1]);
								$this->device->type = Constants\DeviceType::MOBILE;
								$this->device->generic = false;
								$identified = true;
							}

							if (preg_match('/^FLY_]?([^\s\/]+)/ui', $candidates[$i], $match)) {
								$this->device->manufacturer = 'Fly';
								$this->device->model = Data\DeviceModels::cleanup($match[1]);
								$this->device->type = Constants\DeviceType::MOBILE;
								$this->device->generic = false;
								$identified = true;
							}

							if (preg_match('/^GIONEE[-_ ]([^\s\/]+)/ui', $candidates[$i], $match)) {
								$this->device->manufacturer = 'Gionee';
								$this->device->model = Data\DeviceModels::cleanup($match[1]);
								$this->device->type = Constants\DeviceType::MOBILE;
								$this->device->generic = false;
								$identified = true;
							}

							if (preg_match('/^GIONEE([A-Z0-9]+)/ui', $candidates[$i], $match)) {
								$this->device->manufacturer = 'Gionee';
								$this->device->model = Data\DeviceModels::cleanup($match[1]);
								$this->device->type = Constants\DeviceType::MOBILE;
								$this->device->generic = false;
								$identified = true;
							}

							if (preg_match('/^HIKe_([^\s]+)/ui', $candidates[$i], $match)) {
								$this->device->manufacturer = 'HIKe';
								$this->device->model = Data\DeviceModels::cleanup($match[1]);
								$this->device->type = Constants\DeviceType::MOBILE;
								$this->device->generic = false;
								$identified = true;
							}

							if (preg_match('/^Hisense[ -](?:HS-)?([^\s]+)/ui', $candidates[$i], $match)) {
								$this->device->manufacturer = 'Hisense';
								$this->device->model = Data\DeviceModels::cleanup($match[1]);
								$this->device->type = Constants\DeviceType::MOBILE;
								$this->device->generic = false;
								$identified = true;
							}

							if (preg_match('/^HS-([^\s]+)/ui', $candidates[$i], $match)) {
								$this->device->manufacturer = 'Hisense';
								$this->device->model = Data\DeviceModels::cleanup($match[1]);
								$this->device->type = Constants\DeviceType::MOBILE;
								$this->device->generic = false;
								$identified = true;
							}

							if (preg_match('/^HTC[_-]?([^\/_]+)(?:\/|_|$)/ui', $candidates[$i], $match)) {
								$this->device->manufacturer = 'HTC';
								$this->device->model = Data\DeviceModels::cleanup($match[1]);
								$this->device->type = Constants\DeviceType::MOBILE;
								$this->device->generic = false;
								$identified = true;
							}

							if (preg_match('/^HUAWEI[\s_-]?([^\/]*)/ui', $candidates[$i], $match)) {
								$this->device->manufacturer = 'Huawei';
								$this->device->model = Data\DeviceModels::cleanup($match[1]);
								$this->device->type = Constants\DeviceType::MOBILE;
								$this->device->generic = false;
								$identified = true;
							}

							if (preg_match('/^Karbonn ([^\s]+)/ui', $candidates[$i], $match)) {
								$this->device->manufacturer = 'Karbonn';
								$this->device->model = Data\DeviceModels::cleanup($match[1]);
								$this->device->type = Constants\DeviceType::MOBILE;
								$this->device->generic = false;
								$identified = true;
							}

							if (preg_match('/^KDDI-([^\s;]+)/ui', $candidates[$i], $match)) {
								$this->device->manufacturer = 'KDDI';
								$this->device->model = Data\DeviceModels::cleanup($match[1]);
								$this->device->type = Constants\DeviceType::MOBILE;
								$this->device->generic = false;
								$identified = true;
							}

							if (preg_match('/^KONKA[-_]?([^\s]+)/ui', $candidates[$i], $match)) {
								$this->device->manufacturer = 'Konka';
								$this->device->model = Data\DeviceModels::cleanup($match[1]);
								$this->device->type = Constants\DeviceType::MOBILE;
								$this->device->generic = false;
								$identified = true;
							}

							if (preg_match('/^TIANYU-KTOUCH\/([^\/]+)/ui', $candidates[$i], $match)) {
								$this->device->manufacturer = 'K-Touch';
								$this->device->model = Data\DeviceModels::cleanup($match[1]);
								$this->device->type = Constants\DeviceType::MOBILE;
								$this->device->generic = false;
								$identified = true;
							}

							if (preg_match('/^K-Touch_?([^\/]*)/ui', $candidates[$i], $match)) {
								$this->device->manufacturer = 'K-Touch';
								$this->device->model = Data\DeviceModels::cleanup($match[1]);
								$this->device->type = Constants\DeviceType::MOBILE;
								$this->device->generic = false;
								$identified = true;
							}

							if (preg_match('/^Lenovo-([^\/]*)/ui', $candidates[$i], $match)) {
								$this->device->manufacturer = 'Lenovo';
								$this->device->model = Data\DeviceModels::cleanup($match[1]);
								$this->device->type = Constants\DeviceType::MOBILE;
								$this->device->generic = false;
								$identified = true;
							}

							if (preg_match('/^Lephone_([^\/]*)/ui', $candidates[$i], $match)) {
								$this->device->manufacturer = 'Lephone';
								$this->device->model = Data\DeviceModels::cleanup($match[1]);
								$this->device->type = Constants\DeviceType::MOBILE;
								$this->device->generic = false;
								$identified = true;
							}

							if (preg_match('/(?:^|\()LGE?(?:\/|-|_|\s)([^\s]*)/ui', $candidates[$i], $match)) {
								$this->device->manufacturer = 'LG';
								$this->device->model = Data\DeviceModels::cleanup($match[1]);
								$this->device->type = Constants\DeviceType::MOBILE;
								$this->device->generic = false;
								$identified = true;
							}

							if (preg_match('/^MOT-([^\/_]+)(?:\/|_|$)/ui', $candidates[$i], $match)) {
								$this->device->manufacturer = 'Motorola';
								$this->device->model = Data\DeviceModels::cleanup($match[1]);
								$this->device->type = Constants\DeviceType::MOBILE;
								$this->device->generic = false;
								$identified = true;
							}

							if (preg_match('/^Motorola_([^\/_]+)(?:\/|_|$)/ui', $candidates[$i], $match)) {
								$this->device->manufacturer = 'Motorola';
								$this->device->model = Data\DeviceModels::cleanup($match[1]);
								$this->device->type = Constants\DeviceType::MOBILE;
								$this->device->generic = false;
								$identified = true;
							}

							if (preg_match('/^Nokia-?([^\/]+)(?:\/|$)/ui', $candidates[$i], $match)) {
								$this->device->manufacturer = 'Nokia';

								if ($match[1] != 'Browser') {
									$this->device->model = Data\DeviceModels::cleanup($match[1]);
									$this->device->type = Constants\DeviceType::MOBILE;
									$this->device->identified = false;
									$this->device->generic = false;
									$identified = true;

									if (!$this->device->identified) {
										$device = Data\DeviceModels::identify('s60', $this->device->model);
										if ($device->identified) {
											$device->identified |= $this->device->identified;
											$this->device = $device;

											if (!isset($this->os->name) || $this->os->name != 'Series60') {
												$this->os->name = 'Series60';
												$this->os->version = null;
											}
										}
									}

									if (!$this->device->identified) {
										$device = Data\DeviceModels::identify('s40', $this->device->model);
										if ($device->identified) {
											$device->identified |= $this->device->identified;
											$this->device = $device;

											if (!isset($this->os->name) || $this->os->name != 'Series40') {
												$this->os->name = 'Series40';
												$this->os->version = null;
											}
										}
									}

									if (!$this->device->identified) {
										$device = Data\DeviceModels::identify('asha', $this->device->model);
										if ($device->identified) {
											$device->identified |= $this->device->identified;
											$this->device = $device;

											if (!isset($this->os->name) || $this->os->name != 'Nokia Asha Platform') {
												$this->os->name = 'Nokia Asha Platform';
												$this->os->version = new Version([ 'value' => '1.0' ]);

												if (preg_match('/java_runtime_version=Nokia_Asha_([0-9_]+);/u', $ua, $match)) {
													$this->os->version = new Version([ 'value' => str_replace('_', '.', $match[1]) ]);
												}
											}
										}
									}
								}
							}

							if (preg_match('/^Nexian([^\/_]+)(?:\/|_|$)/ui', $candidates[$i], $match)) {
								$this->device->manufacturer = 'Nexian';
								$this->device->model = Data\DeviceModels::cleanup($match[1]);
								$this->device->type = Constants\DeviceType::MOBILE;
								$this->device->generic = false;
								$identified = true;
							}

							if (preg_match('/^NGM_([^\/_]+)(?:\/|_|$)/ui', $candidates[$i], $match)) {
								$this->device->manufacturer = 'NGM';
								$this->device->model = Data\DeviceModels::cleanup($match[1]);
								$this->device->type = Constants\DeviceType::MOBILE;
								$this->device->generic = false;
								$identified = true;
							}

							if (preg_match('/^OPPO_([^\/_]+)(?:\/|_|$)/ui', $candidates[$i], $match)) {
								$this->device->manufacturer = 'Oppo';
								$this->device->model = Data\DeviceModels::cleanup($match[1]);
								$this->device->type = Constants\DeviceType::MOBILE;
								$this->device->generic = false;
								$identified = true;
							}

							if (preg_match('/^Pantech-?([^\/_]+)(?:\/|_|$)/ui', $candidates[$i], $match)) {
								$this->device->manufacturer = 'Pantech';
								$this->device->model = Data\DeviceModels::cleanup($match[1]);
								$this->device->type = Constants\DeviceType::MOBILE;
								$this->device->generic = false;
								$identified = true;
							}

							if (preg_match('/^Philips([^\/_\s]+)/ui', $candidates[$i], $match)) {
								$this->device->manufacturer = 'Philips';
								$this->device->model = Data\DeviceModels::cleanup($match[1]);
								$this->device->type = Constants\DeviceType::MOBILE;
								$this->device->generic = false;
								$identified = true;
							}

							if (preg_match('/^sam-([A-Z][0-9]+)$/ui', $candidates[$i], $match)) {
								$this->device->manufacturer = 'Samsung';
								$this->device->model = Data\DeviceModels::cleanup('sam-' . $match[1]);
								$this->device->type = Constants\DeviceType::MOBILE;
								$this->device->identified = false;
								$this->device->generic = false;
								$identified = true;
							}

							if (preg_match('/^(SH[0-9]+[A-Z])$/ui', $candidates[$i], $match)) {
								$this->device->manufacturer = 'Sharp';
								$this->device->model = Data\DeviceModels::cleanup($match[1]);
								$this->device->type = Constants\DeviceType::MOBILE;
								$this->device->identified = false;
								$this->device->generic = false;
								$identified = true;
							}

							if (preg_match('/^SE([A-Z][0-9]+[a-z])$/ui', $candidates[$i], $match)) {
								$this->device->manufacturer = 'Sony Ericsson';
								$this->device->model = Data\DeviceModels::cleanup($match[1]);
								$this->device->type = Constants\DeviceType::MOBILE;
								$this->device->identified = false;
								$this->device->generic = false;
								$identified = true;
							}

							if (preg_match('/^SonyEricsson([^\/_]+)(?:\/|_|$)/ui', $candidates[$i], $match)) {
								$this->device->manufacturer = 'Sony Ericsson';
								$this->device->model = Data\DeviceModels::cleanup($match[1]);
								$this->device->type = Constants\DeviceType::MOBILE;
								$this->device->identified = false;
								$this->device->generic = false;
								$identified = true;

								if (preg_match('/^[a-z][0-9]+/u', $this->device->model)) {
									$this->device->model[0] = strtoupper($this->device->model[0]);
								}

								if (isset($this->os->name) && $this->os->name == 'Series60') {
									$device = Data\DeviceModels::identify('s60', $this->device->model);
									if ($device->identified) {
										$device->identified |= $this->device->identified;
										$this->device = $device;
									}
								}
							}

							if (preg_match('/^Spice\s?([A-Z][0-9]+)/ui', $candidates[$i], $match)) {
								$this->device->manufacturer = 'Spice';
								$this->device->model = Data\DeviceModels::cleanup($match[1]);
								$this->device->type = Constants\DeviceType::MOBILE;
								$this->device->generic = false;
								$identified = true;
							}

							if (preg_match('/^Tecno([^\/]*)/ui', $candidates[$i], $match)) {
								$this->device->manufacturer = 'Tecno';
								$this->device->model = Data\DeviceModels::cleanup($match[1]);
								$this->device->type = Constants\DeviceType::MOBILE;
								$this->device->generic = false;
								$identified = true;
							}

							if (preg_match('/^T-smart_([^\/]*)/ui', $candidates[$i], $match)) {
								$this->device->manufacturer = 'T-smart';
								$this->device->model = Data\DeviceModels::cleanup($match[1]);
								$this->device->type = Constants\DeviceType::MOBILE;
								$this->device->generic = false;
								$identified = true;
							}

							if (preg_match('/^TCL[-_ ]([^\/]*)/ui', $candidates[$i], $match)) {
								$this->device->manufacturer = 'TCL';
								$this->device->model = Data\DeviceModels::cleanup($match[1]);
								$this->device->type = Constants\DeviceType::MOBILE;
								$this->device->generic = false;
								$identified = true;
							}

							if (preg_match('/^Tiphone ([^\/]*)/ui', $candidates[$i], $match)) {
								$this->device->manufacturer = 'TiPhone';
								$this->device->model = Data\DeviceModels::cleanup($match[1]);
								$this->device->type = Constants\DeviceType::MOBILE;
								$this->device->generic = false;
								$identified = true;
							}

							if (preg_match('/^Toshiba[\/-]([^\/-]*)/ui', $candidates[$i], $match)) {
								$this->device->manufacturer = 'Toshiba';
								$this->device->model = Data\DeviceModels::cleanup($match[1]);
								$this->device->type = Constants\DeviceType::MOBILE;
								$this->device->generic = false;
								$identified = true;
							}

							if (preg_match('/^SHARP[-_\/]([^\/]*)/ui', $candidates[$i], $match)) {
								$this->device->manufacturer = 'Sharp';
								$this->device->model = Data\DeviceModels::cleanup($match[1]);
								$this->device->type = Constants\DeviceType::MOBILE;
								$this->device->generic = false;
								$identified = true;
							}

							if (preg_match('/^SAMSUNG[-\/ ]?([^\/_]+)(?:\/|_|$)/ui', $candidates[$i], $match)) {
								$this->device->manufacturer = 'Samsung';
								$this->device->model = Data\DeviceModels::cleanup($match[1]);
								$this->device->type = Constants\DeviceType::MOBILE;
								$this->device->identified = false;
								$this->device->generic = false;
								$identified = true;

								if (isset($this->os->name) && $this->os->name == 'Bada') {
									$device = Data\DeviceModels::identify('bada', $this->device->model);
									if ($device->identified) {
										$device->identified |= $this->device->identified;
										$this->device = $device;
									}
								}

								else if (isset($this->os->name) && $this->os->name == 'Series60') {
									$device = Data\DeviceModels::identify('s60', $this->device->model);
									if ($device->identified) {
										$device->identified |= $this->device->identified;
										$this->device = $device;
									}
								}

								else if (preg_match('/Jasmine\/([0-9.]*)/u', $ua, $match)) {
									$version = $match[1];

									$device = Data\DeviceModels::identify('touchwiz', $this->device->model);
									if ($device->identified) {
										$device->identified |= $this->device->identified;
										$this->device = $device;
										$this->os->name = 'Touchwiz';

										switch($version) {
											case '0.8':		$this->os->version = new Version([ 'value' => '1.0' ]); break;
											case '1.0':		$this->os->version = new Version([ 'value' => '2.0', 'alias' => '2.0 or earlier' ]); break;
											case '2.0':		$this->os->version = new Version([ 'value' => '3.0' ]); break;
										}
									}
								}

								else if (preg_match('/(?:Dolfin\/([0-9.]*)|Browser\/Dolfin([0-9.]*))/u', $ua, $match)) {
									$version = $match[1] || $match[2];

									$device = Data\DeviceModels::identify('bada', $this->device->model);
									if ($device->identified) {
										$device->identified |= $this->device->identified;
										$this->device = $device;
										$this->os->name = 'Bada';

										switch($version) {
											case '2.0':		$this->os->version = new Version([ 'value' => '1.0' ]); break;
											case '2.2':		$this->os->version = new Version([ 'value' => '1.2' ]); break;
											case '3.0':		$this->os->version = new Version([ 'value' => '2.0' ]); break;
										}
									}

									else {
										$device = Data\DeviceModels::identify('touchwiz', $this->device->model);
										if ($device->identified) {
										$device->identified |= $this->device->identified;
											$this->device = $device;
											$this->os->name = 'Touchwiz';

											switch($version) {
												case '1.5':		$this->os->version = new Version([ 'value' => '2.0' ]); break;
												case '2.0':		$this->os->version = new Version([ 'value' => '3.0' ]); break;
											}
										}
									}
								}
							}

							if (preg_match('/^Spice\s([^\s]+)/ui', $candidates[$i], $match)) {
								$this->device->manufacturer = 'Spice';
								$this->device->model = Data\DeviceModels::cleanup($match[1]);
								$this->device->type = Constants\DeviceType::MOBILE;
								$this->device->generic = false;
								$identified = true;
							}

							if (preg_match('/^UTStar-([^\s]+)/ui', $candidates[$i], $match)) {
								$this->device->manufacturer = 'UTStar';
								$this->device->model = Data\DeviceModels::cleanup($match[1]);
								$this->device->type = Constants\DeviceType::MOBILE;
								$this->device->generic = false;
								$identified = true;
							}

							if (preg_match('/^vk-(vk[0-9]+)/ui', $candidates[$i], $match)) {
								$this->device->manufacturer = 'VK Mobile';
								$this->device->model = Data\DeviceModels::cleanup(strtoupper($match[1]));
								$this->device->type = Constants\DeviceType::MOBILE;
								$this->device->generic = false;
								$identified = true;
							}

							if (preg_match('/^Xiaomi[_]?([^\s]+)/ui', $candidates[$i], $match)) {
								$this->device->manufacturer = 'Xiaomi';
								$this->device->model = Data\DeviceModels::cleanup($match[1]);
								$this->device->type = Constants\DeviceType::MOBILE;
								$this->device->generic = false;
								$identified = true;
							}

							if (preg_match('/^ZTE[-_]?([^\s]+)/ui', $candidates[$i], $match)) {
								$this->device->manufacturer = 'ZTE';
								$this->device->model = Data\DeviceModels::cleanup($match[1]);
								$this->device->type = Constants\DeviceType::MOBILE;
								$this->device->generic = false;
								$identified = true;
							}
						}
					}

					if ($identified && !$this->device->identified) {
						if (!$this->device->identified) {
							$device = Data\DeviceModels::identify('bada', $this->device->model);
							if ($device->identified) {
								$device->identified |= $this->device->identified;
								$this->device = $device;
								$this->os->name = 'Bada';
							}
						}

						if (!$this->device->identified) {
							$device = Data\DeviceModels::identify('touchwiz', $this->device->model);
							if ($device->identified) {
								$device->identified |= $this->device->identified;
								$this->device = $device;
								$this->os->name = 'Touchwiz';
							}
						}

						if (!$this->device->identified) {
							$device = Data\DeviceModels::identify('wp', $this->device->model);
							if ($device->identified) {
								$device->identified |= $this->device->identified;
								$this->device = $device;
								$this->os->name = 'Windows Phone';
							}
						}

						if (!$this->device->identified) {
							$device = Data\DeviceModels::identify('wm', $this->device->model);
							if ($device->identified) {
								$device->identified |= $this->device->identified;
								$this->device = $device;
								$this->os->name = 'Windows Mobile';
							}
						}

						if (!$this->device->identified) {
							$device = Data\DeviceModels::identify('android', $this->device->model);
							if ($device->identified) {
								$device->identified |= $this->device->identified;
								$this->device = $device;

								if (!isset($this->os->name) || ($this->os->name != 'Android' && (!isset($this->os->family) || $this->os->family != 'Android'))) {
									$this->os->name = 'Android';
								}
							}
						}

						if (!$this->device->identified) {
							$device = Data\DeviceModels::identify('brew', $this->device->model);
							if ($device->identified) {
								$device->identified |= $this->device->identified;
								$this->device = $device;
								$this->os->name = 'Brew';
							}
						}

						if (!$this->device->identified) {
							$device = Data\DeviceModels::identify('feature', $this->device->model);
							if ($device->identified) {
								$device->identified |= $this->device->identified;
								$this->device = $device;
							}
						}
					}

					if ($identified && !$this->device->identified) {
						if (!$this->device->identified) {
							$device = Data\DeviceModels::identify('bada', $this->device->manufacturer . ' ' . $this->device->model);
							if ($device->identified) {
								$device->identified |= $this->device->identified;
								$this->device = $device;
								$this->os->name = 'Bada';
							}
						}

						if (!$this->device->identified) {
							$device = Data\DeviceModels::identify('touchwiz', $this->device->manufacturer . ' ' . $this->device->model);
							if ($device->identified) {
								$device->identified |= $this->device->identified;
								$this->device = $device;
								$this->os->name = 'Touchwiz';
							}
						}

						if (!$this->device->identified) {
							$device = Data\DeviceModels::identify('wp', $this->device->manufacturer . ' ' . $this->device->model);
							if ($device->identified) {
								$device->identified |= $this->device->identified;
								$this->device = $device;
								$this->os->name = 'Windows Phone';
							}
						}

						if (!$this->device->identified) {
							$device = Data\DeviceModels::identify('wm', $this->device->manufacturer . ' ' . $this->device->model);
							if ($device->identified) {
								$device->identified |= $this->device->identified;
								$this->device = $device;
								$this->os->name = 'Windows Mobile';
							}
						}

						if (!$this->device->identified) {
							$device = Data\DeviceModels::identify('android', $this->device->manufacturer . ' ' . $this->device->model);
							if ($device->identified) {
								$device->identified |= $this->device->identified;
								$this->device = $device;

								if (!isset($this->os->name)) {
									$this->os->name = 'Android';
								}
							}
						}

						if (!$this->device->identified) {
							$device = Data\DeviceModels::identify('feature', $this->device->manufacturer . ' ' . $this->device->model);
							if ($device->identified) {
								$device->identified |= $this->device->identified;
								$this->device = $device;
							}
						}
					}

					if ($identified) {
						$this->device->identified |= Constants\Id::PATTERN;
					}
				}
			}


			if (preg_match('/\(([A-Z][0-9]+[A-Z])[^;]*; ?FOMA/ui', $ua, $match)) {
				$this->device->manufacturer = 'DoCoMo';
				$this->device->model = Data\DeviceModels::cleanup($match[1]);
				$this->device->type = Constants\DeviceType::MOBILE;
				$this->device->identified |= Constants\Id::PATTERN;
				$this->device->generic = false;
			}

			if (preg_match('/DoCoMo\/[0-9.]+\/([A-Z][0-9]+[A-Z])[^\/]*\//ui', $ua, $match)) {
				$this->device->manufacturer = 'DoCoMo';
				$this->device->model = Data\DeviceModels::cleanup($match[1]);
				$this->device->type = Constants\DeviceType::MOBILE;
				$this->device->identified |= Constants\Id::PATTERN;
				$this->device->generic = false;
			}

			if (preg_match('/J-PHONE\/[^\/]+\/([^\/]+)\//u', $ua, $match)) {
				$this->device->manufacturer = 'Softbank';
				$this->device->model = Data\DeviceModels::cleanup($match[1]);
				$this->device->type = Constants\DeviceType::MOBILE;
				$this->device->identified |= Constants\Id::PATTERN;
				$this->device->generic = false;
			}

			if (preg_match('/SoftBank\/[^\/]+\/([^\/]+)\//u', $ua, $match)) {
				$this->device->manufacturer = 'Softbank';
				$this->device->model = Data\DeviceModels::cleanup($match[1]);
				$this->device->type = Constants\DeviceType::MOBILE;
				$this->device->identified |= Constants\Id::PATTERN;
				$this->device->generic = false;
			}

			if (preg_match('/^T-Mobile ([^\/]+)\//u', $ua, $match)) {
				$this->device->manufacturer = 'T-Mobile';
				$this->device->model = Data\DeviceModels::cleanup($match[1]);
				$this->device->type = Constants\DeviceType::MOBILE;
				$this->device->identified |= Constants\Id::PATTERN;
				$this->device->generic = false;
			}

			if (preg_match('/HP(iPAQ[0-9]+)\//u', $ua, $match)) {
				$this->device->manufacturer = 'HP';
				$this->device->model = Data\DeviceModels::cleanup($match[1]);
				$this->device->type = Constants\DeviceType::MOBILE;
				$this->device->identified |= Constants\Id::PATTERN;
				$this->device->generic = false;

				$device = Data\DeviceModels::identify('wm', $this->device->model);
				if ($device->identified) {
					$device->identified |= $this->device->identified;
					$this->device = $device;
				}
			}

			if (preg_match('/\((?:LG[-|\/])(.*) (?:Browser\/)?AppleWebkit/u', $ua, $match)) {
				$this->device->manufacturer = 'LG';
				$this->device->model = Data\DeviceModels::cleanup($match[1]);
				$this->device->type = Constants\DeviceType::MOBILE;
				$this->device->identified |= Constants\Id::PATTERN;
				$this->device->generic = false;
			}

			if (preg_match('/^Mozilla\/5.0 \((?:Nokia|NOKIA)(?:\s?)([^\)]+)\)UC AppleWebkit\(like Gecko\) Safari\/530$/u', $ua, $match)) {
				$this->device->manufacturer = 'Nokia';
				$this->device->model = Data\DeviceModels::cleanup($match[1]);
				$this->device->type = Constants\DeviceType::MOBILE;
				$this->device->identified |= Constants\Id::PATTERN;
				$this->device->generic = false;

				if (! ($this->device->identified & Constants\Id::MATCH_UA)) {
					$device = Data\DeviceModels::identify('s60', $this->device->model);
					if ($device->identified) {
						$device->identified |= $this->device->identified;
						$this->device = $device;

						if (!isset($this->os->name) || $this->os->name != 'Series60') {
							$this->os->name = 'Series60';
							$this->os->version = null;
						}
					}
				}

				if (! ($this->device->identified & Constants\Id::MATCH_UA)) {
					$device = Data\DeviceModels::identify('s40', $this->device->model);
					if ($device->identified) {
						$device->identified |= $this->device->identified;
						$this->device = $device;

						if (!isset($this->os->name) || $this->os->name != 'Series40') {
							$this->os->name = 'Series40';
							$this->os->version = null;
						}
					}
				}
			}



			/****************************************************
			 *		Safari
			 */

			if (preg_match('/Safari/u', $ua)) {

				if (isset($this->os->name) && $this->os->name == 'iOS') {
					$this->browser->stock = true;
					$this->browser->hidden = true;
					$this->browser->name = 'Safari';
					$this->browser->version = null;

					if (preg_match('/Version\/([0-9\.]+)/u', $ua, $match)) {
						$this->browser->version = new Version([ 'value' => $match[1], 'hidden' => true ]);
					}
				}

				if (isset($this->os->name) && ($this->os->name == 'OS X' || $this->os->name == 'Windows')) {
					$this->browser->name = 'Safari';
					$this->browser->stock = $this->os->name == 'OS X';

					if (preg_match('/Version\/([0-9\.]+)/u', $ua, $match)) {
						$this->browser->version = new Version([ 'value' => $match[1] ]);
					}

					if (preg_match('/AppleWebKit\/[0-9\.]+\+/u', $ua)) {
						$this->browser->name = 'WebKit Nightly Build';
						$this->browser->version = null;
					}
				}


				if (isset($this->os->name) && $this->os->name == 'Darwin') {
					if (preg_match("/^MobileSafari/iu", $ua)) {
						$this->browser->name = 'Safari';
						$this->browser->version = null;
						$this->browser->stock = true;
						$this->browser->hidden = true;

						$this->device->type = Constants\DeviceType::MOBILE;
					}

					else if (preg_match("/^Safari/iu", $ua)) {
						$this->browser->name = 'Safari';
						$this->browser->version = null;
						$this->browser->stock = true;

						$this->device->type = Constants\DeviceType::DESKTOP;
					}
				}
			}

			if (preg_match('/(?:Apple-PubSub|AppleSyndication)\//u', $ua)) {
				$this->browser->stock = true;
				$this->browser->name = 'Safari RSS';
				$this->browser->version = null;

				$this->os->name = 'OS X';
				$this->os->version = null;

				$this->device->type = Constants\DeviceType::DESKTOP;
			}



			/****************************************************
			 *		Internet Explorer
			 */

			if (preg_match('/MSIE/u', $ua)) {
				$this->browser->name = 'Internet Explorer';

				if (preg_match('/IEMobile/u', $ua) || preg_match('/Windows CE/u', $ua) || preg_match('/Windows Phone/u', $ua) || preg_match('/WP7/u', $ua) || preg_match('/WPDesktop/u', $ua)) {
					$this->browser->name = 'Mobile Internet Explorer';

					if (isset($this->device->model) && ($this->device->model == 'Xbox 360' || $this->device->model == 'Xbox One')) {
						$this->browser->name = 'Internet Explorer';
					}
				}

				if (preg_match('/MSIE ([0-9.]*)/u', $ua, $match)) {
					$this->browser->version = new Version([ 'value' => preg_replace("/\.([0-9])([0-9])/", '.$1.$2', $match[1]) ]);
				}

				if (preg_match('/Mac_/u', $ua)) {
					$this->os->name = 'Mac OS';
					$this->engine->name = 'Tasman';
					$this->device->type = Constants\DeviceType::DESKTOP;

					if ($this->browser->version->toFloat() >= 5.11 && $this->browser->version->toFloat() <= 5.13) {
						$this->os->name = 'OS X';
					}

					if ($this->browser->version->toFloat() >= 5.2) {
						$this->os->name = 'OS X';
					}
				}
			}

			if (preg_match('/\(IE ([0-9.]*)/u', $ua, $match)) {
				$this->browser->name = 'Internet Explorer';
				$this->browser->version = new Version([ 'value' => $match[1] ]);
			}

			if (preg_match('/Browser\/IE([0-9.]*)/u', $ua, $match)) {
				$this->browser->name = 'Internet Explorer';
				$this->browser->version = new Version([ 'value' => $match[1] ]);
			}

			if (preg_match('/Trident\/[789][^\)]+; rv:([0-9.]*)\)/u', $ua, $match)) {
				$this->browser->name = 'Internet Explorer';
				$this->browser->version = new Version([ 'value' => $match[1] ]);
			}

			if (preg_match('/Trident\/[789][^\)]+; Touch; rv:([0-9.]*);\s+IEMobile\//u', $ua, $match)) {
				$this->browser->name = 'Mobile Internet Explorer';
				$this->browser->version = new Version([ 'value' => $match[1] ]);
			}

			if (preg_match('/Trident\/[789][^\)]+; Touch; rv:([0-9.]*); WPDesktop/u', $ua, $match)) {
				$this->browser->mode = 'desktop';
				$this->browser->name = 'Mobile Internet Explorer';
				$this->browser->version = new Version([ 'value' => $match[1] ]);
			}


			/****************************************************
			 *		Firefox
			 */

			if (preg_match('/Firefox/u', $ua)) {
				$this->browser->stock = false;
				$this->browser->name = 'Firefox';

				if (preg_match('/Firefox\/([0-9ab.]*)/u', $ua, $match)) {
					$this->browser->version = new Version([ 'value' => $match[1] ]);

					if (preg_match('/a/u', $match[1])) {
						$this->browser->channel = 'Aurora';
					}

					if (preg_match('/b/u', $match[1])) {
						$this->browser->channel = 'Beta';
					}
				}

				if (preg_match('/Aurora\/([0-9ab.]*)/u', $ua, $match)) {
					$this->browser->channel = 'Aurora';
					$this->browser->version = new Version([ 'value' => $match[1] ]);
				}

				if (preg_match('/Fennec/u', $ua)) {
					$this->device->type = Constants\DeviceType::MOBILE;
				}

				if (preg_match('/Mobile;(?: ([^;]+);)? rv/u', $ua, $match)) {
					$this->device->type = Constants\DeviceType::MOBILE;

					if (isset($match[1])) {
						$device = Data\DeviceModels::identify('firefoxos', $match[1]);
						if ($device->identified) {
							$device->identified |= $this->device->identified;
							$this->os->name = 'Firefox OS';
							$this->device = $device;
						}
					}
				}

				if (preg_match('/Tablet;(?: ([^;]+);)? rv/u', $ua, $match)) {
					$this->device->type = Constants\DeviceType::TABLET;

					if (isset($match[1])) {
						$device = Data\DeviceModels::identify('firefoxos', $match[1]);
						if ($device->identified) {
							$device->identified |= $this->device->identified;
							$this->os->name = 'Firefox OS';
							$this->device = $device;
						}
					}
				}

				if (preg_match('/Viera;(?: ([^;]+);)? rv/u', $ua, $match)) {
					$this->device->type = Constants\DeviceType::TELEVISION;
					$this->os->name = 'Firefox OS';
				}

				if ($this->device->type == Constants\DeviceType::MOBILE || $this->device->type == Constants\DeviceType::TABLET) {
					$this->browser->name = 'Firefox Mobile';
				}

				if ($this->device->type == '') {
					$this->device->type = Constants\DeviceType::DESKTOP;
				}
			}

			if (preg_match('/Namoroka/u', $ua)) {
				$this->browser->stock = false;
				$this->browser->name = 'Firefox';

				if (preg_match('/Namoroka\/([0-9ab.]*)/u', $ua, $match)) {
					$this->browser->version = new Version([ 'value' => $match[1] ]);
				}

				$this->browser->channel = 'Namoroka';
			}

			if (preg_match('/Shiretoko/u', $ua)) {
				$this->browser->stock = false;
				$this->browser->name = 'Firefox';

				if (preg_match('/Shiretoko\/([0-9ab.]*)/u', $ua, $match)) {
					$this->browser->version = new Version([ 'value' => $match[1] ]);
				}

				$this->browser->channel = 'Shiretoko';
			}

			if (preg_match('/Minefield/u', $ua)) {
				$this->browser->stock = false;
				$this->browser->name = 'Firefox';

				if (preg_match('/Minefield\/([0-9ab.]*)/u', $ua, $match)) {
					$this->browser->version = new Version([ 'value' => $match[1] ]);
				}

				$this->browser->channel = 'Minefield';
			}

			if (preg_match('/BonEcho/u', $ua)) {
				$this->browser->stock = false;
				$this->browser->name = 'Firefox';

				if (preg_match('/BonEcho\/([0-9ab.]*)/u', $ua, $match)) {
					$this->browser->version = new Version([ 'value' => $match[1] ]);
				}

				$this->browser->channel = 'BonEcho';
			}

			if (preg_match('/Firebird/u', $ua)) {
				$this->browser->stock = false;
				$this->browser->name = 'Firebird';

				if (preg_match('/Firebird\/([0-9ab.]*)/u', $ua, $match)) {
					$this->browser->version = new Version([ 'value' => $match[1] ]);
				}
			}

			if (isset($this->os->name) && $this->os->name == 'Firefox OS') {
				if (preg_match('/rv:([0-9.]*)/u', $ua, $match)) {
					switch($match[1]) {
						case '18.0': $this->os->version = new Version([ 'value' => '1.0.1' ]); break;
						case '18.1': $this->os->version = new Version([ 'value' => '1.1' ]); break;
						case '26.0': $this->os->version = new Version([ 'value' => '1.2' ]); break;
						case '28.0': $this->os->version = new Version([ 'value' => '1.3' ]); break;
						case '30.0': $this->os->version = new Version([ 'value' => '1.4' ]); break;
						case '32.0': $this->os->version = new Version([ 'value' => '2.0' ]); break;
						case '34.0': $this->os->version = new Version([ 'value' => '2.1' ]); break;
					}
				}
			}

			if (preg_match('/FxiOS\/([0-9.]*)/u', $ua, $match)) {
				$this->browser->name = 'Firefox';
				$this->browser->version = new Version([ 'value' => $match[1] ]);
			}


			/****************************************************
			 *		SeaMonkey
			 */

			if (preg_match('/SeaMonkey/u', $ua)) {
				$this->browser->stock = false;
				$this->browser->name = 'SeaMonkey';

				if (preg_match('/SeaMonkey\/([0-9ab.]*)/u', $ua, $match)) {
					$this->browser->version = new Version([ 'value' => $match[1] ]);
				}

				if ($this->device->type == '') {
					$this->device->type = Constants\DeviceType::DESKTOP;
				}
			}

			if (preg_match('/PmWFx\/([0-9ab.]*)/u', $ua, $match)) {
				$this->browser->stock = false;
				$this->browser->name = 'SeaMonkey';
				$this->browser->version = new Version([ 'value' => $match[1] ]);
			}



			/****************************************************
			 *		Netscape
			 */

			if (preg_match('/Netscape/u', $ua)) {
				$this->browser->stock = false;
				$this->browser->name = 'Netscape';

				if (preg_match('/Netscape[0-9]?\/([0-9.]*)/u', $ua, $match)) {
					$this->browser->version = new Version([ 'value' => $match[1] ]);
				}
			}

			/****************************************************
			 *		Konqueror
			 */

			if (preg_match('/[k|K]onqueror\//u', $ua)) {
				$this->browser->name = 'Konqueror';

				if (preg_match('/[k|K]onqueror\/([0-9.]*)/u', $ua, $match)) {
					$this->browser->version = new Version([ 'value' => $match[1] ]);
				}

				if ($this->device->type == '') {
					$this->device->type = Constants\DeviceType::DESKTOP;
				}
			}

			/****************************************************
			 *		Chrome
			 */

			if (preg_match('/(?:Chrome|CrMo|CriOS)\/([0-9.]*)/u', $ua, $match)) {
				$this->browser->stock = false;
				$this->browser->name = 'Chrome';
				$this->browser->version = new Version([ 'value' => $match[1] ]);

				if (isset($this->os->name) && $this->os->name == 'Android') {
					$channel = Data\Chrome::getChannel('mobile', $match[1]);

					if ($channel == 'stable') {
						if (explode('.', $match[1])[1] == '0') {
							$this->browser->version->details = 1;
						} else {
							$this->browser->version->details = 2;
						}
					}
					else if ($channel == 'beta') {
						$this->browser->channel = 'Beta';
					}
					else {
						$this->browser->channel = 'Dev';
					}


					/* Webview for Android 4.4 and higher */
					if (implode('.', array_slice(explode('.', $match[1]), 1, 2)) == '0.0' && preg_match('/Version\//u', $ua)) {
						$this->browser->using = new Using([ 'name' => 'Chromium WebView', 'version' => new Version([ 'value' => explode('.', $match[1])[0] ]) ]);
						$this->browser->stock = true;
						$this->browser->name = null;
						$this->browser->version = null;
						$this->browser->channel = null;
					}

					/* Webview for Android 5 */
					if (preg_match('/; wv\)/u', $ua)) {
						$this->browser->using = new Using([ 'name' => 'Chromium WebView', 'version' => new Version([ 'value' => explode('.', $match[1])[0] ]) ]);
						$this->browser->stock = true;
						$this->browser->name = null;
						$this->browser->version = null;
						$this->browser->channel = null;
					}

					/* LG Chromium based browsers */
					if (isset($device->manufacturer) && $device->manufacturer == 'LG') {
						if (in_array($match[1], [ '30.0.1599.103', '34.0.1847.118', '38.0.2125.0', '38.0.2125.102' ]) && preg_match('/Version\/4/u', $ua) && !preg_match('/; wv\)/u', $ua)) {
							$this->browser->name = "LG Browser";
							$this->browser->channel = null;
							$this->browser->stock = true;
							$this->browser->version = null;
							$this->browser->channel = null;
						}
					}

					/* Samsung Chromium based browsers */
					if (isset($device->manufacturer) && $device->manufacturer == 'Samsung') {

						/* Version 1.0 */
						if ($match[1] == '18.0.1025.308' && preg_match('/Version\/1.0/u', $ua)) {
							$this->browser->name = "Samsung Browser";
							$this->browser->channel = null;
							$this->browser->stock = true;
							$this->browser->version = new Version([ 'value' => '1.0' ]);
							$this->browser->channel = null;
						}

						/* Version 1.5 */
						if ($match[1] == '28.0.1500.94' && preg_match('/Version\/1.5/u', $ua)) {
							$this->browser->name = "Samsung Browser";
							$this->browser->channel = null;
							$this->browser->stock = true;
							$this->browser->version = new Version([ 'value' => '1.5' ]);
							$this->browser->channel = null;
						}

						/* Version 1.6 */
						if ($match[1] == '28.0.1500.94' && preg_match('/Version\/1.6/u', $ua)) {
							$this->browser->name = "Samsung Browser";
							$this->browser->channel = null;
							$this->browser->stock = true;
							$this->browser->version = new Version([ 'value' => '1.6' ]);
							$this->browser->channel = null;
						}

						/* Version 2.0 */
						if ($match[1] == '34.0.1847.76' && preg_match('/Version\/2.0/u', $ua)) {
							$this->browser->name = "Samsung Browser";
							$this->browser->channel = null;
							$this->browser->stock = true;
							$this->browser->version = new Version([ 'value' => '2.0' ]);
							$this->browser->channel = null;
						}

						/* Version 2.1 */
						if ($match[1] == '34.0.1847.76' && preg_match('/Version\/2.1/u', $ua)) {
							$this->browser->name = "Samsung Browser";
							$this->browser->channel = null;
							$this->browser->stock = true;
							$this->browser->version = new Version([ 'value' => '2.1' ]);
							$this->browser->channel = null;
						}
					}

					/* Samsung Chromium based browsers */
					if (preg_match('/SamsungBrowser\/([0-9.]*)/u', $ua, $match)) {
						$this->browser->name = "Samsung Browser";
						$this->browser->channel = null;
						$this->browser->stock = true;
						$this->browser->version = new Version([ 'value' => $match[1] ]);
						$this->browser->channel = null;
					}
				}

				else {
					$channel = Data\Chrome::getChannel('desktop', $match[1]);

					if ($channel == 'stable') {
						if (explode('.', $match[1])[1] == '0') {
							$this->browser->version->details = 1;
						} else {
							$this->browser->version->details = 2;
						}
					}
					else if ($channel == 'beta') {
						$this->browser->channel = 'Beta';
					}
					else {
						$this->browser->channel = 'Dev';
					}
				}

				if ($this->device->type == '') {
					$this->device->type = Constants\DeviceType::DESKTOP;
				}
			}

			/****************************************************
			 *		Chromium
			 */

			if (preg_match('/Chromium/u', $ua)) {
				$this->browser->stock = false;
				$this->browser->channel = '';
				$this->browser->name = 'Chromium';

				if (preg_match('/Chromium\/([0-9.]*)/u', $ua, $match)) {
					$this->browser->version = new Version([ 'value' => $match[1] ]);
				}

				if ($this->device->type == '') {
					$this->device->type = Constants\DeviceType::DESKTOP;
				}
			}


			/****************************************************
			 *		Chromium WebView by Amazon
			 */

			if (preg_match('/AmazonWebAppPlatform\//u', $ua)) {
				$this->browser->using = new Using([ 'name' => 'Amazon WebView' ]); 

				$this->browser->stock = false;
				$this->browser->name = null;
				$this->browser->version = null;
				$this->browser->channel = null;
			}

			/****************************************************
			 *		Chromium WebView by Crosswalk
			 */

			if (preg_match('/Crosswalk\/([0-9.]*)/u', $ua, $match)) {
				$this->browser->using = new Using([ 'name' => 'Crosswalk WebView', 'version' => new Version([ 'value' => $match[1], 'details' => 1 ]) ]); 

				$this->browser->stock = false;
				$this->browser->name = null;
				$this->browser->version = null;
				$this->browser->channel = null;
			}

			/****************************************************
			 *		Edge
			 */


			if (preg_match('/Edge\/([0-9]+)/u', $ua, $match)) {
				$this->browser->name = 'Edge';
				$this->browser->alias = 'Edge ' . $match[1];
				$this->browser->channel = '';
				$this->browser->version = null;
			}

			/****************************************************
			 *		Opera
			 */

			if (preg_match('/OPR\/([0-9.]*)/u', $ua, $match)) {
				$this->browser->stock = false;
				$this->browser->channel = '';
				$this->browser->name = 'Opera';
				$this->browser->version = new Version([ 'value' => $match[1], 'details' => 2 ]);

				if (preg_match('/Edition Developer/u', $ua)) {
					$this->browser->channel = 'Developer';
				}

				if (preg_match('/Edition Next/u', $ua)) {
					$this->browser->channel = 'Next';
				}

				if (preg_match('/Edition beta/u', $ua)) {
					$this->browser->channel = 'Beta';
				}

				if ($this->device->type == Constants\DeviceType::MOBILE) {
					$this->browser->name = 'Opera Mobile';
				}

				if (preg_match('/OMI\//u', $ua)) {
					$this->device->type = Constants\DeviceType::TELEVISION;
				}
			}

			if (preg_match('/Opera[\/\-\s]/iu', $ua)) {
				$this->browser->stock = false;
				$this->browser->name = 'Opera';

				if (preg_match('/Opera[\/| ]([0-9.]*)/u', $ua, $match)) {
					$this->browser->version = new Version([ 'value' => $match[1] ]);
				}

				if (preg_match('/Version\/([0-9.]*)/u', $ua, $match)) {
					if (floatval($match[1]) >= 10)
						$this->browser->version = new Version([ 'value' => $match[1] ]);
					else
						$this->browser->version = null;
				}

				if (isset($this->browser->version) && preg_match('/Edition Labs/u', $ua)) {
					$this->browser->channel = 'Labs';
				}

				if (isset($this->browser->version) && preg_match('/Edition Next/u', $ua)) {
					$this->browser->channel = 'Next';
				}

				if (preg_match('/Opera Tablet/u', $ua)) {
					$this->browser->name = 'Opera Mobile';
					$this->device->type = Constants\DeviceType::TABLET;
				}

				if (preg_match('/Opera Mobi/u', $ua)) {
					$this->browser->name = 'Opera Mobile';
					$this->device->type = Constants\DeviceType::MOBILE;
				}

				if (preg_match('/Opera Mini;/u', $ua)) {
					$this->browser->name = 'Opera Mini';
					$this->browser->version = null;
					$this->browser->mode = 'proxy';
					$this->device->type = Constants\DeviceType::MOBILE;
				}

				if (preg_match('/Opera Mini\/(?:att\/)?([0-9.]*)/u', $ua, $match)) {
					$this->browser->name = 'Opera Mini';
					$this->browser->version = new Version([ 'value' => $match[1], 'details' => (intval(substr(strrchr($match[1], '.'), 1)) > 99 ? -1 : null) ]);
					$this->browser->mode = 'proxy';
					$this->device->type = Constants\DeviceType::MOBILE;
				}

				if ($this->browser->name == 'Opera' && $this->device->type == Constants\DeviceType::MOBILE) {
					$this->browser->name = 'Opera Mobile';

					if (preg_match('/BER/u', $ua)) {
						$this->browser->name = 'Opera Mini';
						$this->browser->version = null;
					}
				}

				if (preg_match('/InettvBrowser/u', $ua)) {
					$this->device->type = Constants\DeviceType::TELEVISION;
				}

				if (preg_match('/Opera[ -]TV/u', $ua)) {
					$this->browser->name = 'Opera';
					$this->device->type = Constants\DeviceType::TELEVISION;
				}

				if (preg_match('/Linux zbov/u', $ua)) {
					$this->browser->name = 'Opera Mobile';
					$this->browser->mode = 'desktop';

					$this->device->type = Constants\DeviceType::MOBILE;

					$this->os->name = null;
					$this->os->version = null;
				}

				if (preg_match('/Linux zvav/u', $ua)) {
					$this->browser->name = 'Opera Mini';
					$this->browser->version = null;
					$this->browser->mode = 'desktop';

					$this->device->type = Constants\DeviceType::MOBILE;

					$this->os->name = null;
					$this->os->version = null;
				}

				if ($this->device->type == '') {
					$this->device->type = Constants\DeviceType::DESKTOP;
				}
			}

			if (preg_match('/OPiOS\/([0-9.]*)/u', $ua, $match)) {
				$this->browser->name = 'Opera Mini';
				$this->browser->version = new Version([ 'value' => $match[1], 'details' => 2 ]);
			}

			if (preg_match('/Coast\/([0-9.]*)/u', $ua, $match)) {
				$this->browser->name = 'Coast by Opera';
				$this->browser->version = new Version([ 'value' => $match[1], 'details' => 3 ]);
			}

			/****************************************************
			 *		wOSBrowser
			 */

			if (preg_match('/wOSBrowser/u', $ua)) {
				$this->browser->name = 'webOS Browser';

				if ($this->os->name != 'webOS') {
					$this->os->name = 'webOS';
				}
			}

			/****************************************************
			 *		Sailfish Browser
			 */

			if (preg_match('/Sailfish ?Browser/u', $ua)) {
				$this->browser->name = 'Sailfish Browser';
				$this->browser->stock = true;

				if (preg_match('/Sailfish ?Browser\/([0-9.]*)/u', $ua, $match)) {
					$this->browser->version = new Version([ 'value' => $match[1], 'details' => 2 ]);
				}
			}

			/****************************************************
			 *		BrowserNG
			 */

			if (preg_match('/BrowserNG/u', $ua)) {
				$this->browser->name = 'Nokia Browser';

				if (preg_match('/BrowserNG\/([0-9.]*)/u', $ua, $match)) {
					$this->browser->version = new Version([ 'value' => $match[1], 'details' => 3, 'builds' => false ]);
				}
			}

			/****************************************************
			 *		Nokia Browser
			 */

			if (preg_match('/NokiaBrowser/u', $ua)) {
				$this->browser->name = 'Nokia Browser';
				$this->browser->channel = null;

				if (preg_match('/NokiaBrowser\/([0-9.]*)/u', $ua, $match)) {
					$this->browser->version = new Version([ 'value' => $match[1], 'details' => 3 ]);
				}
			}

			/****************************************************
			 *		Nokia Xpress
			 *
			 *		Mozilla/5.0 (X11; Linux x86_64; rv:5.0.1) Gecko/20120822 OSRE/1.0.7f
			 */

			if (preg_match('/OSRE/u', $ua)) {
				$this->browser->name = 'Nokia Xpress';
				$this->browser->mode = 'proxy';
				$this->device->type = Constants\DeviceType::MOBILE;

				$this->os->name = null;
				$this->os->version = null;
			}

			if (preg_match('/S40OviBrowser/u', $ua)) {
				$this->browser->name = 'Nokia Xpress';
				$this->browser->mode = 'proxy';

				if (preg_match('/S40OviBrowser\/([0-9.]*)/u', $ua, $match)) {
					$this->browser->version = new Version([ 'value' => $match[1], 'details' => 3 ]);
				}

				if (preg_match('/Nokia([^\/]+)\//u', $ua, $match)) {
					$this->device->manufacturer = 'Nokia';
					$this->device->model = $match[1];
					$this->device->identified |= Constants\Id::PATTERN;

					if (isset($this->device->model)) {
						$device = Data\DeviceModels::identify('s40', $this->device->model);
						if ($device->identified) {
							$device->identified |= $this->device->identified;
							$this->device = $device;
						}
					}

					if (isset($this->device->model)) {
						$device = Data\DeviceModels::identify('asha', $this->device->model);
						if ($device->identified) {
							$device->identified |= $this->device->identified;
							$this->os->name = 'Nokia Asha Platform';
							$this->os->version = new Version([ 'value' => '1.0' ]);
							$this->device = $device;


							if (preg_match('/java_runtime_version=Nokia_Asha_([0-9_]+);/u', $ua, $match)) {
								$this->os->version = new Version([ 'value' => str_replace('_', '.', $match[1]) ]);
							}
						}
					}
				}

				if (preg_match('/NOKIALumia([0-9]+)/u', $ua, $match)) {
					$this->device->manufacturer = 'Nokia';
					$this->device->model = $match[1];
					$this->device->identified |= Constants\Id::PATTERN;

					$device = Data\DeviceModels::identify('wp', $this->device->model);
					if ($device->identified) {
						$device->identified |= $this->device->identified;
						$this->device = $device;
						$this->os->name = 'Windows Phone';
					}
				}
			}


			/****************************************************
			 *		MicroB
			 */

			if (preg_match('/Maemo[ |_]Browser/u', $ua)) {
				$this->browser->name = 'MicroB';

				if (preg_match('/Maemo[ |_]Browser[ |_]([0-9.]*)/u', $ua, $match)) {
					$this->browser->version = new Version([ 'value' => $match[1], 'details' => 3 ]);
				}
			}


			/****************************************************
			 *		Silk
			 */

			if (preg_match('/Silk/u', $ua)) {
				if (preg_match('/Silk-Accelerated/u', $ua) || !preg_match('/PlayStation/u', $ua)) {
					$this->browser->name = 'Silk';
					$this->browser->channel = null;

					if (preg_match('/Silk\/([0-9.]*)/u', $ua, $match)) {
						$this->browser->version = new Version([ 'value' => $match[1], 'details' => 2 ]);
					}

					if (preg_match('/; ([^;]*[^;\s])\s+Build/u', $ua, $match)) {
						$this->device = Data\DeviceModels::identify('android', $match[1]);
					}

					if (!$this->device->identified) {
						$this->device->manufacturer = 'Amazon';
						$this->device->model = 'Kindle Fire';
						$this->device->type = Constants\DeviceType::TABLET;
						$this->device->identified |= Constants\Id::INFER;

						if (isset($this->os->name) && ($this->os->name != 'Android' || $this->os->name != 'FireOS')) {
							$this->os->name = 'FireOS';
							$this->os->family = new Family([ 'name' => 'Android' ]);
							$this->os->alias = null;
							$this->os->version = null;
						}
					}
				}
			}

			/****************************************************
			 *		Dolfin
			 */

			if (preg_match('/Dolfin/u', $ua) || preg_match('/Jasmine/u', $ua)) {
				$this->browser->name = 'Dolfin';

				if (preg_match('/Dolfin\/([0-9.]*)/u', $ua, $match)) {
					$this->browser->version = new Version([ 'value' => $match[1] ]);
				}

				if (preg_match('/Browser\/Dolfin([0-9.]*)/u', $ua, $match)) {
					$this->browser->version = new Version([ 'value' => $match[1] ]);
				}

				if (preg_match('/Jasmine\/([0-9.]*)/u', $ua, $match)) {
					$this->browser->version = new Version([ 'value' => $match[1] ]);
				}
			}

			/****************************************************
			 *		Iris
			 */

			if (preg_match('/Iris[ \/]/u', $ua)) {
				$this->browser->name = 'Iris';

				$this->device->type = Constants\DeviceType::MOBILE;
				$this->device->manufacturer = null;
				$this->device->model = null;

				$this->os->name = 'Windows Mobile';
				$this->os->version = null;

				if (preg_match('/Iris\/([0-9.]*)/u', $ua, $match)) {
					$this->browser->version = new Version([ 'value' => $match[1] ]);
				}

				if (preg_match('/ WM([0-9]) /u', $ua, $match)) {
					$this->os->version = new Version([ 'value' => $match[1] . '.0' ]);
				} else {
					$this->browser->mode = 'desktop';
				}
			}

			/****************************************************
			 *		Boxee
			 */

			if (preg_match('/Boxee/u', $ua)) {
				$this->browser->name = 'Boxee';
				$this->device->type = Constants\DeviceType::TELEVISION;

				if (preg_match('/Boxee\/([0-9.]*)/u', $ua, $match)) {
					$this->browser->version = new Version([ 'value' => $match[1] ]);
				}
			}

			/****************************************************
			 *		Sraf TV Browser
			 */

			if (preg_match('/sraf_tv_browser/u', $ua)) {
				$this->browser->name = 'Sraf TV Browser';
				$this->browser->version = null;
				$this->device->type = Constants\DeviceType::TELEVISION;
			}

			/****************************************************
			 *		LG Browser
			 */

			if (preg_match('/LG Browser\/([0-9.]*)/u', $ua, $match)) {
				$this->browser->name = 'LG Browser';
				$this->browser->version = new Version([ 'value' => $match[1], 'details' => 2 ]);
				$this->device->type = Constants\DeviceType::TELEVISION;
			}

			if (preg_match('/NetCast/u', $ua) && preg_match('/SmartTV\//u', $ua)) {
				unset($this->browser->name);
				unset($this->browser->version);
			}

			/****************************************************
			 *		Sony Browser
			 */

			if (preg_match('/SonyBrowserCore\/([0-9.]*)/u', $ua, $match)) {
				unset($this->browser->name);
				unset($this->browser->version);
				$this->device->type = Constants\DeviceType::TELEVISION;
			}



			/****************************************************
			 *		Espial
			 */

			if (preg_match('/Espial/u', $ua)) {
				$this->browser->name = 'Espial';

				$this->os->name = '';
				$this->os->version = null;

				if ($this->device->type != Constants\DeviceType::TELEVISION) {
					$this->device->type = Constants\DeviceType::TELEVISION;
					$this->device->manufacturer = null;
					$this->device->model = null;
				}

				if (preg_match('/Espial\/([0-9.]*)/u', $ua, $match)) {
					$this->browser->version = new Version([ 'value' => $match[1] ]);
				}

				if (preg_match('/;L7200/u', $ua)) {
					$this->device->manufacturer = 'Toshiba';
					$this->device->model = 'Regza L7200';
					$this->device->series = 'Smart TV';
					$this->device->identified |= Constants\Id::MATCH_UA;
					$this->device->generic = false;
				}
			}

			/****************************************************
			 *		MachBlue XT
			 */

			if (preg_match('/mbxtWebKit\/([0-9.]*)/u', $ua, $match)) {
				$this->os->name = '';
				$this->browser->name = 'MachBlue XT';
				$this->browser->version = new Version([ 'value' => $match[1], 'details' => 2 ]);
				$this->device->type = Constants\DeviceType::TELEVISION;
			}

			if ($ua == 'MachBlue') {
				$this->os->name = '';
				$this->browser->name = 'MachBlue XT';
				$this->device->type = Constants\DeviceType::TELEVISION;
			}

			/****************************************************
			 *		ANT Galio
			 */

			if (preg_match('/ANTGalio\/([0-9.]*)/u', $ua, $match)) {
				$this->browser->name = 'ANT Galio';
				$this->browser->version = new Version([ 'value' => $match[1], 'details' => 3 ]);
				$this->device->type = Constants\DeviceType::TELEVISION;
			}

			/****************************************************
			 *		NetFront
			 */

			if (preg_match('/Net[fF]ront/u', $ua)) {
				$this->browser->name = 'NetFront';
				$this->device->type = Constants\DeviceType::MOBILE;

				if (preg_match('/NetFront\/?([0-9.]*)/ui', $ua, $match)) {
					$this->browser->version = new Version([ 'value' => $match[1] ]);
				}

				if (preg_match('/(InettvBrowser|HbbTV)/u', $ua)) {
					$this->device->type = Constants\DeviceType::TELEVISION;
				}

				if (preg_match('/Kindle/u', $ua)) {
					$this->device->type = Constants\DeviceType::EREADER;
				}
			}

			if (preg_match('/Browser\/NF([0-9.]*)/ui', $ua, $match)) {
				$this->browser->name = 'NetFront';
				$this->browser->version = new Version([ 'value' => $match[1] ]);
				$this->device->type = Constants\DeviceType::MOBILE;
			}

			if (preg_match('/Browser\/NetFont-([0-9.]*)/ui', $ua, $match)) {
				$this->browser->name = 'NetFront';
				$this->browser->version = new Version([ 'value' => $match[1] ]);
				$this->device->type = Constants\DeviceType::MOBILE;
			}

			/****************************************************
			 *		NetFront NX
			 */

			if (preg_match('/NX\/([0-9.]*)/u', $ua, $match)) {
				$this->browser->name = 'NetFront NX';
				$this->browser->version = new Version([ 'value' => $match[1], 'details' => 2 ]);

				if (!isset($this->device->type) || !$this->device->type) {
					if (preg_match('/(DTV|HbbTV)/iu', $ua)) {
						$this->device->type = Constants\DeviceType::TELEVISION;
					} else if (preg_match('/mobile/iu', $ua)) {
						$this->device->type = Constants\DeviceType::MOBILE;
					} else {
						$this->device->type = Constants\DeviceType::DESKTOP;
					}
				}

				$this->os->name = '';
				$this->os->version = null;
			}

			/****************************************************
			 *		XBMC
			 */

			if (preg_match('/^XBMC\/(?:PRE-)?([0-9.]+)/u', $ua, $match)) {
				$this->browser->name = 'XBMC';
				$this->browser->version = new Version([ 'value' => $match[1], 'details' => 2 ]);
			}


			/****************************************************
			 *		Kodi
			 */

			if (preg_match('/^Kodi\/([0-9.]+)/u', $ua, $match)) {
				$this->browser->name = 'Kodi';
				$this->browser->version = new Version([ 'value' => $match[1], 'details' => 2 ]);
			}


			/****************************************************
			 *		ANT
			 */

			if (preg_match('/ANTFresco\/([0-9.]+)/iu', $ua, $match)) {
				$this->browser->name = 'ANT Fresco';
				$this->browser->version = new Version([ 'value' => $match[1] ]);
			}

			if (preg_match('/ANTGalio\/([0-9.]+)/iu', $ua, $match)) {
				$this->browser->name = 'ANT Galio';
				$this->browser->version = new Version([ 'value' => $match[1], 'details' => 3 ]);
			}


			/****************************************************
			 *		Obigo
			 */

			if (preg_match('/(?:Obigo|Teleca)/ui', $ua)) {
				$this->browser->name = 'Obigo';

				if (preg_match('/Obigo\/0?([0-9.]+)/iu', $ua, $match)) {
					$this->browser->version = new Version([ 'value' => $match[1] ]);
				}

				else if (preg_match('/(?:Obigo(?:InternetBrowser|[- ]Browser)?|Teleca)\/([A-Z]+)0?([0-9.]+)/ui', $ua, $match)) {
					$this->browser->name = 'Obigo ' . $match[1];
					$this->browser->version = new Version([ 'value' => $match[2] ]);
				}

				else if (preg_match('/(?:Obigo|Teleca)[- ]([A-Z]+)0?([0-9.]+)(?:[A-Z][0-9])?(?:[\/;]|$)/ui', $ua, $match)) {
					$this->browser->name = 'Obigo ' . $match[1];
					$this->browser->version = new Version([ 'value' => $match[2] ]);
				}

				else if (preg_match('/Browser\/(?:Obigo|Teleca)[_-](?:Browser\/)?([A-Z]+)0?([0-9.]+)/ui', $ua, $match)) {
					$this->browser->name = 'Obigo ' . $match[1];
					$this->browser->version = new Version([ 'value' => $match[2] ]);
				}
			}

			/****************************************************
			 *		UC Web
			 */

			if (preg_match('/UCWEB/u', $ua)) {
				$this->browser->stock = false;
				$this->browser->name = 'UC Browser';

				unset($this->browser->channel);

				if (preg_match('/UCWEB\/?([0-9]*[.][0-9]*)/u', $ua, $match)) {
					$this->browser->version = new Version([ 'value' => $match[1], 'details' => 3 ]);
				}

				if (!$this->device->type) {
					$this->device->type = Constants\DeviceType::MOBILE;
				}

				if (isset($this->os->name) && $this->os->name == 'Linux') {
					$this->os->name = '';
				}

				if (preg_match('/^IUC ?\(U; ?iOS ([0-9\._]+);/u', $ua, $match)) {
					$this->os->name = 'iOS';
					$this->os->version = new Version([ 'value' => str_replace('_', '.', $match[1]) ]);
				}

				if (preg_match('/^JUC ?\(Linux; ?U; ?(?:Android)? ?([0-9\.]+)[^;]*; ?[^;]+; ?([^;]*[^\s])\s*; ?[0-9]+\*[0-9]+;?\)/u', $ua, $match)) {
					$this->os->name = 'Android';
					$this->os->version = new Version([ 'value' => $match[1] ]);

					$this->device = Data\DeviceModels::identify('android', $match[2]);
				}

				if (preg_match('/; Adr ([0-9\.]+); [^;]+; ([^;]*[^\s])\)/u', $ua, $match)) {
					$this->os->name = 'Android';
					$this->os->version = new Version([ 'value' => $match[1] ]);

					$this->device = Data\DeviceModels::identify('android', $match[2]);
				}

				if (preg_match('/\(iOS;/u', $ua)) {
					$this->os->name = 'iOS';
					$this->os->version = new Version([ 'value' => '1.0' ]);

					if (preg_match('/OS ([0-9_]*);/u', $ua, $match)) {
						$this->os->version = new Version([ 'value' => str_replace('_', '.', $match[1]) ]);
					}

					if (preg_match('/; ([^;]+)\)/u', $ua, $match)) {
						$device = Data\DeviceModels::identify('ios', $match[1]);

						if ($device->identified) {
							$device->identified |= $this->device->identified;
							$this->device = $device;
						}
					}
				}

				if (preg_match('/\(Windows;/u', $ua)) {
					$this->os->name = 'Windows Phone';
					$this->os->version = null;

					if (preg_match('/wds ([0-9]\.[0-9])/u', $ua, $match)) {
						switch($match[1]) {
							case '7.0':		$this->os->version = new Version([ 'value' => '7.0' ]); break;
							case '7.1':		$this->os->version = new Version([ 'value' => '7.5' ]); break;
							case '8.0':		$this->os->version = new Version([ 'value' => '8.0' ]); break;
						}
					}

					if (preg_match('/; ([^;]+); ([^;]+)\)/u', $ua, $match)) {
						$this->device->manufacturer = $match[1];
						$this->device->model = $match[2];
						$this->device->identified |= Constants\Id::PATTERN;

						$device = Data\DeviceModels::identify('wp', $match[2]);

						if ($device->identified) {
							$device->identified |= $this->device->identified;
							$this->device = $device;
						}
					}
				}
			}

			if (preg_match('/Ucweb\/([0-9]*[.][0-9]*)/u', $ua, $match)) {
				$this->browser->stock = false;
				$this->browser->name = 'UC Browser';
				$this->browser->version = new Version([ 'value' => $match[1], 'details' => 3 ]);
			}

			if (preg_match('/ucweb-squid/u', $ua)) {
				$this->browser->stock = false;
				$this->browser->name = 'UC Browser';

				unset($this->browser->channel);
			}

			if (preg_match('/\) ?UC /u', $ua)) {
				$this->browser->stock = false;
				$this->browser->name = 'UC Browser';

				unset($this->browser->version);
				unset($this->browser->channel);
				unset($this->browser->mode);

				if (!$this->device->type) {
					$this->device->type = Constants\DeviceType::MOBILE;
				}

				if ($this->device->type == Constants\DeviceType::DESKTOP) {
					$this->device->type = Constants\DeviceType::MOBILE;
					$this->browser->mode = 'desktop';
				}
			}

			if (preg_match('/UC ?Browser\/?([0-9.]*)/u', $ua, $match)) {
				$this->browser->stock = false;
				$this->browser->name = 'UC Browser';
				$this->browser->version = new Version([ 'value' => $match[1], 'details' => 2 ]);

				unset($this->browser->channel);

				if (!$this->device->type) {
					$this->device->type = Constants\DeviceType::MOBILE;
				}
			}

			if (preg_match('/UBrowser\/?([0-9.]*)/u', $ua, $match)) {
				$this->browser->stock = false;
				$this->browser->name = 'UC Browser';
				$this->browser->version = new Version([ 'value' => $match[1], 'details' => 2 ]);

				unset($this->browser->channel);
			}

			/* U2 is the Proxy service used by UC Browser on low-end phones */
			if (preg_match('/U2\//u', $ua)) {
				$this->browser->stock = false;
				$this->browser->name = 'UC Browser';
				$this->browser->mode = 'proxy';

				$this->engine->name = 'Gecko';

				/* UC Browser running on Windows 8 is identifing itself as U2, but instead its a Trident Webview */
				if (isset($this->os->name) && isset($this->os->version)) {
					if ($this->os->name == 'Windows Phone' && $this->os->version->toFloat() >= 8) {
						$this->engine->name = 'Trident';
						$this->browser->mode = '';
					}
				}

				if (!$this->device->identified && preg_match('/; ([^;]*)\) U2\//u', $ua, $match)) {
					$device = Data\DeviceModels::identify('android', $match[1]);
					if ($device->identified) {
						$device->identified |= $this->device->identified;
						$this->device = $device;

						if (!isset($this->os->name) || ($this->os->name != 'Android' && (!isset($this->os->family) || $this->os->family->getName() != 'Android'))) {
							$this->os->name = 'Android';
						}
					}
				}
			}

			/* U3 is the Webkit based Webview used on Android phones */
			if (preg_match('/U3\//u', $ua)) {
				$this->engine->name = 'Webkit';
			}


			/****************************************************
			 *		NineSky
			 */

			if (preg_match('/Ninesky(?:-android-mobile(?:-cn)?)?\/([0-9.]*)/u', $ua, $match)) {
				$this->browser->name = 'NineSky';
				$this->browser->version = new Version([ 'value' => $match[1] ]);

				if (isset($this->device->manufacturer) && $this->device->manufacturer == 'Apple') {
					unset($this->device->manufacturer);
					unset($this->device->model);
					unset($this->device->identifier);
					$this->device->identified = Constants\Id::NONE;
				}

				if (isset($this->os->name) && $this->os->name != 'Android') {
					$this->os->name = 'Android';
					$this->os->version = null;
				}
			}

			/****************************************************
			 *		Skyfire
			 */

			if (preg_match('/Skyfire\/([0-9.]*)/u', $ua, $match)) {
				$this->browser->name = 'Skyfire';
				$this->browser->version = new Version([ 'value' => $match[1] ]);

				$this->device->type = Constants\DeviceType::MOBILE;

				$this->os->name = 'Android';
				$this->os->version = null;
			}

			/****************************************************
			 *		Dolphin HD
			 */

			if (preg_match('/Dolphin(?:HDCN)?\/(?:INT|CN)?-?([0-9.]*)/u', $ua, $match)) {
				$this->browser->name = 'Dolphin';
				$this->browser->version = new Version([ 'value' => $match[1] ]);

				$this->device->type = Constants\DeviceType::MOBILE;
			}

			/****************************************************
			 *		QQ Browser
			 */

			if (preg_match('/(M?QQBrowser)\/([0-9.]*)/u', $ua, $match)) {
				$this->browser->name = 'QQ Browser';

				$version = $match[2];
				if (preg_match('/^[0-9][0-9]$/u', $version)) $version = $version[0] . '.' . $version[1];

				$this->browser->version = new Version([ 'value' => $version, 'details' => 2 ]);
				$this->browser->channel = '';

				if (!isset($this->os->name) && $match[1] == 'QQBrowser') {
					$this->os->name = 'Windows';
				}
			}

			if (preg_match('/MQQBrowser\/Mini([0-9.]*)/u', $ua, $match)) {
				$this->browser->name = 'QQ Browser Mini';
				$this->browser->version = new Version([ 'value' => $match[1], 'details' => 2 ]);
				$this->browser->channel = '';
			}

			/****************************************************
			*		360 Phone Browser
			*/

			if (preg_match('/360 (?:Aphone|Android Phone) Browser \((?:Version |V)?([0-9.]*)(?:beta)?\)/u', $ua, $match)) {
				$this->browser->name = '360 Phone Browser';
				$this->browser->channel = '';
				$this->browser->version = null;
				$this->browser->version = new Version([ 'value' => $match[1] ]);
				
				if (preg_match('/360\(android/u', $ua) && (!isset($this->os->name) || ($this->os->name != 'Android' && (!isset($this->os->family) || $this->os->family->getName() != 'Android')))) {
					$this->os->name = 'Android';
					$this->os->version = null;
					$this->device->type = Constants\DeviceType::MOBILE;
				}
			}

			/****************************************************
			 *		iBrowser
			 */

			if (preg_match('/(iBrowser)\/([0-9.]*)/u', $ua, $match) && !preg_match('/OviBrowser/u', $ua)) {
				$this->browser->name = 'iBrowser';

				$version = $match[2];
				if (preg_match('/^[0-9][0-9]$/u', $version)) $version = $version[0] . '.' . $version[1];

				$this->browser->version = new Version([ 'value' => $version, 'details' => 2 ]);
				$this->browser->channel = '';
			}

			if (preg_match('/iBrowser\/Mini([0-9.]*)/u', $ua, $match)) {
				$this->browser->name = 'iBrowser Mini';
				$this->browser->version = new Version([ 'value' => $match[1], 'details' => 2 ]);
				$this->browser->channel = '';
			}

			/****************************************************
			 *		Puffin
			 */

			if (preg_match('/Puffin\/([0-9.]*)/u', $ua, $match)) {
				$this->browser->name = 'Puffin';
				$this->browser->version = new Version([ 'value' => $match[1], 'details' => 2 ]);
				$this->browser->mode = 'proxy';
				$this->browser->channel = '';

				$this->device->type = Constants\DeviceType::MOBILE;

				if ($this->os->name == 'Linux') {
					$this->os->name = null;
					$this->os->version = null;
				}
			}

			/****************************************************
			 *		Midori
			 */

			if (preg_match('/Midori\/([0-9.]*)/u', $ua, $match)) {
				$this->browser->name = 'Midori';
				$this->browser->version = new Version([ 'value' => $match[1] ]);

				$this->device->manufacturer = null;
				$this->device->model = null;
				$this->device->type = Constants\DeviceType::DESKTOP;

				if (isset($this->os->name) && $this->os->name == 'OS X') {
					$this->os->name = null;
					$this->os->version = null;
				}
			}

			if (preg_match('/midori(?:\/[0-9.]*)?$/u', $ua)) {
				$this->browser->name = 'Midori';
				$this->device->type = Constants\DeviceType::DESKTOP;
	
				if (preg_match('/midori\/([0-9.]*)$/u', $ua, $match)) {
					$this->browser->version = new Version([ 'value' => $match[1] ]);
				}
			}


			/****************************************************
			 *		MiniBrowser Mobile
			 */

			if (preg_match('/MiniBr?owserM(?:obile)?\/([0-9.]*)/u', $ua, $match)) {
				$this->browser->name = 'MiniBrowser';
				$this->browser->version = new Version([ 'value' => $match[1] ]);

				$this->os->name = 'Series60';
				$this->os->version = null;
			}

			/****************************************************
			 *		Maxthon
			 */

			if (preg_match('/Maxthon/iu', $ua, $match)) {
				$this->browser->name = 'Maxthon';
				$this->browser->channel = '';
				$this->browser->version = null;
				
				if (preg_match('/Maxthon[\/\' ]\(?([0-9.]*)\)?/iu', $ua, $match)) {
					$this->browser->version = new Version([ 'value' => $match[1], 'details' => 3 ]);
				}

				if (isset($this->os->name) && $this->browser->version && $this->os->name == 'Windows' && $this->browser->version->toFloat() < 4) {
					$this->browser->version->details = 1;
				}
			}

			if (preg_match('/MxNitro/iu', $ua, $match)) {
				$this->browser->name = 'Maxthon Nitro';
				$this->browser->channel = '';
				$this->browser->version = null;
				
				if (preg_match('/MxNitro\/([0-9.]*)/iu', $ua, $match)) {
					$this->browser->version = new Version([ 'value' => $match[1], 'details' => 3 ]);
				}
			}

			/****************************************************
			 *		WebPositive
			 */

			if (preg_match('/WebPositive/u', $ua, $match)) {
				$this->browser->name = 'WebPositive';
				$this->browser->channel = '';
				$this->browser->version = null;

				if (preg_match('/WebPositive\/([0-9]\.[0-9.]+)/u', $ua, $match)) {
					$this->browser->version = new Version([ 'value' => $match[1], 'details' => 3 ]);
				}
			}

			/****************************************************
			 *		WorldWideweb
			 */

			if (preg_match('/WorldWideweb \(NEXT\)/u', $ua, $match)) {
				$this->browser->name = 'WorldWideWeb';
				$this->browser->channel = '';
				$this->browser->version = null;

				$this->os->name = 'NextStep';
			}

			/****************************************************
			 *		Sogou Mobile
			 */

			if (preg_match('/SogouAndroidBrowser\/([0-9.]*)/u', $ua, $match)) {
				$this->browser->name = 'Sogou Mobile';
				$this->browser->version = new Version([ 'value' => $match[1] ]);

				if (isset($this->device->manufacturer) && $this->device->manufacturer == 'Apple') {
					unset($this->device->manufacturer);
					unset($this->device->model);
					unset($this->device->identifier);
					$this->device->identified = Constants\Id::NONE;
				}

				if (isset($this->os->name) && $this->os->name != 'Android') {
					$this->os->name = 'Android';
					$this->os->version = null;
				}
			}

			/****************************************************
			 *		Xiino
			 */

			if (preg_match('/Xiino\/([^;]+);/u', $ua, $match)) {
				$this->browser->name = 'Xiino';
				$this->browser->version = new Version([ 'value' => $match[1] ]);
				$this->os->name = 'Palm OS';
				$this->device->type = Constants\DeviceType::MOBILE;
			}

			/****************************************************
			 *		WebPro
			 */

			if (preg_match('/WebPro/u', $ua) && preg_match('/PalmOS/u', $ua)) {
				$this->browser->name = 'WebPro';
				$this->browser->version = null;

				if (preg_match('/WebPro\/([0-9.]*)/u', $ua, $match)) {
					$this->browser->version = new Version([ 'value' => $match[1] ]);
				}
			}



			/****************************************************
			 *		Others
			 */

			$browsers = [
				array('name' => 'AdobeAIR',				'regexp' => '/AdobeAIR\/([0-9.]*)/u'),
				array('name' => 'Awesomium',			'regexp' => '/Awesomium\/([0-9.]*)/u'),
				array('name' => 'Bsalsa Embedded',		'regexp' => '/EmbeddedWB ([0-9.]*)/u'),
				array('name' => 'Bsalsa Embedded',		'regexp' => '/bsalsa\.com/u'),
				array('name' => 'Bsalsa Embedded',		'regexp' => '/Embedded Web Browser/u'),
				array('name' => 'Canvace',				'regexp' => '/Canvace Standalone\/([0-9.]*)/u'),
				array('name' => 'Ekioh',				'regexp' => '/Ekioh\/([0-9.]*)/u'),
				array('name' => 'JavaFX',				'regexp' => '/JavaFX\/([0-9.]*)/u'),
				array('name' => 'GFXe',					'regexp' => '/GFXe\/([0-9.]*)/u'),
				array('name' => 'LuaKit',				'regexp' => '/luakit/u'),
				array('name' => 'Titanium',				'regexp' => '/Titanium\/([0-9.]*)/u'),
				array('name' => 'OpenWebKitSharp',		'regexp' => '/OpenWebKitSharp/u'),
				array('name' => 'Prism',				'regexp' => '/Prism\/([0-9.]*)/u'),
				array('name' => 'Qt',					'regexp' => '/Qt\/([0-9.]*)/u'),
				array('name' => 'Qt',					'regexp' => '/QtWebEngine\/([0-9.]*)/u'),
				array('name' => 'QtEmbedded',			'regexp' => '/QtEmbedded/u'),
				array('name' => 'QtEmbedded',			'regexp' => '/QtEmbedded.*Qt\/([0-9.]*)/u'),
				array('name' => 'ReqwirelessWeb',		'regexp' => '/ReqwirelessWeb\/([0-9.]*)/u'),
				array('name' => 'RhoSimulator',			'regexp' => '/RhoSimulator/u'),
				array('name' => 'UWebKit',				'regexp' => '/UWebKit\/([0-9.]*)/u'),
				array('name' => 'Node-WebKit',			'regexp' => '/nw-tests\/([0-9.]*)/u'),
				array('name' => 'WebKit2.NET',			'regexp' => '/WebKit2.NET/u'),

				array('name' => 'PhantomJS',			'regexp' => '/PhantomJS\/([0-9.]*)/u'),

				array('name' => 'Google Earth',			'regexp' => '/Google Earth\/([0-9.]*)/u'),
				array('name' => 'Google Desktop',		'regexp' => '/Google Desktop\/([0-9.]*)/u', 'details' => 2),

				array('name' => 'EA Origin',			'regexp' => '/Origin\/([0-9.]*)/u'),
				array('name' => 'SecondLife',			'regexp' => '/SecondLife\/([0-9.]*)/u'),
				array('name' => 'Valve Steam',			'regexp' => '/Valve Steam/u'),

				/* Media players */
				array('name' => 'iTunes',				'regexp' => '/iTunes\/(?:xaa.)?([0-9.]*)/u'),
				array('name' => 'QuickTime',			'regexp' => '/QuickTime[\/\\\\](?:xaa.)?([0-9.]*)/u'),
				array('name' => 'Bluefish',				'regexp' => '/bluefish ([0-9.]*)/u'),
				array('name' => 'Songbird',				'regexp' => '/Songbird\/([0-9.]*)/u'),
				array('name' => 'Stagefright',				'regexp' => '/stagefright\/([0-9.]*)/u'),
				array('name' => 'SubStream',			'regexp' => '/SubStream\/([0-9.]*)/u', 'type' => Constants\DeviceType::MOBILE),

				/* Email clients */
				array('name' => 'Lightning', 			'regexp' => '/Lightning\/([0-9.]*)/u'),
				array('name' => 'Thunderbird',			'regexp' => '/Thunderbird[\/ ]([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP),
				array('name' => 'Microsoft FrontPage',	'regexp' => '/MS FrontPage ([0-9.]*)/u', 'details' => 2, 'type' => Constants\DeviceType::DESKTOP),
				array('name' => 'Microsoft Outlook',	'regexp' => '/Microsoft Outlook IMO, Build ([0-9.]*)/u', 'details' => 2, 'type' => Constants\DeviceType::DESKTOP),
				array('name' => 'Microsoft Outlook',	'regexp' => '/Microsoft Outlook ([0-9.]*)/u', 'details' => 2, 'type' => Constants\DeviceType::DESKTOP),
				array('name' => 'Microsoft Outlook Express',	'regexp' => '/Outlook-Express\/([0-9.]*)/u', 'details' => 2, 'type' => Constants\DeviceType::DESKTOP),
				array('name' => 'Lotus Notes',			'regexp' => '/Lotus-Notes\/([0-9.]*)/u', 'details' => 2, 'type' => Constants\DeviceType::DESKTOP),
				array('name' => 'Postbox',				'regexp' => '/Postbox[\/ ]([0-9.]*)/u', 'details' => 2),

				/* Feed readers */
				array('name' => 'Akregator',			'regexp' => '/Akregator\/([0-9.]*)/u'),
				array('name' => 'Blogos',				'regexp' => '/Blogos\/([0-9.]*)/u', 'type' => Constants\DeviceType::MOBILE),
				array('name' => 'FeedDemon',			'regexp' => '/FeedDemon\/([0-9.]*)/u'),
				array('name' => 'Feeddler',				'regexp' => '/FeeddlerRSS\/([0-9.]*)/u', 'type' => Constants\DeviceType::MOBILE),
				array('name' => 'Feeddler Pro',			'regexp' => '/FeeddlerPro\/([0-9.]*)/u', 'type' => Constants\DeviceType::MOBILE),
				array('name' => 'Liferea',				'regexp' => '/Liferea\/([0-9.]*)/u'),
				array('name' => 'NewsBlur',				'regexp' => '/NewsBlur\/([0-9.]*)/u', 'type' => Constants\DeviceType::MOBILE),
				array('name' => 'Rss Bandit',			'regexp' => '/RssBandit\/([0-9.]*)/u'),
				array('name' => 'Rss Owl',				'regexp' => '/RSSOwl\/([0-9.]*)/u'),
				array('name' => 'Reeder',				'regexp' => '/Reeder\/([0-9.]*)/u'),
				array('name' => 'ReedKit',				'regexp' => '/ReedKit\/([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP),

				/* Social apps */
				array('name' => 'Facebook',				'regexp' => '/FBAN\/FBIOS/u'),
				array('name' => 'Facebook',				'regexp' => '/FB_IAB\/FB4A/u'),
				array('name' => 'Google+',				'regexp' => '/com.google.GooglePlus/u' ),
				array('name' => 'WeChat',				'regexp' => '/MicroMessenger\/([0-9.]*)/u'),
				array('name' => 'Sina Weibo',			'regexp' => '/weibo__([0-9.]*)/u'),
				array('name' => 'Twitter',				'regexp' => '/TwitterAndroid/u'),
				array('name' => 'Kik',					'regexp' => '/Kik\/([0-9.]*)/u'),

				/* Office suite */
				array('name' => 'Microsoft Office',		'regexp' => '/MSOffice ([0-9.]*)/u'),


				/* Search */
				array('name' => 'NAVER',				'regexp' => '/NAVER\(inapp; search; [0-9]+; ([0-9.]*)\)/u'),

				/* Media players */
				array('name' => 'CorePlayer',			'regexp' => '/CorePlayer\/([0-9.]*)/u'),
				array('name' => 'FlyCast',				'regexp' => '/FlyCast\/([0-9.]*)/u'),

				/* Editors */
				array('name' => 'W3C Amaya',			'regexp' => '/amaya\/([0-9.]*)/u'),

				/* Browsers */
				array('name' => '1Browser',				'regexp' => '/1Password\/([0-9.]*)/u'),
				array('name' => '2345 Browser',			'regexp' => '/Mb2345Browser\/([0-9.]*)/u'),
				array('name' => '3G Explorer',			'regexp' => '/3G Explorer\/([0-9.]*)/u', 'details' => 3),
				array('name' => '4G Explorer',			'regexp' => '/4G Explorer\/([0-9.]*)/u', 'details' => 3),
				array('name' => '360 Aphone Browser',	'regexp' => '/360 Aphone Browser\(([0-9.]*)\)/u'),
				array('name' => '360 Extreme Explorer',	'regexp' => '/QIHU 360EE/u', 'type' => Constants\DeviceType::DESKTOP),
				array('name' => '360 Safe Explorer',	'regexp' => '/QIHU 360SE/u', 'type' => Constants\DeviceType::DESKTOP),
				array('name' => 'ABrowse',				'regexp' => '/A[Bb]rowse ([0-9.]*)/u'),
				array('name' => 'Abrowser',				'regexp' => '/Abrowser\/([0-9.]*)/u'),
				array('name' => 'Acorn Browse',			'regexp' => '/Acorn Browse ([0-9.]+)/u' ),
				array('name' => 'AltiBrowser',			'regexp' => '/AltiBrowser\/([0-9.]*)/i'),
				array('name' => 'AOL Desktop',			'regexp' => '/AOL ([0-9.]*); AOLBuild/i'),
				array('name' => 'AOL Browser',			'regexp' => '/America Online Browser (?:[0-9.]*); rev([0-9.]*);/i'),
				array('name' => 'Arachne',				'regexp' => '/Arachne\/([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP),
				array('name' => 'Arora',				'regexp' => '/[Aa]rora\/([0-9.]*)/u'),							// see: www.arora-browser.org
				array('name' => 'Avant Browser',		'regexp' => '/Avant Browser/u'),
				array('name' => 'Avant Browser',		'regexp' => '/Avant TriCore/u'),
				array('name' => 'Aviator',				'regexp' => '/Aviator\/([0-9.]*)/u', 'details' => 1),
				array('name' => 'Awakening',			'regexp' => '/Awakening Browser\/([0-9.]*)/u', 'details' => 2),
				array('name' => 'AWeb',					'regexp' => '/Amiga-AWeb(?:\/([0-9.]*))?/u'),
				array('name' => 'Baidu Browser',		'regexp' => '/bdbrowser\/([0-9.]*)/i'),
				array('name' => 'Baidu Browser',		'regexp' => '/bdbrowser_i18n\/([0-9.]*)/i'),
				array('name' => 'Baidu Browser',		'regexp' => '/M?BaiduBrowser\/([0-9.]*)/i'),
				array('name' => 'Baidu Browser',		'regexp' => '/BdMobile\/([0-9.]*)/i'),
				array('name' => 'Baidu Browser',		'regexp' => '/FlyFlow\/([0-9.]*)/u', 'details' => 2),
				array('name' => 'Baidu Browser',		'regexp' => '/BIDUBrowser[ \/]([0-9.]*)/u'),
				array('name' => 'Baidu Browser',		'regexp' => '/BaiduHD\/([0-9.]*)/u', 'details' => 2),
				array('name' => 'Baidu Spark',			'regexp' => '/BDSpark\/([0-9.]*)/u', 'details' => 2),
				array('name' => 'Baidu Hao123',			'regexp' => '/hao123\/([0-9.]*)/u', 'details' => 2),
				array('name' => 'Black Wren',			'regexp' => '/BlackWren\/([0-9.]*)/u', 'details' => 2),
				array('name' => 'Blazer',				'regexp' => '/Blazer\/([0-9.]*)/u'),
				array('name' => 'BrightSign', 			'regexp' => '/BrightSign\/([0-9.]*)/u', 'type' => Constants\DeviceType::SIGNAGE),
				array('name' => 'Bunjalloo',			'regexp' => '/Bunjalloo\/([0-9.]*)/u'),															// Browser for the Nintento DS
				array('name' => 'Byffox', 				'regexp' => '/Byffox\/([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP),
				array('name' => 'Camino', 				'regexp' => '/Camino\/([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP),
				array('name' => 'Canure', 				'regexp' => '/Canure\/([0-9.]*)/u', 'details' => 3),
				array('name' => 'CometBird', 			'regexp' => '/CometBird\/([0-9.]*)/u'),
				array('name' => 'Comodo Dragon', 		'regexp' => '/Comodo_Dragon\/([0-9.]*)/u', 'details' => 2),
				array('name' => 'Comodo Dragon', 		'regexp' => '/Dragon\/([0-9.]*)/u', 'details' => 2),
				array('name' => 'Conkeror', 			'regexp' => '/[Cc]onkeror\/([0-9.]*)/u'),
				array('name' => 'CoolNovo', 			'regexp' => '/(?:CoolNovo|CoolNovoChromePlus)\/([0-9.]*)/u', 'details' => 3, 'type' => Constants\DeviceType::DESKTOP),
				array('name' => 'ChromePlus', 			'regexp' => '/ChromePlus(?:\/([0-9.]*))?$/u', 'details' => 3, 'type' => Constants\DeviceType::DESKTOP),
				array('name' => 'Cunaguaro', 			'regexp' => '/Cunaguaro\/([0-9.]*)/u', 'details' => 3, 'type' => Constants\DeviceType::DESKTOP),
				array('name' => 'CuteBrowser', 			'regexp' => '/CuteBrowser\/([0-9.]*)/u', 'details' => 2),
				array('name' => 'Cyberfox', 			'regexp' => '/Cyberfox\/([0-9.]*)/u', 'details' => 2),
				array('name' => 'Daedalus', 			'regexp' => '/Daedalus ([0-9.]*)/u', 'details' => 2),
				array('name' => 'Daum', 				'regexp' => '/DaumApps\/([0-9.]*)/u'),
				array('name' => 'Daum', 				'regexp' => '/daumcafe\/([0-9.]*)/u'),
				array('name' => 'Dillo', 				'regexp' => '/Dillo\/([0-9.]*)/u'),
				array('name' => 'Demobrowser', 			'regexp' => '/demobrowser\/([0-9.]*)/u'),
				array('name' => 'Doga Rhodonit', 		'regexp' => '/DogaRhodonit/u'),
				array('name' => 'Dorado', 				'regexp' => '/Browser\/Dorado([0-9.]*)/u'),
				array('name' => 'Dooble', 				'regexp' => '/Dooble(?:\/([0-9.]*))?/u'),
				array('name' => 'Dorothy', 				'regexp' => '/Dorothy$/u'),
				array('name' => 'DWB', 					'regexp' => '/dwb(?:-hg)?(?:\/([0-9.]*))?/u'),
				array('name' => 'GNOME Web', 			'regexp' => '/Epiphany\/([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP),
				array('name' => 'ELinks', 				'regexp' => '/ELinks\/([0-9.]*[0-9])/u', 'type' => Constants\DeviceType::DESKTOP),
				array('name' => 'EVM Browser', 			'regexp' => '/EVMBrowser\/([0-9.]*)/u'),
				array('name' => 'FireWeb', 				'regexp' => '/FireWeb\/([0-9.]*)/u'),
				array('name' => 'Flock', 				'regexp' => '/Flock\/([0-9.]*)/u', 'details' => 3, 'type' => Constants\DeviceType::DESKTOP),
				array('name' => 'Galeon', 				'regexp' => '/Galeon\/([0-9.]*)/u', 'details' => 3),
				array('name' => 'Helium', 				'regexp' => '/HeliumMobileBrowser\/([0-9.]*)/u'),
				array('name' => 'Hive Explorer', 		'regexp' => '/HiveE/u'),
				array('name' => 'IBrowse', 				'regexp' => '/IBrowse[\/ ]([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP),
				array('name' => 'iCab', 				'regexp' => '/iCab\/([0-9.]*)/u'),
				array('name' => 'Iceape', 				'regexp' => '/Iceape\/([0-9.]*)/u'),
				array('name' => 'IceCat', 				'regexp' => '/IceCat[ \/]([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP),
				array('name' => 'Comodo IceDragon', 	'regexp' => '/IceDragon\/([0-9.]*)/u', 'details' => 2, 'type' => Constants\DeviceType::DESKTOP),
				array('name' => 'Iceweasel', 			'regexp' => '/Iceweasel\/([0-9.]*)/iu', 'type' => Constants\DeviceType::DESKTOP),
				array('name' => 'InternetSurfboard', 	'regexp' => '/InternetSurfboard\/([0-9.]*)/u'),
				array('name' => 'Iron', 				'regexp' => '/Iron\/([0-9.]*)/u', 'details' => 2),
				array('name' => 'Isis', 				'regexp' => '/BrowserServer/u'),
				array('name' => 'Isis', 				'regexp' => '/ISIS\/([0-9.]*)/u', 'details' => 2),
				array('name' => 'Jumanji', 				'regexp' => '/jumanji/u'),
				array('name' => 'Kazehakase', 			'regexp' => '/Kazehakase\/([0-9.]*)/u'),
				array('name' => 'KChrome', 				'regexp' => '/KChrome\/([0-9.]*)/u', 'details' => 3),
				array('name' => 'Kiosk', 				'regexp' => '/Kiosk\/([0-9.]*)/u'),
				array('name' => 'K-Meleon', 			'regexp' => '/K-Meleon\/([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP),
				array('name' => 'Lbbrowser',			'regexp' => '/LBBROWSER/u'),
				array('name' => 'Leechcraft', 			'regexp' => '/Leechcraft(?:\/([0-9.]*))?/u', 'details' => 2),
				array('name' => 'LieBaoFast', 			'regexp' => '/LieBaoFast\/([0-9.]*)/u'),
				array('name' => 'Lobo', 				'regexp' => '/Lobo\/([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP),
				array('name' => 'Lotus Expeditor', 		'regexp' => '/Gecko Expeditor ([0-9.]*)/u', 'details' => 3),
				array('name' => 'Lunascape', 			'regexp' => '/Lunascape[\/| ]([0-9.]*)/u', 'details' => 3),
				array('name' => 'Lynx', 				'regexp' => '/Lynx\/([0-9.]*)/u'),
				array('name' => 'iLunascape', 			'regexp' => '/iLunascape\/([0-9.]*)/u', 'details' => 3),
				array('name' => 'Intermec Browser', 	'regexp' => '/Intermec\/([0-9.]*)/u', 'details' => 2),
				array('name' => 'Jig Browser', 			'regexp' => '/jig browser(?: core|9i?)/u'),
				array('name' => 'MaCross Mobile', 		'regexp' => '/MaCross\/([0-9.]*)/u'),
				array('name' => 'Mammoth', 				'regexp' => '/Mammoth\/([0-9.]*)/u'),										// see: https://itunes.apple.com/cn/app/meng-ma-liu-lan-qi/id403760998?mt=8
				array('name' => 'Maxthon', 				'regexp' => '/MxBrowser\/([0-9.]*)/u'),
				array('name' => 'Mercury Browser', 		'regexp' => '/Mercury\/([0-9.]*)/u'),
				array('name' => 'MixShark', 			'regexp' => '/MixShark\/([0-9.]*)/u'),
				array('name' => 'mlbrowser',			'regexp' => '/mlbrowser/u'),
				array('name' => 'Motorola WebKit', 		'regexp' => '/MotorolaWebKit(?:\/([0-9.]*))?/u', 'details' => 3),
				array('name' => 'NetFront Life Browser', 'regexp' => '/NetFrontLifeBrowser\/([0-9.]*)/u'),
				array('name' => 'NetPositive', 			'regexp' => '/NetPositive\/([0-9.]*)/u'),
				array('name' => 'Netscape Navigator', 	'regexp' => '/Navigator\/([0-9.]*)/u', 'details' => 3),
				array('name' => 'Odyssey', 				'regexp' => '/OWB\/([0-9.]*)/u'),
				array('name' => 'OmniWeb', 				'regexp' => '/OmniWeb/u', 'type' => Constants\DeviceType::DESKTOP),
				array('name' => 'OneBrowser', 			'regexp' => '/OneBrowser\/([0-9.]*)/u'),
				array('name' => 'Openwave',				'regexp' => '/Openwave\/([0-9.]*)/u', 'details' => 2),
				array('name' => 'Openwave', 			'regexp' => '/UP\.Browser\/([a-z0-9.]*)/iu', 'details' => 2),
				array('name' => 'Opera Oupeng', 		'regexp' => '/Oupeng\/([0-9.]*)/u', 'details' => 2),
				array('name' => 'Oregano', 				'regexp' => '/Oregano ([0-9.]*)/u'),
				array('name' => 'Orca', 				'regexp' => '/Orca\/([0-9.]*)/u'),
				array('name' => 'Origyn', 				'regexp' => '/Origyn Web Browser/u'),
				array('name' => 'Otter', 				'regexp' => '/Otter Browser\/([0-9.]*)/u'),
				array('name' => 'Pale Moon', 			'regexp' => '/Pale[mM]oon\/([0-9.]*)/u'),
				array('name' => 'Phantom', 				'regexp' => '/Phantom\/V([0-9.]*)/u'),
				array('name' => 'Polaris', 				'regexp' => '/Polaris[\/ ]v?([0-9.]*)/iu', 'details' => 2),
				array('name' => 'Polaris', 				'regexp' => '/POLARIS([0-9.]+)/u', 'details' => 2),
				array('name' => 'Qihoo 360', 			'regexp' => '/QIHU THEWORLD/u'),
				array('name' => 'QtCreator', 			'regexp' => '/QtCreator\/([0-9.]*)/u'),
				array('name' => 'QtQmlViewer', 			'regexp' => '/QtQmlViewer/u'),
				array('name' => 'QtTestBrowser', 		'regexp' => '/QtTestBrowser\/([0-9.]*)/u'),
				array('name' => 'QtWeb', 				'regexp' => '/QtWeb Internet Browser\/([0-9.]*)/u'),
				array('name' => 'QupZilla', 			'regexp' => '/QupZilla\/([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP),
				array('name' => 'Ryouko', 				'regexp' => '/Ryouko\/([0-9.]*)/u', 'type' => Constants\DeviceType::DESKTOP),						// see: https://github.com/foxhead128/ryouko
				array('name' => 'Roccat', 				'regexp' => '/Roccat\/([0-9]\.[0-9.]*)/u'),
				array('name' => 'Raven for Mac', 		'regexp' => '/Raven for Mac\/([0-9.]*)/u'),
				array('name' => 'rekonq', 				'regexp' => '/rekonq(?:\/([0-9.]*))?/u', 'type' => Constants\DeviceType::DESKTOP),
				array('name' => 'RockMelt', 			'regexp' => '/RockMelt\/([0-9.]*)/u', 'details' => 2),
				array('name' => 'SaaYaa Explorer', 		'regexp' => '/SaaYaa/u', 'type' => Constants\DeviceType::DESKTOP),
				array('name' => 'SEMC Browser', 		'regexp' => '/SEMC-Browser\/([0-9.]*)/u'),
				array('name' => 'Sleipnir', 			'regexp' => '/Sleipnir\/([0-9.]*)/u', 'details' => 3),
				array('name' => 'SlimBoat', 			'regexp' => '/SlimBoat\/([0-9.]*)/u'),
				array('name' => 'SMBrowser', 			'regexp' => '/SMBrowser/u'),
				array('name' => 'Sogou Explorer', 		'regexp' => '/SE 2.X MetaSr/u', 'type' => Constants\DeviceType::DESKTOP),
				array('name' => 'Sogou Mobile',			'regexp' => '/SogouMobileBrowser\/([0-9.]*)/u', 'details' => 2),
				array('name' => 'Snowshoe', 			'regexp' => '/Snowshoe\/([0-9.]*)/u', 'details' => 2),
				array('name' => 'Sputnik', 				'regexp' => '/Sputnik\/([0-9.]*)/iu', 'details' => 3),
				array('name' => 'Stainless', 			'regexp' => '/Stainless\/([0-9.]*)/u'),
				array('name' => 'SunChrome', 			'regexp' => '/SunChrome\/([0-9.]*)/u'),
				array('name' => 'Superbird', 			'regexp' => '/Superbird\/([0-9.]*)/u', 'details' => 2),
				array('name' => 'Surf', 				'regexp' => '/Surf\/([0-9.]*)/u'),
				array('name' => 'The World', 			'regexp' => '/TheWorld ([0-9.]*)/u'),
				array('name' => 'TaoBrowser', 			'regexp' => '/TaoBrowser\/([0-9.]*)/u', 'details' => 2),
				array('name' => 'TaomeeBrowser', 		'regexp' => '/TaomeeBrowser\/([0-9.]*)/u', 'details' => 2),
				array('name' => 'TazWeb', 				'regexp' => '/TazWeb/u'),
				array('name' => 'Tencent Traveler', 	'regexp' => '/TencentTraveler ([0-9.]*)/u', 'details' => 2),
				array('name' => 'Uzbl', 				'regexp' => '/^Uzbl/u'),
				array('name' => 'Viera Browser', 		'regexp' => '/Viera\/([0-9.]*)/u'),
				array('name' => 'Villanova', 			'regexp' => '/Villanova\/([0-9.]*)/u', 'details' => 3),
				array('name' => 'Vimb', 				'regexp' => '/vimb\/([0-9.]*)/u'),
				array('name' => 'Vivaldi', 				'regexp' => '/Vivaldi\/([0-9.]*)/u', 'details' => 2),
				array('name' => 'Voyager',				'regexp' => '/AmigaVoyager\/([0-9.]*)/u'),
				array('name' => 'WADA Browser',			'regexp' => '/WadaBrowser\/([0-9.]*)/u'),
				array('name' => 'Waterfox', 			'regexp' => '/Waterfox\/([0-9.]*)/u', 'details' => 2, 'type' => Constants\DeviceType::DESKTOP),
				array('name' => 'Wavelink Velocity',	'regexp' => '/Wavelink Velocity Browser\/([0-9.]*)/u', 'details' => 2),
				array('name' => 'WebLite', 				'regexp' => '/WebLite\/([0-9.]*)/u', 'type' => Constants\DeviceType::MOBILE),
				array('name' => 'WebRender', 			'regexp' => '/WebRender/u'),
				array('name' => 'Webster', 				'regexp' => '/Webster ([0-9.]*)/u'),
				array('name' => 'Wear Internet Browser','regexp' => '/WIB\/([0-9.]*)/u'),
				array('name' => 'Wyzo', 				'regexp' => '/Wyzo\/([0-9.]*)/u', 'details' => 3),
				array('name' => 'Miui Browser', 		'regexp' => '/XiaoMi\/MiuiBrowser\/([0-9.]*)/u'),
				array('name' => 'Yandex Browser', 		'regexp' => '/YaBrowser\/([0-9.]*)/u', 'details' => 2),
				array('name' => 'Yelang', 				'regexp' => '/Yelang\/([0-9.]*)/u', 'details' => 3),							// see: wellgo.org
				array('name' => 'YRC Weblink', 			'regexp' => '/YRCWeblink\/([0-9.]*)/u'),
				array('name' => 'Zetakey', 				'regexp' => '/Zetakey Webkit\/([0-9.]*)/u'),
				array('name' => 'Zetakey', 				'regexp' => '/Zetakey\/([0-9.]*)/u'),
				array('name' => '冲浪浏览器', 			'regexp' => '/CMSurfClient-Android/u'),

				array('name' => 'Nimbus', 				'regexp' => '/Nimbus\/([0-9.]*)/u'),

				array('name' => 'McAfee Web Gateway', 	'regexp' => '/Webwasher\/([0-9.]*)/u'),
				array('name' => 'Android Download Manager', 'regexp' => '/AndroidDownloadManager\/([0-9.]*)/u'),

				array('name' => 'Open Sankoré', 		'regexp' => '/Open-Sankore\/([0-9.]*)/u', 'type' => Constants\DeviceType::WHITEBOARD),
				array('name' => 'Coship MMCP', 			'regexp' => '/Coship_MMCP_([0-9.]*)/u', 'type' => Constants\DeviceType::SIGNAGE),

				/* Bots */

			];

			for ($b = 0; $b < count($browsers); $b++) {
				if (preg_match($browsers[$b]['regexp'], $ua, $match)) {
					$this->browser->name = $browsers[$b]['name'];
					$this->browser->channel = '';
					$this->browser->hidden = false;
					$this->browser->stock = false;

					if (isset($match[1]) && $match[1]) {
						$this->browser->version = new Version([ 'value' => $match[1], 'details' => isset($browsers[$b]['details']) ? $browsers[$b]['details'] : null ]);
					} else {
						$this->browser->version = null;
					}

					if (isset($browsers[$b]['type'])) {
						$this->device->type = $browsers[$b]['type'];
					}
				}
			}


			/****************************************************
			 *		WebKit
			 */

			if (preg_match('/WebKit\/([0-9.]*)/iu', $ua, $match)) {
				$this->engine->name = 'Webkit';
				$this->engine->version = new Version([ 'value' => $match[1] ]);

				if (preg_match('/(?:Chrome|Chromium)\/([0-9]*)/u', $ua, $match)) {
					if (intval($match[1]) >= 27) {
						$this->engine->name = 'Blink';
					}
				}
			}

			if (preg_match('/Browser\/AppleWebKit\/?([0-9.]*)/iu', $ua, $match)) {
				$this->engine->name = 'Webkit';
				$this->engine->version = new Version([ 'value' => $match[1] ]);
			}

			if (preg_match('/AppleWebkit\(like Gecko\)/iu', $ua, $match)) {
				$this->engine->name = 'Webkit';
			}


			/****************************************************
			 *		KHTML
			 */

			if (preg_match('/KHTML\/([0-9.]*)/u', $ua, $match)) {
				$this->engine->name = 'KHTML';
				$this->engine->version = new Version([ 'value' => $match[1] ]);
			}

			/****************************************************
			 *		Gecko
			 */

			if (preg_match('/Gecko/u', $ua) && !preg_match('/like Gecko/iu', $ua)) {
				$this->engine->name = 'Gecko';

				if (preg_match('/; rv:([^\);]+)[\);]/u', $ua, $match)) {
					$this->engine->version = new Version([ 'value' => $match[1], 'details' => 3 ]);
				}
			}

			/****************************************************
			 *		Presto
			 */

			if (preg_match('/Presto\/([0-9.]*)/u', $ua, $match)) {
				$this->engine->name = 'Presto';
				$this->engine->version = new Version([ 'value' => $match[1] ]);
			}

			/****************************************************
			 *		Trident
			 */

			if (preg_match('/Trident\/([0-9.]*)/u', $ua, $match)) {
				$this->engine->name = 'Trident';
				$this->engine->version = new Version([ 'value' => $match[1] ]);


				if (isset($this->browser->version) && isset($this->browser->name) && $this->browser->name == 'Internet Explorer') {
					if ($this->engine->version->toNumber() == 7 && $this->browser->version->toFloat() < 11) {
						$this->browser->version = new Version([ 'value' => '11.0' ]);
						$this->browser->mode = 'compat';
					}

					if ($this->engine->version->toNumber() == 6 && $this->browser->version->toFloat() < 10) {
						$this->browser->version = new Version([ 'value' => '10.0' ]);
						$this->browser->mode = 'compat';
					}

					if ($this->engine->version->toNumber() == 5 && $this->browser->version->toFloat() < 9) {
						$this->browser->version = new Version([ 'value' => '9.0' ]);
						$this->browser->mode = 'compat';
					}

					if ($this->engine->version->toNumber() == 4 && $this->browser->version->toFloat() < 8) {
						$this->browser->version = new Version([ 'value' => '8.0' ]);
						$this->browser->mode = 'compat';
					}
				}

				if (isset($this->os->version) && isset($this->os->name) && $this->os->name == 'Windows Phone' && isset($this->browser->name) && $this->browser->name == 'Mobile Internet Explorer') {
					if ($this->engine->version->toNumber() == 7 && $this->os->version->toFloat() < 8.1) {
						$this->os->version = new Version([ 'value' => '8.1' ]);
					}

					if ($this->engine->version->toNumber() == 6 && $this->os->version->toFloat() < 8) {
						$this->os->version = new Version([ 'value' => '8.0' ]);
					}

					if ($this->engine->version->toNumber() == 5 && $this->os->version->toFloat() < 7.5) {
						$this->os->version = new Version([ 'value' => '7.5' ]);
					}
				}
			}

			if (preg_match('/Edge\/([0-9.]*)/u', $ua, $match)) {
				$this->engine->name = 'EdgeHTML';
				$this->engine->version = new Version([ 'value' => $match[1], 'details' => 1 ]);
			}


			/****************************************************
			 *		Corrections
			 */

			if (isset($this->os->name) && isset($this->browser->name)) {
				if ($this->os->name == 'iOS' && ($this->browser->name == 'Opera Mini' && $this->browser->version->toFloat() < 8)) {
					$this->os->version = null;
				}

				if ($this->os->name == 'Series80' && $this->browser->name == 'Internet Explorer') {
					$this->browser->name = null;
					$this->browser->version = null;
				}

				if ($this->os->name == 'Tizen' && $this->browser->name == 'Chrome') {
					$this->browser->name = null;
					$this->browser->version = null;
				}

				if ($this->os->name == 'Ubuntu Touch' && $this->browser->name == 'Chromium') {
					$this->browser->name = null;
					$this->browser->version = null;
				}
			}

			if (isset($this->browser->name) && isset($this->engine->name)) {
				if ($this->browser->name == 'Midori' && $this->engine->name != 'Webkit') {
					$this->engine->name = 'Webkit';
					$this->engine->version = null;
				}
			}


			if (isset($this->browser->name) && $this->browser->name == 'Firefox Mobile' && !isset($this->os->name)) {
				$this->os->name = 'Firefox OS';
			}


			if (isset($this->os->name) && $this->os->name == 'Windows Phone' && isset($this->browser->name) && $this->browser->name == 'Mobile Internet Explorer') {
				if ($this->os->version->toFloat() == 8.0 && $this->browser->version->toNumber() < 10) {
					$this->browser->version = new Version([ 'value' => '11' ]);
				}

				if ($this->os->version->toFloat() == 8.1 && $this->browser->version->toNumber() < 11) {
					$this->browser->version = new Version([ 'value' => '11' ]);
				}
			}


			if (isset($this->browser->name) && $this->browser->name == 'Opera' && $this->device->type == Constants\DeviceType::TELEVISION) {
				$this->browser->name = 'Opera Devices';

				if (preg_match('/Presto\/([0-9]+\.[0-9]+)/u', $ua, $match)) {
					switch($match[1]) {
						case '2.12':		$this->browser->version = new Version([ 'value' => '3.4' ]); break;
						case '2.11':		$this->browser->version = new Version([ 'value' => '3.3' ]); break;
						case '2.10':		$this->browser->version = new Version([ 'value' => '3.2' ]); break;
						case '2.9':			$this->browser->version = new Version([ 'value' => '3.1' ]); break;
						case '2.8':			$this->browser->version = new Version([ 'value' => '3.0' ]); break;
						case '2.7':			$this->browser->version = new Version([ 'value' => '2.9' ]); break;
						case '2.6':			$this->browser->version = new Version([ 'value' => '2.8' ]); break;
						case '2.4':			$this->browser->version = new Version([ 'value' => '10.3' ]); break;
						case '2.3':			$this->browser->version = new Version([ 'value' => '10' ]); break;
						case '2.2':			$this->browser->version = new Version([ 'value' => '9.7' ]); break;
						case '2.1':			$this->browser->version = new Version([ 'value' => '9.6' ]); break;
						default:			unset($this->browser->version);
					}
				}

				else if (preg_match('/OMI\/([0-9]+\.[0-9]+)/u', $ua, $match)) {
					$this->browser->version = new Version([ 'value' => $match[1] ]);
				}

				else if (preg_match('/OPR\/([0-9]+)/u', $ua, $match)) {
					switch($match[1]) {
						case '17':			$this->browser->version = new Version([ 'value' => '4.0' ]); break;
						case '19':			$this->browser->version = new Version([ 'value' => '4.1' ]); break;
						case '22':			$this->browser->version = new Version([ 'value' => '4.2' ]); break;
						default:			unset($this->browser->version);
					}
				}

				unset($this->os->name);
				unset($this->os->version);
			}

			if (isset($this->browser->name)) {
				if ($this->browser->name == 'UC Browser') {
					if (!preg_match("/UBrowser\//", $ua) && ($this->device->type == 'desktop' || (isset($this->os->name) && ($this->os->name == 'Windows' || $this->os->name == 'OS X')))) {
						$this->device->type = Constants\DeviceType::MOBILE;

						$this->browser->mode = 'desktop';

						unset($this->engine->name);
						unset($this->engine->version);
						unset($this->os->name);
						unset($this->os->version);
					}

					else if (!isset($this->os->name) || ($this->os->name != 'iOS' && $this->os->name != 'Windows Phone' && $this->os->name != 'Windows' && $this->os->name != 'Android' && (!isset($this->os->family) || $this->os->family->getName() != 'Android'))) {
						$this->engine->name = 'Gecko';
						unset($this->engine->version);
						$this->browser->mode = 'proxy';
					}

					if (isset($this->engine->name) && $this->engine->name == 'Presto') {
						$this->engine->name = 'Webkit';
						unset($this->engine->version);
					}
				}
			}

			if (isset($this->device->flag) && $this->device->flag == Constants\Flag::NOKIAX) {
				$this->os->name = 'Nokia X Platform';
				$this->os->family = new Family([ 'name' => 'Android' ]);

				unset($this->os->version);
				unset($this->device->flag);
			}

			if (isset($this->device->flag) && $this->device->flag == Constants\Flag::FIREOS) {
				$this->os->name = 'FireOS';
				$this->os->family = new Family([ 'name' => 'Android' ]);

				if (isset($this->os->version) && isset($this->os->version->value)) {
					switch($this->os->version->value) {
						case '2.3.3':	$this->os->version = new Version([ 'value' => '1' ]); break;
						case '4.0.3':	$this->os->version = new Version([ 'value' => '2' ]); break;
						case '4.2.2':	$this->os->version = new Version([ 'value' => '3' ]); break;
						case '4.4.2':	$this->os->version = new Version([ 'value' => '4' ]); break;
						case '4.4.3':	$this->os->version = new Version([ 'value' => '4.5' ]); break;
						case '5.1.1':	$this->os->version = new Version([ 'value' => '5' ]); break;
						default:		unset($this->os->version); break;
					}
				}

				if ($this->isBrowser('Chrome')) {
					$this->browser->using = new Using([ 'name' => 'Amazon WebView' ]); 

					$this->browser->stock = false;
					$this->browser->name = null;
					$this->browser->version = null;
					$this->browser->channel = null;
				}

				if ($this->browser->isUsing('Chromium WebView')) {
					$this->browser->using = new Using([ 'name' => 'Amazon WebView' ]); 
				}

				unset($this->device->flag);
			}

			if (isset($this->device->flag) && $this->device->flag == Constants\Flag::GOOGLETV) {
				$this->os->name = 'Google TV';
				$this->os->family = new Family([ 'name' => 'Android' ]);

				unset($this->os->version);
				unset($this->device->flag);
			}

			if (isset($this->device->flag) && $this->device->flag == Constants\Flag::ANDROIDTV) {
				$this->os->name = 'Android TV';
				$this->os->family = new Family([ 'name' => 'Android' ]);

				unset($this->device->flag);
			}

			if (isset($this->device->flag) && $this->device->flag == Constants\Flag::ANDROIDWEAR) {
				$this->os->name = 'Android Wear';
				$this->os->family = new Family([ 'name' => 'Android' ]);
				unset($this->os->version);

				if (preg_match('/Chrome\/19\.77\.34\.5/u', $ua)) {
					$this->browser->name = "Wear Internet Browser";
					$this->browser->version = null;
				}
				else {
					$this->browser->stock = true;
					$this->browser->hidden = true;
				}

				unset($this->browser->channel);
				unset($this->device->flag);
			}

			if (isset($this->device->flag) && $this->device->flag == Constants\Flag::GOOGLEGLASS) {
				$this->os->family = new Family([ 'name' => 'Android' ]);
				unset($this->os->name);
				unset($this->os->version);
				unset($this->device->flag);
			}


			if (isset($this->os->name)) {
				if ($this->os->name == 'Android' && !isset($this->browser->using) && !isset($this->browser->name) && $this->browser->stock) {
					$this->browser->name = 'Android Browser';
				}

				if ($this->os->name == 'Aliyun OS' && !isset($this->browser->using) && !isset($this->browser->name) && $this->browser->stock) {
					$this->browser->name = 'Aliyun Browser';
				}

				if ($this->os->name == 'Google TV' && !isset($this->browser->name) && $this->browser->stock) {
					$this->browser->name = 'Chrome';
				}

				if ($this->os->name == 'BlackBerry' && !isset($this->browser->name) && $this->browser->stock) {
					$this->browser->name = 'BlackBerry Browser';
					$this->browser->hidden = true;
				}

				if ($this->os->name == 'BlackBerry OS' && !isset($this->browser->name) && $this->browser->stock) {
					$this->browser->name = 'BlackBerry Browser';
					$this->browser->hidden = true;
				}

				if ($this->os->name == 'BlackBerry Tablet OS' && !isset($this->browser->name) && $this->browser->stock) {
					$this->browser->name = 'BlackBerry Browser';
					$this->browser->hidden = true;
				}

				if ($this->os->name == 'Tizen' && !isset($this->browser->name) && $this->browser->stock && $this->device->type == Constants\DeviceType::MOBILE) {
					$this->browser->name = 'Samsung Browser';
				}

				if ($this->os->name == 'Aliyun OS' && $this->browser->stock) {
					$this->browser->hidden = true;
				}

				if ($this->os->name == 'Darwin' && $this->device->type == Constants\DeviceType::MOBILE) {
					$this->os->name = 'iOS';

					switch (strstr($this->os->getVersion(), '.', true)) {
						case '9':		$this->os->version = new Version([ 'value' =>'1' ]); $this->os->alias = 'iPhone OS'; break;
						case '10':		$this->os->version = new Version([ 'value' =>'4' ]); break;
						case '11':		$this->os->version = new Version([ 'value' =>'5' ]); break;
						case '13':		$this->os->version = new Version([ 'value' =>'6' ]); break;
						case '14':		$this->os->version = new Version([ 'value' =>'7' ]); break;
						case '15':		$this->os->version = new Version([ 'value' =>'9' ]); break;
						default:		$this->os->version = null;
					}
				}

				if ($this->os->name == 'Darwin' && $this->device->type == Constants\DeviceType::DESKTOP) {
					$this->os->name = 'OS X';

					switch (strstr($this->os->getVersion(), '.', true)) {
						case '1':		$this->os->version = new Version([ 'value' =>'10.0' ]); break;
						case '5':		$this->os->version = new Version([ 'value' =>'10.1' ]); break;
						case '6':		$this->os->version = new Version([ 'value' =>'10.2' ]); break;
						case '7':		$this->os->version = new Version([ 'value' =>'10.3' ]); break;
						case '8':		$this->os->version = new Version([ 'value' =>'10.4' ]); break;
						case '9':		$this->os->version = new Version([ 'value' =>'10.5' ]); break;
						case '10':		$this->os->version = new Version([ 'value' =>'10.6' ]); break;
						case '11':		$this->os->version = new Version([ 'value' =>'10.7' ]); break;
						case '12':		$this->os->version = new Version([ 'value' =>'10.8' ]); break;
						case '13':		$this->os->version = new Version([ 'value' =>'10.9' ]); break;
						case '14':		$this->os->version = new Version([ 'value' =>'10.10' ]); break;
						case '15':		$this->os->version = new Version([ 'value' =>'10.11' ]); break;
						default:		$this->os->version = null;
					}

					if (!empty($this->os->version)) {
						if ($this->os->version->is('<', '10.7')) $this->os->alias = 'Mac OS X';
						if ($this->os->version->is('10.7')) $this->os->version->nickname = 'Lion';
						if ($this->os->version->is('10.8')) $this->os->version->nickname = 'Mountain Lion';
						if ($this->os->version->is('10.9')) $this->os->version->nickname = 'Mavericks';
						if ($this->os->version->is('10.10')) $this->os->version->nickname = 'Yosemite';
						if ($this->os->version->is('10.11')) $this->os->version->nickname = 'El Capitan';
					}
				}			
			}


			if (preg_match('/Bot[\/;]/iu', $ua) || preg_match('/Robot[\/;]/iu', $ua) || preg_match('/Spider[\/;]/iu', $ua) || preg_match('/Crawler[\/;]/iu', $ua)) {
				$this->device->identified = false;
				$this->device->type = Constants\DeviceType::BOT;

				unset($this->browser->name);
				unset($this->browser->alias);
				unset($this->browser->version);

				unset($this->os->name);
				unset($this->os->alias);
				unset($this->os->version);

				unset($this->engine->name);
				unset($this->engine->alias);
				unset($this->engine->version);

				unset($this->device->manufacturer);
				unset($this->device->model);
				unset($this->device->identifier);
			}

			if ($bot = Data\Bots::identify($ua)) {
				$this->browser = $bot;

				$this->device->identified = false;
				$this->device->type = Constants\DeviceType::BOT;

				unset($this->os->name);
				unset($this->os->alias);
				unset($this->os->version);

				unset($this->engine->name);
				unset($this->engine->alias);
				unset($this->engine->version);

				unset($this->device->manufacturer);
				unset($this->device->model);
				unset($this->device->identifier);
			}

			if (!$this->device->identified && isset($this->device->model)) {
				if (preg_match('/^[a-z][a-z]-[a-z][a-z]$/u', $this->device->model)) {
					$this->device->model = null;
				}
			}


			if ((isset($this->os->name) && $this->os->name == 'Android') || isset($this->os->name) && $this->os->name == 'Android TV') {
				if (preg_match('/Build\/([^\);]+)/u', $ua, $match)) {
					$version = Data\BuildIds::identify('android', $match[1]);

					if ($version) {
						if (!isset($this->os->version) || $this->os->version == null || $this->os->version->value == null || $version->toFloat() < $this->os->version->toFloat()) {
							$this->os->version = $version;
						}

						/* Special case for Android L */
						if ($version->toFloat() == 5) {
							$this->os->version = $version;
						}
					}

					$this->os->build = $match[1];
				}
			}

			if ($this->device->type == Constants\DeviceType::TELEVISION) {
				if (isset($this->browser->name) && $this->browser->name == 'Firefox') {
					unset($this->browser->name);
					unset($this->browser->version);
				}

				if (isset($this->browser->name) && $this->browser->name == 'Internet Explorer') {
					$valid = false;
					if (isset($this->device->model) && in_array($this->device->model, [ 'WebTV' ])) $valid = true;

					if (!$valid) {
						unset($this->browser->name);
						unset($this->browser->version);
					}
				}

				if (isset($this->browser->name) && ($this->browser->name == 'Chrome' || $this->browser->name == 'Chromium')) {
					$valid = false;
					if (isset($this->os->name) && in_array($this->os->name, [ 'Google TV', 'Android' ])) $valid = true;
					if (isset($this->device->model) && in_array($this->device->model, [ 'Chromecast' ])) $valid = true;

					if (!$valid) {
						unset($this->browser->name);
						unset($this->browser->version);
					}
				}
			}


			/* And finally try to detect Netscape */
			if ($this->device->type == Constants\DeviceType::DESKTOP && $this->browser->getName() == '') {
				if (!preg_match('/compatible;/u', $ua)) {
					if (preg_match('/Mozilla\/([123].[0-9]+)/u', $ua, $match)) {
						$this->browser->name = 'Netscape Navigator';
						$this->browser->version = new Version([ 'value' => preg_replace("/([0-9])([0-9])/", '$1.$2', $match[1]) ]);
					}				

					if (preg_match('/Mozilla\/(4.[0-9]+)/u', $ua, $match)) {
						$this->browser->name = 'Netscape Communicator';
						$this->browser->version = new Version([ 'value' => preg_replace("/([0-9])([0-9])/", '$1.$2', $match[1]) ]);
					}				
				}
			}
		}	
	}