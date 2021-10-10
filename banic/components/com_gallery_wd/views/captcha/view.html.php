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


class gallery_wdViewcaptcha extends JViewLegacy
{
	// Overwriting JView display method
	function display($tpl = null) 
	{
		// Assign data to the view
	 $bwg=0;

			$model = $this->getModel();
			
			
			$this->bwg_captcha=$model->bwg_captcha();


			
			
		// Display the view
		parent::display($tpl);
	}
	
	
	

	
	
}
