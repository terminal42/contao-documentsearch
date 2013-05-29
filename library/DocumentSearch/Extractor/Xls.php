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

namespace DocumentSearch\Extractor;

use DocumentSearch\ExtractorInterface;

class Xls implements ExtractorInterface
{
    /**
     * {@inheritdoc}
     */
    public function isEnabledForExtension($ext)
    {
        $arrExts = deserialize($GLOBALS['TL_CONFIG']['searchExtensions'], true);
        return (in_array($ext, array('xls')) && in_array($ext, $arrExts));
    }

    /**
     * {@inheritdoc}
     */
    public function extract($objFile)
    {
        try
        {
            require_once('tools/xls/excel_reader.php');

            $strBuffer = '';

            $objReader = new Spreadsheet_Excel_Reader();
            $objReader->setOutputEncoding('UTF-8');

            $objReader->read($objFile->dirname.'/'.$objFile->basename);

            foreach( $objReader->sheets as $sheet )
            {
                foreach( $sheet['cells'] as $row )
                {
                    foreach( $row as $cell )
                    {
                        $strBuffer .= $cell.';';
                    }

                    $strBuffer .= "\n";
                }

                $strBuffer .= "\n\n\n";
            }
        }
        catch (Exception $e)
        {
            return false;
        }

        return $strBuffer;
    }
}