<?php

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
 * Initialize the system
 */
define('TL_MODE', 'FE');
require('../../initialize.php');


/**
 * Class DocumentIndexer
 *
 * Document indexer class.
 * @copyright  Andreas Schempp 2008
 * @author     Andreas Schempp <andreas@schempp.ch>
 */
class DocumentIndexer extends Frontend
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
		$this->import('Input');
		$objPage = $this->getPageDetails($this->Input->get('pid'));
		
		// Index page if searching is allowed and there is no back end user
		if ($GLOBALS['TL_CONFIG']['enableSearch'] && $objPage->type == 'regular' && !BE_USER_LOGGED_IN && !$objPage->noSearch)
		{
			// Index protected pages if enabled
			if ($GLOBALS['TL_CONFIG']['indexProtected'] || (!FE_USER_LOGGED_IN && !$objPage->protected))
			{
				// import nessesary libraries
				$this->import('Search');
				
				$objFile = new File($this->Input->get('file'));
				
				// $GLOBALS['TL_DOCUMENT_SEARCH'] holds information about indexable extensions
				if (is_array($GLOBALS['TL_DOCUMENT_SEARCH'][$objFile->extension]) && in_array($objFile->extension, deserialize($GLOBALS['TL_CONFIG']['searchExtensions'], true)))
				{
					// prepare the $arrData array. hopefully we get all information from get!
					$arrData = array
					(
						'url'		=> $this->Input->get('url'),
						'title'		=> (strlen($this->Input->get('title')) ? $this->Input->get('title') : (strlen($objPage->pageTitle) ? $objPage->pageTitle : $objPage->title)),
						'protected'	=> ($this->Input->get('groups') ? '1' : ($objPage->protected ? '1' : '')),
						'groups'	=> ($this->Input->get('groups') ? deserialize(rawurldecode($this->Input->get('groups'))) : $objPage->groups),
						'pid'		=> $objPage->id,
						'filesize'	=> $objFile->filesize/1024,
						'language'	=> $objPage->language,
					);
					
					$callback = $GLOBALS['TL_DOCUMENT_SEARCH'][$objFile->extension];
					$this->import($callback[0]);
					$arrData['content'] = $this->$callback[0]->$callback[1]($objFile);
					
					// Extraction failed
					if ($arrData['content'] === false)
					{
						$this->log('Could not index file "'.$this->Input->get('file').'". Reason: Content extraction failed.', 'DocumentIndexer run()', TL_ERROR);
						$this->failed();
					}
					
					// Library "Search" database throws an exception if some fields are missing
					try {
						$this->Search->indexPage($arrData);
					}
					catch (Exception $e) {
						$this->log('Could not index file "'.$this->Input->get('file').'". Reason: Class Search throwed an exception.', 'DocumentIndexer run()', TL_ERROR);
						$this->failed();
					}
		
					$this->success();
				}
				else
				{
					$this->log('Could not index file "'.$this->Input->get('file').'". Reason: Invalid or disabled extension.', 'DocumentIndexer run()', TL_ERROR);
				}
			}
			else
			{
				$this->log('Could not index file "'.$this->Input->get('file').'". Reason: Protected page.', 'DocumentIndexer run()', TL_ERROR);
			}
		}
		else
		{
			if (!$GLOBALS['TL_CONFIG']['enableSearch'])
				$this->log('Could not index file "'.$this->Input->get('file').'". Reason: Search disabled.', 'DocumentIndexer run()', TL_ERROR);
			elseif ($objPage->type != 'regular')
				$this->log('Could not index file "'.$this->Input->get('file').'". Reason: Not a regular page.', 'DocumentIndexer run()', TL_ERROR);
			elseif (BE_USER_LOGGED_IN)
				$this->log('Could not index file "'.$this->Input->get('file').'". Reason: Back end user logged in.', 'DocumentIndexer run()', TL_ERROR);
				
			elseif ($objPage->noSearch)
				$this->log('Could not index file "'.$this->Input->get('file').'". Reason: Page index disabled.', 'DocumentIndexer run()', TL_ERROR);
		}
		
		$this->failed();
	}
	
	
	/**
	 * Output success image and exit
	 */
	private function success()
	{
		header("Content-Type: image/gif");
		readfile(TL_ROOT.'/system/modules/documentsearch/html/success.gif');
		exit;
	}
	
	
	/**
	 * Output failed image and exit
	 */
	private function failed()
	{
		header("Content-Type: image/gif");
		readfile(TL_ROOT.'/system/modules/documentsearch/html/failed.gif');
		exit;
	}
}


/**
 * Instantiate indexer
 */
$objIndexer = new DocumentIndexer();
$objIndexer->run();

