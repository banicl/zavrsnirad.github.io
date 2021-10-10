<?php

/*
 * @version		$Id: config.php 1.2.7 06-08-2018 $
 * @package		Yendif Video Share
 * @copyright   Copyright (C) 2014-2018 Yendif Technologies (P) Ltd
 * @license     GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

class YendifVideoShareModelConfig extends YendifVideoShareModel {
	
	public function getItem() {
	
        $db  = JFactory::getDBO();
		
        $query = "SELECT * FROM #__yendifvideoshare_config WHERE id=1";
        $db->setQuery( $query );
        $item = $db->loadObject();
		 
        return $item;
		
	}
	
	public function save() {
	
	  	$app = JFactory::getApplication();
		
		$cid = $app->input->get('cid', array(0), 'ARRAY');
		$id = $cid[0];
		
	  	$row = JTable::getInstance('Config', 'YendifVideoShareTable');
      	$row->load($id);

		$post = $app->input->post->getArray();
      	if( ! $row->bind( $post ) ) {
			$app->enqueueMessage( $row->getError(), 'error' );
	  	}

		$row->responsive_css = $app->input->post->get( 'responsive_css', '', 'RAW' );
	  	$row->share_script = $app->input->post->get( 'share_script', '', 'RAW' );
		$row->license = $app->input->post->get( 'license', '', 'RAW' );

		if( ! $row->sef_cat ) {
			$row->sef_cat = 'category';
		}
		
		if( ! $row->sef_video_prefix ) {
			$row->sef_video_prefix = 'video';
		}
		
		if( ! $row->feed_limit || $row->feed_limit == 0 ) {
			$row->feed_limit = 5;
		}
		
		$replacement = array('-','/',',','_','|','&',' ');
		$row->sef_cat = str_replace($replacement, "", $row->sef_cat);
		$row->sef_video_prefix = str_replace($replacement, "", $row->sef_video_prefix);
		
	  	if( ! $row->store() ) {
			$app->enqueueMessage( $row->getError(), 'error' );
	  	}

      	$msg = JText::_('YENDIF_VIDEO_SHARE_CHANGES_SAVED');
      	$link = 'index.php?option=com_yendifvideoshare&view=config';
  
	  	$app->redirect($link, $msg, 'message');
		
	}
	
}