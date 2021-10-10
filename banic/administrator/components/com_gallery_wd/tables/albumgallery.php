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


class gallery_wdTableAlbumgallery extends JTable
{
	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 */
	 var $id = null;
	 var $album_id = null;
	 var $is_album = null;
	 var $alb_gal_id = null;
	 var $order = null;

	 
	 
	function __construct(&$db)
	{
		parent::__construct('#__bwg_album_gallery', 'id', $db);
	}
}