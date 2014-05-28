<?php

$router = new \Phalcon\Mvc\Router();

//Remove trailing slashes automatically
$router->removeExtraSlashes(true);
/**
 * Frontend routes
 */
$router->add('/', array(
	'module' => 'frontend',
	'namespace' => 'JunMy\Frontend\Controllers\\',
	'controller' => 'index',
	'action' => 'index'
));

//Set 404 paths
$router->notFound(array(
    'module' => 'frontend',
	'namespace' => 'JunMy\Frontend\Controllers\\',
	'controller' => 'index',
	'action' => 'index'
));

$router->add('/index/index', array(
	'module' => 'frontend',
	'namespace' => 'JunMy\Frontend\Controllers\\',
	'controller' => 'index',
	'action' => 'index'
));

$router->add('/epins/index', array(
	'module' => 'frontend',
	'namespace' => 'JunMy\Frontend\Controllers\\',
	'controller' => 'epins',
	'action' => 'index'
));

$router->add('/epins/track', array(
	'module' => 'frontend',
	'namespace' => 'JunMy\Frontend\Controllers\\',
	'controller' => 'epins',
	'action' => 'track'
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

$router->add('/tree/index', array(
	'module' => 'frontend',
	'namespace' => 'JunMy\Frontend\Controllers\\',
	'controller' => 'tree',
	'action' => 'index',
));

$router->add('/tree/first', array(
	'module' => 'frontend',
	'namespace' => 'JunMy\Frontend\Controllers\\',
	'controller' => 'tree',
	'action' => 'first',
));

$router->add('/tree/second', array(
	'module' => 'frontend',
	'namespace' => 'JunMy\Frontend\Controllers\\',
	'controller' => 'tree',
	'action' => 'second',
));

$router->add('/profile/{username}', array(
	'module' => 'frontend',
	'namespace' => 'JunMy\Frontend\Controllers\\',
	'controller' => 'profile',
	'action' => 'index',
));

/*
$router->add('/tree/third', array(
	'module' => 'frontend',
	'namespace' => 'JunMy\Frontend\Controllers\\',
	'controller' => 'tree',
	'action' => 'third',
));

$router->add('/tree/fourth', array(
	'module' => 'frontend',
	'namespace' => 'JunMy\Frontend\Controllers\\',
	'controller' => 'tree',
	'action' => 'fourth',
));

$router->add('/tree/view/{slug}', array(
	'module' => 'frontend',
	'namespace' => 'JunMy\Frontend\Controllers\\',
	'controller' => 'tree',
	'action' => 'view',
));*/
 

$router->add('/users/index', array(
	'module' => 'frontend',
	'namespace' => 'JunMy\Frontend\Controllers\\',
	'controller' => 'users',
	'action' => 'index',
));

$router->add('/users/logout', array(
	'module' => 'frontend',
	'namespace' => 'JunMy\Frontend\Controllers\\',
	'controller' => 'users',
	'action' => 'logout',
));

$router->add('/users/login', array(
	'module' => 'frontend',
	'namespace' => 'JunMy\Frontend\Controllers\\',
	'controller' => 'users',
	'action' => 'login',
));

$router->add('/users/forgotpassword', array(
	'module' => 'frontend',
	'namespace' => 'JunMy\Frontend\Controllers\\',
	'controller' => 'users',
	'action' => 'forgotpassword',
));

$router->add('/users/tacrequest/{slug}', array(
	'module' => 'frontend',
	'namespace' => 'JunMy\Frontend\Controllers\\',
	'controller' => 'users',
	'action' => 'tacrequest',
));

$router->add('/wallets/index', array(
	'module' => 'frontend',
	'namespace' => 'JunMy\Frontend\Controllers\\',
	'controller' => 'wallets',
	'action' => 'index',
));

$router->add('/wallets/add', array(
	'module' => 'frontend',
	'namespace' => 'JunMy\Frontend\Controllers\\',
	'controller' => 'wallets',
	'action' => 'add',
));

$router->add('/wallets/histories', array(
	'module' => 'frontend',
	'namespace' => 'JunMy\Frontend\Controllers\\',
	'controller' => 'wallets',
	'action' => 'histories',
));

$router->add('/wallets/redeem', array(
	'module' => 'frontend',
	'namespace' => 'JunMy\Frontend\Controllers\\',
	'controller' => 'wallets',
	'action' => 'redeem',
));

$router->add('/wallets/transfer', array(
	'module' => 'frontend',
	'namespace' => 'JunMy\Frontend\Controllers\\',
	'controller' => 'wallets',
	'action' => 'transfer',
));

$router->add('/wallets/steptwo', array(
	'module' => 'frontend',
	'namespace' => 'JunMy\Frontend\Controllers\\',
	'controller' => 'wallets',
	'action' => 'steptwo',
));

$router->add('/wallets/status', array(
	'module' => 'frontend',
	'namespace' => 'JunMy\Frontend\Controllers\\',
	'controller' => 'wallets',
	'action' => 'status',
));

$router->add('/ipoint/index', array(
	'module' => 'frontend',
	'namespace' => 'JunMy\Frontend\Controllers\\',
	'controller' => 'ipoint',
	'action' => 'index',
));

$router->add('/settings/profile', array(
	'module' => 'frontend',
	'namespace' => 'JunMy\Frontend\Controllers\\',
	'controller' => 'settings',
	'action' => 'profile',
));

$router->add('/settings/edit', array(
	'module' => 'frontend',
	'namespace' => 'JunMy\Frontend\Controllers\\',
	'controller' => 'settings',
	'action' => 'edit',
));

$router->add('/activations/index', array(
	'module' => 'frontend',
	'namespace' => 'JunMy\Frontend\Controllers\\',
	'controller' => 'activations',
	'action' => 'index',
));

$router->add('/activations/all', array(
	'module' => 'frontend',
	'namespace' => 'JunMy\Frontend\Controllers\\',
	'controller' => 'activations',
	'action' => 'all',
));

$router->add('/activations/problems', array(
	'module' => 'frontend',
	'namespace' => 'JunMy\Frontend\Controllers\\',
	'controller' => 'activations',
	'action' => 'problems',
));

$router->add('/activations/profile/{slug}', array(
	'module' => 'frontend',
	'namespace' => 'JunMy\Frontend\Controllers\\',
	'controller' => 'activations',
	'action' => 'profile',
));

$router->add('/messages/index', array(
	'module' => 'frontend',
	'namespace' => 'JunMy\Frontend\Controllers\\',
	'controller' => 'messages',
	'action' => 'index',
));

$router->add('/messages/sentitems', array(
	'module' => 'frontend',
	'namespace' => 'JunMy\Frontend\Controllers\\',
	'controller' => 'messages',
	'action' => 'sentitems',
));

$router->add('/messages/view/{id:[0-9]+}', array(
	'module' => 'frontend',
	'namespace' => 'JunMy\Frontend\Controllers\\',
	'controller' => 'messages',
	'action' => 'view',
));

$router->add('/messages/compose', array(
	'module' => 'frontend',
	'namespace' => 'JunMy\Frontend\Controllers\\',
	'controller' => 'messages',
	'action' => 'compose',
));

$router->add('/imall/index', array(
	'module' => 'frontend',
	'namespace' => 'JunMy\Frontend\Controllers\\',
	'controller' => 'imall',
	'action' => 'index',
));

$router->add('/imall/myads', array(
	'module' => 'frontend',
	'namespace' => 'JunMy\Frontend\Controllers\\',
	'controller' => 'imall',
	'action' => 'myads',
));

$router->add('/imall/add', array(
	'module' => 'frontend',
	'namespace' => 'JunMy\Frontend\Controllers\\',
	'controller' => 'imall',
	'action' => 'add',
));

$router->add('/imall/steptwo', array(
	'module' => 'frontend',
	'namespace' => 'JunMy\Frontend\Controllers\\',
	'controller' => 'imall',
	'action' => 'steptwo',
));

$router->add('/imall/stepthree/{slug}', array(
	'module' => 'frontend',
	'namespace' => 'JunMy\Frontend\Controllers\\',
	'controller' => 'imall',
	'action' => 'stepthree',
));

$router->add('/imall/finish/{slug}', array(
	'module' => 'frontend',
	'namespace' => 'JunMy\Frontend\Controllers\\',
	'controller' => 'imall',
	'action' => 'finish',
));

$router->add('/imall/view/{slug}', array(
	'module' => 'frontend',
	'namespace' => 'JunMy\Frontend\Controllers\\',
	'controller' => 'imall',
	'action' => 'view',
));

$router->add('/ajax/ajaximall', array(
	'module' => 'frontend',
	'namespace' => 'JunMy\Frontend\Controllers\\',
	'controller' => 'ajax',
	'action' => 'ajaximall',
));

$router->add('/ajax/ajaxupload', array(
	'module' => 'frontend',
	'namespace' => 'JunMy\Frontend\Controllers\\',
	'controller' => 'ajax',
	'action' => 'ajaxupload',
));

$router->add('/ajax/ajaxuploadprofile', array(
	'module' => 'frontend',
	'namespace' => 'JunMy\Frontend\Controllers\\',
	'controller' => 'ajax',
	'action' => 'ajaxuploadprofile',
));

$router->add('/ajax/ajaxreply', array(
	'module' => 'frontend',
	'namespace' => 'JunMy\Frontend\Controllers\\',
	'controller' => 'ajax',
	'action' => 'ajaxreply',
));

$router->add('/ajax/ajaxaddtocart', array(
	'module' => 'frontend',
	'namespace' => 'JunMy\Frontend\Controllers\\',
	'controller' => 'ajax',
	'action' => 'ajaxaddtocart',
));

$router->add('/ajax/ajaxioffer', array(
	'module' => 'frontend',
	'namespace' => 'JunMy\Frontend\Controllers\\',
	'controller' => 'ajax',
	'action' => 'ajaxioffer',
));

$router->add('/imall/edit/{slug}', array(
	'module' => 'frontend',
	'namespace' => 'JunMy\Frontend\Controllers\\',
	'controller' => 'imall',
	'action' => 'edit',
));

$router->add('/epins/transfer', array(
	'module' => 'frontend',
	'namespace' => 'JunMy\Frontend\Controllers\\',
	'controller' => 'epins',
	'action' => 'transfer',
));

$router->add('/epins/confirmation', array(
	'module' => 'frontend',
	'namespace' => 'JunMy\Frontend\Controllers\\',
	'controller' => 'epins',
	'action' => 'confirmation',
));

$router->add('/graph/username', array(
	'module' => 'frontend',
	'namespace' => 'JunMy\Frontend\Controllers\\',
	'controller' => 'graph',
	'action' => 'username',
));

$router->add('/iprihatin/index', array(
	'module' => 'frontend',
	'namespace' => 'JunMy\Frontend\Controllers\\',
	'controller' => 'iprihatin',
	'action' => 'index',
));

$router->add('/iprihatin/view/{slug}', array(
	'module' => 'frontend',
	'namespace' => 'JunMy\Frontend\Controllers\\',
	'controller' => 'iprihatin',
	'action' => 'view',
));

$router->add('/ajax/ajaxuserid', array(
	'module' => 'frontend',
	'namespace' => 'JunMy\Frontend\Controllers\\',
	'controller' => 'ajax',
	'action' => 'ajaxuserid',
));


$router->add('/ajax/ajaxusername', array(
	'module' => 'frontend',
	'namespace' => 'JunMy\Frontend\Controllers\\',
	'controller' => 'ajax',
	'action' => 'ajaxusername',
));

$router->add('/ajax/ajaxcategory', array(
	'module' => 'frontend',
	'namespace' => 'JunMy\Frontend\Controllers\\',
	'controller' => 'ajax',
	'action' => 'ajaxcategory',
));
 
$router->add('/find', array(
	'module' => 'frontend',
	'namespace' => 'JunMy\Frontend\Controllers\\',
	'controller' => 'find',
	'action' => 'index'
));

$router->add('/itakaful/index', array(
	'module' => 'frontend',
	'namespace' => 'JunMy\Frontend\Controllers\\',
	'controller' => 'itakaful',
	'action' => 'index'
));

$router->add('/news/index', array(
	'module' => 'frontend',
	'namespace' => 'JunMy\Frontend\Controllers\\',
	'controller' => 'news',
	'action' => 'index'
)); 

$router->add('/news/view/{slug}', array(
	'module' => 'frontend',
	'namespace' => 'JunMy\Frontend\Controllers\\',
	'controller' => 'news',
	'action' => 'view'
)); 

$router->add('/settings/personal', array(
	'module' => 'frontend',
	'namespace' => 'JunMy\Frontend\Controllers\\',
	'controller' => 'settings',
	'action' => 'personal'
)); 

$router->add('/settings/vehicle', array(
	'module' => 'frontend',
	'namespace' => 'JunMy\Frontend\Controllers\\',
	'controller' => 'settings',
	'action' => 'vehicle'
)); 

$router->add('/settings/account', array(
	'module' => 'frontend',
	'namespace' => 'JunMy\Frontend\Controllers\\',
	'controller' => 'settings',
	'action' => 'account'
)); 

$router->add('/notifications/index', array(
	'module' => 'frontend',
	'namespace' => 'JunMy\Frontend\Controllers\\',
	'controller' => 'notifications',
	'action' => 'index'
)); 

$router->add('/notifications/view/{slug}', array(
	'module' => 'frontend',
	'namespace' => 'JunMy\Frontend\Controllers\\',
	'controller' => 'notifications',
	'action' => 'view'
));

$router->add('/ipartner/index', array(
	'module' => 'frontend',
	'namespace' => 'JunMy\Frontend\Controllers\\',
	'controller' => 'ipartner',
	'action' => 'index'
));

$router->add('/ipartner/add', array(
	'module' => 'frontend',
	'namespace' => 'JunMy\Frontend\Controllers\\',
	'controller' => 'ipartner',
	'action' => 'add'
));

$router->add('/ipartner/myads', array(
	'module' => 'frontend',
	'namespace' => 'JunMy\Frontend\Controllers\\',
	'controller' => 'ipartner',
	'action' => 'myads'
));

$router->add('/ipartner/steptwo', array(
	'module' => 'frontend',
	'namespace' => 'JunMy\Frontend\Controllers\\',
	'controller' => 'ipartner',
	'action' => 'steptwo'
));

$router->add('/ipartner/finish/{slug}', array(
	'module' => 'frontend',
	'namespace' => 'JunMy\Frontend\Controllers\\',
	'controller' => 'ipartner',
	'action' => 'finish'
));

$router->add('/ipartner/view/{slug}', array(
	'module' => 'frontend',
	'namespace' => 'JunMy\Frontend\Controllers\\',
	'controller' => 'ipartner',
	'action' => 'view'
));


$router->add('/isahabat/index', array(
	'module' => 'frontend',
	'namespace' => 'JunMy\Frontend\Controllers\\',
	'controller' => 'isahabat',
	'action' => 'index'
));

$router->add('/isahabat/upgrade', array(
	'module' => 'frontend',
	'namespace' => 'JunMy\Frontend\Controllers\\',
	'controller' => 'isahabat',
	'action' => 'upgrade'
));

$router->add('/ioffer/index', array(
	'module' => 'frontend',
	'namespace' => 'JunMy\Frontend\Controllers\\',
	'controller' => 'ioffer',
	'action' => 'index'
));

$router->add('/ioffer/viewcart', array(
	'module' => 'frontend',
	'namespace' => 'JunMy\Frontend\Controllers\\',
	'controller' => 'ioffer',
	'action' => 'viewcart'
));

$router->add('/ioffer/checkout', array(
	'module' => 'frontend',
	'namespace' => 'JunMy\Frontend\Controllers\\',
	'controller' => 'ioffer',
	'action' => 'checkout'
));

$router->add('/ioffer/verification/{id}', array(
	'module' => 'frontend',
	'namespace' => 'JunMy\Frontend\Controllers\\',
	'controller' => 'ioffer',
	'action' => 'verification'
));

$router->add('/ioffer/view/{slug}', array(
	'module' => 'frontend',
	'namespace' => 'JunMy\Frontend\Controllers\\',
	'controller' => 'ioffer',
	'action' => 'view'
));

$router->add('/payment/ioffer/{id}', array(
	'module' => 'frontend',
	'namespace' => 'JunMy\Frontend\Controllers\\',
	'controller' => 'payment',
	'action' => 'ioffer'
));

$router->add('/payment/ipoint', array(
	'module' => 'frontend',
	'namespace' => 'JunMy\Frontend\Controllers\\',
	'controller' => 'payment',
	'action' => 'ipoint'
));

$router->add('/payment/success', array(
	'module' => 'frontend',
	'namespace' => 'JunMy\Frontend\Controllers\\',
	'controller' => 'payment',
	'action' => 'success'
));

$router->add('/itools/index', array(
	'module' => 'frontend',
	'namespace' => 'JunMy\Frontend\Controllers\\',
	'controller' => 'itools',
	'action' => 'index'
));

$router->add('/itools/view', array(
	'module' => 'frontend',
	'namespace' => 'JunMy\Frontend\Controllers\\',
	'controller' => 'itools',
	'action' => 'view'
));

$router->add('/itools/graph', array(
	'module' => 'frontend',
	'namespace' => 'JunMy\Frontend\Controllers\\',
	'controller' => 'itools',
	'action' => 'graph'
));

$router->add('/itools/graphisahabat', array(
	'module' => 'frontend',
	'namespace' => 'JunMy\Frontend\Controllers\\',
	'controller' => 'itools',
	'action' => 'graphisahabat'
));

$router->add('/itools/graphikomuniti', array(
	'module' => 'frontend',
	'namespace' => 'JunMy\Frontend\Controllers\\',
	'controller' => 'itools',
	'action' => 'graphikomuniti'
));

/**
 * Backend routes
 */
 

$router->add('/gghadmin', array(
	'module' => 'admin',
	'namespace' => 'JunMy\Admin\Controllers\\',
	'controller' => 'index',
	'action' => 'index'
));

$router->add('/gghadmin/index', array(
	'module' => 'admin',
	'namespace' => 'JunMy\Admin\Controllers\\',
	'controller' => 'index',
	'action' => 'index'
));

$router->add('/gghadmin/index/', array(
	'module' => 'admin',
	'namespace' => 'JunMy\Admin\Controllers\\',
	'controller' => 'index',
	'action' => 'index'
)); 
 
$router->add('/gghadmin/imall/index', array(
	'module' => 'admin',
	'namespace' => 'JunMy\Admin\Controllers\\',
	'controller' => 'imall',
	'action' => 'index',
));

$router->add('/gghadmin/imall/pending', array(
	'module' => 'admin',
	'namespace' => 'JunMy\Admin\Controllers\\',
	'controller' => 'imall',
	'action' => 'pending',
));

$router->add('/gghadmin/imall/view/{slug}', array(
	'module' => 'admin',
	'namespace' => 'JunMy\Admin\Controllers\\',
	'controller' => 'imall',
	'action' => 'view',
));

$router->add('/gghadmin/users/register', array(
	'module' => 'admin',
	'namespace' => 'JunMy\Admin\Controllers\\',
	'controller' => 'users',
	'action' => 'register',
));

$router->add('/gghadmin/users/index', array(
	'module' => 'admin',
	'namespace' => 'JunMy\Admin\Controllers\\',
	'controller' => 'users',
	'action' => 'index',
));

$router->add('/gghadmin/users/view', array(
	'module' => 'admin',
	'namespace' => 'JunMy\Admin\Controllers\\',
	'controller' => 'users',
	'action' => 'view',
));

$router->add('/gghadmin/users/profile/{slug}', array(
	'module' => 'admin',
	'namespace' => 'JunMy\Admin\Controllers\\',
	'controller' => 'users',
	'action' => 'profile',
));

$router->add('/gghadmin/users/edit/{slug}', array(
	'module' => 'admin',
	'namespace' => 'JunMy\Admin\Controllers\\',
	'controller' => 'users',
	'action' => 'edit',
));

$router->add('/gghadmin/users/ireseller/{slug}', array(
	'module' => 'admin',
	'namespace' => 'JunMy\Admin\Controllers\\',
	'controller' => 'users',
	'action' => 'ireseller',
));

$router->add('/gghadmin/users/logout', array(
	'module' => 'admin',
	'namespace' => 'JunMy\Admin\Controllers\\',
	'controller' => 'users',
	'action' => 'logout',
));

$router->add('/gghadmin/users/login', array(
	'module' => 'admin',
	'namespace' => 'JunMy\Admin\Controllers\\',
	'controller' => 'users',
	'action' => 'login',
));

$router->add('/gghadmin/users/forgotpassword', array(
	'module' => 'admin',
	'namespace' => 'JunMy\Admin\Controllers\\',
	'controller' => 'users',
	'action' => 'forgotpassword',
));

$router->add('/gghadmin/insuran/manage', array(
	'module' => 'admin',
	'namespace' => 'JunMy\Admin\Controllers\\',
	'controller' => 'insuran',
	'action' => 'manage',
));

$router->add('/gghadmin/insuran/quotation', array(
	'module' => 'admin',
	'namespace' => 'JunMy\Admin\Controllers\\',
	'controller' => 'insuran',
	'action' => 'quotation',
));

$router->add('/gghadmin/insuran/kiv', array(
	'module' => 'admin',
	'namespace' => 'JunMy\Admin\Controllers\\',
	'controller' => 'insuran',
	'action' => 'kiv',
));

$router->add('/gghadmin/insuran/all', array(
	'module' => 'admin',
	'namespace' => 'JunMy\Admin\Controllers\\',
	'controller' => 'insuran',
	'action' => 'all',
));

$router->add('/gghadmin/insuran/addtokiv', array(
	'module' => 'admin',
	'namespace' => 'JunMy\Admin\Controllers\\',
	'controller' => 'insuran',
	'action' => 'addtokiv',
));

$router->add('/gghadmin/insuran/done', array(
	'module' => 'admin',
	'namespace' => 'JunMy\Admin\Controllers\\',
	'controller' => 'insuran',
	'action' => 'done',
));

$router->add('/gghadmin/insuran/update/{slug}', array(
	'module' => 'admin',
	'namespace' => 'JunMy\Admin\Controllers\\',
	'controller' => 'insuran',
	'action' => 'update',
));

$router->add('/gghadmin/commissions/payout', array(
	'module' => 'admin',
	'namespace' => 'JunMy\Admin\Controllers\\',
	'controller' => 'commissions',
	'action' => 'payout',
));
$router->add('/gghadmin/insuran/renew/{slug}', array(
	'module' => 'admin',
	'namespace' => 'JunMy\Admin\Controllers\\',
	'controller' => 'insuran',
	'action' => 'renew',
));


$router->add('/gghadmin/epins/index', array(
	'module' => 'admin',
	'namespace' => 'JunMy\Admin\Controllers\\',
	'controller' => 'epins',
	'action' => 'index',
));

$router->add('/gghadmin/epins/add', array(
	'module' => 'admin',
	'namespace' => 'JunMy\Admin\Controllers\\',
	'controller' => 'epins',
	'action' => 'add',
));

$router->add('/gghadmin/epins/transfer', array(
	'module' => 'admin',
	'namespace' => 'JunMy\Admin\Controllers\\',
	'controller' => 'epins',
	'action' => 'transfer',
));

$router->add('/gghadmin/epins/track', array(
	'module' => 'admin',
	'namespace' => 'JunMy\Admin\Controllers\\',
	'controller' => 'epins',
	'action' => 'track',
));

$router->add('/gghadmin/epins/viewuseripin', array(
	'module' => 'admin',
	'namespace' => 'JunMy\Admin\Controllers\\',
	'controller' => 'epins',
	'action' => 'viewuseripin',
));

$router->add('/gghadmin/epins/track', array(
	'module' => 'admin',
	'namespace' => 'JunMy\Admin\Controllers\\',
	'controller' => 'epins',
	'action' => 'track',
));

$router->add('/gghadmin/reports/index', array(
	'module' => 'admin',
	'namespace' => 'JunMy\Admin\Controllers\\',
	'controller' => 'reports',
	'action' => 'index',
));

$router->add('/gghadmin/reports/renewal', array(
	'module' => 'admin',
	'namespace' => 'JunMy\Admin\Controllers\\',
	'controller' => 'reports',
	'action' => 'renewal',
));

$router->add('/gghadmin/reports/bankin', array(
	'module' => 'admin',
	'namespace' => 'JunMy\Admin\Controllers\\',
	'controller' => 'reports',
	'action' => 'bankin',
));

$router->add('/gghadmin/reports/iprihatin', array(
	'module' => 'admin',
	'namespace' => 'JunMy\Admin\Controllers\\',
	'controller' => 'reports',
	'action' => 'iprihatin',
));

$router->add('/gghadmin/reports/payout', array(
	'module' => 'admin',
	'namespace' => 'JunMy\Admin\Controllers\\',
	'controller' => 'reports',
	'action' => 'payout',
));

$router->add('/gghadmin/wallets/index', array(
	'module' => 'admin',
	'namespace' => 'JunMy\Admin\Controllers\\',
	'controller' => 'wallets',
	'action' => 'index',
));

$router->add('/gghadmin/wallets/view', array(
	'module' => 'admin',
	'namespace' => 'JunMy\Admin\Controllers\\',
	'controller' => 'wallets',
	'action' => 'view',
));

$router->add('/gghadmin/wallets/admin', array(
	'module' => 'admin',
	'namespace' => 'JunMy\Admin\Controllers\\',
	'controller' => 'wallets',
	'action' => 'admin',
));

$router->add('/gghadmin/wallets/deduct', array(
	'module' => 'admin',
	'namespace' => 'JunMy\Admin\Controllers\\',
	'controller' => 'wallets',
	'action' => 'deduct',
));

$router->add('/gghadmin/wallets/admin', array(
	'module' => 'admin',
	'namespace' => 'JunMy\Admin\Controllers\\',
	'controller' => 'wallets',
	'action' => 'admin',
));

$router->add('/gghadmin/ajax/ajaxusername', array(
	'module' => 'admin',
	'namespace' => 'JunMy\Admin\Controllers\\',
	'controller' => 'ajax',
	'action' => 'ajaxusername',
));

$router->add('/gghadmin/ajax/ajaxreply', array(
	'module' => 'admin',
	'namespace' => 'JunMy\Admin\Controllers\\',
	'controller' => 'ajax',
	'action' => 'ajaxreply',
));

$router->add('/gghadmin/ajax/ajaximall', array(
	'module' => 'admin',
	'namespace' => 'JunMy\Admin\Controllers\\',
	'controller' => 'ajax',
	'action' => 'ajaximall',
));

$router->add('/gghadmin/ajax/ajaxioffer', array(
	'module' => 'admin',
	'namespace' => 'JunMy\Admin\Controllers\\',
	'controller' => 'ajax',
	'action' => 'ajaxioffer',
));

$router->add('/gghadmin/ajax/ajaxuserid', array(
	'module' => 'admin',
	'namespace' => 'JunMy\Admin\Controllers\\',
	'controller' => 'ajax',
	'action' => 'ajaxuserid',
));

$router->add('/gghadmin/messages/index', array(
	'module' => 'admin',
	'namespace' => 'JunMy\Admin\Controllers\\',
	'controller' => 'messages',
	'action' => 'index',
));


$router->add('/gghadmin/messages/sentitems', array(
	'module' => 'admin',
	'namespace' => 'JunMy\Admin\Controllers\\',
	'controller' => 'messages',
	'action' => 'sentitems',
));

$router->add('/gghadmin/messages/preview', array(
	'module' => 'admin',
	'namespace' => 'JunMy\Admin\Controllers\\',
	'controller' => 'messages',
	'action' => 'preview',
));

$router->add('/gghadmin/messages/compose', array(
	'module' => 'admin',
	'namespace' => 'JunMy\Admin\Controllers\\',
	'controller' => 'messages',
	'action' => 'compose',
));


$router->add('/gghadmin/messages/view/{id}', array(
	'module' => 'admin',
	'namespace' => 'JunMy\Admin\Controllers\\',
	'controller' => 'messages',
	'action' => 'view',
));

$router->add('/gghadmin/iprihatin/index', array(
	'module' => 'admin',
	'namespace' => 'JunMy\Admin\Controllers\\',
	'controller' => 'iprihatin',
	'action' => 'index',
));

$router->add('/gghadmin/iprihatin/view/{slug}', array(
	'module' => 'admin',
	'namespace' => 'JunMy\Admin\Controllers\\',
	'controller' => 'iprihatin',
	'action' => 'view',
));

$router->add('/gghadmin/iprihatin/edit/{slug}', array(
	'module' => 'admin',
	'namespace' => 'JunMy\Admin\Controllers\\',
	'controller' => 'iprihatin',
	'action' => 'edit',
));


$router->add('/gghadmin/iprihatin/add', array(
	'module' => 'admin',
	'namespace' => 'JunMy\Admin\Controllers\\',
	'controller' => 'iprihatin',
	'action' => 'add',
));

$router->add('/gghadmin/iprihatin/steptwo/{id}', array(
	'module' => 'admin',
	'namespace' => 'JunMy\Admin\Controllers\\',
	'controller' => 'iprihatin',
	'action' => 'steptwo',
));

$router->add('/gghadmin/iprihatin/ajaxiprihatin', array(
	'module' => 'admin',
	'namespace' => 'JunMy\Admin\Controllers\\',
	'controller' => 'iprihatin',
	'action' => 'ajaxiprihatin',
));
 
$router->add('/gghadmin/graph/username', array(
	'module' => 'admin',
	'namespace' => 'JunMy\Admin\Controllers\\',
	'controller' => 'graph',
	'action' => 'username',
));

$router->add('/gghadmin/error/notallowed', array(
	'module' => 'admin',
	'namespace' => 'JunMy\Admin\Controllers\\',
	'controller' => 'error',
	'action' => 'notallowed',
));

$router->add('/gghadmin/index/jsongrid', array(
	'module' => 'admin',
	'namespace' => 'JunMy\Admin\Controllers\\',
	'controller' => 'index',
	'action' => 'jsongrid',
));

$router->add('/gghadmin/index/jsongridmonth', array(
	'module' => 'admin',
	'namespace' => 'JunMy\Admin\Controllers\\',
	'controller' => 'index',
	'action' => 'jsongridmonth',
));

$router->add('/gghadmin/tree/index', array(
	'module' => 'admin',
	'namespace' => 'JunMy\Admin\Controllers\\',
	'controller' => 'tree',
	'action' => 'index',
));

$router->add('/gghadmin/tree/first', array(
	'module' => 'admin',
	'namespace' => 'JunMy\Admin\Controllers\\',
	'controller' => 'tree',
	'action' => 'first',
));

$router->add('/gghadmin/tree/second', array(
	'module' => 'admin',
	'namespace' => 'JunMy\Admin\Controllers\\',
	'controller' => 'tree',
	'action' => 'second',
));

$router->add('/gghadmin/withdrawals/index', array(
	'module' => 'admin',
	'namespace' => 'JunMy\Admin\Controllers\\',
	'controller' => 'withdrawals',
	'action' => 'index',
));

$router->add('/gghadmin/withdrawals/rejected', array(
	'module' => 'admin',
	'namespace' => 'JunMy\Admin\Controllers\\',
	'controller' => 'withdrawals',
	'action' => 'rejected',
));

$router->add('/gghadmin/withdrawals/proceed', array(
	'module' => 'admin',
	'namespace' => 'JunMy\Admin\Controllers\\',
	'controller' => 'withdrawals',
	'action' => 'proceed',
));

$router->add('/gghadmin/withdrawals/success', array(
	'module' => 'admin',
	'namespace' => 'JunMy\Admin\Controllers\\',
	'controller' => 'withdrawals',
	'action' => 'success',
));

$router->add('/gghadmin/withdrawals/view/{slug}', array(
	'module' => 'admin',
	'namespace' => 'JunMy\Admin\Controllers\\',
	'controller' => 'withdrawals',
	'action' => 'view',
));

$router->add('/gghadmin/withdrawals/approve/{slug}', array(
	'module' => 'admin',
	'namespace' => 'JunMy\Admin\Controllers\\',
	'controller' => 'withdrawals',
	'action' => 'approve',
));

$router->add('/gghadmin/cashflow/index', array(
	'module' => 'admin',
	'namespace' => 'JunMy\Admin\Controllers\\',
	'controller' => 'cashflow',
	'action' => 'index',
));

$router->add('/gghadmin/cashflow/statistic', array(
	'module' => 'admin',
	'namespace' => 'JunMy\Admin\Controllers\\',
	'controller' => 'cashflow',
	'action' => 'statistic',
));

$router->add('/gghadmin/ioffer/index', array(
	'module' => 'admin',
	'namespace' => 'JunMy\Admin\Controllers\\',
	'controller' => 'ioffer',
	'action' => 'index',
));

$router->add('/gghadmin/ioffer/add', array(
	'module' => 'admin',
	'namespace' => 'JunMy\Admin\Controllers\\',
	'controller' => 'ioffer',
	'action' => 'add',
));

$router->add('/gghadmin/ioffer/order', array(
	'module' => 'admin',
	'namespace' => 'JunMy\Admin\Controllers\\',
	'controller' => 'ioffer',
	'action' => 'order',
));

$router->add('/gghadmin/ioffer/steptwo', array(
	'module' => 'admin',
	'namespace' => 'JunMy\Admin\Controllers\\',
	'controller' => 'ioffer',
	'action' => 'steptwo',
));

$router->add('/gghadmin/ioffer/finish', array(
	'module' => 'admin',
	'namespace' => 'JunMy\Admin\Controllers\\',
	'controller' => 'ioffer',
	'action' => 'finish',
));

$router->add('/gghadmin/ioffer/edit/{slug}', array(
	'module' => 'admin',
	'namespace' => 'JunMy\Admin\Controllers\\',
	'controller' => 'ioffer',
	'action' => 'edit',
));

$router->add('/gghadmin/ioffer/view/{slug}', array(
	'module' => 'admin',
	'namespace' => 'JunMy\Admin\Controllers\\',
	'controller' => 'ioffer',
	'action' => 'view',
));

$router->add('/gghadmin/ipartner/index', array(
	'module' => 'admin',
	'namespace' => 'JunMy\Admin\Controllers\\',
	'controller' => 'ipartner',
	'action' => 'index',
));

$router->add('/gghadmin/event/index', array(
	'module' => 'admin',
	'namespace' => 'JunMy\Admin\Controllers\\',
	'controller' => 'event',
	'action' => 'index',
));

$router->add('/gghadmin/ipartner/pending', array(
	'module' => 'admin',
	'namespace' => 'JunMy\Admin\Controllers\\',
	'controller' => 'ipartner',
	'action' => 'pending',
));

$router->add('/gghadmin/ipartner/view/{slug}', array(
	'module' => 'admin',
	'namespace' => 'JunMy\Admin\Controllers\\',
	'controller' => 'ipartner',
	'action' => 'view',
)); 

$router->add('/gghadmin/isahabat/index', array(
	'module' => 'admin',
	'namespace' => 'JunMy\Admin\Controllers\\',
	'controller' => 'isahabat',
	'action' => 'index',
));

$router->add('/gghadmin/reports/index', array(
	'module' => 'admin',
	'namespace' => 'JunMy\Admin\Controllers\\',
	'controller' => 'reports',
	'action' => 'index',
));

$router->add('/gghadmin/reports/print', array(
	'module' => 'admin',
	'namespace' => 'JunMy\Admin\Controllers\\',
	'controller' => 'reports',
	'action' => 'print',
));

$router->add('/gghadmin/statistic/index', array(
	'module' => 'admin',
	'namespace' => 'JunMy\Admin\Controllers\\',
	'controller' => 'statistic',
	'action' => 'index',
));

$router->add('/gghadmin/settings/index', array(
	'module' => 'admin',
	'namespace' => 'JunMy\Admin\Controllers\\',
	'controller' => 'settings',
	'action' => 'index',
));

$router->add('/gghadmin/settings/password', array(
	'module' => 'admin',
	'namespace' => 'JunMy\Admin\Controllers\\',
	'controller' => 'settings',
	'action' => 'password',
));  

$router->add('/gghadmin/activations/index', array(
	'module' => 'admin',
	'namespace' => 'JunMy\Admin\Controllers\\',
	'controller' => 'activations',
	'action' => 'index',
));  

$router->add('/gghadmin/activations/all', array(
	'module' => 'admin',
	'namespace' => 'JunMy\Admin\Controllers\\',
	'controller' => 'activations',
	'action' => 'all',
));  

$router->add('/gghadmin/activations/problems', array(
	'module' => 'admin',
	'namespace' => 'JunMy\Admin\Controllers\\',
	'controller' => 'activations',
	'action' => 'problems',
));  

$router->add('/gghadmin/inews/index', array(
	'module' => 'admin',
	'namespace' => 'JunMy\Admin\Controllers\\',
	'controller' => 'inews',
	'action' => 'index',
)); 

$router->add('/gghadmin/inews/view/{slug}', array(
	'module' => 'admin',
	'namespace' => 'JunMy\Admin\Controllers\\',
	'controller' => 'inews',
	'action' => 'view',
)); 

$router->add('/gghadmin/repairs/index', array(
	'module' => 'admin',
	'namespace' => 'JunMy\Admin\Controllers\\',
	'controller' => 'repairs',
	'action' => 'index',
));

 
return $router;
