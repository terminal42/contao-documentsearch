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
 * @author     Kamil Kuzminski <kamil.kuzminski@codefog.pl>
 */

namespace DocumentSearch\Extractor;

use DocumentSearch\ExtractorInterface;

class Link implements ExtractorInterface
{
    /**
     * {@inheritdoc}
     */
    public function isEnabledForExtension($ext)
    {
        $arrExts = trimsplit(',', $GLOBALS['TL_CONFIG']['searchExtensions']);
        $arrContent = deserialize($GLOBALS['TL_CONFIG']['searchContents'], true);

        return (\Input::get('source') == 'ce_dl' && in_array('link', $arrContent) && in_array($ext, $arrExts));
    }

    /**
     * {@inheritdoc}
     */
    public function extract($fileModel, $pageModel)
    {
        $strContent = '';
        $objContentElements = \Database::getInstance()->prepare("SELECT linkTitle, titleText FROM tl_content WHERE type='download' AND singleSRC=? AND pid IN (SELECT id FROM tl_article WHERE pid=?)")
                                                      ->execute((version_compare(VERSION, '3.2', '<') ? $fileModel->id : $fileModel->uuid), $pageModel->id);

        while ($objContentElements->next())
        {
            $strContent .= ' ' . $objContentElements->linkTitle . ' ' . $objContentElements->titleText;
        }

        return $strContent;
    }
}
