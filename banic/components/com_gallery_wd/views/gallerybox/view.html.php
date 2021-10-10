<?php

 /**
 * @package Gallery WD Lite
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/
 
defined('_JEXEC') or die('Restricted access');

// import Joomla view library
jimport('joomla.application.component.view');

class gallery_wdViewGalleryBox extends JViewLegacy
{
	// Overwriting JView display method
	function display($tpl = null) 
	{
		// Assign data to the view
	

			$model = $this->getModel();

			
			$theme_id=JRequest::getVar('theme_id');
			$gallery_id=JRequest::getVar('gallery_id');
			$sort_by=JRequest::getVar('sort_by');
			$image_id=JRequest::getVar('image_id');
			$tag_id=JRequest::getVar('tag_id',0);

			$this->get_theme_row_data=$model->get_theme_row_data($theme_id);
			$this->get_option_row_data=$model->get_option_row_data();
			$this->get_image_rows_data=$model->get_image_rows_data($gallery_id,$sort_by);
			$this->get_comment_rows_data=$model->get_comment_rows_data($image_id);
			$this->get_image_rows_data_tag=$model->get_image_rows_data_tag($tag_id, $sort_by);
			
			
		// Display the view
		parent::display($tpl);
	}
}
