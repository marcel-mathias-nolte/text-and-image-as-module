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

class DcaCallbacks extends \Contao\Backend
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
     * @param \Contao\DataContainer $dc
     *
     * @return mixed
     */
    public function setSingleSrcFlags($varValue, \Contao\DataContainer $dc)
    {
        if ($dc->activeRecord)
        {
            switch ($dc->activeRecord->type)
            {
                case 'text':
                case 'image':
                    $GLOBALS['TL_DCA'][$dc->table]['fields'][$dc->field]['eval']['extensions'] = \Contao\Config::get('validImageTypes');
                    break;
            }
        }

        return $varValue;
    }


    /**
     * Pre-fill the "alt" and "caption" fields with the file meta data
     *
     * @param mixed         $varValue
     * @param \Contao\DataContainer $dc
     *
     * @return mixed
     */
    public function storeFileMetaInformation($varValue, \Contao\DataContainer $dc)
    {
        if ($dc->activeRecord->singleSRC == $varValue)
        {
            return $varValue;
        }

        $objFile = \Contao\FilesModel::findByUuid($varValue);

        if ($objFile !== null)
        {
            $arrMeta = deserialize($objFile->meta);

            if (!empty($arrMeta))
            {
                $objPage = $this->Database->prepare("SELECT * FROM tl_page WHERE id=(SELECT pid FROM " . ($dc->activeRecord->ptable ?: 'tl_article') . " WHERE id=?)")
                    ->execute($dc->activeRecord->pid);

                if ($objPage->numRows)
                {
                    $objModel = new \Contao\PageModel();
                    $objModel->setRow($objPage->row());
                    $objModel->loadDetails();

                    // Convert the language to a locale (see #5678)
                    $strLanguage = str_replace('-', '_', $objModel->rootLanguage);
                    if (isset($arrMeta[$strLanguage]))
                    {
                        \Contao\Input::setPost('alt', $arrMeta[$strLanguage]['title']);
                        \Contao\Input::setPost('caption', $arrMeta[$strLanguage]['caption']);
                    }
                }
            }
        }

        return $varValue;
    }


    /**
     * Return the link picker wizard
     *
     * @param \Contao\DataContainer $dc
     *
     * @return string
     */
    public function pagePicker(\Contao\DataContainer $dc)
    {
        return ' <a href="' . ((strpos($dc->value, '{{link_url::') !== false) ? 'contao/page.php' : 'contao/file.php') . '?do=' . \Contao\Input::get('do') . '&amp;table=' . $dc->table . '&amp;field=' . $dc->field . '&amp;value=' . str_replace(array('{{link_url::', '}}'), '', $dc->value) . '&amp;switch=1' . '" title="' . specialchars($GLOBALS['TL_LANG']['MSC']['pagepicker']) . '" onclick="Backend.getScrollOffset();Backend.openModalSelector({\'width\':768,\'title\':\'' . specialchars(str_replace("'", "\\'", $GLOBALS['TL_LANG']['MOD']['page'][0])) . '\',\'url\':this.href,\'id\':\'' . $dc->field . '\',\'tag\':\'ctrl_'. $dc->field . ((\Contao\Input::get('act') == 'editAll') ? '_' . $dc->id : '') . '\',\'self\':this});return false">' . \Contao\Image::getHtml('pickpage.gif', $GLOBALS['TL_LANG']['MSC']['pagepicker'], 'style="vertical-align:top;cursor:pointer"') . '</a>';
    }

}
