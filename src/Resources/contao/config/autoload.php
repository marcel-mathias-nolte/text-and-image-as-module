<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (C) 2005-2012 Leo Feyer
 *
 * @package   ContaoTextAndImageAsModuleBundle
 * @author    Marcel Mathias Nolte
 * @copyright Marcel Mathias Nolte 2015-2020
 * @website	  https://marcel.live
 * @license   LGPL-3.0-or-later
 */


/**
 * Register the namespaces
 */
ClassLoader::addNamespaces(array
(
	'NC',
));


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	// Modules
	'NC\\ModuleNcText'  => 'system/modules/nc_mod_text_image/modules/ModuleNcText.php',
	'NC\\ModuleNcImage' => 'system/modules/nc_mod_text_image/modules/ModuleNcImage.php'
));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
	'mod_text'          => 'system/modules/nc_mod_text_image/templates/modules',
	'mod_image'         => 'system/modules/nc_mod_text_image/templates/modules'
));