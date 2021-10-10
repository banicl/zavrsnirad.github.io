<?php
 /**
 * @package Gallery WD Lite
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/
 
defined('_JEXEC') or die('Restricted access');

// import Joomla table library
jimport('joomla.database.table');


class gallery_wdTableAlbums extends JTable
{
	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 */
	 var $id = null;
	 var $name = null;
	 var $slug = null;
	 var $description = null;
	 var $preview_image = null;
	 var $random_preview_image = null;
	 var $order = null;
	 var $author = null;
	 var $published = null;
	 
	 
	function __construct(&$db)
	{
		parent::__construct('#__bwg_album', 'id', $db);
	}
}