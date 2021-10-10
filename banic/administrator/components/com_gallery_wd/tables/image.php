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


class gallery_wdTableImage extends JTable
{
	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 */
	 var $id = null;
	 var $gallery_id = null;
	 var $slug = null;
	 var $filename = null;
	 var $image_url = null;
	 var $thumb_url = null;
	 var $description = null;
	 var $alt = null;
	 var $date = null;
	 var $size = null;
	 var $filetype = null;
	 var $resolution = null;
	 var $author = null;
	 var $order = null;
	 var $published = null;
	 var $comment_count = null;

	 
	function __construct(&$db)
	{
		parent::__construct('#__bwg_image', 'id', $db);
	}
}