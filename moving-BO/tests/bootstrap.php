<?php
//putenv('ZF2=../../../vendor/zendframework/zendframework/library');

chdir(dirname(__DIR__));

$autoloader = include __DIR__ . '/../vendor/autoload.php';
include __DIR__ . '/../init_autoloader.php';
/*
$config = array(
		'modules' => array(
				'ZendDeveloperTools',
				'DoctrineModule',
				'DoctrineORMModule',
				'BjyAuthorize',
				'ZfcBase',
				'ZfcUser',
				'ZfcUserDoctrineORM',
				'DoctrineDataFixtureModule',
				'AssetManager',
				'Application',
				'Album',
				'Core',
				'DataTable'
		),
		'module_listener_options' => array(
				'module_paths' => array(
						'./module',
						'./vendor'
				),
				'config_glob_paths' => array('config/autoload/{,*.}{global,local}.php')
		)
);*/


require_once __DIR__ . '/library/Phpunit/Doctrine.php';
$loader = new Zend\Loader\StandardAutoloader();
$loader->registerNamespace('TestsCervin', realpath('tests/library/Phpunit'));
$loader->register();


return Zend\Mvc\Application::init(include __DIR__ . '/../config/application.config.php');
//return Zend\Mvc\Application::init($config);
