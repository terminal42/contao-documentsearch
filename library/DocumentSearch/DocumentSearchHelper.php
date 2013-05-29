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

namespace DocumentSearch;

class DocumentSearchHelper extends \Frontend
{

    /**
     * Add documents to the indexer
     * Basically, this is the same as getSearchablePages, but we need this special hook to disable certain document elements
     */
    public function getSearchableDocuments($arrPages, $intRoot=0)
    {
        // Do not add documents to XML sitemap
        if ($intRoot > 0) {

            return $arrPages;
        }

        $strDomain = \Environment::get('base');

        // Try to find any available root page with a domain, doesn't matter which one we use
        $objDomain = \Database::getInstance()->prepare("SELECT dns FROM tl_page WHERE type='root' AND dns!=''")->limit(1)->execute();

        if ($objDomain->numRows) {
            $strDomain = (\Environment::get('ssl') ? 'https://' : 'http://') . $objDomain->dns . '/';
        }

        foreach ($GLOBALS['TL_DOCUMENT_SEARCH']['sources'] as $sourceClass) {
            $source = new $sourceClass();

            if ((!$source instanceof SourceInterface) || !$source->isEnabled()) {
                continue;
            }

            $arrPages = array_merge($arrPages, $source->collectFileURIs($strDomain));
        }

        return $arrPages;
    }
}