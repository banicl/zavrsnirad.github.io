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


class gallery_wdViewAlbums extends JViewLegacy
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
	$get_row_data=$model->get_row_data($id);
	$get_albums_galleries_rows_data=$model->get_albums_galleries_rows_data($id);
	$this->assignRef('get_row_data',$get_row_data);
	$this->assignRef('get_albums_galleries_rows_data',$get_albums_galleries_rows_data);


	$this->_layout = 'edit';
	break;
	default:
	$this->delete_unknown_images();
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
$user=JFactory::getUser();

	switch($input->get('task'))
	{
	case 'add':	
	case 'edit':
	JToolBarHelper::title(JText::_('Albums'));
	JToolBarHelper::apply('albums.apply_album');
	JToolBarHelper::save('albums.save_album');
	JToolBarHelper::cancel('albums.cancel');
	break;
	default:
	JToolBarHelper::title(JText::_('Albums'));
	if($user->authorise('core.create', 'com_gallery_wd')) 
	{	
    JToolBarHelper::addNew('albums.add');
	}
	if($user->authorise('core.edit', 'com_gallery_wd')) 
	{		
	JToolBarHelper::editList('albums.edit');
	JToolBarHelper::publish('albums.publish');
	JToolBarHelper::unpublish('albums.unpublish');
	}
	if($user->authorise('core.delete', 'com_gallery_wd')) 
	{		
	JToolBarHelper::deleteList('Are you sure you want to delete this item?','albums.delete');
	}
	JToolBarHelper::custom('albums.save_order', 'save_order', 'extrahello_f2.png', 'Save Order', false);
	
	break;
	
	}

	}
	
public function delete_unknown_images() {
    $db =JFactory::getDBO();
    $db->setQuery('DELETE FROM #__bwg_image WHERE gallery_id=0');
	$db->query();
  }
	/**
	 * Setting the toolbar
	 */
	
}