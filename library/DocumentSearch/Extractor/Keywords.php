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

class Keywords implements ExtractorInterface
{
    /**
     * {@inheritdoc}
     */
    public function isEnabledForExtension($ext)
    {
        // this one is enabled for all files enabled in the settings
        $arrExts = deserialize($GLOBALS['TL_CONFIG']['searchExtensions'], true);
        $arrContent = deserialize($GLOBALS['TL_CONFIG']['searchContents'], true);

        return (in_array('keywords', $arrContent) && in_array($ext, $arrExts));
    }

    /**
     * {@inheritdoc}
     */
    public function extract($fileModel, $pageModel)
    {
        // replace commas with spaces so the search engine treats them as separate words
        return str_replace(',', ' ', $fileModel->documentsearch_keywords);
    }


    /**
     * {@inheritdoc}
     */
    public function setIndexData($data)
    {
        return $data;
    }
}
