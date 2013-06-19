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
 * Palettes
 */
$GLOBALS['TL_DCA']['tl_settings']['palettes']['default'] = str_replace('indexProtected', 'indexProtected,searchExtensions,searchSources,searchToolPDF,searchToolDOC,searchToolPPT', $GLOBALS['TL_DCA']['tl_settings']['palettes']['default']);


/**
 * Fields
 */
$GLOBALS['TL_DCA']['tl_settings']['fields']['searchExtensions'] = array
(
	'label'			=> &$GLOBALS['TL_LANG']['tl_settings']['searchExtensions'],
	'inputType'		=> 'checkbox',
	'options'		=> array('pdf', 'dot', 'doc', 'docx', 'ppt', 'pptx', 'xls', 'xlsx', 'rtf', 'html', 'htm', 'txt', 'csv', 'jpg', 'jpeg', 'gif', 'png'),
    'reference'     => &$GLOBALS['TL_LANG']['tl_settings']['searchExtensions'],
	'eval'			=> array('multiple'=>true, 'tl_class'=>'clr'),
);

$GLOBALS['TL_DCA']['tl_settings']['fields']['searchSources'] = array
(
	'label'			=> &$GLOBALS['TL_LANG']['tl_settings']['searchSources'],
	'inputType'		=> 'checkbox',
	'options'		=> array('ce_dl'),
	'reference'		=> &$GLOBALS['TL_LANG']['tl_settings']['searchSources'],
	'eval'			=> array('multiple'=>true, 'tl_class'=>'clr'),
);

$GLOBALS['TL_DCA']['tl_settings']['fields']['searchToolPDF'] = array
(
	'label'			=> &$GLOBALS['TL_LANG']['tl_settings']['searchToolPDF'],
	'inputType'		=> 'text',
	'eval'			=> array('tl_class'=>'w50'),
);

$GLOBALS['TL_DCA']['tl_settings']['fields']['searchToolDOC'] = array
(
	'label'			=> &$GLOBALS['TL_LANG']['tl_settings']['searchToolDOC'],
	'inputType'		=> 'text',
	'eval'			=> array('tl_class'=>'w50'),
);

$GLOBALS['TL_DCA']['tl_settings']['fields']['searchToolPPT'] = array
(
	'label'			=> &$GLOBALS['TL_LANG']['tl_settings']['searchToolPPT'],
	'inputType'		=> 'text',
	'eval'			=> array('tl_class'=>'w50'),
);

