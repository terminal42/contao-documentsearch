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

interface SourceInterface
{
    /**
     * Check if this source is enabled
     *
     * @return boolean
     */
    public function isEnabled();

    /**
     * Collect all file URI's this source provides
     *
     * @param string The domain we are working on
     * @return array
     */
    public function collectFileURIs($domain);
}