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

class Rtf implements ExtractorInterface
{
    /**
     * {@inheritdoc}
     */
    public function isEnabledForExtension($ext)
    {
        $arrExts = trimsplit(',', $GLOBALS['TL_CONFIG']['searchExtensions']);
        $arrContent = deserialize($GLOBALS['TL_CONFIG']['searchContents'], true);

        return (in_array('file', $arrContent) && in_array($ext, array('rtf')) && in_array($ext, $arrExts));
    }

    /**
     * {@inheritdoc}
     */
    public function extract($fileModel, $pageModel)
    {
        require_once(TL_ROOT . '/system/modules/documentsearch/tools/rtf/rtfclass.php');
        $objFile = new \File($fileModel->path);

        ob_start();

        $objReader = new \rtf($objFile->getContent());
        $objReader->output('html');
        $objReader->parse();

        $strBuffer = ob_get_clean();

        if (!strlen($strBuffer))
            return false;

        return $strBuffer;
    }


    /**
     * {@inheritdoc}
     */
    public function setIndexData($data)
    {
        return $data;
    }
}
