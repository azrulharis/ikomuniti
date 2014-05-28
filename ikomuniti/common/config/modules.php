<?php

return array(
	'frontend' => array(
		'className' => 'JunMy\Frontend\Module',
		'path' => '../apps/frontend/Module.php'
	),
	'admin' => array(
	    'className' => 'JunMy\Admin\Module',
	    'path' => '../apps/admin/Module.php'
	)
);

return array(
	'elements' => array(
		'className' => 'JunMy\Frontend\Elements',
		'path' => '../apps/frontend/Elements.php'
	)
);