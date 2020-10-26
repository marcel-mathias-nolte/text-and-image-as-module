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

namespace MarcelMathiasNolte\ContaoTextAndImageAsModuleBundle\Module;


/**
 * Front end module "image".
 *
 * @package   ContaoTestAndImageAsModuleBundle
 * @author    Marcel Mathias Nolte
 * @copyright Marcel Mathias Nolte 2015-2020
 */
class ModuleImage extends Contao\Module
{

	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'mod_mmn_image';


	/**
	 * Return if the image does not exist
	 *
	 * @return string
	 */
	public function generate()
	{
		if ($this->singleSRC == '')
		{
			return '';
		}

		$objFile = Contao\FilesModel::findByUuid($this->singleSRC);

		if ($objFile === null)
		{
			if (!Contao\Validator::isUuid($this->singleSRC))
			{
				return '<p class="error">'.$GLOBALS['TL_LANG']['ERR']['version2format'].'</p>';
			}

			return '';
		}

		if (!is_file(TL_ROOT . '/' . $objFile->path))
		{
			return '';
		}

		$this->singleSRC = $objFile->path;

		return parent::generate();
	}


	/**
	 * Generate the content element
	 */
	protected function compile()
	{
		$this->addImageToTemplate($this->Template, $this->arrData);
	}
}