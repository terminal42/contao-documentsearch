<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * TYPOlight webCMS
 * Copyright (C) 2005-2009 Leo Feyer
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 2.1 of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 * 
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at http://www.gnu.org/licenses/.
 *
 * PHP version 5
 * @copyright  Andreas Schempp 2009
 * @author     Andreas Schempp <andreas@schempp.ch>
 * @license    http://opensource.org/licenses/lgpl-3.0.html
 * @version    $Id$
 */


/**
 * Hooks
 */
$GLOBALS['TL_HOOKS']['getSearchablePages'][]				= array('DocumentSearch', 'getSearchableDocuments');
$GLOBALS['TL_HOOKS']['getSearchableDocuments']['download']	= array('DocumentSearch', 'getDownloadElements');
$GLOBALS['TL_HOOKS']['getSearchableDocuments']['news']		= array('DocumentSearch', 'getNewsEnclosures');
$GLOBALS['TL_HOOKS']['getSearchableDocuments']['calendar']	= array('DocumentSearch', 'getCalendarEnclosures');


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

