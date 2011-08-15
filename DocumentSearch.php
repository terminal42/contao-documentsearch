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


class DocumentSearch extends Frontend
{

	/**
	 * Add documents to the indexer
	 * Basically, this is the same as getSearchablePages, but we need this special hook to disable certain document elements
	 */
	public function getSearchableDocuments($arrPages, $intRoot=0)
	{
		// Do not add documents to XML sitemap
		if ($intRoot > 0)
			return $arrPages;
			
		$GLOBALS['TL_CONFIG']['searchDocuments'] = deserialize($GLOBALS['TL_CONFIG']['searchDocuments']);
		
		// HOOK: find documents
		if (array_key_exists('getSearchableDocuments', $GLOBALS['TL_HOOKS']) && 
			is_array($GLOBALS['TL_HOOKS']['getSearchableDocuments']) && 
			is_array($GLOBALS['TL_CONFIG']['searchDocuments']) &&
			count($GLOBALS['TL_CONFIG']['searchDocuments']) > 0)
		{
			foreach ($GLOBALS['TL_HOOKS']['getSearchableDocuments'] as $name => $callback)
			{
				if (!in_array($name, $GLOBALS['TL_CONFIG']['searchDocuments']))
				{
					continue;
				}
				
				$this->import($callback[0]);
				$arrPages = $this->$callback[0]->$callback[1]($arrPages);
			}
		}
			
		return $arrPages;
	}
	
	
	/**
	 * List content element "download" and "downloads" files for indexing
	 */
	public function getDownloadElements($arrPages)
	{
		$this->import('Database');
		$this->import('Session');
		
		// search all content elements "Download" and "Downloads"
		$objElements = $this->Database->prepare("SELECT DISTINCT tl_content.*, tl_page.id AS page_id FROM tl_content, tl_article LEFT JOIN tl_page ON tl_article.pid = tl_page.id WHERE tl_content.pid=tl_article.id AND (tl_content.type=? OR tl_content.type=?)")
									  ->execute('download', 'downloads');
		
		// no elements available		 
		if ($objElements->numRows == 0) 
		{
			return $arrPages;
		}
		
		while( $objElements->next() )
		{
			// index "download" elements
			if ($objElements->type == 'download')
			{
				if (!file_exists(TL_ROOT.'/'.$objElements->singleSRC))
					continue;
					
				$strUrl = preg_replace('@^(index.php/)?([^\?]+)(\?.*)?@i', '$2', $this->generateFrontendUrl($this->Database->prepare("SELECT * FROM tl_page WHERE id=?")->execute($objElements->page_id)->fetchAssoc())). (($GLOBALS['TL_CONFIG']['disableAlias'] && $this->Input->get('id')) ? '&amp;' : '?') . 'file=' . $this->urlEncode($objElements->singleSRC);
				
				if (!strlen($objElements->linkTitle))
				{
					$objElements->linkTitle = basename($objElements->singleSRC);
				}
				
				$arrPages[] = sprintf('system/modules/documentsearch/indexer.php?file=%s&pid=%s&url=%s&title=%s', 
								$this->urlEncode($objElements->singleSRC),
								$objElements->page_id,
								$strUrl,
								$this->urlEncode($objElements->linkTitle),
								$objElements->protected ? '&groups=' . $objElements->groups : '');
			}
			
			// index "downloads" elemens
			else
			{
				$arrDownloads = deserialize($objElements->multiSRC);
				
				$strUrl = preg_replace('@^(index.php/)?([^\?]+)(\?.*)?@i', '$2', $this->generateFrontendUrl($this->Database->prepare("SELECT * FROM tl_page WHERE id=?")->execute($objElements->page_id)->fetchAssoc())). (($GLOBALS['TL_CONFIG']['disableAlias'] && $this->Input->get('id')) ? '&amp;' : '?') . 'file=';
				
				foreach( $arrDownloads as $strFile )
				{
					if (!file_exists(TL_ROOT.'/'.$strFile))
						continue;
						
					// Files in directory
					if (is_dir(TL_ROOT.'/'.$strFile))
					{
						foreach( scan(TL_ROOT.'/'.$strFile) as $strSub )
						{
							if (!is_file(TL_ROOT.'/'.$strFile.'/'.$strSub) || strpos($strFile, '.') === 0)
								continue;
								
							$this->parseMetaFile(dirname($strFile.'/'.$strSub), true);
							$strTitle = strlen($this->arrMeta[basename($strSub)][0]) ? $this->arrMeta[basename($strSub)][0] : specialchars(basename($strSub));
						
							$arrPages[] = sprintf('system/modules/documentsearch/indexer.php?file=%s&pid=%s&url=%s&title=%s', 
											$this->urlEncode($strFile.'/'.$strSub),
											$objElements->page_id,
											$strUrl . $this->urlEncode($strFile.'/'.$strSub),
											$this->urlEncode($strTitle),
											$objElements->protected ? '&groups=' . $objElements->groups : '');
						}
						
						continue;
					}
						
					$this->parseMetaFile(dirname($strFile), true);
					$strTitle = strlen($this->arrMeta[basename($strFile)][0]) ? $this->arrMeta[basename($strFile)][0] : specialchars(basename($strFile));
				
					$arrPages[] = sprintf('system/modules/documentsearch/indexer.php?file=%s&pid=%s&url=%s&title=%s', 
									$this->urlEncode($strFile),
									$objElements->page_id,
									$strUrl . $this->urlEncode($strFile),
									$this->urlEncode($strTitle),
									$objElements->protected ? '&groups=' . $objElements->groups : '');
				}
			}
		}
		
		return $arrPages;
	}
	
	
	/**
	 * List news enclosures for indexing
	 */
	public function getNewsEnclosures($arrPages)
	{
		return $arrPages;
	}
	 
	 
	/**
	 * List calendar enclosures for indexing
	 */
	public function getCalendarEnclosures($arrPages)
	{
		return $arrPages;
	}
	
	
	/**
	* return the file content
	* @param object
	* @return string
	*/
	public function extractFile($objFile)
	{
		return $objFile->getContent();
	}
	
	
	/**
	* Convert a PDF file and return it as text/string
	* @param object
	* @return string
	*/
	public function extractPDF($objFile)
	{
		$strTempFile = TL_ROOT.'/system/tmp/'.md5(print_r($objFile, true));
		
		if (!file_exists($strTempFile))
		{
//			$strCommand = '"'.TL_ROOT.'/system/modules/documentsearch/tools/pdf/pdftotext" "'.$objFile->dirname.'/'.$objFile->basename.'" "'.$strTempFile.'"';
			$strCommand = 'pdftotext "'.$objFile->dirname.'/'.$objFile->basename.'" "'.$strTempFile.'"';

			system($strCommand, $returnCode);
			
			if ($returnCode != 0)
				return false;
		}

		$strContent = file_get_contents($strTempFile);
		unlink($strTempFile);
		return $strContent;
	}
	
	
	/**
	* Convert a .doc (Word) file and return it as text/string
	* @param object
	* @return string
	*/
	public function extractDOC($objFile)
	{
		$arrContent = array();
		$strCommand = 'catdoc "'.$objFile->dirname.'/'.$objFile->basename.'"';
		
		exec($strCommand, $arrContent, $returnCode);
		
		if ($returnCode != 0)
			return false;

		return implode("\n", $arrContent);
	}
	
	
	/**
	* Convert a .ppt (PowerPoint) file and return it as text/string
	* @param object
	* @return string
	*/
	public function extractPPT($objFile)
	{
		$arrContent = array();
		$strCommand = 'ppthtml "'.$objFile->dirname.'/'.$objFile->basename.'"';
		
		exec($strCommand, $arrContent, $returnCode);
		
		if ($returnCode != 0)
			return false;
			
		// remove unnessessary parts (html header, file name, pptHtml notice, html footer)
		unset($arrContent[count($arrContent)-1]);
		unset($arrContent[count($arrContent)-1]);
		unset($arrContent[0]);
		unset($arrContent[1]);

		return strip_tags(implode("\n", $arrContent));
	}
	
	
	/**
	* Convert an .xls (Excel) file and return it as text/string
	* @param object
	* @return string
	*/
	public function extractXLS($objFile)
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
	
	
	/**
	* Convert a .rtf (Rich-Text Format) file and return it as text/string
	* @param object
	* @return string
	*/
	public function extractRTF($objFile)
	{
		require_once('tools/rtf/rtfclass.php');
		
		ob_start();
		
		$objReader = new rft($objFile->getContent());
		$objReader->output('html');
		$objReader->parse();
		
		$strBuffer = ob_get_clean();
		
		if (!strlen($strBuffer))
			return false;
		
		return $strBuffer;
	}
}

