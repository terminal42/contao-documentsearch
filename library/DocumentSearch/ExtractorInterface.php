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

interface ExtractorInterface
{
    /**
     * Check if this extractor is enabled for a given file extension
     *
     * @return boolean
     */
    public function isEnabledForExtension($extension);

    /**
     * Extract the string content from the given file model
     *
     * @param \FilesModel
     * @return string
     */
    public function extract($fileModel);

    /**
     * Normally you won't need this method to do anything but this allows every extractor to modify all the data
     * again before it is actually sent to \Search::indexPage()
     *
     * @param array
     * @return array
     */
    public function setIndexData($arrData);
}