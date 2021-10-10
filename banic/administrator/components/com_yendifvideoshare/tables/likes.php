<?php

/*
 * @version		$Id: videos.php 1.2.7 06-08-2018 $
 * @package		Yendif Video Share
 * @copyright   Copyright (C) 2014-2018 Yendif Technologies (P) Ltd
 * @license     GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

class YendifVideoShareTableLikesDislikes extends JTable {

	var $id        = null;
  	var $videoid   = null;
  	var $userid    = null;
	var $sessionid = null;
	var $likes     = null;
  	var $dislikes  = null;  	 	

	public function __construct( &$db ) {
		parent::__construct( '#__yendifvideoshare_likes_dislikes', 'id', $db );
	}

	public function check() {
		return true;
	}
	
}