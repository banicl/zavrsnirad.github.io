<?php

/*
 * @version		$Id: config.php 1.2.7 06-08-2018 $
 * @package		Yendif Video Share
 * @copyright   Copyright (C) 2014-2018 Yendif Technologies (P) Ltd
 * @license     GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

class YendifVideoShareControllerConfig extends YendifVideoShareController {

	public function config() {
	
		$model = $this->getModel('config');
		
	    $view = $this->getView('config', 'html');        		
        $view->setModel($model, true);		
		$view->setLayout('default');
		$view->display();
		
	}
	
	public function save() {
	
		YendifVideoShareUtils::checkToken();
		
		$model = $this->getModel('config');
	  	$model->save();
		
	}
		
}