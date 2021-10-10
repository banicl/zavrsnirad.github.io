<?php

/*
 * @version		$Id: videos.php 1.2.7 06-08-2018 $
 * @package		Yendif Video Share
 * @copyright   Copyright (C) 2014-2018 Yendif Technologies (P) Ltd
 * @license     GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
*/

// no direct access
defined('_JEXEC') or die('Restricted access'); 

class YendifVideoShareControllerVideos extends YendifVideoShareController {
	
	public function videos() {
	
	    $document = JFactory::getDocument();
		$vType = $document->getType();
		
	    $model = $this->getModel('videos');			
	    $view = $this->getView('videos', $vType);        	
        $view->setModel($model, true);		
		$view->setLayout('default');
		$view->display();
		
	}
			
}