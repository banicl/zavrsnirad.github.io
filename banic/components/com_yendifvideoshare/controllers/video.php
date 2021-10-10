<?php

/*
 * @version		$Id: video.php 1.2.7 06-08-2018 $
 * @package		Yendif Video Share
 * @copyright   Copyright (C) 2014-2018 Yendif Technologies (P) Ltd
 * @license     GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

class YendifVideoShareControllerVideo extends YendifVideoShareController {

	public function video() {
			
	    $model = $this->getModel('video');
		
	    $view = $this->getView('video', 'html');        		
        $view->setModel($model, true);	
		$view->setLayout('default');
		$view->display();
		
	}
			
}