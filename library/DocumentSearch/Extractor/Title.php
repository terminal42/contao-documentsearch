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
        $arrExts = trimsplit(',', $GLOBALS['TL_CONFIG']['searchExtensions']);
        $arrContent = deserialize($GLOBALS['TL_CONFIG']['searchContents'], true);

        return (in_array('title', $arrContent) && in_array($ext, $arrExts));
    }

    /**
     * {@inheritdoc}
     */
    public function extract($fileModel, $pageModel)
    {
        $arrMeta = $this->getMetaData($fileModel->meta, $pageModel->rootLanguage);

        return (string) $arrMeta['title'];
    }


    /**
     * {@inheritdoc}
     */
    public function setIndexData($data)
    {
        return $data;
    }


    /**
	 * Get the meta data from a serialized string
	 * @param string
	 * @param string
	 * @return array
	 */
	protected function getMetaData($strData, $strLanguage)
	{
		$arrData = deserialize($strData);

		// Convert the language to a locale (see #5678)
		$strLanguage = str_replace('-', '_', $strLanguage);

		if (!is_array($arrData) || !isset($arrData[$strLanguage]))
		{
			return array();
		}

		return $arrData[$strLanguage];
	}
}
