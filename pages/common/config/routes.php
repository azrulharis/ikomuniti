<?php

$router = new \Phalcon\Mvc\Router();

//Remove trailing slashes automatically
$router->removeExtraSlashes(true);
//Set 404 paths
$router->notFound(array(
    'module' => 'frontend',
	'namespace' => 'JunMy\Frontend\Controllers\\',
	'controller' => 'index',
	'action' => 'index'
));
 
/**
 * Frontend routes
 */
$router->add('/', array(
	'module' => 'frontend',
	'namespace' => 'JunMy\Frontend\Controllers\\',
	'controller' => 'index',
	'action' => 'index'
));



$router->add('/index', array(
	'module' => 'frontend',
	'namespace' => 'JunMy\Frontend\Controllers\\',
	'controller' => 'index',
	'action' => 'index'
));
 

$router->add('/index/', array(
	'module' => 'frontend',
	'namespace' => 'JunMy\Frontend\Controllers\\',
	'controller' => 'index',
	'action' => 'index'
));

$router->add('/register', array(
	'module' => 'frontend',
	'namespace' => 'JunMy\Frontend\Controllers\\',
	'controller' => 'users',
	'action' => 'register'
)); 

$router->add('/success/{id}/{param}/{ref}', array(
	'module' => 'frontend',
	'namespace' => 'JunMy\Frontend\Controllers\\',
	'controller' => 'users',
	'action' => 'success'
)); 

$router->add('/ireseller', array(
	'module' => 'frontend',
	'namespace' => 'JunMy\Frontend\Controllers\\',
	'controller' => 'ireseller',
	'action' => 'index'
));

$router->add('/ioffer', array(
	'module' => 'frontend',
	'namespace' => 'JunMy\Frontend\Controllers\\',
	'controller' => 'ioffer',
	'action' => 'index'
));

$router->add('/ioffer/view/{slug}', array(
	'module' => 'frontend',
	'namespace' => 'JunMy\Frontend\Controllers\\',
	'controller' => 'ioffer',
	'action' => 'view'
));

$router->add('/ipartner', array(
	'module' => 'frontend',
	'namespace' => 'JunMy\Frontend\Controllers\\',
	'controller' => 'ipartner',
	'action' => 'index'
));

$router->add('/ipartner/view/{slug}', array(
	'module' => 'frontend',
	'namespace' => 'JunMy\Frontend\Controllers\\',
	'controller' => 'ipartner',
	'action' => 'view'
));

$router->add('/iprihatin', array(
	'module' => 'frontend',
	'namespace' => 'JunMy\Frontend\Controllers\\',
	'controller' => 'iprihatin',
	'action' => 'index'
));

$router->add('/iprihatin/view/{slug}', array(
	'module' => 'frontend',
	'namespace' => 'JunMy\Frontend\Controllers\\',
	'controller' => 'iprihatin',
	'action' => 'view'
));
 
$router->add('/ajax/ajaxusername', array(
	'module' => 'frontend',
	'namespace' => 'JunMy\Frontend\Controllers\\',
	'controller' => 'ajax',
	'action' => 'ajaxusername',
));

$router->add('/ajax/sponsorusername', array(
	'module' => 'frontend',
	'namespace' => 'JunMy\Frontend\Controllers\\',
	'controller' => 'ajax',
	'action' => 'sponsorusername',
)); 

$router->add('/ajax/ajaxioffer', array(
	'module' => 'frontend',
	'namespace' => 'JunMy\Frontend\Controllers\\',
	'controller' => 'ajax',
	'action' => 'ajaxioffer',
));
 
$router->add('/igaleri', array(
	'module' => 'frontend',
	'namespace' => 'JunMy\Frontend\Controllers\\',
	'controller' => 'igaleri',
	'action' => 'index',
));

 
/*
$router->add('/play/{id:[0-9]+}', array(
	'module' => 'frontend',
	'namespace' => 'JunMy\Frontend\Controllers\\',
	'controller' => 'catalog',
	'action' => 'play',
));

$router->add('/tag/{name}', array(
	'module' => 'frontend',
	'namespace' => 'JunMy\Frontend\Controllers\\',
	'controller' => 'catalog',
	'action' => 'tag'
));

$router->add('/tag/{name}/{page:[0-9]+}', array(
	'module' => 'frontend',
	'namespace' => 'JunMy\Frontend\Controllers\\',
	'controller' => 'catalog',
	'action' => 'tag'
));

$router->add('/search(/?)', array(
	'module' => 'frontend',
	'namespace' => 'JunMy\Frontend\Controllers\\',
	'controller' => 'catalog',
	'action' => 'search'
));

$router->add('/popular', array(
	'module' => 'frontend',
	'namespace' => 'JunMy\Frontend\Controllers\\',
	'controller' => 'catalog',
	'action' => 'popular'
));
*/ 

/**
 * Backend routes
 */

return $router;
