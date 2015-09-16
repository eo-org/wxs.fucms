<?php
return array(
	'env' => array(
		'usage' => array(
			'server' => 'production',
		),
		'base_path' => '/var/www',
		'account_fucms_db' => array(
			'host' => '127.0.0.1',
			'username' => 'craftgavin',
			'password' => 'whothirstformagic?',
			'db' => 'admin'
		),
		'path' => array(
			'fucms'		=> 'http://qs-lib.fucms.com/fucms',
			'src'		=> 'http://qs-lib.fucms.com/src',
			'compact'	=> 'http://qs-lib.fucms.com/compact',
			'wxs.fucms' => 'http://qs-lib.fucms.com/wxs.fucms',
			'qiniu'		=> 'http://7fvjw0.com1.z0.glb.clouddn.com',
		),
		'wx' => array(
			'appId' => 'wx2ce4babba45b702d',
			'appSecret' => '0c79e1fa963cd80cc0be99b20a18faeb',
			'token' => 'fucmsweb2015weixinopen888',
			'encryptKey' => 'MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCqco4',
			'path' => array(
				'redirectUri' => 'http://wx.fucmsweb.com/auth',
				'accessToken' => 'https://api.weixin.qq.com/cgi-bin/component/api_component_token',
				'preAuthCode' => 'https://api.weixin.qq.com/cgi-bin/component/api_create_preauthcode?component_access_token=',				
				'authInfo' => 'https://api.weixin.qq.com/cgi-bin/component/api_query_auth?component_access_token=',
			),
		),
		
		
		
		
		
		
		// developer qiniu key and bucket
		'qiniu' => array(
			'keyId' => 'xo6Ap0TOfDWSNQtSYCdeb4nSg-1oilUgJ4i27GsK',
			'keySecret' => 'K2j2Vq9uizQcjemFkRBTOlTAQ5v1rkZYnVaXWyog',
			'bucket' => 'en-developer'
		),
	),
	'account_fucms_db' => array(
		'host'		=> '127.0.0.1',
		'username'	=> 'craftgavin',
		'password'	=> 'whothirstformagic?'
	),
);