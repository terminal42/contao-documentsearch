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
$GLOBALS['TL_HOOKS']['getSearchablePages'][]				= array('DocumentSearch', 'getSearchableDocuments');
$GLOBALS['TL_HOOKS']['getSearchableDocuments']['download']	= array('DocumentSearch', 'getDownloadElements');
//$GLOBALS['TL_HOOKS']['getSearchableDocuments']['news']		= array('DocumentSearch', 'getNewsEnclosures');
//$GLOBALS['TL_HOOKS']['getSearchableDocuments']['calendar']	= array('DocumentSearch', 'getCalendarEnclosures');


/**
 * Document Types
 */
$GLOBALS['TL_DOCUMENT_SEARCH']['pdf']	= array('DocumentSearch', 'extractPDF');
$GLOBALS['TL_DOCUMENT_SEARCH']['doc']	= array('DocumentSearch', 'extractDOC');
$GLOBALS['TL_DOCUMENT_SEARCH']['ppt']	= array('DocumentSearch', 'extractPPT');
$GLOBALS['TL_DOCUMENT_SEARCH']['xls']	= array('DocumentSearch', 'extractXLS');
$GLOBALS['TL_DOCUMENT_SEARCH']['rtf']	= array('DocumentSearch', 'extractRTF');
$GLOBALS['TL_DOCUMENT_SEARCH']['html']	= array('DocumentSearch', 'extractFile');
$GLOBALS['TL_DOCUMENT_SEARCH']['htm']	= array('DocumentSearch', 'extractFile');
$GLOBALS['TL_DOCUMENT_SEARCH']['txt']	= array('DocumentSearch', 'extractFile');
$GLOBALS['TL_DOCUMENT_SEARCH']['csv']	= array('DocumentSearch', 'extractFile');

