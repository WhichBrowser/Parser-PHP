<?php

	/*
		Copyright (c) 2010-2013 Niels Leenheer
		 
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
	*/
	
	
		
	define ('TYPE_DESKTOP', 'desktop');
	define ('TYPE_MOBILE', 'mobile');
	define ('TYPE_TABLET', 'tablet');
	define ('TYPE_GAMING', 'gaming');
	define ('TYPE_EREADER', 'ereader');
	define ('TYPE_MEDIA', 'media');
	define ('TYPE_EMULATOR', 'emulator');
	define ('TYPE_TELEVISION', 'television');
	define ('TYPE_MONITOR', 'monitor');
	define ('TYPE_CAMERA', 'camera');
	define ('TYPE_SIGNAGE', 'signage');
	define ('TYPE_WHITEBOARD', 'whiteboard');
	define ('TYPE_CAR', 'car');
	define ('TYPE_POS', 'pos');
	define ('TYPE_BOT', 'bot');

	define ('FLAG_GOOGLETV', 1);

	
	class BrowserIds {
		static $ANDROID_BROWSERS = array(
//			com.android.browser
//			com.google.android.browser

//			com.hydrastream.hydroid
//			com.oupeng.browser

			'com.qihoo.browser'									=> '360 Phone Browser',
			'net.adgjm.angel'									=> 'Angel Browser',
			'com.apc.browser'									=> 'APC',
			'com.baidu.browser.apps'							=> 'Baidu Browser',
			'com.baidu.browser.inter'							=> 'Baidu Browser',
			'com.baidu.searchbox'								=> 'Baidu Browser',
			'com.boatbrowser.free'								=> 'Boat Browser',
			'com.boatgo.browser'								=> 'Boat Browser Mini',
			'com.ericsson.research.mario'						=> 'Bowser',
			'mobi.mgeek.TunnyBrowser'							=> 'Dolphin',
			'com.dolphin.browser.android.jp'					=> 'Dolphin',
			'com.dolphin.browser.pad'							=> 'Dolphin',
			'com.dolphin.browser.lab.cn'						=> 'Dolphin Beta',
			'com.dolphin.browser.lab.en'						=> 'Dolphin Beta',
			'com.dolphin.browser.cn'							=> 'Dolphin Mini',
			'com.dolphin.browser.en'							=> 'Dolphin Mini',
			'easy.browser.classic'								=> 'Easy Browser',
			'easy.browser.com'									=> 'Easy Browser',
			'it.blogspot.fedeveloper'							=> 'Emergency Browser',	
			'gpc.myweb.hinet.net.PopupWeb'						=> 'Floating Browser Flux',
			'galaxy.browser.gb.free'							=> 'Galaxy Browser',
			'galaxy.browser.gb.pro'								=> 'Galaxy Browser',
			'jp.ddo.pigsty.Habit_Browser'						=> 'Habit Browser',
			'com.adsi.kioware.client.mobile.app'				=> 'KioWare Kiosk',
			'com.vng.android.zingbrowser'						=> 'Laban',
			'acr.browser.barebones'								=> 'Lightning Browser',
			'com.mx.browser'									=> 'Maxthon',
			'com.mx.browser.tablet'								=> 'Maxthon',
			'com.fevdev.nakedbrowser'							=> 'Naked Browser',
			'com.nhn.android.search'							=> 'Naver',
			'com.access_company.android.nflifebrowser.lite'		=> 'NetFront LifeBrowser',
			'com.ninesky.browser'								=> 'Ninesky',
			'com.compal.android.browser'						=> 'Ocean Browser',
			'com.tencent.ibibo.mtt'								=> 'One Browser',
			'info.guardianproject.browser'						=> 'Orweb',	
			'com.appsverse.photon'								=> 'Photon Browser',
			'com.tencent.international.mtt'						=> 'QQ Browser',
			'com.tencent.mobileqq'								=> 'QQ Browser',
			'com.tencent.padbrowser'							=> 'QQ Browser',
			'com.skyfire.consumer.browser'						=> 'Skyfire',
			'jp.co.fenrir.android.sleipnir'						=> 'Sleipnir',
			'jp.co.fenrir.android.sleipnir_test'				=> 'Sleipnir',
			'com.mns.android.swing'								=> 'Swing Browser',
			'org.tint'											=> 'Tint Browser',
			'com.UCMobile'										=> 'UC Browser',
			'com.UCMobile.intl'									=> 'UC Browser',
			'com.uc.browser.hd'									=> 'UC Browser',
			'com.uc.browser.en'									=> 'UC Browser Mini',
			'sui.mRelease'										=> 'xScope Browser Pro',
			'org.zirco'											=> 'Zirco Browser',
			
			'com.jv.falcon.pro'									=> 'Falcon Pro',
			'com.noinnion.android.greader.readerpro'			=> 'gReader Pro',
			'com.levelup.touiteur'								=> 'Plume',
			'com.andrewshu.android.redditdonation'				=> 'Reddit is fun',
			'com.sina.weibo'									=> 'Sina Weibo'
		);

		function identify($type, $model) {
			switch($type) {
				case 'android':		return BrowserIds::identifyList(BrowserIds::$ANDROID_BROWSERS, $model);
			}

			return false;
		}
		
		function identifyList($list, $id) {
			if (isset($list[$id])) {
				return $list[$id];
			}
			
			return false;
		}
	}

	
	class BuildIds {
		static $ANDROID_BUILDS = array(
			'CUPCAKE'		=> '1.5',
			'DONUT'			=> '1.6',
			'ECLAIR'		=> '2.0',
			'FROYO'			=> '2.2',
			'GINGERBREAD'	=> '2.3',
			
			'DRC83'			=> '1.6',
			'DRC92'			=> '1.6',
			'DRD08'			=> '1.6',
			'DRD20'			=> '1.6',	
			'DMD64'			=> '1.6',
			'ESD20'			=> '2.0',
			'ESD56'			=> '2.0.1',
			'ERD79'			=> '2.1',
			'ERE27'			=> '2.1',
			'EPE54B'		=> '2.1',
			'ESE81'			=> '2.1',
			'EPF21B'		=> '2.1',
			'FRF85B'		=> '2.2',
			'FRF91'			=> '2.2',
			'FRG01B'		=> '2.2',
			'FRG22D'		=> '2.2',
			'FRG83'			=> '2.2.1',
			'FRG83D'		=> '2.2.1',
			'FRG83G'		=> '2.2.2',
			'FRK76'			=> '2.2.3',
			'FRK76C'		=> '2.2.3',
			'GRH55'			=> '2.3',
			'GRH78'			=> '2.3.1',
			'GRH78C'		=> '2.3.2',
			'GRI40'			=> '2.3.3',
			'GRI54'			=> '2.3.3',
			'GRJ06D'		=> '2.3.4',
			'GRJ22'			=> '2.3.4',
			'GRJ90'			=> '2.3.5',
			'GRK39C'		=> '2.3.6',
			'GRK39F'		=> '2.3.6',
			'GWK74'			=> '2.3.7',
			
			'HRI39'			=> '3.0',
			'HRI66'			=> '3.0',
			'HWI69'			=> '3.0',
			'HRI83'			=> '3.0',
			'HMJ37'			=> '3.1',
			'HTJ85B'		=> '3.2',
			'HTK55D'		=> '3.2.1',
			'HTK75D'		=> '3.2.1',
			'HLK75C'		=> '3.2.2',
			'HLK75D'		=> '3.2.2',
			'HLK75F'		=> '3.2.4',
			'HLK75H'		=> '3.2.6',
			
			'ITL41D'		=> '4.0.1',
			'ITL41E'		=> '4.0.1',
			'ITL41F'		=> '4.0.1',
			'ICL53F'		=> '4.0.2',
			'IML74K'		=> '4.0.3',
			'IML77'			=> '4.0.3',
			'IMM76'			=> '4.0.4',
			'IMM76D'		=> '4.0.4',
			'IMM76I'		=> '4.0.4',
			'IMM76K'		=> '4.0.4',
			'IMM76L'		=> '4.0.4',
			'JRO03C'		=> '4.1.1',
			'JRO03D'		=> '4.1.1',
			'JRO03E'		=> '4.1.1',
			'JRO03H'		=> '4.1.1',
			'JRO03L'		=> '4.1.1',
			'JRO03O'		=> '4.1.1',
			'JRO03R'		=> '4.1.1',
			'JRO03S'		=> '4.1.1',
			'JZO54K'		=> '4.1.2',
			'JOP40C'		=> '4.2',
			'JOP40D'		=> '4.2.1',
			'JOP40F'		=> '4.2.1',
			'JOP40G'		=> '4.2.1',
			'JDQ39'			=> '4.2.2',
		);

		function identify($type, $id) {
			switch($type) {
				case 'android':		return BuildIds::identifyList(BuildIds::$ANDROID_BUILDS, $id);
			}

			return false;
		}
		
		function identifyList($list, $id) {
			if (isset($list[$id])) {
				return new Version(array('value' => $list[$id])); 
			}
			
			return false;
		}
	}
	
	class DeviceModels {
		static $ANDROID_MODELS = array(
			/* Generic identifiers */
			'Android'									=> array( null, null ),		
			'google sdk'								=> array( null, null, TYPE_EMULATOR ),		
			'sdk'										=> array( null, null, TYPE_EMULATOR ),
			'generic'									=> array( null, null ),
			'generic x86'								=> array( null, null ),
			'VirtualBox!'								=> array( null, null, TYPE_EMULATOR ),		
			
			/* Development boards and kits */
			'amd brazos'								=> array( 'AMD', 'Fusion based device' ),
			'Amlogic M1 reference board'				=> array( 'Amlogic', 'M1 reference board' ),
			'AML8726M'									=> array( 'Amlogic', 'AML8726-M based device' ),
			'vexpress a9'								=> array( 'ARM', 'Versatile Express development platform' ),
			'sama5d3'									=> array( 'Atmel', 'SAMA5D3 based device' ),
			'BEAGLEBONE'								=> array( 'BeagleBoard', 'BeagleBone' ),
			'bcm7231'									=> array( 'Broadcom', 'BCM7231 based device', TYPE_TELEVISION ),
			'bcm7425'									=> array( 'Broadcom', 'BCM7425 based device', TYPE_TELEVISION ),
			'bcm7429'									=> array( 'Broadcom', 'BCM7429 based device', TYPE_TELEVISION ),
			'BCM21664!'									=> array( 'Broadcom', 'BCM21664 based device' ),
			'BCM28145!'									=> array( 'Broadcom', 'BCM28145 based device' ),
			'BCM28155!'									=> array( 'Broadcom', 'BCM28155 based device' ),
			'imx50!'									=> array( 'Freescale', 'i.MX50 based device' ),
			'imx51!'									=> array( 'Freescale', 'i.MX51 based device' ),
			'imx53!'									=> array( 'Freescale', 'i.MX53 based device' ),
			'imx6q!'									=> array( 'Freescale', 'i.MX6Q based device' ),
			'SABRESD-MX6DQ'								=> array( 'Freescale', 'i.MX6DQ based device' ),
			'ODROID-A'									=> array( 'Hardkernel', 'ODROID-A developer tablet', TYPE_TABLET ),
			'ODROID-U2'									=> array( 'Hardkernel', 'ODROID-U2 developer board' ),
			'cedartrail'								=> array( 'Intel', 'Cedar Trail based device' ),
			'mfld (dv10|dv20|lw00|pr2|pr3)!'			=> array( 'Intel', 'Medfield based device' ),
			'redhookbay'								=> array( 'Intel', 'Merrifield based device' ),
			'Shark Bay Client platform'					=> array( 'Intel', 'Haswell based device' ),
			'BP710A'									=> array( 'Intel', 'Yukka Beach based device' ),
			'berlin bg2!'								=> array( 'Marvell', 'Armada based device', TYPE_TELEVISION ),
			'berlin generic!'							=> array( 'Marvell', 'Armada based device', TYPE_TELEVISION ),
			'bg2 !'										=> array( 'Marvell', 'Armada based device', TYPE_TELEVISION ),		
			'bg2ct !'									=> array( 'Marvell', 'Armada based device', TYPE_TELEVISION ),		
			'MStar Amber3'								=> array( 'MStar', 'Amber3 based device' ),
			'Konka Amber3'								=> array( 'MStar', 'Amber3 based device' ),
			'mt5396'									=> array( 'Mediatek', 'MT5396 based device', TYPE_TELEVISION ),
			'baoxue'									=> array( 'Mediatek', 'MT6573 based device' ),
			'bird75v2'									=> array( 'Mediatek', 'MT6575 based device' ),
			'eagle75v1 2'								=> array( 'Mediatek', 'MT6575 based device' ),
			'mt6575!'									=> array( 'Mediatek', 'MT6575 based device' ),		
			'mt6582!'									=> array( 'Mediatek', 'MT6582 based device' ),		
			'mt6589!'									=> array( 'Mediatek', 'MT6589 based device' ),		
			'mt8658'									=> array( 'Mediatek', 'MT8658 based device' ),
			'MBX DVBT reference board (c03ref)'			=> array( 'MXB', 'DVBT reference board', TYPE_TELEVISION ),
			'NS115' 									=> array( 'Nufront', 'NuSmart 115 based device' ),
			'NS2816'									=> array( 'Nufront', 'NuSmart 2816 based device' ),
			'Ventana'									=> array( 'nVidia', 'Tegra Ventana development kit' ),
			'Cardhu'									=> array( 'nVidia', 'Tegra 3 based device' ),
			'Panda(Board)?!'							=> array( 'Pandaboard', 'Development Kit' ),
			'MSM'										=> array( 'Qualcomm', 'Snapdragon based device' ),
			'msm(7227|7627)!'							=> array( 'Qualcomm', 'Snapdragon S1 based device' ),
			'msm7630!'									=> array( 'Qualcomm', 'Snapdragon S2 based device' ),
			'msm8660!'									=> array( 'Qualcomm', 'Snapdragon S3 based device' ),
			'msm(8625|8960)!'							=> array( 'Qualcomm', 'Snapdragon S4 based device' ),
			'msm8974!'									=> array( 'Qualcomm', 'Snapdragon based device' ),
			'rk2808(sdk)?!'								=> array( 'Rockchip', 'RK2808 based device' ),
			'rk2818(sdk)?!'								=> array( 'Rockchip', 'RK2818 based device' ),
			'Android-for-Rockchip-2818'					=> array( 'Rockchip', 'RK2818 based device' ),
			'rk29sdk'									=> array( 'Rockchip', 'RK29 based device' ),
			'rk30sdk'									=> array( 'Rockchip', 'RK30 based device' ),
			's3c6410'									=> array( 'Samsung', 'S3C6410 based device' ),
			'smdk6410'									=> array( 'Samsung', 'S3C6410 based device' ),
			'SMDKC110'									=> array( 'Samsung', 'Exynos 3110 based device' ),
			'SMDKV210'									=> array( 'Samsung', 'Exynos 4210 based device' ),
			'S5PV210'									=> array( 'Samsung', 'Exynos 4210 based device' ),
			'sec smdkc210'								=> array( 'Samsung', 'Exynos 4210 based device' ),
			'SMDK4x12'									=> array( 'Samsung', 'Exynos 4212 or 4412 based device' ),
			'SMDK5250'									=> array( 'Samsung', 'Exynos 5250 based device' ),									
			'smp86xx'									=> array( 'Sigma', 'SMP86xx based device', TYPE_TELEVISION ),
			'sv8860'									=> array( 'Skyviia', 'SV8860 based device', TYPE_TELEVISION ),
			'ste u8500'									=> array( 'ST Ericsson', 'Novathor U8500 based device' ),
			'Telechips M801 Evaluation Board'			=> array( 'Telechips', 'M801 based device', TYPE_TELEVISION ),
			'Telechips TCC8900 Evaluation Board'		=> array( 'Telechips', 'TCC8900 based device', TYPE_TELEVISION ),
			'TCC8920 STB EV'							=> array( 'Telechips', 'TCC8920 based device', TYPE_TELEVISION ),
			'OMAP'										=> array( 'Texas Instruments', 'OMAP based device' ),
			'OMAP SS'									=> array( 'Texas Instruments', 'OMAP based device' ),
			'LogicPD Zoom2'								=> array( 'Texas Instruments', 'OMAP based device' ),
			'omap3evm'									=> array( 'Texas Instruments', 'OMAP3 based device' ),
			'Omap5sevm'									=> array( 'Texas Instruments', 'OMAP5 based device' ),
			'AM335XEVM SK'								=> array( 'Texas Instruments', 'Sitara AM335 based device' ),
			'pnx8473 kiryung'							=> array( 'Trident', 'PNX8473 based device', TYPE_TELEVISION ),
			
			/* Official Google development devices */
			'Bravo'										=> array( 'HTC', 'Desire' ),
			'Dream'										=> array( 'HTC', 'Dream' ),
			'Vogue'										=> array( 'HTC', 'Touch' ),
			'Vendor Optimus'							=> array( 'LG', 'Optimus' ),
			'Stingray'									=> array( 'Motorola', 'XOOM', TYPE_TABLET ),
			'Wingray'									=> array( 'Motorola', 'XOOM', TYPE_TABLET ),
			'Blaze'										=> array( 'Texas Instruments', 'Blaze Tablet', TYPE_TABLET ),
			'Blaze Tablet'								=> array( 'Texas Instruments', 'Blaze Tablet', TYPE_TABLET ),
			'Google Ion'								=> array( 'Google', 'Ion' ),


			/* Nexus Devices (without official model no. */
			'Passion'									=> array( 'HTC', 'Nexus One' ),
			'(HTC )?Nexus ?One!'						=> array( 'HTC', 'Nexus One' ),
			'Crespo!'									=> array( 'Samsung', 'Nexus S' ),
			'(Google )?Nexus S!'						=> array( 'Samsung', 'Nexus S' ),
			'Dooderbutt!'								=> array( 'Samsung', 'Nexus S' ),
			'Maguro'									=> array( 'Samsung', 'Galaxy Nexus' ),
			'Toro-VZW'									=> array( 'Samsung', 'Galaxy Nexus' ),
			'Galaxy Nexus'								=> array( 'Samsung', 'Galaxy Nexus' ),
			'Grouper'									=> array( 'Asus', 'Nexus 7', TYPE_TABLET ),
			'(Google )?Nexus 7!'						=> array( 'Asus', 'Nexus 7', TYPE_TABLET ),
			'(Google )?Nexus 4!'						=> array( 'LG', 'Nexus 4' ),
			'Mako'										=> array( 'LG', 'Nexus 4' ),
			'manta'										=> array( 'Samsung', 'Nexus 10', TYPE_TABLET ),
			'Nexus 10'									=> array( 'Samsung', 'Nexus 10', TYPE_TABLET ),

			
			/* Middleware and emulators */
			'BlueStacks'								=> array( 'BlueStacks', 'App Player', 'desktop' ),
			'youwave custom'							=> array( 'Youwave', 'Android on PC', 'desktop' ),
			'BlackBerry Runtime for Android Apps'		=> array( 'RIM', 'BlackBerry (Android Runtime)', TYPE_MOBILE ),
			'BlackBerry Runtime for Android Apps'		=> array( 'RIM', 'BlackBerry (Android Runtime)', TYPE_MOBILE ),
			'full Android on Microsoft Windows, pad, pc, n*books'	
														=> array( 'SocketeQ', 'WindowsAndroid', 'desktop' ),

			/* TV sticks */
			'MK808'										=> array( null, 'MK808', TYPE_TELEVISION ),
			'MK808B'									=> array( null, 'MK808B', TYPE_TELEVISION ),
			'GK802'										=> array( null, 'GK802', TYPE_TELEVISION ),
			'VEOLO'										=> array( 'A.C. Ryan', 'VEOLO Smart Android Hub', TYPE_TELEVISION ),
			'JT SmartPC02'								=> array( 'Joy-IT', 'Smart PC', TYPE_TELEVISION ),
			'M3 Enjoy TV Box'							=> array( 'Geniatech', 'Enjoy TV', TYPE_TELEVISION ),
			'Rikomagic MK802'							=> array( 'Rikomagic', 'MK802', TYPE_TELEVISION ),
			'Rikomagic MK802 ?II!'						=> array( 'Rikomagic', 'MK802 II', TYPE_TELEVISION ),
			'Rikomagic MK802III'						=> array( 'Rikomagic', 'MK802 III', TYPE_TELEVISION ),	
			'Rikomagic MK802IIIS'						=> array( 'Rikomagic', 'MK802 IIIS', TYPE_TELEVISION ),	
			'XW-I8'										=> array( 'Sambao', 'XW-I8', TYPE_TELEVISION ),
			'TCC8925 HDMI DONGLE'						=> array( 'Telechips', 'TCC8925', TYPE_TELEVISION ),
			'TCC8930 STB EV'							=> array( 'Telechips', 'TCC8930', TYPE_TELEVISION ),

			
			/* Regular devices */
			'BC9710A'									=> array( '3Q', 'Qoo! Q-Pad BC9710A', TYPE_TABLET ),
			'RC0710B'									=> array( '3Q', 'Qoo! Q-Pad RC0710B', TYPE_TABLET ),
			'RC9724C'									=> array( '3Q', 'Qoo! Q-Pad RC9724C', TYPE_TABLET ),
			'QS9718C'									=> array( '3Q', 'Qoo! Q-Pad QS9718C', TYPE_TABLET ),
			'TS1009B'									=> array( '3Q', 'Qoo! Surf Tablet TS1009B', TYPE_TABLET ),
			'VM0711A'									=> array( '3Q', 'Qoo! Surf Tablet VM0711A', TYPE_TABLET ),
			'aspire1000s'								=> array( 'Acer', '1000 Series', TYPE_DESKTOP ),
			'A100'										=> array( 'Acer', 'Iconia Tab A100', TYPE_TABLET ),
			'A101'										=> array( 'Acer', 'Iconia Tab A101', TYPE_TABLET ),
			'A110'										=> array( 'Acer', 'Iconia Tab A110', TYPE_TABLET ),
			'A200'										=> array( 'Acer', 'Iconia Tab A200', TYPE_TABLET ),
			'A210'										=> array( 'Acer', 'Iconia Tab A210', TYPE_TABLET ),
			'A211'										=> array( 'Acer', 'Iconia Tab A211', TYPE_TABLET ),
			'A500'										=> array( 'Acer', 'Iconia Tab A500', TYPE_TABLET ),
			'A501'										=> array( 'Acer', 'Iconia Tab A501', TYPE_TABLET ),
			'A510'										=> array( 'Acer', 'Iconia Tab A510', TYPE_TABLET ),
			'A511'										=> array( 'Acer', 'Iconia Tab A511', TYPE_TABLET ),
			'A700'										=> array( 'Acer', 'Iconia Tab A700', TYPE_TABLET ),
			'P2A700'									=> array( 'Acer', 'Iconia Tab A700', TYPE_TABLET ),
			'A701'										=> array( 'Acer', 'Iconia Tab A701', TYPE_TABLET ),
			'A800'										=> array( 'Acer', 'Iconia Tab A800', TYPE_TABLET ),
			'A1-810'									=> array( 'Acer', 'Iconia A1-810', TYPE_TABLET ),
			'B1-A71'									=> array( 'Acer', 'Iconia B1-A71', TYPE_TABLET ),
			'E110'										=> array( 'Acer', 'beTouch E110' ),
			'E120'										=> array( 'Acer', 'beTouch E120' ),
			'E130'										=> array( 'Acer', 'beTouch E130' ),
			'E140'										=> array( 'Acer', 'beTouch E140' ),
			'E210'										=> array( 'Acer', 'beTouch E210' ),
			'E310'										=> array( 'Acer', 'Liquid mini' ),
			'E320'										=> array( 'Acer', 'Liquid Express' ),
			'E330'										=> array( 'Acer', 'Liquid Glow' ),
			'E350'										=> array( 'Acer', 'Liquid Gallant' ),
			'E400'										=> array( 'Acer', 'beTouch E400' ),
			'G100W'										=> array( 'Acer', 'G100W' ),
			'S100'										=> array( 'Acer', 'Liquid' ),
			'S110'										=> array( 'Acer', 'Stream' ),
			'S120'										=> array( 'Acer', 'Liquid mt' ),
			'S300'										=> array( 'Acer', 'Iconia Smart' ),
			'S500'										=> array( 'Acer', 'CloudMobile' ),
			'Z110'										=> array( 'Acer', 'Liquid Z' ),
			'Z120'										=> array( 'Acer', 'Liquid Z2' ),
			'TD600'										=> array( 'Acer', 'beTouch TD600' ),
			'Liquid'									=> array( 'Acer', 'Liquid' ),
			'Liquid E'									=> array( 'Acer', 'Liquid E' ),
			'Liquid MT'									=> array( 'Acer', 'Liquid mt' ),
			'Liquid Metal'								=> array( 'Acer', 'Liquid mt' ),
			'Stream'									=> array( 'Acer', 'Stream' ),
			'AK330s'									=> array( 'Acer', 'AK330s' ),
			'DA220HQL'									=> array( 'Acer', 'Touch and 3D Monitor DA220HQL', TYPE_MONITOR ),
			'T1-B'										=> array( 'Advan', 'Vandroid T1-B', TYPE_TABLET ),
			'VegaBean!'									=> array( 'Advent', 'Vega', TYPE_TABLET ),
			'N700'										=> array( 'aigo', 'N700', TYPE_TABLET ),
			'M801'										=> array( 'aigo', 'M801', TYPE_TABLET ),
			'Novo7'										=> array( 'Ainovo', 'Novo7', TYPE_TABLET ),
			'Novo7 -?Aurora!'							=> array( 'Ainovo', 'Novo7 Aurora', TYPE_TABLET ),
			'Ainovo Aurora-II'							=> array( 'Ainovo', 'Novo7 Aurora II', TYPE_TABLET ),
			'Aurora-II'									=> array( 'Ainovo', 'Novo7 Aurora II', TYPE_TABLET ),
			'Novo7 Advanced'							=> array( 'Ainovo', 'Novo7 Advanced', TYPE_TABLET ),
			'Novo7 Advanced2'							=> array( 'Ainovo', 'Novo7 Advanced 2', TYPE_TABLET ),
			'Novo7 Basic'								=> array( 'Ainovo', 'Novo7 Basic', TYPE_TABLET ),
			'NovoCrystal'								=> array( 'Ainovo', 'Novo7 Crystal', TYPE_TABLET ),
			'Novo7 ELF'									=> array( 'Ainovo', 'Novo7 Elf', TYPE_TABLET ),
			'ELF-II'									=> array( 'Ainovo', 'Novo7 Elf II', TYPE_TABLET ),
			'Novo7 Fire'								=> array( 'Ainovo', 'Novo7 Fire', TYPE_TABLET ),
			'Novo7 Flame'								=> array( 'Ainovo', 'Novo7 Flame', TYPE_TABLET ),
			'Ainovo Flame (Nexus 7)'					=> array( 'Ainovo', 'Novo7 Flame', TYPE_TABLET ),
			'Novo7 Legend'								=> array( 'Ainovo', 'Novo7 Legend', TYPE_TABLET ),
			'Novo7 PALADIN'								=> array( 'Ainovo', 'Novo7 Paladin', TYPE_TABLET ),
			'Novo7 Venus'								=> array( 'Ainovo', 'Novo7 Venus', TYPE_TABLET ),
			'Novo8 Advanced'							=> array( 'Ainovo', 'Novo8 Advanced', TYPE_TABLET ),
			'novo9-Spark'								=> array( 'Ainovo', 'Novo9 Spark', TYPE_TABLET ),
			'Novo10 Hero'								=> array( 'Ainovo', 'Novo10 Hero', TYPE_TABLET ),
			'Novo 10 Hero QuadCore'						=> array( 'Ainovo', 'Novo10 Hero', TYPE_TABLET ),
			'AIRIS TM400'								=> array( 'Airis', 'TM400' ),
			'one touch 890!'							=> array( 'Alcatel', 'One Touch 890' ),
			'one touch 891!'							=> array( 'Alcatel', 'One Touch 891' ),
			'one touch 903!'							=> array( 'Alcatel', 'One Touch 903' ),
			'one touch 906!'							=> array( 'Alcatel', 'One Touch 906' ),
			'one touch 908!'							=> array( 'Alcatel', 'One Touch 908' ),
			'one touch 909!'							=> array( 'Alcatel', 'One Touch 909' ),
			'one touch 910!'							=> array( 'Alcatel', 'One Touch 910' ),
			'one touch 916!'							=> array( 'Alcatel', 'One Touch 916' ),
			'one touch 918!'							=> array( 'Alcatel', 'One Touch 918' ),
			'one touch 922!'							=> array( 'Alcatel', 'One Touch 922' ),
			'one touch 927!'							=> array( 'Alcatel', 'One Touch 927' ),
			'one touch 928!'							=> array( 'Alcatel', 'One Touch 928' ),
			'one touch 930!'							=> array( 'Alcatel', 'One Touch 930' ),
			'one touch 979!'							=> array( 'Alcatel', 'One Touch 979' ),
			'one touch 980!'							=> array( 'Alcatel', 'One Touch 980' ),
			'one touch 981!'							=> array( 'Alcatel', 'One Touch 981' ),
			'one touch 983!'							=> array( 'Alcatel', 'One Touch 983' ),
			'one touch 985!'							=> array( 'Alcatel', 'One Touch 985' ),
			'one touch 986!'							=> array( 'Alcatel', 'One Touch 986' ),
			'one touch 990!'							=> array( 'Alcatel', 'One Touch 990' ),
			'one touch 991!'							=> array( 'Alcatel', 'One Touch 991' ),
			'one touch 992!'							=> array( 'Alcatel', 'One Touch 992' ),
			'one touch 993!'							=> array( 'Alcatel', 'One Touch 993' ),
			'one touch 995!'							=> array( 'Alcatel', 'One Touch 995' ),
			'one touch 997!'							=> array( 'Alcatel', 'One Touch 997' ),
			'OT 918'									=> array( 'Alcatel', 'One Touch 918' ),
			'OT-995'									=> array( 'Alcatel', 'One Touch 995' ),
			'one touch 40(05|10)!'						=> array( 'Alcatel', 'One Touch T\'Pop' ),
			'one touch 4030!'							=> array( 'Alcatel', 'One Touch S\'Pop' ),
			'one touch 5020!'							=> array( 'Alcatel', 'One Touch M\'Pop' ),
			'one touch 5035!'							=> array( 'Alcatel', 'One Touch X\'Pop' ),
			'one touch 6010!'							=> array( 'Alcatel', 'One Touch Star' ),
			'one touch 6030!'							=> array( 'Alcatel', 'One Touch Idol' ),
			'one touch 6033!'							=> array( 'Alcatel', 'One Touch Idol Ultra' ),
			'one touch 6035!'							=> array( 'Alcatel', 'One Touch "6035"' ),
			'one touch 6040!'							=> array( 'Alcatel', 'One Touch "6040"' ),
			'one touch 7024!'							=> array( 'Alcatel', 'One Touch "7024"' ),
			'one touch 70(25|30)!'						=> array( 'Alcatel', 'One Touch Snap' ),
			'Alcatel 7030L'								=> array( 'Alcatel', 'One Touch Snap' ),
			'one touch 8000!'							=> array( 'Alcatel', 'One Touch Scribe Easy' ),
			'one touch 8008!'							=> array( 'Alcatel', 'One Touch Scribe HD' ),
			'one touch T10'								=> array( 'Alcatel', 'One Touch T10', TYPE_TABLET ),
			'onetouch EVO7'								=> array( 'Alcatel', 'One Touch Evo 7', TYPE_TABLET ),
			'Venture'									=> array( 'Alcatel', 'Venture' ),
			'ALLVIEW P4i'								=> array( 'Allview', 'P4 Duo' ),
			'Allview P5-Mini'							=> array( 'Allview', 'P5 Mini' ),
			'A10'										=> array( 'AllWinner', 'A10', TYPE_TABLET ),
			'Allwinner A10'								=> array( 'AllWinner', 'A10', TYPE_TABLET ),
			'97FC'										=> array( 'AllWinner', 'A10 97FC', TYPE_TABLET ),
			'A13-?MID!'									=> array( 'AllWinner', 'A13', TYPE_TABLET ),
			'AT108F'									=> array( 'Aluratek', 'Cinepad AT108F', TYPE_TABLET ),
			'(Amazon )?Kindle Fire!'					=> array( 'Amazon', 'Kindle Fire', TYPE_TABLET ),
			'KFOT'										=> array( 'Amazon', 'Kindle Fire', TYPE_TABLET ),	
			'KFTT'										=> array( 'Amazon', 'Kindle Fire HD 7"', TYPE_TABLET ),
			'KFJW(I|A)!'								=> array( 'Amazon', 'Kindle Fire HD 8.9"', TYPE_TABLET ),
			'AMOI A860w'								=> array( 'Amoi', 'A860W' ),
			'AMOI N79+'									=> array( 'Amoi', 'N79' ),
			'AMOI N89'									=> array( 'Amoi', 'N89' ),
			'AMOI N807'									=> array( 'Amoi', 'N807' ),
			'AMOI N808'									=> array( 'Amoi', 'N808' ),
			'AMOI N816'									=> array( 'Amoi', 'N816' ),
			'AMOI N820'									=> array( 'Amoi', 'N820' ),
			'AMOI N821'									=> array( 'Amoi', 'N821' ),
			'AMOI N828'									=> array( 'Amoi', 'N828' ),
			'AMOI N850'									=> array( 'Amoi', 'N850' ),
			'AMOI M8228'								=> array( 'Amoi', 'M8228' ),
			'AMD120'									=> array( 'AnyDATA', 'AnyTAB AMD120', TYPE_TABLET ),
			'mw07'										=> array( 'AOC', 'Breeze MW07', TYPE_TABLET ),
			'MW0711'									=> array( 'AOC', 'Breeze MW0711', TYPE_TABLET ),
			'MW0811'									=> array( 'AOC', 'Breeze MW0811', TYPE_TABLET ),
			'MW0812'									=> array( 'AOC', 'Breeze MW0812', TYPE_TABLET ),
			'MW0821 V2.0'								=> array( 'AOC', 'Breeze MW0821', TYPE_TABLET ),
			'MW0922'									=> array( 'AOC', 'Breeze MW0922', TYPE_TABLET ),
			'AOLE 828'									=> array( 'Aole', '828' ),
			'M19'										=> array( 'Aoson', 'M19', TYPE_TABLET ),
			'Aoson M19'									=> array( 'Aoson', 'M19', TYPE_TABLET ),
			'Apanda.A60!'								=> array( 'Apanda', 'A60' ),
			'apanda-A80S'								=> array( 'Apanda', 'A80' ),
			'Quicki-811'								=> array( 'Apollo', 'Quicki-811', TYPE_TABLET ),
			'AN7CG2'									=> array( 'Archos', 'Arnova 7c G2', TYPE_TABLET ),
			'AN7G2DTE'									=> array( 'Archos', 'Arnova 7 G2', TYPE_TABLET ),
			'AN7G3'										=> array( 'Archos', 'Arnova 7 G3', TYPE_TABLET ),
			'AN7BG3'									=> array( 'Archos', 'Arnova 7b G3', TYPE_TABLET ),
			'AN7DG3-CP'									=> array( 'Archos', 'Arnova 7d G3', TYPE_TABLET ),
			'AN7FG3'									=> array( 'Archos', 'Arnova 7f G3', TYPE_TABLET ),
			'AN7HG3'									=> array( 'Archos', 'Arnova 7h G3', TYPE_TABLET ),
			'A80KSC!'									=> array( 'Archos', 'Arnova 8', TYPE_TABLET ),
			'AN8G3'										=> array( 'Archos', 'Arnova 8 G3', TYPE_TABLET ),
			'AN9G2'										=> array( 'Archos', 'Arnova 9 G2', TYPE_TABLET ),
			'AN9G2I'									=> array( 'Archos', 'Arnova 9i G2', TYPE_TABLET ),
			'AN9G3'										=> array( 'Archos', 'Arnova 9 G3', TYPE_TABLET ),
			'A101B'										=> array( 'Archos', 'Arnova 10', TYPE_TABLET ),
			'AN10G2'									=> array( 'Archos', 'Arnova 10 G2', TYPE_TABLET ),
			'AN10BG2DT'									=> array( 'Archos', 'Arnova 10b G2', TYPE_TABLET ),
			'AN10BG3'									=> array( 'Archos', 'Arnova 10b G3', TYPE_TABLET ),
			'AN10CG3'									=> array( 'Archos', 'Arnova 10c G3', TYPE_TABLET ),
			'AN10DG3'									=> array( 'Archos', 'Arnova 10d G3', TYPE_TABLET ),
			'A32'										=> array( 'Archos', '32', 'media' ),
			'A35DE'										=> array( 'Archos', '35 Smart Home Phone' ),
			'A43'										=> array( 'Archos', '43', 'media' ),
			'Archos5'									=> array( 'Archos', '5', 'media' ),
			'A70H'										=> array( 'Archos', '7 Home Tablet', TYPE_TABLET ),					// G7
			'A70HB'										=> array( 'Archos', '7 Home Tablet', TYPE_TABLET ),
			'A70BHT'									=> array( 'Archos', '7 Home Tablet', TYPE_TABLET ),
			'A70CHT'									=> array( 'Archos', '7 Home Tablet', TYPE_TABLET ),
			'A70S'										=> array( 'Archos', '70 Internet Tablet', TYPE_TABLET ),				// G8
			'A7EB'										=> array( 'Archos', '70B Internet Tablet', TYPE_TABLET ),
			'ARCHOS 70it2'								=> array( 'Archos', '70B Internet Tablet', TYPE_TABLET ),		
			'A101IT'									=> array( 'Archos', '101 Internet Tablet', TYPE_TABLET ),		
			'ARCHOS 80G9'								=> array( 'Archos', '80 G9', TYPE_TABLET ),							// G9
			'ARCHOS 101G9'								=> array( 'Archos', '101 G9', TYPE_TABLET ),						
			'ARCHOS 97XSLG10'							=> array( 'Archos', '97 XS', TYPE_TABLET ),							// G10
			'ARCHOS 80XSK'								=> array( 'Archos', '80 XS', TYPE_TABLET ),							// G10
			'ARCHOS 101G10'								=> array( 'Archos', '101 XS', TYPE_TABLET ),
			'ARCHOS 70 Titanium'						=> array( 'Archos', '70 Titanium', TYPE_TABLET ),					// Elements
			'ARCHOS 80 COBALT'							=> array( 'Archos', '80 Cobalt', TYPE_TABLET ),						// Elements
			'ARCHOS 80 TITANIUM'						=> array( 'Archos', '80 Titanium', TYPE_TABLET ),					// Elements
			'ARCHOS 97 CARBON'							=> array( 'Archos', '97 Carbon', TYPE_TABLET ),						// Elements
			'ARCHOS 97 TITANIUMHD'						=> array( 'Archos', '97 Titanium HD', TYPE_TABLET ),				// Elements
			'ARCHOS 101 Titanium'						=> array( 'Archos', '101 Titanium', TYPE_TABLET ),					// Elements
			'ARCHOS GAMEPAD'							=> array( 'Archos', 'Gamepad', TYPE_GAMING ),
			'D9702'										=> array( 'Artes', 'D9702', TYPE_TABLET ),
			'ASTRI'										=> array( 'ASTRI', 'e-reader', TYPE_EREADER ),
			'eeepc'										=> array( 'Asus', 'Eee Pc' ),
			'asus laptop'								=> array( 'Asus', 'Eee Pc' ),
			'eee 701'									=> array( 'Asus', 'Eee Pc' ),
			'ME171'										=> array( 'Asus', 'Eee Pad MeMO', TYPE_TABLET ),
			'ME172V'									=> array( 'Asus', 'MemoPad ME172V', TYPE_TABLET ),
			'Slider SL101'								=> array( 'Asus', 'Eee Pad Slider', TYPE_TABLET ),
			'EPAD'										=> array( 'Asus', 'Eee Pad Transformer', TYPE_TABLET ),
			'TF101'										=> array( 'Asus', 'Eee Pad Transformer', TYPE_TABLET ),
			'Transformer'								=> array( 'Asus', 'Eee Pad Transformer', TYPE_TABLET ),
			'Transformer TF101(G)?!'					=> array( 'Asus', 'Eee Pad Transformer', TYPE_TABLET ),
			'TF201'										=> array( 'Asus', 'Eee Pad Transformer Prime', TYPE_TABLET ),
			'(Eee Pad )?Transformer Prime TF201!'		=> array( 'Asus', 'Eee Pad Transformer Prime', TYPE_TABLET ),
			'Transformer Prime'							=> array( 'Asus', 'Eee Pad Transformer Prime', TYPE_TABLET ),
			'(Transformer )?(Pad )?TF300(T|TG|TL)!'		=> array( 'Asus', 'Transformer Pad 300', TYPE_TABLET ),
			'(Transformer )?(Pad )?TF700(T|K)!'			=> array( 'Asus', 'Transformer Pad Infinity 700', TYPE_TABLET ),
			'Transformer (Pad )?Infinity!'				=> array( 'Asus', 'Transformer Pad Infinity 700', TYPE_TABLET ),
			'ME301T'									=> array( 'Asus', 'MemoPad ME301T', TYPE_TABLET ),
			'ME371MG'									=> array( 'Asus', 'Fonepad K004', TYPE_TABLET ),
			'PadFone'									=> array( 'Asus', 'Padfone', TYPE_TABLET ),
			'PadFone 2'									=> array( 'Asus', 'Padfone 2', TYPE_TABLET ),
			'PadFone Infinity'							=> array( 'Asus', 'Padfone Infinity', TYPE_TABLET ),
			'OMS TTD'									=> array( 'Asus', 'Eee Pc T10' ),
			'ASUS T20'									=> array( 'Asus', 'Eee Pc T20' ),
			'ETBW11AA'									=> array( 'Asus', 'Tough' ),
			'T-07B'										=> array( 'AudioSonic', 'T07B', TYPE_TABLET ),
			'AUX V900'									=> array( 'AUX', 'V900' ),
			'PICOpad GEW'								=> array( 'Axioo', 'Picopad GEW', TYPE_TABLET ),
			'Axioo PICOpad GIM'							=> array( 'Axioo', 'Picopad GIM', TYPE_TABLET ),
			'PICOpad GJT'								=> array( 'Axioo', 'Picopad GJT', TYPE_TABLET ),
			'PICOpad-QGN'								=> array( 'Axioo', 'Picopad QGN', TYPE_TABLET ),
			'A10 MID'									=> array( 'Azhuo', 'A10 MID', TYPE_TABLET ),
			'NOOK'										=> array( 'Barnes & Noble', 'NOOK', TYPE_EREADER ),
			'Nook ?Color!'								=> array( 'Barnes & Noble', 'NOOK Color', TYPE_EREADER ),
			'(NOOK )?BNRV(200|300)!'					=> array( 'Barnes & Noble', 'NOOK Color', TYPE_EREADER ),
			'Nook ?Tablet!'								=> array( 'Barnes & Noble', 'NOOK Tablet', TYPE_EREADER ),
			'NOOK Slate'								=> array( 'Barnes & Noble', 'NOOK Tablet', TYPE_EREADER ),
			'Barnes & Noble Nook Tablet'				=> array( 'Barnes & Noble', 'NOOK Tablet', TYPE_EREADER ),
			'(NOOK )?BNTV250!'							=> array( 'Barnes & Noble', 'NOOK Tablet', TYPE_EREADER ),
			'(NOOK )?BNRV350!'							=> array( 'Barnes & Noble', 'NOOK Simple Touch', TYPE_EREADER ),
			'(NOOK )?BNTV(400)!'						=> array( 'Barnes & Noble', 'NOOK HD Tablet', TYPE_EREADER ),
			'(NOOK )?BNTV(600)!'						=> array( 'Barnes & Noble', 'NOOK HD+ Tablet', TYPE_EREADER ),
			'Barnes & Noble Nook HD'					=> array( 'Barnes & Noble', 'NOOK HD Tablet', TYPE_EREADER ),
			'Barnes & Noble Nook HD+'					=> array( 'Barnes & Noble', 'NOOK HD+ Tablet', TYPE_EREADER ),
			'BenWee 5100'								=> array( 'BenWee', '5100' ),
			'WL-101GQC'									=> array( 'Bauhn', 'WL-101GQC', TYPE_TABLET ),
			'CA907AAC0G'								=> array( 'Besta', 'CA907AAC0G' ),
			'BLU DASH 3.2'								=> array( 'BLU', 'Dash 3.2' ),
			'BLU DASH 3.5'								=> array( 'BLU', 'Dash 3.5' ),
			'BMOBILE DASH 3.5'							=> array( 'BLU', 'Dash 3.5' ),
			'BLU DASH 4.0'								=> array( 'BLU', 'Dash 4.0' ),
			'BLU Quattro 4.5'							=> array( 'BLU', 'Quattro 4.5' ),
			'BLU Quattro 4.5 HD'						=> array( 'BLU', 'Quattro 4.5 HD' ),
			'BLU Studio 5.3'							=> array( 'BLU', 'Studio 5.3' ),
			'BLU STUDIO 5.3 II'							=> array( 'BLU', 'Studio 5.3 II' ),
			'BLU P100i'									=> array( 'BLU', 'Touch Book 7.0 Plus', TYPE_TABLET ),
			'(BLU )?VIVO 4.3!'							=> array( 'BLU', 'Vivo 4.3' ),
			'B3000'										=> array( 'BlueBo', 'B3000' ),
			'JC-S9220'									=> array( 'Bmorn', 'Phone One' ),
			'BM999'										=> array( 'Bmorn', 'BM999', TYPE_TABLET ),
			'V11'										=> array( 'Bmorn', 'V11', TYPE_TABLET ),
			'V99'										=> array( 'Bmorn', 'V99', TYPE_TABLET ),
			'BOVO S-F16'								=> array( 'Bovo', 'Walker S-F16' ),
			'S-F16'										=> array( 'Bovo', 'Walker S-F16' ),
			'BROR S9'									=> array( 'BROR', 'S9' ),
			'BROR W60'									=> array( 'BROR', 'W60' ),
			'BROR W68'									=> array( 'BROR', 'W68' ),
			'bq Aquaris'								=> array( 'bq', 'Aquaris', TYPE_TABLET ),
			'bq Curie'									=> array( 'bq', 'Curie', TYPE_TABLET ),
			'bq DaVinci'								=> array( 'bq', 'DaVinci', TYPE_TABLET ),
			'bq Elcano'									=> array( 'bq', 'Elcano', TYPE_TABLET ),
			'bq Edison'									=> array( 'bq', 'Edison', TYPE_TABLET ),
			'bq Edison 3G'								=> array( 'bq', 'Edison', TYPE_TABLET ),
			'bq Edison 2'								=> array( 'bq', 'Edison 2', TYPE_TABLET ),
			'Maxwell Lite'								=> array( 'bq', 'Maxwell Lite', TYPE_TABLET ),
			'bq Maxwell Plus'							=> array( 'bq', 'Maxwell Plus', TYPE_TABLET ),
			'bq Pascal 2'								=> array( 'bq', 'Pascal 2', TYPE_TABLET ),
			'bq Verne Plus'								=> array( 'bq', 'Verne Plus', TYPE_TABLET ),
			'CT701'										=> array( 'Carrefour', 'CT701', TYPE_TABLET ),
			'CT704'										=> array( 'Carrefour', 'CT704', TYPE_TABLET ),
			'CT705'										=> array( 'Carrefour', 'CT705', TYPE_TABLET ),
			'CT705FR'									=> array( 'Carrefour', 'CT705', TYPE_TABLET ),
			'CT1002'									=> array( 'Carrefour', 'CT1002', TYPE_TABLET ),
			'CT1010'									=> array( 'Carrefour', 'CT1010', TYPE_TABLET ),
			'Camangi-Mangrove7'							=> array( 'Camangi', 'Mangrove 7', TYPE_TABLET ),
			'WS171'										=> array( 'Camangi', 'WebStation', TYPE_TABLET ),
			'CAL21'										=> array( 'Casio', 'GzOne Type-L' ),
			'IS11CA'									=> array( 'Casio', 'GzOne IS11CA' ),
			'C771'										=> array( 'Casio', 'GzOne Commando' ),
			'C811 4G'									=> array( 'Casio', 'GzOne Commando 811' ),
			'VX-100'									=> array( 'Casio', 'VX-100 EPOS Terminal', TYPE_POS ),
			'CAT NOVA'									=> array( 'Cat', 'NOVA', TYPE_TABLET ),
			'Celkon A79'								=> array( 'Celkon', 'A79' ),
			'Celkon A119'								=> array( 'Celkon', 'A119' ),
			'Celkon A 200'								=> array( 'Celkon', 'A200' ),
			'CELKON CT2'								=> array( 'Celkon', 'CT2', TYPE_TABLET ),
			'Celkon CT7'								=> array( 'Celkon', 'CT7', TYPE_TABLET ),
			'W820'										=> array( 'Cellon', 'HW-W820' ),
			'ChangHong-Z-ME'							=> array( 'ChangHong', 'Z-me' ),
			'Changhong H5018'							=> array( 'ChangHong', 'H5018' ),
			'ChangHong V7'								=> array( 'ChangHong', 'V7' ),
			'ChangHongW3'								=> array( 'ChangHong', 'W3' ),
			'ChanghongW6'								=> array( 'ChangHong', 'W6' ),
			'Candy TV'									=> array( 'Cherry Mobile', 'Candy TV' ),
			'Titan TV S320'								=> array( 'Cherry Mobile', 'Titan TV S320' ),
			'Cherry w500'								=> array( 'Cherry Mobile', 'W500' ),
			'W900'										=> array( 'Cherry Mobile', 'W900' ),
			'Fusion Bolt'								=> array( 'Cherry Mobile', 'Fusion Bolt', TYPE_TABLET ),
			'LA-E'										=> array( 'Chili', 'E' ),
			'LA-I2'										=> array( 'Chili', 'I2' ),
			'LA-M1'										=> array( 'Chili', 'M1' ),
			'LA-M2'										=> array( 'Chili', 'M2' ),
			'LA-Q1'										=> array( 'Chili', 'Q1' ),
			'ARMM3V'									=> array( 'chinaleap', 'ARMM3V', TYPE_TABLET ),
			'V936'										=> array( 'Chiva', 'V936' ),
			'CIUS-7!'									=> array( 'Cisco', 'Cius', TYPE_TABLET ),
			'CP-DX650'									=> array( 'Cisco', 'DX650', TYPE_TABLET ),
			'Cloudfone Excite320e'						=> array( 'Cloudfone', 'Excite 320e' ),
			'Cloudfone Thrill 430g'						=> array( 'Cloudfone', 'Thrill 430g' ),
			'Thrill 430x'								=> array( 'Cloudfone', 'Thrill 430x' ),
			'CloudPad 700w'								=> array( 'Cloudfone', 'CloudPad 700w' ),
			'AQUILA 080-1008'							=> array( 'CMX', 'Aquila MID 080-1008', TYPE_TABLET ),
			'CnM TouchPad 7'							=> array( 'CnM', 'TouchPad 7', TYPE_TABLET ),
			'CnM TouchPad 7DC'							=> array( 'CnM', 'TouchPad 7 DC', TYPE_TABLET ),
			'Cnm TOUCHPAD 9.7'							=> array( 'CnM', 'TouchPad 9.7', TYPE_TABLET ),
			'CnM TouchPad 10.1DC'						=> array( 'CnM', 'TouchPad 10.1 DC', TYPE_TABLET ),
			'MID1024'									=> array( 'Coby', 'Kyros MID1024', TYPE_TABLET ),
			'MID1042'									=> array( 'Coby', 'Kyros MID1042', TYPE_TABLET ),
			'MID1045'									=> array( 'Coby', 'Kyros MID1045', TYPE_TABLET ),
			'MID1125'									=> array( 'Coby', 'Kyros MID1125', TYPE_TABLET ),
			'MID1126'									=> array( 'Coby', 'Kyros MID1126', TYPE_TABLET ),
			'MID7002'									=> array( 'Coby', 'Kyros MID7002', TYPE_TABLET ),
			'MID7010'									=> array( 'Coby', 'Kyros MID7010', TYPE_TABLET ),
			'MID7012'									=> array( 'Coby', 'Kyros MID7012', TYPE_TABLET ),
			'MID7015!'									=> array( 'Coby', 'Kyros MID7015', TYPE_TABLET ),
			'MID7016'									=> array( 'Coby', 'Kyros MID7016', TYPE_TABLET ),
			'MID7020'									=> array( 'Coby', 'Kyros MID7020', TYPE_TABLET ),
			'MID7022'									=> array( 'Coby', 'Kyros MID7022', TYPE_TABLET ),
			'MID7024'									=> array( 'Coby', 'Kyros MID7024', TYPE_TABLET ),
			'MID7025'									=> array( 'Coby', 'Kyros MID7025', TYPE_TABLET ),
			'MID7032'									=> array( 'Coby', 'Kyros MID7032', TYPE_TABLET ),
			'MID7033'									=> array( 'Coby', 'Kyros MID7033', TYPE_TABLET ),
			'MID7034'									=> array( 'Coby', 'Kyros MID7034', TYPE_TABLET ),
			'MID7035'									=> array( 'Coby', 'Kyros MID7035', TYPE_TABLET ),
			'MID7036'									=> array( 'Coby', 'Kyros MID7036', TYPE_TABLET ),
			'MID7042'									=> array( 'Coby', 'Kyros MID7042', TYPE_TABLET ),
			'MID7048'									=> array( 'Coby', 'Kyros MID7048', TYPE_TABLET ),
			'MID7127'									=> array( 'Coby', 'Kyros MID7127', TYPE_TABLET ),
			'MID8024'									=> array( 'Coby', 'Kyros MID8024', TYPE_TABLET ),
			'MID8042'									=> array( 'Coby', 'Kyros MID8042', TYPE_TABLET ),
			'MID8048'									=> array( 'Coby', 'Kyros MID8048', TYPE_TABLET ),
			'MID8120'									=> array( 'Coby', 'Kyros MID8120', TYPE_TABLET ),
			'MID8125'									=> array( 'Coby', 'Kyros MID8125', TYPE_TABLET ),
			'MID8127'									=> array( 'Coby', 'Kyros MID8127', TYPE_TABLET ),
			'MID9042'									=> array( 'Coby', 'Kyros MID9042', TYPE_TABLET ),
			'MID9740'									=> array( 'Coby', 'Kyros MID9740', TYPE_TABLET ),
			'MID9742'									=> array( 'Coby', 'Kyros MID9742', TYPE_TABLET ),
			'Z71'										=> array( 'Commtiva', 'Z71' ),
			'V-T100'									=> array( 'Commtiva', 'V-T100' ),
			'FIH-FB0'									=> array( 'Commtiva', 'HD700'),
			'Commtiva-N700'								=> array( 'Commtiva', 'N700'),
			'Coolpad D510'								=> array( 'Coolpad', 'D510' ),
			'D530'										=> array( 'Coolpad', 'D530' ),
			'Coolpad D530'								=> array( 'Coolpad', 'D530' ),
			'D539'										=> array( 'Coolpad', 'D539' ),
			'Coolpad D539'								=> array( 'Coolpad', 'D539' ),
			'E239'										=> array( 'Coolpad', 'E239' ),
			'Coolpad E239'								=> array( 'Coolpad', 'E239' ),
			'Coolpad N930'								=> array( 'Coolpad', 'N930' ),
			'N930'										=> array( 'Coolpad', 'N930' ),
			'Coolpad W706!'								=> array( 'Coolpad', 'W706' ),
			'Coolpad W708'								=> array( 'Coolpad', 'W708' ),
			'W711'										=> array( 'Coolpad', 'W711' ),
			'Coolpad 5010'								=> array( 'Coolpad', '5010' ),
			'Coolpad 5110'								=> array( 'Coolpad', '5110' ),
			'Coolpad 5210'								=> array( 'Coolpad', '5210' ),
			'Coolpad 5210!'								=> array( 'Coolpad', '5210' ),
			'Coolpad 5216!'								=> array( 'Coolpad', '5216' ),
			'Coolpad 5820'								=> array( 'Coolpad', '5820' ),
			'5832'										=> array( 'Coolpad', '5832' ),
			'Coolpad 5832'								=> array( 'Coolpad', '5832' ),
			'5855'										=> array( 'Coolpad', '5855' ),
			'Coolpad 5860!'								=> array( 'Coolpad', '5860' ),
			'5860'										=> array( 'Coolpad', '5860' ),
			'5860A'										=> array( 'Coolpad', '5860A' ),
			'5860E'										=> array( 'Coolpad', 'Quattro 4G 5860E' ),
			'5860S'										=> array( 'Coolpad', '5860S' ),
			'Coolpad 5870'								=> array( 'Coolpad', '5870' ),
			'5870'										=> array( 'Coolpad', '5870' ),
			'Coolpad 5876'								=> array( 'Coolpad', '5876' ),
			'Coolpad 5880'								=> array( 'Coolpad', '5880' ),
			'Coolpad 5890'								=> array( 'Coolpad', '5890' ),
			'Coolpad 5910'								=> array( 'Coolpad', '5910' ),
			'Coolpad 5930'								=> array( 'Coolpad', '5930' ),
			'Coolpad 7005'								=> array( 'Coolpad', '7005' ),
			'Coolpad 7011'								=> array( 'Coolpad', '7011' ),
			'Coolpad 7019!'								=> array( 'Coolpad', '7019' ),
			'Coolpad 7020'								=> array( 'Coolpad', '7020' ),
			'Coolpad 7230!'								=> array( 'Coolpad', '7230' ),
			'Coolpad 7235'								=> array( 'Coolpad', '7235' ),
			'7260'										=> array( 'Coolpad', '7260' ),
			'Coolpad 7260!'								=> array( 'Coolpad', '7260' ),
			'7266'										=> array( 'Coolpad', '7266' ),
			'Coolpad 7290'								=> array( 'Coolpad', '7290' ),
			'Coolpad 7295'								=> array( 'Coolpad', '7295' ),
			'Coolpad 7295+'								=> array( 'Coolpad', '7295' ),
			'Coolpad 7728'								=> array( 'Coolpad', '7728' ),
			'Coolpad 8010'								=> array( 'Coolpad', '8010' ),
			'Coolpad 8013'								=> array( 'Coolpad', '8013' ),
			'Coolpad 8020+'								=> array( 'Coolpad', '8020' ),
			'8022'										=> array( 'Coolpad', '8022' ),
			'Coolpad 8026'								=> array( 'Coolpad', '8026' ),
			'Coolpad 8028'								=> array( 'Coolpad', '8028' ),
			'Coolpad 8050'								=> array( 'Coolpad', '8050' ),
			'Coolpad 8060'								=> array( 'Coolpad', '8060' ),
			'Coolpad -?8190!'							=> array( 'Coolpad', '8190' ),
			'Coolpad 8809'								=> array( 'Coolpad', '8809' ),
			'Coolpad 8810'								=> array( 'Coolpad', '8810' ),
			'8810'										=> array( 'Coolpad', '8810' ),
			'Coolpad 8811'								=> array( 'Coolpad', '8811' ),
			'Coolpad 9070'								=> array( 'Coolpad', '9070' ),
			'Coolpad 9120'								=> array( 'Coolpad', '9120' ),
			'Coolpad 9900'								=> array( 'Coolpad', '9900' ),
			'Coolpad 9960'								=> array( 'Coolpad', '9960' ),
			'CLP281X'									=> array( 'Craig', 'CLP281x', TYPE_TABLET ),
			'CMP741d'									=> array( 'Craig', 'CMP741d', TYPE_TABLET ),
			'CMP741E'									=> array( 'Craig', 'CMP741e', TYPE_TABLET ),
			'ZiiO7'										=> array( 'Creative', 'ZiiO 7', TYPE_TABLET ),
			'ZiiLABS ZiiO7'								=> array( 'Creative', 'ZiiO 7', TYPE_TABLET ),
			'ZiiLABS ZiiO10 '							=> array( 'Creative', 'ZiiO 10', TYPE_TABLET ),
			'CTP828BT'									=> array( 'Cresta', 'CTP828BT', TYPE_TABLET ),
			'Cross A2'									=> array( 'Cross', 'A2' ),
			'Cross A7*'									=> array( 'Cross', 'A7' ),
			'CROSS A10'									=> array( 'Cross', 'A10' ),
			'CROSS A27'									=> array( 'Cross', 'A27' ),
			'CROSS A28'									=> array( 'Cross', 'A28' ),
			'CUBE K8GT A'								=> array( 'Cube', 'K8GT A', TYPE_TABLET ),
			'CUBE K8GT B'								=> array( 'Cube', 'K8GT B', TYPE_TABLET ),
			'K8GT C'									=> array( 'Cube', 'K8GT C', TYPE_TABLET ),
			'K8GT H'									=> array( 'Cube', 'K8GT H', TYPE_TABLET ),
			'CUBE K8GT H'								=> array( 'Cube', 'K8GT H', TYPE_TABLET ),
			'K8GT W'									=> array( 'Cube', 'K8GT W', TYPE_TABLET ),
			'CUBE U8GT'									=> array( 'Cube', 'U8GT', TYPE_TABLET ),
			'CUBE U9GT'									=> array( 'Cube', 'U9GT', TYPE_TABLET ),
			'U9GT'										=> array( 'Cube', 'U9GT', TYPE_TABLET ),
			'U9GT S'									=> array( 'Cube', 'U9GT S', TYPE_TABLET ),
			'U9GT S A'									=> array( 'Cube', 'U9GT SA', TYPE_TABLET ),
			'U9GTS A'									=> array( 'Cube', 'U9GT SA', TYPE_TABLET ),
			'U9GT V'									=> array( 'Cube', 'U9GT V', TYPE_TABLET ),
			'CUBE U9GT ?2!'								=> array( 'Cube', 'U9GT2', TYPE_TABLET ),
			'U9GT2!'									=> array( 'Cube', 'U9GT2', TYPE_TABLET ),
			'N90 From moage.com'						=> array( 'Cube', 'U9GT2', TYPE_TABLET ),
			'U9GT3'										=> array( 'Cube', 'U9GT3', TYPE_TABLET ),
			'U9GT3-S'									=> array( 'Cube', 'U9GT3 S', TYPE_TABLET ),
			'U9GT4'										=> array( 'Cube', 'U9GT4', TYPE_TABLET ),
			'U10GT S'									=> array( 'Cube', 'U10GT S', TYPE_TABLET ),
			'U10GT 2'									=> array( 'Cube', 'U10GT2', TYPE_TABLET ),
			'CUBE U15GT'								=> array( 'Cube', 'U15GT', TYPE_TABLET ),
			'U18GT-H'									=> array( 'Cube', 'U18GT H', TYPE_TABLET ),
			'U18GT-S'									=> array( 'Cube', 'U18GT S', TYPE_TABLET ),
			'U18GT-W'									=> array( 'Cube', 'U18GT W', TYPE_TABLET ),
			'U18GT2'									=> array( 'Cube', 'U18GT2', TYPE_TABLET ),
			'U19GT-W'									=> array( 'Cube', 'U19GT W', TYPE_TABLET ),
			'U20GT'										=> array( 'Cube', 'U20GT', TYPE_TABLET ),
			'U23GT'										=> array( 'Cube', 'U23GT', TYPE_TABLET ),
			'U23GT-S'									=> array( 'Cube', 'U23GT S', TYPE_TABLET ),
			'U25GT'										=> array( 'Cube', 'U25GT', TYPE_TABLET ),
			'U30GT-H'									=> array( 'Cube', 'U30GT H', TYPE_TABLET ),
			'U30GT-M'									=> array( 'Cube', 'U30GT M', TYPE_TABLET ),
			'U30GT MINI'								=> array( 'Cube', 'U30GT Mini', TYPE_TABLET ),
			'U30GT-mini'								=> array( 'Cube', 'U30GT Mini', TYPE_TABLET ),
			'U30GT 2'									=> array( 'Cube', 'U30GT2', TYPE_TABLET ),
			'CUBE Q7PRO'								=> array( 'Cube', 'Q7 Pro', TYPE_TABLET ),
			'CUBE Q7PRO J'								=> array( 'Cube', 'Q7 Pro', TYPE_TABLET ),
			'LT8088'									=> array( 'Curtis', 'Klu LT8088', TYPE_TABLET ),
			'Cydle M7!'									=> array( 'Cydle', 'M7 MultiPAD', TYPE_TABLET ),
			'DAKELE MC001'								=> array( 'Dakele', 'MC001' ),
			'EvoPAD A7000'								=> array( 'Dark', 'EvoPad A7000', TYPE_TABLET ),
			'EVOPad R9720'								=> array( 'Dark', 'EvoPad R9720', TYPE_TABLET ),
			'EvoPAD-R9722'								=> array( 'Dark', 'EvoPad R9722', TYPE_TABLET ),
			'HB-100 DASAN'								=> array( 'Dasan', 'HB-100', TYPE_TELEVISION ),
			'HB-100 DASAN Networks, Inc.'				=> array( 'Dasan', 'HB-100', TYPE_TELEVISION ),
			'Dell Aero'									=> array( 'Dell', 'Aero' ),
			'Dell Grappa'								=> array( 'Dell', 'Grappa' ),
			'Dell M01M'									=> array( 'Dell', 'Mini 5', TYPE_TABLET ),
			'Dell Streak'								=> array( 'Dell', 'Streak', TYPE_TABLET ),
			'001DL'										=> array( 'Dell', 'Streak', TYPE_TABLET ),
			'101DL'										=> array( 'Dell', 'Streak Pro', TYPE_TABLET ),
			'GS01'										=> array( 'Dell', 'Streak Pro', TYPE_TABLET ),
			'Dell Streak Pro'							=> array( 'Dell', 'Streak Pro', TYPE_TABLET ),
			'streak7'									=> array( 'Dell', 'Streak 7', TYPE_TABLET ),
			'Dell Streak 7'								=> array( 'Dell', 'Streak 7', TYPE_TABLET ),
			'Dell Streak 10 Pro'						=> array( 'Dell', 'Streak 10 Pro', TYPE_TABLET ),
			'Dell V04B'									=> array( 'Dell', 'Streak V04B', TYPE_TABLET ),
			'Dell Venue'								=> array( 'Dell', 'Venue' ),
			'Dell XCD35'								=> array( 'Dell', 'XCD35' ),
			'XCD35'										=> array( 'Dell', 'XCD35' ),
			'deovo V5'									=> array( 'deovo', 'V5' ),
			'Digma iDj7!'								=> array( 'Digma', 'iDj7', TYPE_TABLET ),
			'iDj7n'										=> array( 'Digma', 'iDj7n', TYPE_TABLET ),
			'DIGMA iDs10!'								=> array( 'Digma', 'iDs10', TYPE_TABLET ),
			'iDx7'										=> array( 'Digma', 'iDx7', TYPE_TABLET ),
			'iDxD7 3G'									=> array( 'Digma', 'iDxD7', TYPE_TABLET ),
			'iDx10!'									=> array( 'Digma', 'iDx10', TYPE_TABLET ),
			'DISTAB9000R'								=> array( 'Disgo', 'Distab 9000R', TYPE_TABLET ),
			'DM009SH'									=> array( 'Disney Mobile', 'DM009SH' ),
			'DM010SH'									=> array( 'Disney Mobile', 'DM010SH' ),
			'DM012SH'									=> array( 'Disney Mobile', 'DM012SH' ),
			'F-08D'										=> array( 'Disney Mobile', 'F-08D' ),
			'N-03E'										=> array( 'Disney Mobile', 'N-03E' ),
			'P-05D'										=> array( 'Disney Mobile', 'P-05D' ),
			'DJC Touchtab3'								=> array( 'DJC', 'Touchtab3', TYPE_TABLET ),
			'DPS Dream 9'								=> array( 'DPS', 'Dream 9', TYPE_TABLET ),
			'domod G20'									=> array( 'Domod', 'G20' ),
			'M975'										=> array( 'Double Power', 'M975', TYPE_TABLET ),
			'TD-1010'									=> array( 'Double Power', 'TD-1010', TYPE_TABLET ),
			'Tablet-P27'								=> array( 'DracoTek', 'P27 Tablet', TYPE_TABLET ),
			'ACM3066-8'									=> array( 'MY|eebo', 'Color Tablet', TYPE_TABLET ),
			'SUPREME IPS Dual Core X200'				=> array( 'E-Boda', 'Supreme IPS Dual Core X200', TYPE_TABLET ),
			'EBEST V5'									=> array( 'EBEST', 'V5' ),
			'EBEST W16A'								=> array( 'EBEST', 'W16A' ),
			'EBEST W18'									=> array( 'EBEST', 'W18' ),
			'EBEST W70'									=> array( 'EBEST', 'W70' ),
			'D709'										=> array( 'Empire Electronix', 'Tablet D709', TYPE_TABLET ),
			'edgejr'									=> array( 'EnTourage', 'Pocket eDGe', TYPE_TABLET ),
			'l97D'										=> array( 'EPad', 'l97D', TYPE_TABLET ),
			'epade A360S'								=> array( 'epade', 'A360S' ),
			'equiso.smart.tv.pro'						=> array( 'Equiso', 'SmartTV', TYPE_TELEVISION ),
			'M4301'										=> array( 'Eston', 'MID M4301', 'media' ),
			'P10AN'										=> array( 'Exper', 'Easypad P10AN', TYPE_TABLET ),
			'Explay Advance'							=> array( 'Explay', 'Advance' ),
			'Informer-702'								=> array( 'Explay', 'Informer 702', TYPE_TABLET ),
			'informer 921'								=> array( 'Explay', 'Informer 921', TYPE_TABLET ),
			'Explay Surfer 7.02'						=> array( 'Explay', 'Surfer 7.02', TYPE_TABLET ),
			'FIH-F0X'									=> array( 'FIH', 'F0X' ),
			'FLY F45s'									=> array( 'Fly', 'F45s' ),
			'Fly F350'									=> array( 'Fly', 'F350' ),
			'(Fly )?IQ235!'								=> array( 'Fly', 'IQ235 Uno' ),
			'(Fly )?IQ237!'								=> array( 'Fly', 'IQ237 Dynamic' ),
			'(Fly )?IQ245!'								=> array( 'Fly', 'IQ245 Wizard' ),
			'(Fly )?IQ245 Plus!'						=> array( 'Fly', 'IQ245 Wizard Plus' ),
			'(Fly )?IQ255!'								=> array( 'Fly', 'IQ255 Pride' ),
			'(Fly )?IQ256!'								=> array( 'Fly', 'IQ256 Vogue' ),
			'(Fly )?IQ260!'								=> array( 'Fly', 'IQ260 BlackBird' ),
			'(Fly )?IQ280!'								=> array( 'Fly', 'IQ280 Tech' ),
			'(Fly )?IQ285!'								=> array( 'Fly', 'IQ285 Turbo' ),
			'(Fly )?IQ430!'								=> array( 'Fly', 'IQ430 Evoke' ),
			'(Fly )?IQ440!'								=> array( 'Fly', 'IQ440 Energie' ),
			'(Fly )?IQ441!'								=> array( 'Fly', 'IQ441 Radiance' ),
			'(Fly )?IQ442!'								=> array( 'Fly', 'IQ442 Miracle' ),
			'(Fly )?IQ443!'								=> array( 'Fly', 'IQ443 Trend' ),
			'(Fly )?IQ444!'								=> array( 'Fly', 'IQ444 Diamond' ),
			'(Fly )?IQ446!'								=> array( 'Fly', 'IQ446 Magic' ),
			'(Fly )?IQ450!'								=> array( 'Fly', 'IQ450 Horizon' ),
			'(Fly )?IQ451!'								=> array( 'Fly', 'IQ451 Vista' ),
			'BC1003'									=> array( 'Flytouch', 'BC1003', TYPE_TABLET ),
			'Freelander I20'							=> array( 'Freelander', 'i20' ),
			'NABI2-NV7A'								=> array( 'Fuhu', 'Nabi 2', TYPE_TABLET ),
			'NABI2-NV7A-UK'								=> array( 'Fuhu', 'Nabi 2', TYPE_TABLET ),
			'201F'										=> array( 'Fujitsu', 'Arrows A' ),
			'ISW11F'									=> array( 'Fujitsu', 'Arrows Z' ),
			'ISW13F'									=> array( 'Fujitsu', 'Arrows Z' ),
			'IS12F'										=> array( 'Fujitsu', 'Arrows ES' ),
			'F-01D'										=> array( 'Fujitsu', 'Arrows Tab LTE', TYPE_TABLET ),
			'F-02E'										=> array( 'Fujitsu', 'Arrows X' ),
			'F-03D'										=> array( 'Fujitsu', 'Arrows Kiss' ),
			'F-03E'										=> array( 'Fujitsu', 'Arrows Kiss' ),
			'F-04E'										=> array( 'Fujitsu', 'Arrows V' ),
			'F-05D'										=> array( 'Fujitsu', 'Arrows X LTE' ),
			'F-05E'										=> array( 'Fujitsu', 'Arrows Tab' ),
			'F-06E'										=> array( 'Fujitsu', 'Arrows NX' ),
			'F-07D'										=> array( 'Fujitsu', 'Arrows μ' ),
			'F-09D'										=> array( 'Fujitsu', 'ANTEPRIMA' ),
			'F-10D'										=> array( 'Fujitsu', 'Arrows X F-10D' ),
			'F-11D'										=> array( 'Fujitsu', 'Arrows Me' ),
			'F-12C'										=> array( 'Fujitsu', 'Globetrotter' ),
			'F-12D'										=> array( 'Fujitsu', 'F-12D' ),
			'f12arc'									=> array( 'Fujitsu', 'F12arc' ),
			'f12bob'									=> array( 'Fujitsu', 'F12bob' ),
			'FJL21'										=> array( 'Fujitsu', 'Arrows ef FJL21' ),
			'M532'										=> array( 'Fujitsu', 'Stylistic M532', TYPE_TABLET ),
			'Garminfone'								=> array( 'Garmin-Asus', 'Garminfone' ),
			'Garmin-Asus A10'							=> array( 'Garmin-Asus', 'Nuvifone A10' ),
			'Garmin-Asus A50'							=> array( 'Garmin-Asus', 'Nuvifone A50' ),
			'TPA60W'									=> array( 'Gateway', 'TPA60W', TYPE_TABLET ),
			'Geeksphone ZERO'							=> array( 'Geeksphone', 'ZERO'),
			'Gemei G2'									=> array( 'Gemei', 'G2', TYPE_TABLET ),
			'Gemei G3'									=> array( 'Gemei', 'G3', TYPE_TABLET ),
			'Gemei G9'									=> array( 'Gemei', 'G9', TYPE_TABLET ),
			'GEM7008'									=> array( 'Gemini', 'JoyTab GEM7008', TYPE_TABLET ),
			'GSmart G1310'								=> array( 'Gigabyte', 'GSmart G1310' ),
			'GSmart G1315!'								=> array( 'Gigabyte', 'GSmart G1315' ),
			'GSmart G1317D'								=> array( 'Gigabyte', 'GSmart G1317D' ),
			'GSmart G1342'								=> array( 'Gigabyte', 'GSmart G1342' ),
			'GSmart G1345'								=> array( 'Gigabyte', 'GSmart G1345' ),
			'GSmart G1355'								=> array( 'Gigabyte', 'GSmart G1355' ),
			'GSmart G1362'								=> array( 'Gigabyte', 'GSmart G1362' ),
			'GSmart GS202!'								=> array( 'Gigabyte', 'GSmart GS202' ),
			'GSmart Maya M1'							=> array( 'Gigabyte', 'Maya M1' ),
			'GSmart Rio R1'								=> array( 'Gigabyte', 'Rio R1' ),
			'Gigabyte TB100'							=> array( 'Gigabyte', 'TB100', TYPE_TABLET ),
			'GIO-GiONEE C500'							=> array( 'Gionee', 'C500' ),
			'GIO-GiONEE C600'							=> array( 'Gionee', 'C600' ),
			'GN100'										=> array( 'Gionee', 'GN100' ),		
			'GN105'										=> array( 'Gionee', 'GN105' ),		
			'GN106'										=> array( 'Gionee', 'GN106' ),		
			'GN109'										=> array( 'Gionee', 'GN109' ),
			'GN135'										=> array( 'Gionee', 'GN135' ),
			'GN180'										=> array( 'Gionee', 'GN180' ),
			'GN200'										=> array( 'Gionee', 'GN200' ),		
			'GN205'										=> array( 'Gionee', 'GN205' ),
			'GN305'										=> array( 'Gionee', 'GN305' ),
			'GN360'										=> array( 'Gionee', 'GN360' ),
			'GN700T'									=> array( 'Gionee', 'GN700T' ),
			'GN700W'									=> array( 'Gionee', 'GN700W' ),
			'GN708W'									=> array( 'Gionee', 'GN708W' ),
			'GN800'										=> array( 'Gionee', 'GN800' ),
			'GN818T'									=> array( 'Gionee', 'GN818T' ),
			'GN858'										=> array( 'Gionee', 'GN858' ),
			'GN868'										=> array( 'Gionee', 'GN86N7078' ),
			'GOCLEVER'									=> array( 'Goclever', 'TAB', TYPE_TABLET ),
			'GOCLEVER TAB A73'							=> array( 'Goclever', 'TAB A73', TYPE_TABLET ),
			'GOCLEVER TAB A93'							=> array( 'Goclever', 'TAB A93', TYPE_TABLET ),
			'GOCLEVER TAB A103'							=> array( 'Goclever', 'TAB A103', TYPE_TABLET ),
			'GoClever A103'								=> array( 'Goclever', 'TAB A103', TYPE_TABLET ),
			'GOCLEVER TAB A104!'						=> array( 'Goclever', 'TAB A104', TYPE_TABLET ),
			'GOCLEVER TAB M703G'						=> array( 'Goclever', 'TAB M703G', TYPE_TABLET ),
			'GOCLEVER TAB M813G'						=> array( 'Goclever', 'TAB M813G', TYPE_TABLET ),
			'GOCLEVER TAB R70'							=> array( 'Goclever', 'TAB R70', TYPE_TABLET ),
			'GOCLEVER TAB R106'							=> array( 'Goclever', 'TAB R106', TYPE_TABLET ),
			'GOCLEVER TAB T76'							=> array( 'Goclever', 'TAB T76', TYPE_TABLET ),
			'GOCLEVER TAB 9300'							=> array( 'Goclever', 'TAB 9300', TYPE_TABLET ),
			'GOCLEVER HYBRID'							=> array( 'Goclever', 'Hybrid', TYPE_TABLET ),
			'GHONG W100'								=> array( 'Guohong', 'W100' ),
			'M758A'										=> array( 'Gpad', 'M758A', TYPE_TABLET ),
			'GO M3'										=> array( 'GreenOrange', 'M3' ),
			'HE-E760'									=> array( 'Haier', 'HE-E760' ),
			'Haier-HT-I617'								=> array( 'Haier', 'HT-I617' ),
			'HT-I617'									=> array( 'Haier', 'HT-I617' ),
			'Haier HW-W910'								=> array( 'Haier', 'HW-W910' ),
			'Haier-N88W'								=> array( 'Haier', 'N88W' ),
			'W718'										=> array( 'Haier', 'W718' ),
			'I9220'										=> array( 'Haipai', 'I9220' ),
			'X710d'										=> array( 'Haipai', 'X710D' ),
			'X720D'										=> array( 'Haipai', 'X720D' ),
			'SN10T1'									=> array( 'HANNspree', 'HANNSpad SN10T1', TYPE_TABLET ),
			'SN10T2'									=> array( 'HANNspree', 'HANNSpad SN10T2', TYPE_TABLET ),
			'HannsComb'									=> array( 'HANNspree', 'HANNSpad', TYPE_TABLET ),
			'Hannspadd'									=> array( 'HANNspree', 'HANNSpad', TYPE_TABLET ),
			'MITO A300'									=> array( 'Harga', 'MITO A300' ),
			'X1'										=> array( 'HCL', 'ME X1', TYPE_TABLET ),
			'Y2'										=> array( 'HCL', 'ME Y2', TYPE_TABLET ),
			'H701'										=> array( 'Hedy', 'H701' ),
			'9300+'										=> array( 'Hero', '9300+' ),
			'H2000+'									=> array( 'Hero', 'H2000+' ),
			'H9500'										=> array( 'Hero', 'H9500' ),
			'MID Ser(ai|ia)ls!'							=> array( 'Herotab', 'C8', TYPE_TABLET ),
			'HILIVE H7'									=> array( 'Hilive', 'H7' ),
			'HS-7DTB4'									=> array( 'Hipstreet', '7" Titan tablet', TYPE_TABLET ),
			'HS-7DTB5'									=> array( 'Hipstreet', '7" Nova tablet', TYPE_TABLET ),
			'HS-7DTB6!'									=> array( 'Hipstreet', '7" Aurora tablet', TYPE_TABLET ),
			'HS-9DTB4!'									=> array( 'Hipstreet', '9" Flare tablet', TYPE_TABLET ),
			'HS-10DTB2'									=> array( 'Hipstreet', '10" Equinox tablet', TYPE_TABLET ),
			'Cosmo'										=> array( 'Hiscreen', 'Cosmo', TYPE_TABLET ),
			'COSMO DUO'									=> array( 'Hiscreen', 'Cosmo DUO', TYPE_TABLET ),
			'HS-U8'										=> array( 'Hisense', 'U8' ),
			'HS-U950'									=> array( 'Hisense', 'U950' ),
			'HS-U960Q'									=> array( 'Hisense', 'U960' ),
			'HS-T9'										=> array( 'Hisense', 'T9' ),
			'HS-T92'									=> array( 'Hisense', 'T92' ),
			'T92'										=> array( 'Hisense', 'T92' ),
			'Hisense T92'								=> array( 'Hisense', 'T92' ),
			'HS-T96'									=> array( 'Hisense', 'T96' ),
			'HS-T818'									=> array( 'Hisense', 'T818' ),
			'HS-T830'									=> array( 'Hisense', 'T830' ),
			'HS-T909'									=> array( 'Hisense', 'T909' ),
			'HS-T930'									=> array( 'Hisense', 'T930' ),
			'HS-T950'									=> array( 'Hisense', 'T950' ),
			'HS-T958'									=> array( 'Hisense', 'T958' ),
			'HS-F1'										=> array( 'Hisense', 'F1' ),
			'HS-E86'									=> array( 'Hisense', 'E86' ),
			'HS-E820'									=> array( 'Hisense', 'E820' ),
			'HS-E830'									=> array( 'Hisense', 'E830' ),
			'HS-E860'									=> array( 'Hisense', 'E860' ),
			'E860'										=> array( 'Hisense', 'E860' ),
			'HS-E910'									=> array( 'Hisense', 'E910' ),
			'HS-E912!'									=> array( 'Hisense', 'E912' ),
			'HS-E920'									=> array( 'Hisense', 'E920' ),
			'HS-E926'									=> array( 'Hisense', 'E926' ),
			'HS-E930'									=> array( 'Hisense', 'E930' ),
			'HS-E956Q'									=> array( 'Hisense', 'E956' ),
			'HS-EG900'									=> array( 'Hisense', 'EG900' ),
			'HS-EG901'									=> array( 'Hisense', 'EG901' ),
			'HS-EG906'									=> array( 'Hisense', 'EG906' ),
			'HS-EG909'									=> array( 'Hisense', 'EG909' ),
			'AD683G'									=> array( 'Hisense', 'EG909' ),
			'HS-EG950'									=> array( 'Hisense', 'EG950' ),
			'HS-EG958'									=> array( 'Hisense', 'EG958' ),
			'HS-EG970'									=> array( 'Hisense', 'EG970' ),
			'HS-ET919'									=> array( 'Hisense', 'ET919' ),
			'EG968B'									=> array( 'Hisense', 'EG968B' ),
			'HKPHONE H8-3G'								=> array( 'HKPhone', 'H8 3G' ),
			'D7800AD'									=> array( 'Honeywell', 'D7800AD' ),
			'HOSIN U2'									=> array( 'Hosin', 'U2' ),
			'Hosin U7'									=> array( 'Hosin', 'U7' ),
			'HP Slate 7'								=> array( 'HP', 'Slate 7', TYPE_TABLET ),
			'(HP )?Touchpad!'							=> array( 'HP', 'TouchPad', TYPE_TABLET ),
			'(cm|aokp) tenderloin!'						=> array( 'HP', 'TouchPad', TYPE_TABLET ),
			'Amaze 4G'									=> array( 'HTC', 'Amaze 4G' ),
			'HTC (Amaze|Ruby)!'							=> array( 'HTC', 'Amaze 4G' ),
			'HTC (Aria|Liberty)!'						=> array( 'HTC', 'Aria' ),
			'HTC A63(66|80)!'							=> array( 'HTC', 'Aria' ),
			'HTC Bee'									=> array( 'HTC', 'Bee' ),
			'HTC ?ChaCha!'								=> array( 'HTC', 'ChaCha' ),
			'HTC A810e'									=> array( 'HTC', 'ChaCha' ),
			'HTC A9188!'								=> array( 'HTC', 'Cullinan' ),
			'HTC Desire C'								=> array( 'HTC', 'Desire C' ),
			'HTC H1000C'								=> array( 'HTC', 'Desire C' ),
			'HTC A320e'									=> array( 'HTC', 'Desire C' ),
			'HTC Desire ?HD!'							=> array( 'HTC', 'Desire HD' ),
			'HTC A91(91|92)!'							=> array( 'HTC', 'Desire HD' ),
			'HTC PM6014'								=> array( 'HTC', 'Desire L' ),
			'HTC ?Desire ?S( |$)!'						=> array( 'HTC', 'Desire S' ),
			'HTC S510(b|e)!'							=> array( 'HTC', 'Desire S' ),
			'HTC Desire Saga'							=> array( 'HTC', 'Desire S' ),
			'HTC Saga'									=> array( 'HTC', 'Desire S' ),
			'HTC Desire V'								=> array( 'HTC', 'Desire V' ),
			'HTC T328w'									=> array( 'HTC', 'Desire V' ),
			'HTC Desire VC'								=> array( 'HTC', 'Desire VC' ),
			'HTC T328d'									=> array( 'HTC', 'Desire VC' ),
			'HTC Desire VT'								=> array( 'HTC', 'Desire VT' ),
			'HTC T328t'									=> array( 'HTC', 'Desire VT' ),
			'HTC Desire ?X!'							=> array( 'HTC', 'Desire X' ),
			'HTC T329w'									=> array( 'HTC', 'Desire X' ),
			'HTC Desire ?Z!'							=> array( 'HTC', 'Desire Z' ),
			'HTC Vision'								=> array( 'HTC', 'Desire Z' ),
			'HTC A72(71|72|75)!'						=> array( 'HTC', 'Desire Z' ),
			'HTC T329d'									=> array( 'HTC', 'T329d' ),
			'HTC Desire!'								=> array( 'HTC', 'Desire' ),
			'HTC Bravo'									=> array( 'HTC', 'Desire' ),
			'HTC eris'									=> array( 'HTC', 'Desire' ),
			'HTC A81(81|83)!'							=> array( 'HTC', 'Desire' ),
			'HTC ?X06HT!'								=> array( 'HTC', 'Desire' ),
			'HTC 606w'									=> array( 'HTC', 'Desire 606w' ),
			'HTC 608t'									=> array( 'HTC', 'Desire 608t' ),
			'HTC Dream'									=> array( 'HTC', 'Dream' ),
			'HTC Droid DNA'								=> array( 'HTC', 'Droid DNA' ),
			'HTC Droid Incredible'						=> array( 'HTC', 'Droid Incredible' ),
			'HTC S710d'									=> array( 'HTC', 'Droid Incredible 2' ),
			'HTC Incredible 2'							=> array( 'HTC', 'Droid Incredible 2' ),
			'HTC ?EVO ?3D!'								=> array( 'HTC', 'EVO 3D' ),
			'HTC X51(5a|5c|5d|5m)!'						=> array( 'HTC', 'EVO 3D' ),
			'HTC EVO 4G\+!'								=> array( 'HTC', 'EVO 4G+' ),
			'HTC X515e'									=> array( 'HTC', 'EVO 4G+' ),
			'HTC ?EVO ?4G!'								=> array( 'HTC', 'EVO 4G' ),
			'HTC jewel'									=> array( 'HTC', 'EVO 4G' ),
			'HTC ?EVO ?V ?4G!'							=> array( 'HTC', 'EVO V 4G' ),
			'HTC ?(EVO ?)?Design ?4G!'					=> array( 'HTC', 'EVO Design 4G' ),		
			'HTC C715c'									=> array( 'HTC', 'EVO Design 4G' ),
			'HTC EVO Shift!'							=> array( 'HTC', 'EVO Shift' ),
			'HTC EVO View 4G'							=> array( 'HTC', 'EVO View 4G' ),
			'HTC ?Explorer!'							=> array( 'HTC', 'Explorer' ),
			'HTC A31(0b|0e)!'							=> array( 'HTC', 'Explorer' ),
			'HTC Pico Incredible HD'					=> array( 'HTC', 'Explorer' ),
			'HTC first'									=> array( 'HTC', 'First' ),
			'HTC Flyer!'								=> array( 'HTC', 'Flyer', TYPE_TABLET ),
			'HTC P51(0e|2|5e)!'							=> array( 'HTC', 'Flyer', TYPE_TABLET ),
			'HTC Gratia!'								=> array( 'HTC', 'Gratia' ),
			'HTC A6380'									=> array( 'HTC', 'Gratia' ),
			'HTC HD'									=> array( 'HTC', 'HD' ),
			'HTC HD2!'									=> array( 'HTC', 'HD2' ),
			'HTC T8585'									=> array( 'HTC', 'HD2' ),
			'HTC HD7!'									=> array( 'HTC', 'HD7' ),
			'HTC T92(98|99)!'							=> array( 'HTC', 'HD7' ),
			'HTC HD7S!'									=> array( 'HTC', 'HD7s' ),
			'HTC T(93|98)99!'							=> array( 'HTC', 'HD7s' ),
			'VitMod ExtraLite 1.6.5.fullodex for HTC HD7 Pro'		=> array( 'HTC', 'HD7 Pro' ),
			'HTC HERO200'								=> array( 'HTC', 'Hero 200' ),			/* Sprint */
			'HTC Hero S'								=> array( 'HTC', 'Hero S' ),				/* US Cellular */
			'HTC Hero!'									=> array( 'HTC', 'Hero' ),
			'HTC H3000C'								=> array( 'HTC', 'Hero' ),
			'HTC IMAGIO'								=> array( 'HTC', 'Imagio' ),
			'HTC Incredible'							=> array( 'HTC', 'Incredible' ),
			'HTC Incredible CDMA'						=> array( 'HTC', 'Incredible' ),
			'HTC Incredible ?S!'						=> array( 'HTC', 'Incredible S' ),
			'HTC ?Vivo!'								=> array( 'HTC', 'Incredible S' ),
			'HTC S710e!'								=> array( 'HTC', 'Incredible S' ),
			'HTC Innovation'							=> array( 'HTC', 'Innovation' ),
			'HTC (HD7 )?Inspire!'						=> array( 'HTC', 'Inspire 4G' ),
			'HTC J Z321e'								=> array( 'HTC', 'J' ),
			'HTC X920e'									=> array( 'HTC', 'J Butterfly' ),
			'HTC Butterfly'								=> array( 'HTC', 'J Butterfly' ),
			'HTC J Butterfly'							=> array( 'HTC', 'J Butterfly' ),
			'HTC P715a'									=> array( 'HTC', 'Jetstream', TYPE_TABLET ),
			'HTC PG09410'								=> array( 'HTC', 'Jetstream', TYPE_TABLET ),
			'HTC Legend'								=> array( 'HTC', 'Legend' ),
			'HTC Magic!'								=> array( 'HTC', 'Magic' ),
			'HTC Sapphire'								=> array( 'HTC', 'Magic' ),
			'HTC Merge'									=> array( 'HTC', 'Merge' ),
			'HTC Lexikon'								=> array( 'HTC', 'Merge' ),
			'HTC One S'									=> array( 'HTC', 'One S' ),
			'HTC One S !'								=> array( 'HTC', 'One S' ),
			'HTC Z(52|56)0e!'							=> array( 'HTC', 'One S' ),
			'HTC T528d'									=> array( 'HTC', 'One SC' ),
			'HTC T528t'									=> array( 'HTC', 'One ST' ),
			'HTC T528w'									=> array( 'HTC', 'One SU' ),
			'HTC One ?SV!'								=> array( 'HTC', 'One SV' ),
			'HTC C525c'									=> array( 'HTC', 'One SV' ),
			'HTC C525u'									=> array( 'HTC', 'One SV' ),
			'HTC One V'									=> array( 'HTC', 'One V' ),
			'HTC T120C'									=> array( 'HTC', 'One V' ),
			'HTC T320e'									=> array( 'HTC', 'One V' ),
			'HTC H2000C'								=> array( 'HTC', 'One V' ),
			'HTC One VX'								=> array( 'HTC', 'One VX' ),
			'HTC ?One ?X!'								=> array( 'HTC', 'One X' ),
			'HTC Endeavour!'							=> array( 'HTC', 'One X' ),
			'HTC S720e'									=> array( 'HTC', 'One X' ),
			'HTC One X S720e'							=> array( 'HTC', 'One X' ),
			'HTC One X with Beats Audio'				=> array( 'HTC', 'One X' ),
			'HTC One X+'								=> array( 'HTC', 'One X+' ),
			'HTC OneXplus'								=> array( 'HTC', 'One X+' ),
			'HTC PM63100'								=> array( 'HTC', 'One X+' ),
			'HTC X720d'									=> array( 'HTC', 'One XC' ),
			'HTC ?One XL!'								=> array( 'HTC', 'One XL' ),
			'HTC S720t'									=> array( 'HTC', 'One XT' ),
			'HTC 801e'									=> array( 'HTC', 'One' ),
			'HTC 802d'									=> array( 'HTC', 'One' ),
			'HTC 802t'									=> array( 'HTC', 'One' ),
			'HTC 802w'									=> array( 'HTC', 'One' ),
			'HTC PN071'									=> array( 'HTC', 'One' ),
			'HTC PN072'									=> array( 'HTC', 'One' ),
			'HTC PN07120'								=> array( 'HTC', 'One' ),
			'HTC One 801e'								=> array( 'HTC', 'One' ),
			'801a'										=> array( 'HTC', 'One' ),
			'HTC One'									=> array( 'HTC', 'One' ),
			'HTCONE'									=> array( 'HTC', 'One' ),
			'HTC PO581'									=> array( 'HTC', 'One Mini' ),
			'HTC PO582'									=> array( 'HTC', 'One Mini' ),
			'HTC Raider!'								=> array( 'HTC', 'Raider 4G' ),
			'HTC Holiday'								=> array( 'HTC', 'Raider 4G' ),
			'HTC X710(a|e|s)!'							=> array( 'HTC', 'Raider 4G' ),
			'HTC PH39100'								=> array( 'HTC', 'Raider 4G' ),
			'HTC Rezound'								=> array( 'HTC', 'Rezound' ),
			'HTC Rhyme!'								=> array( 'HTC', 'Rhyme' ),
			'HTC Bliss!'								=> array( 'HTC', 'Rhyme' ),
			'HTC S510b'									=> array( 'HTC', 'Rhyme' ),
			'HTC Salsa!'								=> array( 'HTC', 'Salsa' ),	
			'HTC C510e'									=> array( 'HTC', 'Salsa' ),
			'HTC Sensation.*XE!'						=> array( 'HTC', 'Sensation XE' ),
			'HTC .*Z715(a|e)!'							=> array( 'HTC', 'Sensation XE' ),
			'HTC Sensation.*XL!'						=> array( 'HTC', 'Sensation XL' ),
			'HTC Runnymede'								=> array( 'HTC', 'Sensation XL' ),
			'HTC .*X315(b|e)!'							=> array( 'HTC', 'Sensation XL' ),
			'HTC G21!'									=> array( 'HTC', 'Sensation XL' ),
			'HTC ?Sensation!'							=> array( 'HTC', 'Sensation' ),
			'HTC Pyramid!'								=> array( 'HTC', 'Sensation' ),
			'HTC .*Z710(a|e|t)?!'						=> array( 'HTC', 'Sensation' ),
			'HTC G14!'									=> array( 'HTC', 'Sensation' ),
			'HTC Status'								=> array( 'HTC', 'Status' ),
			'HTC PH06130'								=> array( 'HTC', 'Status' ),
			'HTC Tattoo!'								=> array( 'HTC', 'Tattoo' ),
			'HTC Click'									=> array( 'HTC', 'Tattoo' ),
			'HTC A3288'									=> array( 'HTC', 'Tattoo' ),
			'HTC A9188'									=> array( 'HTC', 'Tianxi' ),
			'HTC X310e'									=> array( 'HTC', 'Titan' ),
			'HTC Polaris'								=> array( 'HTC', 'Touch Cruise' ),
			'HTC DiamondII EX'							=> array( 'HTC', 'Touch Diamond II' ),
			'HTC T7373'									=> array( 'HTC', 'Touch Pro II' ),
			'HTC ThunderBolt( 4G)?!'					=> array( 'HTC', 'ThunderBolt'),	
			'HTC Mecha'									=> array( 'HTC', 'ThunderBolt'),
			'HTC Kaiser'								=> array( 'HTC', 'TyTN II'),
			'HTC Velocity!'								=> array( 'HTC', 'Velocity 4G'),
			'HTC Vivid'									=> array( 'HTC', 'Vivid'),
			'HTC ?Wildfire ?S!'							=> array( 'HTC', 'Wildfire S' ),	
			'HTC .*A510(a|b|c|e)!'						=> array( 'HTC', 'Wildfire S' ),
			'HTC ?PG762!'								=> array( 'HTC', 'Wildfire S' ),
			'HTC Wildfire!'								=> array( 'HTC', 'Wildfire' ),
			'HTC .*A33(33|66|80)!'						=> array( 'HTC', 'Wildfire' ),
			'HTC A6390'									=> array( 'HTC', 'A6390' ),
			'HTC A8180'									=> array( 'HTC', 'A8180' ),
			'HTC S610d'									=> array( 'HTC', 'S610d' ),
			'HTC S715e'									=> array( 'HTC', 'S715e' ),
			'HTC T327t'									=> array( 'HTC', 'T327t' ),
			'HTC T329t'									=> array( 'HTC', 'T329t' ),
			'HTC Z510d'									=> array( 'HTC', 'Z510d' ),
			'HTC PO681'									=> array( 'HTC', 'Droid DNA 2' ),
			'HTC PO682'									=> array( 'HTC', 'Butterfly S' ),
			'HTC GOF U'									=> array( 'HTC', 'Desire C' ),
			'HTC VLE U'									=> array( 'HTC', 'One S' ),
			'HTC VLE#U'									=> array( 'HTC', 'One S' ),
			'HTC VIE U'									=> array( 'HTC', 'One S' ),
			'HTC K2 UL'									=> array( 'HTC', 'One SV' ),
			'HTC EVA UL'								=> array( 'HTC', 'One V' ),
			'HTC EVA UTL'								=> array( 'HTC', 'One V' ),
//			'HTC IMN WLJ'								
			'HTC DLX WLJ'								=> array( 'HTC', 'J Butterfly' ),
			'HTC DLX WL'								=> array( 'HTC', 'Droid DNA' ),
			'HTC DLX U'									=> array( 'HTC', 'Droid DNA' ),
			'HTC6435LVW!'								=> array( 'HTC', 'Droid DNA' ),
			'DLX'										=> array( 'HTC', 'Droid DNA' ),
			'HTC ENR U'									=> array( 'HTC', 'One X' ),
			'ENR U'										=> array( 'HTC', 'One X' ),
			'EndeavorU'									=> array( 'HTC', 'One X' ),
			'HTC EVARE UL'								=> array( 'HTC', 'One X+' ),
			'Liberty'									=> array( 'HTC', 'Aria' ),
			'Desire HD!'								=> array( 'HTC', 'Desire HD' ),
			'Desire ?S!'								=> array( 'HTC', 'Desire S' ),
			'Desire Z'									=> array( 'HTC', 'Desire Z' ),
			'Desire!'									=> array( 'HTC', 'Desire' ),
			'Dream'										=> array( 'HTC', 'Dream' ),
			'GinDream/GinMagic'							=> array( 'HTC', 'Dream' ),
			'SiRF Dream'								=> array( 'HTC', 'Dream' ),
			'Droid Incredible'							=> array( 'HTC', 'Droid Incredible' ),
			'Incredible'								=> array( 'HTC', 'Droid Incredible' ),	/* Verizon */
			'Incredible 2'								=> array( 'HTC', 'Droid Incredible 2' ),	/* Verizon */
			'EVO'										=> array( 'HTC', 'EVO' ),
			'Evo HD2'									=> array( 'HTC', 'EVO HD' ),
			'EVO ?3D!'									=> array( 'HTC', 'EVO 3D' ),
			'EVO 4G'									=> array( 'HTC', 'EVO 4G' ),
			'Evo V 4G'									=> array( 'HTC', 'EVO V 4G' ),
			'photon'									=> array( 'HTC', 'HD mini' ),
			'HD2'										=> array( 'HTC', 'HD2' ),
			'NexusHD2'									=> array( 'HTC', 'HD2' ),
			'Nexus HD2'									=> array( 'HTC', 'HD2' ),
			'HD7  Pro'									=> array( 'HTC', 'HD7 Pro' ),
			'Hero'										=> array( 'HTC', 'Hero' ),
			'HERO CDMA'									=> array( 'HTC', 'Hero' ),
			'HERO200'									=> array( 'HTC', 'Hero 200' ),
			'Incredible ?S!'							=> array( 'HTC', 'Incredible S' ),
			'Incredible ?2!'							=> array( 'HTC', 'Incredible 2' ),
			'Inspire HD'								=> array( 'HTC', 'Inspire 4G' ),
			'Inspire 4G'								=> array( 'HTC', 'Inspire 4G' ),
			'Legend'									=> array( 'HTC', 'Legend' ),
			'Docomo HT-03A'								=> array( 'HTC', 'Magic' ),
			'One S'										=> array( 'HTC', 'One S' ),
			'One X'										=> array( 'HTC', 'One X' ),
			'One V'										=> array( 'HTC', 'One V' ),
			'Rezound'									=> array( 'HTC', 'Rezound' ),
			'MIUI.us Sensation 4G'						=> array( 'HTC', 'Sensation 4G' ),
			'SensationXE!'								=> array( 'HTC', 'Sensation XE' ),
			'SensationXL!'								=> array( 'HTC', 'Sensation XL' ),
			'Sensation!'								=> array( 'HTC', 'Sensation' ),
			'Pyramid'									=> array( 'HTC', 'Sensation' ),
			'TripNiCE Pyramid'							=> array( 'HTC', 'Sensation' ),
			'Click'										=> array( 'HTC', 'Tattoo' ),
			'Vivid 4G'									=> array( 'HTC', 'Vivid 4G' ),
			'Wildfire S!'								=> array( 'HTC', 'Wildfire S' ),
			'Wildfire!'									=> array( 'HTC', 'Wildfire' ),
			'Sprint APX515CKT'							=> array( 'HTC', 'EVO 3D' ),
			'Sprint APA9292KT'							=> array( 'HTC', 'EVO 4G' ),
			'Sprint APA7373KT'							=> array( 'HTC', 'EVO Shift 4G' ),
			'Sprint APC715CKT'							=> array( 'HTC', 'EVO Design 4G' ),
			'A320a'										=> array( 'HTC', 'Desire C' ),					
			'A3380'										=> array( 'HTC', 'Wildfire' ),
			'A6277'										=> array( 'HTC', 'Hero' ),
			'a7272'										=> array( 'HTC', 'Desire Z' ),					
			'A7272+(HTC DesireZ)'						=> array( 'HTC', 'Desire Z' ),					
			'S31HT'										=> array( 'HTC', 'Aria' ),
			'S710d'										=> array( 'HTC', 'Droid Incredible 2' ),
			'S710D'										=> array( 'HTC', 'Droid Incredible 2' ),
			'T320a'										=> array( 'HTC', 'One V' ),
			'X06HT'										=> array( 'HTC', 'Desire' ),
			'001HT'										=> array( 'HTC', 'Desire HD' ),
			'X325a'										=> array( 'HTC', 'One X' ),
			'X525a'										=> array( 'HTC', 'One X+' ),
			'X710E'										=> array( 'HTC', 'Raider 4G' ),
			'Z520m'										=> array( 'HTC', 'One S' ),
			'Z710'										=> array( 'HTC', 'Sensation' ),
			'Z710e'										=> array( 'HTC', 'Sensation' ),
			'T9199h'									=> array( 'HTC', 'T9199h' ),
			'ADR6200'									=> array( 'HTC', 'Droid Eris' ),
			'HTCADR6290US'								=> array( 'HTC', 'One V' ),
			'ADR6300'									=> array( 'HTC', 'Droid Incredible' ),
			'ADR6325!'									=> array( 'HTC', 'Merge' ),
			'ADR6330VW'									=> array( 'HTC', 'Rhyme' ),	
			'ADR6350'									=> array( 'HTC', 'Droid Incredible 2' ),
			'ADR6400L!'									=> array( 'HTC', 'Thunderbolt 4G' ),
			'ADR6410LVW!'								=> array( 'HTC', 'Fireball' ),
			'ADR6425LVW!'								=> array( 'HTC', 'Rezound' ),
			'Coquettish Red'							=> array( 'HTC', 'Rezound' ),
			'PB99400'									=> array( 'HTC', 'Desire' ),	
			'pcdadr6350'								=> array( 'HTC', 'Droid Incredible 2' ),
			'PC36100!'									=> array( 'HTC', 'EVO 4G' ),
			'PG06100'									=> array( 'HTC', 'EVO Shift 4G' ),
			'PG41200'									=> array( 'HTC', 'EVO View 4G', TYPE_TABLET ),
			'PG86100!'									=> array( 'HTC', 'EVO 3D' ),
			'PH44100'									=> array( 'HTC', 'EVO Design 4G' ),
			'PJ83100'									=> array( 'HTC', 'One X' ),
			'PM36100'									=> array( 'HTC', 'One VX' ),
			'PM63100'									=> array( 'HTC', 'One X+' ),
			'ISW11HT'									=> array( 'HTC', 'EVO 4G' ),
			'ISW12HT'									=> array( 'HTC', 'EVO 3D' ),
			'ISW13HT'									=> array( 'HTC', 'J' ),
			'HTL21!'									=> array( 'HTC', 'J Butterfly' ),
			'HTL22'										=> array( 'HTC', 'J One' ),
			'HTX21'										=> array( 'HTC', 'au Infobar A02' ),
			'USCCADR6275US!'							=> array( 'HTC', 'Desire' ),
			'USCCADR6285US!'							=> array( 'HTC', 'Hero S' ),
			'USCCADR6325US!'							=> array( 'HTC', 'Merge' ),
			'MediaPad'									=> array( 'Huawei', 'MediaPad', TYPE_TABLET ),
			'Huawei MediaPad'							=> array( 'Huawei', 'MediaPad', TYPE_TABLET ),
			'Huawei S7-312u'							=> array( 'Huawei', 'MediaPad', TYPE_TABLET ),
			'MediaPad 7 Lite'							=> array( 'Huawei', 'MediaPad 7 Lite', TYPE_TABLET ),
			'MediaPad 7 Vogue'							=> array( 'Huawei', 'MediaPad 7 Vogue', TYPE_TABLET ),
			'MediaPad 10 FHD'							=> array( 'Huawei', 'MediaPad 10', TYPE_TABLET ),
			'MediaPad 10 LINK'							=> array( 'Huawei', 'MediaPad 10 Link', TYPE_TABLET ),
			'Huawei A199'								=> array( 'Huawei', 'A199' ),
			'Huawei C8500!'								=> array( 'Huawei', 'C8500' ),
			'Huawei C8600'								=> array( 'Huawei', 'C8600' ),
			'Huawei C8650!'								=> array( 'Huawei', 'C8650' ),
			'Huawei C8655'								=> array( 'Huawei', 'Ascend Y201C' ),
			'Huawei C8800'								=> array( 'Huawei', 'IDEOS X5' ),
			'Huawei C8810'								=> array( 'Huawei', 'Ascend G300' ),
			'Huawei C8812!'								=> array( 'Huawei', 'Ascend C8812' ),
			'Huawei C8813!'								=> array( 'Huawei', 'Ascend C8813' ),
			'Huawei C8825D'								=> array( 'Huawei', 'Ascend G330C' ),
			'Huawei C8826D'								=> array( 'Huawei', 'Ascend G500C' ),
			'Huawei C8860E'								=> array( 'Huawei', 'Honor' ),
			'Huawei C8950D'								=> array( 'Huawei', 'Honor+' ),
			'Huawei G300'								=> array( 'Huawei', 'Ascend G300' ),
			'Huawei G525-U00'							=> array( 'Huawei', 'Ascend G525' ),
			'Huawei G7500'								=> array( 'Huawei', 'G7500' ),
			'Huawei H867G'								=> array( 'Huawei', 'H867G' ),
			'Huawei M835'								=> array( 'Huawei', 'M835' ),
			'Huawei M860'								=> array( 'Huawei', 'Ascend' ),
			'Huawei M920'								=> array( 'Huawei', 'M920' ),
			'Huawei M921'								=> array( 'Huawei', 'M921' ),
			'Huawei M931'								=> array( 'Huawei', 'M931' ),
			'Huawei MT1-U06'							=> array( 'Huawei', 'Ascend Mate' ),
			'Huawei MT1-T00'							=> array( 'Huawei', 'Ascend Mate' ),
			'Huawei S8520'								=> array( 'Huawei', 'S8520' ),
			'Huawei S8600'								=> array( 'Huawei', 'S8600' ),
			'Huawei T8100'								=> array( 'Huawei', 'T8100' ),
			'Huawei T8300'								=> array( 'Huawei', 'T8300' ),
			'Huawei ?T8500!'							=> array( 'Huawei', 'T8500' ),
			'Huawei T8600'								=> array( 'Huawei', 'T8600' ),
			'Huawei T8620'								=> array( 'Huawei', 'Ascend Y200T' ),
			'Huawei T8828'								=> array( 'Huawei', 'Ascend G305T' ),
			'Huawei T8830'								=> array( 'Huawei', 'Ascend G309T' ),
			'Huawei T8830Pro'							=> array( 'Huawei', 'Ascend G309T Pro' ),
			'Huawei T8833'								=> array( 'Huawei', 'Ascend Y300' ),
			'Huawei T8950'								=> array( 'Huawei', 'Honor+' ),
			'Huawei T8951'								=> array( 'Huawei', 'Ascend G510' ),
			'Huawei T9200'								=> array( 'Huawei', 'Ascend P1' ),
			'Huawei U8220'								=> array( 'Huawei', 'U8220' ),
			'Huawei U8500'								=> array( 'Huawei', 'IDEOS X2' ),
			'Huawei ?U8520!'							=> array( 'Huawei', 'U8520 Duplex' ),
			'Huawei ?U8650!'							=> array( 'Huawei', 'Sonic' ),
			'Huawei U8652'								=> array( 'Huawei', 'Sonic' ),
			'Huawei U8661'								=> array( 'Huawei', 'Sonic+' ),
			'Huawei U8665'								=> array( 'Huawei', 'Fusion 2' ),
			'Huawei U8666!'								=> array( 'Huawei', 'Ascend Y201' ),
			'Huawei U8681'								=> array( 'Huawei', 'Ascend G312' ),
			'Huawei U8800!'								=> array( 'Huawei', 'IDEOS X5' ),
			'Huawei U8815!'								=> array( 'Huawei', 'Ascend G300' ),
			'Huawei U8818'								=> array( 'Huawei', 'Ascend G300' ),
			'Huawei U8825D'								=> array( 'Huawei', 'Ascend G330D' ),
			'Huawei U8825-1'							=> array( 'Huawei', 'Ascend G330' ),
			'Huawei U8850'								=> array( 'Huawei', 'Vision' ),
			'Huawei U8860'								=> array( 'Huawei', 'Honor' ),
			'Huawei U8950!'								=> array( 'Huawei', 'Ascend G600' ),
			'Huawei ?U9000!'							=> array( 'Huawei', 'Ascend X' ),
			'Huawei U9508'								=> array( 'Huawei', 'Honor 2' ),
			'Huawei ?U9508!'							=> array( 'Huawei', 'Honor 2 Quad-core' ),
			'Huawei U9510!'								=> array( 'Huawei', 'Ascend D quad' ),
			'Huawei D2-0082'							=> array( 'Huawei', 'Ascend D2' ),
			'Huawei D2-2010'							=> array( 'Huawei', 'Ascend D2' ),
			'Huawei P2-6011'							=> array( 'Huawei', 'Ascend P2' ),
			'Huawei P2-6070'							=> array( 'Huawei', 'Ascend P2' ),
			'Huawei P6-U06'								=> array( 'Huawei', 'Ascend P6' ),
			'Huawei IDEOS U8500'						=> array( 'Huawei', 'IDEOS X2' ),
			'Huawei IDEOS U8650'						=> array( 'Huawei', 'Sonic' ),
			'Huawei IDEOS X3'							=> array( 'Huawei', 'IDEOS X3' ),
			'Huawei Ideos X5!'							=> array( 'Huawei', 'IDEOS X5' ),
			'Huawei X6'									=> array( 'Huawei', 'IDEOS X6' ),
			'Huawei SONIC'								=> array( 'Huawei', 'Sonic' ),
			'Huawei 8100-9'								=> array( 'Huawei', 'U8100' ),
			'Huawei Ascend G 300'						=> array( 'Huawei', 'Ascend G300' ),
			'Ascend G300'								=> array( 'Huawei', 'Ascend G300' ),
			'Huawei G510!'								=> array( 'Huawei', 'Ascend G510' ),
			'Huawei G520-5000'							=> array( 'Huawei', 'Ascend G520' ),
			'Huawei Y210!'								=> array( 'Huawei', 'Ascend Y210' ),
			'Huawei Y 220T'								=> array( 'Huawei', 'Ascend Y220T' ),
			'Huawei Y300!'								=> array( 'Huawei', 'Ascend Y300' ),
			'Huawei Y310!'								=> array( 'Huawei', 'Ascend Y310' ),
			'Huawei Ascend X'							=> array( 'Huawei', 'Ascend X' ),
			'FUSIONideos'								=> array( 'Huawei', 'IDEOS' ),
			'Gnappo Ideos'								=> array( 'Huawei', 'IDEOS' ),
			'Ideos'										=> array( 'Huawei', 'IDEOS' ),
			'IDEOS X5'									=> array( 'Huawei', 'IDEOS X5' ),
			'IDEOS S7!'									=> array( 'Huawei', 'IDEOS S7', TYPE_TABLET ),
			'Huawei S7'									=> array( 'Huawei', 'IDEOS S7', TYPE_TABLET ),
			'SONIC'										=> array( 'Huawei', 'Sonic' ),
			'Kyivstar Aqua'								=> array( 'Huawei', 'Sonic' ),
			'Lucky Ultra Sonic U8650'					=> array( 'Huawei', 'Sonic' ),
			'MTC Android'								=> array( 'Huawei', 'U8110' ),
			'A01HW'										=> array( 'Huawei', 'eMobile A01HW', TYPE_TABLET ),
			'S31HW'										=> array( 'Huawei', 'Pocket WiFi S' ),
			'S41HW'										=> array( 'Huawei', 'Pocket WiFi S II' ),
			'007HW'										=> array( 'Huawei', 'Vision' ),	
			'201HW'										=> array( 'Huawei', 'Ascend P1' ),
			'UM840'										=> array( 'Huawei', 'Evolution' ),	
			'M860'										=> array( 'Huawei', 'Ascend' ),
			'M865'										=> array( 'Huawei', 'Ascend II' ),
			'M886'										=> array( 'Huawei', 'Glory' ),
			'C8150'										=> array( 'Huawei', 'IDEOS' ),
			'C8500!'									=> array( 'Huawei', 'C8500' ),
			'C8600'										=> array( 'Huawei', 'C8600' ),
			'C8650!'									=> array( 'Huawei', 'C8650' ),
			'C8800'										=> array( 'Huawei', 'C8800' ),
			'C8810'										=> array( 'Huawei', 'Ascend G300C' ),
			'C8812!'									=> array( 'Huawei', 'Ascend C8812' ),
			'C8860E'									=> array( 'Huawei', 'Honor' ),
			'CM980'										=> array( 'Huawei', 'Evolution II' ),
			'S8600'										=> array( 'Huawei', 'S8600' ),
			'T8620'										=> array( 'Huawei', 'Ascend Y200T' ),
			'T8808!'									=> array( 'Huawei', 'Ascend G306T' ),
			'T8830!'									=> array( 'Huawei', 'Ascend G309T' ),
			'T9200'										=> array( 'Huawei', 'Ascend P1' ),
			'T9510E'									=> array( 'Huawei', 'Ascend D1 Quad XL' ),
			'U8100'										=> array( 'Huawei', 'U8100' ),
			'U8110'										=> array( 'Huawei', 'U8110' ),
			'U8120'										=> array( 'Huawei', 'U8120' ),
			'U8180'										=> array( 'Huawei', 'IDEOS X1' ),
			'U8220'										=> array( 'Huawei', 'Pulse' ),
			'U8300'										=> array( 'Huawei', 'U8300' ),
			'U8350'										=> array( 'Huawei', 'Boulder' ),
			'U8150'										=> array( 'Huawei', 'IDEOS' ),
			'U8160'										=> array( 'Huawei', 'U8160' ),
			'U8180'										=> array( 'Huawei', 'IDEOS X1' ),
			'U8185'										=> array( 'Huawei', 'Ascend Y100' ),
			'U8500'										=> array( 'Huawei', 'IDEOS X2' ),
			'U8500 HiQQ'								=> array( 'Huawei', 'U8500 HiQQ Edition' ),
			'U8510'										=> array( 'Huawei', 'IDEOS X3' ),
			'U8600'										=> array( 'Huawei', 'U8600' ),
			'U8650!'									=> array( 'Huawei', 'Sonic' ),
			'U8652!'									=> array( 'Huawei', 'Fusion U8652' ),
			'U8655!'									=> array( 'Huawei', 'Ascend Y200' ),
			'U8660'										=> array( 'Huawei', 'Sonic' ),
			'U8800 ?Pro!'								=> array( 'Huawei', 'IDEOS X5 Pro' ),
			'U8800!'									=> array( 'Huawei', 'IDEOS X5' ),
			'U8812D'									=> array( 'Huawei', 'Ascend G302D' ),
			'U8815'										=> array( 'Huawei', 'Ascend G300' ),
			'U8818'										=> array( 'Huawei', 'Ascend G300' ),
			'U8820'										=> array( 'Huawei', 'Titan' ),
			'U8836D'									=> array( 'Huawei', 'Ascend G500' ),
			'U8850'										=> array( 'Huawei', 'Vision' ),
			'U8860!'									=> array( 'Huawei', 'Honor' ),
			'U9000'										=> array( 'Huawei', 'Ascend X' ),
			'U9200!'									=> array( 'Huawei', 'Ascend P1' ),
			'U9202!'									=> array( 'Huawei', 'Ascend P1' ),
			'U9500'										=> array( 'Huawei', 'Ascend D1' ),
			'U9500E'									=> array( 'Huawei', 'Ascend D1 XL' ),
			'U9501L'									=> array( 'Huawei', 'Ascend D LTE' ),
			'U9510!'									=> array( 'Huawei', 'Ascend D quad' ),
			'Comet'										=> array( 'Huawei', 'Comet' ),
			'GS02'										=> array( 'Huawei', 'Honor' ),
			'GS03'										=> array( 'Huawei', 'Ascend P1' ),
			'DroniX-0.5'								=> array( 'Huawei', 'U8180' ),
			'MTS-SP101'									=> array( 'Huawei', 'C8511' ),
			'TSP21'										=> array( 'Huawei', 'U8110' ),
			'GL07S'										=> array( 'Huawei', 'Stream X GL07S' ),	
			'HW-01E'									=> array( 'Huawei', 'Ascend HW-01E' ),	
			'H866C'										=> array( 'Huawei', 'Ascend Y H866C' ),								
			'A7 HD'										=> array( 'Hyundai', 'A7 HD', TYPE_TABLET ),
			'HYUNDAI H6'								=> array( 'Hyundai', 'Storm H6' ),
			'HYUNDAI H8Q'								=> array( 'Hyundai', 'H8Q' ),
			'HYUNDAI H11'								=> array( 'Hyundai', 'H11' ),
			'HYUNDAI T7'								=> array( 'Hyundai', 'T7', TYPE_TABLET ),
			'HYUNDAI T7S'								=> array( 'Hyundai', 'T7s', TYPE_TABLET ),
			'HYUNDAI T10'								=> array( 'Hyundai', 'T10', TYPE_TABLET ),
			'MW1031'									=> array( 'Hyundai', 'MW1031', TYPE_TABLET ),
			'Andi3n'									=> array( 'iBall', 'Andi 3n' ),
			'iBall Andi3e'								=> array( 'iBall', 'Andi 3e' ),
			'Andi 3.5i'									=> array( 'iBall', 'Andi 3.5i' ),
			'iBall Andi4.5q'							=> array( 'iBall', 'Andi 4.5q' ),
			'iBall i6012'								=> array( 'iBall', 'Slide i6012', TYPE_TABLET ),
			'iBall Slide 6309i'							=> array( 'iBall', 'Slide i6309', TYPE_TABLET ),
			'iBall Slide i7011'							=> array( 'iBall', 'Slide i7011', TYPE_TABLET ),
			'iBall Slide 3G7271'						=> array( 'iBall', 'Slide 3G 7271', TYPE_TABLET ),
			'iBall Slide 3G 7334'						=> array( 'iBall', 'Slide 3G 7334', TYPE_TABLET ),
			'AUXUS CoreX2 3G'							=> array( 'iBerry', 'Auxus CoreX2', TYPE_TABLET ),
			'NetTAB RUNE'								=> array( 'IconBit', 'NetTab Rune', TYPE_TABLET ),
			'NetTAB SPACE II Plus'						=> array( 'IconBit', 'NetTab Space II Plus', TYPE_TABLET ),
			'NetTAB THOR-LE'							=> array( 'IconBit', 'NetTab Thor LE', TYPE_TABLET ),
			'D70W'										=> array( 'Icoo', 'D70W', TYPE_TABLET ),
			'D80'										=> array( 'Icoo', 'D80', TYPE_TABLET ),
			'CT920'										=> array( 'IdeaUSA', 'CT920', TYPE_TABLET ),
			'INFOBAR A01'								=> array( 'iida', 'INFOBAR A01' ),
			'INFOBAR A01-2'								=> array( 'iida', 'INFOBAR A01' ),
			'IMO S79'									=> array( 'IMO', 'Explorer S79' ),
			'IMO S88'									=> array( 'IMO', 'Discovery S88' ),
			'IMO S89'									=> array( 'IMO', 'Miracle S89' ),
			'IMO S99'									=> array( 'IMO', 'Ocean S99' ),
			'IMO S900'									=> array( 'IMO', 'Groovy S900' ),
			'IMO X2'									=> array( 'IMO', 'Normandy X2' ),
			'IMO X2 NORMANDY'							=> array( 'IMO', 'Normandy X2' ),
			'IMO Z7'									=> array( 'IMO', 'Orion Z7', TYPE_TABLET ),
			'M009F'										=> array( 'Infotmic', 'M009F' ),
			'INHON PAPILIO G1'							=> array( 'Inhon', 'Papilio G1' ),
			'innos i6'									=> array( 'Innos', 'i6' ),
			'AZ210A'									=> array( 'Intel', 'AZ210A' ),
			'AZ210B'									=> array( 'Intel', 'AZ210B' ),
			'AZ510'										=> array( 'Intel', 'AZ510' ),
			'BT210'										=> array( 'Intel', 'BT210' ),
			'BT230'										=> array( 'Intel', 'BT230' ),
			'BT510'										=> array( 'Intel', 'BT510' ),
			'greenridge'								=> array( 'Intel', 'Green Ridge', TYPE_TABLET ),
			'INQ Cloud Touch'							=> array( 'INQ', 'Cloud Touch' ),
			'NS-13T001'									=> array( 'Insignia', 'Flex Tablet', TYPE_TABLET ),
			'IPRO i5S'									=> array( 'IPRO', 'i5S' ),
			'ILT-MX100'									=> array( 'iRiver', 'Tab', TYPE_TABLET ),
			'IVIO DE38'									=> array( 'Ivio', 'DE38' ),
			'iwoo i900'									=> array( 'iwoo', 'i900' ),
			'JY-G1'										=> array( 'Jiayu', 'G1' ),
			'JY-G2'										=> array( 'Jiayu', 'G2' ),
			'JY-G2L'									=> array( 'Jiayu', 'G2' ),
			'Jiayu G2'									=> array( 'Jiayu', 'G2' ),
			'Jiayu G2H'									=> array( 'Jiayu', 'G2' ),
			'Jiayu G2L'									=> array( 'Jiayu', 'G2' ),
			'Jiayu G2s'									=> array( 'Jiayu', 'G2 Plus' ),
			'JY-G3'										=> array( 'Jiayu', 'G3' ),
			'Jiayu G3'									=> array( 'Jiayu', 'G3' ),
			'JY-G4'										=> array( 'Jiayu', 'G4' ),
			'JT-Smart PC01'								=> array( 'Joy-IT', 'JT-Smart PC-01' ),
			'JXD S601WIFI'								=> array( 'JXD', 'S601 WIFI', 'media' ),
			'JXD V5200'									=> array( 'JXD', 'V5200', 'media' ),
			'A2'										=> array( 'KakaTech', 'A2' ),
			'Karbonn A1'								=> array( 'Karbonn', 'A1' ),
			'Karbonn A2'								=> array( 'Karbonn', 'A2' ),
			'Karbonn A4'								=> array( 'Karbonn', 'A4' ),
			'Karbonn A5'								=> array( 'Karbonn', 'A5' ),
			'Karbonn A6'								=> array( 'Karbonn', 'A6' ),
			'Karbonn A9+'								=> array( 'Karbonn', 'A9+' ),
			'A11'										=> array( 'Karbonn', 'A11' ),
			'Karbonn A12'								=> array( 'Karbonn', 'A12' ),
			'Karbonn A18'								=> array( 'Karbonn', 'A18' ),
			'Karbonn A21!'								=> array( 'Karbonn', 'A21' ),
			'A21'										=> array( 'Karbonn', 'A21' ),
			'Karbonn A30'								=> array( 'Karbonn', 'A30' ),
			'A111'										=> array( 'Karbonn', 'A111' ),
			'Titanium S5'								=> array( 'Karbonn', 'S5 Titanium' ),
			'SmartTab1'									=> array( 'Karbonn', 'Smart Tab 1', TYPE_TABLET ),
			'ST10'										=> array( 'Karbonn', 'Smart Tab 10 Cosmic', TYPE_TABLET ),
			'D91'										=> array( 'KK', 'D91', TYPE_TABLET ),
			'K080'										=> array( 'Kobo', 'K080', TYPE_EREADER ),
			'W990'										=> array( 'Konka', 'W990' ),
			'A106'										=> array( 'koobee', 'A160' ),
			'Koobe S7 Easy tablet'						=> array( 'Koobe', 'S7 Easy tablet', TYPE_TABLET ),
			'KPT A9'									=> array( 'KPT', 'A9' ),
			'EV-S100'									=> array( 'Kttech', 'Take EV-S100' ),
			'KM-E100'									=> array( 'Kttech', 'Take LTE KM-E100' ),
			'KM-S120'									=> array( 'Kttech', 'Take 2 KM-S120' ),
			'KM-S200'									=> array( 'Kttech', 'Take Janus KM-S200' ),
			'KM-S220'									=> array( 'Kttech', 'Take Tachy KM-S220' ),
			'KM-S300'									=> array( 'Kttech', 'Take HD KM-S300' ),
			'KM-S330'									=> array( 'Kttech', 'Take Fit KM-S330' ),
			'Kyobo mirasol eReader'						=> array( 'Kyobo', 'eReader', TYPE_EREADER ),
			'ISW11K'									=> array( 'Kyocera', 'Digno' ),
			'KYL21'										=> array( 'Kyocera', 'Digno S' ),
			'WX04K'										=> array( 'Kyocera', 'Digno Duo' ),
			'JC-KSP8000'								=> array( 'Kyocera', 'Echo' ),
			'KSP8000'									=> array( 'Kyocera', 'Echo' ),
			'Rise'										=> array( 'Kyocera', 'Rise' ),
			'Zio'										=> array( 'Kyocera', 'Zio' ),
			'C5120'										=> array( 'Kyocera', 'Milano' ),
			'C5155'										=> array( 'Kyocera', 'Rise' ),
			'C5170'										=> array( 'Kyocera', 'Hydro' ),
			'C6750'										=> array( 'Kyocera', 'Kinetic' ),
			'M9300'										=> array( 'Kyocera', 'Echo' ),
			'KYY21'										=> array( 'Kyocera', 'Urbano L01' ),
			'URBANO PROGRESSO'							=> array( 'Kyocera', 'Urbano Progresso' ),
			'TY-K-Touch E616'							=> array( 'K-Touch', 'E616' ),
			'K-Touch E619'								=> array( 'K-Touch', 'E619' ),
			'K-Touch E688'								=> array( 'K-Touch', 'E688' ),
			'E800'										=> array( 'K-Touch', 'E800' ),
			'K-Touch E806'								=> array( 'K-Touch', 'E806' ),
			'K-Touch S5'								=> array( 'K-Touch', 'S5' ),
			'K-TouchT580'								=> array( 'K-Touch', 'T580' ),
			'K-Touch T619'								=> array( 'K-Touch', 'T619' ),
			'K-Touch T619+'								=> array( 'K-Touch', 'T619+' ),
			'K-Touch T760'								=> array( 'K-Touch', 'T760' ),
			'K-Touch T780'								=> array( 'K-Touch', 'T780' ),
			'K-Touch T800'								=> array( 'K-Touch', 'T800' ),
			'K-Touch U6'								=> array( 'K-Touch', 'U6' ),
			'K-Touch U7'								=> array( 'K-Touch', 'U7' ),
			'K-Touch U8'								=> array( 'K-Touch', 'U8' ),
			'K-Touch U10'								=> array( 'K-Touch', 'U10' ),
			'K-Touch U86'								=> array( 'K-Touch', 'U86' ),
			'K-Touch V8'								=> array( 'K-Touch', 'V8' ),
			'K-Touch V9'								=> array( 'K-Touch', 'V9' ),
			'W606'										=> array( 'K-Touch', 'W606' ),
			'K-Touch W619!'								=> array( 'K-Touch', 'W619' ),
			'K-Touch W621'								=> array( 'K-Touch', 'W621' ),
			'K-Touch W650'								=> array( 'K-Touch', 'W650' ),
			'K-Touch W658'								=> array( 'K-Touch', 'W658' ),
			'W686'										=> array( 'K-Touch', 'W686' ),
			'K-Touch W688'								=> array( 'K-Touch', 'W688' ),
			'K-Touch W700'								=> array( 'K-Touch', 'W700' ),
			'W700'										=> array( 'K-Touch', 'W700' ),
			'K-Touch W719'								=> array( 'K-Touch', 'W719' ),
			'W732'										=> array( 'K-Touch', 'W732' ),
			'K-Touch W760'								=> array( 'K-Touch', 'W760' ),
			'K-Touch W780'								=> array( 'K-Touch', 'W780' ),
			'W800'										=> array( 'K-Touch', 'W800' ),
			'K-Touch W806!'								=> array( 'K-Touch', 'W806' ),
			'W806'										=> array( 'K-Touch', 'W806' ),
			'W808'										=> array( 'K-Touch', 'W808' ),
			'W810'										=> array( 'K-Touch', 'W810' ),
			'W880'										=> array( 'K-Touch', 'W880' ),
			'LAVA S12'									=> array( 'Lava', 'S12' ),
			'XOLO A700'									=> array( 'Lava', 'XOLO A700' ),
			'XOLO A800'									=> array( 'Lava', 'XOLO A800' ),
			'XOLO A1000'								=> array( 'Lava', 'XOLO A1000' ),
			'XOLO B700'									=> array( 'Lava', 'XOLO B700' ),
			'XOLO Q800'									=> array( 'Lava', 'XOLO Q800' ),
			'Xolo X500'									=> array( 'Lava', 'XOLO X500' ),
			'X900'										=> array( 'Lava', 'XOLO X900' ),
			'Xolo X900'									=> array( 'Lava', 'XOLO X900' ),
			'XOLO X1000'								=> array( 'Lava', 'XOLO X1000' ),
			'leepoo i500'								=> array( 'Leepoo', 'i500' ),
			'leepoo i600'								=> array( 'Leepoo', 'i600' ),
			'LENCM900HZ'								=> array( 'Lenco', 'TAB 811', TYPE_TABLET ),
			'Lenco TAB-1014'							=> array( 'Lenco', 'TAB 1014', TYPE_TABLET ),
			'ThinkPad( Tablet)?!'						=> array( 'Lenovo', 'ThinkPad Tablet', TYPE_TABLET ),
			'Lenovo A1-32AB0'							=> array( 'Lenovo', 'IdeaPad A1', TYPE_TABLET ),
			'(Ideapad )?K1!'							=> array( 'Lenovo', 'IdeaPad K1', TYPE_TABLET ),
			'Ideapad S10-3T'							=> array( 'Lenovo', 'IdeaPad S10-3T', TYPE_TABLET ),
			'IdeaTab ?A1000(-F|-T)!'					=> array( 'Lenovo', 'IdeaTab A1000', TYPE_TABLET ),
			'IdeaTab ?A1107!'							=> array( 'Lenovo', 'IdeaTab A1107', TYPE_TABLET ),
			'Lenovo A2105'								=> array( 'Lenovo', 'IdeaTab A2105', TYPE_TABLET ),
			'IdeaTab ?A2107(A-F|A-H)!'					=> array( 'Lenovo', 'IdeaTab A2107', TYPE_TABLET ),
			'A2107A-H'									=> array( 'Lenovo', 'IdeaTab A2107', TYPE_TABLET ),
			'IdeaTab ?A2109(A)!'						=> array( 'Lenovo', 'IdeaTab A2109', TYPE_TABLET ),
			'IdeaTab ?A2207(A-H)!'						=> array( 'Lenovo', 'IdeaTab A2207', TYPE_TABLET ),
			'IdeaTab ?A3000-H!'							=> array( 'Lenovo', 'IdeaTab A3000', TYPE_TABLET ),
			'Lenovo A3000-H!'							=> array( 'Lenovo', 'IdeaTab A3000', TYPE_TABLET ),
			'IdeaTab ?A5000-E!'							=> array( 'Lenovo', 'IdeaTab A5000', TYPE_TABLET ),
			'IdeaTab ?K2110(A-F)!'						=> array( 'Lenovo', 'IdeaTab K2110', TYPE_TABLET ),
			'S2005A-H'									=> array( 'Lenovo', 'IdeaTab S2005', TYPE_TABLET ),
			'IdeaTab ?S2007(A-D)!'						=> array( 'Lenovo', 'IdeaTab S2007', TYPE_TABLET ),
			'IdeaTab ?S2010(A-D)!'						=> array( 'Lenovo', 'IdeaTab S2010', TYPE_TABLET ),
			'IdeaTab ?S2109(A-F)!'						=> array( 'Lenovo', 'IdeaTab S2109', TYPE_TABLET ),
			'IdeaTab ?S2110(AF|AH)!'					=> array( 'Lenovo', 'IdeaTab S2110', TYPE_TABLET ),
			'IdeaTab ?S6000-(F|H)!'						=> array( 'Lenovo', 'IdeaTab S6000', TYPE_TABLET ),
			'IdeaTab ?V2007(A|A-D-I)!'					=> array( 'Lenovo', 'IdeaTab V2007', TYPE_TABLET ),
			'IdeaTab ?V2010(A)!'						=> array( 'Lenovo', 'IdeaTab V2010', TYPE_TABLET ),
			'A1 07'										=> array( 'Lenovo', 'LePad', TYPE_TABLET ),
			'lepad 001b'								=> array( 'Lenovo', 'LePad', TYPE_TABLET ),
			'lepad 001n'								=> array( 'Lenovo', 'LePad', TYPE_TABLET ),
			'(Lenovo )?3GC101!'							=> array( 'Lenovo', 'LePhone 3GC101' ),
			'(Lenovo |Lephone )?3GW100!'				=> array( 'Lenovo', 'LePhone 3GW100' ),
			'(Lenovo |Lephone )?3GW101!'				=> array( 'Lenovo', 'LePhone 3GW101' ),
			'(Lenovo )?S1[- ]37AH0!'					=> array( 'Lenovo', 'LePhone S1' ),
			'(Lenovo )?S2[- ]38A(H0|T0)!'				=> array( 'Lenovo', 'LePhone S2' ),
			'lephone 1800'								=> array( 'Lenovo', 'LePhone 1800' ),
			'A30t'										=> array( 'Lenovo', 'A30' ),
			'Lenovo A60+?!'								=> array( 'Lenovo', 'A60' ),
			'Lenovo A65'								=> array( 'Lenovo', 'A65' ),
			'Lenovo A66t'								=> array( 'Lenovo', 'A66' ),
			'Lenovo A68e'								=> array( 'Lenovo', 'A68' ),
			'Lenovo A208t'								=> array( 'Lenovo', 'A208' ),
			'Lenovo A218t'								=> array( 'Lenovo', 'A218' ),
			'Lenovo A278t'								=> array( 'Lenovo', 'A278' ),
			'Lenovo ?A288t!'							=> array( 'Lenovo', 'A288' ),
			'Lenovo A298t'								=> array( 'Lenovo', 'A298' ),
			'Lenovo A300'								=> array( 'Lenovo', 'A300' ),
			'Lenovo A305e'								=> array( 'Lenovo', 'A305' ),
			'Lenovo A326'								=> array( 'Lenovo', 'A326' ),
			'Lenovo A356'								=> array( 'Lenovo', 'A356' ),
			'Lenovo A360'								=> array( 'Lenovo', 'A360' ),
			'Lenovo A365e'								=> array( 'Lenovo', 'A365' ),
			'Lenovo A366t'								=> array( 'Lenovo', 'A366' ),
			'Lenovo A370e'								=> array( 'Lenovo', 'A370' ),
			'Lenovo A375e'								=> array( 'Lenovo', 'A375' ),
			'Lenovo A378t'								=> array( 'Lenovo', 'A378' ),
			'Lenovo A390!'								=> array( 'Lenovo', 'A390' ),
			'Lenovo A398t'								=> array( 'Lenovo', 'A398' ),
			'Lenovo A500'								=> array( 'Lenovo', 'A500' ),
			'Lenovo A520!'								=> array( 'Lenovo', 'A520' ),
			'Lenovo A530'								=> array( 'Lenovo', 'A530' ),
			'Lenovo A560e'								=> array( 'Lenovo', 'A560' ),
			'Lenovo A580'								=> array( 'Lenovo', 'A580' ),
			'Lenovo A586'								=> array( 'Lenovo', 'A586' ),
			'Lenovo A590'								=> array( 'Lenovo', 'A590' ),
			'Lenovo A630!'								=> array( 'Lenovo', 'A630' ),
			'Lenovo A656'								=> array( 'Lenovo', 'A656' ),
			'Lenovo A660'								=> array( 'Lenovo', 'A660' ),
			'Lenovo A690'								=> array( 'Lenovo', 'A690' ),
			'Lenovo A668t'								=> array( 'Lenovo', 'A668' ),
			'Lenovo A698t'								=> array( 'Lenovo', 'A698' ),
			'Lenovo A700e'								=> array( 'Lenovo', 'A700' ),
			'Lenovo A710e'								=> array( 'Lenovo', 'A710' ),
			'Lenovo A750!'								=> array( 'Lenovo', 'A750' ),
			'A750'										=> array( 'Lenovo', 'A750' ),	
			'Lenovo A765!'								=> array( 'Lenovo', 'A765' ),	
			'Lenovo A766'								=> array( 'Lenovo', 'A766' ),	
			'Lenovo A780'								=> array( 'Lenovo', 'A780' ),
			'Lenovo A789!'								=> array( 'Lenovo', 'A789' ),
			'Lenovo A790e'								=> array( 'Lenovo', 'A790' ),
			'Lenovo A798t'								=> array( 'Lenovo', 'A798' ),
			'Lenovo A800'								=> array( 'Lenovo', 'A800' ),
			'Lenovo A820!'								=> array( 'Lenovo', 'A820' ),
			'Lenovo K800'								=> array( 'Lenovo', 'K800' ),
			'Lenovo K860!'								=> array( 'Lenovo', 'K860' ),
			'Lenovo K900!'								=> array( 'Lenovo', 'K900' ),
			'Lenovo P70'								=> array( 'Lenovo', 'P70' ),
			'Lenovo P700!'								=> array( 'Lenovo', 'P700' ),
			'P700i'										=> array( 'Lenovo', 'P700i' ),
			'Lenovo P770'								=> array( 'Lenovo', 'P770' ),
			'Lenovo-P770'								=> array( 'Lenovo', 'P770' ),
			'Lenovo P780'								=> array( 'Lenovo', 'P780' ),
			'Lenovo S560'								=> array( 'Lenovo', 'S560' ),
			'Lenovo S680'								=> array( 'Lenovo', 'S680' ),
			'Lenovo S686'								=> array( 'Lenovo', 'S686' ),
			'Lenovo S720'								=> array( 'Lenovo', 'S720' ),
			'S720i'										=> array( 'Lenovo', 'S720' ),
			'Lenovo S760'								=> array( 'Lenovo', 'S760' ),
			'Lenovo S850e'								=> array( 'Lenovo', 'S850' ),
			'Lenovo S870e'								=> array( 'Lenovo', 'S870' ),
			'Lenovo S880!'								=> array( 'Lenovo', 'S880' ),
			'Lenovo S890'								=> array( 'Lenovo', 'S890' ),
			'Lenovo S898!'								=> array( 'Lenovo', 'S898' ),
			'Lenovo ?S899!'								=> array( 'Lenovo', 'S899' ),
			'Lenovo S920'								=> array( 'Lenovo', 'S920' ),
			'ideatv A21'								=> array( 'Lenovo', 'IDEA TV', TYPE_TELEVISION ),
			'ideatv K82'								=> array( 'Lenovo', 'IDEA TV', TYPE_TELEVISION ),
			'IDEA TV T100'								=> array( 'Lenovo', 'IDEA TV', TYPE_TELEVISION ),
			'IDEA TV K91'								=> array( 'Lenovo', 'IDEA TV', TYPE_TELEVISION ),
			'TC970'										=> array( 'Le Pan', 'TC970', TYPE_TABLET ),
			'LePanII'									=> array( 'Le Pan', 'II', TYPE_TABLET ),
			'Le Pan S'									=> array( 'Le Pan', 'S', TYPE_TABLET ),
			'LG-C5(50|55)!'								=> array( 'LG', 'Optimus Chat' ),
			'LG-C660!'									=> array( 'LG', 'Optimus Pro' ),
			'LG-C710!'									=> array( 'LG', 'Aloha' ),
			'LG-C729'									=> array( 'LG', 'DoublePlay' ),
			'LG-C800G'									=> array( 'LG', 'Eclypse' ),
			'LG-CX670'									=> array( 'LG', 'Optimus 3G' ),
			'LG-D500'									=> array( 'LG', 'D500' ),
			'LG-D505'									=> array( 'LG', 'D505' ),
			'LG-D605'									=> array( 'LG', 'D605' ),
			'LG-D700'									=> array( 'LG', 'D700' ),
			'LG-D800'									=> array( 'LG', 'D800' ),
			'LG-D801'									=> array( 'LG', 'D801' ),
			'LG-DS1203'									=> array( 'LG', 'Optimus G2' ),
			'LG-E4(00|10|15)!'							=> array( 'LG', 'Optimus L3' ),
			'LG-E405!'									=> array( 'LG', 'Optimus L3 Dual' ),
			'LG-E420!'									=> array( 'LG', 'E420' ),
			'LG-E4(25|30)!'								=> array( 'LG', 'Optimus L3 II' ),
			'LG-E435!'									=> array( 'LG', 'Optimus L3 II Dual' ),
			'LG-E440!'									=> array( 'LG', 'Optimus L4 II' ),
			'LG-E445!'									=> array( 'LG', 'Optimus L4 II Dual' ),
			'LG-E4(50|60)!'								=> array( 'LG', 'Optimus L5 II' ),
			'LG-E455!'									=> array( 'LG', 'Optimus L5 II Dual' ),
			'LG-E470!'									=> array( 'LG', 'E470' ),
			'LG-E510!'									=> array( 'LG', 'Optimus Hub' ),
			'LG-E6(10|12|17)!'							=> array( 'LG', 'Optimus L5' ),
			'LG-E615!'									=> array( 'LG', 'Optimus L5 Dual' ),
			'LG-E720!'									=> array( 'LG', 'Optimus Chic' ),
			'LG-E730!'									=> array( 'LG', 'Optimus Sol' ),
			'LG-E940'									=> array( 'LG', 'Optimus G Pro' ),
			'LG-E960'									=> array( 'LG', 'Nexus 4' ),
			'LG-E9(70|71|73|75|76|77|78)!'				=> array( 'LG', 'Optimus G' ),
			'LG-E9(80|85|88|89)!'						=> array( 'LG', 'Optimus G Pro' ),
			'LG-F100!'									=> array( 'LG', 'Optimus Vu' ),
			'LG-F120!'									=> array( 'LG', 'Optimus LTE Tag' ),
			'LG-F160!'									=> array( 'LG', 'Optimus LTE II' ),
			'LG-F180!'									=> array( 'LG', 'Optimus G' ),
			'LG-F200!'									=> array( 'LG', 'Optimus Vu 2' ),
			'LG-F220!'									=> array( 'LG', 'Optimus GK' ),
			'LG-F240!'									=> array( 'LG', 'Optimus G Pro' ),
			'LG-F260!'									=> array( 'LG', 'Optimus LTE III' ),
			'LG-F300!'									=> array( 'LG', 'F300' ),
			'LG-F320!'									=> array( 'LG', 'Optimus G2' ),
			'LG-F340!'									=> array( 'LG', 'F340' ),
			'LG-GT540!'									=> array( 'LG', 'Optimus' ),
			'LG-GW620'									=> array( 'LG', 'GW620 Eve' ),
			'LG-KH5200'									=> array( 'LG', 'Andro-1' ),
			'LG-KU3700'									=> array( 'LG', 'Optimus One' ),
			'LG-KU5400'									=> array( 'LG', 'PRADA 3.0' ),
			'LG-KU5900'									=> array( 'LG', 'Optimus Black' ),
			'LG-L25L'									=> array( 'LG', 'L25L' ),
			'LG-L38C'									=> array( 'LG', 'Optimus Dynamic' ),
			'LG-L40G'									=> array( 'LG', 'L40G' ),
			'LG-L160L'									=> array( 'LG', 'L160L' ),
			'LG-LG730'									=> array( 'LG', 'Venice' ),
			'LG-LG855'									=> array( 'LG', 'Marquee' ),
			'LG-LG870'									=> array( 'LG', 'LG870' ),
			'LG-LS670'									=> array( 'LG', 'Optimus S' ),
			'LG-LS696'									=> array( 'LG', 'Elite' ),
			'LG-LS720'									=> array( 'LG', 'Optimus F3' ),
			'LG-LS840'									=> array( 'LG', 'Viper' ),
			'LG-LS855'									=> array( 'LG', 'Marquee' ),
			'LG-LS860'									=> array( 'LG', 'Mach' ),
			'LG-LS970'									=> array( 'LG', 'Optimus G' ),
			'LG-LS980'									=> array( 'LG', 'LS980' ),
			'LG-LU3000'									=> array( 'LG', 'Optimus Mach' ),
			'LG-LU3100'									=> array( 'LG', 'Optimus Chic' ),
			'LG-LU3700'									=> array( 'LG', 'Optimus One' ),
			'LG-LU5400'									=> array( 'LG', 'PRADA 3.0' ),
			'LG-LU6200'									=> array( 'LG', 'Optimus Q2' ),
			'LG-LU6500'									=> array( 'LG', 'Optimus Note' ),
			'LG-LU6800'									=> array( 'LG', 'Optimus Big' ),
			'LG-LU8300'									=> array( 'LG', 'Optimus Pad LTE' ),
			'LG-LW690'									=> array( 'LG', 'Optimus C' ),
			'LG-LW770'									=> array( 'LG', 'Regard' ),
			'LG-MS690'									=> array( 'LG', 'Optimus M' ),
			'LGMS769'									=> array( 'LG', 'Optimus L9' ),
			'LG-MS770'									=> array( 'LG', 'Motion 4G' ),
			'LG-MS790'									=> array( 'LG', 'MS790' ),
			'LG-MS840'									=> array( 'LG', 'Connect 4G' ),
			'LG-MS870'									=> array( 'LG', 'Spirit 4G' ),
			'LG-MS910'									=> array( 'LG', 'Esteem' ),
			'LG-MS695'									=> array( 'LG', 'Optimus M+' ),
			'LG-P350!'									=> array( 'LG', 'Optimus Me' ),
			'LG-P355'									=> array( 'LG', 'P355' ),
			'LG-P5(00|03|04)!'							=> array( 'LG', 'Optimus One' ),
			'LG-P505!'									=> array( 'LG', 'Phoenix' ),
			'LG-P506'									=> array( 'LG', 'Thrive' ),
			'LG-P509'									=> array( 'LG', 'Optimus T' ),
			'LG-P655!'									=> array( 'LG', 'P655' ),
			'LG-P659'									=> array( 'LG', 'P659' ),
			'LG-P6(90|98)!'								=> array( 'LG', 'Optimus Net' ),
			'LG-P692!'									=> array( 'LG', 'Optimus Net' ),
			'LG-P693!'									=> array( 'LG', 'P693' ),
			'LG-P698!'									=> array( 'LG', 'Optimus Net Dual' ),
			'LG-P7(00|05|08)!'							=> array( 'LG', 'Optimus L7' ),
			'LG-P7(10|14)!'								=> array( 'LG', 'Optimus L7 II' ),
			'LG-P7(15|16)!'								=> array( 'LG', 'Optimus L7 II Dual' ),
			'LG-P720!'									=> array( 'LG', 'Optimus Chic' ),
			'LG-P725'									=> array( 'LG', 'Optimus 3D Max' ),
			'LG-P7(60|65|68|69|78)!'					=> array( 'LG', 'Optimus L9' ),
			'LG-P860'									=> array( 'LG', 'P860' ),
			'LG-P870!'									=> array( 'LG', 'Escape' ),	
			'LG-P875!'									=> array( 'LG', 'Optimus F5' ),
			'LG-P880!'									=> array( 'LG', 'Optimus 4X HD' ),
			'LG-P895'									=> array( 'LG', 'Optimus Vu' ),	
			'LG-P920!'									=> array( 'LG', 'Optimus 3D' ),
			'LG-P925!'									=> array( 'LG', 'Thrill' ),
			'LG-P930!'									=> array( 'LG', 'Nitro HD' ),
			'LG-P9(35|36)!'								=> array( 'LG', 'Optimus LTE' ),
			'LG-P940!'									=> array( 'LG', 'PRADA 3.0' ),
			'LG-P970!'									=> array( 'LG', 'Optimus Black' ),
			'LG-P990!'									=> array( 'LG', 'Optimus 2X Speed' ),
			'LG-P993'									=> array( 'LG', 'Optimus 2X' ),
			'LG-SU370'									=> array( 'LG', 'Optimus One' ),
			'LG-SU540'									=> array( 'LG', 'PRADA 3.0' ),
			'LG-SU640'									=> array( 'LG', 'Optimus LTE' ),
			'LG-SU660'									=> array( 'LG', 'Optimus 2X' ),
			'LG-SU760'									=> array( 'LG', 'Optimus 3D' ),
			'LG-SU870'									=> array( 'LG', 'Optimus 3D Cube' ),
			'LG-SU880'									=> array( 'LG', 'Optimus EX' ),
			'LG-US670'									=> array( 'LG', 'Optimus U' ),
			'LG-US730'									=> array( 'LG', 'Splendor' ),
			'LG-V500'									=> array( 'LG', 'V500' ),
			'LG-V900'									=> array( 'LG', 'Optimus Pad', TYPE_TABLET ),
			'LG-V9(05|09)!'								=> array( 'LG', 'Optimus G-Slate', TYPE_TABLET ),
			'LG-VM670'									=> array( 'LG', 'Optimus V' ),
			'LG-VM696'									=> array( 'LG', 'Optimus Elite' ),
			'LG-VM701'									=> array( 'LG', 'Optimus Slider' ),
			'LG-VS410!'									=> array( 'LG', 'Optimus Zone' ),
			'LG-VS660'									=> array( 'LG', 'Vortex' ),
			'LG-VS700'									=> array( 'LG', 'Enlighten' ),
			'LG-VS740'									=> array( 'LG', 'Ally' ),
			'LG-VS840'									=> array( 'LG', 'Lucid' ),
			'LG-VS870'									=> array( 'LG', 'Escape' ),
			'LG-VS890'									=> array( 'LG', 'Optimus FX3' ),
			'LG-VS910'									=> array( 'LG', 'Revolution' ),
			'LG-VS930'									=> array( 'LG', 'Spectrum II' ),
			'LG-VS950'									=> array( 'LG', 'Intuition' ),
			'LG-VS980'									=> array( 'LG', 'Optimus G Pro' ),
			'lgp-970'									=> array( 'LG', 'Optimus Black' ),
			'AS740'										=> array( 'LG', 'Axis' ),
			'E900'										=> array( 'LG', 'Optimus 7' ),
			'GT540'										=> array( 'LG', 'Optimus GT540' ),
			'GW620'										=> array( 'LG', 'Eve' ),
			'KU9500'									=> array( 'LG', 'Optimus Z' ),
			'LGC660!'									=> array( 'LG', 'Optimus Pro' ),
			'LGL21'										=> array( 'LG', 'Optimus G' ),
			'LGL35G'									=> array( 'LG', 'L35G' ),
			'LGL39C'									=> array( 'LG', 'L39C' ),
			'LGL45C'									=> array( 'LG', 'Optimus Net' ),
			'LGL55C'									=> array( 'LG', 'Optimus Q' ),
			'LGL86C'									=> array( 'LG', 'Optimus Showtime' ),
			'LU2300'									=> array( 'LG', 'Optimus Q' ),	
			'LS670'										=> array( 'LG', 'Optimus S' ),
			'P940'										=> array( 'LG', 'PRADA 3.0' ),
			'P990'										=> array( 'LG', 'Optimus 2X Speed' ),
			'USCC-US730'								=> array( 'LG', 'Splendor' ),
			'USCC-US760'								=> array( 'LG', 'Genesis' ),
			'VM670'										=> array( 'LG', 'Optimus V' ),
			'VS840 4G'									=> array( 'LG', 'Lucid' ),
			'VS870 4G'									=> array( 'LG', 'Escape' ),
			'VS900-4G'									=> array( 'LG', 'Enlighten' ),
			'VS910 4G'									=> array( 'LG', 'Revolution 4G' ),
			'VS920 4G'									=> array( 'LG', 'Spectrum' ),
			'VS930 4G'									=> array( 'LG', 'Spectrum 2' ),
			'VS950 4G'									=> array( 'LG', 'Intuition' ),
			'VS980 4G'									=> array( 'LG', 'Optimus G Pro' ),
			'L-01D'										=> array( 'LG', 'Optimus LTE' ),
			'L-01E'										=> array( 'LG', 'Optimus G' ),
			'L-02D'										=> array( 'LG', 'PRADA phone' ),
			'L-02E'										=> array( 'LG', 'Optimus LIFE' ),
			'L-04C'										=> array( 'LG', 'Optimus Chat' ),
			'L-04E'										=> array( 'LG', 'Optimus G Pro' ),
			'L-05D'										=> array( 'LG', 'Optimus it' ),
			'L-05E'										=> array( 'LG', 'L-05E' ),
			'L-06C'										=> array( 'LG', 'Optimus Pad', TYPE_TABLET ),
			'L-06D'										=> array( 'LG', 'Optimus Vu' ),
			'L-07C'										=> array( 'LG', 'Optimus Bright' ),
			'LG-Eve'									=> array( 'LG', 'Eve' ),
			'LG-Optimus One P500'						=> array( 'LG', 'Optimus One' ),
			'LG-Optimus 2X'								=> array( 'LG', 'Optimus 2X' ),
			'LG-GT540 Optimus'							=> array( 'LG', 'Optimus' ),
			'LG-Optimus Black'							=> array( 'LG', 'Optimus Black' ),
			'LG-OptimusG'								=> array( 'LG', 'Optimus G' ),
			'LG-Optimus G'								=> array( 'LG', 'Optimus G' ),
			'LG-Optimus G Pro'							=> array( 'LG', 'Optimus G Pro' ),
			'LG-Optimus LTE2'							=> array( 'LG', 'Optimus LTE2' ),
			'LG-Optimus V'								=> array( 'LG', 'Optimus V' ),
			'LG-optimus L7'								=> array( 'LG', 'Optimus L7' ),
			'LG-Swift L9'								=> array( 'LG', 'Optimus L9' ),
			'LG-OPTIMUS HD LTE'							=> array( 'LG', 'Optimus HD' ),
			'LG-OPTIMUS LTE HD'							=> array( 'LG', 'Optimus HD' ),
			'Ally'										=> array( 'LG', 'Ally' ),
			'Optimus'									=> array( 'LG', 'Optimus' ),
			'OptimusBlack'								=> array( 'LG', 'Optimus Black' ),
			'Optimus G'									=> array( 'LG', 'Optimus G' ),
			'Optimus Me'								=> array( 'LG', 'Optimus Me' ),
			'optimus me p350'							=> array( 'LG', 'Optimus Me' ),
			'Optimus 2X'								=> array( 'LG', 'Optimus 2X' ),
			'Optimus 2x'								=> array( 'LG', 'Optimus 2X' ),
			'IS11LG'									=> array( 'LG', 'Optimus X' ),
			'Vortex'									=> array( 'LG', 'Vortex' ),
			'LDK-ICK v1.4'								=> array( 'LG', 'Esteem' ),
			'Prada 3.0'									=> array( 'LG', 'PRADA 3.0' ),
			'LG-Google TV!'								=> array( 'LG', 'Google TV', TYPE_TELEVISION, FLAG_GOOGLETV ),
			'T6'										=> array( 'Malata', 'Zpad T6', TYPE_TABLET ),
			'Malata SMBA1002'							=> array( 'Malata', 'Tablet SMB-A1002', TYPE_TABLET ),
			'MID05V2'									=> array( 'Manta', 'Powertab MID05V2', TYPE_TABLET ),
			'MID801'									=> array( 'Manta', 'MID801 Duo Power HD', TYPE_TABLET ),
			'M-270'										=> array( 'Maylong', 'M-270', TYPE_TABLET ),
			'M70'										=> array( 'Maxsun', 'M70', TYPE_TABLET ),
			'MP705C'									=> array( 'Mediacom', 'SmartPad 705c', TYPE_TABLET ),
			'STM712HCZ'									=> array( 'Mediacom', 'SmartPad 712c', TYPE_TABLET ),
			'STM803HC'									=> array( 'Mediacom', 'SmartPad 810c', TYPE_TABLET ),
			'Mediacom 810C'								=> array( 'Mediacom', 'SmartPad 810c', TYPE_TABLET ),
			'Xteam Smartpad 810c'						=> array( 'Mediacom', 'SmartPad 810c', TYPE_TABLET ),
			'Xteam 4.8 Smartpad 810c'					=> array( 'Mediacom', 'SmartPad 810c', TYPE_TABLET ),
			'SmartPad810c'								=> array( 'Mediacom', 'SmartPad 810c', TYPE_TABLET ),
			'MP810C'									=> array( 'Mediacom', 'SmartPad 810c', TYPE_TABLET ),
			'M-MP855i'									=> array( 'Mediacom', 'SmartPad 855i', TYPE_TABLET ),
			'SmartPad870'								=> array( 'Mediacom', 'SmartPad 870 S2', TYPE_TABLET ),
			'M-MP875S2'									=> array( 'Mediacom', 'SmartPad 875 S2', TYPE_TABLET ),
			'MP907C'									=> array( 'Mediacom', 'SmartPad 907c', TYPE_TABLET ),
			'932i'										=> array( 'Mediacom', 'SmartPad 932i', TYPE_TABLET ),
			'SmartPad970s2'								=> array( 'Mediacom', 'SmartPad 970 S2', TYPE_TABLET ),
			'SmartPad1010i'								=> array( 'Mediacom', 'SmartPad 1010i', TYPE_TABLET ),
			'M-MP101S2'									=> array( 'Mediacom', 'SmartPad 10.1 S2', TYPE_TABLET ),
			'MT7003'									=> array( 'Mediadroid', 'Imperius' ),
			'MTK6516'									=> array( 'Mediatek', 'MTK6516' ),
			'LIFETAB S9512'								=> array( 'Medion', 'Lifetab S9512', TYPE_TABLET ),
			'LIFETAB S9714'								=> array( 'Medion', 'Lifetab S9714', TYPE_TABLET ),
			'LIFETAB P9514'								=> array( 'Medion', 'Lifetab P9514', TYPE_TABLET ),
			'MD LIFETAB P9516'							=> array( 'Medion', 'Lifetab P9516', TYPE_TABLET ),
			'MEDION Smartphone LIFE E3501'				=> array( 'Medion', 'Life E3501' ),
			'MEDION LIFE P4012'							=> array( 'Medion', 'Life P4012' ),
			'MEDION LIFE P4310'							=> array( 'Medion', 'Life P4310' ),
			'M8'										=> array( 'Meizu', 'M8' ),
			'M9'										=> array( 'Meizu', 'M9' ),
			'M9-unlocked'								=> array( 'Meizu', 'M9' ),
			'MEIZU M9'									=> array( 'Meizu', 'M9' ),
			'MEIZU MX'									=> array( 'Meizu', 'MX' ),
			'M030'										=> array( 'Meizu', 'MX M030' ),
			'M031'										=> array( 'Meizu', 'MX M031' ),
			'M032'										=> array( 'Meizu', 'MX M032' ),
			'M040'										=> array( 'Meizu', 'M040' ),
			'Slidepad'									=> array( 'Memup', 'Slidepad', TYPE_TABLET ),
			'SP-A20i'									=> array( 'Мегафон', 'SP-A20i Mint' ),
			'Micromax A25'								=> array( 'Micromax', 'A25 Smarty' ),
			'Micromax A30'								=> array( 'Micromax', 'A30 Smarty' ),
			'Micromax A44'								=> array( 'Micromax', 'A44 Punk' ),
			'A45'										=> array( 'Micromax', 'A45 Punk' ),
			'Micromax A50'								=> array( 'Micromax', 'A50 Ninja' ),
			'Micromax A51'								=> array( 'Micromax', 'A51 Bolt' ),
			'Micromax A52'								=> array( 'Micromax', 'A52 Aisha' ),
			'A52'										=> array( 'Micromax', 'A52 Aisha' ),
			'Micromax-Xzoom A52'						=> array( 'Micromax', 'A52 Aisha' ),
			'Micromax A56'								=> array( 'Micromax', 'A56 Ninja 2' ),
			'Micromax A57'								=> array( 'Micromax', 'A57 Ninja 3' ),
			'Micromax A60'								=> array( 'Micromax', 'Andro A60' ),
			'Micromax A62'								=> array( 'Micromax', 'Bolt A62' ),
			'Micromax A65'								=> array( 'Micromax', 'Smarty A65' ),
			'Micromax A68'								=> array( 'Micromax', 'Smarty A68' ),
			'Micromax A70'								=> array( 'Micromax', 'Andro A70' ),
			'Micromax A73'								=> array( 'Micromax', 'A73 Buzz' ),
			'Micromax A75'								=> array( 'Micromax', 'A75 Lite' ),
			'Micromax A78'								=> array( 'Micromax', 'A78 Gossip' ),
			'Micromax A80'								=> array( 'Micromax', 'A80 Infinity' ),
			'Micromax A84'								=> array( 'Micromax', 'A84' ),
			'Micromax A85'								=> array( 'Micromax', 'A85' ),
			'Micromax A87!'								=> array( 'Micromax', 'A87 Ninja 4' ),
			'Micromax A89'								=> array( 'Micromax', 'A89 Ninja' ),
			'Micromax A90!'								=> array( 'Micromax', 'A90 Pixel' ),
			'A90S'										=> array( 'Micromax', 'A90S Pixel' ),
			'Micromax A91'								=> array( 'Micromax', 'A91 Ninja' ),
			'Micromax A100'								=> array( 'Micromax', 'A100 Canvas' ),
			'Micromax A101'								=> array( 'Micromax', 'A101' ),
			'Micromax A110!'							=> array( 'Micromax', 'A110 Canvas 2' ),
			'Micromax Canvas 2'							=> array( 'Micromax', 'A110 Canvas 2' ),
			'Micromax A110 (Canvas 2)'					=> array( 'Micromax', 'A110 Canvas 2' ),
			'Micromax A116'								=> array( 'Micromax', 'A116 Canvas HD' ),
			'Micromax A210'								=> array( 'Micromax', 'A210' ),
			'Micromax P250(Funbook)'					=> array( 'Micromax', 'Funbook Alpha P250', TYPE_TABLET ),
			'Micromax P275'								=> array( 'Micromax', 'Funbook Infinity P275', TYPE_TABLET ),
			'P300(Funbook)'								=> array( 'Micromax', 'Funbook P300', TYPE_TABLET ),
			'Micromax P350'								=> array( 'Micromax', 'Funbook P350', TYPE_TABLET ),
			'Micromax P362'								=> array( 'Micromax', 'Funbook Talk P362', TYPE_TABLET ),
			'Micromax P500(Funbook)'					=> array( 'Micromax', 'Funbook Pro P500', TYPE_TABLET ),
			'Micromax P600'								=> array( 'Micromax', 'Funbook 3G P600', TYPE_TABLET ),
			'MioPad 6'									=> array( 'Mitac', 'MioPad 6', TYPE_TABLET ),
			'MITO A200'									=> array( 'Mito', 'A200' ),
			'MITO A322'									=> array( 'Mito', 'A322' ),
			'Mobiistar Touch S01'						=> array( 'Mobiistar', 'Touch S01' ),
			'Mobiistar Touch S03'						=> array( 'Mobiistar', 'Touch S03' ),
			'Mobiistar Touch S05'						=> array( 'Mobiistar', 'Touch S05' ),
			'Mobiistar Touch Kem 350'					=> array( 'Mobiistar', 'Touch Kem 350' ),
			'Mobiistar Touch Kem 402'					=> array( 'Mobiistar', 'Touch Kem 402' ),
			'Mobiistar Touch Kem 432'					=> array( 'Mobiistar', 'Touch Kem 432' ),
			'Mobiistar touch KEM 462'					=> array( 'Mobiistar', 'Touch Kem 462' ),
			'Mobiistar Touch Lai 502'					=> array( 'Mobiistar', 'Touch Lai 502' ),
			'edenTAB ET-701'							=> array( 'Mobile In Style', 'Eden TAB ET-701', TYPE_TABLET ),	
			'Cynus F3'									=> array( 'Mobistel', 'Cynus F3' ),	
			'Cynus T1'									=> array( 'Mobistel', 'Cynus T1' ),	
			'Cynus T2'									=> array( 'Mobistel', 'Cynus T2' ),			
			'FreeTAB1003'								=> array( 'Modecom', 'FreeTAB 1003', TYPE_TABLET ),
			'FreeTAB 8014 IPS X4'						=> array( 'Modecom', 'FreeTAB 8014 IPS X4', TYPE_TABLET ),
			'FreeTAB 9701'								=> array( 'Modecom', 'FreeTAB 9701', TYPE_TABLET ),
			'FreeTAB 9701 HD X1'						=> array( 'Modecom', 'FreeTAB 9701 HD X1', TYPE_TABLET ),
			'FreeTAB 9701 IPS'							=> array( 'Modecom', 'FreeTAB 9701 IPS', TYPE_TABLET ),
			'FreeTAB 9704 IPS2 X4'						=> array( 'Modecom', 'FreeTAB 9704 IPS2 X4', TYPE_TABLET ),
			'MOGU M2'									=> array( 'Mogu', 'M2' ),				
			'MOGU M2 ROM'								=> array( 'Mogu', 'M2' ),				
			'AT735'										=> array( 'Moinstone', 'AT735', TYPE_TABLET ),
			'A853'										=> array( 'Motorola', 'Milestone' ),
			'A953'										=> array( 'Motorola', 'Milestone 2' ),
			'A1680'										=> array( 'Motorola', 'MOTO A1680' ),
			'ET1'										=> array( 'Motorola', 'ET1 Enterprise Tablet', TYPE_TABLET ),
			'MB200'										=> array( 'Motorola', 'CLIQ' ),
			'MB300'										=> array( 'Motorola', 'BACKFLIP' ),
			'MB501'										=> array( 'Motorola', 'CLIQ XT' ),
			'MB502'										=> array( 'Motorola', 'CHARM' ),
			'MB508'										=> array( 'Motorola', 'FLIPSIDE' ),
			'MB511'										=> array( 'Motorola', 'FLIPOUT' ),
			'MB520'										=> array( 'Motorola', 'BRAVO' ),
			'MB525!'									=> array( 'Motorola', 'DEFY' ),
			'MB526'										=> array( 'Motorola', 'DEFY+' ),
			'MB611'										=> array( 'Motorola', 'CLIQ 2' ),
			'MB612'										=> array( 'Motorola', 'XPRT' ),
			'MB632'										=> array( 'Motorola', 'PRO+' ),
			'MB855'										=> array( 'Motorola', 'PHOTON 4G' ),
			'MB8(60|61)!'								=> array( 'Motorola', 'ATRIX' ),
			'MB865'										=> array( 'Motorola', 'ATRIX 2' ),
			'MB870'										=> array( 'Motorola', 'Droid X2' ),
			'MB886'										=> array( 'Motorola', 'DINARA' ),
			'ME501'										=> array( 'Motorola', 'CLIQ XT' ),
			'ME511'										=> array( 'Motorola', 'FLIPOUT' ),
			'ME525!'									=> array( 'Motorola', 'MOTO ME525' ),
			'ME526!'									=> array( 'Motorola', 'DEFY+' ),
			'ME600'										=> array( 'Motorola', 'BACKFLIP' ),
			'ME632'										=> array( 'Motorola', 'PRO+' ),
			'ME722'										=> array( 'Motorola', 'Milestone 2' ),
			'ME811'										=> array( 'Motorola', 'Droid X' ),
			'ME860'										=> array( 'Motorola', 'ATRIX' ),
			'ME863'										=> array( 'Motorola', 'Milestone 3' ),
			'ME865'										=> array( 'Motorola', 'ATRIX 2' ),
			'MT620!'									=> array( 'Motorola', 'MOTO MT620' ),
			'MT716'										=> array( 'Motorola', 'MOTO MT716' ),
			'MT788'										=> array( 'Motorola', 'RAZR i' ),
			'MT810'										=> array( 'Motorola', 'MOTO MT810' ),
			'MT870'										=> array( 'Motorola', 'MOTO MT870' ),
			'MT887'										=> array( 'Motorola', 'RAZR V' ),
			'MT917'										=> array( 'Motorola', 'MT917' ),
			'MZ505'										=> array( 'Motorola', 'XOOM Family Edition', TYPE_TABLET ),
			'MZ600'										=> array( 'Motorola', 'XOOM 4G LTE', TYPE_TABLET ),
			'MZ601'										=> array( 'Motorola', 'XOOM 3G', TYPE_TABLET ),
			'MZ602'										=> array( 'Motorola', 'XOOM 4G LTE', TYPE_TABLET ),
			'MZ603'										=> array( 'Motorola', 'XOOM 3G', TYPE_TABLET ),
			'MZ604'										=> array( 'Motorola', 'XOOM WiFi', TYPE_TABLET ),
			'MZ605'										=> array( 'Motorola', 'XOOM 3G', TYPE_TABLET ),
			'MZ606'										=> array( 'Motorola', 'XOOM WiFi', TYPE_TABLET ),
			'MZ607'										=> array( 'Motorola', 'XOOM 2 WiFi Media Edition', TYPE_TABLET ),
			'MZ608'										=> array( 'Motorola', 'XOOM 2 3G Media Edition', TYPE_TABLET ),
			'MZ609!'									=> array( 'Motorola', 'Droid XYBOARD 8.2', TYPE_TABLET ),
			'MZ615'										=> array( 'Motorola', 'XOOM 2 WiFi', TYPE_TABLET ),
			'MZ616'										=> array( 'Motorola', 'XOOM 2 3G', TYPE_TABLET ),
			'MZ617!'									=> array( 'Motorola', 'Droid XYBOARD 10.1', TYPE_TABLET ),
			'WX435'										=> array( 'Motorola', 'TRIUMPH WX435' ),
			'WX445'										=> array( 'Motorola', 'CITRUS WX445' ),
			'XT300'										=> array( 'Motorola', 'SPICE' ),
			'XT301'										=> array( 'Motorola', 'MOTO XT301' ),
			'XT303'										=> array( 'Motorola', 'MOTOSMART XT303' ),
			'XT305'										=> array( 'Motorola', 'MOTOSMART XT305' ),
			'XT311'										=> array( 'Motorola', 'FIRE' ),
			'XT316'										=> array( 'Motorola', 'MOTO XT316' ),
			'XT317'										=> array( 'Motorola', 'SPICE Key' ),
			'XT319'										=> array( 'Motorola', 'MOTO XT319' ),
			'XT3(20|21)!'								=> array( 'Motorola', 'DEFY Mini' ),
			'XT389'										=> array( 'Motorola', 'MOTOSMART XT389' ),
			'XT390'										=> array( 'Motorola', 'MOTOSMART XT390' ),
			'XT500'										=> array( 'Motorola', 'MOTO XT500' ),
			'xt-500'									=> array( 'Motorola', 'MOTO XT500' ),
			'XT502'										=> array( 'Motorola', 'QUENCH XT5' ),
			'XT5(30|31)!'								=> array( 'Motorola', 'FIRE XT' ),
			'XT532'										=> array( 'Motorola', 'MOTO XT532' ),	
			'XT535'										=> array( 'Motorola', 'DEFY' ),	
			'XT536'										=> array( 'Motorola', 'DEFY Diana' ),	
			'XT550'										=> array( 'Motorola', 'MOTOSMART MIX' ),	
			'XT5(56|57)!'								=> array( 'Motorola', 'DEFY XT' ),	
			'XT560'										=> array( 'Motorola', 'DEFY Pro' ),	
			'XT603'										=> array( 'Motorola', 'ADMIRAL' ),
			'XT605'										=> array( 'Motorola', 'XT605' ),	
			'XT610'										=> array( 'Motorola', 'Droid Pro' ),
			'XT611'										=> array( 'Motorola', 'MOTOSMART Flip' ),
			'XT615'										=> array( 'Motorola', 'MOTO XT615' ),
			'XT621'										=> array( 'Motorola', 'Primus XT621' ),
			'XT626'										=> array( 'Motorola', 'MOTO XT626' ),
			'XT681'										=> array( 'Motorola', 'MOTO XT681' ),
			'XT682'										=> array( 'Motorola', 'Droid 3' ),
			'XT685'										=> array( 'Motorola', 'MOTO XT685' ),
			'XT687'										=> array( 'Motorola', 'ATRIX TV' ),
			'XT701'										=> array( 'Motorola', 'XT701' ),
			'XT702'										=> array( 'Motorola', 'MOTO XT702' ),
			'XT711'										=> array( 'Motorola', 'MOTO XT711' ),
			'XT720'										=> array( 'Motorola', 'Milestone' ),
			'XT760'										=> array( 'Motorola', 'MOTO XT760' ),
			'XT788'										=> array( 'Motorola', 'XT788' ),
			'XT875'										=> array( 'Motorola', 'Droid Bionic' ),
			'XT800W'									=> array( 'Motorola', 'MOTO Glam' ),
			'XT800!'									=> array( 'Motorola', 'MOTO XT800' ),
			'XT806'										=> array( 'Motorola', 'MOTO XT806' ),
			'XT8(60|83)!'								=> array( 'Motorola', 'Milestone 3' ),
			'XT862'										=> array( 'Motorola', 'Droid 3' ),
			'XT881'										=> array( 'Motorola', 'Electrify 2' ),
			'XT882'										=> array( 'Motorola', 'MOTO XT882' ),
			'XT8(85|86)!'								=> array( 'Motorola', 'RAZR V' ),
			'XT889'										=> array( 'Motorola', 'XT889' ),
			'XT890'										=> array( 'Motorola', 'RAZR i' ),
			'XT8(94|97)!'								=> array( 'Motorola', 'Droid 4' ),
			'XT9(01|10)!'								=> array( 'Motorola', 'RAZR' ),
			'XT905'										=> array( 'Motorola', 'RAZR M' ),
			'XT907'										=> array( 'Motorola', 'Droid RAZR M' ),
			'XT912!'									=> array( 'Motorola', 'Droid RAZR' ),
			'XT916'										=> array( 'Motorola', 'Droid RAZR Maxx' ),
			'XT9(14|18)!'								=> array( 'Motorola', 'Droid RAZR D1' ),
			'XT9(19|20)!'								=> array( 'Motorola', 'Droid RAZR D3' ),
			'XT9(23|25|26)!'							=> array( 'Motorola', 'Droid RAZR HD' ),
			'XT928'										=> array( 'Motorola', 'XT928' ),
			'XT1058'									=> array( 'Motorola', '"X Phone"' ),
			'201M'										=> array( 'Motorola', 'Droid RAZR M' ),
			'Atrix 2'									=> array( 'Motorola', 'ATRIX 2' ),
			'Atrix 4G'									=> array( 'Motorola', 'ATRIX 4G' ),
			'Atrix 4G ME860'							=> array( 'Motorola', 'ATRIX 4G' ),
			'Backflip'									=> array( 'Motorola', 'BACKFLIP' ),
			'CLIQ'										=> array( 'Motorola', 'CLIQ' ),
			'CLIQ XT'									=> array( 'Motorola', 'CLIQ XT' ),
			'CLIQ2'										=> array( 'Motorola', 'CLIQ 2' ),
			'Corvair'									=> array( 'Motorola', 'Corvair', TYPE_TABLET ),
			'DEFY'										=> array( 'Motorola', 'DEFY' ),
			'Defy(\\+| Plus)!'							=> array( 'Motorola', 'DEFY+' ),
			'DEDY+'										=> array( 'Motorola', 'DEFY+' ),
			'Dext'										=> array( 'Motorola', 'Dext' ),
			'Droid'										=> array( 'Motorola', 'Droid' ),
			'DROID'										=> array( 'Motorola', 'Droid' ),
			'DROID ?2!'									=> array( 'Motorola', 'Droid 2' ),
			'DROID ?3!'									=> array( 'Motorola', 'Droid 3' ),
			'DROID ?4!'									=> array( 'Motorola', 'Droid 4' ),
			'DROID Pro'									=> array( 'Motorola', 'Droid Pro' ),
			'DROID BIONIC!'								=> array( 'Motorola', 'Droid Bionic' ),
			'DROID RAZR HD!'							=> array( 'Motorola', 'Droid RAZR HD' ),
			'DROID ?RAZR!'								=> array( 'Motorola', 'Droid RAZR' ),
			'DROID SPYDER'								=> array( 'Motorola', 'Droid RAZR' ),
			'DROID ?X2!'								=> array( 'Motorola', 'Droid X2' ),
			'DROID ?X!'									=> array( 'Motorola', 'Droid X' ),
			'Devour'									=> array( 'Motorola', 'Droid Devour' ),
			'calgary'									=> array( 'Motorola', 'Droid Devour' ),
			'Electrify'									=> array( 'Motorola', 'Electrify' ),
			'Milestone XT720'							=> array( 'Motorola', 'Milestone' ),
			'Milestone'									=> array( 'Motorola', 'Milestone' ),
			'A853 Milestone'							=> array( 'Motorola', 'Milestone' ),
			'Milestone X'								=> array( 'Motorola', 'Milestone X' ),
			'Milestone X2'								=> array( 'Motorola', 'Milestone X2' ),
			'MotoroiX'									=> array( 'Motorola', 'Droid X' ),
			'Moto Backflip'								=> array( 'Motorola', 'BACKFLIP' ),
			'RAZR'										=> array( 'Motorola', 'RAZR' ),
			'RAZR HD'									=> array( 'Motorola', 'RAZR HD' ),
			'RAZR MAXX'									=> array( 'Motorola', 'RAZR MAXX' ),
			'Triumph'									=> array( 'Motorola', 'TRIUMPH' ),
			'Opus One'									=> array( 'Motorola', 'i1' ),
			'Photon'									=> array( 'Motorola', 'PHOTON' ),
			'Photon 4G'									=> array( 'Motorola', 'PHOTON 4G' ),
			'XOOM'										=> array( 'Motorola', 'XOOM', TYPE_TABLET ),
			'MOTOROLA XOOM MZ606'						=> array( 'Motorola', 'XOOM', TYPE_TABLET ),
			'XOOM 2!'									=> array( 'Motorola', 'XOOM 2', TYPE_TABLET ),
			'XOOM MZ606'								=> array( 'Motorola', 'XOOM WiFi', TYPE_TABLET ),
			'ISW11M'									=> array( 'Motorola', 'PHOTON' ),
			'IS12M'										=> array( 'Motorola', 'RAZR' ),
			'MOTOROLA RAZR'								=> array( 'Motorola', 'RAZR' ),
			'MOTWX435KT'								=> array( 'Motorola', 'TRIUMPH' ),
			'X3-Ice MIUI XT720 Memorila Classics'		=> array( 'Motorola', 'Milestone' ),
			'MC40N0'									=> array( 'Motorola', 'MC40', TYPE_POS ),
			'Enjoy 7 Plus'								=> array( 'Multilaser', 'Vibe NB036', TYPE_TABLET ),
			'MTS-SP100'									=> array( 'MTS', 'Lifewire SP 100' ),
			'NB036'										=> array( 'Nabi', 'Kids tablet', TYPE_TABLET ),
			'MyPhone A848 Duo'							=> array( 'MyPhone', 'A848 Duo' ),
			'A878 Duo'									=> array( 'MyPhone', 'A878 Duo' ),
			'MyPhone A888 Duo'							=> array( 'MyPhone', 'A888 Duo' ),
			'A898 Duo'									=> array( 'MyPhone', 'A898 Duo' ),
			'MyPhone A919 Duo'							=> array( 'MyPhone', 'A919 Duo' ),
			'NABI-A'									=> array( 'Nabi', 'Kids tablet', TYPE_TABLET ),
			'N1'										=> array( 'Newman', 'N1' ),
			'Newman N2'									=> array( 'Newman', 'N2' ),
			'Newpad'									=> array( 'Newsmy', 'Newpad', TYPE_TABLET ),
			'Newpad-K97'								=> array( 'Newsmy', 'Newpad K97', TYPE_TABLET ),
			'P7'										=> array( 'Newsmy', 'Newpad P7', TYPE_TABLET ),
			'Newpad P9'									=> array( 'Newsmy', 'Newpad P9', TYPE_TABLET ),
			'M-PAD N8'									=> array( 'Newsmy', 'M-pad N8', TYPE_TABLET ),
			'LT-NA7'									=> array( 'NEC', 'LT-NA7' ),
			'N-01D'										=> array( 'NEC', 'MEDIAS PP N-01D' ),
			'N-04C'										=> array( 'NEC', 'MEDIAS N-04C' ),
			'N-04D'										=> array( 'NEC', 'MEDIAS LTE N-04D' ),
			'N-04E'										=> array( 'NEC', 'MEDIAS X N-04E' ),
			'N-05D'										=> array( 'NEC', 'MEDIAS ES N-05D' ),
			'N-05E'										=> array( 'NEC', 'MEDIAS W N-05E' ),
			'N-06C'										=> array( 'NEC', 'MEDIAS WP N-06C' ),
			'N-06D'										=> array( 'NEC', 'MEDIAS Tab N-06D', TYPE_TABLET ),
			'N-07D'										=> array( 'NEC', 'MEDIAS X N-07D' ),
			'101N'										=> array( 'NEC', 'MEDIAS CH Softbank 101N' ),
			'IS11N'										=> array( 'NEC', 'MEDIAS BR IS11N' ),
			'NEC-101S'									=> array( 'NEC', 'MEDIAS 101S' ),
			'NEC-101T'									=> array( 'NEC', 'MEDIAS 101T' ),
			'NEC-102'									=> array( 'NEC', 'MEDIAS 102' ),
			'Nexian NX-A890'							=> array( 'Nexian', 'Journey' ),
			'NX-A890'									=> array( 'Nexian', 'Journey' ),
			'NX-A891'									=> array( 'Nexian', 'Ultra Journey' ),
			'NX-A899'									=> array( 'Nexian', 'Xtreme' ),
			'M726HC'									=> array( 'Nextbook', 'Premium 7', TYPE_EREADER ),
			'Next7P12!'									=> array( 'Nextbook', 'Premium 7', TYPE_EREADER ),
			'NXM726HN'									=> array( 'Nextbook', 'Premium 7', TYPE_EREADER ),
			'NXM727KC!'									=> array( 'Nextbook', 'Premium 7', TYPE_EREADER ),
			'Next8P12'									=> array( 'Nextbook', 'Premium 8', TYPE_EREADER ),
			'NXM803HC'									=> array( 'Nextbook', 'Premium 8', TYPE_EREADER ),
			'NXM803HD'									=> array( 'Nextbook', 'Premium 8', TYPE_EREADER ),
			'DATAM803HC'								=> array( 'Nextbook', 'Premium 8', TYPE_EREADER ),
			'NXM805ND'									=> array( 'Nextbook', 'Premium 8 SE', TYPE_EREADER ),
			'DATAM819HD B'								=> array( 'Nextbook', 'Premium 8', TYPE_EREADER ),
			'NXM908HC'									=> array( 'Nextbook', 'Premium 9', TYPE_EREADER ),
			'NXM703U'									=> array( 'Nextbook', 'Next 2', TYPE_EREADER ),
			'NXM901'									=> array( 'Nextbook', 'Next 3', TYPE_EREADER),
			'NGM Vanity Smart'							=> array( 'NGM', 'Vanity Smart' ),
			'i9430'										=> array( 'Ninetology', 'Insight i9430' ),
			'Nokia N9'									=> array( 'Nokia', 'N9' ),
			'Nokia N900'								=> array( 'Nokia', 'N900' ),
			'Lumia800'									=> array( 'Nokia', 'Lumia 800' ),
			'Lumia 900'									=> array( 'Nokia', 'Lumia 900' ),
			'Notion Ink ADAM'							=> array( 'Notion Ink', 'ADAM', TYPE_TABLET ),
			'Adam'										=> array( 'Notion Ink', 'ADAM', TYPE_TABLET ),
			'P4D Sirius'								=> array( 'Nvsbl', 'P4D SIRIUS', TYPE_TABLET ),
			'EFM710A'									=> array( 'Oblio', 'Mint 7x', TYPE_TABLET ),
			'Loox'										=> array( 'Odys', 'Loox', TYPE_TABLET ),
			'XELIO'										=> array( 'Odys', 'Xelio', TYPE_TABLET ),
			'ODYS-Xpress'								=> array( 'Odys', 'Xpress', TYPE_TABLET ),
			'Olivetti Olipad 100'						=> array( 'Olivetti', 'Olipad 100', TYPE_TABLET ),
			'OP110'										=> array( 'Olivetti', 'Olipad 110', TYPE_TABLET ),
			'ONDA MID'									=> array( 'Onda', 'MID', TYPE_TABLET ),
			'V812 Core4'								=> array( 'Onda', 'V812 Quad Core', TYPE_TABLET ),
			'V972 Core4'								=> array( 'Onda', 'V972 Quad Core', TYPE_TABLET ),
			'VX580A'									=> array( 'Onda', 'VX580A', TYPE_TABLET ),
			'VX610A'									=> array( 'Onda', 'VX610A', TYPE_TABLET ),
			'TQ150'										=> array( 'Onda', 'TQ150' ),
			'TT101'										=> array( 'Onda', 'TT101', TYPE_TABLET ),
			'N2T'										=> array( 'ONN', 'N2T', TYPE_TABLET ),
			'Renesas!'									=> array( 'Opad', 'Renesas', TYPE_TABLET ),
			'Find 5'									=> array( 'Oppo', 'Find 5' ),
			'X903'										=> array( 'Oppo', 'Find Me X903' ),
			'X905'										=> array( 'Oppo', 'Find 3 X905' ),
			'OPPOX905'									=> array( 'Oppo', 'Find 3 X905' ),
			'X907'										=> array( 'Oppo', 'Finder X907' ),
			'OPPOX907'									=> array( 'Oppo', 'Finder X907' ),
			'X909'										=> array( 'Oppo', 'Find 5 X909' ),
			'X909T'										=> array( 'Oppo', 'Find 5 X909T' ),
			'X9015'										=> array( 'Oppo', 'Find X9015' ),
			'OPPOX9015'									=> array( 'Oppo', 'Find X9015' ),
			'X9017'										=> array( 'Oppo', 'Finder X9017' ),
			'OPPOX9017'									=> array( 'Oppo', 'Finder X9017' ),
			'OPPOR601'									=> array( 'Oppo', 'Real R601' ),
			'R801'										=> array( 'Oppo', 'Real R801' ),
			'OPPOR801'									=> array( 'Oppo', 'Real R801' ),
			'OPPOR803'									=> array( 'Oppo', 'Real R803' ),
			'OPPOR805'									=> array( 'Oppo', 'Real R805' ),
			'R807'										=> array( 'Oppo', 'Real R807' ),
			'OPPOR807'									=> array( 'Oppo', 'Real R807' ),
			'OPPOR817'									=> array( 'Oppo', 'Real R817' ),
			'OPPOR8111'									=> array( 'Oppo', 'Find Melody R8111' ),
			'OPPOT29'									=> array( 'Oppo', 'T29' ),
			'(OPPO-?)?T703!'							=> array( 'Oppo', 'T703' ),
			'OPPOU701'									=> array( 'Oppo', 'Ulike U701' ),
			'OPPOU7011'									=> array( 'Oppo', 'Find Gemini U7011' ),
			'OP0118-12'									=> array( 'Oregon Scientific', 'Meep!', TYPE_TABLET ),
			'P-01D'										=> array( 'Panasonic', 'P-01D' ),
			'P-02D'										=> array( 'Panasonic', 'Lumix Phone' ),
			'P-02E'										=> array( 'Panasonic', 'Eluga X' ),
			'P-03E'										=> array( 'Panasonic', 'Eluga P' ),
			'P-04D'										=> array( 'Panasonic', 'Eluga' ),
			'P-06D'										=> array( 'Panasonic', 'Eluga V' ),
			'P-07C'										=> array( 'Panasonic', 'P-07C' ),
			'P-07D'										=> array( 'Panasonic', 'Eluga Power' ),
			'P-08D'										=> array( 'Panasonic', 'Eluga Live' ),
			'dL1'										=> array( 'Panasonic', 'Eluga dL1' ),
			'101P'										=> array( 'Panasonic', 'Lumix Phone' ),
			'Panasonic P11'								=> array( 'Panasonic', 'P11' ),
			'JT-H580VT'									=> array( 'Panasonic', 'BizPad 7', TYPE_TABLET ),
			'JT-H581VT'									=> array( 'Panasonic', 'BizPad 10', TYPE_TABLET ),
			'FZ-A1(A|B)!'								=> array( 'Panasonic', 'Toughpad', TYPE_TABLET ),
			'pandigital9hr'								=> array( 'Pandigital', '9HR', TYPE_TABLET ),
			'pandigital9hr2'							=> array( 'Pandigital', '9HR2', TYPE_TABLET ),
			'pandigitalopc1'							=> array( 'Pandigital', 'OPC1', TYPE_TABLET ),
			'pandigitalopp1'							=> array( 'Pandigital', 'OPP1', TYPE_TABLET ),
			'pandigitalp1hr'							=> array( 'Pandigital', 'p1hr', TYPE_TABLET ),
			'IM-A600!'									=> array( 'Pantech', 'SIRIUS α' ),
			'IM-A630!'									=> array( 'Pantech', 'Izar' ),
			'IM-A650!'									=> array( 'Pantech', 'Vega' ),
			'IM-A690!'									=> array( 'Pantech', 'Mirach' ),
			'IM-A7(10|20)!'								=> array( 'Pantech', 'VegaXpress' ),
			'IM-A725!'									=> array( 'Pantech', 'Vega X+' ),
			'IM-A730!'									=> array( 'Pantech', 'Vega S' ),
			'IM-A7(40|50)!'								=> array( 'Pantech', 'Mirach A' ),
			'IM-A7(60|70|75|80)!'						=> array( 'Pantech', 'Vega Racer' ),
			'IM-A800!'									=> array( 'Pantech', 'Vega LTE' ),
			'IM-A810!'									=> array( 'Pantech', 'Vega LTE M' ),
			'IM-A820!'									=> array( 'Pantech', 'Vega LTE EX' ),
			'IM-A830!'									=> array( 'Pantech', 'Vega Racer 2' ),
			'IM-A840!'									=> array( 'Pantech', 'Vega S5' ),
			'IM-A850!'									=> array( 'Pantech', 'Vega R3' ),
			'IM-A860!'									=> array( 'Pantech', 'Vega N˚ 6' ),
			'IM-A870!'									=> array( 'Pantech', 'IM-A870' ),
			'IM-T100K'									=> array( 'Pantech', 'Vega N˚ 5', TYPE_TABLET ),
			'IS06'										=> array( 'Pantech', 'SIRIUS α' ),
			'ADR8995!'									=> array( 'Pantech', 'Breakout' ),
			'ADR910L 4G'								=> array( 'Pantech', 'Marauder' ),
			'ADR930L 4G'								=> array( 'Pantech', 'Perception' ),
			'PantechP4100'								=> array( 'Pantech', 'Element', TYPE_TABLET ),
			'PantechP8000'								=> array( 'Pantech', 'Crossover' ),
			'PantechP8010'								=> array( 'Pantech', 'Flex' ),
			'PantechP9060'								=> array( 'Pantech', 'Pocket' ),
			'PantechP9070'								=> array( 'Pantech', 'Burst' ),
			'PantechP9090'								=> array( 'Pantech', 'Magnus' ),
			'SKY IM-A600S'								=> array( 'Pantech', 'SIRIUS α' ),
			'SKY IM-A630K'								=> array( 'Pantech', 'Izar' ),
			'SKY IM-A650S'								=> array( 'Pantech', 'Vega' ),
			'PTL21'										=> array( 'Pantech', 'Vega PTL21' ),
			'IS11PT'									=> array( 'Pantech', 'Mirach IS11PT' ),
			'FC6100'									=> array( 'Parrot', 'FC6100', TYPE_CAR ),
			'chagall'									=> array( 'Pegatron', 'Chagall', TYPE_TABLET ),
			'7500IPS'									=> array( 'Perfeo', '7500IPS', TYPE_TABLET ),
			'PAT712W'									=> array( 'Perfeo', 'PAT712W', TYPE_TABLET ),
			'X7G'										=> array( 'Pearl', 'Touchlet X7G', TYPE_TABLET ),
			'PP4MT-7'									=> array( 'Pendo', 'Pendopad 4', TYPE_TABLET ),
			'Penta IS701C'								=> array( 'Penta', 'T-Pad IS701C', TYPE_TABLET ),
			'IS801C'									=> array( 'Penta', 'T-Pad WS801C', TYPE_TABLET ),
			'Penta WS802C'								=> array( 'Penta', 'T-Pad WS802C', TYPE_TABLET ),
			'FWS610 EU'									=> array( 'Phicomm', 'FWS610' ),
			'FWS710EU'									=> array( 'Phicomm', 'FWS710' ),
			'FWS810'									=> array( 'Phicomm', 'FWS810' ),
			'PHICOMM-i700v'								=> array( 'Phicomm', 'i700v' ),
			'Philips PI5000'							=> array( 'Philips', 'PI5000', TYPE_TABLET ),
			'PI7000'									=> array( 'Philips', 'PI7000', TYPE_TABLET ),
			'Philips W336'								=> array( 'Philips', 'W336' ),
			'Philips W536'								=> array( 'Philips', 'W536' ),
			'Philips W626'								=> array( 'Philips', 'W626' ),
			'W626'										=> array( 'Philips', 'W626' ),
			'Philips W632'								=> array( 'Philips', 'W632' ),
			'Philips W832'								=> array( 'Philips', 'W832' ),
			'PGM 398'									=> array( 'Pixcom', 'PGM 398' ),
			'PLOYER-MOMO'								=> array( 'Ployer', 'MOMO', TYPE_TABLET ),
			'MOMO'										=> array( 'Ployer', 'MOMO', TYPE_TABLET ),
			'MOMO7'										=> array( 'Ployer', 'MOMO7', TYPE_TABLET ),
			'MOMO7 Talent'								=> array( 'Ployer', 'MOMO7 Talent', TYPE_TABLET ),
			'MOMO8'										=> array( 'Ployer', 'MOMO8', TYPE_TABLET ),
			'MOMO9'										=> array( 'Ployer', 'MOMO9', TYPE_TABLET ),
			'MOMO9 STAR'								=> array( 'Ployer', 'MOMO9 Star', TYPE_TABLET ),
			'MOMO9 plus III'							=> array( 'Ployer', 'MOMO9 Plus III', TYPE_TABLET ),
			'MOMO11 bird'								=> array( 'Ployer', 'MOMO11 Bird', TYPE_TABLET ),
			'MOMO11Speed'								=> array( 'Ployer', 'MOMO11 Speed', TYPE_TABLET ),
			'MOMO15'									=> array( 'Ployer', 'MOMO15', TYPE_TABLET ),
			'MOMO19HD'									=> array( 'Ployer', 'MOMO19 HD', TYPE_TABLET ),
			'PocketBook A7'								=> array( 'PocketBook', 'A7', TYPE_TABLET ),
			'PocketBook A10'							=> array( 'PocketBook', 'A10', TYPE_TABLET ),
			'PocketBook A10 3G'							=> array( 'PocketBook', 'A10 3G', TYPE_TABLET ),
			'Obreey SURFpad'							=> array( 'PocketBook', 'SURFpad', TYPE_TABLET ),
			'Mobii 7'									=> array( 'Point Of View', 'Mobii 7', TYPE_TABLET ),
			'POV-Mobii-7'								=> array( 'Point Of View', 'Mobii 7', TYPE_TABLET ),
			'PlayTabPro'								=> array( 'Point Of View', 'PlayTabPro', TYPE_TABLET ),
			'TAB-PLAYTABPRO'							=> array( 'Point Of View', 'PlayTabPro', TYPE_TABLET ),
			'POV TAB-PROTAB25!'							=> array( 'Point Of View', 'ProTab 25', TYPE_TABLET ),
			'POV TAB-PROTAB26!'							=> array( 'Point Of View', 'ProTab 26', TYPE_TABLET ),
			'POV TAB-PROTAB30!'							=> array( 'Point Of View', 'ProTab 30', TYPE_TABLET ),
			'TAB-PROTAB2XXL(4)'							=> array( 'Point Of View', 'ProTab2 XXL', TYPE_TABLET ),
			'POV TAB NAVI7 3G M'						=> array( 'Point Of View', 'Onyx 507', TYPE_TABLET ),
			'POV TV-HDMI-200BT'							=> array( 'Point Of View', 'Smart TV', TYPE_TELEVISION ),
			'POV TV-HDMI-KB-01'							=> array( 'Point Of View', 'Smart TV', TYPE_TELEVISION ),
			'MIDC409'									=> array( 'Polaroid', 'Diamond III', TYPE_TABLET ),
			'PMID4311'									=> array( 'Polaroid', 'PMID 4311', TYPE_TABLET ),
			'PMID701C'									=> array( 'Polaroid', 'PMID 701c', TYPE_TABLET ),
			'PMID1000B V2'								=> array( 'Polaroid', 'PMID 1000b', TYPE_TABLET ),
			'POLY PAD 9708HD'							=> array( 'Polypad', '9708 HD', TYPE_TABLET ),
			'POLY PAD 9716HD'							=> array( 'Polypad', '9716 HD', TYPE_TABLET ),
			'Polypad C508'								=> array( 'Polypad', 'C508', TYPE_TABLET ),
			'Polytron W1320'							=> array( 'Polytron', 'W1320' ),
			'POLYTRON W2430'							=> array( 'Polytron', 'W2430 Wizard Twins' ),
			'POLYTRON W2500'							=> array( 'Polytron', 'W2500 Wizard Twins' ),
			'POLYTRON W3430'							=> array( 'Polytron', 'W3430 Wizard Crystal' ),
			'ACT2000'									=> array( 'Poptronix', 'ACT2000', TYPE_TABLET ),
			'PMP3084B'									=> array( 'Prestigio', 'Multipad 3084', TYPE_TABLET ),
			'PMP3170B'									=> array( 'Prestigio', 'Multipad 3170 Pro', TYPE_TABLET ),
			'PMP3170BEN'								=> array( 'Prestigio', 'Multipad 3170 Pro', TYPE_TABLET ),
			'PMP3270B'									=> array( 'Prestigio', 'Multipad 3270 Prime', TYPE_TABLET ),
			'PMP3370B'									=> array( 'Prestigio', 'Multipad 3370', TYPE_TABLET ),
			'PMP3384BRU'								=> array( 'Prestigio', 'Multipad 3384', TYPE_TABLET ),
			'PMP3770B'									=> array( 'Prestigio', 'Multipad 3770', TYPE_TABLET ),
			'PMP5080B'									=> array( 'Prestigio', 'Multipad 5080', TYPE_TABLET ),
			'PMP5080CPRO'								=> array( 'Prestigio', 'Multipad 5080 Pro', TYPE_TABLET ),
			'PMP5097CPRO'								=> array( 'Prestigio', 'Multipad 5097 Pro', TYPE_TABLET ),
			'PMP5197DULTRA'								=> array( 'Prestigio', 'Multipad 5197 Ultra', TYPE_TABLET ),
			'PMP5570C'									=> array( 'Prestigio', 'Multipad 5570 Pro', TYPE_TABLET ),	
			'PMP5580C'									=> array( 'Prestigio', 'Multipad 5580 Prime', TYPE_TABLET ),
			'PMP5597D'									=> array( 'Prestigio', 'Multipad 5597 Ultra Duo', TYPE_TABLET ),
			'PMP5770D'									=> array( 'Prestigio', 'Multipad 5770 Pro', TYPE_TABLET ),
			'PMP5880D'									=> array( 'Prestigio', 'Multipad 5880 Ultra Duo', TYPE_TABLET ),
			'PMP7100D3G'								=> array( 'Prestigio', 'Multipad 7100 Ultimate 3G', TYPE_TABLET ),
			'PAP3500 DUO'								=> array( 'Prestigio', 'Multiphone 3500 Duo' ),
			'PAP4040 DUO'								=> array( 'Prestigio', 'Multiphone 4040 Duo' ),
			'PAP4300 DUO'								=> array( 'Prestigio', 'Multiphone 4300 Duo' ),
			'PAP4500DUO'								=> array( 'Prestigio', 'Multiphone 4500 Duo' ),
			'PAP4500TDUO'								=> array( 'Prestigio', 'Multiphone 4500 Duo' ),
			'PAP5000TDUO'								=> array( 'Prestigio', 'Multiphone 5000 Duo' ),
			'MD-0696B'									=> array( 'Prolink', 'MD-0696B', TYPE_TABLET ),
			'TB07FTA'									=> array( 'Positivo', 'TB07FTA', TYPE_TABLET ),
			'QW TB-1207'								=> array( 'Qware', 'Pro3', TYPE_TABLET ),
			'W6'										=> array( 'Ramos', 'W6', TYPE_TABLET ),
			'W6HD ICS'									=> array( 'Ramos', 'W6HD', TYPE_TABLET ),
			'W10'										=> array( 'Ramos', 'W10', TYPE_TABLET ),
			'W10 V2.0'									=> array( 'Ramos', 'W10 v2.0', TYPE_TABLET ),
			'Ramos W12HD'								=> array( 'Ramos', 'W12HD', TYPE_TABLET ),
			'W17PRO(Dualcore)'							=> array( 'Ramos', 'W17 Pro Dual Core', TYPE_TABLET ),
			'W22PRO'									=> array( 'Ramos', 'W22 Pro', TYPE_TABLET ),
			'W22PRO 3G'									=> array( 'Ramos', 'W22 Pro 3G', TYPE_TABLET ),
			'Ramos W27Pro'								=> array( 'Ramos', 'W27 Pro', TYPE_TABLET ),
			'W28(Dualcore)'								=> array( 'Ramos', 'W28 Dual Core', TYPE_TABLET ),
			'W30(QuadCore)'								=> array( 'Ramos', 'W30 Quad Core', TYPE_TABLET ),
			'w30hd(QuadCore)'							=> array( 'Ramos', 'W30HD Quad Core', TYPE_TABLET ),
			'w42(QuadCore)'								=> array( 'Ramos', 'W42 Quad Core', TYPE_TABLET ),
			'T11AD!'									=> array( 'Ramos', 'T11AD', TYPE_TABLET ),
			'Readboy G12'								=> array( 'Readboy', 'G12', TYPE_TABLET ),
			'PlayBook'									=> array( 'RIM', 'BlackBerry PlayBook', TYPE_TABLET ),
			'RBK-490'									=> array( 'Ritmix', 'RBK-490', TYPE_TABLET ),
			'RMD-755'									=> array( 'Ritmix', 'RBK-755', TYPE_TABLET ),
			'RMD-1030'									=> array( 'Ritmix', 'RBK-1030', TYPE_TABLET ),
			'RMD-73G'									=> array( 'Ross&Moor', 'RMD-73G', TYPE_TABLET ),	
			'RMD-973G'									=> array( 'Ross&Moor', 'RMD-973G', TYPE_TABLET ),
			'RoverPad 3W T71D'							=> array( 'RoverPad', '3W T71D', TYPE_TABLET ),
			'A8HD'										=> array( 'Saayi', 'Dropad A8HD', TYPE_TABLET ),
			'EK-GC100'									=> array( 'Samsung', 'Galaxy Camera', TYPE_CAMERA ),
			'EK-GC110'									=> array( 'Samsung', 'Galaxy Camera', TYPE_CAMERA ),
			'EK-GC120'									=> array( 'Samsung', 'Galaxy NX', TYPE_CAMERA ),
			'GT-B5330!'									=> array( 'Samsung', 'Galaxy Chat' ),
			'GT-B5510!'									=> array( 'Samsung', 'Galaxy Y Pro' ),
			'GT-B5512!'									=> array( 'Samsung', 'Galaxy Y Pro Duos' ),
			'GT-B7510!'									=> array( 'Samsung', 'Galaxy Pro' ),
			'GT-B9062'									=> array( 'Samsung', 'GT-B9062' ),
			'GT-B9150'									=> array( 'Samsung', 'Galaxy "Q"' ),
			'GT-I55(00|03|08)!'							=> array( 'Samsung', 'Galaxy 5' ),
			'GT-I5510!'									=> array( 'Samsung', 'Galaxy 551' ),
			'GT-I5700!'									=> array( 'Samsung', 'Galaxy Spica' ),
			'GT-I58(00|01)!'							=> array( 'Samsung', 'Galaxy Apollo' ),
			'GT-I6500!'									=> array( 'Samsung', 'Saturn' ),
			'GT-I777!'									=> array( 'Samsung', 'Singa' ),
			'GT-I8000!'									=> array( 'Samsung', 'Omnia 2' ),
			'GT-I8150!'									=> array( 'Samsung', 'Galaxy W' ),
			'GT-I8160!'									=> array( 'Samsung', 'Galaxy Ace 2' ),
			'GT-I81(90|91)!'							=> array( 'Samsung', 'Galaxy S III Mini' ),
			'GT-I8240!'									=> array( 'Samsung', 'GT-I8240' ),	
			'GT-I8245!'									=> array( 'Samsung', 'GT-I8245' ),			
			'GT-I8250!'									=> array( 'Samsung', 'GT-I8250' ),
			'GT-I8262!'									=> array( 'Samsung', 'Galaxy Core' ),
			'GT-I8268!'									=> array( 'Samsung', 'GT-I8268' ),
			'GT-I8320!'									=> array( 'Samsung', 'H1' ),
			'GT-I85(20|30)!'							=> array( 'Samsung', 'Galaxy Beam' ),
			'GT-I85(52|58)!'							=> array( 'Samsung', 'Galaxy Win' ),
			'GT-I8730!'									=> array( 'Samsung', 'Galaxy Express' ),							
			'GT-I90(00|08|18|88)!'						=> array( 'Samsung', 'Galaxy S' ),
			'GT-I9001!'									=> array( 'Samsung', 'Galaxy S Plus' ),
			'GT-I9003!'									=> array( 'Samsung', 'Galaxy SL' ),
			'GT-I9010!'									=> array( 'Samsung', 'Galaxy S Giorgio Armani' ),
			'GT-I9050!'									=> array( 'Samsung', 'GT-I9050' ),
			'GT-I9070!'									=> array( 'Samsung', 'Galaxy S Advance' ),
			'GT-I9080!'									=> array( 'Samsung', 'Galaxy Grand' ),
			'GT-I9082!'									=> array( 'Samsung', 'Galaxy Grand Duos' ),
			'GT-I91(00|08)!'							=> array( 'Samsung', 'Galaxy S II' ),
			'GT-I9103!'									=> array( 'Samsung', 'Galaxy R' ),
			'GT-I9105!'									=> array( 'Samsung', 'Galaxy S II Plus' ),
			'GT-I9128!'									=> array( 'Samsung', 'Galaxy Grand' ),
			'GT-I9150!'									=> array( 'Samsung', 'Galaxy Mega 5.8' ),
			'GT-I9152!'									=> array( 'Samsung', 'Galaxy Mega 5.8 Duos' ),
			'GT-I91(90|95)!'							=> array( 'Samsung', 'Galaxy S4 Mini' ),
			'GT-I9192!'									=> array( 'Samsung', 'Galaxy S4 Mini Duos' ),
			'GT-I9200!'									=> array( 'Samsung', 'Galaxy Mega 6.3' ),
			'GT-I9205'									=> array( 'Samsung', 'Galaxy Mega 6.3' ),
			'GT-I9210!'									=> array( 'Samsung', 'Galaxy S II LTE' ),
			'GT-I92(20|28)!'							=> array( 'Samsung', 'Galaxy Note' ),
			'GT-I9250!'									=> array( 'Samsung', 'Galaxy Nexus' ),
			'GT-I92(60|68)!'							=> array( 'Samsung', 'Galaxy Premier' ),
			'GT-I9295!'									=> array( 'Samsung', 'Galaxy S4 Active' ),
			'GT-I93(00|03|05|08)!'						=> array( 'Samsung', 'Galaxy S III' ),
			'GT-I95(00|05)!'							=> array( 'Samsung', 'Galaxy S4' ),
			'GT-I95(02|08)!'							=> array( 'Samsung', 'Galaxy S4 Duos' ),
			'GT-I9800!'									=> array( 'Samsung', 'GT-I9800' ),								// Unknown
			'GT-N51(00|05|10|20)!'						=> array( 'Samsung', 'Galaxy Note 8.0', TYPE_TABLET ),
			'GT-N70(00|05)!'							=> array( 'Samsung', 'Galaxy Note' ),
			'GT-N71(00|02|05|08)!'						=> array( 'Samsung', 'Galaxy Note II' ),
			'GT-N7200!'									=> array( 'Samsung', 'Galaxy Note 3' ),
			'GT-N80(00|05|10|13|20)!'					=> array( 'Samsung', 'Galaxy Note 10.1', TYPE_TABLET ),
			'GT-P10(00|10)!'							=> array( 'Samsung', 'Galaxy Tab', TYPE_TABLET ),
			'GT-P31(00|05|10|13)!'						=> array( 'Samsung', 'Galaxy Tab 2 (7.0)', TYPE_TABLET ),
			'GT-P32(00|10)!'							=> array( 'Samsung', 'Galaxy Tab 3 (7.0)', TYPE_TABLET ),
			'GT-P51(00|10|13)!'							=> array( 'Samsung', 'Galaxy Tab 2 (10.1)', TYPE_TABLET ),
			'GT-P52(00|10)!'							=> array( 'Samsung', 'Galaxy Tab 3 (10.1)', TYPE_TABLET ),
			'GT-P62(00|10)!'							=> array( 'Samsung', 'Galaxy Tab 7.0 Plus', TYPE_TABLET ),
			'GT-P62(01|11)!'							=> array( 'Samsung', 'Galaxy Tab 7.0 Plus N', TYPE_TABLET ),
			'GT-P68(00|10)!'							=> array( 'Samsung', 'Galaxy Tab 7.7', TYPE_TABLET ),
			'GT-P7100!'									=> array( 'Samsung', 'Galaxy Tab 10.1V', TYPE_TABLET ),
			'GT-P73(00|10|20)!'							=> array( 'Samsung', 'Galaxy Tab 8.9', TYPE_TABLET ),
			'GT-P75(00|10)!'							=> array( 'Samsung', 'Galaxy Tab 10.1', TYPE_TABLET ),
			'GT-P75(01|11)!'							=> array( 'Samsung', 'Galaxy Tab 10.1N', TYPE_TABLET ),
			'GT-P8110!'									=> array( 'Samsung', 'Nexus 10', TYPE_TABLET ),
			'GT-P8200!'									=> array( 'Samsung', 'Galaxy Tab 3 Plus (10.1)', TYPE_TABLET ),
			'GT-S5282!'									=> array( 'Samsung', 'Galaxy Star' ),
			'GT-S5300!'									=> array( 'Samsung', 'Galaxy Pocket' ),
			'GT-S5301!'									=> array( 'Samsung', 'Galaxy Pocket Plus' ),
			'GT-S5302!'									=> array( 'Samsung', 'Galaxy Pocket Duos' ),
			'GT-S5303!'									=> array( 'Samsung', 'Galaxy Y Plus' ),
			'GT-S5310!'									=> array( 'Samsung', 'Galaxy Pocket 2' ),
			'GT-S5312!'									=> array( 'Samsung', 'Galaxy Pocket 2 Duos' ),
			'GT-S53(60|63|69)!'							=> array( 'Samsung', 'Galaxy Y' ),
			'GT-S5367!'									=> array( 'Samsung', 'Galaxy Y TV' ),
			'GT-S5368!'									=> array( 'Samsung', 'Galaxy Y Young' ),
			'GT-S55(70|78)!'							=> array( 'Samsung', 'Galaxy Mini' ),
			'GT-S5660!'									=> array( 'Samsung', 'Galaxy Gio' ),
			'GT-S5670!'									=> array( 'Samsung', 'Galaxy Fit' ),
			'GT-S5690!'									=> array( 'Samsung', 'Galaxy Xcover' ),
			'GT-S58(20|30|38|39)!'						=> array( 'Samsung', 'Galaxy Ace' ),
			'GT-S6010'									=> array( 'Samsung', 'Galaxy Music' ),
			'GT-S6012!'									=> array( 'Samsung', 'Galaxy Music Duos' ),
			'GT-S6102!'									=> array( 'Samsung', 'Galaxy Y Duos' ),
			'GT-S6310!'									=> array( 'Samsung', 'Galaxy Young' ),
			'GT-S6312!'									=> array( 'Samsung', 'Galaxy Young Duos' ),
			'GT-S6313!'									=> array( 'Samsung', 'Galaxy Y Duos TV' ),
			'GT-S6352!'									=> array( 'Samsung', 'Galaxy Ace Duos' ),
			'GT-S6358!'									=> array( 'Samsung', 'Galaxy Ace' ),
			'GT-S6500!'									=> array( 'Samsung', 'Galaxy Mini 2' ),
			'GT-S6702!'									=> array( 'Samsung', 'Galaxy Y Duos' ),
			'GT-S6802!'									=> array( 'Samsung', 'Galaxy Ace Duos' ),
			'GT-S6810!'									=> array( 'Samsung', 'Galaxy Frame' ),
			'GT-S72(70|75)!'							=> array( 'Samsung', 'Galaxy Ace 3' ),
			'GT-S75(00|08)!'							=> array( 'Samsung', 'Galaxy Ace Plus' ),
			'GT-S7560!'									=> array( 'Samsung', 'Galaxy Ace II x' ),
			'GT-S75(62|68)!'							=> array( 'Samsung', 'Galaxy S Duos' ),
			'GT-S7572!'									=> array( 'Samsung', 'Galaxy Trend II Duos' ),
			'GT-S7710!'									=> array( 'Samsung', 'Galaxy Xcover 2' ),
			'GT-S8500'									=> array( 'Samsung', 'Wave' ),
			'GT-S8530'									=> array( 'Samsung', 'Wave II' ),
			'GT-S9081'									=> array( 'Samsung', 'GT-S9081' ),								// Unknown
			'GT-T959!'									=> array( 'Samsung', 'Galaxy S Vibrant' ),
			'SCH-i509'									=> array( 'Samsung', 'Galaxy Y' ),
			'SCH-i559'									=> array( 'Samsung', 'Galaxy Pop' ),
			'SCH-i569'									=> array( 'Samsung', 'Galaxy Gio' ),
			'SCH-i579'									=> array( 'Samsung', 'Galaxy Ace' ),
			'SCH-i589'									=> array( 'Samsung', 'Galaxy Ace Duos' ),
			'SCH-i705!'									=> array( 'Samsung', 'Galaxy Tab 2 (7.0)', TYPE_TABLET ),
			'SCH-i809'									=> array( 'Samsung', 'SCH-i809' ),
			'SCH-i889'									=> array( 'Samsung', 'Galaxy Note' ),
			'SCH-i909'									=> array( 'Samsung', 'Galaxy S' ),
			'SCH-i919'									=> array( 'Samsung', 'Galaxy S Duos' ),
			'SCH-i929'									=> array( 'Samsung', 'Galaxy S II Duos' ),
			'SCH-I100'									=> array( 'Samsung', 'Gem' ),
			'SCH-I110'									=> array( 'Samsung', 'Illusion' ),
			'SCH-I200( 4G)?$!'							=> array( 'Samsung', 'Galaxy Stellar' ),
			'SCH-I339'									=> array( 'Samsung', 'SCH-I339' ),
			'SCH-I400'									=> array( 'Samsung', 'Continuum' ),
			'SCH-I405( 4G)?$!'							=> array( 'Samsung', 'Stratosphere' ),
			'SCH-I405U'									=> array( 'Samsung', 'Galaxy Metrix' ),
			'SCH-I415( 4G)?$!'							=> array( 'Samsung', 'Stratosphere II' ),
			'SCH-I435'									=> array( 'Samsung', 'Galaxy S4 Mini' ),
			'SCH-I500'									=> array( 'Samsung', 'Fascinate' ),
			'SCH-I510'									=> array( 'Samsung', 'Stealth V' ),
			'SCH-I510 4G'								=> array( 'Samsung', 'Droid Charge' ),
			'SCH-I515'									=> array( 'Samsung', 'Galaxy Nexus' ),
			'SCH-I535!'									=> array( 'Samsung', 'Galaxy S III' ),
			'SCH-I545!'									=> array( 'Samsung', 'Galaxy S4' ),
			'SCH-I605'									=> array( 'Samsung', 'Galaxy Note II' ),
			'SCH-I619'									=> array( 'Samsung', 'SCH-I619' ),
			'SCH-I659'									=> array( 'Samsung', 'Galaxy Ace Plus' ),
			'SCH-I665'									=> array( 'Samsung', 'SCH-I665' ),								// Unknown
			'SCH-I699'									=> array( 'Samsung', 'Galaxy Trend' ),
			'SCH-I739'									=> array( 'Samsung', 'Galaxy Trend II' ),
			'SCH-I747'									=> array( 'Samsung', 'Galaxy S III' ),
			'SCH-I759'									=> array( 'Samsung', 'Galaxy Infinite' ),
			'SCH-I779'									=> array( 'Samsung', 'Saga' ),
			'SCH-I800'									=> array( 'Samsung', 'Galaxy Tab 7.0', TYPE_TABLET ),
			'SCH-I815!'									=> array( 'Samsung', 'Galaxy Tab 7.7', TYPE_TABLET ),
			'SCH-I829'									=> array( 'Samsung', 'Galaxy Style Duos' ),
			'SCH-I869'									=> array( 'Samsung', 'SCH-I869' ),
			'SCH-I879'									=> array( 'Samsung', 'Captivate' ),
			'SCH-I905!'									=> array( 'Samsung', 'Galaxy Tab 10.1', TYPE_TABLET ),
			'SCH-I909'									=> array( 'Samsung', 'Galaxy S' ),
			'SCH-I915!'									=> array( 'Samsung', 'Galaxy Tab 2 (10.1)', TYPE_TABLET ),
			'SCH-I919!'									=> array( 'Samsung', 'SCH-I919' ),
			'SCH-I925!'									=> array( 'Samsung', 'Galaxy Note 10.1', TYPE_TABLET ),
			'SCH-I939!'									=> array( 'Samsung', 'Galaxy S III' ),
			'SCH-I959'									=> array( 'Samsung', 'Galaxy S4' ),
			'SCH-L710'									=> array( 'Samsung', 'Galaxy S III' ),
			'SCH-M828!'									=> array( 'Samsung', 'Galaxy Precedent' ),
			'SCH-N719'									=> array( 'Samsung', 'Galaxy Note II' ),
			'SCH-P739'									=> array( 'Samsung', 'Galaxy Tab 8.9', TYPE_TABLET ),
			'SCH-R530!'									=> array( 'Samsung', 'Galaxy S III' ),
			'SCH-R680!'									=> array( 'Samsung', 'Repp' ),
			'SCH-R720!'									=> array( 'Samsung', 'Admire' ),
			'SCH-R730!'									=> array( 'Samsung', 'Transfix' ),
			'SCH-R740!'									=> array( 'Samsung', 'SCH-R740' ),
			'SCH-R760!'									=> array( 'Samsung', 'Galaxy S II' ),
			'SCH-R820!'									=> array( 'Samsung', 'Admire' ),
			'SCH-R830!'									=> array( 'Samsung', 'Axiom' ),
			'SCH-R880!'									=> array( 'Samsung', 'Acclaim' ),
			'SCH-R910!'									=> array( 'Samsung', 'Galaxy Indulge 4G' ),
			'SCH-R915!'									=> array( 'Samsung', 'Galaxy Indulge' ),
			'SCH-R920!'									=> array( 'Samsung', 'Galaxy Attain 4G' ),
			'SCH-R930!'									=> array( 'Samsung', 'Galaxy S Aviator' ),
			'SCH-R940!'									=> array( 'Samsung', 'Galaxy S Lightray' ),
			'SCH-R950!'									=> array( 'Samsung', 'Galaxy Note II' ),
			'SCH-R970!'									=> array( 'Samsung', 'Galaxy S4' ),
			'SCH-S720!'									=> array( 'Samsung', 'Galaxy Proclaim' ),
			'SCH-S735!'									=> array( 'Samsung', 'Galaxy Discover' ),
			'SCH-S738!'									=> array( 'Samsung', 'Galaxy Centura' ),
			'SCH-S950!'									=> array( 'Samsung', 'Galaxy S Showcase' ),
			'SCH-V727'									=> array( 'Samsung', 'Galaxy S4' ),
			'SCH-W789!'									=> array( 'Samsung', 'SCH-W789' ),
			'SCH-W799!'									=> array( 'Samsung', 'SCH-W799' ),
			'SCH-W899'									=> array( 'Samsung', 'SCH-W899' ),
			'SCH-W999'									=> array( 'Samsung', 'SCH-W999' ),
			'SCH-W2013'									=> array( 'Samsung', 'SCH-W2013' ),
			'SGH-E258'									=> array( 'Samsung', 'SGH-E258' ),
			'SGH-I317!'									=> array( 'Samsung', 'Galaxy Note II' ),
			'SGH-I337!'									=> array( 'Samsung', 'Galaxy S4' ),
			'SGH-I437!'									=> array( 'Samsung', 'Galaxy Express' ),
			'SGH-I467!'									=> array( 'Samsung', 'Galaxy Note 8.0', TYPE_TABLET ),
			'SGH-I497'									=> array( 'Samsung', 'Galaxy Tab 2 (10.1)', TYPE_TABLET ),
			'SGH-I527!'									=> array( 'Samsung', 'Galaxy Mega 6.3' ),
			'SGH-I537!'									=> array( 'Samsung', 'Galaxy S4 Active' ),
			'SGH-I547!'									=> array( 'Samsung', 'Galaxy Rugby Pro' ),
			'SGH-I577!'									=> array( 'Samsung', 'Galaxy Exhilarate' ),	
			'SGH-I717!'									=> array( 'Samsung', 'Galaxy Note' ),
			'SGH-I727'									=> array( 'Samsung', 'Galaxy S II Skyrocket' ),
			'SGH-I727R'									=> array( 'Samsung', 'Galaxy S II' ),
			'SGH-I7(47|48)!'							=> array( 'Samsung', 'Galaxy S III' ),
			'SGH-I757!'									=> array( 'Samsung', 'Galaxy S II Skyrocket HD' ),
			'SGH-I9?777!'								=> array( 'Samsung', 'Galaxy S II' ),
			'SGH-I827!'									=> array( 'Samsung', 'Galaxy Ace Q' ),
			'SGH-I847'									=> array( 'Samsung', 'Rugby Smart' ),
			'SGH-I857'									=> array( 'Samsung', 'DoubleTime' ),
			'SGH-I8(96|97)!'							=> array( 'Samsung', 'Captivate' ),
			'SGH-I927!'									=> array( 'Samsung', 'Captivate Glide' ),
			'SGH-I957!'									=> array( 'Samsung', 'Galaxy Tab 8.9', TYPE_TABLET ),
			'SGH-I987'									=> array( 'Samsung', 'Galaxy Tab 7.0', TYPE_TABLET ),
			'SGH-I997'									=> array( 'Samsung', 'Infuse 4G' ),
			'SGH-I997R'									=> array( 'Samsung', 'Infuse 4G' ),
			'SGH-I9000'									=> array( 'Samsung', 'Galaxy S' ),
			'SGH-I9300'									=> array( 'Samsung', 'Galaxy S III' ),
			'SGH-M919!'									=> array( 'Samsung', 'Galaxy S4' ),
			'SGH-S730!'									=> array( 'Samsung', 'Galaxy Discover' ),
			'SGH-S959G'									=> array( 'Samsung', 'Galaxy S II' ),
			'SGH-T499'									=> array( 'Samsung', 'Dart' ),
			'SGH-T499[VY]!'								=> array( 'Samsung', 'Galaxy Mini' ),
			'SGH-T589!'									=> array( 'Samsung', 'Gravity Smart' ),
			'SGH-T599!'									=> array( 'Samsung', 'Exhibit' ),	
			'SGH-T679!'									=> array( 'Samsung', 'Exhibit II 4G' ),
			'SGH-T699'									=> array( 'Samsung', 'S Blaze Q' ),
			'SGH-T759'									=> array( 'Samsung', 'Exhibit 4G' ),
			'SGH-T769'									=> array( 'Samsung', 'Galaxy S Blaze 4G' ),
			'SGH-T779'									=> array( 'Samsung', 'Galaxy Tab 2 (10.1)', TYPE_TABLET ),
			'SGH-T839'									=> array( 'Samsung', 'T-Mobile Sidekick' ),
			'SGH-T849'									=> array( 'Samsung', 'Galaxy Tab 7.0', TYPE_TABLET ),
			'SGH-T859'									=> array( 'Samsung', 'Galaxy Tab 10.1', TYPE_TABLET ),
			'SGH-T869'									=> array( 'Samsung', 'Galaxy Tab 7.0 Plus', TYPE_TABLET ),
			'SGH-T879'									=> array( 'Samsung', 'Galaxy Note' ),
			'SGH-T889!'									=> array( 'Samsung', 'Galaxy Note II' ),
			'SGH-T959'									=> array( 'Samsung', 'Vibrant' ),
			'SGH-T959D'									=> array( 'Samsung', 'Galaxy S Fascinate 3G+' ),
			'SGH-T959P'									=> array( 'Samsung', 'Galaxy S Fascinate 4G' ),
			'SGH-T959V'									=> array( 'Samsung', 'Galaxy S 4G' ),
			'SGH-T959W'									=> array( 'Samsung', 'Galaxy S 4G' ),
			'SGH-T989'									=> array( 'Samsung', 'Galaxy S II' ),
			'SGH-T989D'									=> array( 'Samsung', 'Galaxy S II X' ),
			'SGH-T999!'									=> array( 'Samsung', 'Galaxy S Blaze 4G' ),
			'SHV-E120!'									=> array( 'Samsung', 'Galaxy S II HD LTE' ),
			'SHV-E110!'									=> array( 'Samsung', 'Galaxy S II LTE' ),
			'SHV-E140!'									=> array( 'Samsung', 'Galaxy Tab 8.9', TYPE_TABLET ),
			'SHV-E150!'									=> array( 'Samsung', 'Galaxy Tab 7.7', TYPE_TABLET ),
			'SHV-E160!'									=> array( 'Samsung', 'Galaxy Note' ),
			'SHV-E170!'									=> array( 'Samsung', 'Galaxy R' ),
			'SHV-E210!'									=> array( 'Samsung', 'Galaxy S III' ),
			'SHV-E220!'									=> array( 'Samsung', 'Galaxy Pop' ),
			'SHV-E230!'									=> array( 'Samsung', 'Galaxy Note 10.1', TYPE_TABLET ),
			'SHV-E250!'									=> array( 'Samsung', 'Galaxy Note II' ),
			'SHV-E270!'									=> array( 'Samsung', 'Galaxy Grand' ),
			'SHV-E300!'									=> array( 'Samsung', 'Galaxy S4' ),
			'SHV-E310!'									=> array( 'Samsung', 'Galaxy Mega 6.3' ),
			'SHV-E330!'									=> array( 'Samsung', 'Galaxy S4' ),
			'SHV-E370!'									=> array( 'Samsung', 'Galaxy S4 Mini' ),
			'SHV-E400!'									=> array( 'Samsung', 'SHV-E400' ), 								// Unknown, same as SHV-E400, SHW-M550 and SM-G730
			'SHW-M100!'									=> array( 'Samsung', 'Galaxy A' ),
			'SHW-M110!'									=> array( 'Samsung', 'Galaxy S' ),
			'SHW-M130L!'								=> array( 'Samsung', 'Galaxy U' ),
			'SHW-M130K!'								=> array( 'Samsung', 'Galaxy K' ),
			'SHW-M1(80|85)!'							=> array( 'Samsung', 'Galaxy Tab', TYPE_TABLET ),
			'SHW-M190!'									=> array( 'Samsung', 'Galaxy S Hoppin' ),
			'SHW-M220!'									=> array( 'Samsung', 'Galaxy Neo' ),
			'SHW-M240!'									=> array( 'Samsung', 'Galaxy Ace' ),
			'SHW ?-M250!'								=> array( 'Samsung', 'Galaxy S II' ),
			'SHW-M290K'									=> array( 'Samsung', 'Galaxy Gio' ),
			'SHW-M300!'									=> array( 'Samsung', 'Galaxy Tab 10.1', TYPE_TABLET ),
			'SHW-M305!'									=> array( 'Samsung', 'Galaxy Tab 8.9', TYPE_TABLET ),
			'SHW-M340!'									=> array( 'Samsung', 'Galaxy M Style' ),
			'SHW-M380!'									=> array( 'Samsung', 'Galaxy Tab 10.1', TYPE_TABLET ),
			'SHW-M420!'									=> array( 'Samsung', 'Galaxy Nexus' ),
			'SHW-M440!'									=> array( 'Samsung', 'Galaxy S III' ),
			'SHW-M4(80|85)!'							=> array( 'Samsung', 'Galaxy Note 10.1', TYPE_TABLET ),
			'SHW-M500!'									=> array( 'Samsung', 'Galaxy Note 8.0', TYPE_TABLET ),
			'SHW-M550!'									=> array( 'Samsung', 'SHW-M550' ), 								// Unknown, same as SHV-E400, SHW-M550 and SM-G730
			'SMT-E5015'									=> array( 'Samsung', 'SMT-E5015', TYPE_TELEVISION ),
			'SMT-i9100'									=> array( 'Samsung', 'SMT-I9100', TYPE_TABLET ),
			'SM-C101!'									=> array( 'Samsung', 'Galaxy S4 Zoom' ),
			'SM-G730!'									=> array( 'Samsung', 'SM-G730' ), 								// Unknown, same as SHV-E400, SHW-M550 and SM-G730
			'SM-N900!'									=> array( 'Samsung', 'Galaxy Note 3' ),
			'SM-T2(10|11|17)!'							=> array( 'Samsung', 'Galaxy Tab 3 (7.0)', TYPE_TABLET ),
			'SM-T3(10|11)!'								=> array( 'Samsung', 'Galaxy Tab 3 (8.0)', TYPE_TABLET ),
			'SPH-D600'									=> array( 'Samsung', 'Conquer 4G' ),
			'SPH-D700'									=> array( 'Samsung', 'Epic 4G' ),
			'SPH-D705'									=> array( 'Samsung', 'Epic 4G 2' ),
			'SPH-D710!'									=> array( 'Samsung', 'Epic 4G Touch' ),
			'SPH-L300'									=> array( 'Samsung', 'Galaxy Victory 4G LTE' ),
			'SPH-L520'									=> array( 'Samsung', 'SPH-L520' ),								// Unknown, maybe Galaxy S4 Mini for Sprint?
			'SPH-L700'									=> array( 'Samsung', 'Galaxy Nexus' ),
			'SPH-L710'									=> array( 'Samsung', 'Galaxy S III' ),
			'SPH-L720'									=> array( 'Samsung', 'Galaxy S4' ),
			'SPH-L900'									=> array( 'Samsung', 'Galaxy Note II' ),
			'SPH-M820!'									=> array( 'Samsung', 'Galaxy Prevail' ),
			'SPH-M830'									=> array( 'Samsung', 'Galaxy Rush' ),
			'SPH-M580!'									=> array( 'Samsung', 'Replenish' ),
			'SPH-M900'									=> array( 'Samsung', 'Moment' ),
			'SPH-M910'									=> array( 'Samsung', 'Intercept' ),
			'SPH-M920'									=> array( 'Samsung', 'Transform' ),
			'SPH-M930!'									=> array( 'Samsung', 'Transform Ultra' ),
			'SPH-M950'									=> array( 'Samsung', 'Galaxy Reverb' ),
			'SPH-P100'									=> array( 'Samsung', 'Galaxy Tab', TYPE_TABLET ),
			'SPH-P500'									=> array( 'Samsung', 'Galaxy Tab 2 10.1', TYPE_TABLET ),
			'YP-GB1'									=> array( 'Samsung', 'Galaxy Player', 'media' ),
			'YP-GB70'									=> array( 'Samsung', 'Galaxy Player 70', 'media' ),
			'YP-GB70D'									=> array( 'Samsung', 'Galaxy Player 70 Plus', 'media' ),
			'YP-GP1'									=> array( 'Samsung', 'Galaxy Player 5.8', 'media' ),
			'YP-GS1'									=> array( 'Samsung', 'Galaxy S WiFi 3.6', 'media' ),
			'YP-G1'										=> array( 'Samsung', 'Galaxy S WiFi 4.0', 'media' ),
			'YP-GI1'									=> array( 'Samsung', 'Galaxy S WiFi 4.2', 'media' ),
			'YP-G50'									=> array( 'Samsung', 'Galaxy Player', 'media' ),
			'YP-G70'									=> array( 'Samsung', 'Galaxy S WiFi 5.0', 'media' ),
			'GT9100'									=> array( 'Samsung', 'Galaxy S II' ),
			'I897'										=> array( 'Samsung', 'Captivate' ),
			'I7500'										=> array( 'Samsung', 'Galaxy' ),
			'I9000'										=> array( 'Samsung', 'Galaxy S' ),
			'T959'										=> array( 'Samsung', 'Galaxy S Vibrant' ),
			'Captivate-I897'							=> array( 'Samsung', 'Captivate' ),
			'Galaxy'									=> array( 'Samsung', 'Galaxy' ),
			'Galaxy ACE'								=> array( 'Samsung', 'Galaxy Ace' ),
			'Galaxy Mini'								=> array( 'Samsung', 'Galaxy Mini' ),
			'Galaxy Mini Plus 4G'						=> array( 'Samsung', 'Galaxy Mini Plus' ),
			'Galaxy Note'								=> array( 'Samsung', 'Galaxy Note' ),
			'Galaxy Note II'							=> array( 'Samsung', 'Galaxy Note II' ),
			'GalaxyS'									=> array( 'Samsung', 'Galaxy S' ),
			'Galaxy S II'								=> array( 'Samsung', 'Galaxy S II' ),
			'Galaxy S III'								=> array( 'Samsung', 'Galaxy S III' ),
			'Galaxy X'									=> array( 'Samsung', 'Galaxy X' ),
			'Galaxy Spica'								=> array( 'Samsung', 'Galaxy Spica' ),
			'Galaxy pop plus 4G'						=> array( 'Samsung', 'Galaxy Pop Plus' ),
			'Galaxy Precedent'							=> array( 'Samsung', 'Galaxy Precedent' ),
			'GALAXY Tab'								=> array( 'Samsung', 'Galaxy Tab', TYPE_TABLET ),
			'Vibrantmtd'								=> array( 'Samsung', 'Vibrant' ),
			'Vibrant T959'								=> array( 'Samsung', 'Vibrant' ),
			'SC-01C'									=> array( 'Samsung', 'Galaxy Tab', TYPE_TABLET ),
			'SC-01D'									=> array( 'Samsung', 'Galaxy Tab 10.1 LTE', TYPE_TABLET ),
			'SC-01E'									=> array( 'Samsung', 'Galaxy Tab 7.7 Plus', TYPE_TABLET ),
			'SC-02B'									=> array( 'Samsung', 'Galaxy S' ),
			'SC-02C'									=> array( 'Samsung', 'Galaxy S II' ),
			'SC-02D'									=> array( 'Samsung', 'Galaxy Tab 7.0 Plus', TYPE_TABLET ),
			'SC-02E'									=> array( 'Samsung', 'Galaxy Note II' ),
			'SC-03D'									=> array( 'Samsung', 'Galaxy S II LTE' ),
			'SC-03E'									=> array( 'Samsung', 'Galaxy S III α' ),
			'SC-04D'									=> array( 'Samsung', 'Galaxy Nexus' ),
			'SC-04E'									=> array( 'Samsung', 'Galaxy S4' ),
			'SC-05D'									=> array( 'Samsung', 'Galaxy Note LTE' ),
			'SC-06D'									=> array( 'Samsung', 'Galaxy S III' ),
			'SCL21'										=> array( 'Samsung', 'Galaxy S III Progre' ),
			'ISW11SC'									=> array( 'Samsung', 'Galaxy S II WiMAX' ),
			'ELEMENT7V2'								=> array( 'Sencor', 'Element 7 V2', TYPE_TABLET ),
			'Bambook S1'								=> array( 'Shanda', 'Bambook S1', TYPE_TABLET ),
			'A01SH'										=> array( 'Sharp', 'A01SH' ),
			'IS01'										=> array( 'Sharp', 'IS01' ),
			'IS03'										=> array( 'Sharp', 'IS03' ),
			'IS05'										=> array( 'Sharp', 'IS05' ),
			'IS11SH'									=> array( 'Sharp', 'Aquos IS11SH' ),
			'IS12SH'									=> array( 'Sharp', 'Aquos IS12SH' ),
			'IS13SH'									=> array( 'Sharp', 'Aquos IS13SH' ),
			'IS14SH'									=> array( 'Sharp', 'Aquos IS14SH' ),
			'IS15SH'									=> array( 'Sharp', 'Aquos IS15SH' ),
			'ISW16SH'									=> array( 'Sharp', 'Aquos ISW16SH' ),
			'IS17SH'									=> array( 'Sharp', 'Aquos CL IS17SH' ),
			'EB-W51GJ'									=> array( 'Sharp', 'EB-W51GJ' ),
			'SBM003SH'									=> array( 'Sharp', 'Galapagos' ),
			'SBM005SH'									=> array( 'Sharp', 'Galapagos' ),
			'SBM006SH'									=> array( 'Sharp', 'Aquos' ),
			'SBM007SH'									=> array( 'Sharp', 'Aquos 007SH' ),
			'SBM009SH'									=> array( 'Sharp', 'Aquos 009SH' ),
			'SBM009SHY'									=> array( 'Sharp', 'Yahoo! Phone' ),
			'SBM102SH'									=> array( 'Sharp', 'Aquos 102SH' ),
			'SBM103SH'									=> array( 'Sharp', 'Aquos 103SH' ),
			'SBM104SH'									=> array( 'Sharp', 'Aquos 104SH' ),
			'SBM106SH'									=> array( 'Sharp', 'Aquos 106SH' ),
			'SBM107SH'									=> array( 'Sharp', 'Aquos 107SH' ),
			'SBM107SHB'									=> array( 'Sharp', 'Aquos 107SH' ),
			'SBM200SH'									=> array( 'Sharp', 'PANTONE 6 200SH' ),
			'SBM203SH'									=> array( 'Sharp', 'Aquos Xx 203SH' ),
			'SBM204SH'									=> array( 'Sharp', 'Aquos 204SH' ),
			'SH-01D'									=> array( 'Sharp', 'Aquos SH-01D' ),
			'SH-01E'									=> array( 'Sharp', 'Aquos si SH-01E' ),
			'SH-02D'									=> array( 'Sharp', 'Aquos slider SH-02D' ),
			'SH-02E'									=> array( 'Sharp', 'Aquos Zeta SH-02E' ),
			'SH-03C'									=> array( 'Sharp', 'Lynx 3D' ),
			'SH-04E'									=> array( 'Sharp', 'Aquos EX SH-04E' ),
			'SH-06D'									=> array( 'Sharp', 'Aquos SH-06D' ),
			'SH-06DNERV'								=> array( 'Sharp', 'NERV SH-06D' ),
			'SH-06E'									=> array( 'Sharp', 'Aquos Zeta SH-06E' ),
			'SH-07C'									=> array( 'Sharp', 'Galapagos SH-07C' ),
			'SH-07D'									=> array( 'Sharp', 'Aquos st SH-07D' ),
			'SH-09D'									=> array( 'Sharp', 'Aquos Zeta SH-09D' ),
			'SH-10B'									=> array( 'Sharp', 'Lynx' ),
			'SH-10D'									=> array( 'Sharp', 'Aquos sv SH-10D' ),
			'SH-12C'									=> array( 'Sharp', 'Aquos' ),
			'SH-13C'									=> array( 'Sharp', 'Aquos f SH-13C' ),
			'SH80F'										=> array( 'Sharp', 'Aquos SH80F' ),
			'SH530U'									=> array( 'Sharp', 'SH530U' ),
			'SH-631M'									=> array( 'Sharp', 'SH631M' ),
			'SH631W'									=> array( 'Sharp', 'SH631W' ),
			'SH837W'									=> array( 'Sharp', 'SH837W' ),
			'SH930W'									=> array( 'Sharp', 'SH930W' ),
			'SH931W'									=> array( 'Sharp', 'SH931W' ),
			'SH72x8U'									=> array( 'Sharp', 'SH72x8U' ),
			'SH8118U'									=> array( 'Sharp', 'SH8118U' ),
			'SH8128U'									=> array( 'Sharp', 'SH8128U' ),
			'SH8158U'									=> array( 'Sharp', 'SH8158U' ),
			'SH8168U'									=> array( 'Sharp', 'SH8168U' ),
			'SH8188U'									=> array( 'Sharp', 'SH8188U' ),
			'SH8268U'									=> array( 'Sharp', 'SH8268U' ),
			'SH8298U'									=> array( 'Sharp', 'SH8298U' ),
			'SHL21'										=> array( 'Sharp', 'Aquos Serie SHL21' ),
			'SHL22'										=> array( 'Sharp', 'Aquos Serie SHL22' ),
			'SHT21'										=> array( 'Sharp', 'Aquos Pad SHT21', TYPE_TABLET ),
			'INFOBAR C01'								=> array( 'Sharp', 'INFOBAR C01' ),
			'SPX-5'										=> array( 'Simvalley', 'SPX-5' ),
			'SPX-5 3G'									=> array( 'Simvalley', 'SPX-5 3G' ),
			'SPX-12'									=> array( 'Simvalley', 'SPX-12' ),
			'Skyworth PE90'								=> array( 'Skyworth', 'PE90' ),
			'Andromax U'								=> array( 'Smartfren', 'Andromax U' ),
			'Smartfren Tab 7'							=> array( 'Smartfren', 'Tab 7' ),
			'SmartQ G7'									=> array( 'SmartQ', 'G7', TYPE_TABLET ),
			'SmartQT7'									=> array( 'SmartQ', 'T7', TYPE_TABLET ),
			'SmartQT10'									=> array( 'SmartQ', 'T10', TYPE_TABLET ),
			'SmartQT15'									=> array( 'SmartQ', 'T15', TYPE_TABLET ),
			'SmartQT19'									=> array( 'SmartQ', 'T19', TYPE_TABLET ),
			'SmartQT20'									=> array( 'SmartQ', 'T20', TYPE_TABLET ),
			'T20'										=> array( 'SmartQ', 'T20', TYPE_TABLET ),
			'T30'										=> array( 'SmartQ', 'T30', TYPE_TABLET ),
			'OMS1 6'									=> array( 'Sony Ericsson', 'A8i' ),
			'C15(04|05)!'								=> array( 'Sony', 'Xperia E' ),							// NanHu
			'C16(04|05)!'								=> array( 'Sony', 'Xperia E dual' ),					// NanHu	
			'C19(04|05)!'								=> array( 'Sony', 'Xperia M' ),							// ...
			'C20(04|05)!'								=> array( 'Sony', 'Xperia M dual' ),					// ...		
			'C21(04|05)!'								=> array( 'Sony', 'Xperia L' ),							// TaoShan
			'C3602'										=> array( 'Sony', 'Xperia Z Ultra' ),					// Togari
			'C53(02|03|06)!'							=> array( 'Sony', 'Xperia SP' ),						// HuaShan
			'C550[0-9]!'								=> array( 'Sony', 'Xperia ZR' ),						// Dogo
			'C65(02|03|06)!'							=> array( 'Sony', 'Xperia ZL' ),						// Odin
			'C66(02|03|06)!'							=> array( 'Sony', 'Xperia Z' ),							// Yuga
			'C670[0-9]!'								=> array( 'Sony', 'Xperia "Honami"' ),					// Honami
			'C6802'										=> array( 'Sony', 'Xperia UL' ),						// Gaga
			'C69(02|03|07)!'							=> array( 'Sony', 'Xperia Tablet Z', TYPE_TABLET ),		// Pollux
			'E10(a|i|iv)!'								=> array( 'Sony Ericsson', 'Xperia X10 Mini' ),			// Robyn
			'E15(a|i|iv|i-o)?$!'						=> array( 'Sony Ericsson', 'Xperia X8' ),				// Shakira
			'E16i!'										=> array( 'Sony Ericsson', 'W8 Walkman' ),				// Shakira Walkman
			'L35h'										=> array( 'Sony', 'Xperia ZL' ),						// Odin
			'L36h'										=> array( 'Sony', 'Xperia Z' ),							// Yuga
			'LT11i!'									=> array( 'Sony Ericsson', 'Xperia Neo V' ),			// Haida
			'LT15(a|i|iv|i-o)?$!'						=> array( 'Sony Ericsson', 'Xperia Arc' ),				// Anzu
			'LT15i Speed Edition'						=> array( 'Sony Ericsson', 'Xperia Arc' ),				// Anzu
			'LT18(a|i|iv|i-o)?$!'						=> array( 'Sony Ericsson', 'Xperia Arc S' ),			// Ayame
			'LT22i!'									=> array( 'Sony', 'Xperia P' ),							// Nypon
			'LT25i!'									=> array( 'Sony', 'Xperia V' ),							// Tsubasa
			'LT25c!'									=> array( 'Sony', 'Xperia VC' ),						// Tsubasa
			'LT26(i|i-o)!'								=> array( 'Sony', 'Xperia S' ),							// Nozomi
			'LT26ii!'									=> array( 'Sony', 'Xperia SL' ),						// Nozomi2
			'LT26w!'									=> array( 'Sony', 'Xperia Acro S' ),					// Hikari
			'LT28(at|h|i)!'								=> array( 'Sony', 'Xperia Ion' ),						// Aoba
			'LT29i!'									=> array( 'Sony', 'Xperia TX' ),						// Hayabusa
			'LT30(at)!'									=> array( 'Sony', 'Xperia TL' ),						// Mint
			'LT30(a|p)!'								=> array( 'Sony', 'Xperia T' ),							// Mint
			'M35(t)!'									=> array( 'Sony', 'Xperia SP' ),						// HuaShan
			'MK16(a|i)!'								=> array( 'Sony Ericsson', 'Xperia Pro' ),				// Iyokan
			'MT11(a|i|iv|i-o)!'							=> array( 'Sony Ericsson', 'Xperia Neo V' ),			// Haida
			'MT15(a|i|iv|i-o)!'							=> array( 'Sony Ericsson', 'Xperia Neo' ),				// Hallon
			'MT25i!'									=> array( 'Sony', 'Xperia Neo L' ),						// Phoenix
			'MT27i!'									=> array( 'Sony', 'Xperia Sola' ),						// Pepper
			'R800(a|at|i|iv|x)!'						=> array( 'Sony Ericsson', 'Xperia Play' ),				// Zeus
			'S36h'										=> array( 'Sony', 'Xperia L' ),							// TaoShan
			'S39h'										=> array( 'Sony', 'Xperia C' ),							// CN3
			'SK17(a|i|iv|i-o)!'							=> array( 'Sony Ericsson', 'Xperia Mini Pro' ),			// Mango
			'ST15(a|i)!'								=> array( 'Sony Ericsson', 'Xperia Mini' ),				// Smultron
			'ST17(a|i)!'								=> array( 'Sony Ericsson', 'Xperia Active' ),			// Satsuma
			'ST18(a|av|i|iv)?!'							=> array( 'Sony Ericsson', 'Xperia Ray' ),				// Urushi
			'ST21(a|i|i-o|iv)?$!'						=> array( 'Sony', 'Xperia Tipo' ),						// Tapioca
			'ST21(a2|i2)!'								=> array( 'Sony', 'Xperia Tipo Dual' ),					// Tapioca
			'ST23(a|i)!'								=> array( 'Sony', 'Xperia Miro' ),						// Mesona
			'ST25(a|i)!'								=> array( 'Sony', 'Xperia U' ),							// Kumquat
			'ST26(a|i)?!'								=> array( 'Sony', 'Xperia J' ),							// JLo
			'ST27(a|i)!'								=> array( 'Sony', 'Xperia Go' ),						// Lotus
			'U20(a|i|iv)!'								=> array( 'Sony Ericsson', 'Xperia X10 Mini Pro' ),		// Mimmi
			'WT13i!'									=> array( 'Sony Ericsson', 'Mix Walkman' ),				// Shijia
			'WT18i!'									=> array( 'Sony Ericsson', 'Walkman' ),					// Mulberry
			'WT19(a|i|iv)!'								=> array( 'Sony Ericsson', 'Live with Walkman' ),		// Coconut
			'X8'										=> array( 'Sony Ericsson', 'Xperia X8' ),				// Shakira
			'X10(a|i|iv|i-o|s)?$!'						=> array( 'Sony Ericsson', 'Xperia X10' ),				// Rachael
			'X10 ?(Mini Pro)$!'							=> array( 'Sony Ericsson', 'Xperia X10 Mini Pro' ),		// Mimmi
			'X10 ?(Mini)$!'								=> array( 'Sony Ericsson', 'Xperia X10 Mini' ),			// Robyn
			'Z1i'										=> array( 'Sony Ericsson', 'Xperia Play' ),				// Zeus
			'S51SE'										=> array( 'Sony Ericsson', 'Xperia Mini' ),				// Smultron
			'IS11S'										=> array( 'Sony Ericsson', 'Xperia Acro' ),				// Akane
			'IS12S'										=> array( 'Sony Ericsson', 'Xperia Acro HD' ),			// Hayate
			'SO-01B'									=> array( 'Sony Ericsson', 'Xperia X10' ),				// Rachael
			'SO-01C'									=> array( 'Sony Ericsson', 'Xperia Arc' ),				// Anzu
			'SO-01D'									=> array( 'Sony Ericsson', 'Xperia Play' ),				// Zeus
			'SO-01E'									=> array( 'Sony', 'Xperia AX' ),						// Tsubasa
			'SO-02C'									=> array( 'Sony Ericsson', 'Xperia Acro' ),				// Azusa
			'SO-02D'									=> array( 'Sony Ericsson', 'Xperia NX' ),				// Nozomi
			'SO-02E'									=> array( 'Sony', 'Xperia Z' ),							// Yuga
			'SO-03C'									=> array( 'Sony Ericsson', 'Xperia Ray' ),				// Urushi
			'SO-03D'									=> array( 'Sony Ericsson', 'Xperia Acro HD' ),			// Hikari
			'SO-03E'									=> array( 'Sony', 'Xperia Tablet Z', TYPE_TABLET ),		// Pollux
			'SO-04D'									=> array( 'Sony', 'Xperia GX' ),						// Hayabusa
			'SO-04E'									=> array( 'Sony', 'Xperia A' ),							// Dogo
			'SO-05D'									=> array( 'Sony', 'Xperia SX' ),						// Komachi
			'SOL21'										=> array( 'Sony', 'Xperia VL' ),						// Surf
			'SOL22'										=> array( 'Sony', 'Xperia UL' ),						// Gaga
			'Xperia X1'									=> array( 'Sony Ericsson', 'Xperia X1' ),
			'Xperia X8'									=> array( 'Sony Ericsson', 'Xperia X8' ),				// Shakira
			'Xperia X10'								=> array( 'Sony Ericsson', 'Xperia X10' ),				// Rachael
			'Xperia Acro S'								=> array( 'Sony', 'Xperia Acro S' ),					// Hikari
			'Xperia Active'								=> array( 'Sony Ericsson', 'Xperia Active' ),			// Satsuma
			'Xperia Arc'								=> array( 'Sony Ericsson', 'Xperia Arc' ),				// Anzu
			'Xperia Arc S'								=> array( 'Sony Ericsson', 'Xperia Arc S' ),			// Ayame
			'Xperia Go'									=> array( 'Sony', 'Xperia Go' ),						// Lotus
			'Xperia ion'								=> array( 'Sony', 'Xperia Ion' ),						// Aoba
			'Xperia J'									=> array( 'Sony', 'Xperia J' ),							// JLo
			'Xperia Miro'								=> array( 'Sony', 'Xperia Miro' ),						// Mesona
			'Xperia Mini'								=> array( 'Sony Ericsson', 'Xperia Mini' ),				// Smultron
			'Xperia Mini Pro'							=> array( 'Sony Ericsson', 'Xperia Mini Pro' ),			// Mango
			'Xperia Neo'								=> array( 'Sony Ericsson', 'Xperia Neo' ),				// Hallon
			'Xperia NeoV'								=> array( 'Sony Ericsson', 'Xperia Neo V' ),			// Haida
			'Xperia Neo V'								=> array( 'Sony Ericsson', 'Xperia Neo V' ),			// Haida
			'Xperia Neo L'								=> array( 'Sony', 'Xperia Neo L' ),						// Phoenix
			'Xperia P'									=> array( 'Sony', 'Xperia P' ),							// Nypon
			'Xperia Play'								=> array( 'Sony Ericsson', 'Xperia Play' ),				// Zeus
			'Xperia Pro'								=> array( 'Sony Ericsson', 'Xperia Pro' ),				// Iyokan
			'Xperia Ray'								=> array( 'Sony Ericsson', 'Xperia Ray' ),				// Urushi
			'Xperia S'									=> array( 'Sony', 'Xperia S' ),							// Nozomi
			'Xperia SL'									=> array( 'Sony', 'Xperia SL' ),						// Nozomi2
			'Xperia Sola'								=> array( 'Sony', 'Xperia Sola' ),						// Pepper
			'Xperia T'									=> array( 'Sony', 'Xperia T' ),							// Mint
			'Xperia Tipo'								=> array( 'Sony', 'Xperia Tipo' ),						// Tapioca
			'Xperia U'									=> array( 'Sony', 'Xperia U' ),							// Kumquat
			'Xperia Z'									=> array( 'Sony', 'Xperia Z' ),							// Yuga
			'Xperia Live with Walkman'					=> array( 'Sony Ericsson', 'Live with Walkman' ),		// Coconut
			'Live ?With ?Walkman!'						=> array( 'Sony Ericsson', 'Live with Walkman' ),		// Coconut
			'Neo V'										=> array( 'Sony Ericsson', 'Xperia Neo V' ),			// Haida
			'Hayabusa'									=> array( 'Sony', 'Xperia GX or TX' ),					// Hayabusa
			'Nozomi'									=> array( 'Sony', 'Xperia S' ),							// Nozomi
			'Tablet P'									=> array( 'Sony', 'Tablet P', TYPE_TABLET ),
			'Tablet S'									=> array( 'Sony', 'Tablet S', TYPE_TABLET ),
			'SGPT12'									=> array( 'Sony', 'Xperia Tablet S', TYPE_TABLET ),
			'SGPT13'									=> array( 'Sony', 'Xperia Tablet S', TYPE_TABLET ),
			'SGP311'									=> array( 'Sony', 'Xperia Tablet Z', TYPE_TABLET ),
			'SGP312'									=> array( 'Sony', 'Xperia Tablet Z', TYPE_TABLET ),
			'SGP321'									=> array( 'Sony', 'Xperia Tablet Z', TYPE_TABLET ),
			'NWZ?-Z1000Series!'							=> array( 'Sony', 'Walkman Z', TYPE_MEDIA ),
			'NSZ-GP9'									=> array( 'Sony', 'NSZ-GP9', TYPE_TELEVISION, FLAG_GOOGLETV ),
			'NSZ-GS7'									=> array( 'Sony', 'NSZ-GS7', TYPE_TELEVISION, FLAG_GOOGLETV ),
			'NSZ-GT1'									=> array( 'Sony', 'NSZ-GT1', TYPE_TELEVISION, FLAG_GOOGLETV ),
			'Spice Mi280'								=> array( 'Spice', 'Mi-280' ),
			'SPICE Mi-285'								=> array( 'Spice', 'Mi-285' ),
			'Spice Mi300'								=> array( 'Spice', 'Mi-300' ),
			'CSL Spice MI300'							=> array( 'Spice', 'Mi-300' ),
			'Spice Mi-310'								=> array( 'Spice', 'Mi-310' ),
			'Mi320'										=> array( 'Spice', 'Mi-320' ),
			'Spice Mi-350'								=> array( 'Spice', 'Mi-350' ),
			'Spice MI352'								=> array( 'Spice', 'Mi-352' ),
			'Spice Mi-355'								=> array( 'Spice', 'Mi-355' ),
			'CSL-MI410'									=> array( 'Spice', 'Mi-410' ),
			'Spice Mi-425'								=> array( 'Spice', 'Mi-425' ),
			'Spice Mi-435'								=> array( 'Spice', 'Mi-435' ),
			'Spice Mi-495'								=> array( 'Spice', 'Mi-495' ),
			'Spice Mi-500'								=> array( 'Spice', 'Mi-500' ),
			'Mi501'										=> array( 'Spice', 'Mi-501' ),
			'Spice Mi-530'								=> array( 'Spice', 'Mi-530' ),
			'Spice Mi-535'								=> array( 'Spice', 'Mi-535' ),
			'SPICE Mi-720'								=> array( 'Spice', 'Mi-720' ),
			'SpiceMi1010'								=> array( 'Spice', 'Mi-1010 Stellar Pad', TYPE_TABLET ),
			'A5000'										=> array( 'Star', 'A5000' ),
			'A7272+'									=> array( 'Star', 'A7272+' ),
			'N710'										=> array( 'Star', 'N710' ),
			'e1808 v75!'								=> array( 'Star', 'N8000' ),
			'V1277'										=> array( 'Star', 'V1277' ),
			'e1109 v73!'								=> array( 'Star', 'X18i' ),
			'Starmobile ASTRA'							=> array( 'Starmobile', 'Astra' ),
			'Starmobile CRYSTAL'						=> array( 'Starmobile', 'Crystal' ),
			'Starmobile ENERGY'							=> array( 'Starmobile', 'Energy' ),
			'eZee\'Tab10c'								=> array( 'Storex', 'eZee\'Tab 10c', TYPE_TABLET ),
			'eZee\'Tab703'								=> array( 'Storex', 'eZee\'Tab 703', TYPE_TABLET ),
			'eZee\'TAB707'								=> array( 'Storex', 'eZee\'Tab 707', TYPE_TABLET ),
			'eZee\'Tab803'								=> array( 'Storex', 'eZee\'Tab 803', TYPE_TABLET ),
			'eZee\'Tab1001'								=> array( 'Storex', 'eZee\'Tab 1001', TYPE_TABLET ),
			'Cyclone Voyager'							=> array( 'Sumvision', 'Cyclone Voyager', TYPE_TABLET ),
			'M1001'										=> array( 'Superpad', 'M1001', TYPE_TABLET ),
			'TS1004T'									=> array( 'Surf 3Q', 'TS1004T', TYPE_TABLET ),
			'Fablet F3'									=> array( 'Swipe', 'Fablet F3' ),
			'SYTABEX7-2'								=> array( 'Sylvania', 'SYTABEX7', TYPE_TABLET ),
			'Synrgic Uno M1'							=> array( 'Synrgic', 'Uno M1' ),
			'KM-S200'									=> array( 'TAKE', 'Janus KM-S200' ),
			'TCL A506'									=> array( 'TCL', 'A506' ),
			'TCL A860'									=> array( 'TCL', 'A860' ),
			'TCL A906'									=> array( 'TCL', 'A906' ),
			'TCL A909'									=> array( 'TCL', 'A909' ),
			'TCL A916'									=> array( 'TCL', 'A916' ),
			'TCL A919'									=> array( 'TCL', 'A919' ),
			'TCL A966'									=> array( 'TCL', 'A966' ),
			'TCL A968'									=> array( 'TCL', 'A968' ),
			'TCL A986'									=> array( 'TCL', 'A986' ),
			'TCL A988'									=> array( 'TCL', 'A988' ),
			'TCL A990'									=> array( 'TCL', 'A990' ),
			'TCL A996'									=> array( 'TCL', 'A996' ),
			'TCL A998'									=> array( 'TCL', 'A998' ),
			'TCL C990+'									=> array( 'TCL', 'C990+' ),
			'TCL C995'									=> array( 'TCL', 'C995' ),
			'TCL-D668'									=> array( 'TCL', 'D668' ),
			'TCL GENESEE E708'							=> array( 'TCL', 'Genesee E708' ),
			'TCL P600'									=> array( 'TCL', 'P600' ),
			'TCL P606!'									=> array( 'TCL', 'P606' ),
			'TCL S500'									=> array( 'TCL', 'S500' ),
			'(TCL )?S600!'								=> array( 'TCL', 'S600' ),
			'TCL S800'									=> array( 'TCL', 'S800' ),
			'TCL S810'									=> array( 'TCL', 'S810' ),
			'TCL S820'									=> array( 'TCL', 'S820' ),
			'TCL S830'									=> array( 'TCL', 'S830' ),
			'TCL S850'									=> array( 'TCL', 'S850' ),
			'TCL S900'									=> array( 'TCL', 'S900' ),
			'TCL S950'									=> array( 'TCL', 'S950' ),
			'TCL W939'									=> array( 'TCL', 'W939' ),
			'TCL W969'									=> array( 'TCL', 'W969' ),
			'TCL Y710'									=> array( 'TCL', 'Y710' ),
			'TCL Y900'									=> array( 'TCL', 'Y900' ),
			'A10t(5DM3)'								=> array( 'Teclast', 'A10T', TYPE_TABLET ),
			'P72'										=> array( 'Teclast', 'P72', TYPE_TABLET ),
			'P75HD(M3E5)'								=> array( 'Teclast', 'P75HD', TYPE_TABLET ),
			'Teclast P76e!'								=> array( 'Teclast', 'P76e', TYPE_TABLET ),
			'P76TI'										=> array( 'Teclast', 'P76Ti', TYPE_TABLET ),
			'P81HD'										=> array( 'Teclast', 'P81HD', TYPE_TABLET ),
			'P85(A9D3)'									=> array( 'Teclast', 'P85', TYPE_TABLET ),
			'P85(R8A1)'									=> array( 'Teclast', 'P85', TYPE_TABLET ),
			'Teclast P85!'								=> array( 'Teclast', 'P85', TYPE_TABLET ),
			'T720 SE'									=> array( 'Teclast', 'T720', TYPE_TABLET ),
			'T760 from moage.com'						=> array( 'Teclast', 'T760', TYPE_TABLET ),
			'tegav2'									=> array( 'Tegatech', 'TEGA v2', TYPE_TABLET ),
			'Tensent S9000'								=> array( 'Tensent', 'S9000' ),
			'TM-7024'									=> array( 'teXet', 'TM-7024', TYPE_TABLET ),
			'TM-7025'									=> array( 'teXet', 'TM-7025', TYPE_TABLET ),
			'TM-7037W'									=> array( 'teXet', 'TM-7037W', TYPE_TABLET ),
			'TM-8041HD'									=> array( 'teXet', 'TM-8041HD', TYPE_TABLET ),
			'MoFing'									=> array( 'Thomson', 'MoFing', TYPE_TABLET ),
			'Ultimate10'								=> array( 'Tomtec', 'Ultimate10', TYPE_TABLET ),
			'ThL V7'									=> array( 'THL', 'V7' ),
			'ThL V8'									=> array( 'THL', 'V8' ),
			'ThL V9'									=> array( 'THL', 'V9' ),
			'ThL V11'									=> array( 'THL', 'V11' ),
			'ThL V12'									=> array( 'THL', 'V12' ),
			'ThL W1'									=> array( 'THL', 'W1' ),
			'ThL W3'									=> array( 'THL', 'W3' ),
			'ThL W3dc'									=> array( 'THL', 'W3' ),
			'ThL W3+ (Dual Core)'						=> array( 'THL', 'W3' ),
			'ThL W5'									=> array( 'THL', 'W5' ),
			'ThL W6'									=> array( 'THL', 'W6' ),
			'ThL W7'									=> array( 'THL', 'W7' ),
			'ThL W8'									=> array( 'THL', 'W8' ),
			'TOOKY T83'									=> array( 'Tooky', 'T83' ),
			'TOOKY T85'									=> array( 'Tooky', 'T85' ),
			'TOOKY T1982'								=> array( 'Tooky', 'T1982' ),
			'TSB CLOUD COMPANION;TOSHIBA AC AND AZ'		=> array( 'Toshiba', 'Dynabook AZ', 'desktop' ),
			'TOSHIBA AC AND AZ'							=> array( 'Toshiba', 'Dynabook AZ', 'desktop' ),
			'TOSHIBA FOLIO AND A'						=> array( 'Toshiba', 'Folio 100', TYPE_TABLET ),
			'T-01C'										=> array( 'Toshiba', 'Regza T-01C' ),
			'T-01D'										=> array( 'Toshiba', 'Regza T-01D' ),
			'T-02D'										=> array( 'Toshiba', 'Regza T-02D' ),
			'IS04'										=> array( 'Toshiba', 'Regza IS04' ),
			'IS11T'										=> array( 'Toshiba', 'Regza IS11T' ),
			'AT1S0'										=> array( 'Toshiba', 'Regza AT1S0' ),
			'Tostab03'									=> array( 'Toshiba', 'Regza AT100', TYPE_TABLET ),
			'AT100'										=> array( 'Toshiba', 'Regza AT100', TYPE_TABLET ),
			'AT200'										=> array( 'Toshiba', 'Regza AT200', TYPE_TABLET ),
			'AT270'										=> array( 'Toshiba', 'Regza AT270', TYPE_TABLET ),
			'AT300'										=> array( 'Toshiba', 'Regza AT300', TYPE_TABLET ),
			'AT300SE'									=> array( 'Toshiba', 'Regza AT300SE', TYPE_TABLET ),
			'AT330'										=> array( 'Toshiba', 'Regza AT330', TYPE_TABLET ),
			'AT470'										=> array( 'Toshiba', 'Regza AT470', TYPE_TABLET ),
			'AT500'										=> array( 'Toshiba', 'Regza AT500', TYPE_TABLET ),
			'AT500a'									=> array( 'Toshiba', 'Regza AT500', TYPE_TABLET ),
			'AT570'										=> array( 'Toshiba', 'Regza AT570', TYPE_TABLET ),
			'AT830'										=> array( 'Toshiba', 'Regza AT830', TYPE_TABLET ),
			'Folio 100'									=> array( 'Toshiba', 'Folio 100', TYPE_TABLET ),
			'folio100'									=> array( 'Toshiba', 'Folio 100', TYPE_TABLET ),
			'THRiVE'									=> array( 'Toshiba', 'THRiVE', TYPE_TABLET ),
			'TRACER OXYGEN GS1'							=> array( 'Tracer', 'Oxygen GS1' ),
			'TREQ A10C'									=> array( 'Treq', 'A10C', TYPE_TABLET ),
			'Fantastic T3'								=> array( 'TWM', 'Fantastic T3' ),
			'TB100'										=> array( 'Unitech', 'TB100', TYPE_TABLET ),
			'M70014'									=> array( 'United Star Technology', 'M70014', TYPE_TABLET ),
			'UMI S1'									=> array( 'UMI', 'S1' ),
			'UMI X1'									=> array( 'UMI', 'X1' ),
			'UMI X1S'									=> array( 'UMI', 'X1s' ),
			'U1203'										=> array( 'Uniscope', 'U1203' ),
			'UOOGOU X6'									=> array( 'Uoogou', 'X6' ),
			'PS47'										=> array( 'Velocity Micro', 'Cruz PS47', TYPE_TABLET ),
			'T301'										=> array( 'Velocity Micro', 'Cruz T301', TYPE_TABLET ),
			'Vibo-A688'									=> array( 'FIH', 'Vibo A688' ),
			'Videocon-V7500'							=> array( 'Videocon', 'V7500' ),
			'ViewSonic-V350'							=> array( 'ViewSonic', 'V350' ),
			'GTablet'									=> array( 'ViewSonic', 'gTablet', TYPE_TABLET ),
			'GtabComb'									=> array( 'ViewSonic', 'gTablet', TYPE_TABLET ),
			'TeamDRH ICS for GTablet'					=> array( 'ViewSonic', 'gTablet', TYPE_TABLET ),
			'ViewPad7'									=> array( 'ViewSonic', 'ViewPad 7', TYPE_TABLET ),
			'ViewPad 10e'								=> array( 'ViewSonic', 'ViewPad 10e', TYPE_TABLET ),
			'ViewPad 10S'								=> array( 'ViewSonic', 'ViewPad 10s', TYPE_TABLET ),
			'ViewPad97A'								=> array( 'ViewSonic', 'ViewPad 97a', TYPE_TABLET ),
			'VSD220'									=> array( 'ViewSonic', 'VSD220', TYPE_DESKTOP ),
			'VINUS V8'									=> array( 'Vinus', 'V8' ),
			'vivo E1'									=> array( 'Vivo', 'E1' ),
			'vivo E3'									=> array( 'Vivo', 'E3' ),
			'vivo E5'									=> array( 'Vivo', 'E5' ),
			'vivo S1'									=> array( 'Vivo', 'S1' ),
			'vivo S3'									=> array( 'Vivo', 'S3' ),
			'vivo S3+'									=> array( 'Vivo', 'S3+' ),
			'vivo S6'									=> array( 'Vivo', 'S6' ),
			'vivo S6T'									=> array( 'Vivo', 'S6T' ),
			'vivo S7'									=> array( 'Vivo', 'S7' ),
			'vivo S9!'									=> array( 'Vivo', 'S9' ),
			'vivo S1'									=> array( 'Vivo', 'S1' ),
			'vivo S6'									=> array( 'Vivo', 'S6' ),
			'vivo S7t'									=> array( 'Vivo', 'S7' ),
			'vivo S9t'									=> array( 'Vivo', 'S9' ),
			'vivo S11t'									=> array( 'Vivo', 'S11' ),
			'vivo S12'									=> array( 'Vivo', 'S12' ),
			'vivo V1'									=> array( 'Vivo', 'V1' ),
			'vivo V2'									=> array( 'Vivo', 'V2' ),
			'vivo X1'									=> array( 'Vivo', 'X1' ),
			'vivo X1S'									=> array( 'Vivo', 'X1S' ),
			'vivo X1St'									=> array( 'Vivo', 'X1S' ),
			'vivo X1w'									=> array( 'Vivo', 'X1W' ),
			'vivo Xplay'								=> array( 'Vivo', 'Xplay' ),
			'vivo X510t'								=> array( 'Vivo', 'Xplay' ),
			'vivo Y1'									=> array( 'Vivo', 'Y1' ),
			'vivo Y3t'									=> array( 'Vivo', 'Y3T' ),
			'VTAB1008'									=> array( 'Vizio', 'VTAB1008', TYPE_TABLET ),
			'VTAB3010'									=> array( 'Vizio', 'VTAB3010', TYPE_TABLET ),
			'VOTO W5300'								=> array( 'VOTO', 'W5300' ),
			'Vsun i9'									=> array( 'Vsun Mobile', 'i9' ),
			'xPAD-70'									=> array( 'WayteQ', 'xPAD-70', TYPE_TABLET ),
			'xTAB-70!'									=> array( 'WayteQ', 'xTAB-70', TYPE_TABLET ),
			'WellcoM-A99'								=> array( 'WellcoM', 'A99' ),
			'WellcoM-A800'								=> array( 'WellcoM', 'A800', TYPE_TABLET ),
			'WEXLER-TAB-7T'								=> array( 'Wexler', 'Tab 7T', TYPE_TABLET ),
			'CINK FIVE'									=> array( 'Wiko', 'Cink Five' ),
			'CINK KING'									=> array( 'Wiko', 'Cink King' ),
			'CINK PEAX'									=> array( 'Wiko', 'Cink Peax' ),
			'WIKO-CINK SLIM'							=> array( 'Wiko', 'Cink Slim' ),
			'CINK SLIM'									=> array( 'Wiko', 'Cink Slim' ),
			'N5PRO2jingying'							=> array( 'Window', 'N5 Pro 2', TYPE_MEDIA ),
			'N12'										=> array( 'Window', 'N12', TYPE_TABLET ),
			'N12R'										=> array( 'Window', 'N12R', TYPE_TABLET ),
			'N50'										=> array( 'Window', 'N50', TYPE_TABLET ),
			'N50DT'										=> array( 'Window', 'N50DT', TYPE_TABLET ),
			'N50GT'										=> array( 'Window', 'N50GT', TYPE_TABLET ),
			'N50GT A'									=> array( 'Window', 'N50GT-A', TYPE_TABLET ),
			'N70'										=> array( 'Window', 'N70', TYPE_TABLET ),
			'N70DC'										=> array( 'Window', 'N70DC', TYPE_TABLET ),
			'N70-S'										=> array( 'Window', 'N70S', TYPE_TABLET ),
			'N70HD'										=> array( 'Window', 'N70HD', TYPE_TABLET ),
			'N70 DUAL CORE'								=> array( 'Window', 'N70 Dual Core', TYPE_TABLET ),
			'N70DC-S'									=> array( 'Window', 'N70 Dual Core', TYPE_TABLET ),
			'N70DC-T'									=> array( 'Window', 'N70 Dual Core', TYPE_TABLET ),
			'N80($| from moage.com)!'					=> array( 'Window', 'N80', TYPE_TABLET ),
			'N80DC'										=> array( 'Window', 'N80 Dual Core', TYPE_TABLET ),
			'N80IPS'									=> array( 'Window', 'N80 IPS', TYPE_TABLET ),
			'N90'										=> array( 'Window', 'N90', TYPE_TABLET ),
			'N90 DUAL CORE!'							=> array( 'Window', 'N90 Dual Core', TYPE_TABLET ),
			'N101 DUAL CORE!'							=> array( 'Window', 'N101 Dual Core', TYPE_TABLET ),
			'N612'										=> array( 'Wishway', 'N612' ),
			'A81E'										=> array( 'Witstech', 'A81E', TYPE_TABLET ),
			'AT-AS40D'									=> array( 'Wolfgang', 'AT-AS40D' ),
			'AT-AS40SE'									=> array( 'Wolfgang', 'AT-AS40SE' ),
			'AT-AS43D'									=> array( 'Wolfgang', 'AT-AS43D' ),
			'AT-AS43D2'									=> array( 'Wolfgang', 'AT-AS43D2' ),
			'AT-AS45SE'									=> array( 'Wolfgang', 'AT-AS45SE' ),
			'M12'										=> array( 'Wopad', 'M12', TYPE_TABLET ),
			'WM8650'									=> array( 'WonderMedia', 'WM8650', TYPE_TABLET ),
			'WM8850-mid'								=> array( 'WonderMedia', 'WM8850', TYPE_TABLET ),
			'MI-ONE'									=> array( 'Xiaomi', 'MI-ONE' ),
			'MI 1S'										=> array( 'Xiaomi', 'MI-ONE S' ),
			'MI 1SC'									=> array( 'Xiaomi', 'MI-ONE SC' ),
			'MI-ONE C1'									=> array( 'Xiaomi', 'MI-ONE C1' ),
			'MI-ONE Plus!'								=> array( 'Xiaomi', 'MI-ONE Plus' ),
			'mione plus'								=> array( 'Xiaomi', 'MI-ONE Plus' ),
			'MI 2'										=> array( 'Xiaomi', 'MI-TWO' ),
			'MI 2A'										=> array( 'Xiaomi', 'MI-TWO A' ),
			'MI 2C'										=> array( 'Xiaomi', 'MI-TWO C' ),
			'MI 2S'										=> array( 'Xiaomi', 'MI-TWO S' ),
			'MI 2SC'									=> array( 'Xiaomi', 'MI-TWO SC' ),
			'MI-TWO'									=> array( 'Xiaomi', 'MI-TWO' ),
			'X403'										=> array( 'Xtouch', 'X403' ),
			'X506'										=> array( 'Xtouch', 'X506' ),
			'Q07CL01'									=> array( 'XVision', 'Q07', TYPE_TABLET ),
			'Luna TAB07-100'							=> array( 'Yarvik', 'Luna 7"', TYPE_TABLET ),
			'TAB10-201'									=> array( 'Yarvik', 'Xenta 10"', TYPE_TABLET ),
			'N6'										=> array( 'Yarvik', 'TAB210 Tablet', TYPE_TABLET ),
			'TAB224'									=> array( 'Yarvik', 'TAB224 GoTab Velocity', TYPE_TABLET ),
			'C868'										=> array( 'Yicheer', 'C868' ),
			'EMR1879'									=> array( 'Yidong', 'EMR1879', TYPE_TABLET ),
			'yusun W702'								=> array( 'Yusun', 'W702' ),
			'YX-YUSUN E80'								=> array( 'Yusun', 'E80' ),
			'TB782B'									=> array( 'Zeki', 'TB782B', TYPE_TABLET ),
			'p7901a'									=> array( 'Zenithink', 'Epad P7901A', TYPE_TABLET ),
			'zt180'										=> array( 'Zenithink', 'ZT-180', TYPE_TABLET ),
			'Jaguar7'									=> array( 'ZiiLabs', 'Jaguar 7', TYPE_TABLET ),
			'Ziss Ranger HD'							=> array( 'Ziss', 'Ranger HD' ),
			'ZTE Libra'									=> array( 'ZTE', 'Libra' ),
			'ZTE T T9'									=> array( 'ZTE', 'Light Tab T9', TYPE_TABLET ),
			'V9'										=> array( 'ZTE', 'Light Tab V9', TYPE_TABLET ),
			'ZTE V9'									=> array( 'ZTE', 'Light Tab V9', TYPE_TABLET ),
			'ZTE C V9E'									=> array( 'ZTE', 'Light Tab V9', TYPE_TABLET ),
			'V9e+'										=> array( 'ZTE', 'Light Tab 2', TYPE_TABLET ),
			'V9A'										=> array( 'ZTE', 'Light Tab 2', TYPE_TABLET ),
			'Light Tab 2W'								=> array( 'ZTE', 'Light Tab 2', TYPE_TABLET ),
			'Light Tab 2'								=> array( 'ZTE', 'Light Tab 2', TYPE_TABLET ),
			'V9C'										=> array( 'ZTE', 'Light Tab 3', TYPE_TABLET ),
			'ZTE V72A'									=> array( 'ZTE', 'V72A', TYPE_TABLET ),
			'ZTE T T98'									=> array( 'ZTE', 'T98', TYPE_TABLET ),
			'V55'										=> array( 'ZTE', 'Optik', TYPE_TABLET ),
			'Acqua'										=> array( 'ZTE', 'Acqua' ),
			'ZTE Blade'									=> array( 'ZTE', 'Blade' ),
			'a5'										=> array( 'ZTE', 'Blade' ),
			'ZTE Blade G'								=> array( 'ZTE', 'Blade G' ),			
			'Blade S'									=> array( 'ZTE', 'Blade S' ),
			'Crescent'									=> array( 'ZTE', 'Blade S' ),	
			'ZTE Grand X Classic'						=> array( 'ZTE', 'Grand X Classic' ),
			'ZTE Kis Lite'								=> array( 'ZTE', 'Kis Lite' ),
			'Skate'										=> array( 'ZTE', 'Skate' ),
			'ZTE Skate'									=> array( 'ZTE', 'Skate' ),
			'Skate Pro'									=> array( 'ZTE', 'Skate Pro' ),
			'X500'										=> array( 'ZTE', 'X500 Score' ),
			'ZTE X500'									=> array( 'ZTE', 'X500 Score' ),
			'ZTE C X500'								=> array( 'ZTE', 'X500 Score' ),
			'ZTE C N600!'								=> array( 'ZTE', 'N600' ),
			'ZTE C N606'								=> array( 'ZTE', 'N606' ),
			'ZTE C N700'								=> array( 'ZTE', 'N700' ),
			'ZTE U N720'								=> array( 'ZTE', 'N720' ),
			'ZTE U N721'								=> array( 'ZTE', 'N721' ),
			'ZTE C R750'								=> array( 'ZTE', 'R750' ),
			'ZTE C N760'								=> array( 'ZTE', 'N760' ),
			'ZTE U V760'								=> array( 'ZTE', 'V760' ),
			'N762'										=> array( 'ZTE', 'N762' ),
			'ZTE V768'									=> array( 'ZTE', 'V768 Concord' ),
			'ZTE C N780'								=> array( 'ZTE', 'N780' ),
			'ZTE N788'									=> array( 'ZTE', 'N788' ),
			'ZTE V788!'									=> array( 'ZTE', 'V788 Kis' ),
			'ZTE U788!'									=> array( 'ZTE', 'U788 Kis' ),
			'ZTE N789'									=> array( 'ZTE', 'N789' ),
			'ZTE N790!'									=> array( 'ZTE', 'N790' ),
			'ZTE U790'									=> array( 'ZTE', 'U790' ),
			'ZTE V790'									=> array( 'ZTE', 'V790' ),
			'ZTE V791'									=> array( 'ZTE', 'V791' ),
			'ZTE V793'									=> array( 'ZTE', 'V793' ),
			'ZTE U795!'									=> array( 'ZTE', 'U795' ),
			'ZTE N798'									=> array( 'ZTE', 'N798' ),
			'ZTE T U802'								=> array( 'ZTE', 'U802' ),
			'RacerII'									=> array( 'ZTE', 'U806 Racer II' ),
			'ZTE T U806'								=> array( 'ZTE', 'U806 Racer II' ),
			'ZTE N807'									=> array( 'ZTE', 'N807' ),
			'ZTE U807'									=> array( 'ZTE', 'U807' ),
			'ZTE V807'									=> array( 'ZTE', 'V807 Blade C' ),
			'E810'										=> array( 'ZTE', 'E810' ),
			'ZTE T U812'								=> array( 'ZTE', 'U812' ),
			'ZTE U817'									=> array( 'ZTE', 'U817' ),
			'ZTE V817'									=> array( 'ZTE', 'V817' ),
			'ZTE N818'									=> array( 'ZTE', 'N818' ),
			'ZTE GV821'									=> array( 'ZTE', 'V821' ),
			'ZTE T U830'								=> array( 'ZTE', 'U830' ),		
			'ZTE Racer'									=> array( 'ZTE', 'X850 Racer' ),
			'Racer'										=> array( 'ZTE', 'X850 Racer' ),
			'ZTE U X850'								=> array( 'ZTE', 'X850 Racer' ),
			'ZTE U V852'								=> array( 'ZTE', 'V852 Dreamer' ),
			'ZTE N855D'									=> array( 'ZTE', 'N855D' ),
			'ZTE U V856'								=> array( 'ZTE', 'V856 Mimosa Mini' ),
			'ZTE V856'									=> array( 'ZTE', 'V856 Mimosa Mini' ),
			'ZTE U V857'								=> array( 'ZTE', 'V857' ),
			'N860'										=> array( 'ZTE', 'N860 Warp' ),
			'N861'										=> array( 'ZTE', 'N861 Warp II' ),
			'ZTE U? X876!'								=> array( 'ZTE', 'X876 Raise' ),
			'ZTE V877!'									=> array( 'ZTE', 'V877' ),
			'N880'										=> array( 'ZTE', 'N880 Blade' ),
			'ZTE C N880!'								=> array( 'ZTE', 'N880 Blade' ),
			'U880'										=> array( 'ZTE', 'U880 Blade' ),
			'ZTE ?U880!'								=> array( 'ZTE', 'U880 Blade' ),
			'ZTE T ?U880!'								=> array( 'ZTE', 'U880 Blade' ),
			'V880'										=> array( 'ZTE', 'V880 Blade' ),
			'ZTE (U )?V880!'							=> array( 'ZTE', 'V880 Blade' ),
			'ZTE U(V)880+'								=> array( 'ZTE', 'V880 Blade' ),
			'Blade(-V880|-opda)?$!'						=> array( 'ZTE', 'V880 Blade' ),
			'ZTE N880E'									=> array( 'ZTE', 'N880E' ),
			'ZTE N880F'									=> array( 'ZTE', 'N880F' ),
			'ZTE N880G'									=> array( 'ZTE', 'N880G' ),
			'ZTE N881E'									=> array( 'ZTE', 'N881E' ),
			'ZTE N881F'									=> array( 'ZTE', 'N881F' ),
			'BLADEII'									=> array( 'ZTE', 'V881 Blade II' ),
			'Blade2'									=> array( 'ZTE', 'V881 Blade II' ),
			'ZTE U V881'								=> array( 'ZTE', 'V881 Blade II' ),	
			'ZTE V881'									=> array( 'ZTE', 'V881 Blade II' ),		
			'ZTE N882E'									=> array( 'ZTE', 'N882E' ),
			'ZTE ?U885!'								=> array( 'ZTE', 'U885' ),
			'ZTE V887'									=> array( 'ZTE', 'V887' ),
			'ZTE V889!'									=> array( 'ZTE', 'V889' ),
			'ZTE Blade III'								=> array( 'ZTE', 'V889M Blade III' ),	
			'Blade III'									=> array( 'ZTE', 'V889M Blade III' ),			
			'ZTE T ?U900!'								=> array( 'ZTE', 'U900' ),	
			'ZTE N909'									=> array( 'ZTE', 'N909' ),
			'ZTE N910'									=> array( 'ZTE', 'N910 Anthem' ),
			'ZTE C X920'								=> array( 'ZTE', 'X920' ),
			'ZXY-ZTE-C X920'							=> array( 'ZTE', 'X920' ),
			'ZTE U930!'									=> array( 'ZTE', 'U930 Grand X' ),
			'ZTE Grand X'								=> array( 'ZTE', 'U930 Grand X' ),
			'Grand X In'								=> array( 'ZTE', 'U930 Grand X IN' ),
			'Grand X Intel'								=> array( 'ZTE', 'U930 Grand X IN' ),
			'ZTE U930 Ultimate'							=> array( 'ZTE', 'U930 Grand X' ),
			'ZTE U930HD'								=> array( 'ZTE', 'U930 HD' ),
			'ZTE U935'									=> array( 'ZTE', 'U935' ),
			'ZTE U950'									=> array( 'ZTE', 'U950' ),
			'ZTE V955'									=> array( 'ZTE', 'V955' ),
			'ZTE U956'									=> array( 'ZTE', 'U956' ),
			'ZTE V956'									=> array( 'ZTE', 'V956' ),
			'ZTE (U )?V960!'							=> array( 'ZTE', 'V960 Skate' ),
			'ZTE T ?U960!'								=> array( 'ZTE', 'U960 Skate' ),
			'ZTE U960s2'								=> array( 'ZTE', 'U960s2' ),
			'ZTE U960s3'								=> array( 'ZTE', 'U960s3' ),
			'ZTE V965'									=> array( 'ZTE', 'V965' ),
			'ZTE V967S'									=> array( 'ZTE', 'V967' ),
			'ZTE N970'									=> array( 'ZTE', 'N970 Grand X' ),
			'ZTE U970'									=> array( 'ZTE', 'U970 Grand X' ),
			'ZTE V970!'									=> array( 'ZTE', 'Z970 Grand X' ),
			'ZTE N983'									=> array( 'ZTE', 'N983' ),
			'Grand X Pro'								=> array( 'ZTE', 'V983 Grand X Pro' ),
			'ZTE Grand Era'								=> array( 'ZTE', 'U985 Grand Era' ),
			'ZTE U985'									=> array( 'ZTE', 'U985 Grand Era' ),
			'ZTE V985'									=> array( 'ZTE', 'V985 Grand Era' ),
			'ZTE N986'									=> array( 'ZTE', 'N986' ),
			'ZTE V987'									=> array( 'ZTE', 'V987' ),
			'ZTE V988'									=> array( 'ZTE', 'V988 Grand S' ),
			'ZTE Roamer'								=> array( 'ZTE', 'Z990 Roamer ' ),
			'ZTE Z990!'									=> array( 'ZTE', 'Z990 Roamer' ),
			'V8000 USA Cricket'							=> array( 'ZTE', 'V8000 Engage' ),
			'X501 USA Cricket'							=> array( 'ZTE', 'X501 Groove' ),
			'ZXY-ZTE V6700'								=> array( 'ZTE', 'V6700' ),
			'ZTE V9800'									=> array( 'ZTE', 'V9800 Grand Era LTE' ),
			'ZTE V9815'									=> array( 'ZTE', 'V9800 Grand Memo' ),
			'N9100'										=> array( 'ZTE', 'N9100 Force' ),
			'ZTE N9120'									=> array( 'ZTE', 'N9120 Avid' ),
			'N9500'										=> array( 'ZTE', 'N9500 Flash' ),
			'ZTE N5'									=> array( 'ZTE', 'N5 Grand Memo' ),
			'003Z'										=> array( 'ZTE', 'Softbank 003Z' ),
			'008Z'										=> array( 'ZTE', 'Softbank 008Z' ),
			'009Z'										=> array( 'ZTE', 'Softbank Star7' ),
			'(Zopo )?ZP100!'							=> array( 'Zopo', 'ZP100 Pilot' ),
			'ZP200'										=> array( 'Zopo', 'ZP200 Shining' ),
			'ZP300'										=> array( 'Zopo', 'ZP300 Field' ),
			'ZP300+'									=> array( 'Zopo', 'ZP300 Field Plus' ),
			'ZP500'										=> array( 'Zopo', 'ZP500 Libero' ),
			'(Zopo )?ZP900!'							=> array( 'Zopo', 'ZP900 Leader' ),
			'ZP950'										=> array( 'Zopo', 'ZP950 Phablet' ),
			'ZP980'										=> array( 'Zopo', 'ZP980' ),
	
			/* Telecom provider branded devices */
			'i-mobile i691'								=> array( 'i-Mobile', 'i691' ),
			'i-mobile i695'								=> array( 'i-Mobile', 'i695' ),
			'i-mobile i858'								=> array( 'i-Mobile', 'i858' ),
			'i-mobile 3G 8500'							=> array( 'i-Mobile', '3G 8500' ),
			'i-mobile IQ 1'								=> array( 'i-Mobile', 'iQ 1' ),	
			'i-mobile IQ 2'								=> array( 'i-Mobile', 'iQ 2' ),	
			'i-mobile IQ 2A'							=> array( 'i-Mobile', 'iQ 2A' ),
			'i-mobile IQ 3'								=> array( 'i-Mobile', 'iQ 3' ),		
			'i-mobile IQ 5'								=> array( 'i-Mobile', 'iQ 5' ),	
			'i-mobile IQ 6'								=> array( 'i-Mobile', 'iQ 6' ),	
			'i-mobile IQ 6A'							=> array( 'i-Mobile', 'iQ 6A' ),	
			'i-STYLE 1'									=> array( 'i-Mobile', 'i-Style 1' ),	
			'i-mobile i-STYLE 2'						=> array( 'i-Mobile', 'i-Style 2' ),	
			'i-mobile i-style 3'						=> array( 'i-Mobile', 'i-Style 3' ),	
			'i-mobile i-STYLE 4'						=> array( 'i-Mobile', 'i-Style 4' ),	
			'i-MOBILE i-STYLE 5'						=> array( 'i-Mobile', 'i-Style 5' ),	
			'i-mobile i-style Q1'						=> array( 'i-Mobile', 'i-Style Q1' ),						
			'i-mobile i-STYLE Q2'						=> array( 'i-Mobile', 'i-Style Q2' ),			
			'i-mobile i-STYLE Q2 DUO'					=> array( 'i-Mobile', 'i-Style Q2 Duo' ),
			'i-STYLE Q2 DUO'							=> array( 'i-Mobile', 'i-Style Q2 Duo' ),
			'i-mobile i-style Q3'						=> array( 'i-Mobile', 'i-Style Q3' ),		
			'i-mobile i-style Q3i'						=> array( 'i-Mobile', 'i-Style Q3i' ),				
			'i-mobile i-STYLE Q 5A'						=> array( 'i-Mobile', 'i-Style Q5A' ),				
			'i-mobile i-STYLE Q6'						=> array( 'i-Mobile', 'i-Style Q6' ),						
			'i-mobile I-Note'							=> array( 'i-Mobile', 'i-Note', TYPE_TABLET ),
			'i-mobile i-note 3'							=> array( 'i-Mobile', 'i-Note 3', TYPE_TABLET ),
			'i-mobile i-note WiFi 7'					=> array( 'i-Mobile', 'i-Note 7', TYPE_TABLET ),
			'i-mobile i-note WiFi 9'					=> array( 'i-Mobile', 'i-Note 9', TYPE_TABLET ),
	
			'Etisalat Smartphone'						=> array( 'Etisalat', 'Smartphone' ),	
			
			'Optimus Boston'							=> array( 'Optimus', 'Boston' ),							/* Gigabyte GSmart G1305 */
			'Optimus San Francisco'						=> array( 'Optimus', 'San Francisco' ),						/* ZTE Blade */
			'Optimus Monte Carlo'						=> array( 'Optimus', 'Monte Carlo' ),						/* ZTE Skate */
			
			'Orange Boston'								=> array( 'Orange', 'Boston' ),								/* Gigabyte GSmart G1305 */
			'Orange Daytona'							=> array( 'Orange', 'Daytona' ),						
			'Orange Kivo'								=> array( 'Orange', 'Kivo' ),
			'Orange Monte Carlo'						=> array( 'Orange', 'Monte Carlo' ),						/* ZTE Skate */
			'San Francisco'								=> array( 'Orange', 'San Francisco' ),						/* ZTE Blade */
			'San Francisco for Orange'					=> array( 'Orange', 'San Francisco' ),						/* ZTE Blade */
			'Orange San Francisco'						=> array( 'Orange', 'San Francisco' ),						/* ZTE Blade */
			'Orange Zali'								=> array( 'Orange', 'Zali' ),
			
			'MOVE'										=> array( 'T-Mobile', 'MOVE' ),								/* Alcatel One Touch 908 */
			'T-Mobile G1'								=> array( 'T-Mobile', 'G1' ),								/* HTC Dream */
			'T-Mobile G2'								=> array( 'T-Mobile', 'G2' ),								/* HTC Desire Z */
			'T-Mobile G2 Touch'							=> array( 'T-Mobile', 'G2' ),								/* HTC Desire Z */
			'LG-P999'									=> array( 'T-Mobile', 'G2x' ),								/* LG Optimus 2X */
			'LG-E739'									=> array( 'T-Mobile', 'myTouch' ),							/* LG E739 */
			'T-Mobile myTouch'							=> array( 'T-Mobile', 'myTouch' ),							/* LG E739 */
			'T-Mobile myTouch 3G'						=> array( 'T-Mobile', 'myTouch 3G'),						/* HTC Magic */
			'T-Mobile myTouch 3G Slide'					=> array( 'T-Mobile', 'myTouch 3G Slide' ),					/* HTC Espresso */
			'T-mobile my touch 3g slide'				=> array( 'T-Mobile', 'myTouch 3G Slide' ),					/* HTC Espresso */
			'HTC T-Mobile myTouch 3G Slide'				=> array( 'T-Mobile', 'myTouch 3G Slide' ),					/* HTC Espresso */
			'T-Mobile Espresso'							=> array( 'T-Mobile', 'myTouch 3G Slide' ),					/* HTC Espresso */
			'HTC my ?Touch 3G Slide!'					=> array( 'T-Mobile', 'myTouch 3G Slide' ),					/* HTC Espresso */
			'T-Mobile myTouch 4G'						=> array( 'T-Mobile', 'myTouch 4G' ),						/* HTC Glacier */
			'HTC Glacier'								=> array( 'T-Mobile', 'myTouch 4G' ),						/* HTC Glacier */
			'HTC Panache'								=> array( 'T-Mobile', 'myTouch 4G' ),						/* HTC Glacier */
			'My ?Touch ?4G$!'							=> array( 'T-Mobile', 'myTouch 4G' ),						/* HTC Glacier */
			'HTC My ?Touch ?4G$!'						=> array( 'T-Mobile', 'myTouch 4G' ),						/* HTC Glacier */
			'HTC myTouch 4G Slide'						=> array( 'T-Mobile', 'myTouch 4G Slide' ),					/* HTC Doubleshot */
			'myTouch 4G Slide'							=> array( 'T-Mobile', 'myTouch 4G Slide' ),					/* HTC Doubleshot */
			'T-Mobile myTouch Q'						=> array( 'T-Mobile', 'myTouch Q' ),						/* Huawei U8730 */
			'LG-C800'									=> array( 'T-Mobile', 'myTouch Q' ),
			'Pulse Mini'								=> array( 'T-Mobile', 'Pulse Mini' ),						/* Huawei U8110 */
			'T-Mobile Vivacity'							=> array( 'T-Mobile', 'Vivacity' ),				
			
			'Telenor OneTouch'							=> array( 'Telenor', 'One Touch' ),
			'Telenor One Touch S'						=> array( 'Telenor', 'One Touch S' ),
			'Telenor Touch Plus'						=> array( 'Telenor', 'Touch Plus' ),
			'Telenor Smart Pro'							=> array( 'Telenor', 'Smart Pro' ),
			
			'Turkcell Maxi Plus 5'						=> array( 'Turkcell', 'Maxi Plus 5' ),
			'TURKCELL MaxiPRO5'							=> array( 'Turkcell', 'Maxi Pro 5' ),
			'Turkcell T10'								=> array( 'Turkcell', 'T10' ),
			'Turkcell T20'								=> array( 'Turkcell', 'T20' ),
		
			'MTC 916'									=> array( 'MTC', '916' ),
			'MTC 950'									=> array( 'MTC', '950' ),
			'MTC 955'									=> array( 'MTC', '955' ),
			'MTC 960'									=> array( 'MTC', '960' ),
			'MTC-962'									=> array( 'MTC', '962' ),
			'MTC Evo'									=> array( 'MTC', 'Evo' ),
			'MTC Neo'									=> array( 'MTC', 'Neo' ),
			'MTC Viva'									=> array( 'MTC', 'Viva' ),
			
			'QMobile A7'								=> array( 'Q-Mobile', 'Noir A7' ),
			'QMobile A8'								=> array( 'Q-Mobile', 'Noir A8' ),
			'QMobile A12'								=> array( 'Q-Mobile', 'Noir A12' ),
			'Qmobile-S11'								=> array( 'Q-Mobile', 'S11' ),
			'Q-Smart S18'								=> array( 'Q-Mobile', 'Q-Smart S18' ),
			'Q-Smart S20'								=> array( 'Q-Mobile', 'Q-Smart S20' ),
			
			'KPN Smart 300'								=> array( 'KPN', 'Smart 300' ),
			
			'Vodafone 845'								=> array( 'Vodafone', '845 Nova' ),							/* Huawei U8100 */
			'Vodafone 858'								=> array( 'Vodafone', '858 Smart' ),						/* Huawei U8160 */
			'Vodafone 861'								=> array( 'Vodafone', '861 Smart' ),
			'Vodafone 945'								=> array( 'Vodafone', '945' ),								/* ZTE Joe */
			'Vodafone 958'								=> array( 'Vodafone', '958' ),
			'Vodafone 975N'								=> array( 'Vodafone', '975' ),
			'Vodafone 980'								=> array( 'Vodafone', '980' ),
			'Vodafone Smart ll'							=> array( 'Vodafone', 'Smart II' ),
			'Vodafone Smart II'							=> array( 'Vodafone', 'Smart II' ),
			'Vodafone Smart 4G'							=> array( 'Vodafone', 'Smart 4G' ),
			'SmartTabII7'								=> array( 'Vodafone', 'SmartTab II 7', TYPE_TABLET ),		/* Lenovo */
			'SmartTab10'								=> array( 'Vodafone', 'SmartTab 10', TYPE_TABLET )			/* ZTE Web Tab 10 */
		);
		
		static $BADA_MODELS = array(
			'GT- ?S52(50|53)!'							=> array( 'Samsung', 'Wave 525' ),
			'GT-S53(30|33)!'							=> array( 'Samsung', 'Wave 533' ),
			'GT-S5380!'									=> array( 'Samsung', 'Wave Y' ),
			'GT-S57(50|53)!'							=> array( 'Samsung', 'Wave 575' ),
			'GT-S72(30|33)!'							=> array( 'Samsung', 'Wave 723' ),
			'GT-S7250!'									=> array( 'Samsung', 'Wave M' ),
			'GT-S8500!'									=> array( 'Samsung', 'Wave' ),
			'GT- ?S8530!'								=> array( 'Samsung', 'Wave II' ),
			'GT- ?S8600!'								=> array( 'Samsung', 'Wave 3' ),
			'SHW-M410'									=> array( 'Samsung', 'Wave 3' )
		);
		
		static $BREW_MODELS = array(
			'Coolpad D508'								=> array( 'Coolpad', 'D508' ),
			'Coolpad E600'								=> array( 'Coolpad', 'E600' ),
			'SCH-F839'									=> array( 'Samsung', 'SCH-F839' ),
			'SCH-M519!'									=> array( 'Samsung', 'Metro TV' ),
			'SCH-U380'									=> array( 'Samsung', 'Brightside' ),
			'SCH-W709!'									=> array( 'Samsung', 'SCH-W709' ),
			'HS-E316!'									=> array( 'Hisense', 'E316' ),
		);
		
		static $TIZEN_MODELS = array(
			'GT-I8800!'									=> array( 'Samsung', '"Melius"' ),
			'GT-I8805!'									=> array( 'Samsung', '"Redwood"' ),
			'GT-I9500!'									=> array( 'Samsung', 'GT-I9500 prototype' ),
			'SEC SC-001'								=> array( 'Samsung', 'SC-001 prototype' ),
		);
		
		static $TOUCHWIZ_MODELS = array(
			'GT-B5310!'									=> array( 'Samsung', 'Corby Pro' ),
			'GT-B3410'									=> array( 'Samsung', 'Star Qwerty' ),
			'GT-B7722'									=> array( 'Samsung', 'Star Duos' ),
			'GT-C3262'									=> array( 'Samsung', 'Champ Neo Duos' ),
			'GT-C33(00|03)!'							=> array( 'Samsung', 'Champ' ),
			'GT-C3312'									=> array( 'Samsung', 'Champ Deluxe Duos' ),
			'GT-C3330'									=> array( 'Samsung', 'Champ 2' ),
			'GT-C6712'									=> array( 'Samsung', 'Star II Duos' ),
			'GT-M3710'									=> array( 'Samsung', 'Corby Beat' ),
			'GT-M5650'									=> array( 'Samsung', 'Lindy' ),
			'GT-S3370C'									=> array( 'Samsung', 'Corby 3G' ),
			'GT-S36(50|53)!'							=> array( 'Samsung', 'Corby' ),
			'GT-S3850'									=> array( 'Samsung', 'Corby II' ),
			'GT-S5220'									=> array( 'Samsung', 'Star 3' ),
			'GT-S5222'									=> array( 'Samsung', 'Star 3 Duos' ),
			'GT-S52(30|33)!'							=> array( 'Samsung', 'Star' ),
			'GT-S5260'									=> array( 'Samsung', 'Star II' ),
			'GT-S5560'									=> array( 'Samsung', 'Marvel' ),
			'GT-S5620!'									=> array( 'Samsung', 'Monte' ),
			'GT-S5680'									=> array( 'Samsung', 'GT-S5680' ),
			'GT-S7550'									=> array( 'Samsung', 'Blue Earth' ),
			'S80(00|03)!'								=> array( 'Samsung', 'Jet' ),
			'SGH-F480'									=> array( 'Samsung', 'Tocco' ),
			'SGH-T528g'									=> array( 'Samsung', 'Straight Talk' )		
		);
		
		static $WINDOWS_MOBILE_MODELS = array(
			'DX900'										=> array( 'Acer', 'Tempo DX900' ),
			'F900'										=> array( 'Acer', 'Tempo F900' ),
			'Coolpad F800'								=> array( 'Coolpad', 'F800' ),
			'T5388'										=> array( 'Dopod', 'Touch Diamond 2' ),
			'garmin-asus-Nuvifone-M10'					=> array( 'Garmin-Asus', 'Nuvifone M10' ),
			'HP iPAQ 510'								=> array( 'HP', 'iPAQ 510' ),
			'((HTC )?HD mini|.*T5555)!'					=> array( 'HTC', 'HD mini' ),
			'((HTC )?HD2|.*T8585)!'						=> array( 'HTC', 'HD2' ),
			'T-Mobile LEO'								=> array( 'HTC', 'HD2' ),
			'dopodT5588'								=> array( 'HTC', 'Hengshan' ),
			'(HTC Mega|.*T3333)!'						=> array( 'HTC', 'Mega' ),
			'(HTC Snap|.*S521)!'						=> array( 'HTC', 'Snap' ),
			'(HTC Touch2|.*T33(20|33|35))!'				=> array( 'HTC', 'Touch 2' ),
			'(HTC Touch Diamond2|.*T5353)!'				=> array( 'HTC', 'Touch Diamond 2' ),
			'XV6975'									=> array( 'HTC', 'Touch Diamond 2' ),
			'(HTC Touch Diamond|.*P3700)!'				=> array( 'HTC', 'Touch Diamond' ),
			'(HTC Touch HD2|.*T8585)!'					=> array( 'HTC', 'Touch HD2' ),
			'(HTC Touch HD|.*T82(82|83))!'				=> array( 'HTC', 'Touch HD' ),
			'(HTC Touch Pro2|.*T73(73|80))!'			=> array( 'HTC', 'Touch Pro 2' ),
			'HTC TyTN II'								=> array( 'HTC', 'TyTN II' ),
			'GT-B5722'									=> array( 'Samsung', 'B5722' ),	
			'GT-B6520'									=> array( 'Samsung', 'B6520 OmniaPRO 5' ),	
			'GT-B7300'									=> array( 'Samsung', 'B7300 OmniaLITE' ),
			'GT-B7320'									=> array( 'Samsung', 'B7320 OmniaPRO' ),
			'GT-B7330'									=> array( 'Samsung', 'B7330 OmniaPRO' ),
			'GT-B7350'									=> array( 'Samsung', 'B7350 OmniaPRO 4' ),
			'GT-B7610'									=> array( 'Samsung', 'B7610 OmniaPRO' ),
			'GT-C6625'									=> array( 'Samsung', 'C6625 Valencia' ),
			'GT-I8000!'									=> array( 'Samsung', 'I8000 Omnia II' ),
			'SCH-M715'									=> array( 'Samsung', 'M715 T*OMNIA II' ),
			'SGH-i900'									=> array( 'Samsung', 'i900 Omnia' ),
			'WS007SH'									=> array( 'Sharp', 'W-ZERO3' ),
			'M1i' 										=> array( 'Sony Ericsson', 'M1i Aspen' )
		);
		
		static $WINDOWS_PHONE_MODELS = array(
			'Allegro'									=> array( 'Acer', 'Allegro' ),
			'M310'										=> array( 'Acer', 'Allegro' ),
			'Galaxy6'									=> array( 'Asus', 'Galaxy 6' ),
			'Venue Pro'									=> array( 'Dell', 'Venue Pro' ),
			'IS12T'										=> array( 'Fujitsu Toshiba', 'IS12T' ),
			'USCCHTC-PC93100'							=> array( 'HTC', 'Arrive' ),
			'Gold'										=> array( 'HTC', 'Gold' ),
			'HD2'										=> array( 'HTC', 'HD2' ),
			'LEO'										=> array( 'HTC', 'HD2' ),
			'(HD7|.*T92(92|95|96))!'					=> array( 'HTC', 'HD7' ),
			'Schubert!'									=> array( 'HTC', 'HD7' ),
			'(7 Pro|.*T75(75|76))!'						=> array( 'HTC', '7 Pro' ),
			'((7 )?Mozart|.*T86(97|98))!'				=> array( 'HTC', '7 Mozart' ),
			'PD67100'									=> array( 'HTC', '7 Mozart' ), 
			'((7 )?Trophy|.*T8686)!'					=> array( 'HTC', 'Trophy' ),
			'mwp6985'									=> array( 'HTC', 'Trophy' ),
			'htc mpw6958'								=> array( 'HTC', 'Trophy' ),
			'PC40100'									=> array( 'HTC', 'Trophy' ),
			'Touch-IT Trophy'							=> array( 'HTC', 'Trophy' ),
			'(Radar|.*C110e)!'							=> array( 'HTC', 'Radar' ),
			'Mazaa'										=> array( 'HTC', 'Mazaa' ), 
			'Mondrian'									=> array( 'HTC', 'Mondrian' ),
			'Spark'										=> array( 'HTC', 'Spark' ),
			'.*T8788!'									=> array( 'HTC', 'Surround' ),
			'.*X310e!'									=> array( 'HTC', 'Titan' ),
			'PI39100'									=> array( 'HTC', 'Titan' ),
			'Eternity'									=> array( 'HTC', 'Titan' ),
			'PI86100'									=> array( 'HTC', 'Titan II' ),
			'Ultimate'									=> array( 'HTC', 'Ultimate' ),
			'HTC6990LVW'								=> array( 'HTC', '8X' ),
			'RIO U'										=> array( 'HTC', '8X' ),
			'C620(d|e|t)!'								=> array( 'HTC', '8X' ),
			'C625(a|b)!'								=> array( 'HTC', '8X' ),
			'Windows Phone 8X by HTC'					=> array( 'HTC', '8X' ),
			'Windows Phone 8S by HTC'					=> array( 'HTC', '8S' ),
			'HUAWEI Ascend W1!'							=> array( 'Huawei', 'Ascend W1' ),
			'GW910'										=> array( 'LG', 'Optimus 7' ),
			'LG-E-?900!'								=> array( 'LG', 'Optimus 7 E900' ),
			'LG-E906'									=> array( 'LG', 'Jil Sander' ),
			'LG-C900!'									=> array( 'LG', 'Optimus 7Q' ),
			'Lumia 505'									=> array( 'Nokia', 'Lumia 505' ),
			'(Lumia ?|Nokia ?)?510!'					=> array( 'Nokia', 'Lumia 510' ),
			'(Lumia ?|Nokia ?)?610!'					=> array( 'Nokia', 'Lumia 610' ),
			'(Lumia ?|Nokia ?)?620!'					=> array( 'Nokia', 'Lumia 620' ),
			'(Lumia ?|Nokia ?)?710!'					=> array( 'Nokia', 'Lumia 710' ),
			'Lumia 719'									=> array( 'Nokia', 'Lumia 719' ),
			'(Lumia ?|Nokia ?)?800!'					=> array( 'Nokia', 'Lumia 800' ),
			'SeaRay'									=> array( 'Nokia', 'Lumia 800' ),
			'Lumia ?810!'								=> array( 'Nokia', 'Lumia 810' ),
			'Lumia ?820!'								=> array( 'Nokia', 'Lumia 820' ),
			'Lumia ?822!'								=> array( 'Nokia', 'Lumia 822' ),
			'(Lumia ?|Nokia ?)?900!'					=> array( 'Nokia', 'Lumia 900' ),
			'(Lumia ?|Nokia ?)?920!'					=> array( 'Nokia', 'Lumia 920' ),
			'RM-8(20|21)!'								=> array( 'Nokia', 'Lumia 920' ),
			'GT-I8350!'									=> array( 'Samsung', 'Omnia W' ),
			'GT-i8700'									=> array( 'Samsung', 'Omnia 7' ),
			'GT-I8750'									=> array( 'Samsung', 'Ativ S' ),
			'GT-S7530'									=> array( 'Samsung', 'Omnia M' ),
			'SGH-i667'									=> array( 'Samsung', 'Focus 2' ),
			'SGH-i677'									=> array( 'Samsung', 'Focus Flash' ),
			'SGH-i707'									=> array( 'Samsung', 'Taylor' ),
			'SGH-i917!'									=> array( 'Samsung', 'Focus' ),
			'SCH-I930'									=> array( 'Samsung', 'Ativ Odyssey' ),
			'SGH-i937!'									=> array( 'Samsung', 'Focus S' ),
			'SGH-T899M'									=> array( 'Samsung', 'Ativ S' ),
			'OM(NI|IN)A ?7!'							=> array( 'Samsung', 'Omnia 7' ),
			'Taylor'									=> array( 'Samsung', 'Taylor' ),
			'CETUS'										=> array( 'Samsung', 'Cetus' ),
			'I917'										=> array( 'Samsung', 'Cetus' ),
			'S606'										=> array( 'TCL', 'Horizon S606' ),
			'TSUNAGI'									=> array( 'Toshiba', 'Tsunagi' ),
			'N880e!'									=> array( 'ZTE', 'N880e' ),
			'V965W'										=> array( 'ZTE', 'V965W Tania' ),
			'Tania'										=> array( 'ZTE', 'V965W Tania' )
		);
		
		static $S40_MODELS = array(
			'C1-01!'									=> array( 'Nokia', 'C1-01' ),
			'C1-02'										=> array( 'Nokia', 'C1-02' ),
			'C2-00'										=> array( 'Nokia', 'C2-00' ),
			'C2-01'										=> array( 'Nokia', 'C2-01' ),
			'C2-02'										=> array( 'Nokia', 'C2-02' ),
			'C2-03'										=> array( 'Nokia', 'C2-03' ),
			'C2-05'										=> array( 'Nokia', 'C2-05' ),
			'C2-06'										=> array( 'Nokia', 'C2-06' ),
			'C3-00'										=> array( 'Nokia', 'C3-00' ),
			'C3-01!'									=> array( 'Nokia', 'C3-01' ),
			'X2-00'										=> array( 'Nokia', 'X2-00' ),
			'X2-01!'									=> array( 'Nokia', 'X2-01' ),
			'X2-02'										=> array( 'Nokia', 'X2-02' ),
			'X2-05'										=> array( 'Nokia', 'X2-05' ),
			'X3-00'										=> array( 'Nokia', 'X3-00' ),
			'X3-02'										=> array( 'Nokia', 'X3-02' ),
			'109'										=> array( 'Nokia', '109' ),
			'110'										=> array( 'Nokia', '110' ),
			'111'										=> array( 'Nokia', '111' ),
			'112'										=> array( 'Nokia', '112' ),
			'200'										=> array( 'Nokia', 'Asha 200' ),
			'201'										=> array( 'Nokia', 'Asha 201' ),
			'202'										=> array( 'Nokia', 'Asha 202' ),
			'203'										=> array( 'Nokia', 'Asha 203' ),
			'300'										=> array( 'Nokia', 'Asha 300' ),
			'302'										=> array( 'Nokia', 'Asha 302' ),
			'303'										=> array( 'Nokia', 'Asha 303' ),
			'305'										=> array( 'Nokia', 'Asha 305' ),
			'306'										=> array( 'Nokia', 'Asha 306' ),
			'308'										=> array( 'Nokia', 'Asha 308' ),
			'309'										=> array( 'Nokia', 'Asha 309' ),
			'310'										=> array( 'Nokia', 'Asha 311' ),
			'311'										=> array( 'Nokia', 'Asha 311' ),
			'1682c'										=> array( 'Nokia', '1682 classic' ),
			'2220s!'									=> array( 'Nokia', '2220 slide' ),
			'2320c!'									=> array( 'Nokia', '2320 classic' ),
			'2323c!'									=> array( 'Nokia', '2323 classic' ),
			'2330c!'									=> array( 'Nokia', '2330 classic' ),
			'2600c!'									=> array( 'Nokia', '2600 classic' ),
			'2680s!'									=> array( 'Nokia', '2680 slide' ),
			'2690'										=> array( 'Nokia', '2690' ),
			'2700c!'									=> array( 'Nokia', '2700 classic' ),
			'2710c'										=> array( 'Nokia', '2710' ),
			'2720a!'									=> array( 'Nokia', '2720 fold' ),
			'2730c!'									=> array( 'Nokia', '2730 classic' ),
			'3110c'										=> array( 'Nokia', '3110 Evolve' ),
			'3120c'										=> array( 'Nokia', '3120 classic' ),
			'3208c'										=> array( 'Nokia', '3208 classic' ),
			'3555b'										=> array( 'Nokia', '3555' ),
			'3600s'										=> array( 'Nokia', '3600 slide' ),
			'3610a'										=> array( 'Nokia', '3610 fold' ),
			'3710fold'									=> array( 'Nokia', '3710 fold' ),
			'3720c'										=> array( 'Nokia', '3720 classic' ),
			'5000!'										=> array( 'Nokia', '5000' ),
			'5130!'										=> array( 'Nokia', '5130 XpressMusic' ),
			'5220!'										=> array( 'Nokia', '5220 XpressMusic' ),
			'5330'										=> array( 'Nokia', '5330 Mobile TV Edition' ),
			'6208c'										=> array( 'Nokia', '6208 classic' ),
			'6212c'										=> array( 'Nokia', '6212 classic' ),
			'6260s!'									=> array( 'Nokia', '6260 slide' ),
			'6263!'										=> array( 'Nokia', '6263' ),
			'6300i'										=> array( 'Nokia', '6300i' ),
			'6303classic'								=> array( 'Nokia', '6303 classic' ),
			'6303iclassic'								=> array( 'Nokia', '6303i classic' ),
			'6303ci'									=> array( 'Nokia', '6303i classic' ),
			'6350'										=> array( 'Nokia', '6350' ),
			'6600f!'									=> array( 'Nokia', '6600 fold' ),
			'6600s!'									=> array( 'Nokia', '6600 slide' ),
			'6700c!'									=> array( 'Nokia', '6700 classic' ),
			'6750c'										=> array( 'Nokia', '6750 Mural' ),
			'7070!'										=> array( 'Nokia', '7070 Prism' ),
			'7100s!'									=> array( 'Nokia', '7100 Supernova' ),
			'7210s!'									=> array( 'Nokia', '7210 Supernova' ),
			'7210Supernova!'							=> array( 'Nokia', '7210 Supernova' ),					
			'7230'										=> array( 'Nokia', '7230' ),
			'7310c!'									=> array( 'Nokia', '7310 Supernova' ),
			'7510Supernova!'							=> array( 'Nokia', '7510 Supernova' ),
			'7610Supernova!'							=> array( 'Nokia', '7610 Supernova' ),
			'8800!'										=> array( 'Nokia', '8800 Arte' )
		);
		
		static $S60_MODELS = array(
			'U1i'										=> array( 'Sony Ericsson', 'Satio' ),
			'U5i'										=> array( 'Sony Ericsson', 'Vivaz' ),
			'U8i'										=> array( 'Sony Ericsson', 'Vivaz Pro' ),
			'I7710'										=> array( 'Samsung', 'GT-I7710' ),
			'I8510'										=> array( 'Samsung', 'INNOV8' ),
			'I8910'										=> array( 'Samsung', 'Omnia HD' ),
			'SGH-G810'									=> array( 'Samsung', 'G810' ),
			'C5-00!'									=> array( 'Nokia', 'C5-00' ),
			'C5-01'										=> array( 'Nokia', 'C5-01' ),
			'C5-03!'									=> array( 'Nokia', 'C5-03' ),
			'C5-04'										=> array( 'Nokia', 'C5-04' ),
			'C5-05'										=> array( 'Nokia', 'C5-05' ),
			'C5-06'										=> array( 'Nokia', 'C5-06' ),
			'C6-00!'									=> array( 'Nokia', 'C6-00' ),
			'C6-01!'									=> array( 'Nokia', 'C6-01' ),
			'C7-00'										=> array( 'Nokia', 'C7-00' ),
			'E5-00!'									=> array( 'Nokia', 'E5-00' ),
			'E6'										=> array( 'Nokia', 'E6-00' ),
			'E6-00'										=> array( 'Nokia', 'E6-00' ),
			'E7-00'										=> array( 'Nokia', 'E7-00' ),
			'N8-00'										=> array( 'Nokia', 'N8-00' ),
			'T7-00'										=> array( 'Nokia', 'T7-00' ),
			'X5-00'										=> array( 'Nokia', 'X5-00' ),
			'X5-01'										=> array( 'Nokia', 'X5-01' ),
			'X6-00!'									=> array( 'Nokia', 'X6-00' ),
			'X7-00'										=> array( 'Nokia', 'X7-00' ),
			'N-Gage'									=> array( 'Nokia', 'N-Gage' ),
			'N-GageQD'									=> array( 'Nokia', 'N-Gage QD' ),
			'E50!'										=> array( 'Nokia', 'E50' ),
			'E51!'										=> array( 'Nokia', 'E51' ),
			'E52!'										=> array( 'Nokia', 'E52' ),
			'E55!'										=> array( 'Nokia', 'E55' ),
			'E60!'										=> array( 'Nokia', 'E60' ),
			'E61i!'										=> array( 'Nokia', 'E61i' ),
			'E61!'										=> array( 'Nokia', 'E61' ),
			'E62!'										=> array( 'Nokia', 'E62' ),
			'E63!'										=> array( 'Nokia', 'E63' ),
			'E65!'										=> array( 'Nokia', 'E65' ),
			'E66!'										=> array( 'Nokia', 'E66' ),
			'E70!'										=> array( 'Nokia', 'E70' ),
			'E71x'										=> array( 'Nokia', 'E71x' ),
			'E71!'										=> array( 'Nokia', 'E71' ),
			'E72!'										=> array( 'Nokia', 'E72' ),
			'E73!'										=> array( 'Nokia', 'E73 Mode' ),
			'E75!'										=> array( 'Nokia', 'E75 '),
			'E90!'										=> array( 'Nokia', 'E90 Communicator '),
			'N70!'										=> array( 'Nokia', 'N70' ),
			'N71!'										=> array( 'Nokia', 'N71' ),
			'N72!'										=> array( 'Nokia', 'N72' ),
			'N73!'										=> array( 'Nokia', 'N73' ),
			'N75!'										=> array( 'Nokia', 'N75' ),
			'N76!'										=> array( 'Nokia', 'N76' ),
			'N77!'										=> array( 'Nokia', 'N77' ),
			'N78!'										=> array( 'Nokia', 'N78' ),
			'N79!'										=> array( 'Nokia', 'N79' ),
			'N80!'										=> array( 'Nokia', 'N80' ),
			'N81!'										=> array( 'Nokia', 'N81' ),
			'N82!'										=> array( 'Nokia', 'N82' ),
			'N85!'										=> array( 'Nokia', 'N85' ),
			'N86!'										=> array( 'Nokia', 'N86 8MP' ),
			'N90!'										=> array( 'Nokia', 'N90' ),
			'N91!'										=> array( 'Nokia', 'N91' ),
			'N92!'										=> array( 'Nokia', 'N92' ),
			'N93-1'										=> array( 'Nokia', 'N93' ),
			'N93i'										=> array( 'Nokia', 'N93i' ),
			'N95'										=> array( 'Nokia', 'N95' ),
			'N95 8GB'									=> array( 'Nokia', 'N95 8GB' ),
			'N95-3'										=> array( 'Nokia', 'N95-3 NAM' ),
			'N96-1'										=> array( 'Nokia', 'N96' ),
			'N96-3'										=> array( 'Nokia', 'N96-3' ),
			'N97'										=> array( 'Nokia', 'N97' ),
			'N97i'										=> array( 'Nokia', 'N97' ),
			'N97-1'										=> array( 'Nokia', 'N97' ),
			'N97-3'										=> array( 'Nokia', 'N97' ),
			'N97-4'										=> array( 'Nokia', 'N97 Mini' ),
			'N97-5'										=> array( 'Nokia', 'N97 Mini' ),
			'N97mini'									=> array( 'Nokia', 'N97 Mini' ),
			'500!'										=> array( 'Nokia', '500' ),
			'603'										=> array( 'Nokia', '603' ),
			'700'										=> array( 'Nokia', '700' ),
			'701'										=> array( 'Nokia', '701' ),
			'702T'										=> array( 'Nokia', '702T' ),
			'808!'										=> array( 'Nokia', '808 PureView' ),
			'5228'										=> array( 'Nokia', '5228' ),
			'5233!'										=> array( 'Nokia', '5228' ),
			'5230!'										=> array( 'Nokia', '5230' ),
			'5235'										=> array( 'Nokia', '5235 Ovi Music Unlimited' ),
			'5250'										=> array( 'Nokia', '5250' ),
			'5320!'										=> array( 'Nokia', '5320 XpressMusic' ),
			'5500d!'									=> array( 'Nokia', '5500 Sport' ),
			'5530!'										=> array( 'Nokia', '5530 XpressMusic' ),
			'5630!'										=> array( 'Nokia', '5630 XpressMusic' ),
			'5700!'										=> array( 'Nokia', '5700 XpressMusic' ),
			'5730!'										=> array( 'Nokia', '5730 XpressMusic' ),
			'5800!'										=> array( 'Nokia', '5800 XpressMusic' ),
			'6110Navigator'								=> array( 'Nokia', '6110 Navigator' ),
			'6120c!'									=> array( 'Nokia', '6120 classic' ),
			'6121c!'									=> array( 'Nokia', '6121 classic' ),
			'6124c'										=> array( 'Nokia', '6124 classic' ),
			'6210Navigator'								=> array( 'Nokia', '6210 Navigator' ),
			'6220c!'									=> array( 'Nokia', '6220 classic' ),
			'6290!'										=> array( 'Nokia', '6290' ),
			'6650d!'									=> array( 'Nokia', '6650 fold' ),
			'6700s'										=> array( 'Nokia', '6700 slide' ),
			'6710s'										=> array( 'Nokia', '6710 Navigator' ),
			'6720c'										=> array( 'Nokia', '6720 classic' ),
			'6730c'										=> array( 'Nokia', '6730 classic' ),
			'6760s!'									=> array( 'Nokia', '6760 slide' ),
			'6788'										=> array( 'Nokia', '6788' ),
			'6788i'										=> array( 'Nokia', '6788i' ),
			'6790s-1b!'									=> array( 'Nokia', '6790 Surge' ),
			'6790s-1c!'									=> array( 'Nokia', '6790 slide' ),
			'7610'										=> array( 'Nokia', '7610' )
		);
		
		static $FEATURE_MODELS = array(
			'CK13i'										=> array( 'Sony Ericsson', 'txt' ),
			'CK15a'										=> array( 'Sony Ericsson', 'txt Pro' ),
			'J105i'										=> array( 'Sony Ericsson', 'Naite' ),
			'J108[ai]!'									=> array( 'Sony Ericsson', 'Cedar' ),
			'J10i2'										=> array( 'Sony Ericsson', 'Elm' ),
			'J20'										=> array( 'Sony Ericsson', 'Hazel' ),
			'EX115'										=> array( 'Motorola', 'Starling EX115' ),
			'EX118'										=> array( 'Motorola', 'MOTOKEY XT EX118' ),
			'EX119'										=> array( 'Motorola', 'Brea EX119' ),
			'EX128'										=> array( 'Motorola', 'Kingfisher EX128' ),
			'EX225'										=> array( 'Motorola', 'MOTOKEY Social EX225' ),
			'EX226'										=> array( 'Motorola', 'MOTOKEY Social EX226' ),
			'EX430'										=> array( 'Motorola', 'MotoGo EX430' ),
			'KC910i'									=> array( 'LG', 'KC910i Renoir' ),
			'KP500!'									=> array( 'LG', 'KP500 Cookie' ),
			'KU990i'									=> array( 'LG', 'KU990 Viewty' ),
			'GM360'										=> array( 'LG', 'GM360 Viewty Snap' ),
			'GS500'										=> array( 'LG', 'GS500 Cookie Plus' ),
			'GT550'										=> array( 'LG', 'GT550 Encore' ),
			'GT-C3322'									=> array( 'Samsung', 'GT-C3322 Duos' ),
			'GT-E2152'									=> array( 'Samsung', 'GT-E2152 Duos' ),
			'GT-S3350'									=> array( 'Samsung', 'Ch@t 335' ),
			'GT-S3570'									=> array( 'Samsung', 'Ch@t 357' ),
			'GT-S5229'									=> array( 'Samsung', 'Tocco Lite 2' ),
			'GT-S5610!'									=> array( 'Samsung', 'Primo' ),
			'SGH-A667'									=> array( 'Samsung', 'A667 Evergreen' ),
			'SGH-A877'									=> array( 'Samsung', 'A877 Impression' ),
			'SGH-S390G'									=> array( 'Samsung', 'S390 TracFone' )
		);
		
		static $BLACKBERRY_MODELS = array(
			'9000'		=> 'Bold',
			'9600'		=> 'Bold',
			'9650'		=> 'Bold',
			'9700'		=> 'Bold',
			'9780'		=> 'Bold',
			'9790'		=> 'Bold',
			'9900'		=> 'Bold',
			'9930'		=> 'Bold',
			'8300'		=> 'Curve',
			'8310'		=> 'Curve',
			'8320'		=> 'Curve',
			'8330'		=> 'Curve',
			'8350i'		=> 'Curve',
			'8520'		=> 'Curve',
			'8530'		=> 'Curve',
			'8900'		=> 'Curve',
			'9220'		=> 'Curve',
			'9300'		=> 'Curve',
			'9310'		=> 'Curve',
			'9320'		=> 'Curve',
			'9330'		=> 'Curve',
			'9350'		=> 'Curve',
			'9360'		=> 'Curve',
			'9370'		=> 'Curve',
			'9380'		=> 'Curve',
			'8100'		=> 'Pearl',
			'8110'		=> 'Pearl',
			'8120'		=> 'Pearl',
			'8130'		=> 'Pearl',
			'8220'		=> 'Pearl',
			'8230'		=> 'Pearl',
			'9100'		=> 'Pearl',
			'9105'		=> 'Pearl',
			'9500'		=> 'Storm',
			'9530'		=> 'Storm',
			'9550'		=> 'Storm',
			'9670'		=> 'Style',
			'9800'		=> 'Torch',
			'9810'		=> 'Torch',
			'9850'		=> 'Torch',
			'9860'		=> 'Torch',
			'9630'		=> 'Tour',
			'9981'		=> 'Porsche P'
		);
		
	
	
		function identify($type, $model) {
			switch($type) {
				case 'android':		return DeviceModels::identifyAndroid($model);
				case 'blackberry':	return DeviceModels::identifyBlackBerry($model);
				case 'bada': 		return DeviceModels::identifyList(DeviceModels::$BADA_MODELS, $model);
				case 'brew': 		return DeviceModels::identifyList(DeviceModels::$BREW_MODELS, $model);
				case 'tizen': 		return DeviceModels::identifyList(DeviceModels::$TIZEN_MODELS, $model);
				case 'touchwiz': 	return DeviceModels::identifyList(DeviceModels::$TOUCHWIZ_MODELS, $model);
				case 'wm': 			return DeviceModels::identifyList(DeviceModels::$WINDOWS_MOBILE_MODELS, $model);
				case 'wp': 			return DeviceModels::identifyList(DeviceModels::$WINDOWS_PHONE_MODELS, $model);
				case 's40': 		return DeviceModels::identifyList(DeviceModels::$S40_MODELS, $model);
				case 's60': 		return DeviceModels::identifyList(DeviceModels::$S60_MODELS, $model);
				case 'feature': 	return DeviceModels::identifyList(DeviceModels::$FEATURE_MODELS, $model);
			}

			return (object) array('type' => '', 'model' => $model, 'identified' => false);
		}
		
		function identifyAndroid($model) {
			$result = DeviceModels::identifyList(DeviceModels::$ANDROID_MODELS, $model);

			if (!$result->identified) {
				$model = DeviceModels::cleanup($model);
				if (preg_match('/AndroVM/i', $model)  || $model == 'Emulator' || $model == 'x86 Emulator' || $model == 'x86 VirtualBox' || $model == 'vm') {
					return (object) array(
						'type'			=> 'emulator',
						'identified'	=> true,
						'manufacturer'	=> null,
						'model'			=> null
					);
				}
			}
			
			return $result;
		}
		
		function identifyBlackBerry($model) {
			if (isset(DeviceModels::$BLACKBERRY_MODELS[$model])) return 'BlackBerry ' . DeviceModels::$BLACKBERRY_MODELS[$model] . ' ' . $model;
			return 'BlackBerry ' . $model;
		}
		
		function identifyList($list, $model) {
			$model = DeviceModels::cleanup($model);
			
			$device = (object) array(
				'type'			=> TYPE_MOBILE,
				'identified'	=> false,
				'manufacturer'	=> null,
				'model'			=> $model
			);

			foreach ($list as $m => $v) {
				$match = false;
				if (substr($m, -1) == "!") 
					$match = preg_match('/^' . substr($m, 0, -1) . '/i', $model);
				else
					$match = strtolower($m) == strtolower($model);
				
				if ($match) {
 					$device->manufacturer = $v[0];
					$device->model = $v[1];
					if (isset($v[2])) $device->type = $v[2];
					if (isset($v[3])) $device->flag = $v[3];
					$device->identified = true;
					return $device;
				}
			}
			
			return $device;
		}
		
		function cleanup($s = '') {
			$s = preg_replace('/\/[^\/]+$/', '', $s);
			$s = preg_replace('/\/[^\/]+ Android\/.*/', '', $s);
			
			$s = preg_replace('/UCBrowser$/', '', $s);

			$s = preg_replace('/_TD$/', '', $s);
			$s = preg_replace('/_CMCC$/', '', $s);
			
			$s = preg_replace('/_/', ' ', $s);
			$s = preg_replace('/^\s+|\s+$/', '', $s);
			
			$s = preg_replace('/^tita on /', '', $s);
			$s = preg_replace('/^De-Sensed /', '', $s);
			$s = preg_replace('/^ICS AOSP on /', '', $s);
			$s = preg_replace('/^Baidu Yi on /', '', $s);
			$s = preg_replace('/^Buildroid for /', '', $s);
			$s = preg_replace('/^Android (on |for )/', '', $s);
			$s = preg_replace('/^Generic Android on /', '', $s);
			$s = preg_replace('/^Full JellyBean( on )?/', '', $s);			
			$s = preg_replace('/^Full (AOSP on |Android on |Cappuccino on |MIPS Android on |Android)/', '', $s);

			$s = preg_replace('/^Acer( |-)?/i', '', $s);
			$s = preg_replace('/^Iconia( Tab)? /', '', $s);
			$s = preg_replace('/^ASUS ?/', '', $s);
			$s = preg_replace('/^Ainol /', '', $s);
			$s = preg_replace('/^Coolpad ?/i', 'Coolpad ', $s);
			$s = preg_replace('/^ALCATEL /', '', $s);
			$s = preg_replace('/^Alcatel OT-(.*)/', 'one touch $1', $s);
			$s = preg_replace('/^YL-/', '', $s);
			$s = preg_replace('/^Novo7 ?/i', 'Novo7 ', $s);
			$s = preg_replace('/^G[iI]ONEE[ -]/', '', $s);
			$s = preg_replace('/^HW-/', '', $s);
			$s = preg_replace('/^Huawei[ -]/i', 'Huawei ', $s);
			$s = preg_replace('/^SAMSUNG[ -]/i', '', $s);
			$s = preg_replace('/^SAMSUNG SAMSUNG-/i', '', $s);
			$s = preg_replace('/^(Sony ?Ericsson|Sony)/', '', $s);
			$s = preg_replace('/^(Lenovo Lenovo|LNV-Lenovo|LENOVO-Lenovo)/', 'Lenovo', $s);
			$s = preg_replace('/^Lenovo-/', 'Lenovo', $s);
			$s = preg_replace('/^ZTE-/', 'ZTE ', $s);
			$s = preg_replace('/^(LG)[ _\/]/', '$1-', $s);
			$s = preg_replace('/^(HTC.*)\s(?:v|V)?[0-9.]+$/', '$1', $s);
			$s = preg_replace('/^(HTC)[-\/]/', '$1', $s);
			$s = preg_replace('/^(HTC)([A-Z][0-9][0-9][0-9])/', '$1 $2', $s);
			$s = preg_replace('/^(Motorola[\s|-])/', '', $s);
			$s = preg_replace('/^(Moto|MOT-)/', '', $s);

			$s = preg_replace('/-?(orange(-ls)?|vodafone|bouygues|parrot|Kust)$/i', '', $s);
			$s = preg_replace('/http:\/\/.+$/i', '', $s);
			$s = preg_replace('/^\s+|\s+$/', '', $s);
			
			return $s;
		}
	}

	class Version {
		var $value = null;
	
		function __construct($options = null) {
			if (is_array($options)) {
				if (isset($options['value'])) $this->value = $options['value'];
				if (isset($options['alias'])) $this->alias = $options['alias'];
				if (isset($options['details'])) $this->details = $options['details'];
			}
		}
		
		function toFloat() {
			return floatval($this->value);
		}

		function toNumber() {
			return intval($this->value);
		}
	}

	class Detected {
		
		function __construct($headers) {
			$this->headers = $headers;
			
			$this->browser = (object) array('stock' => true, 'hidden' => false, 'channel' => '', 'mode' => '');
			$this->engine = (object) array();
			$this->os = (object) array();
			$this->device = (object) array('type' => '', 'identified' => false);
		
			$this->analyseUserAgent($this->headers['User-Agent']);
			
			if (isset($this->headers['X-OperaMini-Phone-UA'])) $this->analyseAlternativeUserAgent($this->headers['X-OperaMini-Phone-UA']);
			if (isset($this->headers['X-UCBrowser-Phone-UA'])) $this->analyseUCUserAgent($this->headers['X-UCBrowser-Phone-UA']);
			if (isset($this->headers['X-Puffin-UA'])) $this->analysePuffinUserAgent($this->headers['X-Puffin-UA']);

			if (isset($this->headers['X-Original-User-Agent'])) $this->analyseAlternativeUserAgent($this->headers['X-Original-User-Agent']);
			if (isset($this->headers['X-Device-User-Agent'])) $this->analyseAlternativeUserAgent($this->headers['X-Device-User-Agent']);
			if (isset($this->headers['Device-Stock-UA'])) $this->analyseAlternativeUserAgent($this->headers['Device-Stock-UA']);

			if (isset($this->headers['X-Requested-With'])) $this->analyseBrowserId($this->headers['X-Requested-With']);
		}
		
		function analyseBrowserId($id) {
			$browser = BrowserIds::identify('android', $id);
			if ($browser) {
				if (!isset($this->browser->name) || $this->browser->name != $browser) {
					$this->browser->name = $browser;
					$this->browser->version = null;
					$this->browser->stock = false;
				}
			}

			if ($this->os->name != 'Android' && $this->os->name != 'Aliyun OS') {
				$this->os->name = 'Android';
				$this->os->version = null;
				
				$this->device->manufacturer = null;
				$this->device->model = null;
				$this->device->identified = false;
				
				if ($this->device->type != TYPE_MOBILE && $this->device->type != TYPE_TABLET) {
					$this->device->type = TYPE_MOBILE;
				}
			}
			
			if ($this->engine->name != 'Webkit') {
				$this->engine->name = 'Webkit';
				$this->engine->version = null;
			}
		}
		
		function analyseAlternativeUserAgent($ua) {
			$extra = new Detected(array("User-Agent" => $ua));
			if ($extra->device->type != TYPE_DESKTOP) {
				if (isset($extra->os->version)) $this->os = $extra->os;
				if ($extra->device->identified) $this->device = $extra->device;
			}
		}

		function analyseUCUserAgent($ua) {
			if ($this->device->type == TYPE_DESKTOP) {
				$this->device->type = TYPE_MOBILE;

				unset($this->os->name);
				unset($this->os->version);
			}
			if ($this->browser->name != 'UC Browser') {
				$this->browser->name = 'UC Browser';
				$this->browser->version = null;
			}

			$extra = new Detected(array("User-Agent" => $ua));
			if ($extra->device->type != TYPE_DESKTOP) {
				if (isset($extra->os->version)) $this->os = $extra->os;
				if ($extra->device->identified) $this->device = $extra->device;
			}
		}
				
		function analysePuffinUserAgent($ua) {
			$parts = explode('/', $ua);
			
			if ($this->browser->name != 'Puffin') {
				$this->browser->name = 'Puffin';
				$this->browser->version = null;
				$this->browser->stock = false;
			}
		
			$this->device->type = 'mobile';
			
			if (count($parts) > 1 && $parts[0] == 'Android') {
				if (!isset($this->os->name) || $this->os->name != 'Android') {
					$this->os->name = 'Android';
					$this->os->version = null;
				}

				$device = DeviceModels::identify('android', $parts[1]);
				if ($device->identified) {
					$this->device = $device;
				}
			}

			if (count($parts) > 1 && $parts[0] == 'iPhone OS') {
				if (!isset($this->os->name) || $this->os->name != 'iOS') {
					$this->os->name = 'iOS';
					$this->os->version = null;
				}
				
				if (preg_match('/iPod( touch)?/', $parts[1])) {
					$this->device->type = TYPE_MEDIA;
					$this->device->manufacturer = 'Apple';
					$this->device->model = 'iPod touch';
				} 
				else if (preg_match('/(?:Unknown )?iPhone( 3G| 3GS| 4| 4S| 5)?/', $parts[1], $match)) {
					$this->device->type = TYPE_MOBILE;
					$this->device->manufacturer = 'Apple';
					$this->device->model = 'iPhone' . (isset($match[1]) ? $match[1] : '');
				} 
				else if (preg_match('/iPad/', $parts[1])) {
					$this->device->type = TYPE_TABLET;
					$this->device->manufacturer = 'Apple';
					$this->device->model = 'iPad';
				}
				
				$this->device->identified = true;
			}
		}
		
		function analyseUserAgent($ua) {
			
			/****************************************************
			 *		Unix
			 */
		
			if (preg_match('/Unix/', $ua)) {
				$this->os->name = 'Unix';
			}
			
			/****************************************************
			 *		FreeBSD
			 */
		
			if (preg_match('/FreeBSD/', $ua)) {
				$this->os->name = 'FreeBSD';
			}
			
			/****************************************************
			 *		OpenBSD
			 */
		
			if (preg_match('/OpenBSD/', $ua)) {
				$this->os->name = 'OpenBSD';
			}
			
			/****************************************************
			 *		NetBSD
			 */
		
			if (preg_match('/NetBSD/', $ua)) {
				$this->os->name = 'NetBSD';
			}
			
			
			/****************************************************
			 *		Solaris
			 */
		
			if (preg_match('/SunOS/', $ua)) {
				$this->os->name = 'Solaris';
			}
			
			
			/****************************************************
			 *		IRIX
			 */
		
			if (preg_match('/IRIX/', $ua)) {
				$this->os->name = 'IRIX';

				if (preg_match('/IRIX ([0-9.]*)/', $ua, $match)) {
					$this->os->version = new Version(array('value' => $match[1]));
				}

				if (preg_match('/IRIX;(?:64|32) ([0-9.]*)/', $ua, $match)) {
					$this->os->version = new Version(array('value' => $match[1]));
				}
			}
			
			
			/****************************************************
			 *		Syllable
			 */
		
			if (preg_match('/Syllable/', $ua)) {
				$this->os->name = 'Syllable';
			}
			
			
			/****************************************************
			 *		Linux
			 */
		
			if (preg_match('/Linux/', $ua)) {
				$this->os->name = 'Linux';

				if (preg_match('/CentOS/', $ua)) {
					$this->os->name = 'CentOS';
					if (preg_match('/CentOS\/[0-9\.\-]+el([0-9_]+)/', $ua, $match)) {
						$this->os->version = new Version(array('value' => str_replace('_', '.', $match[1])));
					}

					$this->device->type = TYPE_DESKTOP;
				}

				if (preg_match('/Debian/', $ua)) {
					$this->os->name = 'Debian';
					$this->device->type = TYPE_DESKTOP;
				}
				
				if (preg_match('/Fedora/', $ua)) {
					$this->os->name = 'Fedora';
					if (preg_match('/Fedora\/[0-9\.\-]+fc([0-9]+)/', $ua, $match)) {
						$this->os->version = new Version(array('value' => str_replace('_', '.', $match[1])));
					}

					$this->device->type = TYPE_DESKTOP;
				}

				if (preg_match('/Gentoo/', $ua)) {
					$this->os->name = 'Gentoo';
					$this->device->type = TYPE_DESKTOP;
				}
				
				if (preg_match('/Kubuntu/', $ua)) {
					$this->os->name = 'Kubuntu';
					$this->device->type = TYPE_DESKTOP;
				}
				
				if (preg_match('/Mandriva Linux/', $ua)) {
					$this->os->name = 'Mandriva';
					if (preg_match('/Mandriva Linux\/[0-9\.\-]+mdv([0-9]+)/', $ua, $match)) {
						$this->os->version = new Version(array('value' => $match[1]));
					}

					$this->device->type = TYPE_DESKTOP;
				}

				if (preg_match('/Mageia/', $ua)) {
					$this->os->name = 'Mageia';
					if (preg_match('/Mageia\/[0-9\.\-]+mga([0-9]+)/', $ua, $match)) {
						$this->os->version = new Version(array('value' => $match[1]));
					}

					$this->device->type = TYPE_DESKTOP;
				}

				if (preg_match('/Red Hat/', $ua)) {
					$this->os->name = 'Red Hat';
					if (preg_match('/Red Hat[^\/]*\/[0-9\.\-]+el([0-9_]+)/', $ua, $match)) {
						$this->os->version = new Version(array('value' => str_replace('_', '.', $match[1])));
					}

					$this->device->type = TYPE_DESKTOP;
				}

				if (preg_match('/Slackware/', $ua)) {
					$this->os->name = 'Slackware';
					$this->device->type = TYPE_DESKTOP;
				}
				
				if (preg_match('/SUSE/', $ua)) {
					$this->os->name = 'SUSE';
					$this->device->type = TYPE_DESKTOP;
				}
				
				if (preg_match('/Turbolinux/', $ua)) {
					$this->os->name = 'Turbolinux';
					$this->device->type = TYPE_DESKTOP;
				}
				
				if (preg_match('/Ubuntu/', $ua)) {
					$this->os->name = 'Ubuntu';
					if (preg_match('/Ubuntu\/([0-9.]*)/', $ua, $match)) {
						$this->os->version = new Version(array('value' => $match[1]));
					}

					$this->device->type = TYPE_DESKTOP;
				}
			}
			
			
			/****************************************************
			 *		iOS
			 */
		
			if (preg_match('/iPhone( Simulator| 3G| 3GS| 4| 4S| 5)?;/', $ua) || preg_match('/iPad;/', $ua) || preg_match('/iPod( touch)?;/', $ua)) {
				$this->os->name = 'iOS';
				$this->os->version = new Version(array('value' => '1.0'));

				if (preg_match('/OS (.*) like Mac OS X/', $ua, $match)) {
					$this->os->version = new Version(array('value' => str_replace('_', '.', $match[1])));
				}

				if (preg_match('/iPhone Simulator;/', $ua)) {
					$this->device->type = TYPE_EMULATOR;
				} 
				else if (preg_match('/iPod( touch)?;/', $ua)) {
					$this->device->type = TYPE_MEDIA;
					$this->device->manufacturer = 'Apple';
					$this->device->model = 'iPod touch';
				} 
				else if (preg_match('/iPhone( 3G| 3GS| 4| 4S| 5)?;/', $ua, $match)) {
					$this->device->type = TYPE_MOBILE;
					$this->device->manufacturer = 'Apple';
					$this->device->model = 'iPhone' . (isset($match[1]) ? $match[1] : '');
				} 
				else {
					$this->device->type = TYPE_TABLET;
					$this->device->manufacturer = 'Apple';
					$this->device->model = 'iPad';
				}
				
				$this->device->identified = true;
				
				if (preg_match('/((iPad|iPhone|iPod)[0-9],[0-9])/', $ua, $match)) {
					$this->device->manufacturer = 'Apple';

					switch($match[2]) {
						case 'iPad': 		$this->device->type = TYPE_TABLET; break;	
						case 'iPhone': 		$this->device->type = TYPE_MOBILE; break;	
						case 'iPod': 		$this->device->type = TYPE_MEDIA; break;	
					}
					
					switch($match[1]) {
						case 'iPad1,1':
						case 'iPad1,2':		$this->device->model = 'iPad'; break;
						case 'iPad2,1':	
						case 'iPad2,2':	
						case 'iPad2,3':	
						case 'iPad2,4':		$this->device->model = 'iPad 2'; break;
						case 'iPad2,5':	
						case 'iPad2,6':	
						case 'iPad2,7':		$this->device->model = 'iPad mini'; break;
						case 'iPad3,1':	
						case 'iPad3,2':	
						case 'iPad3,3':		$this->device->model = 'iPad (3rd gen)'; break;
						case 'iPad3,4':	
						case 'iPad3,5':	
						case 'iPad3,6':		$this->device->model = 'iPad (4th gen)'; break;
						
						case 'iPhone1,1':	$this->device->model = 'iPhone'; break;
						case 'iPhone1,2':	$this->device->model = 'iPhone 3G'; break;
						case 'iPhone2,1':	$this->device->model = 'iPhone 3GS'; break;
						case 'iPhone3,1':
						case 'iPhone3,2':
						case 'iPhone3,3':	$this->device->model = 'iPhone 4'; break;
						case 'iPhone4,1':	$this->device->model = 'iPhone 4S'; break;
						case 'iPhone5,1':
						case 'iPhone5,2':	$this->device->model = 'iPhone 5'; break;
						
						case 'iPod1,1':		$this->device->model = 'iPod touch'; break;
						case 'iPod2,1':		$this->device->model = 'iPod touch (2nd gen)'; break;
						case 'iPod3,1':		$this->device->model = 'iPod touch (3rd gen)'; break;
						case 'iPod4,1':		$this->device->model = 'iPod touch (4th gen)'; break;
						case 'iPod5,1':		$this->device->model = 'iPod touch (5th gen)'; break;
					}
				}
			}
			
			
			/****************************************************
			 *		OS X
			 */
		
			else if (preg_match('/Mac OS X/', $ua)) {
				$this->os->name = 'Mac OS X';

				if (preg_match('/Mac OS X (10[0-9\._]*)/', $ua, $match)) {
					$this->os->version = new Version(array('value' => str_replace('_', '.', $match[1])));
				}

				$this->device->type = TYPE_DESKTOP;
			}


			/****************************************************
			 *		Windows
			 */
			 
			if (preg_match('/Windows/', $ua)) {
				$this->os->name = 'Windows';
				$this->device->type = TYPE_DESKTOP;

				if (preg_match('/Windows NT ([0-9]\.[0-9])/', $ua, $match)) {
					$this->os->version = new Version(array('value' => $match[1]));
					
					switch($match[1]) {
						case '6.3':		if (preg_match('/; ARM;/', $ua))
											$this->os->version = new Version(array('value' => $match[1], 'alias' => 'RT 8.1')); 
										else
											$this->os->version = new Version(array('value' => $match[1], 'alias' => '8.1')); 
										break;
										
						case '6.2':		if (preg_match('/; ARM;/', $ua))
											$this->os->version = new Version(array('value' => $match[1], 'alias' => 'RT')); 
										else
											$this->os->version = new Version(array('value' => $match[1], 'alias' => '8')); 
										break;
										
						case '6.1':		$this->os->version = new Version(array('value' => $match[1], 'alias' => '7')); break;
						case '6.0':		$this->os->version = new Version(array('value' => $match[1], 'alias' => 'Vista')); break;
						case '5.2':		$this->os->version = new Version(array('value' => $match[1], 'alias' => 'Server 2003')); break;
						case '5.1':		$this->os->version = new Version(array('value' => $match[1], 'alias' => 'XP')); break;
						case '5.0':		$this->os->version = new Version(array('value' => $match[1], 'alias' => '2000')); break;
						default:		$this->os->version = new Version(array('value' => $match[1], 'alias' => 'NT ' . $match[1])); break;
					}
				}
				
				if (preg_match('/Windows 95/', $ua) || preg_match('/Win95/', $ua) || preg_match('/Win 9x 4.00/', $ua)) {
					$this->os->version = new Version(array('value' => '4.0', 'alias' => '95')); 
				}

				if (preg_match('/Windows 98/', $ua) || preg_match('/Win98/', $ua) || preg_match('/Win 9x 4.10/', $ua)) {
					$this->os->version = new Version(array('value' => '4.1', 'alias' => '98')); 
				}

				if (preg_match('/Windows ME/', $ua) || preg_match('/WinME/', $ua) || preg_match('/Win 9x 4.90/', $ua)) {
					$this->os->version = new Version(array('value' => '4.9', 'alias' => 'ME')); 
				}

				if (preg_match('/Windows XP/', $ua) || preg_match('/WinXP/', $ua)) {
					$this->os->version = new Version(array('value' => '5.1', 'alias' => 'XP')); 
				}

				if (preg_match('/WPDesktop/', $ua)) {
					$this->os->name = 'Windows Phone';
					$this->os->version = new Version(array('value' => '8', 'details' => 1)); 
					$this->device->type = TYPE_MOBILE;
				}
				
				if (preg_match('/WP7/', $ua)) {
					$this->os->name = 'Windows Phone';
					$this->os->version = new Version(array('value' => '7', 'details' => 1)); 
					$this->device->type = TYPE_MOBILE;
					$this->browser->mode = 'desktop';
				}

				if (preg_match('/Windows CE/', $ua) || preg_match('/WinCE/', $ua) || preg_match('/WindowsCE/', $ua)) {
					if (preg_match('/ IEMobile/', $ua)) {
						$this->os->name = 'Windows Mobile';

						if (preg_match('/ IEMobile 8/', $ua)) {
							$this->os->version = new Version(array('value' => '6.5', 'details' => 2)); 
						}
	
						if (preg_match('/ IEMobile 7/', $ua)) {
							$this->os->version = new Version(array('value' => '6.1', 'details' => 2)); 
						}
	
						if (preg_match('/ IEMobile 6/', $ua)) {
							$this->os->version = new Version(array('value' => '6.0', 'details' => 2)); 
						}
					}
					else {
						$this->os->name = 'Windows CE';
						
						if (preg_match('/WindowsCEOS\/([0-9.]*)/', $ua, $match)) {
							$this->os->version = new Version(array('value' => $match[1], 'details' => 2));
						}
	
						if (preg_match('/Windows CE ([0-9.]*)/', $ua, $match)) {
							$this->os->version = new Version(array('value' => $match[1], 'details' => 2));
						}
					}
										
					$this->device->type = TYPE_MOBILE;
				}

				if (preg_match('/Windows ?Mobile/', $ua)) {
					$this->os->name = 'Windows Mobile';
					$this->device->type = TYPE_MOBILE;
				}

				if (preg_match('/WindowsMobile\/([0-9.]*)/', $ua, $match)) {
					$this->os->name = 'Windows Mobile';
					$this->os->version = new Version(array('value' => $match[1], 'details' => 2));
					$this->device->type = TYPE_MOBILE;
				}

				if (preg_match('/Windows Phone/', $ua)) {
					$this->os->name = 'Windows Phone';
					$this->device->type = TYPE_MOBILE;
					
					if (preg_match('/Windows Phone (?:OS )?([0-9.]*)/', $ua, $match)) {
						$this->os->version = new Version(array('value' => $match[1], 'details' => 2));

						if (intval($match[1]) < 7) {
							$this->os->name = 'Windows Mobile';
						}						
					}
					
					if (preg_match('/IEMobile\/[^;]+;(?: ARM; Touch; )?([^;]+); ([^;]+)[;|\)]/', $ua, $match)) {
						$this->device = DeviceModels::identify('wp', $match[2]);
						
						if (!$this->device->identified) {
							$this->device->manufacturer = $match[1];
							$this->device->model = $match[2];
						}
					}						

					if ($this->device->manufacturer == 'Microsoft' && $this->device->model == 'XDeviceEmulator') {
						$this->device->manufacturer = null;
						$this->device->model = null;
						$this->device->type = TYPE_EMULATOR;
						$this->device->identified = true;
					}
				}
			}



			/****************************************************
			 *		Android
			 */
		
			if (preg_match('/Android/', $ua)) {
				$this->os->name = 'Android';
				$this->os->version = new Version(); 

				if (preg_match('/Android(?: )?(?:AllPhone_|CyanogenMod_)?(?:\/)?v?([0-9.]+)/', str_replace('-update', ',', $ua), $match)) {
					$this->os->version = new Version(array('value' => $match[1], 'details' => 3));
				}
				
				if (preg_match('/Android [0-9][0-9].[0-9][0-9].[0-9][0-9]\(([^)]+)\);/', str_replace('-update', ',', $ua), $match)) {
					$this->os->version = new Version(array('value' => $match[1], 'details' => 3));
				}
				
				if (preg_match('/Android Eclair/', $ua)) {
					$this->os->version = new Version(array('value' => '2.0', 'details' => 3));
				}
				
				$this->device->type = TYPE_MOBILE;
				if ($this->os->version->toFloat() >= 3) $this->device->type = TYPE_TABLET;
				if ($this->os->version->toFloat() >= 4 && preg_match('/Mobile/', $ua)) $this->device->type = TYPE_MOBILE;


				if (preg_match('/Eclair; (?:[a-zA-Z][a-zA-Z](?:[-_][a-zA-Z][a-zA-Z])?) Build\/([^\/]*)\//', $ua, $match)) {
					$this->device->model = $match[1];
				}
				
				else if (preg_match('/; ([^;]*[^;\s])\s+Build/', $ua, $match)) {
					$this->device->model = $match[1];
				}		
				
				else if (preg_match('/[a-zA-Z][a-zA-Z](?:[-_][a-zA-Z][a-zA-Z])?; ([^;]*[^;\s]);\s+Build/', $ua, $match)) {
					$this->device->model = $match[1];
				}		
				
				else if (preg_match('/\(([^;]+);U;Android\/[^;]+;[0-9]+\*[0-9]+;CTC\/2.0\)/', $ua, $match)) {
					$this->device->model = $match[1];
				}		
				
				else if (preg_match('/;\s?([^;]+);\s?[0-9]+\*[0-9]+;\s?CTC\/2.0/', $ua, $match)) {
					$this->device->model = $match[1];
				}		
				
				else if (preg_match('/Android [^;]+; (?:[a-zA-Z][a-zA-Z](?:[-_][a-zA-Z][a-zA-Z])?; )?([^)]+)\)/', $ua, $match)) {
					if (!preg_match('/[a-zA-Z][a-zA-Z](?:[-_][a-zA-Z][a-zA-Z])?/', $ua)) {
						$this->device->model = $match[1];
					}
				}	
				
				/* Sometimes we get a model name that starts with Android, in that case it is a mismatch and we should ignore it */
				if (isset($this->device->model) && substr($this->device->model, 0, 7) == 'Android') {
					$this->device->model = null;
				}
				
				if (isset($this->device->model)) {
					$this->device = DeviceModels::identify('android', $this->device->model);
				}
				
				if (preg_match('/HP eStation/', $ua)) 	{ $this->device->manufacturer = 'HP'; $this->device->model = 'eStation'; $this->device->type = TYPE_TABLET; $this->device->identified = true; }
				if (preg_match('/Pre\/1.0/', $ua)) 		{ $this->device->manufacturer = 'Palm'; $this->device->model = 'Pre'; $this->device->identified = true; }
				if (preg_match('/Pre\/1.1/', $ua)) 		{ $this->device->manufacturer = 'Palm'; $this->device->model = 'Pre Plus'; $this->device->identified = true; }
				if (preg_match('/Pre\/1.2/', $ua)) 		{ $this->device->manufacturer = 'Palm'; $this->device->model = 'Pre 2'; $this->device->identified = true; }
				if (preg_match('/Pre\/3.0/', $ua)) 		{ $this->device->manufacturer = 'HP'; $this->device->model = 'Pre 3'; $this->device->identified = true; }
				if (preg_match('/Pixi\/1.0/', $ua)) 	{ $this->device->manufacturer = 'Palm'; $this->device->model = 'Pixi'; $this->device->identified = true; }
				if (preg_match('/Pixi\/1.1/', $ua)) 	{ $this->device->manufacturer = 'Palm'; $this->device->model = 'Pixi Plus'; $this->device->identified = true; }
				if (preg_match('/P160UN?A?\/1.0/', $ua)) { $this->device->manufacturer = 'HP'; $this->device->model = 'Veer'; $this->device->identified = true; }
			}



			/****************************************************
			 *		Aliyun OS
			 */
		
			if (preg_match('/Aliyun/', $ua)) {
				$this->os->name = 'Aliyun OS';
				$this->os->version = new Version(); 

				if (preg_match('/YunOs ([0-9.]+)/', $ua, $match)) {
					$this->os->version = new Version(array('value' => $match[1], 'details' => 3));
				}

				if (preg_match('/AliyunOS ([0-9.]+)/', $ua, $match)) {
					$this->os->version = new Version(array('value' => $match[1], 'details' => 3));
				}

				$this->device->type = TYPE_MOBILE;

				if (preg_match('/; ([^;]*[^;\s])\s+Build/', $ua, $match)) {
					$this->device->model = $match[1];
				}
				
				if ($this->device->model) {
					$this->device = DeviceModels::identify('android', $this->device->model);
				}
			}

			if (preg_match('/Android/', $ua)) {
				if (preg_match('/Android v(1.[0-9][0-9])_[0-9][0-9].[0-9][0-9]-/', $ua, $match)) {
					$this->os->name = 'Aliyun OS';
					$this->os->version = new Version(array('value' => $match[1], 'details' => 3));
				}

				if (preg_match('/Android (1.[0-9].[0-9].[0-9]+)-R?T/', $ua, $match)) {
					$this->os->name = 'Aliyun OS';
					$this->os->version = new Version(array('value' => $match[1], 'details' => 3));
				}

				if (preg_match('/Android (2.[0-9].[0-9]+)-R-20[0-9]+/', $ua, $match)) {
					$this->os->name = 'Aliyun OS';
					$this->os->version = new Version(array('value' => $match[1], 'details' => 3));
				}

				if (preg_match('/Android 20[0-9]+/', $ua, $match)) {
					$this->os->name = 'Aliyun OS';
					$this->os->version = null;
				}
			}
			
			
			
			/****************************************************
			 *		Baidu Yi
			 */
		
			if (preg_match('/Baidu Yi/', $ua)) {
				$this->os->name = 'Baidu Yi';
				$this->os->version = null;
			} 
				
				
			

			/****************************************************
			 *		Google TV
			 */
		
			if (preg_match('/GoogleTV/', $ua)) {
				$this->os->name = 'Google TV';
				
				/*
				if (preg_match('/Chrome\/5./', $ua)) {
					$this->os->version = new Version(array('value' => '1'));
				}

				if (preg_match('/Chrome\/11./', $ua)) {
					$this->os->version = new Version(array('value' => '2'));
				}
				*/

				$this->device->type = TYPE_TELEVISION;
			}



			/****************************************************
			 *		WoPhone
			 */
		
			if (preg_match('/WoPhone/', $ua)) {
				$this->os->name = 'WoPhone';

				if (preg_match('/WoPhone\/([0-9\.]*)/', $ua, $match)) {
					$this->os->version = new Version(array('value' => $match[1]));
				}

				$this->device->type = TYPE_MOBILE;
			}
			
			/****************************************************
			 *		BlackBerry
			 */
		
			if (preg_match('/BlackBerry/', $ua) && !preg_match('/BlackBerry Runtime for Android Apps/', $ua)) {
				$this->os->name = 'BlackBerry OS';
				
				if (!preg_match('/Opera/', $ua)) {
					if (preg_match('/BlackBerry([0-9]*)\/([0-9.]*)/', $ua, $match)) {
						$this->device->model = $match[1];
						$this->os->version = new Version(array('value' => $match[2], 'details' => 2));
					}
					
					if (preg_match('/; BlackBerry ([0-9]*);/', $ua, $match)) {
						$this->device->model = $match[1];
					}

					if (preg_match('/; ([0-9]+)[^;\)]+\)/', $ua, $match)) {
						$this->device->model = $match[1];
					}
					
					if (preg_match('/Version\/([0-9.]*)/', $ua, $match)) {
						$this->os->version = new Version(array('value' => $match[1], 'details' => 2));
					}

					if ($this->os->version->toFloat() >= 10) {
						$this->os->name = 'BlackBerry';
					}

					if (isset($this->device->model)) {					
						$this->device->model = DeviceModels::identify('blackberry', $this->device->model);
					} else {
						$this->device->model = 'BlackBerry';
					}
				} else {
					$this->device->model = 'BlackBerry';
				}

				$this->device->manufacturer = 'RIM';
				$this->device->type = TYPE_MOBILE;
				$this->device->identified = true;
			}
			
			if (preg_match('/\(BB(1[^;]+); ([^\)]+)\)/', $ua, $match)) {
				$this->os->name = 'BlackBerry';
				$this->os->version = new Version(array('value' => $match[1], 'details' => 2));
				
				$this->device->manufacturer = 'BlackBerry';
				$this->device->model = $match[2];
				
				if ($this->device->model == 'Kbd') {
					$this->device->model = 'Q10';
				} 
				
				if ($this->device->model == 'Touch') {
					$this->device->model = 'Z10 or Dev Alpha';
				} 
				
				$this->device->type = preg_match('/Mobile/', $ua) ? TYPE_MOBILE : TYPE_TABLET;
				$this->device->identified = true;

				if (preg_match('/Version\/([0-9.]*)/', $ua, $match)) {
					$this->os->version = new Version(array('value' => $match[1], 'details' => 2));
				}
			}
				
			/****************************************************
			 *		BlackBerry PlayBook
			 */
		
			if (preg_match('/RIM Tablet OS ([0-9.]*)/', $ua, $match)) {
				$this->os->name = 'BlackBerry Tablet OS';
				$this->os->version = new Version(array('value' => $match[1], 'details' => 2));

				$this->device->manufacturer = 'RIM';
				$this->device->model = 'BlackBerry PlayBook';
				$this->device->type = TYPE_TABLET;
				$this->device->identified = true;
			}

			else if (preg_match('/\(PlayBook;/', $ua) && preg_match('/PlayBook Build\/([0-9.]*)/', $ua, $match)) {
				$this->os->name = 'BlackBerry Tablet OS';
				$this->os->version = new Version(array('value' => $match[1], 'details' => 2));

				$this->device->manufacturer = 'RIM';
				$this->device->model = 'BlackBerry PlayBook';
				$this->device->type = TYPE_TABLET;
				$this->device->identified = true;
			}			

			else if (preg_match('/PlayBook/', $ua) && !preg_match('/Android/', $ua)) {
				if (preg_match('/Version\/([0-9.]*)/', $ua, $match)) {
					$this->os->name = 'BlackBerry Tablet OS';
					$this->os->version = new Version(array('value' => $match[1], 'details' => 2));

					$this->device->manufacturer = 'RIM';
					$this->device->model = 'BlackBerry PlayBook';
					$this->device->type = TYPE_TABLET;
					$this->device->identified = true;
				}
			}			
				
				
			/****************************************************
			 *		WebOS
			 */
		
			if (preg_match('/(?:web|hpw)OS\/(?:HP webOS )?([0-9.]*)/', $ua, $match)) {
				$this->os->name = 'webOS';
				$this->os->version = new Version(array('value' => $match[1], 'details' => 2));
				$this->device->type = preg_match('/Tablet/i', $ua) ? TYPE_TABLET : TYPE_MOBILE;

				if (preg_match('/Pre\/1.0/', $ua)) $this->device->model = 'Pre';
				if (preg_match('/Pre\/1.1/', $ua)) $this->device->model = 'Pre Plus';
				if (preg_match('/Pre\/1.2/', $ua)) $this->device->model = 'Pre 2';
				if (preg_match('/Pre\/3.0/', $ua)) $this->device->model = 'Pre 3';
				if (preg_match('/Pixi\/1.0/', $ua)) $this->device->model = 'Pixi';
				if (preg_match('/Pixi\/1.1/', $ua)) $this->device->model = 'Pixi Plus';
				if (preg_match('/P160UN?A?\/1.0/', $ua)) $this->device->model = 'Veer';
				if (preg_match('/TouchPad\/1.0/', $ua)) $this->device->model = 'TouchPad';
				if (isset($this->device->model)) $this->device->manufacturer = preg_match('/hpwOS/', $ua) ? 'HP' : 'Palm';
				
				if (preg_match('/Emulator\//', $ua) || preg_match('/Desktop\//', $ua)) {
					$this->device->type = TYPE_EMULATOR;
					$this->device->manufacturer = null;
					$this->device->model = null;
				}

				$this->device->identified = true;
			}
				
			/****************************************************
			 *		S60
			 */
		
			if (preg_match('/Symbian/', $ua) || preg_match('/Series[ ]?60/', $ua) || preg_match('/S60;/', $ua) || preg_match('/S60V/', $ua)) {
				$this->os->name = 'Series60';
				
				if (preg_match('/SymbianOS\/9.1/', $ua) && !preg_match('/Series60/', $ua)) {
					$this->os->version = new Version(array('value' => '3.0'));
				}
							
				if (preg_match('/Series60\/([0-9.]*)/', $ua, $match)) {
					$this->os->version = new Version(array('value' => $match[1]));
				}
							
				if (preg_match('/S60V([0-9.]*)/', $ua, $match)) {
					$this->os->version = new Version(array('value' => $match[1]));
				}

				if (preg_match('/Nokia([^\/;\)]+)[\/|;|\)]/', $ua, $match)) {
					if ($match[1] != 'Browser') {
						$this->device->manufacturer = 'Nokia';
						$this->device->model = DeviceModels::cleanup($match[1]);
						$this->device->identified = true;
					}
				}

				if (preg_match('/Symbian; U; (?:Nokia)?([^;]+); [a-z][a-z]\-[a-z][a-z]/', $ua, $match)) {
					$this->device->manufacturer = 'Nokia';
					$this->device->model = DeviceModels::cleanup($match[1]);
					$this->device->identified = true;
				}

				if (preg_match('/Vertu([^\/;]+)[\/|;]/', $ua, $match)) {
					$this->device->manufacturer = 'Vertu';
					$this->device->model = DeviceModels::cleanup($match[1]);
					$this->device->identified = true;
				}

				if (preg_match('/Samsung\/([^;]*);/', $ua, $match)) {
					$this->device->manufacturer = 'Samsung';
					$this->device->model = DeviceModels::cleanup($match[1]);
					$this->device->identified = true;
				}

				if (isset($this->device->model)) {
					$device = DeviceModels::identify('s60', $this->device->model);
					if ($device->identified) {
						$this->device = $device;
					}
				}
				
				$this->device->type = TYPE_MOBILE;
			}
				
			/****************************************************
			 *		S40
			 */
		
			if (preg_match('/Series40/', $ua)) {
				$this->os->name = 'Series40';

				if (preg_match('/Nokia([^\/]+)\//', $ua, $match)) {
					$this->device->manufacturer = 'Nokia';
					$this->device->model = DeviceModels::cleanup($match[1]);
					$this->device->identified = true;
				}

				if (isset($this->device->model)) {
					$device = DeviceModels::identify('s40', $this->device->model);
					if ($device->identified) {
						$this->device = $device;
					}
				}
				
				$this->device->type = TYPE_MOBILE;
			}
			
			/****************************************************
			 *		MeeGo
			 */
		
			if (preg_match('/MeeGo/', $ua)) {
				$this->os->name = 'MeeGo';
				$this->device->type = TYPE_MOBILE;

				if (preg_match('/Nokia([^\)]+)\)/', $ua, $match)) {
					$this->device->manufacturer = 'Nokia';
					$this->device->model = DeviceModels::cleanup($match[1]);
					$this->device->identified = true;
				}
			}
			
			/****************************************************
			 *		Maemo
			 */
		
			if (preg_match('/Maemo/', $ua)) {
				$this->os->name = 'Maemo';
				$this->device->type = TYPE_MOBILE;

				if (preg_match('/(N[0-9]+)/', $ua, $match)) {
					$this->device->manufacturer = 'Nokia';
					$this->device->model = $match[1];
					$this->device->identified = true;
				}
			}
			
			/****************************************************
			 *		Tizen
			 */
		
			if (preg_match('/Tizen/', $ua)) {
				$this->os->name = 'Tizen';

				if (preg_match('/Tizen[\/ ]([0-9.]*)/', $ua, $match)) {
					$this->os->version = new Version(array('value' => $match[1]));
				}

				$this->device->type = TYPE_MOBILE;

				if (preg_match('/\(([^;]+); ([^\/]+)\//', $ua, $match)) {
					if ($match[1] != 'Linux') {
						$this->device = DeviceModels::identify('tizen', $match[2]);

						if (!$this->device->identified) {
							$this->device->manufacturer = $match[1];
							$this->device->model = $match[2];
						}
					}						
				}

				if (preg_match('/;\s+([^;\)]+)\)/', $ua, $match)) {
					if (substr($match[1], 0, 5) != 'Tizen') {
						$this->device = DeviceModels::identify('tizen', $match[1]);
	
						if (!$this->device->identified) {
							$this->device->model = $match[1];
						}
					}
				}
			}
			
			/****************************************************
			 *		Bada
			 */
		
			if (preg_match('/[b|B]ada/', $ua)) {
				$this->os->name = 'Bada';

				if (preg_match('/[b|B]ada[\/ ]([0-9.]*)/', $ua, $match)) {
					$this->os->version = new Version(array('value' => $match[1], 'details' => 2));
				}

				$this->device->type = TYPE_MOBILE;

				if (preg_match('/\(([^;]+); ([^\/]+)\//', $ua, $match)) {
					if ($match[1] != 'Bada') {
						$this->device = DeviceModels::identify('bada', $match[2]);
	
						if (!$this->device->identified) {
							$this->device->manufacturer = $match[1];
							$this->device->model = $match[2];
						}
					}
				}
			}
			
			/****************************************************
			 *		Brew
			 */
		
			if (preg_match('/BREW/i', $ua) || preg_match('/BMP; U/', $ua)) {
				$this->os->name = 'Brew';

				if (preg_match('/BREW; U; ([0-9.]*)/i', $ua, $match)) {
					$this->os->version = new Version(array('value' => $match[1]));
				}

				else if (preg_match('/;BREW\/([0-9.]*)/i', $ua, $match)) {
					$this->os->version = new Version(array('value' => $match[1]));
				}

				$this->device->type = TYPE_MOBILE;

				if (preg_match('/\(([^;]+);U;REX\/[^;]+;BREW\/[^;]+;(?:.*;)?[0-9]+\*[0-9]+;CTC\/2.0\)/', $ua, $match)) {
					$this->device = DeviceModels::identify('brew', $match[1]);

					if (!$this->device->identified) {
						$this->device->model = $match[1];
					}
				}
			}			
			
			/****************************************************
			 *		MTK
			 */
		
			if (preg_match('/\(MTK;/', $ua)) {
				$this->os->name = 'MTK';
				$this->device->type = TYPE_MOBILE;
			}

			/****************************************************
			 *		MAUI Runtime
			 */
		
			if (preg_match('/\(MAUI Runtime;/', $ua)) {
				$this->os->name = 'MAUI Runtime';
				$this->device->type = TYPE_MOBILE;
			}

			/****************************************************
			 *		CrOS
			 */
		
			if (preg_match('/CrOS/', $ua)) {
				$this->os->name = 'Chrome OS';
				$this->device->type = TYPE_DESKTOP;
			}
			
			/****************************************************
			 *		Joli OS
			 */
		
			if (preg_match('/Joli OS\/([0-9.]*)/i', $ua, $match)) {
				$this->os->name = 'Joli OS';
				$this->os->version = new Version(array('value' => $match[1]));
				$this->device->type = TYPE_DESKTOP;
			}
			
			/****************************************************
			 *		BeOS
			 */
		
			if (preg_match('/BeOS/', $ua)) {
				$this->os->name = 'BeOS';
				$this->device->type = TYPE_DESKTOP;
			}
			
			/****************************************************
			 *		Haiku
			 */
		
			if (preg_match('/Haiku/', $ua)) {
				$this->os->name = 'Haiku';
				$this->device->type = TYPE_DESKTOP;
			}
			
			/****************************************************
			 *		QNX
			 */
		
			if (preg_match('/QNX/', $ua)) {
				$this->os->name = 'QNX';
				$this->device->type = TYPE_MOBILE;
			}
			
			/****************************************************
			 *		OS/2 Warp
			 */
		
			if (preg_match('/OS\/2; (?:U; )?Warp ([0-9.]*)/i', $ua, $match)) {
				$this->os->name = 'OS/2 Warp';
				$this->os->version = new Version(array('value' => $match[1]));
				$this->device->type = TYPE_DESKTOP;
			}
			
			/****************************************************
			 *		Grid OS
			 */
		
			if (preg_match('/Grid OS ([0-9.]*)/i', $ua, $match)) {
				$this->os->name = 'Grid OS';
				$this->os->version = new Version(array('value' => $match[1]));
				$this->device->type = TYPE_TABLET;
			}

			/****************************************************
			 *		AmigaOS
			 */
		
			if (preg_match('/AmigaOS ([0-9.]*)/i', $ua, $match)) {
				$this->os->name = 'AmigaOS';
				$this->os->version = new Version(array('value' => $match[1]));
				$this->device->type = TYPE_DESKTOP;
			}

			/****************************************************
			 *		MorphOS
			 */
		
			if (preg_match('/MorphOS ([0-9.]*)/i', $ua, $match)) {
				$this->os->name = 'MorphOS';
				$this->os->version = new Version(array('value' => $match[1]));
				$this->device->type = TYPE_DESKTOP;
			}
			
			/****************************************************
			 *		AROS
			 */
		
			if (preg_match('/AROS/', $ua, $match)) {
				$this->os->name = 'AROS';
				$this->device->type = TYPE_DESKTOP;
			}
			
			/****************************************************
			 *		Kindle
			 */
		
			if (preg_match('/Kindle/', $ua) && !preg_match('/Fire/', $ua)) {
				$this->os->name = '';

				$this->device->manufacturer = 'Amazon';
				$this->device->model = 'Kindle';
				$this->device->type = TYPE_EREADER;

				if (preg_match('/Kindle\/2.0/', $ua)) $this->device->model = 'Kindle 2';
				if (preg_match('/Kindle\/3.0/', $ua)) $this->device->model = 'Kindle 3 or later';

				$this->device->identified = true;
			}

			/****************************************************
			 *		NOOK
			 */
		
			if (preg_match('/nook browser/', $ua)) {
				$this->os->name = 'Android';
				
				$this->device->manufacturer = 'Barnes & Noble';
				$this->device->model = 'NOOK';
				$this->device->type = TYPE_EREADER;
				$this->device->identified = true;
			}
			
			/****************************************************
			 *		Bookeen
			 */
		
			if (preg_match('/bookeen\/cybook/', $ua)) {
				$this->os->name = '';

				$this->device->manufacturer = 'Bookeen';
				$this->device->model = 'Cybook';
				$this->device->type = TYPE_EREADER;
				
				if (preg_match('/Orizon/', $ua)) $this->device->model = 'Cybook Orizon';

				$this->device->identified = true;
			}

			/****************************************************
			 *		Sony Reader
			 */
		
			if (preg_match('/EBRD1101/', $ua)) {
				$this->os->name = '';
				
				$this->device->manufacturer = 'Sony';
				$this->device->model = 'Reader';
				$this->device->type = TYPE_EREADER;
				$this->device->identified = true;
			}

			/****************************************************
			 *		iRiver
			 */
		
			if (preg_match('/Iriver ;/', $ua)) {
				$this->os->name = '';
		
				$this->device->manufacturer = 'iRiver';
				$this->device->model = 'Story';
				$this->device->type = TYPE_EREADER;
				
				if (preg_match('/EB07/', $ua)) $this->device->model = 'Story HD EB07';

				$this->device->identified = true;
			}

			/****************************************************
			 *		Tesla Model S in-car browser
			 */
		
			if (preg_match('/QtCarBrowser/', $ua)) {
				$this->os->name = '';
				
				$this->device->manufacturer = 'Tesla';
				$this->device->model = 'Model S';
				$this->device->type = TYPE_CAR;
				$this->device->identified = true;
			}


			/****************************************************
			 *		Nintendo
			 *
			 *		Opera/9.30 (Nintendo Wii; U; ; 3642; en)
			 *		Opera/9.30 (Nintendo Wii; U; ; 2047-7; en)
			 *		Opera/9.50 (Nintendo DSi; Opera/507; U; en-US)
			 *		Mozilla/5.0 (Nintendo 3DS; U; ; en) Version/1.7455.US
			 *		Mozilla/5.0 (Nintendo 3DS; U; ; en) Version/1.7455.EU
			 *		Mozilla/5.0 (Nintendo WiiU) AppleWebKit/534.52 (KHTML, like Gecko) NX/2.1.0.8.8 Version/1.0.0.6760.JP
			 */
		
			if (preg_match('/Nintendo Wii/', $ua)) {
				$this->os->name = '';
		
				$this->device->manufacturer = 'Nintendo';
				$this->device->model = 'Wii';
				$this->device->type = TYPE_GAMING;
				$this->device->identified = true;
			}
			
			if (preg_match('/Nintendo Wii ?U/', $ua)) {
				$this->os->name = '';
		
				$this->device->manufacturer = 'Nintendo';
				$this->device->model = 'Wii U';
				$this->device->type = TYPE_GAMING;
				$this->device->identified = true;
			}

			if (preg_match('/Nintendo DSi/', $ua)) {
				$this->os->name = '';
		
				$this->device->manufacturer = 'Nintendo';
				$this->device->model = 'DSi';
				$this->device->type = TYPE_GAMING;
				$this->device->identified = true;
			}

			if (preg_match('/Nintendo 3DS/', $ua)) {
				$this->os->name = '';
		
				if (preg_match('/Version\/([0-9.]*)/', $ua, $match)) {
					$this->os->version = new Version(array('value' => $match[1]));
				}

				$this->device->manufacturer = 'Nintendo';
				$this->device->model = '3DS';
				$this->device->type = TYPE_GAMING;
				$this->device->identified = true;
			}
			
			/****************************************************
			 *		Sony Playstation
			 *
			 *		Mozilla/4.0 (PSP (PlayStation Portable); 2.00)
			 *
			 *		Mozilla/5.0 (PlayStation Vita 1.00) AppleWebKit/531.22.8 (KHTML, like Gecko) Silk/3.2
			 *		Mozilla/5.0 (PlayStation Vita 1.50) AppleWebKit/531.22.8 (KHTML, like Gecko) Silk/3.2
			 *		Mozilla/5.0 (PlayStation Vita 1.51) AppleWebKit/531.22.8 (KHTML, like Gecko) Silk/3.2
			 *		Mozilla/5.0 (PlayStation Vita 1.52) AppleWebKit/531.22.8 (KHTML, like Gecko) Silk/3.2
			 *		Mozilla/5.0 (PlayStation Vita 1.60) AppleWebKit/531.22.8 (KHTML, like Gecko) Silk/3.2
			 *		Mozilla/5.0 (PlayStation Vita 1.61) AppleWebKit/531.22.8 (KHTML, like Gecko) Silk/3.2
			 *		Mozilla/5.0 (PlayStation Vita 1.80) AppleWebKit/531.22.8 (KHTML, like Gecko) Silk/3.2
			 *
			 *		Mozilla/5.0 (PLAYSTATION 3; 1.00)
			 *		Mozilla/5.0 (PLAYSTATION 3; 2.00)
			 *		Mozilla/5.0 (PLAYSTATION 3; 3.55)
			 *		Mozilla/5.0 (PLAYSTATION 3 4.11) AppleWebKit/531.22.8 (KHTML, like Gecko)
			 *		Mozilla/5.0 (PLAYSTATION 3 4.10) AppleWebKit/531.22.8 (KHTML, like Gecko)
			 *
			 *		Mozilla/5.0 (PlayStation 3) SonyComputerEntertainmentEurope/531.3 (NCell) NuantiMeta/2.0
			 */
		
			if (preg_match('/PlayStation Portable/', $ua)) {
				$this->os->name = '';
		
				$this->device->manufacturer = 'Sony';
				$this->device->model = 'Playstation Portable';
				$this->device->type = TYPE_GAMING;
				$this->device->identified = true;
			}

			if (preg_match('/PlayStation Vita ([0-9.]*)/', $ua, $match)) {
				$this->os->name = '';
				$this->os->version = new Version(array('value' => $match[1]));
		
				$this->device->manufacturer = 'Sony';
				$this->device->model = 'Playstation Vita';
				$this->device->type = TYPE_GAMING;
				$this->device->identified = true;
			}

			if (preg_match('/PlayStation 3/i', $ua)) {
				$this->os->name = '';

				if (preg_match('/PLAYSTATION 3;? ([0-9.]*)/', $ua, $match)) {
					$this->os->version = new Version(array('value' => $match[1]));
				}
				
				$this->device->manufacturer = 'Sony';
				$this->device->model = 'Playstation 3';
				$this->device->type = TYPE_GAMING;
				$this->device->identified = true;
			}

			/****************************************************
			 *		XBox
			 *
			 *		Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; Trident/5.0; Xbox)
			 */
		
			if (preg_match('/Xbox\)$/', $ua, $match)) {
				$this->os->name = '';
				$this->os->version = null;
		
				$this->device->manufacturer = 'Microsoft';
				$this->device->model = 'Xbox 360';
				$this->device->type = TYPE_GAMING;
				$this->device->identified = true;
			}


			/****************************************************
			 *		Panasonic Smart Viera
			 *
			 *		Mozilla/5.0 (FreeBSD; U; Viera; ja-JP) AppleWebKit/535.1 (KHTML, like Gecko) Viera/1.2.4 Chrome/14.0.835.202 Safari/535.1
			 */
		
			if (preg_match('/Viera/', $ua)) {
				$this->os->name = '';
				$this->device->manufacturer = 'Panasonic';
				$this->device->model = 'Smart Viera';
				$this->device->type = TYPE_TELEVISION;
				$this->device->identified = true;
			}


			/****************************************************
			 *		Sharp AQUOS TV
			 *
			 *		Mozilla/5.0 (DTV) AppleWebKit/531.2  (KHTML, like Gecko) AQUOSBrowser/1.0 (US00DTV;V;0001;0001)
			 *		Mozilla/5.0 (DTV) AppleWebKit/531.2+ (KHTML, like Gecko) Espial/6.0.4 AQUOSBrowser/1.0 (CH00DTV;V;0001;0001)
			 *		Opera/9.80 (Linux armv6l; U; en) Presto/2.8.115 Version/11.10 AQUOS-AS/1.0 LC-40LE835X
			 */
		
			if (preg_match('/AQUOSBrowser/', $ua) || preg_match('/AQUOS-AS/', $ua)) {
				$this->os->name = '';
				$this->device->manufacturer = 'Sharp';
				$this->device->model = 'Aquos TV';
				$this->device->type = TYPE_TELEVISION;
				$this->device->identified = true;
			}


			/****************************************************
			 *		Samsung Smart TV
			 *
			 *		Mozilla/5.0 (SmartHub; SMART-TV; U; Linux/SmartTV; Maple2012) AppleWebKit/534.7 (KHTML, like Gecko) SmartTV Safari/534.7
			 *		Mozilla/5.0 (SmartHub; SMART-TV; U; Linux/SmartTV) AppleWebKit/531.2+ (KHTML, like Gecko) WebBrowser/1.0 SmartTV Safari/531.2+
			 */

			if (preg_match('/SMART-TV/', $ua)) {
				$this->os->name = '';
				$this->device->manufacturer = 'Samsung';
				$this->device->model = 'Smart TV';
				$this->device->type = TYPE_TELEVISION;
				$this->device->identified = true;

				if (preg_match('/Maple([0-9]*)/', $ua, $match)) {
					$this->device->model .= ' ' . $match[1];
				}
			}


			/****************************************************
			 *		Sony Internet TV
			 *
			 *		Opera/9.80 (Linux armv7l; U; InettvBrowser/2.2(00014A;SonyDTV115;0002;0100) KDL-46EX640; CC/USA; en) Presto/2.8.115 Version/11.10
			 *		Opera/9.80 (Linux armv7l; U; InettvBrowser/2.2(00014A;SonyDTV115;0002;0100) KDL-40EX640; CC/USA; en) Presto/2.10.250 Version/11.60
			 *		Opera/9.80 (Linux armv7l; U; InettvBrowser/2.2(00014A;SonyDTV115;0002;0100) N/A; CC/USA; en) Presto/2.8.115 Version/11.10
			 *		Opera/9.80 (Linux mips; U; InettvBrowser/2.2 (00014A;SonyDTV115;0002;0100) ; CC/JPN; en) Presto/2.9.167 Version/11.50
			 *		Opera/9.80 (Linux mips; U; InettvBrowser/2.2 (00014A;SonyDTV115;0002;0100) AZ2CVT2; CC/CAN; en) Presto/2.7.61 Version/11.00
			 *		Opera/9.80 (Linux armv6l; Opera TV Store/4207; U; (SonyBDP/BDV11); en) Presto/2.9.167 Version/11.50
			 *		Opera/9.80 (Linux armv6l ; U; (SonyBDP/BDV11); en) Presto/2.6.33 Version/10.60
			 *		Opera/9.80 (Linux armv6l; U; (SonyBDP/BDV11); en) Presto/2.8.115 Version/11.10
			 */

			if (preg_match('/SonyDTV|SonyBDP|SonyCEBrowser/', $ua)) {
				$this->os->name = '';
				$this->device->manufacturer = 'Sony';
				$this->device->model = 'Internet TV';
				$this->device->type = TYPE_TELEVISION;
				$this->device->identified = true;
			}

			/****************************************************
			 *		Philips Net TV
			 *
			 *		Opera/9.70 (Linux armv6l ; U; CE-HTML/1.0 NETTV/2.0.2; en) Presto/2.2.1
			 *		Opera/9.80 (Linux armv6l ; U; CE-HTML/1.0 NETTV/3.0.1;; en) Presto/2.6.33 Version/10.60
			 *		Opera/9.80 (Linux mips; U; CE-HTML/1.0 NETTV/3.0.1; PHILIPS-AVM-2012; en) Presto/2.9.167 Version/11.50
			 *		Opera/9.80 (Linux mips ; U; HbbTV/1.1.1 (; Philips; ; ; ; ) CE-HTML/1.0 NETTV/3.1.0; en) Presto/2.6.33 Version/10.70
			 *		Opera/9.80 (Linux i686; U; HbbTV/1.1.1 (; Philips; ; ; ; ) CE-HTML/1.0 NETTV/3.1.0; en) Presto/2.9.167 Version/11.50
			 */

			if (preg_match('/NETTV\//', $ua)) {
				$this->os->name = '';
				$this->device->manufacturer = 'Philips';
				$this->device->model = 'Net TV';
				$this->device->type = TYPE_TELEVISION;
				$this->device->identified = true;
			}
			
			/****************************************************
			 *		LG NetCast TV
			 *
			 *		Mozilla/5.0 (DirectFB; Linux armv7l) AppleWebKit/534.26+ (KHTML, like Gecko) Version/5.0 Safari/534.26+ LG Browser/5.00.00(+mouse+3D+SCREEN+TUNER; LGE; GLOBAL-PLAT4; 03.09.22; 0x00000001;); LG NetCast.TV-2012
			 *		Mozilla/5.0 (DirectFB; Linux armv7l) AppleWebKit/534.26+ (KHTML, like Gecko) Version/5.0 Safari/534.26+ LG Browser/5.00.00(+SCREEN+TUNER; LGE; GLOBAL-PLAT4; 01.00.00; 0x00000001;); LG NetCast.TV-2012
			 *		Mozilla/5.0 (DirectFB; U; Linux armv6l; en) AppleWebKit/531.2  (KHTML, like Gecko) Safari/531.2  LG Browser/4.1.4( BDP; LGE; Media/BD660; 6970; abc;); LG NetCast.Media-2011
			 *		Mozilla/5.0 (DirectFB; U; Linux 7631; en) AppleWebKit/531.2  (KHTML, like Gecko) Safari/531.2  LG Browser/4.1.4( NO_NUM; LGE; Media/SP520; ST.3.97.409.F; 0x00000001;); LG NetCast.Media-2011
			 *		Mozilla/5.0 (DirectFB; U; Linux 7630; en) AppleWebKit/531.2  (KHTML, like Gecko) Safari/531.2  LG Browser/4.1.4( 3D BDP NO_NUM; LGE; Media/ST600; LG NetCast.Media-2011
			 *		(LGSmartTV/1.0) AppleWebKit/534.23 OBIGO-T10/2.0
			 */

			if (preg_match('/LG NetCast\.(?:TV|Media)-([0-9]*)/', $ua, $match)) {
				$this->os->name = '';
				$this->device->manufacturer = 'LG';
				$this->device->model = 'NetCast TV ' . $match[1];
				$this->device->type = TYPE_TELEVISION;
				$this->device->identified = true;
			}

			if (preg_match('/LGSmartTV/', $ua)) {
				$this->os->name = '';
				$this->device->manufacturer = 'LG';
				$this->device->model = 'Smart TV';
				$this->device->type = TYPE_TELEVISION;
				$this->device->identified = true;
			}

			/****************************************************
			 *		Toshiba Smart TV
			 *
			 *		Mozilla/5.0 (Linux mipsel; U; HbbTV/1.1.1 (; TOSHIBA; DTV_RL953; 56.7.66.7; t12; ) ; ToshibaTP/1.3.0 (+VIDEO_MP4+VIDEO_X_MS_ASF+AUDIO_MPEG+AUDIO_MP4+DRM+NATIVELAUNCH) ; en) AppleWebKit/534.1 (KHTML, like Gecko)
			 *		Mozilla/5.0 (DTV; TSBNetTV/T32013713.0203.7DD; TVwithVideoPlayer; like Gecko) NetFront/4.1 DTVNetBrowser/2.2 (000039;T32013713;0203;7DD) InettvBrowser/2.2 (000039;T32013713;0203;7DD)
			 *		Mozilla/5.0 (Linux mipsel; U; HbbTV/1.1.1 (; TOSHIBA; 40PX200; 0.7.3.0.; t12; ) ; Toshiba_TP/1.3.0 (+VIDEO_MP4+AUDIO_MPEG+AUDIO_MP4+VIDEO_X_MS_ASF+OFFLINEAPP) ; en) AppleWebKit/534.1 (KHTML, like Gec
			 */

			if (preg_match('/Toshiba_?TP\//', $ua) || preg_match('/TSBNetTV\//', $ua)) {
				$this->os->name = '';
				$this->device->manufacturer = 'Toshiba';
				$this->device->model = 'Smart TV';
				$this->device->type = TYPE_TELEVISION;
				$this->device->identified = true;
			}

			/****************************************************
			 *		NetRange MMH 
			 */

			if (preg_match('/NETRANGEMMH/', $ua)) {
				$this->os->name = '';
				$this->os->version = null;
				$this->browser->name = '';
				$this->browser->version = null;
				$this->device->model = 'NetRange MMH';
				$this->device->type = TYPE_TELEVISION;
				$this->device->identified = true;
			}

			/****************************************************
			 *		MachBlue XT
			 */

			if (preg_match('/mbxtWebKit\/([0-9.]*)/', $ua, $match)) {
				$this->os->name = '';
				$this->browser->name = 'MachBlue XT';
				$this->browser->version = new Version(array('value' => $match[1], 'details' => 2));
				$this->device->type = TYPE_TELEVISION;
			}

			if ($ua == 'MachBlue') {
				$this->os->name = '';
				$this->browser->name = 'MachBlue XT';
				$this->device->type = TYPE_TELEVISION;
			}
			

			/****************************************************
			 *		Motorola KreaTV
			 */

			if (preg_match('/Motorola KreaTV STB/', $ua)) {
				$this->os->name = '';
				$this->device->manufacturer = 'Motorola';
				$this->device->model = 'KreaTV';
				$this->device->type = TYPE_TELEVISION;
				$this->device->identified = true;
			}

			/****************************************************
			 *		ADB
			 */

			if (preg_match('/\(ADB; ([^\)]+)\)/', $ua, $match)) {
				$this->os->name = '';
				$this->device->manufacturer = 'ADB';
				$this->device->model = ($match[1] != 'Unknown' ? str_replace('ADB', '', $match[1]) . ' ' : '') . 'IPTV receiver';
				$this->device->type = TYPE_TELEVISION;
				$this->device->identified = true;
			}

			/****************************************************
			 *		MStar
			 */

			if (preg_match('/Mstar;OWB/', $ua)) {
				$this->os->name = '';
				$this->device->manufacturer = 'MStar';
				$this->device->model = 'PVR';
				$this->device->type = TYPE_TELEVISION;
				$this->device->identified = true;

				$this->browser->name = 'Origyn Web Browser';
			}

			/****************************************************
			 *		TechniSat
			 */

			if (preg_match('/\TechniSat ([^;]+);/', $ua, $match)) {
				$this->os->name = '';
				$this->device->manufacturer = 'TechniSat';
				$this->device->model = $match[1];
				$this->device->type = TYPE_TELEVISION;
				$this->device->identified = true;
			}
			
			/****************************************************
			 *		Technicolor
			 */

			if (preg_match('/\Technicolor_([^;]+);/', $ua)) {
				$this->os->name = '';
				$this->device->manufacturer = 'Technicolor';
				$this->device->model = $match[1];
				$this->device->type = TYPE_TELEVISION;
				$this->device->identified = true;
			}

			/****************************************************
			 *		Winbox Evo2
			 */

			if (preg_match('/Winbox Evo2/', $ua)) {
				$this->os->name = '';
				$this->device->manufacturer = 'Winbox';
				$this->device->model = 'Evo2';
				$this->device->type = TYPE_TELEVISION;
				$this->device->identified = true;
			}

			/****************************************************
			 *		Roku
			 */

			if (preg_match('/^Roku\/DVP-([0-9]+)/', $ua, $match)) {
				$this->os->name = '';
				$this->device->manufacturer = 'Roku';
				$this->device->type = TYPE_TELEVISION;

				switch ($match[1]) {
					case '2000':	$this->device->model = 'HD'; break;
					case '2050':	$this->device->model = 'XD'; break;
					case '2100':	$this->device->model = 'XDS'; break;
					case '2400':	$this->device->model = 'LT'; break;
					case '3000':	$this->device->model = '2 HD'; break;
					case '3050':	$this->device->model = '2 XD'; break;
					case '3100':	$this->device->model = '2 XS'; break;
				}

				$this->device->identified = true;
			}


			/****************************************************
			 *		Generic
			 */

			if (preg_match('/HbbTV\/1.1.1 \([^;]*;\s*([^;]*)\s*;\s*([^;]*)\s*;/', $ua, $match)) {
				$vendorName = trim($match[1]);
				$modelName = trim($match[2]);

				if (!isset($this->device->manufacturer) && $vendorName != '' && $vendorName != 'vendorName') {
					switch($vendorName) {
						case 'LG Electronics':	$this->device->manufacturer = 'LG'; break;
						case 'LGE':				$this->device->manufacturer = 'LG'; break;
						case 'TOSHIBA':			$this->device->manufacturer = 'Toshiba'; break;
						case 'smart':			$this->device->manufacturer = 'Smart'; break;
						case 'tv2n':			$this->device->manufacturer = 'TV2N'; break;
						default:				$this->device->manufacturer = $vendorName;
					}

					if (!isset($this->device->model) && $modelName != '' && $modelName != 'modelName') {
						switch($modelName) {
							case 'GLOBAL_PLAT3':	$this->device->model = 'NetCast TV'; break;
							case 'GLOBAL_PLAT4':	$this->device->model = 'NetCast TV'; break;
							case 'SmartTV2012':		$this->device->model = 'Smart TV 2012'; break;
							case 'videoweb':		$this->device->model = 'Videoweb'; break;
							default:				$this->device->model = $modelName;
						}
						
						if ($vendorName == 'Humax') {
							$this->device->model = strtoupper($this->device->model);
						}
	
						$this->device->identified = true;
						$this->os->name = '';
					}
				}

				$this->device->type = TYPE_TELEVISION;
			}
			
			/****************************************************
			 *		Detect type based on common identifiers
			 */

			if (preg_match('/InettvBrowser/', $ua)) {
				$this->device->type = TYPE_TELEVISION;
			}

			if (preg_match('/MIDP/', $ua)) {
				$this->device->type = TYPE_MOBILE;
			}
			
			/****************************************************
			 *		Try to detect any devices based on common
			 *		locations of model ids
			 */

			if (!isset($this->device->model) && !isset($this->device->manufacturer)) {
				$candidates = array();
				
				if (!preg_match('/^(Mozilla|Opera)/', $ua)) if (preg_match('/^(?:MQQBrowser\/[0-9\.]+\/)?([^\s]+)/', $ua, $match)) {
					$match[1] = preg_replace('/_TD$/', '', $match[1]);
					$match[1] = preg_replace('/_CMCC$/', '', $match[1]);
					$match[1] = preg_replace('/[_ ]Mozilla$/', '', $match[1]);
					$match[1] = preg_replace('/ Linux$/', '', $match[1]);
					$match[1] = preg_replace('/ Opera$/', '', $match[1]);
					$match[1] = preg_replace('/\/[0-9].*$/', '', $match[1]);

					array_push($candidates, $match[1]);
				}
			
				if (preg_match('/^((?:SAMSUNG|TCL|ZTE) [^\s]+)/', $ua, $match)) {
					array_push($candidates, $match[1]);
				}

				if (preg_match('/[0-9]+x[0-9]+; ([^;]+)/', $ua, $match)) {
					array_push($candidates, $match[1]);
				}

				if (preg_match('/\s*([^;]*[^\s])\s*; [0-9]+\*[0-9]+\)/', $ua, $match)) {
					array_push($candidates, $match[1]);
				}
				
				if (preg_match('/[0-9]+X[0-9]+ ([^;\/\(\)]+)/', $ua, $match)) {
					array_push($candidates, $match[1]);
				}

				if (preg_match('/Windows NT 5.1; ([^;]+); Windows Phone/', $ua, $match)) {
					array_push($candidates, $match[1]);
				}

				if (preg_match('/\) PPC; (?:[0-9]+x[0-9]+; )?([^;\/\(\)]+)/', $ua, $match)) {
					array_push($candidates, $match[1]);
				}

				if (preg_match('/Windows Mobile; ([^;]+); PPC;/', $ua, $match)) {
					array_push($candidates, $match[1]);
				}

				if (preg_match('/\(([^;]+); U; Windows Mobile/', $ua, $match)) {
					array_push($candidates, $match[1]);
				}

				if (preg_match('/Series60\/[0-9\.]+ ([^\s]+) Profile/', $ua, $match)) {
					array_push($candidates, $match[1]);
				}

				if (preg_match('/Vodafone\/1.0\/([^\/]+)/', $ua, $match)) {
					array_push($candidates, $match[1]);
				}

				if (preg_match('/\ ([^\s]+)$/', $ua, $match)) {
					array_push($candidates, $match[1]);
				}
				
				if (preg_match('/; ([^;\)]+)\)/', $ua, $match)) {
					array_push($candidates, $match[1]);
				}
				
				if (preg_match('/^(.*)\/UCWEB/', $ua, $match)) {
					array_push($candidates, $match[1]);
				}
				
				if (preg_match('/^([a-z0-9\.\_\+\/ ]+) Linux/i', $ua, $match)) {
					array_push($candidates, $match[1]);
				}
				
				if (preg_match('/\(([a-z0-9\.\_\+\/ ]+) Browser/i', $ua, $match)) {
					array_push($candidates, $match[1]);
				}
				
				if (isset($this->os->name)) {
					for ($i = 0; $i < count($candidates); $i++) {
						$result = false;
	
						if (!isset($this->device->model) && !isset($this->device->manufacturer)) {
							if (isset($this->os->name) && ($this->os->name == 'Android' || $this->os->name == 'Linux')) {
								$device = DeviceModels::identify('android', $candidates[$i]);
								if ($device->identified) {
									$result = true;
	
									$this->device = $device;

									if ($this->os->name != 'Android') {
										$this->os->name = 'Android';
										$this->os->version = null;
									}
								}
							}
		
							if (!isset($this->os->name) || $this->os->name == 'Windows' || $this->os->name == 'Windows Mobile' || $this->os->name == 'Windows CE') {
								$device = DeviceModels::identify('wm', $candidates[$i]);
								if ($device->identified) {
									$result = true;
	
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
						if (preg_match('/^(?:YL-)?COOLPAD([^\s]+)/i', $candidates[$i], $match)) {
							$this->device->manufacturer = 'Coolpad';
							$this->device->model = DeviceModels::cleanup($match[1]);
							$this->device->type = TYPE_MOBILE;
							$identified = true;
						}
						
						if (preg_match('/^dopod[-_]?([^\s]+)/i', $candidates[$i], $match)) {
							$this->device->manufacturer = 'Dopod';
							$this->device->model = DeviceModels::cleanup($match[1]);
							$this->device->type = TYPE_MOBILE;
							$identified = true;
						}
						
						if (preg_match('/^GIONEE[-_]([^\s]+)/i', $candidates[$i], $match)) {
							$this->device->manufacturer = 'Gionee';
							$this->device->model = DeviceModels::cleanup($match[1]);
							$this->device->type = TYPE_MOBILE;
							$identified = true;
						}
						
						if (preg_match('/^HTC[_-]?([^\/_]+)(?:\/|_|$)/i', $candidates[$i], $match)) {
							$this->device->manufacturer = 'HTC';
							$this->device->model = DeviceModels::cleanup($match[1]);
							$this->device->type = TYPE_MOBILE;
							$identified = true;
						}

						if (preg_match('/^HUAWEI[_-]?([^\/]*)/i', $candidates[$i], $match)) {
							$this->device->manufacturer = 'Huawei';
							$this->device->model = DeviceModels::cleanup($match[1]);
							$this->device->type = TYPE_MOBILE;
							$identified = true;
						}

						if (preg_match('/^KONKA[-_]?([^\s]+)/i', $candidates[$i], $match)) {
							$this->device->manufacturer = 'Konka';
							$this->device->model = DeviceModels::cleanup($match[1]);
							$this->device->type = TYPE_MOBILE;
							$identified = true;
						}
						
						if (preg_match('/^Lenovo-([^\/]*)/i', $candidates[$i], $match)) {
							$this->device->manufacturer = 'Lenovo';
							$this->device->model = DeviceModels::cleanup($match[1]);
							$this->device->type = TYPE_MOBILE;
							$identified = true;
						}

						if (preg_match('/^Lephone_([^\/]*)/i', $candidates[$i], $match)) {
							$this->device->manufacturer = 'Lephone';
							$this->device->model = DeviceModels::cleanup($match[1]);
							$this->device->type = TYPE_MOBILE;
							$identified = true;
						}

						if (preg_match('/(?:^|\()LGE?(?:\/|-|_|\s)([^\s]*)/i', $candidates[$i], $match)) {
							$this->device->manufacturer = 'LG';
							$this->device->model = DeviceModels::cleanup($match[1]);
							$this->device->type = TYPE_MOBILE;
							$identified = true;
						}

						if (preg_match('/^MOT-([^\/_]+)(?:\/|_|$)/i', $candidates[$i], $match)) {
							$this->device->manufacturer = 'Motorola';
							$this->device->model = DeviceModels::cleanup($match[1]);
							$this->device->type = TYPE_MOBILE;
							$identified = true;
						}
						
						if (preg_match('/^Motorola_([^\/_]+)(?:\/|_|$)/i', $candidates[$i], $match)) {
							$this->device->manufacturer = 'Motorola';
							$this->device->model = DeviceModels::cleanup($match[1]);
							$this->device->type = TYPE_MOBILE;
							$identified = true;
						}

						if (preg_match('/^Nokia-?([^\/]+)(?:\/|$)/i', $candidates[$i], $match)) {
							$this->device->manufacturer = 'Nokia';
							$this->device->model = DeviceModels::cleanup($match[1]);
							$this->device->type = TYPE_MOBILE;
							$identified = true;
							
							if (!$this->device->identified) {
								$device = DeviceModels::identify('s60', $this->device->model);
								if ($device->identified) {
									$this->device = $device;
									$this->os->name = 'Series60';
								}
							}

							if (!$this->device->identified) {
								$device = DeviceModels::identify('s40', $this->device->model);
								if ($device->identified) {
									$this->device = $device;
									$this->os->name = 'Series40';
								}
							}
						}

						if (preg_match('/^Pantech([^\/_]+)(?:\/|_|$)/i', $candidates[$i], $match)) {
							$this->device->manufacturer = 'Pantech';
							$this->device->model = DeviceModels::cleanup($match[1]);
							$this->device->type = TYPE_MOBILE;
							$identified = true;
						}
						
						if (preg_match('/^SonyEricsson([^\/_]+)(?:\/|_|$)/i', $candidates[$i], $match)) {
							$this->device->manufacturer = 'Sony Ericsson';
							$this->device->model = DeviceModels::cleanup($match[1]);
							$this->device->type = TYPE_MOBILE;
							$identified = true;

							if (isset($this->os->name) && $this->os->name == 'Series60') {
								$device = DeviceModels::identify('s60', $this->device->model);
								if ($device->identified) {
									$this->device = $device;
								}
							}
						}

						if (preg_match('/^TCL[-_ ]([^\/]*)/i', $candidates[$i], $match)) {
							$this->device->manufacturer = 'TCL';
							$this->device->model = DeviceModels::cleanup($match[1]);
							$this->device->type = TYPE_MOBILE;
							$identified = true;
						}
						
						if (preg_match('/^SHARP[-_\/]([^\/]*)/i', $candidates[$i], $match)) {
							$this->device->manufacturer = 'Sharp';
							$this->device->model = DeviceModels::cleanup($match[1]);
							$this->device->type = TYPE_MOBILE;
							$identified = true;
						}
		
						if (preg_match('/^SAMSUNG[-\/ ]?([^\/_]+)(?:\/|_|$)/i', $candidates[$i], $match)) {
							$this->device->manufacturer = 'Samsung';
							$this->device->model = DeviceModels::cleanup($match[1]);
							$this->device->type = TYPE_MOBILE;
							$identified = true;
						
							if (isset($this->os->name) && $this->os->name == 'Bada') {
								$device = DeviceModels::identify('bada', $this->device->model);
								if ($device->identified) {
									$this->device = $device;
								}
							}
							
							else if (isset($this->os->name) && $this->os->name == 'Series60') {
								$device = DeviceModels::identify('s60', $this->device->model);
								if ($device->identified) {
									$this->device = $device;
								}
							}
							
							else if (preg_match('/Jasmine\/([0-9.]*)/', $ua, $match)) {
								$version = $match[1];
								
								$device = DeviceModels::identify('touchwiz', $this->device->model);
								if ($device->identified) {
									$this->device = $device;
									$this->os->name = 'Touchwiz';
									
									switch($version) {
										case '0.8':		$this->os->version = new Version(array('value' => '1.0')); break;
										case '1.0':		$this->os->version = new Version(array('value' => '2.0', 'alias' => '2.0 or earlier')); break;
										case '2.0':		$this->os->version = new Version(array('value' => '3.0')); break;
									}	
								}
							}
				
							else if (preg_match('/(?:Dolfin\/([0-9.]*)|Browser\/Dolfin([0-9.]*))/', $ua, $match)) {
								$version = $match[1] || $match[2];

								$device = DeviceModels::identify('bada', $this->device->model);
								if ($device->identified) {
									$this->device = $device;
									$this->os->name = 'Bada';
									
									switch($version) {
										case '2.0':		$this->os->version = new Version(array('value' => '1.0')); break;
										case '2.2':		$this->os->version = new Version(array('value' => '1.2')); break;
										case '3.0':		$this->os->version = new Version(array('value' => '2.0')); break;
									}	
								}

								else {
									$device = DeviceModels::identify('touchwiz', $this->device->model);
									if ($device->identified) {
										$this->device = $device;
										$this->os->name = 'Touchwiz';
										
										switch($version) {
											case '1.5':		$this->os->version = new Version(array('value' => '2.0')); break;
											case '2.0':		$this->os->version = new Version(array('value' => '3.0')); break;
										}	
									}
								}
							}
						}

						if (preg_match('/^ZTE[-_]?([^\s]+)/i', $candidates[$i], $match)) {
							$this->device->manufacturer = 'ZTE';
							$this->device->model = DeviceModels::cleanup($match[1]);
							$this->device->type = TYPE_MOBILE;
							$identified = true;
						}
					}
					
					if ($identified && !$this->device->identified) {
						if (!$this->device->identified) {
							$device = DeviceModels::identify('bada', $this->device->model);
							if ($device->identified) {
								$this->device = $device;
								$this->os->name = 'Bada';
							}
						}
													
						if (!$this->device->identified) {
							$device = DeviceModels::identify('touchwiz', $this->device->model);
							if ($device->identified) {
								$this->device = $device;
								$this->os->name = 'Touchwiz';
							}
						}
													
						if (!$this->device->identified) {
							$device = DeviceModels::identify('wp', $this->device->model);
							if ($device->identified) {
								$this->device = $device;
								$this->os->name = 'Windows Phone';
							}
						}
													
						if (!$this->device->identified) {
							$device = DeviceModels::identify('wm', $this->device->model);
							if ($device->identified) {
								$this->device = $device;
								$this->os->name = 'Windows Mobile';
							}
						}
													
						if (!$this->device->identified) {
							$device = DeviceModels::identify('android', $this->device->model);
							if ($device->identified) {
								$this->device = $device;
								$this->os->name = 'Android';
							}
						}
						
						if (!$this->device->identified) {
							$device = DeviceModels::identify('feature', $this->device->model);
							if ($device->identified) {
								$this->device = $device;
							}
						}
					}

					if ($identified && !$this->device->identified) {
						if (!$this->device->identified) {
							$device = DeviceModels::identify('bada', $this->device->manufacturer . ' ' . $this->device->model);
							if ($device->identified) {
								$this->device = $device;
								$this->os->name = 'Bada';
							}
						}
													
						if (!$this->device->identified) {
							$device = DeviceModels::identify('touchwiz', $this->device->manufacturer . ' ' . $this->device->model);
							if ($device->identified) {
								$this->device = $device;
								$this->os->name = 'Touchwiz';
							}
						}
													
						if (!$this->device->identified) {
							$device = DeviceModels::identify('wp', $this->device->manufacturer . ' ' . $this->device->model);
							if ($device->identified) {
								$this->device = $device;
								$this->os->name = 'Windows Phone';
							}
						}
													
						if (!$this->device->identified) {
							$device = DeviceModels::identify('wm', $this->device->manufacturer . ' ' . $this->device->model);
							if ($device->identified) {
								$this->device = $device;
								$this->os->name = 'Windows Mobile';
							}
						}
													
						if (!$this->device->identified) {
							$device = DeviceModels::identify('android', $this->device->manufacturer . ' ' . $this->device->model);
							if ($device->identified) {
								$this->device = $device;
								$this->os->name = 'Android';
							}
						}
						
						if (!$this->device->identified) {
							$device = DeviceModels::identify('feature', $this->device->manufacturer . ' ' . $this->device->model);
							if ($device->identified) {
								$this->device = $device;
							}
						}					}
											
					if ($identified && !$this->device->identified) {
						$this->device->identified = true;
					}
				}
			}
			

			if (preg_match('/SoftBank\/[^\/]+\/([^\/]+)\//', $ua, $match)) {
				$this->device->manufacturer = 'Softbank';
				$this->device->model = DeviceModels::cleanup($match[1]);
				$this->device->type = TYPE_MOBILE;
				$this->device->identified = true;
			}

			if (preg_match('/\((?:LG[-|\/])(.*) (?:Browser\/)?AppleWebkit/', $ua, $match)) {
				$this->device->manufacturer = 'LG';
				$this->device->model = DeviceModels::cleanup($match[1]);
				$this->device->type = TYPE_MOBILE;
				$this->device->identified = true;
			}

			if (preg_match('/^Mozilla\/5.0 \((?:Nokia|NOKIA)(?:\s?)([^\)]+)\)UC AppleWebkit\(like Gecko\) Safari\/530$/', $ua, $match)) {
				$this->device->manufacturer = 'Nokia';
				$this->device->model = DeviceModels::cleanup($match[1]);
				$this->device->type = TYPE_MOBILE;
				$this->device->identified = true;

				if (!$this->device->identified) {
					$device = DeviceModels::identify('s60', $this->device->model);
					if ($device->identified) {
						$this->device = $device;
						$this->os->name = 'Series60';
					}
				}

				if (!$this->device->identified) {
					$device = DeviceModels::identify('s40', $this->device->model);
					if ($device->identified) {
						$this->device = $device;
						$this->os->name = 'Series40';
					}
				}
			}

					
			
			/****************************************************
			 *		Safari
			 */
		
			if (preg_match('/Safari/', $ua)) {
				
				if (isset($this->os->name) && $this->os->name == 'iOS') {
					$this->browser->stock = true;
					$this->browser->hidden = true;
					$this->browser->name = 'Safari';
					$this->browser->version = null;
				}
				
				if (isset($this->os->name) && ($this->os->name == 'Mac OS X' || $this->os->name == 'Windows')) {
					$this->browser->name = 'Safari';
					$this->browser->stock = $this->os->name == 'Mac OS X';

					if (preg_match('/Version\/([0-9\.]+)/', $ua, $match)) {
						$this->browser->version = new Version(array('value' => $match[1]));
					}		

					if (preg_match('/AppleWebKit\/[0-9\.]+\+/', $ua)) {
						$this->browser->name = 'WebKit Nightly Build';
						$this->browser->version = null;
					}
				}
			}

			/****************************************************
			 *		Internet Explorer
			 */
		
			if (preg_match('/MSIE/', $ua)) {
				$this->browser->name = 'Internet Explorer';
				
				if (preg_match('/IEMobile/', $ua) || preg_match('/Windows CE/', $ua) || preg_match('/Windows Phone/', $ua) || preg_match('/WP7/', $ua) || preg_match('/WPDesktop/', $ua)) {
					$this->browser->name = 'Mobile Internet Explorer';
				}

				if (preg_match('/MSIE ([0-9.]*)/', $ua, $match)) {
					$this->browser->version = new Version(array('value' => $match[1]));
				}
			}

			if (preg_match('/\(IE ([0-9.]*)/', $ua, $match)) {
				$this->browser->name = 'Internet Explorer';
				$this->browser->version = new Version(array('value' => $match[1]));
			}

			if (preg_match('/Trident\/[789][^\)]+; rv:([0-9.]*)\)/', $ua, $match)) {
				$this->browser->name = 'Internet Explorer';
				$this->browser->version = new Version(array('value' => $match[1]));
			}

			/****************************************************
			 *		Firefox
			 */
		
			if (preg_match('/Firefox/', $ua)) {
				$this->browser->stock = false;
				$this->browser->name = 'Firefox';

				if (preg_match('/Firefox\/([0-9ab.]*)/', $ua, $match)) {
					$this->browser->version = new Version(array('value' => $match[1]));
					
					if (preg_match('/a/', $match[1])) {
						$this->browser->channel = 'Aurora';
					}

					if (preg_match('/b/', $match[1])) {
						$this->browser->channel = 'Beta';
					}
				}

				if (preg_match('/Fennec/', $ua)) {
					$this->device->type = TYPE_MOBILE;
				}
				
				if (preg_match('/Mobile; rv/', $ua)) {
					$this->device->type = TYPE_MOBILE;
				}

				if (preg_match('/Tablet; rv/', $ua)) {
					$this->device->type = TYPE_TABLET;
				}
				
				if ($this->device->type == TYPE_MOBILE || $this->device->type == TYPE_TABLET) {
					$this->browser->name = 'Firefox Mobile';
				}

				if ($this->device->type == '') {
					$this->device->type = TYPE_DESKTOP;
				}
			}

			if (preg_match('/Namoroka/', $ua)) {
				$this->browser->stock = false;
				$this->browser->name = 'Firefox';

				if (preg_match('/Namoroka\/([0-9ab.]*)/', $ua, $match)) {
					$this->browser->version = new Version(array('value' => $match[1]));
				}

				$this->browser->channel = 'Namoroka';
			}

			if (preg_match('/Shiretoko/', $ua)) {
				$this->browser->stock = false;
				$this->browser->name = 'Firefox';

				if (preg_match('/Shiretoko\/([0-9ab.]*)/', $ua, $match)) {
					$this->browser->version = new Version(array('value' => $match[1]));
				}
				
				$this->browser->channel = 'Shiretoko';
			}
			
			if (preg_match('/Minefield/', $ua)) {
				$this->browser->stock = false;
				$this->browser->name = 'Firefox';

				if (preg_match('/Minefield\/([0-9ab.]*)/', $ua, $match)) {
					$this->browser->version = new Version(array('value' => $match[1]));
				}

				$this->browser->channel = 'Minefield';
			}
			
			if (preg_match('/Firebird/', $ua)) {
				$this->browser->stock = false;
				$this->browser->name = 'Firebird';

				if (preg_match('/Firebird\/([0-9ab.]*)/', $ua, $match)) {
					$this->browser->version = new Version(array('value' => $match[1]));
				}
			}
			
			/****************************************************
			 *		SeaMonkey
			 */
		
			if (preg_match('/SeaMonkey/', $ua)) {
				$this->browser->stock = false;
				$this->browser->name = 'SeaMonkey';

				if (preg_match('/SeaMonkey\/([0-9ab.]*)/', $ua, $match)) {
					$this->browser->version = new Version(array('value' => $match[1]));
				}

				if ($this->device->type == '') {
					$this->device->type = TYPE_DESKTOP;
				}
			}
			
			if (preg_match('/PmWFx\/([0-9ab.]*)/', $ua, $match)) {
				$this->browser->stock = false;
				$this->browser->name = 'SeaMonkey';
				$this->browser->version = new Version(array('value' => $match[1]));
			}
			
			

			/****************************************************
			 *		Netscape
			 */
		
			if (preg_match('/Netscape/', $ua)) {
				$this->browser->stock = false;
				$this->browser->name = 'Netscape';

				if (preg_match('/Netscape[0-9]?\/([0-9.]*)/', $ua, $match)) {
					$this->browser->version = new Version(array('value' => $match[1]));
				}
			}

			/****************************************************
			 *		Konqueror
			 */
		
			if (preg_match('/[k|K]onqueror\//', $ua)) {
				$this->browser->name = 'Konqueror';

				if (preg_match('/[k|K]onqueror\/([0-9.]*)/', $ua, $match)) {
					$this->browser->version = new Version(array('value' => $match[1]));
				}

				if ($this->device->type == '') {
					$this->device->type = TYPE_DESKTOP;
				}
			}

			/****************************************************
			 *		Chrome
			 */
		
			if (preg_match('/(?:Chrome|CrMo|CriOS)\/([0-9.]*)/', $ua, $match)) {
				$this->browser->stock = false;
				$this->browser->name = 'Chrome';
				$this->browser->version = new Version(array('value' => $match[1]));

				if ($this->os->name == 'Android') {
					switch (implode('.', array_splice(explode('.', $match[1]), 0, 3))) {
						case '16.0.912':
							$this->browser->channel = 'Beta';
							break;
						case '18.0.1025':
						case '25.0.1364':
							$this->browser->version->details = 1;
							break;
						default:	
							$this->browser->channel = 'Nightly';
							break;
					}
				}
								
				else {
					switch (implode('.', array_splice(explode('.', $match[1]), 0, 3))) {
						case '0.2.149':
						case '0.3.154':
						case '0.4.154':
						case '4.1.249':
							$this->browser->version->details = 2;
							break;
						
						case '1.0.154':
						case '2.0.172':
						case '3.0.195':
						case '4.0.249':
						case '5.0.375':
						case '6.0.472':
						case '7.0.517':
						case '8.0.552':
						case '9.0.597':
						case '10.0.648':
						case '11.0.696':
						case '12.0.742':
						case '13.0.782':
						case '14.0.835':
						case '15.0.874':
						case '16.0.912':
						case '17.0.963':
						case '18.0.1025':
						case '19.0.1084':
						case '20.0.1132':
						case '21.0.1180':
						case '22.0.1229':
						case '23.0.1271':
						case '24.0.1312':
						case '25.0.1364':
						case '26.0.1410':
						case '27.0.1453':
							$this->browser->version->details = 1;
							break;
						default:	
							$this->browser->channel = 'Nightly';
							break;
					}
				}

				if ($this->device->type == '') {
					$this->device->type = TYPE_DESKTOP;
				}
			}
			
			/****************************************************
			 *		Chromium
			 */
		
			if (preg_match('/Chromium/', $ua)) {
				$this->browser->stock = false;
				$this->browser->channel = '';
				$this->browser->name = 'Chromium';

				if (preg_match('/Chromium\/([0-9.]*)/', $ua, $match)) {
					$this->browser->version = new Version(array('value' => $match[1]));
				}

				if ($this->device->type == '') {
					$this->device->type = TYPE_DESKTOP;
				}
			}	
			
			
			/****************************************************
			 *		Opera
			 */
		
			if (preg_match('/OPR\/([0-9.]*)/', $ua, $match)) {
				$this->browser->stock = false;
				$this->browser->channel = '';
				$this->browser->name = 'Opera';
				$this->browser->version = new Version(array('value' => $match[1], 'details' => 2));

				if (preg_match('/Edition Next/', $ua)) {
					$this->browser->channel = 'Next';
				}

				if ($this->device->type == TYPE_MOBILE) {
					$this->browser->name = 'Opera Mobile';
				}
			}

			if (preg_match('/Opera/i', $ua)) {
				$this->browser->stock = false;
				$this->browser->name = 'Opera';

				if (preg_match('/Opera[\/| ]([0-9.]*)/', $ua, $match)) {
					$this->browser->version = new Version(array('value' => $match[1]));
				}

				if (preg_match('/Version\/([0-9.]*)/', $ua, $match)) {
					if (floatval($match[1]) >= 10)
						$this->browser->version = new Version(array('value' => $match[1]));
					else
						$this->browser->version = null;
				}

				if (!is_null($this->browser->version) && preg_match('/Edition Labs/', $ua)) {
					$this->browser->channel = 'Labs';
				}
				
				if (!is_null($this->browser->version) && preg_match('/Edition Next/', $ua)) {
					$this->browser->channel = 'Next';
				}
				
				if (preg_match('/Opera Tablet/', $ua)) {
					$this->browser->name = 'Opera Mobile';
					$this->device->type = TYPE_TABLET;
				}
				
				if (preg_match('/Opera Mobi/', $ua)) {
					$this->browser->name = 'Opera Mobile';
					$this->device->type = TYPE_MOBILE;
				}

				if (preg_match('/Opera Mini;/', $ua)) {
					$this->browser->name = 'Opera Mini';
					$this->browser->version = null;
					$this->browser->mode = 'proxy';
					$this->device->type = TYPE_MOBILE;
				}
				
				if (preg_match('/Opera Mini\/(?:att\/)?([0-9.]*)/', $ua, $match)) {
					$this->browser->name = 'Opera Mini';
					$this->browser->version = new Version(array('value' => $match[1], 'details' => (intval(substr(strrchr($match[1], '.'), 1)) > 99 ? -1 : null)));
					$this->browser->mode = 'proxy';
					$this->device->type = TYPE_MOBILE;
				}
				
				if ($this->browser->name == 'Opera' && $this->device->type == TYPE_MOBILE) {
					$this->browser->name = 'Opera Mobile';
					
					if (preg_match('/BER/', $ua)) {
						$this->browser->name = 'Opera Mini';
						$this->browser->version = null;
					}
				}

				if (preg_match('/InettvBrowser/', $ua)) {
					$this->device->type = TYPE_TELEVISION;
				}

				if (preg_match('/Opera[ -]TV/', $ua)) {
					$this->browser->name = 'Opera';
					$this->device->type = TYPE_TELEVISION;
				}

				if (preg_match('/Linux zbov/', $ua)) {
					$this->browser->name = 'Opera Mobile';
					$this->browser->mode = 'desktop';

					$this->device->type = TYPE_MOBILE;

					$this->os->name = null;
					$this->os->version = null;
				}

				if (preg_match('/Linux zvav/', $ua)) {
					$this->browser->name = 'Opera Mini';
					$this->browser->version = null;
					$this->browser->mode = 'desktop';

					$this->device->type = TYPE_MOBILE;

					$this->os->name = null;
					$this->os->version = null;
				}
				
				if ($this->device->type == '') {
					$this->device->type = TYPE_DESKTOP;
				}
			}

			/****************************************************
			 *		wOSBrowser
			 */
		
			if (preg_match('/wOSBrowser/', $ua)) {
				$this->browser->name = 'webOS Browser';
				
				if ($this->os->name != 'webOS') {
					$this->os->name = 'webOS';
				}
			}

			/****************************************************
			 *		BrowserNG
			 */
		
			if (preg_match('/BrowserNG/', $ua)) {
				$this->browser->name = 'Nokia Browser';

				if (preg_match('/BrowserNG\/([0-9.]*)/', $ua, $match)) {
					$this->browser->version = new Version(array('value' => $match[1], 'details' => 3, 'builds' => false));
				}
			}	

			/****************************************************
			 *		Nokia Browser
			 */
		
			if (preg_match('/NokiaBrowser/', $ua)) {
				$this->browser->name = 'Nokia Browser';

				if (preg_match('/NokiaBrowser\/([0-9.]*)/', $ua, $match)) {
					$this->browser->version = new Version(array('value' => $match[1], 'details' => 3));
				}
			}	
			
			/****************************************************
			 *		Nokia Xpress
			 *
			 *		Mozilla/5.0 (X11; Linux x86_64; rv:5.0.1) Gecko/20120822 OSRE/1.0.7f
			 */
			
			if (preg_match('/OSRE/', $ua)) {
				$this->browser->name = 'Nokia Xpress';
				$this->browser->mode = 'proxy';
				$this->device->type = TYPE_MOBILE;

				$this->os->name = null;
				$this->os->version = null;
			}

			if (preg_match('/S40OviBrowser/', $ua)) {
				$this->browser->name = 'Nokia Xpress';
				$this->browser->mode = 'proxy';

				if (preg_match('/S40OviBrowser\/([0-9.]*)/', $ua, $match)) {
					$this->browser->version = new Version(array('value' => $match[1], 'details' => 3));
				}
	
				if (preg_match('/Nokia([^\/]+)\//', $ua, $match)) {
					$this->device->manufacturer = 'Nokia';
					$this->device->model = $match[1];
					$this->device->identified = true;
	
					$device = DeviceModels::identify('s40', $this->device->model);
					if ($device->identified) {
						$this->device = $device;
					}
				}
				
				if (preg_match('/NOKIALumia([0-9]+)/', $ua, $match)) {
					$this->device->manufacturer = 'Nokia';
					$this->device->model = $match[1];
	
					$device = DeviceModels::identify('wp', $this->device->model);
					if ($device->identified) {
						$this->device = $device;
						$this->os->name = 'Windows Phone';
					}
				}
			}
			
			
			/****************************************************
			 *		MicroB
			 */
		
			if (preg_match('/Maemo[ |_]Browser/', $ua)) {
				$this->browser->name = 'MicroB';

				if (preg_match('/Maemo[ |_]Browser[ |_]([0-9.]*)/', $ua, $match)) {
					$this->browser->version = new Version(array('value' => $match[1], 'details' => 3));
				}
			}
			

			/****************************************************
			 *		NetFront
			 */
		
			if (preg_match('/Net[fF]ront/', $ua)) {
				$this->browser->name = 'NetFront';
				$this->device->type = TYPE_MOBILE;

				if (preg_match('/NetFront\/?([0-9.]*)/i', $ua, $match)) {
					$this->browser->version = new Version(array('value' => $match[1]));
				}

				if (preg_match('/InettvBrowser/', $ua)) {
					$this->device->type = TYPE_TELEVISION;
				}
			}
			
			/****************************************************
			 *		Silk
			 */
		
			if (preg_match('/Silk/', $ua)) {
				if (preg_match('/Silk-Accelerated/', $ua)) {
					$this->browser->name = 'Silk';

					if (preg_match('/Silk\/([0-9.]*)/', $ua, $match)) {
						$this->browser->version = new Version(array('value' => $match[1], 'details' => 2));
					}
	
					if (preg_match('/; ([^;]*[^;\s])\s+Build/', $ua, $match)) {
						$this->device = DeviceModels::identify('android', $match[1]);
					}		

					if (!$this->device->identified) {
						$this->device->manufacturer = 'Amazon';
						$this->device->model = 'Kindle Fire';
						$this->device->type = TYPE_TABLET;
						$this->device->identified = true;
					}
					
					if ($this->os->name != 'Android') {
						$this->os->name = 'Android';
						$this->os->version = null;
					}
				}
			}

			/****************************************************
			 *		Dolfin
			 */
		
			if (preg_match('/Dolfin/', $ua) || preg_match('/Jasmine/', $ua)) {
				$this->browser->name = 'Dolfin';

				if (preg_match('/Dolfin\/([0-9.]*)/', $ua, $match)) {
					$this->browser->version = new Version(array('value' => $match[1]));
				}

				if (preg_match('/Browser\/Dolfin([0-9.]*)/', $ua, $match)) {
					$this->browser->version = new Version(array('value' => $match[1]));
				}

				if (preg_match('/Jasmine\/([0-9.]*)/', $ua, $match)) {
					$this->browser->version = new Version(array('value' => $match[1]));
				}
			}

			/****************************************************
			 *		Iris
			 */
		
			if (preg_match('/Iris/', $ua)) {
				$this->browser->name = 'Iris';

				$this->device->type = TYPE_MOBILE;
				$this->device->manufacturer = null;
				$this->device->model = null;

				$this->os->name = 'Windows Mobile';
				$this->os->version = null;

				if (preg_match('/Iris\/([0-9.]*)/', $ua, $match)) {
					$this->browser->version = new Version(array('value' => $match[1]));
				}
				
				if (preg_match('/ WM([0-9]) /', $ua, $match)) {
					$this->os->version = new Version(array('value' => $match[1] . '.0'));
				} else {
					$this->browser->mode = 'desktop';
				}
			}

			/****************************************************
			 *		Boxee
			 */
		
			if (preg_match('/Boxee/', $ua)) {
				$this->browser->name = 'Boxee';
				$this->device->type = TYPE_TELEVISION;

				if (preg_match('/Boxee\/([0-9.]*)/', $ua, $match)) {
					$this->browser->version = new Version(array('value' => $match[1]));
				}
			}

			/****************************************************
			 *		LG Browser
			 */

			if (preg_match('/LG Browser\/([0-9.]*)/', $ua, $match)) {
				$this->browser->name = 'LG Browser';
				$this->browser->version = new Version(array('value' => $match[1], 'details' => 2));
				$this->device->type = TYPE_TELEVISION;
			}
			
			/****************************************************
			 *		Espial
			 */
		
			if (preg_match('/Espial/', $ua)) {
				$this->browser->name = 'Espial';
				
				$this->os->name = '';
				$this->os->version = null;

				if ($this->device->type != TYPE_TELEVISION) {
					$this->device->type = TYPE_TELEVISION;
					$this->device->manufacturer = null;
					$this->device->model = null;
				}
				
				if (preg_match('/Espial\/([0-9.]*)/', $ua, $match)) {
					$this->browser->version = new Version(array('value' => $match[1]));
				}
				
				if (preg_match('/;L7200/', $ua)) {
					$this->device->manufacturer = 'Toshiba';
					$this->device->model = 'L7200 Smart TV';
					$this->device->identified = true;
				}
			}

			/****************************************************
			 *		ANT Galio
			 */

			if (preg_match('/ANTGalio\/([0-9.]*)/', $ua, $match)) {
				$this->browser->name = 'ANT Galio';
				$this->browser->version = new Version(array('value' => $match[1], 'details' => 3));
				$this->device->type = TYPE_TELEVISION;
			}
			
			/****************************************************
			 *		NetFront NX
			 */

			if (preg_match('/NX\/([0-9.]*)/', $ua, $match)) {
				$this->browser->name = 'NetFront NX';
				$this->browser->version = new Version(array('value' => $match[1], 'details' => 2));

				if (preg_match('/DTV/i', $ua)) {
					$this->device->type = TYPE_TELEVISION;
				} else if (preg_match('/mobile/i', $ua)) {
					$this->device->type = TYPE_MOBILE;
				} else {
					$this->device->type = TYPE_DESKTOP;
				}
				
				$this->os->name = '';
				$this->os->version = null;
			}
			
			/****************************************************
			 *		Obigo
			 */
		
			if (preg_match('/Obigo/i', $ua)) {
				$this->browser->name = 'Obigo';

				if (preg_match('/Obigo\/([0-9.]*)/i', $ua, $match)) {
					$this->browser->version = new Version(array('value' => $match[1]));
				}

				if (preg_match('/Obigo\/([A-Z])([0-9.]*)/i', $ua, $match)) {
					$this->browser->name = 'Obigo ' . $match[1];
					$this->browser->version = new Version(array('value' => $match[2]));
				}

				if (preg_match('/Obigo-([A-Z])([0-9.]*)\//i', $ua, $match)) {
					$this->browser->name = 'Obigo ' . $match[1];
					$this->browser->version = new Version(array('value' => $match[2]));
				}

				if (preg_match('/Browser\/Obigo-([A-Z])([0-9.]*)/i', $ua, $match)) {
					$this->browser->name = 'Obigo ' . $match[1];
					$this->browser->version = new Version(array('value' => $match[2]));
				}
			}

			/****************************************************
			 *		UC Web
			 */
		
			if (preg_match('/UCWEB/', $ua)) {
				$this->browser->stock = false;
				$this->browser->name = 'UC Browser';

				unset($this->browser->channel);
				
				if (preg_match('/UCWEB\/?([0-9]*[.][0-9]*)/', $ua, $match)) {
					$this->browser->version = new Version(array('value' => $match[1], 'details' => 3));
				}

				if (!$this->device->type) {
					$this->device->type = TYPE_MOBILE;
				}

				if (isset($this->os->name) && $this->os->name == 'Linux') {
					$this->os->name = '';
				}
				
				if (preg_match('/^IUC \(U;\s?iOS ([0-9\.]+);/', $ua, $match)) {
					$this->os->name = 'iOS';
					$this->os->version = new Version(array('value' => $match[1]));
				}
				
				if (preg_match('/^JUC \(Linux; U; ([0-9\.]+)[^;]*; [^;]+; ([^;]*[^\s])\s*; [0-9]+\*[0-9]+\)/', $ua, $match)) {
					$this->os->name = 'Android';
					$this->os->version = new Version(array('value' => $match[1]));
					
					$this->device = DeviceModels::identify('android', $match[2]);
				}
				
				if (preg_match('/; Adr ([0-9\.]+); [^;]+; ([^;]*[^\s])\)/', $ua, $match)) {
					$this->os->name = 'Android';
					$this->os->version = new Version(array('value' => $match[1]));
					
					$this->device = DeviceModels::identify('android', $match[2]);
				}
			}

			if (preg_match('/ucweb-squid/', $ua)) {
				$this->browser->stock = false;
				$this->browser->name = 'UC Browser';

				unset($this->browser->channel);
			}

			if (preg_match('/\) UC /', $ua)) {
				$this->browser->stock = false;
				$this->browser->name = 'UC Browser';
				
				unset($this->browser->version);
				unset($this->browser->channel);
				unset($this->browser->mode);

				if (!$this->device->type) {
					$this->device->type = TYPE_MOBILE;
				}
				
				if ($this->device->type == TYPE_DESKTOP) {
					$this->device->type = TYPE_MOBILE;
					$this->browser->mode = 'desktop';
				}
			}

			if (preg_match('/UC ?Browser\/?([0-9.]*)/', $ua, $match)) {
				$this->browser->stock = false;
				$this->browser->name = 'UC Browser';
				$this->browser->version = new Version(array('value' => $match[1], 'details' => 2));

				unset($this->browser->channel);

				if (!$this->device->type) {
					$this->device->type = TYPE_MOBILE;
				}
			}

			if (preg_match('/U2\//', $ua)) {
				$this->browser->mode = 'proxy';
			}

			if (preg_match('/U3\//', $ua)) {
				$this->engine->name = 'Webkit';
			}

						
			/****************************************************
			 *		NineSky
			 */
		
			if (preg_match('/Ninesky(?:-android-mobile(?:-cn)?)?\/([0-9.]*)/', $ua, $match)) {
				$this->browser->name = 'NineSky';
				$this->browser->version = new Version(array('value' => $match[1]));

				if ($this->os->name != 'Android') {
					$this->os->name = 'Android';
					$this->os->version = null;
					
					$this->device->manufacturer = null;
					$this->device->model = null;
				}
			}

			/****************************************************
			 *		Skyfire
			 */
		
			if (preg_match('/Skyfire\/([0-9.]*)/', $ua, $match)) {
				$this->browser->name = 'Skyfire';
				$this->browser->version = new Version(array('value' => $match[1]));

				$this->device->type = TYPE_MOBILE;

				$this->os->name = 'Android';
				$this->os->version = null;
			}
			
			/****************************************************
			 *		Dolphin HD
			 */
		
			if (preg_match('/DolphinHDCN\/([0-9.]*)/', $ua, $match)) {
				$this->browser->name = 'Dolphin';
				$this->browser->version = new Version(array('value' => $match[1]));

				$this->device->type = TYPE_MOBILE;

				if ($this->os->name != 'Android') {
					$this->os->name = 'Android';
					$this->os->version = null;
				}
			}

			if (preg_match('/Dolphin\/(?:INT|CN)/', $ua, $match)) {
				$this->browser->name = 'Dolphin';
				$this->device->type = TYPE_MOBILE;
			}
			
			/****************************************************
			 *		QQ Browser
			 */
		
			if (preg_match('/(M?QQBrowser)\/([0-9.]*)/', $ua, $match)) {
				$this->browser->name = 'QQ Browser';

				$version = $match[2];
				if (preg_match('/^[0-9][0-9]$/', $version)) $version = $version[0] . '.' . $version[1];
				
				$this->browser->version = new Version(array('value' => $version, 'details' => 2));
				$this->browser->channel = '';
				
				if (!$this->os->name && $match[1] == 'QQBrowser') {
					$this->os->name = 'Windows';
				}
			}	

			/****************************************************
			 *		iBrowser
			 */
		
			if (preg_match('/(iBrowser)\/([0-9.]*)/', $ua, $match) && !preg_match('/OviBrowser/', $ua)) {
				$this->browser->name = 'iBrowser';
				
				$version = $match[2];
				if (preg_match('/^[0-9][0-9]$/', $version)) $version = $version[0] . '.' . $version[1];
				
				$this->browser->version = new Version(array('value' => $version, 'details' => 2));
				$this->browser->channel = '';
			}	

			/****************************************************
			 *		Puffin
			 */
		
			if (preg_match('/Puffin\/([0-9.]*)/', $ua, $match)) {
				$this->browser->name = 'Puffin';
				$this->browser->version = new Version(array('value' => $match[1], 'details' => 2));
				$this->browser->mode = 'proxy';
				$this->browser->channel = '';
				
				$this->device->type = TYPE_MOBILE;

				if ($this->os->name == 'Linux') {
					$this->os->name = null;
					$this->os->version = null;
				}
			}	

			/****************************************************
			 *		Midori
			 */
		
			if (preg_match('/Midori\/([0-9.]*)/', $ua, $match)) {
				$this->browser->name = 'Midori';
				$this->browser->version = new Version(array('value' => $match[1]));

				if ($this->os->name != 'Linux') {
					$this->os->name = 'Linux';
					$this->os->version = null;
				}

				$this->device->manufacturer = null;
				$this->device->model = null;
				$this->device->type = TYPE_DESKTOP;
			}	

			if (preg_match('/midori$/', $ua)) {
				$this->browser->name = 'Midori';
			}


			/****************************************************
			 *		MiniBrowser Mobile
			 */
		
			if (preg_match('/MiniBr?owserM(?:obile)?\/([0-9.]*)/', $ua, $match)) {
				$this->browser->name = 'MiniBrowser';
				$this->browser->version = new Version(array('value' => $match[1]));

				$this->os->name = 'Series60';
				$this->os->version = null;
			}
						
			/****************************************************
			 *		Maxthon
			 */
		
			if (preg_match('/Maxthon[\/\' ]([0-9.]*)/', $ua, $match)) {
				$this->browser->name = 'Maxthon';
				$this->browser->version = new Version(array('value' => $match[1], 'details' => 3));
				$this->browser->channel = '';
				
				if ($this->os->name == 'Windows' && $this->browser->version->toFloat() < 4) {
					$this->browser->version->details = 1;
				}
			}	

			/****************************************************
			 *		Others
			 */

			$browsers = array(
				array('name' => 'AdobeAIR',				'regexp' => '/AdobeAIR\/([0-9.]*)/'),
				array('name' => 'Awesomium',			'regexp' => '/Awesomium\/([0-9.]*)/'),
				array('name' => 'Bsalsa Embedded',		'regexp' => '/EmbeddedWB ([0-9.]*)/'),
				array('name' => 'Canvace',				'regexp' => '/Canvace Standalone\/([0-9.]*)/'),
				array('name' => 'Ekioh',				'regexp' => '/Ekioh\/([0-9.]*)/'),
				array('name' => 'JavaFX',				'regexp' => '/JavaFX\/([0-9.]*)/'),
				array('name' => 'GFXe',					'regexp' => '/GFXe\/([0-9.]*)/'),
				array('name' => 'LuaKit',				'regexp' => '/luakit/'),
				array('name' => 'Titanium',				'regexp' => '/Titanium\/([0-9.]*)/'),
				array('name' => 'OpenWebKitSharp',		'regexp' => '/OpenWebKitSharp/'),
				array('name' => 'Prism',				'regexp' => '/Prism\/([0-9.]*)/'),
				array('name' => 'Qt',					'regexp' => '/Qt\/([0-9.]*)/'),
				array('name' => 'QtEmbedded',			'regexp' => '/QtEmbedded/'),
				array('name' => 'QtEmbedded',			'regexp' => '/QtEmbedded.*Qt\/([0-9.]*)/'),
				array('name' => 'RhoSimulator',			'regexp' => '/RhoSimulator/'),
				array('name' => 'UWebKit',				'regexp' => '/UWebKit\/([0-9.]*)/'),
				
				array('name' => 'PhantomJS',			'regexp' => '/PhantomJS\/([0-9.]*)/'),
				
				array('name' => 'Google Earth',			'regexp' => '/Google Earth\/([0-9.]*)/'),
				array('name' => 'EA Origin',			'regexp' => '/Origin\/([0-9.]*)/'),
				array('name' => 'SecondLife',			'regexp' => '/SecondLife\/([0-9.]*)/'),
				array('name' => 'Valve Steam',			'regexp' => '/Valve Steam/'),
				
				array('name' => 'Songbird',				'regexp' => '/Songbird\/([0-9.]*)/'),
				array('name' => 'Thunderbird',			'regexp' => '/Thunderbird[\/ ]([0-9.]*)/', 'type' => TYPE_DESKTOP),
				array('name' => 'Microsoft Outlook',	'regexp' => '/Microsoft Outlook IMO, Build ([0-9.]*)/', 'details' => 2, 'type' => TYPE_DESKTOP),
				
				array('name' => '360 Extreme Explorer',	'regexp' => '/QIHU 360EE/', 'type' => TYPE_DESKTOP),
				array('name' => '360 Safe Explorer',	'regexp' => '/QIHU 360SE/', 'type' => TYPE_DESKTOP),
				array('name' => '360 Phone Browser',	'regexp' => '/360 Android Phone Browser \(V([0-9.]*)\)/'),
				array('name' => '360 Phone Browser',	'regexp' => '/360 Aphone Browser \(Version ([0-9.]*)\)/'),
				array('name' => 'ABrowse',				'regexp' => '/A[Bb]rowse ([0-9.]*)/'),
				array('name' => 'Abrowser',				'regexp' => '/Abrowser\/([0-9.]*)/'),
				array('name' => 'AltiBrowser',			'regexp' => '/AltiBrowser\/([0-9.]*)/i'),
				array('name' => 'arora',				'regexp' => '/[Aa]rora\/([0-9.]*)/'),
				array('name' => 'Avant Browser',		'regexp' => '/Avant TriCore/'),
				array('name' => 'Baidu Browser',		'regexp' => '/M?BaiduBrowser\/([0-9.]*)/i'),
				array('name' => 'Baidu Browser',		'regexp' => '/BdMobile\/([0-9.]*)/i'),
				array('name' => 'Baidu Browser',		'regexp' => '/FlyFlow\/([0-9.]*)/', 'details' => 2),
				array('name' => 'Baidu Browser',		'regexp' => '/BIDUBrowser[ \/]([0-9.]*)/'),
				array('name' => 'Camino', 				'regexp' => '/Camino\/([0-9.]*)/', 'type' => TYPE_DESKTOP),
				array('name' => 'Canure', 				'regexp' => '/Canure\/([0-9.]*)/', 'details' => 3),
				array('name' => 'CometBird', 			'regexp' => '/CometBird\/([0-9.]*)/'),
				array('name' => 'Comodo Dragon', 		'regexp' => '/Comodo_Dragon\/([0-9.]*)/', 'details' => 2),
				array('name' => 'Conkeror', 			'regexp' => '/[Cc]onkeror\/([0-9.]*)/'),
				array('name' => 'CoolNovo', 			'regexp' => '/(?:CoolNovo|CoolNovoChromePlus)\/([0-9.]*)/', 'details' => 3, 'type' => TYPE_DESKTOP),
				array('name' => 'ChromePlus', 			'regexp' => '/ChromePlus(?:\/([0-9.]*))?$/', 'details' => 3, 'type' => TYPE_DESKTOP),
				array('name' => 'Daedalus', 			'regexp' => '/Daedalus ([0-9.]*)/', 'details' => 2),
				array('name' => 'Demobrowser', 			'regexp' => '/demobrowser\/([0-9.]*)/'),
				array('name' => 'Doga Rhodonit', 		'regexp' => '/DogaRhodonit/'),
				array('name' => 'Dooble', 				'regexp' => '/Dooble(?:\/([0-9.]*))?/'),
				array('name' => 'Dorothy', 				'regexp' => '/Dorothy$/'),
				array('name' => 'DWB', 					'regexp' => '/dwb(?:-hg)?(?:\/([0-9.]*))?/'),
				array('name' => 'GNOME Web', 			'regexp' => '/Epiphany\/([0-9.]*)/', 'type' => TYPE_DESKTOP),
				array('name' => 'EVM Browser', 			'regexp' => '/EVMBrowser\/([0-9.]*)/'),
				array('name' => 'FireWeb', 				'regexp' => '/FireWeb\/([0-9.]*)/'),
				array('name' => 'Flock', 				'regexp' => '/Flock\/([0-9.]*)/', 'details' => 3, 'type' => TYPE_DESKTOP),
				array('name' => 'Galeon', 				'regexp' => '/Galeon\/([0-9.]*)/', 'details' => 3),
				array('name' => 'Helium', 				'regexp' => '/HeliumMobileBrowser\/([0-9.]*)/'),
				array('name' => 'Hive Explorer', 		'regexp' => '/HiveE/'),
				array('name' => 'iCab', 				'regexp' => '/iCab\/([0-9.]*)/'),
				array('name' => 'Iceape', 				'regexp' => '/Iceape\/([0-9.]*)/'),
				array('name' => 'IceCat', 				'regexp' => '/IceCat[ \/]([0-9.]*)/', 'type' => TYPE_DESKTOP),
				array('name' => 'Iceweasel', 			'regexp' => '/Iceweasel\/([0-9.]*)/', 'type' => TYPE_DESKTOP),
				array('name' => 'InternetSurfboard', 	'regexp' => '/InternetSurfboard\/([0-9.]*)/'),
				array('name' => 'Iron', 				'regexp' => '/Iron\/([0-9.]*)/', 'details' => 2),
				array('name' => 'Isis', 				'regexp' => '/BrowserServer/'),
				array('name' => 'Jumanji', 				'regexp' => '/jumanji/'),
				array('name' => 'Kazehakase', 			'regexp' => '/Kazehakase\/([0-9.]*)/'),
				array('name' => 'KChrome', 				'regexp' => '/KChrome\/([0-9.]*)/', 'details' => 3),
				array('name' => 'Kiosk', 				'regexp' => '/Kiosk\/([0-9.]*)/'),
				array('name' => 'K-Meleon', 			'regexp' => '/K-Meleon\/([0-9.]*)/', 'type' => TYPE_DESKTOP),
				array('name' => 'Leechcraft', 			'regexp' => '/Leechcraft(?:\/([0-9.]*))?/', 'details' => 2),
				array('name' => 'Lightning', 			'regexp' => '/Lightning\/([0-9.]*)/'),
				array('name' => 'Lunascape', 			'regexp' => '/Lunascape[\/| ]([0-9.]*)/', 'details' => 3),
				array('name' => 'Lynx', 				'regexp' => '/Lynx\/([0-9.]*)/'),
				array('name' => 'iLunascape', 			'regexp' => '/iLunascape\/([0-9.]*)/', 'details' => 3),
				array('name' => 'Intermec Browser', 	'regexp' => '/Intermec\/([0-9.]*)/', 'details' => 2),
				array('name' => 'MaCross Mobile', 		'regexp' => '/MaCross\/([0-9.]*)/'),
				array('name' => 'Mercury Browser', 		'regexp' => '/Mercury\/([0-9.]*)/'),
				array('name' => 'MixShark', 			'regexp' => '/MixShark\/([0-9.]*)/'),
				array('name' => 'Motorola WebKit', 		'regexp' => '/MotorolaWebKit(?:\/([0-9.]*))?/', 'details' => 3),
				array('name' => 'NetFront LifeBrowser', 'regexp' => '/NetFrontLifeBrowser\/([0-9.]*)/'),
				array('name' => 'NetPositive', 			'regexp' => '/NetPositive\/([0-9.]*)/'),
				array('name' => 'Netscape Navigator', 	'regexp' => '/Navigator\/([0-9.]*)/', 'details' => 3),
				array('name' => 'Odyssey', 				'regexp' => '/OWB\/([0-9.]*)/'),
				array('name' => 'OmniWeb', 				'regexp' => '/OmniWeb/', 'type' => TYPE_DESKTOP),
				array('name' => 'OneBrowser', 			'regexp' => '/OneBrowser\/([0-9.]*)/'),
				array('name' => 'Orca', 				'regexp' => '/Orca\/([0-9.]*)/'),
				array('name' => 'Origyn', 				'regexp' => '/Origyn Web Browser/'),
				array('name' => 'Palemoon', 			'regexp' => '/Pale[mM]oon\/([0-9.]*)/'),
				array('name' => 'Phantom', 				'regexp' => '/Phantom\/V([0-9.]*)/'),
				array('name' => 'Polaris', 				'regexp' => '/Polaris\/v?([0-9.]*)/i', 'details' => 2),
				array('name' => 'Qihoo 360', 			'regexp' => '/QIHU THEWORLD/'),
				array('name' => 'QtCreator', 			'regexp' => '/QtCreator\/([0-9.]*)/'),
				array('name' => 'QtQmlViewer', 			'regexp' => '/QtQmlViewer/'),
				array('name' => 'QtTestBrowser', 		'regexp' => '/QtTestBrowser\/([0-9.]*)/'),
				array('name' => 'QtWeb', 				'regexp' => '/QtWeb Internet Browser\/([0-9.]*)/'),
				array('name' => 'QupZilla', 			'regexp' => '/QupZilla\/([0-9.]*)/', 'type' => TYPE_DESKTOP),
				array('name' => 'Roccat', 				'regexp' => '/Roccat\/([0-9]\.[0-9.]*)/'),
				array('name' => 'Raven for Mac', 		'regexp' => '/Raven for Mac\/([0-9.]*)/'),
				array('name' => 'rekonq', 				'regexp' => '/rekonq(?:\/([0-9.]*))?/', 'type' => TYPE_DESKTOP),
				array('name' => 'RockMelt', 			'regexp' => '/RockMelt\/([0-9.]*)/', 'details' => 2),
				array('name' => 'Sleipnir', 			'regexp' => '/Sleipnir\/([0-9.]*)/', 'details' => 3),
				array('name' => 'SMBrowser', 			'regexp' => '/SMBrowser/'),
				array('name' => 'Sogou Explorer', 		'regexp' => '/SE 2.X MetaSr/', 'type' => TYPE_DESKTOP),
				array('name' => 'Sogou Mobile',			'regexp' => '/SogouMobileBrowser\/([0-9.]*)/', 'details' => 2),
				array('name' => 'Snowshoe', 			'regexp' => '/Snowshoe\/([0-9.]*)/', 'details' => 2),
				array('name' => 'Sputnik', 				'regexp' => '/Sputnik\/([0-9.]*)/i', 'details' => 3),
				array('name' => 'Stainless', 			'regexp' => '/Stainless\/([0-9.]*)/'),
				array('name' => 'SunChrome', 			'regexp' => '/SunChrome\/([0-9.]*)/'),
				array('name' => 'Surf', 				'regexp' => '/Surf\/([0-9.]*)/'),
				array('name' => 'TaoBrowser', 			'regexp' => '/TaoBrowser\/([0-9.]*)/', 'details' => 2),
				array('name' => 'TaomeeBrowser', 		'regexp' => '/TaomeeBrowser\/([0-9.]*)/', 'details' => 2),
				array('name' => 'TazWeb', 				'regexp' => '/TazWeb/'),
				array('name' => 'Uzbl', 				'regexp' => '/^Uzbl/'),
				array('name' => 'Viera', 				'regexp' => '/Viera\/([0-9.]*)/'),
				array('name' => 'Villanova', 			'regexp' => '/Villanova\/([0-9.]*)/', 'details' => 3),
				array('name' => 'Wavelink Velocity',	'regexp' => '/Wavelink Velocity Browser\/([0-9.]*)/', 'details' => 2),
				array('name' => 'WebPositive', 			'regexp' => '/WebPositive/'),
				array('name' => 'WebRender', 			'regexp' => '/WebRender/'),
				array('name' => 'Webster', 				'regexp' => '/Webster ([0-9.]*)/'),
				array('name' => 'Wyzo', 				'regexp' => '/Wyzo\/([0-9.]*)/', 'details' => 3),
				array('name' => 'Yandex Browser', 		'regexp' => '/YaBrowser\/([0-9.]*)/', 'details' => 2),
				array('name' => 'YRC Weblink', 			'regexp' => '/YRCWeblink\/([0-9.]*)/'),
				array('name' => 'Zetakey', 				'regexp' => '/Zetakey Webkit\/([0-9.]*)/'),
				array('name' => 'Zetakey', 				'regexp' => '/Zetakey\/([0-9.]*)/'),
				
				array('name' => 'McAfee Web Gateway', 	'regexp' => '/Webwasher\/([0-9.]*)/'),
				
				array('name' => 'Open Sankoré', 		'regexp' => '/Open-Sankore\/([0-9.]*)/', 'type' => TYPE_WHITEBOARD),
				array('name' => 'Coship MMCP', 			'regexp' => '/Coship_MMCP_([0-9.]*)/', 'type' => TYPE_SIGNAGE),
				
				array('name' => '80legs', 				'regexp' => '/008\/([0-9.]*)/', 'type' => TYPE_BOT),
				array('name' => 'Ask Jeeves', 			'regexp' => '/Ask Jeeves\/Teoma/', 'type' => TYPE_BOT),
				array('name' => 'Baiduspider', 			'regexp' => '/Baiduspider\/([0-9.]*)/', 'type' => TYPE_BOT),
				array('name' => 'Bloglines', 			'regexp' => '/Bloglines\/([0-9.]*)/', 'type' => TYPE_BOT),
				array('name' => 'Googlebot', 			'regexp' => '/Googlebot\/([0-9.]*)/', 'type' => TYPE_BOT),
				array('name' => 'Google Web Preview',	'regexp' => '/Google Web Preview/', 'type' => TYPE_BOT),
				array('name' => 'Google Font Analysis', 'regexp' => '/Google-FontAnalysis\/([0-9.]*)/', 'type' => TYPE_BOT),
				array('name' => 'HeartRails Capture', 	'regexp' => '/HeartRails_Capture\/([0-9.]*)/', 'type' => TYPE_BOT),
				array('name' => 'Wget', 				'regexp' => '/Wget\/([0-9.]*)/', 'type' => TYPE_BOT)
			);

			for ($b = 0; $b < count($browsers); $b++) {
				if (preg_match($browsers[$b]['regexp'], $ua, $match)) {
					$this->browser->name = $browsers[$b]['name'];
					$this->browser->channel = '';
					$this->browser->stock = false;

					if (isset($match[1]) && $match[1]) {
						$this->browser->version = new Version(array('value' => $match[1], 'details' => isset($browsers[$b]['details']) ? $browsers[$b]['details'] : null));
					} else {
						$this->browser->version = null;
					}
					
					if (isset($browsers[$b]['type']) && $this->device->type == '') {
						$this->device->type = $browsers[$b]['type'];
					}
				}
			}


			/****************************************************
			 *		WebKit
			 */
	
			if (preg_match('/WebKit\/([0-9.]*)/i', $ua, $match)) {
				$this->engine->name = 'Webkit';
				$this->engine->version = new Version(array('value' => $match[1]));

				if (preg_match('/(?:Chrome|Chromium)\/([0-9]*)/', $ua, $match)) {
					if (intval($match[1]) >= 27) {
						$this->engine->name = 'Blink';
					}
				}
			}

			if (preg_match('/Browser\/AppleWebKit([0-9.]*)/i', $ua, $match)) {
				$this->engine->name = 'Webkit';
				$this->engine->version = new Version(array('value' => $match[1]));
			}

			/****************************************************
			 *		KHTML
			 */
		
			if (preg_match('/KHTML\/([0-9.]*)/', $ua, $match)) {
				$this->engine->name = 'KHTML';
				$this->engine->version = new Version(array('value' => $match[1]));
			}

			/****************************************************
			 *		Gecko
			 */
		
			if (preg_match('/Gecko/', $ua) && !preg_match('/like Gecko/', $ua)) {
				$this->engine->name = 'Gecko';

				if (preg_match('/; rv:([^\)]+)\)/', $ua, $match)) {
					$this->engine->version = new Version(array('value' => $match[1]));
				}
			}

			/****************************************************
			 *		Presto
			 */
		
			if (preg_match('/Presto\/([0-9.]*)/', $ua, $match)) {
				$this->engine->name = 'Presto';
				$this->engine->version = new Version(array('value' => $match[1]));
			}

			/****************************************************
			 *		Trident
			 */
		
			if (preg_match('/Trident\/([0-9.]*)/', $ua, $match)) {
				$this->engine->name = 'Trident';
				$this->engine->version = new Version(array('value' => $match[1]));

				
				if ($this->browser->name == 'Internet Explorer') {
					if ($this->engine->version->toNumber() == 7 && $this->browser->version->toFloat() < 11) {
						$this->browser->version = new Version(array('value' => '11.0'));
						$this->browser->mode = 'compat';
					}

					if ($this->engine->version->toNumber() == 6 && $this->browser->version->toFloat() < 10) {
						$this->browser->version = new Version(array('value' => '10.0'));
						$this->browser->mode = 'compat';
					}

					if ($this->engine->version->toNumber() == 5 && $this->browser->version->toFloat() < 9) {
						$this->browser->version = new Version(array('value' => '9.0'));
						$this->browser->mode = 'compat';
					}

					if ($this->engine->version->toNumber() == 4 && $this->browser->version->toFloat() < 8) {
						$this->browser->version = new Version(array('value' => '8.0'));
						$this->browser->mode = 'compat';
					}
				}

				if ($this->os->name == 'Windows Phone') {
					if ($this->engine->version->toNumber() == 6 && $this->browser->version->toFloat() < 8) {
						$this->os->version = new Version(array('value' => '8.0'));
					}

					if ($this->engine->version->toNumber() == 5 && $this->browser->version->toFloat() < 7.5) {
						$this->os->version = new Version(array('value' => '7.5'));
					}
				}
			}
			

			/****************************************************
			 *		Corrections
			 */
		
			if (isset($this->os->name)) {
				if ($this->os->name == 'Android' && $this->browser->stock) {
					$this->browser->hidden = true;
				}
	
				if ($this->os->name == 'Aliyun OS' && $this->browser->stock) {
					$this->browser->hidden = true;
				}
			}

			if (isset($this->os->name) && isset($this->browser->name)) {
				if ($this->os->name == 'iOS' && $this->browser->name == 'Opera Mini') {
					$this->os->version = null;
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
				
			
			if (isset($this->browser->name) && $this->browser->name == 'Opera' && $this->device->type == TYPE_TELEVISION) {
				$this->browser->name = 'Opera Devices';
				
				if (preg_match('/Presto\/([0-9]+\.[0-9]+)/', $ua, $match)) {
					switch($match[1]) {
						case '2.12':		$this->browser->version = new Version(array('value' => '3.4')); break;
						case '2.11':		$this->browser->version = new Version(array('value' => '3.3')); break;
						case '2.10':		$this->browser->version = new Version(array('value' => '3.2')); break;
						case '2.9':			$this->browser->version = new Version(array('value' => '3.1')); break;
						case '2.8':			$this->browser->version = new Version(array('value' => '3.0')); break;
						case '2.7':			$this->browser->version = new Version(array('value' => '2.9')); break;
						case '2.6':			$this->browser->version = new Version(array('value' => '2.8')); break;
						case '2.4':			$this->browser->version = new Version(array('value' => '10.3')); break;
						case '2.3':			$this->browser->version = new Version(array('value' => '10')); break;
						case '2.2':			$this->browser->version = new Version(array('value' => '9.7')); break;
						case '2.1':			$this->browser->version = new Version(array('value' => '9.6')); break;
						default:			unset($this->browser->version);
					}
				}
				
				unset($this->os->name);
				unset($this->os->version);
			}
			
			if (isset($this->browser->name)) {
				if ($this->browser->name == 'UC Browser') {
					if ($this->device->type == 'desktop' || (isset($this->os->name) && ($this->os->name == 'Windows' || $this->os->name == 'Mac OS X'))) {
						$this->device->type = TYPE_MOBILE;
						
						$this->browser->mode = 'desktop';
						
						unset($this->engine->name);
						unset($this->engine->version);
						unset($this->os->name);
						unset($this->os->version);
					}
				
					else if (!isset($this->os->name) || ($this->os->name != 'iOS' && $this->os->name != 'Android' && $this->os->name != 'Aliyun OS')) {
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
			
			if (isset($this->device->flag) && $this->device->flag == FLAG_GOOGLETV) {
				$this->os->name = 'Google TV';

				unset($this->os->version);	
				unset($this->device->flag);			
			}

			if (!$this->device->identified && isset($this->device->model)) {
				if (preg_match('/^[a-z][a-z]-[a-z][a-z]$/', $this->device->model)) {
					$this->device->model = null;
				}
			}
			
			
			/* If we have a Mozilla browser and not engine or other browser name, it could be the original */
			if (preg_match('/Mozilla/', $ua) && !isset($this->browser->name) && !isset($this->engine->name)) {
				$this->browser->name = 'Netscape';

				if (preg_match('/Mozilla\/([0-9.]*)/i', $ua, $match)) {
					$this->browser->version = new Version(array('value' => $match[1]));
				}
			}
			
			
			
			if (isset($this->os->name) && $this->os->name == 'Android') {
				if (!isset($this->os->version) || $this->os->version == null || $this->os->version->value == null) {
					if (preg_match('/Build\/([^\);]+)/', $ua, $match)) {
						$version = BuildIds::identify('android', $match[1]);
						
						if ($version) {
							$this->os->version = $version;
						}
					}
				}
			}
			
		}
		
		function toJavaScript() {
			if (isset($this->browser)) {
				echo "\t\t\tthis.browser = { ";
				echo $this->toJavaScriptObject($this->browser);
				echo " };\n";
			}
			
			if (isset($this->engine)) {
				echo "\t\t\tthis.engine = { ";
				echo $this->toJavaScriptObject($this->engine);
				echo " };\n";
			}
			
			if (isset($this->os)) {
				echo "\t\t\tthis.os = { ";
				echo $this->toJavaScriptObject($this->os);
				echo " };\n";
			}
			
			if (isset($this->device)) {
				echo "\t\t\tthis.device = { ";
				echo $this->toJavaScriptObject($this->device);
				echo " };\n";
			}	
		}
		
		function toJavaScriptObject($object) {
			$lines = array();

			foreach ((array)$object as $key => $value) {
				if (!is_null($value)) {
					$line = $key . ": ";
					
					if ($key == 'version') {
						$line .= 'new Version({ ' . $this->toJavaScriptObject($value) . ' })';
					} else {
						switch(gettype($value)) {
							case 'boolean':		$line .= $value ? 'true' : 'false'; break;
							case 'string':		$line .= '"' . addslashes($value) . '"'; break;
							case 'integer':		$line .= $value; break;
						}
					}
					
					$lines[] = $line;
				}
			}
			
			return implode($lines, ", ");
		}
	}
	
