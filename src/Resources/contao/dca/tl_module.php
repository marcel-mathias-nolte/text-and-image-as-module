<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (C) 2005-2012 Leo Feyer
 *
 * @package   ContaoTestAndImageAsModuleBundle
 * @author    Marcel Mathias Nolte
 * @copyright Marcel Mathias Nolte 2015-2020
 * @website	  https://marcel.live
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
$GLOBALS['TL_DCA']['tl_module']['fields']['singleSRC']['load_callback'][] = array('MarcelMathiasNolte\ContaoTextAndImageAsModuleBundle\ContaoTextAndImageAsModuleDcaHelper', 'setSingleSrcFlags');
$GLOBALS['TL_DCA']['tl_module']['fields']['singleSRC']['save_callback'][] = array('MarcelMathiasNolte\ContaoTextAndImageAsModuleBundle\ContaoTextAndImageAsModuleDcaHelper', 'storeFileMetaInformation');
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
		array('MarcelMathiasNolte\ContaoTextAndImageAsModuleBundle\ContaoTextAndImageAsModuleDcaHelper', 'pagePicker')
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

/**
 * Class ContaoTextAndImageAsModuleDcaHelper
 *
 * Provide miscellaneous methods that are used by the data configuration array.
 * @package   ContaoTextAndImageAsModuleBundle
 * @author    Marcel Mathias Nolte
 * @copyright Marcel Mathias Nolte 2015-2020
 * @website	  https://marcel.live
 * @license   LGPL-3.0-or-later
 */
class ContaoTextAndImageAsModuleDcaHelper extends \Backend
{

	/**
	 * Import the back end user object
	 */
	public function __construct()
	{
		parent::__construct();
		$this->import('BackendUser', 'User');
	}

	/**
	 * Dynamically add flags to the "singleSRC" field
	 *
	 * @param mixed         $varValue
	 * @param DataContainer $dc
	 *
	 * @return mixed
	 */
	public function setSingleSrcFlags($varValue, DataContainer $dc)
	{
		if ($dc->activeRecord)
		{
			switch ($dc->activeRecord->type)
			{
				case 'text':
				case 'image':
					$GLOBALS['TL_DCA'][$dc->table]['fields'][$dc->field]['eval']['extensions'] = Config::get('validImageTypes');
					break;
			}
		}

		return $varValue;
	}


	/**
	 * Pre-fill the "alt" and "caption" fields with the file meta data
	 *
	 * @param mixed         $varValue
	 * @param DataContainer $dc
	 *
	 * @return mixed
	 */
	public function storeFileMetaInformation($varValue, DataContainer $dc)
	{
		if ($dc->activeRecord->singleSRC == $varValue)
		{
			return $varValue;
		}

		$objFile = FilesModel::findByUuid($varValue);

		if ($objFile !== null)
		{
			$arrMeta = deserialize($objFile->meta);

			if (!empty($arrMeta))
			{
				$objPage = $this->Database->prepare("SELECT * FROM tl_page WHERE id=(SELECT pid FROM " . ($dc->activeRecord->ptable ?: 'tl_article') . " WHERE id=?)")
										  ->execute($dc->activeRecord->pid);

				if ($objPage->numRows)
				{
					$objModel = new PageModel();
					$objModel->setRow($objPage->row());
					$objModel->loadDetails();

					// Convert the language to a locale (see #5678)
					$strLanguage = str_replace('-', '_', $objModel->rootLanguage);
					if (isset($arrMeta[$strLanguage]))
					{
						Input::setPost('alt', $arrMeta[$strLanguage]['title']);
						Input::setPost('caption', $arrMeta[$strLanguage]['caption']);
					}
				}
			}
		}

		return $varValue;
	}


	/**
	 * Return the link picker wizard
	 *
	 * @param DataContainer $dc
	 *
	 * @return string
	 */
	public function pagePicker(DataContainer $dc)
	{
		return ' <a href="' . ((strpos($dc->value, '{{link_url::') !== false) ? 'contao/page.php' : 'contao/file.php') . '?do=' . Input::get('do') . '&amp;table=' . $dc->table . '&amp;field=' . $dc->field . '&amp;value=' . str_replace(array('{{link_url::', '}}'), '', $dc->value) . '&amp;switch=1' . '" title="' . specialchars($GLOBALS['TL_LANG']['MSC']['pagepicker']) . '" onclick="Backend.getScrollOffset();Backend.openModalSelector({\'width\':768,\'title\':\'' . specialchars(str_replace("'", "\\'", $GLOBALS['TL_LANG']['MOD']['page'][0])) . '\',\'url\':this.href,\'id\':\'' . $dc->field . '\',\'tag\':\'ctrl_'. $dc->field . ((Input::get('act') == 'editAll') ? '_' . $dc->id : '') . '\',\'self\':this});return false">' . Image::getHtml('pickpage.gif', $GLOBALS['TL_LANG']['MSC']['pagepicker'], 'style="vertical-align:top;cursor:pointer"') . '</a>';
	}

}