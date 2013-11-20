<?php

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2013 Leo Feyer
 *
 * Formerly known as TYPOlight Open Source CMS.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 *
 * PHP version 5
 * @copyright  terminal42 gmbh 2013
 * @author     Yanick Witschi <yanick.witschi@terminal42.ch>
 */

namespace DocumentSearch\Extractor;

use DocumentSearch\ExtractorInterface;

class Ppt implements ExtractorInterface
{
    /**
     * {@inheritdoc}
     */
    public function isEnabledForExtension($ext)
    {
        // if there is no indexer tool, it is never enabled
        if ($GLOBALS['TL_CONFIG']['searchToolPPT'] == '')
            return false;

        $arrExts = deserialize($GLOBALS['TL_CONFIG']['searchExtensions'], true);
        return (in_array($ext, array('ppt'. 'pptx')) && in_array($ext, $arrExts));
    }

    /**
     * {@inheritdoc}
     */
    public function extract($fileModel, $pageModel)
    {
        $objFile = new \File($fileModel->path);
        $arrContent = array();
        $strCommand = $GLOBALS['TL_CONFIG']['searchToolPPT'] . ' "'.$objFile->dirname.'/'.$objFile->basename.'"';

        exec($strCommand, $arrContent, $returnCode);

        if ($returnCode != 0)
            return '';

        // remove unnecessary parts (html header, file name, pptHtml notice, html footer)
        unset($arrContent[count($arrContent)-1]);
        unset($arrContent[count($arrContent)-1]);
        unset($arrContent[0]);
        unset($arrContent[1]);

        return strip_tags(implode("\n", $arrContent));
    }


    /**
     * {@inheritdoc}
     */
    public function setIndexData($data)
    {
        return $data;
    }
}
