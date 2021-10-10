<?php

/*
 * @version		$Id: dashboard.php 1.2.7 06-08-2018 $
 * @package		Yendif Video Share
 * @copyright   Copyright (C) 2014-2018 Yendif Technologies (P) Ltd
 * @license     GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

class YendifVideoShareControllerDashboard extends YendifVideoShareController {

   public function __construct() { 
          
        $this->item_type = 'Default';
        parent::__construct();
		
    }
	
	public function dashboard() {
	
		$model = $this->getModel('dashboard');
		
	    $view = $this->getView('dashboard', 'html');       		
        $view->setModel($model, true);		
		$view->setLayout('default');
		$view->display();
		
	}
		
}