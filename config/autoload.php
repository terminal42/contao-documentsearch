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
 * @author     Kamil Kuzminski <kamil.kuzminski@codefog.pl>
 */

/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
    'DocumentSearch\DocumentSearchHelper'              => 'system/modules/documentsearch/library/DocumentSearch/DocumentSearchHelper.php',
    'DocumentSearch\ExtractorInterface'                => 'system/modules/documentsearch/library/DocumentSearch/ExtractorInterface.php',
    'DocumentSearch\SourceInterface'                   => 'system/modules/documentsearch/library/DocumentSearch/SourceInterface.php',
    'DocumentSearch\Extractor\Doc'                     => 'system/modules/documentsearch/library/DocumentSearch/Extractor/Doc.php',
    'DocumentSearch\Extractor\Pdf'                     => 'system/modules/documentsearch/library/DocumentSearch/Extractor/Pdf.php',
    'DocumentSearch\Extractor\Ppt'                     => 'system/modules/documentsearch/library/DocumentSearch/Extractor/Ppt.php',
    'DocumentSearch\Extractor\Rtf'                     => 'system/modules/documentsearch/library/DocumentSearch/Extractor/Rtf.php',
    'DocumentSearch\Extractor\Text'                    => 'system/modules/documentsearch/library/DocumentSearch/Extractor/Text.php',
    'DocumentSearch\Extractor\Title'                   => 'system/modules/documentsearch/library/DocumentSearch/Extractor/Title.php',
    'DocumentSearch\Extractor\Xls'                     => 'system/modules/documentsearch/library/DocumentSearch/Extractor/Xls.php',
    'DocumentSearch\Extractor\Keywords'                => 'system/modules/documentsearch/library/DocumentSearch/Extractor/Keywords.php',
    'DocumentSearch\Source\ContentElement'             => 'system/modules/documentsearch/library/DocumentSearch/Source/ContentElement.php'
));