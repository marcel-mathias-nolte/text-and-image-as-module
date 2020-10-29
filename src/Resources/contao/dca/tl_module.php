<?php

/*
 * This file is part of ContaoTextAndImageAsModuleBundle.
 *
 * @package   ContaoTextAndImageAsModuleBundle
 * @author    Marcel Mathias Nolte
 * @copyright Marcel Mathias Nolte 2015-2020
 * @website	  https://github.com/marcel-mathias-nolte
 * @license   LGPL-3.0-or-later
 */

namespace MarcelMathiasNolte\ContaoTextAndImageAsModuleBundle;

/**
 * Table tl_module
 */
$GLOBALS['TL_DCA']['tl_module']['palettes']['mmnText'] = '{title_legend},name,headline,type;{text_legend},text;{image_legend},addImage;{template_legend:hide},customTpl;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space';
$GLOBALS['TL_DCA']['tl_module']['palettes']['mmnImage'] = '{title_legend},name,headline,type;{source_legend},singleSRC;{image_legend},alt,title,size,imagemargin,imageUrl,fullsize,caption;{template_legend:hide},customTpl;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space';
$GLOBALS['TL_DCA']['tl_module']['subpalettes']['addImage'] = 'singleSRC,alt,title,size,imagemargin,imageUrl,fullsize,caption,floating';
$GLOBALS['TL_DCA']['tl_module']['fields']['text'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['text'],
	'exclude'                 => true,
	'search'                  => true,
	'inputType'               => 'textarea',
	'eval'                    => array('mandatory'=>true, 'rte'=>'tinyMCE', 'helpwizard'=>true),
	'explanation'             => 'insertTags',
	'sql'                     => "mediumtext NULL"
);
$GLOBALS['TL_DCA']['tl_module']['fields']['addImage'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['addImage'],
	'exclude'                 => true,
	'inputType'               => 'checkbox',
	'eval'                    => array('submitOnChange'=>true),
	'sql'                     => "char(1) NOT NULL default ''"
);
$GLOBALS['TL_DCA']['tl_module']['fields']['singleSRC']['load_callback'][] = array('MarcelMathiasNolte\ContaoTextAndImageAsModuleBundle\DcaCallbacks', 'setSingleSrcFlags');
$GLOBALS['TL_DCA']['tl_module']['fields']['singleSRC']['save_callback'][] = array('MarcelMathiasNolte\ContaoTextAndImageAsModuleBundle\DcaCallbacks', 'storeFileMetaInformation');
$GLOBALS['TL_DCA']['tl_module']['fields']['alt'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['alt'],
	'exclude'                 => true,
	'search'                  => true,
	'inputType'               => 'text',
	'eval'                    => array('maxlength'=>255, 'tl_class'=>'w50'),
	'sql'                     => "varchar(255) NOT NULL default ''"
);
$GLOBALS['TL_DCA']['tl_module']['fields']['title'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['title'],
	'exclude'                 => true,
	'search'                  => true,
	'inputType'               => 'text',
	'eval'                    => array('maxlength'=>255, 'tl_class'=>'w50'),
	'sql'                     => "varchar(255) NOT NULL default ''"
);
$GLOBALS['TL_DCA']['tl_module']['fields']['imagemargin'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['imagemargin'],
	'exclude'                 => true,
	'inputType'               => 'trbl',
	'options'                 => $GLOBALS['TL_CSS_UNITS'],
	'eval'                    => array('includeBlankOption'=>true, 'tl_class'=>'w50'),
	'sql'                     => "varchar(128) NOT NULL default ''"
);
$GLOBALS['TL_DCA']['tl_module']['fields']['imageUrl'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['imageUrl'],
	'exclude'                 => true,
	'search'                  => true,
	'inputType'               => 'text',
	'eval'                    => array('rgxp'=>'url', 'decodeEntities'=>true, 'maxlength'=>255, 'fieldType'=>'radio', 'filesOnly'=>true, 'tl_class'=>'w50 wizard'),
	'wizard' => array
	(
		array('MarcelMathiasNolte\ContaoTextAndImageAsModuleBundle\DcaCallbacks', 'pagePicker')
	),
	'sql'                     => "varchar(255) NOT NULL default ''"
);
$GLOBALS['TL_DCA']['tl_module']['fields']['caption'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['caption'],
	'exclude'                 => true,
	'search'                  => true,
	'inputType'               => 'text',
	'eval'                    => array('maxlength'=>255, 'allowHtml'=>true, 'tl_class'=>'w50'),
	'sql'                     => "varchar(255) NOT NULL default ''"
);
$GLOBALS['TL_DCA']['tl_module']['fields']['floating'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['floating'],
	'default'                 => 'above',
	'exclude'                 => true,
	'inputType'               => 'radioTable',
	'options'                 => array('above', 'left', 'right', 'below'),
	'eval'                    => array('cols'=>4, 'tl_class'=>'w50'),
	'reference'               => &$GLOBALS['TL_LANG']['MSC'],
	'sql'                     => "varchar(32) NOT NULL default ''"
);
