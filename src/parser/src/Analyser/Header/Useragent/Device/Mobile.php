<?php

	namespace WhichBrowser\Analyser\Header\Useragent\Device;

	use WhichBrowser\Constants;
	use WhichBrowser\Data;
	use WhichBrowser\Version;

	trait Mobile {


		private function detectMobileFromUseragent($ua) {

			/* Detect the type based on some common markers */
			$this->detectGenericMobileFromUseragent($ua);

			/* Look for specific manufacturers and models */
			$this->detectKinFromUseragent($ua);

			/* Try to parse some generic methods to store device information */
			$this->detectGenericMobileModelsFromUseragent($ua);
		}






		/* Generic markers */

		private function detectGenericMobileFromUseragent($ua) {
			if (preg_match('/MIDP/u', $ua)) {
				$this->device->type = Constants\DeviceType::MOBILE;
			}
		}


		/* Microsoft KIN */

		private function detectKinFromUseragent($ua) {
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
		}


		/* Model information not in a fixed place */

		private function detectGenericMobileModelsFromUseragent($ua) {
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

				if (preg_match('/Huawei\/1.0\/0?([^\s]+)/u', $ua, $match)) {
					array_push($candidates, 'HUAWEI-' . $match[1]);
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

				if (preg_match('/(?:DDIPOCKET|WILLCOM);([a-z]+\/[^\/]+)/iu', $ua, $match)) {
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

							if (preg_match('/^KYOCERA\/([^\s]+)/ui', $candidates[$i], $match)) {
								$this->device->manufacturer = 'Kyocera';
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

							if (preg_match('/^Micromax([^\)]+)/ui', $candidates[$i], $match)) {
								$this->device->manufacturer = 'Micromax';
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

							if (preg_match('/^SANYO\/([^\/]+)$/ui', $candidates[$i], $match)) {
								$this->device->manufacturer = 'Sanyo';
								$this->device->model = Data\DeviceModels::cleanup($match[1]);
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

			if (preg_match('/Vodafone\/[0-9.]+\/V([0-9]+[A-Z]+)[^\/]*\//ui', $ua, $match)) {
				$this->device->manufacturer = 'Vodafone';
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
		}
	}