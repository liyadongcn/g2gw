<?php

define('ROOT_DIRECTORY', dirname(__FILE__));

define('EXAMPLE_RESPONSE_XML_1', ROOT_DIRECTORY . '/files/response_xml.1.xml');

define('DOCUMENT_RESPONSE_XML_1', ROOT_DIRECTORY . '/files/document.1.xml');

define('DOCUMENT_RESPONSE_XML_2', ROOT_DIRECTORY . '/files/document.2.xml');

/* Whether or not to run in secure mode */
define('SOLR_SECURE', false);

/* Domain name of the Solr server */
define('SOLR_SERVER_HOSTNAME', '114.250.152.168');

/* HTTP Port to connection */
define('SOLR_SERVER_PORT', ((SOLR_SECURE) ? 8443 : 8983));

/* HTTP Path to connection */
//define('SOLR_SERVER_PATH', '/solr/gettingstarted');
define('SOLR_SERVER_PATH', '/solr/collection1');

/* HTTP Basic Authentication Username */
define('SOLR_SERVER_USERNAME', '');

/* HTTP Basic Authentication password */
define('SOLR_SERVER_PASSWORD', '');

/* HTTP connection timeout */
/* This is maximum time in seconds allowed for the http data transfer operation. Default value is 30 seconds */
define('SOLR_SERVER_TIMEOUT', 10);

/* File name to a PEM-formatted private key + private certificate (concatenated in that order) */
define('SOLR_SSL_CERT', 'certs/combo.pem');

/* File name to a PEM-formatted private certificate only */
define('SOLR_SSL_CERT_ONLY', 'certs/solr.crt');

/* File name to a PEM-formatted private key */
define('SOLR_SSL_KEY', 'certs/solr.key');

/* Password for PEM-formatted private key file */
define('SOLR_SSL_KEYPASSWORD', 'StrongAndSecurePassword');

/* Name of file holding one or more CA certificates to verify peer with*/
define('SOLR_SSL_CAINFO', 'certs/cacert.crt');

/* Name of directory holding multiple CA certificates to verify peer with */
define('SOLR_SSL_CAPATH', 'certs/');

?>