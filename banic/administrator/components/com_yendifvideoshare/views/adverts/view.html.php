<?php

/*
 * @version		$Id: view.html.php 1.2.7 06-08-2018 $
 * @package		Yendif Video Share
 * @copyright   Copyright (C) 2014-2018 Yendif Technologies (P) Ltd
 * @license     GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

class YendifVideoShareViewAdverts extends YendifVideoShareView {

    public function display( $tpl = null ) {
	
		$app = JFactory::getApplication();
		
		$option = $app->input->get('option');
		$view = $app->input->get('view');
		
	    $model = $this->getModel();
		
		$limit = $app->getUserStateFromRequest('global.list.limit', 'limit', $app->getCfg('list_limit'), 'int');
		$limitstart = $app->getUserStateFromRequest($option.$view.'.limitstart', 'limitstart', 0, 'int');
		$this->limitstart = ($limit != 0 ? (floor($limitstart / $limit) * $limit) : 0);
		
		$this->items = $model->getItems();
		$this->pagination = $model->getPagination();
		$this->lists = $model->getLists();
		$this->config = YendifVideoShareUtils::getConfig();
		
		JToolBarHelper::title(JText::_('YENDIF_VIDEO_SHARE'), 'yendifvideoshare');
		JToolBarHelper::publishList('publish', JText::_('YENDIF_VIDEO_SHARE_PUBLISH'));
        JToolBarHelper::unpublishList('unpublish', JText::_('YENDIF_VIDEO_SHARE_UNPUBLISH'));
        JToolBarHelper::deleteList(JText::_('YENDIF_VIDEO_SHARE_ARE_YOU_SURE_WANT_TO_DELETE_SELECTED_ITEMS'), 'delete', JText::_('YENDIF_VIDEO_SHARE_DELETE'));
        JToolBarHelper::editList('edit', JText::_('YENDIF_VIDEO_SHARE_EDIT'));
        JToolBarHelper::addNew('add', JText::_('YENDIF_VIDEO_SHARE_NEW'));
				
		YendifVideoShareUtils::addSubMenu('videos');
		
        parent::display($tpl);
		
    }
	
	public function add( $tpl = null ) {
	
		$model = $this->getModel();
		
		$this->config = YendifVideoShareUtils::getConfig();
		
		JToolBarHelper::title(JText::_('YENDIF_VIDEO_SHARE_ADD_NEW_ADVERT'), 'yendifvideoshare');
		JToolBarHelper::apply('apply', JText::_('YENDIF_VIDEO_SHARE_APPLY'));
		JToolBarHelper::save('save', JText::_('YENDIF_VIDEO_SHARE_SAVE'));
		JToolBarHelper::save2new('save2new', JText::_('YENDIF_VIDEO_SHARE_SAVE_AND_NEW'));
        JToolBarHelper::cancel('cancel', JText::_('YENDIF_VIDEO_SHARE_CANCEL'));
		
        parent::display($tpl);
		
    }
	
	public function edit( $tpl = null ) {
	
	    $model = $this->getModel();
		
		$this->item = $model->getItem();
		$this->config = YendifVideoShareUtils::getConfig();
		
		JToolBarHelper::title(JText::_('YENDIF_VIDEO_SHARE_EDIT_ADVERT'), 'yendifvideoshare');
		JToolBarHelper::apply('apply', JText::_('YENDIF_VIDEO_SHARE_APPLY'));
		JToolBarHelper::save('save', JText::_('YENDIF_VIDEO_SHARE_SAVE'));
		JToolBarHelper::save2new('save2new', JText::_('YENDIF_VIDEO_SHARE_SAVE_AND_NEW'));
        JToolBarHelper::cancel('cancel', JText::_('YENDIF_VIDEO_SHARE_CANCEL'));

        parent::display($tpl);
		
    }
	
}