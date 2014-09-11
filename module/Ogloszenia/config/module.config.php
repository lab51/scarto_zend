<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Ogloszenia\Controller\Ogloszenia' => 'Ogloszenia\Controller\OgloszeniaController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'ogloszenia' => array(
                'type'    => 'Literal',
                'options' => array(
                    // Change this to something specific to your module
                    'route'    => '/ogloszenia',
                    'defaults' => array(
                        // Change this value to reflect the namespace in which
                        // the controllers for your module are found
                        '__NAMESPACE__' => 'Ogloszenia\Controller',
                        'controller'    => 'Ogloszenia',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    // This route is a sane default when developing a module;
                    // as you solidify the routes for your module, however,
                    // you may want to remove it and replace it with more
                    // specific routes.
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:action[/:id]]',
                            'constraints' => array(
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
								'id'     => '[0-9]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
			//'ogloszenia' => '/home/recfilm/domains/scarto.pl/public_html/module/Ogloszenia/view/Ogloszenia',
            'Ogloszenia' => __DIR__ . '/../view',
        ),
    ),
  'tmp_module_config' => array(
			//'tmp_upload_location' => __DIR__ . '/tmp_data',
			'tmp_upload_location' => '/home/recfilm/domains/scarto.pl/public_html/public/images/tmp_data',
			
	),  
	'module_config' => array(
			//'upload_location' => __DIR__ . '/data',
			'upload_location' => '/home/recfilm/domains/scarto.pl/public_html/public/images/data',
	),
	
);
