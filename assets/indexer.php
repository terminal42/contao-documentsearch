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
 * Initialize the system
 */
define('TL_MODE', 'FE');
require('../../../initialize.php');


class DocumentIndexer extends \Frontend
{
    /**
     * Initialize the object
     */
    public function __construct()
    {
        // Load user object before calling the parent constructor
        $this->import('FrontendUser', 'User');
        parent::__construct();

        // Check whether a user is logged in
        define('BE_USER_LOGGED_IN', $this->getLoginStatus('BE_USER_AUTH'));
        define('FE_USER_LOGGED_IN', $this->getLoginStatus('FE_USER_AUTH'));
    }


    /**
     * Run the indexer
     */
    public function run()
    {
        $pageModel = \PageModel::findWithDetails(\Input::get('pid'));

        // Index page if searching is allowed and there is no back end user
        if ($GLOBALS['TL_CONFIG']['enableSearch'] && $pageModel->type == 'regular' && !BE_USER_LOGGED_IN && !$pageModel->noSearch) {

            // Index protected pages if enabled
            if ($GLOBALS['TL_CONFIG']['indexProtected'] || (!FE_USER_LOGGED_IN && !$pageModel->protected)) {

                // search file
                $fileModel = \FilesModel::findByPk(\Input::get('file'));
                $objFile = new \File($fileModel->path);

                // Loop over extractors
                foreach ($GLOBALS['TL_DOCUMENT_SEARCH']['extractors'] as $extractorClass) {

                    $extractor = new $extractorClass();

                    if ((!$extractor instanceof \DocumentSearch\ExtractorInterface) || !$extractor->isEnabledForExtension($objFile->extension)) {
                        continue;
                    }

                    // Title
                    if (\Input::get('title') !== '') {
                        $strTitle = \Input::get('title');
                    } elseif ($pageModel->pageTitle !== '') {
                        $strTitle = $pageModel->pageTitle;
                    } else {
                        $strTitle = $pageModel->title;
                    }

                    $arrData = array
                    (
                        'url'           => \Input::get('url'),
                        'title'         => $strTitle,
                        'protected'     => (\Input::get('groups') ? '1' : ($pageModel->protected ? '1' : '')),
                        'groups'        => (\Input::get('groups') ? deserialize(rawurldecode(\Input::get('groups'))) : $pageModel->groups),
                        'pid'           => $pageModel->id,
                        'filesize'      => number_format(($objFile->filesize/1024), 2, '.', ''),
                        'language'      => $pageModel->rootLanguage,
                        'content'       => $extractor->extract($fileModel)
                    );

                    $extractor->setIndexData($arrData);

                    \Search::indexPage($arrData);
                }
            }
        }
    }
}


/**
 * Instantiate indexer
 */
$objIndexer = new DocumentIndexer();
$objIndexer->run();