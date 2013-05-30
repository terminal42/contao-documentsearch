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

class Doc implements ExtractorInterface
{
    /**
     * {@inheritdoc}
     */
    public function isEnabledForExtension($ext)
    {
        // if there is no indexer tool, it is never enabled
        if ($GLOBALS['TL_CONFIG']['searchToolDOC'] == '')
            return false;

        $arrExts = deserialize($GLOBALS['TL_CONFIG']['searchExtensions'], true);
        return (in_array($ext, array('doc')) && in_array($ext, $arrExts));
    }


    /**
     * {@inheritdoc}
     */
    public function extract($fileModel)
    {
        $objFile = new \File($fileModel->path);
        $arrContent = array();
        $strCommand = $GLOBALS['TL_CONFIG']['searchToolDOC'] . ' "'.$objFile->dirname.'/'.$objFile->basename.'"';

        exec($strCommand, $arrContent, $returnCode);

        if ($returnCode != 0)
            return '';

        return implode("\n", $arrContent);
    }
}