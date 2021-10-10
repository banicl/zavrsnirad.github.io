<?php
 /**
 * @package Gallery WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/
 
defined('_JEXEC') or die('Restricted access');
// import the Joomla modellist library
jimport('joomla.application.component.modellist');

class gallery_wdModelRates extends JModelLegacy
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
	
	$search_value=JRequest::getVar('search_value');
	$search_select_value=JRequest::getVar('search_select_value');
	$search_select_gal_value=JRequest::getVar('search_select_gal_value');

	$where = array();
  
   	if ( $search_value ) {
		$where[] = 'ip LIKE "%'.$db->escape($search_value).'%"';
	}
	
	
	if($search_select_value)
	{
	$where[] = 't1.image_id='.(int)$search_select_value;
	}
	if($search_select_gal_value)
	{
	$where[] = 't2.gallery_id='.(int)$search_select_gal_value;
	}
	
		$where 		= ( count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '' );
	
	if ($filter_order == 'id'){
		$orderby 	= ' ORDER BY id '.$filter_order_Dir;
	} else {
		$orderby 	= ' ORDER BY '. 
         $filter_order .' '. $filter_order_Dir .', id';
	}	
	

	
	
		
    $query ="SELECT count(*), t2.thumb_url,t2.filetype, t2.alt FROM #__bwg_image_rate as t1 INNER JOIN #__bwg_image as t2 on t1.image_id=t2.id " . $where ; 
	$db->setQuery($query);
	$total = $db->loadResult();
	jimport('joomla.html.pagination');
	$pageNav = new JPagination( $total, $limitstart, $limit );	

	
    $query ="SELECT t1.*, t2.thumb_url,t2.filetype, t2.alt FROM #__bwg_image_rate as t1 INNER JOIN #__bwg_image as t2 on t1.image_id=t2.id " . $where . $orderby; 
	$db->setQuery($query, $pageNav->limitstart, $pageNav->limit);
    $rows = $db->loadObjectList();
	
		$lists['order_Dir']	= $filter_order_Dir;
	$lists['order']		= $filter_order;
		
	// search filter	
    $lists['search']= $search;	
	
	
   return array($rows,$pageNav,$lists);
  }

  
  public function get_galleries() {
   $db=JFactory::getDBO();
    
    $query="SELECT * FROM #__bwg_gallery WHERE published=1";
	$db->setQuery($query);
	$rows_object=$db->loadObjectList();
	$rows[0] = 'Select gallery';
    if ($rows_object) {
      foreach ($rows_object as $row_object) {
        $rows[$row_object->id] = $row_object->name;
      }
    }
    return $rows;
  }
  
    public function get_images($gal_id) {
   $db=JFactory::getDBO();
    $where = ($gal_id ? ' AND gallery_id=' . $gal_id : '');

	
	$query="SELECT * FROM #__bwg_image WHERE published=1" . $where;
	$db->setQuery($query);
	$rows_object=$db->loadObjectList();
	
    $rows[0] = 'All';
    if ($rows_object) {
      foreach ($rows_object as $row_object) {
        $rows[$row_object->id] = $row_object->alt;
      }
    }
    return $rows;
  }
  
}