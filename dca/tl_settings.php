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
$GLOBALS['TL_DCA']['tl_settings']['palettes']['default'] = str_replace('indexProtected', 'indexProtected,searchExtensions,searchSources,searchContents,searchToolPDF,searchToolDOC,searchToolPPT', $GLOBALS['TL_DCA']['tl_settings']['palettes']['default']);


/**
 * Fields
 */
$GLOBALS['TL_DCA']['tl_settings']['fields']['searchExtensions'] = array
(
	'label'			=> &$GLOBALS['TL_LANG']['tl_settings']['searchExtensions'],
	'default'		=> 'pdf,dot,doc,docx,ppt,pptx,xls,xlsx,rtf,html,htm,txt,csv,jpg,jpeg,gif,png',
	'inputType'		=> 'text',
	'eval'			=> array('tl_class'=>'clr long'),
);

$GLOBALS['TL_DCA']['tl_settings']['fields']['searchSources'] = array
(
	'label'			=> &$GLOBALS['TL_LANG']['tl_settings']['searchSources'],
	'inputType'		=> 'checkbox',
	'options'		=> array('ce_dl'),
	'reference'		=> &$GLOBALS['TL_LANG']['tl_settings']['searchSources'],
	'eval'			=> array('multiple'=>true, 'tl_class'=>'clr w50" style="height:auto'),
);

$GLOBALS['TL_DCA']['tl_settings']['fields']['searchContents'] = array
(
	'label'			=> &$GLOBALS['TL_LANG']['tl_settings']['searchContents'],
	'inputType'		=> 'checkbox',
	'options'		=> array('file', 'keywords', 'title', 'filename', 'link'),
	'reference'		=> &$GLOBALS['TL_LANG']['tl_settings']['searchContents'],
	'eval'			=> array('multiple'=>true, 'tl_class'=>'w50" style="height:auto'),
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

