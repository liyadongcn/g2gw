<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
    'name' => '官网购',
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
    	'authClientCollection' => [
    		'class' => 'yii\authclient\Collection',
    		'clients' => [
    				'qq' => [
    						'class' => 'xj\oauth\QqAuth',
    						'clientId'=>'101241136',
    						'clientSecret'=>'60b542692faa77ab0e1891f5b6ed1047',
    				],
    				'sina' => [
    						'class' => 'xj\oauth\WeiboAuth',
    						'clientId' => '126537379',
    						'clientSecret' => '75baab3dafcc172737b4ce55d8ea0e20',
    				],
    				'weixin' => [
    						'class' => 'xj\oauth\WeixinAuth',
    						'clientId' => '111',
    						'clientSecret' => '111',
    				],
    				'renren' => [
    						'class' => 'xj\oauth\RenrenAuth',
    						'clientId' => '111',
    						'clientSecret' => '111',
    				],
    				'github' => [
    						'class' => 'yii\authclient\clients\GitHub',
    						'clientId' => 'b3e84718412ea6ad69c8',
    						'clientSecret' => '2bca99bcb8e21b4614b6259c3de79a9d042a745e',
    				],
    				'google' => [
    						'class' => 'yii\authclient\clients\GoogleOpenId'
    				],
    		],
    	],
    ],
    'params' => $params,
];
