<?php

/*
 * @version		$Id: controller.php 1.2.7 06-08-2018 $
 * @package		Yendif Video Share
 * @copyright   Copyright (C) 2014-2018 Yendif Technologies (P) Ltd
 * @license     GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');

class YendifVideoShareController extends JControllerLegacy {
	
	public function display( $cachable = false, $urlparams = array() ) {
	
    	parent::display( $cachable, $urlparams );
		
    }
			
}