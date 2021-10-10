<?php
 /**
 * @package Gallery WD Lite
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/
 
defined('_JEXEC') or die('Restricted access');

// import Joomla controller library
jimport('joomla.application.component.controller');


class gallery_wdController extends JControllerLegacy
{
	/**
	 * display task
	 *
	 * @return void
	 */
	function display($cachable = false, $urlparams = array())
	{
		// set default view if not set
		$input = JFactory::getApplication()->input;
		$input->set('view', $input->get('view', 'galleries'));

		parent::display();
	}
	


	
}