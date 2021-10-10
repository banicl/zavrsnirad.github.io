<?php

/*
 * @version		$Id: import.php 1.2.7 06-08-2018 $
 * @package		Yendif Video Share
 * @copyright   Copyright (C) 2014-2018 Yendif Technologies (P) Ltd
 * @license     GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

class YendifVideoShareControllerImport extends YendifVideoShareController {

	public function import() {
	
		$model = $this->getModel( 'import' );
		
	    $view = $this->getView( 'import', 'html' );       		
        $view->setModel( $model, true );		
		$view->setLayout( 'default' );
		$view->display();
		
	}
	
	public function saveApiKey() {
	
		YendifVideoShareUtils::checkToken();
		
		$model = $this->getModel('import');
	  	$model->saveApiKey();
		
	}
	
	public function insertVideos() {
	
		$app = JFactory::getApplication();
		
		$videos = $app->input->get( 'ids', array(0), 'ARRAY' );
		$ids    = array();
		$titles = array();
		
		if( count( $videos ) > 0 ) {
		
			foreach( $videos as $video ) {
				$infos    = explode( "@", $video );
				$ids[]    = $infos[0];
				$titles[] = $infos[1];
			}
			
			$model = $this->getModel( 'import' );		
			$model->insertVideos( $ids, $titles );
			
		} else {
		
			echo "Please select atleast one video.";
			
		}
		exit();
		
	}
		
}