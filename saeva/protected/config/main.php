<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'SAEVA',
        'language'=>'es',
    
        //'defaultController'=>'site/login',

        'aliases'=>array(
            'bootstrap'=> realpath(__DIR__.'/../extensions/yiibooster'),        
        ),


        

	// preloading 'log' component
	'preload'=>array('log','bootstrap'),
        'theme'=>'heart',

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'ext.edropdownsdependents.*',
		'ext.cascadedropdown.ECascadeDropDown',
		'application.modules.user.models.*',
        'application.modules.user.components.*',
	),

	'modules'=>array(
		'admin',
		// uncomment the following to enable the Gii tool
		'user'=>array(
		
	    	),

		'backup,'=> array(
        	'path' =>'/../_backup',  
   			 ),


		'jbackup'=>array(
                    'path' => __DIR__.'/../_backup/', //Directory where backups are saved
                    'layout' => '//layouts/_column2', //2-column layout to display the options
                    'filter' => 'accessControl', //filter or filters to the controller
                    'bootstrap' => true, //if you want the module use bootstrap components
                    'download' => true, // if you want the option to download
                    'restore' => true, // if you want the option to restore
                    'database' => true, //whether to make backup of the database or not
                    //directory to consider for backup, must be made array key => value array ($ alias => $ directory)
                    'directoryBackup'=>array( 
                       'folder/'=> __DIR__.'/../../folder/',
                    ),
                    //directory sebe not take into account when the backup
                    'excludeDirectoryBackup'=>array(
                       __DIR__.'/../../folder/folder2/',
                    ),
                    //files sebe not take into account when the backup
                    'excludeFileBackup'=>array(
                       __DIR__.'/../../folder/folder1/cfile.png',
                    ),
                    //directory where the backup should be done default Yii::getPathOfAlias('webroot')
                    'directoryRestoreBackup'=>__DIR__.'/../../' 
                 ),
		
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'c0lm4y0r',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
                        'generatorPaths'=>array('ext.heart.gii'),
		),
		
	),

	// application components
	'components'=>array(
		'authManager'=>array(
			"class"=>"CDbAuthManager",
			"connectionID"=>"db",
			'assignmentTable'=>'authassignment',
            'itemChildTable'=>'authitemchild',
            'itemTable'=>'authitem',

		),
		
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
            'loginUrl' => array('site/login'),
		),

		// uncomment the following to enable URLs in path-format
		
		'urlManager'=>array(
			'urlFormat'=>'path',
            'showScriptName'=>false,
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
				//'caseSensitive' => true,

			),
		),

		'widgetFactory' => array(
		'widgets'=> array(
			'CGridView'=> array(
				'cssFile'=>false,
				'pager'=>array('cssFile'=>false),
				'PagerCssClass'=>'paginator'
			),
			'CListView'=> array(
				'cssFile'=>false,
				'pager'=>array('cssFile'=>false),
				'PagerCssClass'=>'paginator'
				),
			'CDetailView'=> array(
				'cssFile'=>false,
				),

			),
		),
		

		// database settings are configured in database.php
		'db'=>require(dirname(__FILE__).'/database.php'),

		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),

		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
                        
		),
                'bootstrap'=> array(
                            'class'=>'bootstrap.components.Bootstrap',
                            'fontAwesomeCss'=>true,
                            'minify'=>true,
                ),
                
                'themeManager'=>array(
                     'basePath'=>'protected/extensions',                     
                ),    

	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'webmaster@example.com',
	),


	
	);
