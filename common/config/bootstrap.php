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

require('solr_config.php');

//require (__DIR__ . '/../../common/solr/bootstrap.php');