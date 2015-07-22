<?php
Yii::setAlias('common', dirname(__DIR__));
Yii::setAlias('frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('backend', dirname(dirname(__DIR__)) . '/backend');
Yii::setAlias('console', dirname(dirname(__DIR__)) . '/console');

/* Model Type */
define('MODEL_TYPE_BRAND', 'brand');
define('MODEL_TYPE_GOODS', 'goods');
define('MODEL_TYPE_POSTS', 'posts');
define('MODEL_TYPE_SOLR', 'solr');
define('MODEL_TYPE_COMPANY', 'company');
define('MODEL_TYPE_COUNTRY', 'country');
define('MODEL_TYPE_CATEGORY', 'category');
define('MODEL_TYPE_COMMENT_STATUS', 'comment_status');
define('MODEL_TYPE_POSTS_STATUS', 'posts_status');

define('POST_STATUS_PUBLISH','publish');
define('POST_STATUS_DRAFT','draft');

define('COMMENT_STATUS_APPROVED','approved');//批准
define('COMMENT_STATUS_REFUSED','refused');//驳回
define('COMMENT_STATUS_SPAM','spam');//垃圾评论
define('COMMENT_STATUS_TRASH','trash');//移至回收站

define('COMMENT_STATUS_CLOSE','open');//不允许评论
define('COMMENT_STATUS_OPEN','close');//允许评论

define('DEFAULT_IMAGE',1);


require('solr_config.php');

//require (__DIR__ . '/../../common/solr/bootstrap.php');