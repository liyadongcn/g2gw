<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
    'name' => '去官网',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'language' => 'zh-CN', // <- here!
    'timeZone' => 'Asia/Chongqing',
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'user' => [
        	'class' =>'common\web\User',
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
    	'urlManager' => [
    		//'enablePrettyUrl' => true,
    		//'showScriptName' => false,    			
    		// create the .htaccess file in the web root directory
    	],
		'view' => [
			/* 'theme' => [
					'basePath' => '@app/themes/basic',
					'baseUrl' => '@web/themes/basic',
					'pathMap' => [
							'@app/views' => '@app/themes/basic',
					],
			], */
		],
    	'authClientCollection' => [
    		'class' => 'yii\authclient\Collection',
    		'clients' => [
    				'qq' => [
    						'class' => 'common\components\QQAuth',
    						'clientId'=>'101241136',
    						'clientSecret'=>'60b542692faa77ab0e1891f5b6ed1047',
    				],
    				'sina' => [
    						'class' => 'common\components\WeiboAuth',
    						'clientId' => '2482357588',
    						'clientSecret' => '88363d0008e462fdc71f58ad1949b607',
    				],
    				/*'weixin' => [
    						'class' => 'xj\oauth\WeixinAuth',
    						'clientId' => '111',
    						'clientSecret' => '111',
    				],
    				'renren' => [
    						'class' => 'xj\oauth\RenrenAuth',
    						'clientId' => '111',
    						'clientSecret' => '111',
    				],*/
    				'github' => [
    						'class' => 'common\components\GithubAuth',
    						'clientId' => 'b3e84718412ea6ad69c8',
    						'clientSecret' => '2bca99bcb8e21b4614b6259c3de79a9d042a745e',
    				],
    				/* 'google' => [
    						'class' => 'yii\authclient\clients\GoogleOpenId'
    				], */
    		],
    	],
    ],
    'params' => $params,
];
