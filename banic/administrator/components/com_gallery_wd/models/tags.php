<?php
 /**
 * @package Gallery WD Lite
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/
 
defined('_JEXEC') or die('Restricted access');
// import the Joomla modellist library
jimport('joomla.application.component.modellist');

class gallery_wdModelTags extends JModelLegacy
{
	/**
	 * Method to build an SQL query to load the list data.
	 *
	 * @return      string  An SQL query
	 */


	
	 public function get_rows_data() {
	$db =JFactory::getDBO();
	
			$mainframe = JFactory::getApplication();;
			$option=JRequest::getVar('option');
	$view=JRequest::getVar('view');	

	
	$filter_order= $mainframe-> getUserStateFromRequest( $option.$view.'filter_order', 'filter_order','id','cmd' );
	//$filter_order='id';
	$filter_order_Dir= $mainframe-> getUserStateFromRequest( $option.$view.'filter_order_Dir', 'filter_order_Dir','desc','word' );
	$search = $mainframe-> getUserStateFromRequest( $option.$view.'search', 'search','','string' );
	$search = JString::strtolower( $search );
	$limit= $mainframe-> getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
	$limitstart= $mainframe-> getUserStateFromRequest($option.$view.'.limitstart', 'limitstart', 0, 'int');
	$where = array();
  
   	if ( $search ) {
		$where[] = 'name LIKE "%'.$db->escape($search).'%"';
	}
	
		$where 		= ( count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '' );
	
	if ($filter_order == 'id'){
		$orderby 	= ' ORDER BY id '.$filter_order_Dir;
	} else {
		$orderby 	= ' ORDER BY '. 
         $filter_order .' '. $filter_order_Dir .', id';
	}	
	

	
	
		
    $query ="SELECT count(*) FROM #__bwg_tags" . $where ; 
	$db->setQuery($query);
	$total = $db->loadResult();
	jimport('joomla.html.pagination');
	$pageNav = new JPagination( $total, $limitstart, $limit );	

	
    $query ="SELECT * FROM #__bwg_tags" . $where . $orderby; 
	$db->setQuery($query, $pageNav->limitstart, $pageNav->limit);
    $rows = $db->loadObjectList();
	
		$lists['order_Dir']	= $filter_order_Dir;
	$lists['order']		= $filter_order;
		
	// search filter	
    $lists['search']= $search;	
	
	
   return array($rows,$pageNav,$lists);
  }

  

  
  
}