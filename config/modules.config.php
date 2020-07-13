<?php

/**
 * @see       https://github.com/laminas/laminas-mvc-skeleton for the canonical source repository
 * @copyright https://github.com/laminas/laminas-mvc-skeleton/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-mvc-skeleton/blob/master/LICENSE.md New BSD License
 */

/**
 * List of enabled modules for this application.
 *
 * This should be an array of module namespaces used in the application.
 */
return [
    'Laminas\Mvc\Plugin\FlashMessenger',
	'Laminas\Router',
	'Laminas\Form',
	'Laminas\InputFilter',
	'Laminas\Hydrator',
	'Laminas\Filter',
	'Laminas\I18n',
	'Laminas\Db',
	'Laminas\Session',
    'Laminas\Validator',
    'Application',
    'User' #my module for album crud operation -initially i was making something else so i did not remained the module name to Album
];
