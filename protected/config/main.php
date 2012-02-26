<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Flow',

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
	),

	//'defaultController'=>'post',

	// application components
	'components'=>array(
		
		'urlManager'=>array(  
  			'urlFormat'=>'path',  
			'showScriptName' => false,  
		),
	
	
		// uncomment the following to use a MySQL database
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=flow',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '',
			'charset' => 'utf8',
		),
	),

);