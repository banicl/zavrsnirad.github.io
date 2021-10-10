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


class gallery_wdViewThemes extends JViewLegacy
{
	/**
	 * HelloWorlds view display method
	 *
	 * @param   string $tpl The name of the template file to parse; automatically searches through the template paths.
	 *
	 * @return  mixed  A string if successful, otherwise a JError object.
	 */
	public function display($tpl = null)
	{
		// Get data from the model
		$model = $this->getModel();
		$input = JFactory::getApplication()->input;
	$document		=JFactory::getDocument();
	JHtml::_('jquery.framework');


		
	switch($input->get('task'))
	{
	case 'add':	
	case 'edit':
	$cid 	= JRequest::getVar('cid', array(0), '', 'array');
	JArrayHelper::toInteger($cid, array(0));
	$id 	= $cid[0];
	$reset=JRequest::getVar('reset');
	$get_row_data=$model->get_row_data($id,$reset);
	$this->assignRef('get_row_data',$get_row_data);
	$this->_layout = 'edit';
	break;
	default:
	$model_data=$model->get_rows_data();
	$this->assignRef('rows_data',$model_data[0]);
	$this->assignRef('page_nav',$model_data[1]);
	$this->assignRef('lists',$model_data[2]);
	$this->_layout = 'display';
	break;
	}
		
		
		$this->addToolBar();
		// Display the template
		parent::display($tpl);
	}

	
	protected function addToolBar()
	{
	
			$input = JFactory::getApplication()->input;

	

	}
	

	
}