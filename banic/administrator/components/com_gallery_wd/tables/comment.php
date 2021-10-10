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


class gallery_wdTableComment extends JTable
{
	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 */
	 var $id = null;
	 var $image_id = null;
	 var $name = null;
	 var $date = null;
	 var $comment = null;
	 var $url = null;
	 var $mail= null;
	 var $published = null;
	 var $user_id = null;
		 
	 
	function __construct(&$db)
	{
		parent::__construct('#__bwg_image_comment', 'id', $db);
	}
}