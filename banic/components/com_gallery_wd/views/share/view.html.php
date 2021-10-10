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


class gallery_wdViewshare extends JViewLegacy
{
	// Overwriting JView display method
	function display($tpl = null) 
	{
		// Assign data to the view


			$model = $this->getModel();
			
			$image_id=JRequest::getVar('image_id',0);
			$this->get_image_row_data=$model->get_image_row_data($image_id);


			
			
		// Display the view
		parent::display($tpl);
	}
	
	
	

	
	
}
