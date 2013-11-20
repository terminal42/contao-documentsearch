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

class Title implements ExtractorInterface
{
    /**
     * {@inheritdoc}
     */
    public function isEnabledForExtension($ext)
    {
        $arrExts = deserialize($GLOBALS['TL_CONFIG']['searchExtensions'], true);
        return in_array($ext, $arrExts);
    }

    /**
     * {@inheritdoc}
     */
    public function extract($fileModel, $pageModel)
    {
        return '';
    }


    /**
     * {@inheritdoc}
     */
    public function setIndexData($data)
    {
        $objContentElements = \Database::getInstance()->prepare("SELECT * FROM tl_content WHERE type='download' AND pid IN (SELECT id FROM tl_article WHERE pid=?)")
                                                      ->execute($data['pid']);

        while ($objContentElements->next())
        {
            $data['content'] .= ' ' . $objContentElements->linkTitle . ' ' . $objContentElements->titleText;
        }

        $data['content'] = trim($data['content']);
        return $data;
    }
}
