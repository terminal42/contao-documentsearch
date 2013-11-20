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

namespace DocumentSearch\Source;

use DocumentSearch\SourceInterface;

class ContentElement extends \Frontend implements SourceInterface
{
    /**
     * {@inheritdoc}
     */
    public function isEnabled()
    {
        $arrSources = deserialize($GLOBALS['TL_CONFIG']['searchSources'], true);
        return in_array('ce_dl', $arrSources);
    }

    /**
     * {@inheritdoc}
     */
    public function collectFileURIs($domain)
    {
        $arrPages = array();

        // search all content elements "Download" and "Downloads"
        $objElements = \Database::getInstance()->execute("SELECT DISTINCT tl_content.*, tl_page.id AS page_id FROM tl_content, tl_article LEFT JOIN tl_page ON tl_article.pid = tl_page.id WHERE tl_content.pid=tl_article.id AND (tl_content.type='download' OR tl_content.type='downloads')");

        if (!$objElements->numRows) {

            return array();
        }

        while ($objElements->next()) {

            // get root page for the language of the element (needed for titles of downloads)
            $pageModel = \PageModel::findWithDetails($objElements->page_id);
            $language = $pageModel->rootLanguage;

            // index "download" elements
            if ($objElements->type == 'download') {

                $fileModel = \FilesModel::findByPk($objElements->singleSRC);

                if ($fileModel === null) {
                    continue;
                }

                $arrPages[] = $this->generateIndexerUri($domain, $fileModel, $objElements, $language);
            }

            // index "downloads" elements
            else
            {
                $collection = \FilesModel::findMultipleByIds(deserialize($objElements->multiSRC, true));

                if ($collection === null) {
                    continue;
                }

                while ($collection->next()) {

                    $fileModel = $collection->current();

                    // All files from folder
                    if ($fileModel->type == 'folder') {

                        $subCollection = \FilesModel::findMultipleFilesByFolder($fileModel->path);

                        if ($subCollection === null) {
                            continue;
                        }

                        while ($subCollection->next()) {

                            $subFileModel = $subCollection->current();
                            $arrPages[] = $this->generateIndexerUri($domain, $subFileModel, $objElements, $language);
                        }

                        continue;
                    }

                    $arrPages[] = $this->generateIndexerUri($domain, $fileModel, $objElements, $language);
                }
            }
        }

        return $arrPages;
    }


    protected function generateIndexerUri($domain, $fileModel, $contentElement, $language)
    {
        $strUrl = \Controller::generateFrontendUrl(
            \Database::getInstance()->prepare("SELECT * FROM tl_page WHERE id=?")->execute($contentElement->page_id)->row(),
            null,
            $language
        );

        $strUrl .= (strpos($strUrl, '?') !== false) ? '&amp;' : '?' . 'file=' . \System::urlEncode($fileModel->path);

        $arrMeta = $this->getMetaData($fileModel->meta, $language);
        // Use the file name as title if none is given
        if ($arrMeta['title'] == '')
        {
            $arrMeta['title'] = specialchars(str_replace('_', ' ', preg_replace('/^[0-9]+_/', '', basename($fileModel->path))));
        }

        return $domain . sprintf('system/modules/documentsearch/assets/indexer.php?source=ce_dl&file=%s&pid=%s&url=%s&title=%s%s',
            $fileModel->id,
            $contentElement->page_id,
            $strUrl,
            \System::urlEncode($arrMeta['title']),
            $contentElement->protected ? '&groups=' . $contentElement->groups : '');
    }
}