<?php

	header("Content-Type: text/javascript");
	header("Cache-Control: no-cache, must-revalidate"); 
	header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); 

	include('libraries/whichbrowser.php');
		
	$detected = new WhichBrowser(apache_request_headers());

?>
	
var WhichBrowser = (function(){
	
 	var Version = function() { this.initialize.apply(this, Array.prototype.slice.call(arguments)) };
	Version.prototype = {
		initialize: function(v) {
			this.original = v.value || null;
			this.alias = v.alias || null;
			this.details = v.details || null;
			this.builds = typeof v.builds != 'undefined' ? v.builds : true;

			this.major = 0;
			this.minor = 0;
			this.revision = '';
			this.build = '';
			this.type = '';
						
			var match;
			if (match = /([0-9]+)(?:\.([0-9]+))?(?:\.([0-9]+))?(?:\.([0-9]+))?(?:([ab])([0-9]+))?/.exec(this.original)) {
				if (typeof match[1] != 'undefined') {
					this.major = match[1];
				}

				if (typeof match[2] != 'undefined') {
					this.minor = match[2];
				}

				if (typeof match[3] != 'undefined') {
					this.revision = match[3];
				}

				if (typeof match[4] != 'undefined') {
					this.build = match[4];
				}

				if (typeof match[5] != 'undefined') {
					switch(match[5]) {
						case 'a':	this.type = 'alpha'; break;
						case 'b':	this.type = 'beta'; break;
					}

					if (typeof match[6] != 'undefined') {
						this.build = match[6];
					}
				}
			}
		},
		
		is: function(v) {
			var valid = false;
			
			if (arguments.length > 0) {
				var operator = '=';
				var compare = null;
				
				if (arguments.length == 1) {
					compare = new Version({ value: arguments[0] });
				}
				
				if (arguments.length >= 2) {
					operator = arguments[0];
					compare = new Version({ value: arguments[1] });
				}
				
				if (compare) {
					switch (operator) {
						case '<':	valid = this.valueOf() < compare.valueOf(); break;
						case '<=':	valid = this.valueOf() <= compare.valueOf(); break;
						case '=':	valid = this.valueOf() == compare.valueOf(); break;
						case '>':	valid = this.valueOf() > compare.valueOf(); break;
						case '>=':	valid = this.valueOf() >= compare.valueOf(); break;
					}
				}
				
				return valid;
			}
			
			return false;
		},
		
		valueOf: function() {
			return parseFloat('' + this.major + '.' + ('0000' + this.minor).slice(-4) + ('0000' + this.revision).slice(-4));
		},
		
		toJSON: function() {
			var o = {
				value:		this.toString(),
				details:	this.details,
				original:	this.original,
				major:		this.major,
				minor:		this.minor,
				build:		this.build,
				revision:	this.revision
			};
			
			if (this.type) o.type = this.type;
			if (this.alias) o.alias = this.alias;
			
			return o;
		},
		
		toString: function() {
			if (this.alias)
				return this.alias;

			var version = '';

			if (this.major || this.minor) {
				var v = [];
				v.push(this.major);
				if (this.minor != '' && this.minor != null) v.push(this.minor);
				if (this.revision != '' && this.revision != null) v.push(this.revision);
				if (this.type == '' && this.build) v.push(this.build);
				if (this.details < 0) v.splice(this.details, 0 - this.details);
				if (this.details > 0) v.splice(this.details, v.length - this.details);
				
				if (!this.builds) {
					for (var i = 0; i < v.length; i++) {
						if (v[i] > 999) {
							v.splice(i, 1);
							i--;
						}					
					}
				}
				
				version = v.join('.');
			
				if (this.type != '') version += this.type[0] + (this.build ? this.build : '');
			}

			return version;
		}
	}
	

 	var Detected = function() { this.initialize.apply(this, arguments) };
	Detected.prototype = {
		initialize: function(options) {
			this.options = {
				useFeatures:		options && options.useFeatures || false,
				detectCamouflage:	options && options.detectCamouflage || false
			}

<?php $detected->toJavaScript(); ?>

			this.camouflage = false;
			this.features = [];
			
			this.detect(navigator.userAgent);
		},
		
		isX: function() {
			var valid = true;
			var x = arguments[0];
			
			if (arguments.length >= 2) {
				valid = valid && this[x].name == arguments[1];
			}
			
			if (arguments.length >= 4 && typeof this[x].version != 'undefined' && valid) {
				var v1 = 0 + this[x].version;
				var v2 = 0 + new Version({ value: arguments[3] });
				switch (arguments[2]) {
					case '<':	valid = valid && v1 < v2; break;
					case '<=':	valid = valid && v1 <= v2; break;
					case '=':	valid = valid && v1 == v2; break;
					case '>':	valid = valid && v1 > v2; break;
					case '>=':	valid = valid && v1 >= v2; break;
				}
			}
			
			return valid;
		},
		
		isBrowser: function() { var a = Array.prototype.slice.call(arguments); a.unshift('browser'); return this.isX.apply(this, a); },
		isEngine: function() { var a = Array.prototype.slice.call(arguments); a.unshift('engine'); return this.isX.apply(this, a); },
		isOs: function() { var a = Array.prototype.slice.call(arguments); a.unshift('os'); return this.isX.apply(this, a); },
				
		isType: function() {
			var valid = false;
			for (var a = 0; a < arguments.length; a++) valid = valid || arguments[a] == this.device.type;
			return valid;
		},

		detect: function(ua) {
			if (ua == 'Mozilla/5.0 (X11; U; Linux i686; zh-CN; rv:1.2.3.4) Gecko/') {
				if (this.browser.name != 'UC Browser') {
					this.browser.name = 'UC Browser';
					this.browser.version = null;
					this.engine.name = 'Gecko';
				}
				
				if (this.os.name == 'Windows') {
					this.os.name = '';
					this.os.version = null;
				}
				
				this.engine.name = 'Gecko';
				this.engine.version = null;
				
				this.device.type = 'mobile';
			}
		
			if (this.options.detectCamouflage) {

				if (match = /Mac OS X 10_6_3; ([^;]+); [a-z]{2}-(?:[a-z]{2})?\)/.exec(ua)) {
					this.browser.name = '';
					this.browser.version = null;
					this.browser.mode = 'desktop';
					
					this.os.name = 'Android';
					this.os.version = null;
				
					this.engine.name = 'Webkit';
					this.engine.version = null;
	
					this.features.push('foundDevice');
				}

				if (match = /Linux Ventana; [a-z]{2}-[a-z]{2}; (.+) Build/.exec(ua)) {
					this.browser.name = '';
					this.browser.version = null;
					this.browser.mode = 'desktop';
					
					this.os.name = 'Android';
					this.os.version = null;
				
					this.engine.name = 'Webkit';
					this.engine.version = null;
	
					this.features.push('foundDevice');
				}

				if (this.browser.name == 'Safari') {
					if (this.os.name != 'iOS' && /AppleWebKit\/([0-9]+.[0-9]+)/i.exec(ua)[1] != /Safari\/([0-9]+.[0-9]+)/i.exec(ua)[1]) {
						this.features.push('safariMismatch');
						this.camouflage = true;			
					}
	
					if (this.os.name == 'iOS' && ! ua.match(/^Mozilla/)) {
						this.features.push('noMozillaPrefix');
						this.camouflage = true;			
					}

					if (! /Version\/[0-9\.]+/.exec(ua)) {
						this.features.push('noVersion');
						this.camouflage = true;			
					}
				}
				
				if (this.browser.name == 'Chrome'){
					if (! /(?:Chrome|CrMo|CriOS)\/([0-9]{1,2}\.[0-9]\.[0-9]{3,4}\.[0-9]+)/.exec(ua)) {
						this.features.push('wrongVersion');
						this.camouflage = true;			
					}
				}


				if (this.options.useFeatures && this.browser.mode != 'proxy') {
					/* If it claims not to be Trident, but it is probably Trident running camouflage mode */
					if (window.ActiveXObject) {
						this.features.push('trident');		
		
						if (typeof this.engine.name != 'undefined' && this.engine.name != 'Trident') {
							this.camouflage = typeof this.browser.name == 'undefined' || (this.browser.name != 'Maxthon' && this.browser.name != 'Motorola WebKit');			
						}	
					}
				
					/* If it claims not to be Opera, but it is probably Opera running camouflage mode */
					if (window.opera) {
						this.features.push('presto');		
		
						if (typeof this.engine.name != 'undefined' && this.engine.name != 'Presto') {
							this.camouflage = true;			
						}	

						if (this.browser.name == 'Internet Explorer') {
							this.camouflage = true;			
						}
					}
					
					/* If it claims not to be Gecko, but it is probably Gecko running camouflage mode */
					if ('getBoxObjectFor' in document || 'mozInnerScreenX' in window) {
						this.features.push('gecko');		
		
						if (typeof this.engine.name != 'undefined' && this.engine.name != 'Gecko') {
							this.camouflage = true;			
						}	
						
						if (this.browser.name == 'Internet Explorer') {
							this.camouflage = true;			
						}
					}
					
					/* If it claims not to be Webkit, but it is probably Webkit running camouflage mode */
					if ('WebKitCSSMatrix' in window || 'WebKitPoint' in window || 'webkitStorageInfo' in window || 'webkitURL' in window) {
						this.features.push('webkit');		
		
						if (typeof this.engine.name != 'undefined' && (this.engine.name != 'Blink' && this.engine.name != 'Webkit')) {
							this.camouflage = true;			
						}	

						if (this.browser.name == 'Internet Explorer') {
							this.camouflage = true;			
						}
					}
					
					
					
					/* If it claims to be Safari and uses V8, it is probably an Android device running camouflage mode */
					if (this.engine.name == 'Webkit' && ({}.toString).toString().indexOf("\n") === -1) {
						this.features.push('v8');		

						if (this.browser != null && this.browser.name == 'Safari') {
							this.camouflage = true;	
						}	
					}
	
	
					/* If we have an iPad that is not 768 x 1024, we have an imposter */
					if (this.device.model == 'iPad') {
						if ((screen.width != 0 && screen.height != 0) && (screen.width != 768 && screen.height != 1024) && (screen.width != 1024 && screen.height != 768)) {
							this.features.push('sizeMismatch');
							this.camouflage = true;			
						}				
					}
					
					/* If we have an iPhone or iPod that is not 320 x 480, we have an imposter */
					if (this.device.model == 'iPhone' || this.device.model == 'iPod') {
						if ((screen.width != 0 && screen.height != 0) && (screen.width != 320 && screen.height != 480) && (screen.width != 480 && screen.height != 320)) {
							this.features.push('sizeMismatch');
							this.camouflage = true;			
						}				
					}
					
					
					if (this.os.name == 'iOS' && this.browser.name != 'Opera Mini' && this.browser.name != 'UC Browser' && this.os.version) {
					
						if (this.os.version.is('<', '4.0') && 'sandbox' in document.createElement('iframe')) {
							this.features.push('foundSandbox');
							this.camouflage = true;			
						}
						
						if (this.os.version.is('<', '4.2') && 'WebSocket' in window) {
							this.features.push('foundSockets');
							this.camouflage = true;			
						}
	
						if (this.os.version.is('<', '5.0') && !!window.Worker) {
							this.features.push('foundWorker');
							this.camouflage = true;			
						}

						if (this.os.version.is('>', '2.1') && !window.applicationCache) {
							this.features.push('noAppCache');
							this.camouflage = true;			
						}
					}
					
					if (this.os.name != 'iOS' && this.browser.name == 'Safari' && this.browser.version) {
					
						if (this.browser.version.is('<', '4.0') && !!window.applicationCache) {
							this.features.push('foundAppCache');
							this.camouflage = true;			
						}
					
						if (this.browser.version.is('<', '4.1') && !!(window.history && history.pushState)) {
							this.features.push('foundHistory');
							this.camouflage = true;			
						}
					
						if (this.browser.version.is('<', '5.1') && !!document.documentElement.webkitRequestFullScreen) {
							this.features.push('foundFullscreen');
							this.camouflage = true;			
						}
					
						if (this.browser.version.is('<', '5.2') && 'FileReader' in window) {
							this.features.push('foundFileReader');
							this.camouflage = true;			
						}
					}
				}
			}
		},
		
		toJSON: function() {
			var o = {
				browser:	{},
				os:			{},
				engine:		{},
				device:		{
					type:		this.device.type,
					identified:	this.device.identified
				}
			};
			
			if (this.browser.name) o.browser.name = this.browser.name;
			if (this.browser.version) o.browser.version = this.browser.version.toJSON();
			if (this.browser.stock) o.browser.stock = this.browser.stock;
			if (this.browser.channel) o.browser.channel = this.browser.channel;
			if (this.browser.mode) o.browser.mode = this.browser.mode;
			if (this.browser.hidden) o.browser.hidden = this.browser.hidden;

			if (this.engine.name) o.engine.name = this.engine.name;
			if (this.engine.version) o.engine.version = this.engine.version.toJSON();

			if (this.os.name) o.os.name = this.os.name;
			if (this.os.version) o.os.version = this.os.version.toJSON();

			if (this.device.manufacturer) o.device.manufacturer = this.device.manufacturer;
			if (this.device.model) o.device.model = this.device.model;
		
			return o;
		},
		
		toString: function() {
			var prefix = this.camouflage ? 'an unknown browser that imitates ' : '';
			var browser = os = device = engine = '';
			
			browser += (this.browser.name ? this.browser.name + (this.browser.channel ? ' ' + this.browser.channel : '') + (this.browser.version ? ' ' + this.browser.version.toString() : '') : '');
			os += (this.os.name ? this.os.name + (this.os.version ? ' ' + this.os.version.toString() : '') : '');
			engine += (typeof this.engine.name != 'undefined' && this.engine.name ? this.engine.name : '') ;
			
			if (this.device.identified)			
				device += (typeof this.device.manufacturer != 'undefined' && this.device.manufacturer ? this.device.manufacturer + ' ' : '') + (typeof this.device.model != 'undefined' && this.device.model ? this.device.model : '');
			else
				device += (typeof this.device.model != 'undefined' && this.device.model ? 'unrecognized device (' + this.device.model + ')' : '');
			
			if (!device && !os && this.device.type == 'television') {
				device = 'television';
			}
		
			if (!device && this.device.type == 'emulator') {
				device = 'emulator';
			}
		
			if (browser && os && device) {
				return prefix + browser + ' on a ' + device + ' running ' + os;
			}
		
			else if (browser && !os && device) {
				return prefix + browser + ' on a ' + device;
			}
		
			else if (browser && os && !device) {
				return prefix + browser + ' on ' + os;
			}
		
			else if (!browser && os && device) {
				return prefix + 'a ' + device + ' running ' + os;
			}
		
			else if (browser && !os && !device) {
				return prefix + browser;
			}
		
			else if (!browser && !os && device) {
				return prefix + 'a ' + device;
			}
		
			else if (this.device.type == 'desktop' && os && engine != '' && !device) {
				return 'an unknown browser based on ' + engine + ' running on ' + os;
			}
		
			else if (this.browser.stock && os && !device) {
				return os;
			}
		
			else if (this.browser.stock && engine != '' && !device) {
				return 'an unknown browser based on ' + engine;
			}
		
			else {
				return 'an unknown browser';
			}
		}
	};

	return Detected;
})();	
