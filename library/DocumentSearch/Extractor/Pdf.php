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

class Pdf implements ExtractorInterface
{
    /**
     * {@inheritdoc}
     */
    public function isEnabledForExtension($ext)
    {
        // if there is no indexer tool, it is never enabled
        if ($GLOBALS['TL_CONFIG']['searchToolPDF'] == '')
            return false;

        $arrExts = deserialize($GLOBALS['TL_CONFIG']['searchExtensions'], true);
        return (in_array($ext, array('pdf')) && in_array($ext, $arrExts));
    }

    /**
     * {@inheritdoc}
     */
    public function extract($fileModel)
    {
        $objFile = new \File($fileModel->path);
        $strTempFile = TL_ROOT . '/system/tmp/documentsearch_pdf_' . $fileModel->id;

        if (!file_exists($strTempFile)) {
            $strCommand = $GLOBALS['TL_CONFIG']['searchToolPDF'] . ' "'.$objFile->dirname.'/'.$objFile->basename.'" "'.$strTempFile.'"';

            system($strCommand, $returnCode);

            if (($returnCode === null) || $returnCode != 0)
                return '';
        }

        $strContent = file_get_contents($strTempFile);
        unlink($strTempFile);

        return $strContent;
    }


    /**
     * {@inheritdoc}
     */
    public function setIndexData($data)
    {
        return $data;
    }
}