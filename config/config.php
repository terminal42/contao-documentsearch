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


/**
 * Hooks
 */
$GLOBALS['TL_HOOKS']['getSearchablePages'][]    = array('DocumentSearch\\DocumentSearchHelper', 'getSearchableDocuments');

/**
 * Sources
 */
$GLOBALS['TL_DOCUMENT_SEARCH']['sources'] = array (
    'DocumentSearch\\Source\\ContentElement'
);

/**
 * Extractors
 */
$GLOBALS['TL_DOCUMENT_SEARCH']['extractors'] = array (
    'DocumentSearch\\Extractor\\Doc',
    'DocumentSearch\\Extractor\\Pdf',
    'DocumentSearch\\Extractor\\Ppt',
    'DocumentSearch\\Extractor\\Rtf',
    'DocumentSearch\\Extractor\\Text',
    'DocumentSearch\\Extractor\\Xls'
);