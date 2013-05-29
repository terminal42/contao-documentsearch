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
$GLOBALS['TL_DCA']['tl_files']['palettes']['default'] = str_replace('protected', 'protected,documentsearch_keywords', $GLOBALS['TL_DCA']['tl_files']['palettes']['default']);


/**
 * Fields
 */
$GLOBALS['TL_DCA']['tl_files']['fields']['documentsearch_keywords'] = array
(
    'label'         => &$GLOBALS['TL_LANG']['tl_files']['documentsearch_keywords'],
    'inputType'     => 'text',
    'eval'          => array('tl_class'=>'w50'),
    'sql'           => "varchar(255) NOT NULL default ''"
);